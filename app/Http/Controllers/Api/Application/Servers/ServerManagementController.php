<?php

namespace Pterodactyl\Http\Controllers\Api\Application\Servers;

use Illuminate\Http\Response;
use Pterodactyl\Models\Server;
use Pterodactyl\Services\Servers\SuspensionService;
use Pterodactyl\Services\Servers\ReinstallServerService;
use Pterodactyl\Http\Requests\Api\Application\Servers\ServerWriteRequest;
use Pterodactyl\Http\Controllers\Api\Application\ApplicationApiController;

class ServerManagementController extends ApplicationApiController
{
    /**
     * @var \Pterodactyl\Services\Servers\ReinstallServerService
     */
    private $reinstallServerService;

    /**
     * @var \Pterodactyl\Services\Servers\SuspensionService
     */
    private $suspensionService;

    /**
     * SuspensionController constructor.
     */
    public function __construct(
        ReinstallServerService $reinstallServerService,
        SuspensionService $suspensionService
    ) {
        parent::__construct();

        $this->reinstallServerService = $reinstallServerService;
        $this->suspensionService = $suspensionService;
    }

    /**
     * Suspend a server on the Panel.
     *
     * @throws \Throwable
     */
    public function suspend(ServerWriteRequest $request, Server $server): Response
    {
        $this->suspensionService->toggle($server, SuspensionService::ACTION_SUSPEND);

        return $this->returnNoContent();
    }

    /**
     * Unsuspend a server on the Panel.
     *
     * @throws \Throwable
     */
    public function unsuspend(ServerWriteRequest $request, Server $server): Response
    {
        $this->suspensionService->toggle($server, SuspensionService::ACTION_UNSUSPEND);

        return $this->returnNoContent();
    }

    /**
     * Mark a server as needing to be reinstalled.
     *
     * @throws \Pterodactyl\Exceptions\DisplayException
     * @throws \Pterodactyl\Exceptions\Model\DataValidationException
     * @throws \Pterodactyl\Exceptions\Repository\RecordNotFoundException
     */
    public function reinstall(ServerWriteRequest $request, Server $server): Response
    {
        $this->reinstallServerService->handle($server);

        return $this->returnNoContent();
    }
}
