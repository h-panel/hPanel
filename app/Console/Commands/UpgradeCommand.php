<?php

namespace Pterodactyl\Console\Commands;

use Closure;
use Illuminate\Console\Command;
use Pterodactyl\Console\Kernel;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Helper\ProgressBar;

class UpgradeCommand extends Command
{
    protected const DEFAULT_URL = 'https://github.com/h-panel/hpanel/releases/%s/panel.tar.gz';

    /** @var string */
    protected $signature = 'p:upgrade
        {--user= : The user that PHP runs under. All files will be owned by this user.}
        {--group= : The group that PHP runs under. All files will be owned by this group.}
        {--url= : The specific archive to download.}
        {--release= : A specific Pterodactyl version to download from GitHub. Leave blank to use latest.}
        {--skip-download : If set no archive will be downloaded.}';

    /** @var string */
    protected $description = 'Downloads a new archive for hPanel from GitHub and then executes the normal upgrade commands.';

    /**
     * Executes an upgrade command which will run through all of our standard
     * commands for Jexactyl and enable users to basically just download
     * the archive and execute this and be done.
     *
     * This places the application in maintenance mode as well while the commands
     * are being executed.
     *
     * @throws \Exception
     */
    public function handle()
    {
        $this->info('This feature currently does not work. Please manually upgrade using the guide on our docs.');
    }

    protected function withProgress(ProgressBar $bar, Closure $callback)
    {
        $bar->clear();
        $callback();
        $bar->advance();
        $bar->display();
    }

    protected function getUrl(): string
    {
        if ($this->option('url')) {
            return $this->option('url');
        }

        return sprintf(self::DEFAULT_URL, $this->option('release') ? 'download/v' . $this->option('release') : 'latest/download');
    }
}
