<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use App\DownloaderException;
use App\DownloaderInterface;
use App\DownloadTask;
use App\Services\DownloadService;
use SM\Factory\FactoryInterface;
use SM\StateMachine\StateMachineInterface;
use Tests\TestCase;

class DownloadServiceTest extends TestCase
{
    public function testRun()
    {
        $url = 'http://127.0.0.1/test.zip';
        $transitions = [
            \App\Enums\DownloadTaskTransition::Download,
            \App\Enums\DownloadTaskTransition::Successfully,
        ];

        $downloader = \Mockery::mock(DownloaderInterface::class);
        $downloader->shouldReceive('download')
            ->once()
            ->with($url, '/tmp/1')
            ->andReturn('/tmp/1.zip');

        $sm = \Mockery::mock(StateMachineInterface::class);
        $sm->shouldReceive('apply')
            ->withArgs(function ($arg) use (&$transitions) {
                $transition = \array_shift($transitions);

                return $arg === $transition;
            });

        $smFactory = \Mockery::mock(FactoryInterface::class);
        $smFactory->shouldReceive('get')
            ->once()
            ->andReturn($sm);

        $service = new DownloadService('/tmp/', $downloader, $smFactory);

        $downloadTask = \Mockery::mock(DownloadTask::class)->makePartial();
        $downloadTask->shouldReceive('save')
            ->twice()
            ->andReturnTrue();

        $downloadTask->id = 1;
        $downloadTask->url = $url;
        $downloadTask->status = \App\Enums\DownloadTaskStatus::Pending;

        $service->run($downloadTask);
    }

    public function testFailRun()
    {
        $url = 'http://127.0.0.1/test.zip';
        $transitions = [
            \App\Enums\DownloadTaskTransition::Download,
            \App\Enums\DownloadTaskTransition::Failure,
        ];

        $downloader = \Mockery::mock(DownloaderInterface::class);
        $downloader->shouldReceive('download')
            ->once()
            ->with($url, '/tmp/1')
            ->andThrowExceptions([new DownloaderException()]);

        $sm = \Mockery::mock(StateMachineInterface::class);
        $sm->shouldReceive('apply')
            ->withArgs(function ($arg) use (&$transitions) {
                $transition = \array_shift($transitions);

                return $arg === $transition;
            });

        $smFactory = \Mockery::mock(FactoryInterface::class);
        $smFactory->shouldReceive('get')
            ->once()
            ->andReturn($sm);

        $service = new DownloadService('/tmp/', $downloader, $smFactory);

        $downloadTask = \Mockery::mock(DownloadTask::class)->makePartial();
        $downloadTask->shouldReceive('save')
            ->twice()
            ->andReturnTrue();

        $downloadTask->id = 1;
        $downloadTask->url = $url;
        $downloadTask->status = \App\Enums\DownloadTaskStatus::Pending;

        $service->run($downloadTask);
    }
}
