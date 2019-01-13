<?php

declare(strict_types=1);

namespace App\Services;

use App\DownloaderException;
use App\DownloaderInterface;
use App\DownloadTask;
use Illuminate\Support\Collection;

class DownloadService
{
    /**
     * @var DownloaderInterface
     */
    private $downloader;

    /**
     * @var \SM\Factory\FactoryInterface
     */
    private $stateMachineFacroty;

    /**
     * @var string
     */
    private $path;

    /**
     * DownloadService constructor.
     *
     * @param $path
     * @param DownloaderInterface          $downloader
     * @param \SM\Factory\FactoryInterface $stateMachineFacroty
     */
    public function __construct(
        $path,
        DownloaderInterface $downloader,
        \SM\Factory\FactoryInterface $stateMachineFacroty
    ) {
        $this->downloader = $downloader;
        $this->stateMachineFacroty = $stateMachineFacroty;
        $this->path = $path;
    }

    /**
     * @return DownloadTask[]|Collection
     */
    public function getAll(): Collection
    {
        return DownloadTask::all();
    }

    /**
     * @param DownloadTask $downloadTask
     *
     * @throws \SM\SMException
     */
    public function run(DownloadTask $downloadTask): void
    {
        $stateMachine = $this->stateMachineFacroty->get($downloadTask);

        $stateMachine->apply(\App\Enums\DownloadTaskTransition::Download);
        $downloadTask->save();

        $filePath = $this->path.$downloadTask->id;

        try {
            $filePath = $this->downloader->download($downloadTask->url, $filePath);

            $downloadTask->file_path = $filePath;
            $downloadTask->download_at = new \DateTimeImmutable('now');

            $stateMachine->apply(\App\Enums\DownloadTaskTransition::Successfully);
        } catch (DownloaderException $e) {
            $stateMachine->apply(\App\Enums\DownloadTaskTransition::Failure);
        }

        $downloadTask->save();
    }
}
