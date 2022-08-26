<?php

namespace Pterodactyl\Services\Databases\Hosts;

use Pterodactyl\Exceptions\Service\HasActiveServersException;
use Pterodactyl\Contracts\Repository\DatabaseRepositoryInterface;
use Pterodactyl\Contracts\Repository\DatabaseHostRepositoryInterface;

class HostDeletionService
{
    /**
     * @var \Pterodactyl\Contracts\Repository\DatabaseRepositoryInterface
     */
    private $databaseRepository;

    /**
     * @var \Pterodactyl\Contracts\Repository\DatabaseHostRepositoryInterface
     */
    private $repository;

    /**
     * HostDeletionService constructor.
     */
    public function __construct(
        DatabaseRepositoryInterface $databaseRepository,
        DatabaseHostRepositoryInterface $repository
    ) {
        $this->databaseRepository = $databaseRepository;
        $this->repository = $repository;
    }

    /**
     * Delete a specified host from the Panel if no databases are
     * attached to it.
     *
     * @throws \Pterodactyl\Exceptions\Service\HasActiveServersException
     */
    public function handle(int $host): int
    {
        $count = $this->databaseRepository->findCountWhere([['database_host_id', '=', $host]]);
        if ($count > 0) {
            throw new HasActiveServersException(trans('exceptions.databases.delete_has_databases'));
        }

        return $this->repository->delete($host);
    }
}
