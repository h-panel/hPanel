<?php

namespace Pterodactyl\Contracts\Repository;

use Pterodactyl\Models\Schedule;
use Illuminate\Support\Collection;

interface ScheduleRepositoryInterface extends RepositoryInterface
{
    /**
     * Return all of the schedules for a given server.
     */
    public function findServerSchedules(int $server): Collection;

    /**
     * Return a schedule model with all of the associated tasks as a relationship.
     *
     * @throws \Pterodactyl\Exceptions\Repository\RecordNotFoundException
     */
    public function getScheduleWithTasks(int $schedule): Schedule;
}
