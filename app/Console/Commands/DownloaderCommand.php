<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Events\CreateDownloadTask;
use Illuminate\Console\Command;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DownloaderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'downloader:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Create a new command instance.
     *
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = $this->ask('Write URL please');
        $this->eventDispatcher->dispatch(new CreateDownloadTask($url));
    }
}
