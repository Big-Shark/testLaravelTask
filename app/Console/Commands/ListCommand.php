<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\DownloadService;
use Illuminate\Console\Command;

class ListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'downloader:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    private $service;

    /**
     * Create a new command instance.
     *
     * @param DownloadService $service
     */
    public function __construct(DownloadService $service)
    {
        $this->service = $service;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $headers = ['Id', 'Url', 'file_path' => 'Path', 'Status', 'Download at', 'Created at', 'Updated at'];
        $downloadTasks = $this->service->getAll()->toArray();

        $this->table($headers, $downloadTasks);
    }
}
