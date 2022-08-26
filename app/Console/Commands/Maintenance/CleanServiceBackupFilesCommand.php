<?php

namespace Pterodactyl\Console\Commands\Maintenance;

use SplFileInfo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;

class CleanServiceBackupFilesCommand extends Command
{
    public const BACKUP_THRESHOLD_MINUTES = 5;

    /**
     * @var string
     */
    protected $description = 'Clean orphaned .bak files created when modifying services.';

    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $disk;

    /**
     * @var string
     */
    protected $signature = 'p:maintenance:clean-service-backups';

    /**
     * CleanServiceBackupFilesCommand constructor.
     */
    public function __construct(FilesystemFactory $filesystem)
    {
        parent::__construct();

        $this->disk = $filesystem->disk();
    }

    /**
     * Handle command execution.
     */
    public function handle()
    {
        $files = $this->disk->files('services/.bak');

        collect($files)->each(function (SplFileInfo $file) {
            $lastModified = Carbon::createFromTimestamp($this->disk->lastModified($file->getPath()));
            if ($lastModified->diffInMinutes(Carbon::now()) > self::BACKUP_THRESHOLD_MINUTES) {
                $this->disk->delete($file->getPath());
                $this->info(trans('command/messages.maintenance.deleting_service_backup', ['file' => $file->getFilename()]));
            }
        });
    }
}
