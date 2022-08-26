<?php

namespace Pterodactyl\Services\Databases;

use Exception;
use InvalidArgumentException;
use Pterodactyl\Models\Server;
use Pterodactyl\Models\Database;
use Pterodactyl\Helpers\Utilities;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Contracts\Encryption\Encrypter;
use Pterodactyl\Extensions\DynamicDatabaseConnection;
use Pterodactyl\Repositories\Eloquent\DatabaseRepository;
use Pterodactyl\Exceptions\Repository\DuplicateDatabaseNameException;
use Pterodactyl\Exceptions\Service\Database\TooManyDatabasesException;
use Pterodactyl\Exceptions\Service\Database\DatabaseClientFeatureNotEnabledException;

class DatabaseManagementService
{
    /**
     * The regex used to validate that the database name passed through to the function is
     * in the expected format.
     *
     * @see \Pterodactyl\Services\Databases\DatabaseManagementService::generateUniqueDatabaseName()
     */
    private const MATCH_NAME_REGEX = '/^(s[\d]+_)(.*)$/';

    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    private $connection;

    /**
     * @var \Pterodactyl\Extensions\DynamicDatabaseConnection
     */
    private $dynamic;

    /**
     * @var \Illuminate\Contracts\Encryption\Encrypter
     */
    private $encrypter;

    /**
     * @var \Pterodactyl\Repositories\Eloquent\DatabaseRepository
     */
    private $repository;

    /**
     * Determines if the service should validate the user's ability to create an additional
     * database for this server. In almost all cases this should be true, but to keep things
     * flexible you can also set it to false and create more databases than the server is
     * allocated.
     *
     * @var bool
     */
    protected $validateDatabaseLimit = true;

    /**
     * CreationService constructor.
     */
    public function __construct(
        ConnectionInterface $connection,
        DynamicDatabaseConnection $dynamic,
        DatabaseRepository $repository,
        Encrypter $encrypter
    ) {
        $this->connection = $connection;
        $this->dynamic = $dynamic;
        $this->encrypter = $encrypter;
        $this->repository = $repository;
    }

    /**
     * Generates a unique database name for the given server. This name should be passed through when
     * calling this handle function for this service, otherwise the database will be created with
     * whatever name is provided.
     */
    public static function generateUniqueDatabaseName(string $name, int $serverId): string
    {
        // Max of 48 characters, including the s123_ that we append to the front.
        return sprintf('s%d_%s', $serverId, substr($name, 0, 48 - strlen("s{$serverId}_")));
    }

    /**
     * Set wether or not this class should validate that the server has enough slots
     * left before creating the new database.
     *
     * @return $this
     */
    public function setValidateDatabaseLimit(bool $validate): self
    {
        $this->validateDatabaseLimit = $validate;

        return $this;
    }

    /**
     * Create a new database that is linked to a specific host.
     *
     * @return \Pterodactyl\Models\Database
     *
     * @throws \Throwable
     * @throws \Pterodactyl\Exceptions\Service\Database\TooManyDatabasesException
     * @throws \Pterodactyl\Exceptions\Service\Database\DatabaseClientFeatureNotEnabledException
     */
    public function create(Server $server, array $data)
    {
        if (!config('pterodactyl.client_features.databases.enabled')) {
            throw new DatabaseClientFeatureNotEnabledException();
        }

        if ($this->validateDatabaseLimit) {
            // If the server has a limit assigned and we've already reached that limit, throw back
            // an exception and kill the process.
            if (!is_null($server->database_limit) && $server->databases()->count() >= $server->database_limit) {
                throw new TooManyDatabasesException();
            }
        }

        // Protect against developer mistakes...
        if (empty($data['database']) || !preg_match(self::MATCH_NAME_REGEX, $data['database'])) {
            throw new InvalidArgumentException('The database name passed to DatabaseManagementService::handle MUST be prefixed with "s{server_id}_".');
        }

        $data = array_merge($data, [
            'server_id' => $server->id,
            'username' => sprintf('u%d_%s', $server->id, str_random(10)),
            'password' => $this->encrypter->encrypt(
                Utilities::randomStringWithSpecialCharacters(24)
            ),
        ]);

        $database = null;

        try {
            return $this->connection->transaction(function () use ($data, &$database) {
                $database = $this->createModel($data);

                $this->dynamic->set('dynamic', $data['database_host_id']);

                $this->repository->createDatabase($database->database);
                $this->repository->createUser(
                    $database->username,
                    $database->remote,
                    $this->encrypter->decrypt($database->password),
                    $database->max_connections
                );
                $this->repository->assignUserToDatabase($database->database, $database->username, $database->remote);
                $this->repository->flush();

                return $database;
            });
        } catch (Exception $exception) {
            try {
                if ($database instanceof Database) {
                    $this->repository->dropDatabase($database->database);
                    $this->repository->dropUser($database->username, $database->remote);
                    $this->repository->flush();
                }
            } catch (Exception $deletionException) {
                // Do nothing here. We've already encountered an issue before this point so no
                // reason to prioritize this error over the initial one.
            }

            throw $exception;
        }
    }

    /**
     * Delete a database from the given host server.
     *
     * @return bool|null
     *
     * @throws \Exception
     */
    public function delete(Database $database)
    {
        $this->dynamic->set('dynamic', $database->database_host_id);

        $this->repository->dropDatabase($database->database);
        $this->repository->dropUser($database->username, $database->remote);
        $this->repository->flush();

        return $database->delete();
    }

    /**
     * Create the database if there is not an identical match in the DB. While you can technically
     * have the same name across multiple hosts, for the sake of keeping this logic easy to understand
     * and avoiding user confusion we will ignore the specific host and just look across all hosts.
     *
     * @throws \Pterodactyl\Exceptions\Repository\DuplicateDatabaseNameException
     * @throws \Throwable
     */
    protected function createModel(array $data): Database
    {
        $exists = Database::query()->where('server_id', $data['server_id'])
            ->where('database', $data['database'])
            ->exists();

        if ($exists) {
            throw new DuplicateDatabaseNameException('A database with that name already exists for this server.');
        }

        $database = (new Database())->forceFill($data);
        $database->saveOrFail();

        return $database;
    }
}
