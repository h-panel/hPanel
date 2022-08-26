<?php

namespace Pterodactyl\Http\Requests\Api\Application\Nodes;

use Pterodactyl\Models\Node;
use Pterodactyl\Services\Acl\Api\AdminAcl;
use Pterodactyl\Http\Requests\Api\Application\ApplicationApiRequest;

class StoreNodeRequest extends ApplicationApiRequest
{
    /**
     * @var string
     */
    protected $resource = AdminAcl::RESOURCE_NODES;

    /**
     * @var int
     */
    protected $permission = AdminAcl::WRITE;

    /**
     * Validation rules to apply to this request.
     */
    public function rules(array $rules = null): array
    {
        return collect($rules ?? Node::getRules())->only([
            'public',
            'name',
            'location_id',
            'fqdn',
            'scheme',
            'behind_proxy',
            'memory',
            'memory_overallocate',
            'disk',
            'disk_overallocate',
            'upload_size',
            'daemonListen',
            'daemonSFTP',
            'daemonBase',
        ])->mapWithKeys(function ($value, $key) {
            $key = ($key === 'daemonSFTP') ? 'daemonSftp' : $key;

            return [snake_case($key) => $value];
        })->toArray();
    }

    /**
     * Fields to rename for clarity in the API response.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'daemon_base' => 'Daemon Base Path',
            'upload_size' => 'File Upload Size Limit',
            'location_id' => 'Location',
            'public' => 'Node Visibility',
        ];
    }

    /**
     * Change the formatting of some data keys in the validated response data
     * to match what the application expects in the services.
     *
     * @return array
     */
    public function validated()
    {
        $response = parent::validated();
        $response['daemonListen'] = $response['daemon_listen'];
        $response['daemonSFTP'] = $response['daemon_sftp'];
        $response['daemonBase'] = $response['daemon_base'] ?? (new Node())->getAttribute('daemonBase');

        unset($response['daemon_base'], $response['daemon_listen'], $response['daemon_sftp']);

        return $response;
    }
}
