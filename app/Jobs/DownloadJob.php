<?php

declare(strict_types=1);

namespace App\Jobs;

use App\DownloadTask;
use App\Services\DownloadService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DownloadJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * @var DownloadTask
     */
    private $downloadTask;

    /**
     * Create a new job instance.
     *
     * @param DownloadTask $downloadTask
     */
    public function __construct(DownloadTask $downloadTask)
    {
        $this->downloadTask = $downloadTask;
    }

    /**
     * Execute the job.
     *
     * @param DownloadService $service
     */
    public function handle(DownloadService $service)
    {
        $service->run($this->downloadTask);
    }
}
