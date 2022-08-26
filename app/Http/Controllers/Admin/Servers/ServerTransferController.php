<?php

namespace Pterodactyl\Http\Controllers\Admin\Servers;

use Illuminate\Http\Request;
use Pterodactyl\Models\Server;
use Prologue\Alerts\AlertsMessageBag;
use Pterodactyl\Models\ServerTransfer;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Services\Servers\TransferService;
use Pterodactyl\Repositories\Eloquent\NodeRepository;
use Pterodactyl\Repositories\Eloquent\ServerRepository;
use Pterodactyl\Repositories\Eloquent\LocationRepository;
use Pterodactyl\Repositories\Wings\DaemonConfigurationRepository;
use Pterodactyl\Contracts\Repository\AllocationRepositoryInterface;

class ServerTransferController extends Controller
{
    /**
     * @var \Prologue\Alerts\AlertsMessageBag
     */
    private $alert;

    /**
     * @var \Pterodactyl\Contracts\Repository\AllocationRepositoryInterface
     */
    private $allocationRepository;

    /**
     * @var \Pterodactyl\Repositories\Eloquent\ServerRepository
     */
    private $repository;

    /**
     * @var \Pterodactyl\Repositories\Eloquent\LocationRepository
     */
    private $locationRepository;

    /**
     * @var \Pterodactyl\Repositories\Eloquent\NodeRepository
     */
    private $nodeRepository;

    /**
     * @var \Pterodactyl\Services\Servers\TransferService
     */
    private $transferService;

    /**
     * @var \Pterodactyl\Repositories\Wings\DaemonConfigurationRepository
     */
    private $daemonConfigurationRepository;

    /**
     * ServerTransferController constructor.
     */
    public function __construct(
        AlertsMessageBag $alert,
        AllocationRepositoryInterface $allocationRepository,
        ServerRepository $repository,
        LocationRepository $locationRepository,
        NodeRepository $nodeRepository,
        TransferService $transferService,
        DaemonConfigurationRepository $daemonConfigurationRepository
    ) {
        $this->alert = $alert;
        $this->allocationRepository = $allocationRepository;
        $this->repository = $repository;
        $this->locationRepository = $locationRepository;
        $this->nodeRepository = $nodeRepository;
        $this->transferService = $transferService;
        $this->daemonConfigurationRepository = $daemonConfigurationRepository;
    }

    /**
     * Starts a transfer of a server to a new node.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Throwable
     */
    public function transfer(Request $request, Server $server)
    {
        $validatedData = $request->validate([
            'node_id' => 'required|exists:nodes,id',
            'allocation_id' => 'required|bail|unique:servers|exists:allocations,id',
            'allocation_additional' => 'nullable',
        ]);

        $node_id = $validatedData['node_id'];
        $allocation_id = intval($validatedData['allocation_id']);
        $additional_allocations = array_map('intval', $validatedData['allocation_additional'] ?? []);

        // Check if the node is viable for the transfer.
        $node = $this->nodeRepository->getNodeWithResourceUsage($node_id);
        if ($node->isViable($server->memory, $server->disk)) {
            // Check if the selected daemon is online.
            $this->daemonConfigurationRepository->setNode($node)->getSystemInformation();

            // Create a new ServerTransfer entry.
            $transfer = new ServerTransfer();

            $transfer->server_id = $server->id;
            $transfer->old_node = $server->node_id;
            $transfer->new_node = $node_id;
            $transfer->old_allocation = $server->allocation_id;
            $transfer->new_allocation = $allocation_id;
            $transfer->old_additional_allocations = $server->allocations->where('id', '!=', $server->allocation_id)->pluck('id');
            $transfer->new_additional_allocations = $additional_allocations;

            $transfer->save();

            // Add the allocations to the server so they cannot be automatically assigned while the transfer is in progress.
            $this->assignAllocationsToServer($server, $node_id, $allocation_id, $additional_allocations);

            // Request an archive from the server's current daemon. (this also checks if the daemon is online)
            $this->transferService->requestArchive($server);

            $this->alert->success(trans('admin/server.alerts.transfer_started'))->flash();
        } else {
            $this->alert->danger(trans('admin/server.alerts.transfer_not_viable'))->flash();
        }

        return redirect()->route('admin.servers.view.manage', $server->id);
    }

    /**
     * Assigns the specified allocations to the specified server.
     */
    private function assignAllocationsToServer(Server $server, int $node_id, int $allocation_id, array $additional_allocations)
    {
        $allocations = $additional_allocations;
        array_push($allocations, $allocation_id);

        $unassigned = $this->allocationRepository->getUnassignedAllocationIds($node_id);

        $updateIds = [];
        foreach ($allocations as $allocation) {
            if (!in_array($allocation, $unassigned)) {
                continue;
            }

            $updateIds[] = $allocation;
        }

        if (!empty($updateIds)) {
            $this->allocationRepository->updateWhereIn('id', $updateIds, ['server_id' => $server->id]);
        }
    }
}
