<?php

declare(strict_types=1);

namespace App\Listeners;

use App\DownloadTask;
use App\Enums\DownloadTaskStatus;
use App\Events\CreateDownloadTask;
use App\Jobs\DownloadJob;
use Illuminate\Contracts\Bus\Dispatcher;

class DownloadSubscriber
{
    private $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function createDownloadTask(CreateDownloadTask $task)
    {
        $downloadTask = new DownloadTask();
        $downloadTask->url = $task->url;
        $downloadTask->status = DownloadTaskStatus::Pending;
        $downloadTask->save();
    }

    public function dispatch(DownloadTask $task)
    {
        $this->dispatcher->dispatch(new DownloadJob($task));
    }

    public function subscribe($events)
    {
        $events->listen(
            CreateDownloadTask::class,
            self::class.'@createDownloadTask'
        );

        $events->listen(
            'eloquent.created: '.DownloadTask::class,
            self::class.'@dispatch'
        );
    }
}
