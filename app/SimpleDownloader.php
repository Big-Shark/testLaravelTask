<?php

declare(strict_types=1);

namespace App;

use Illuminate\Filesystem\FilesystemAdapter;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesserInterface;

/**
 * Class SimpleDownloader.
 */
class SimpleDownloader implements DownloaderInterface
{
    /**
     * @var FilesystemAdapter
     */
    private $storage;

    /**
     * @var ExtensionGuesserInterface
     */
    private $extensionGuesser;

    /**
     * SimpleDownloader constructor.
     *
     * @param FilesystemAdapter         $storage
     * @param ExtensionGuesserInterface $extensionGuesser
     */
    public function __construct(FilesystemAdapter $storage, ExtensionGuesserInterface $extensionGuesser)
    {
        $this->storage = $storage;
        $this->extensionGuesser = $extensionGuesser;
    }

    /**
     * @param string $url
     * @param $filePath
     *
     * @throws DownloaderException
     * @throws \Illuminate\Contracts\Filesystem\FileExistsException
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     *
     * @return mixed|string
     */
    public function download(string $url, $filePath)
    {
        try {
            $stream = \fopen($url, 'r');
        } catch (\Exception $e) {
            throw new DownloaderException('File not found', 0, $e);
        }

        $filePath = \trim($filePath, '/');
        $result = $this->storage->writeStream($filePath, $stream);
        \fclose($stream);

        if (false === $result) {
            throw new DownloaderException('Failed to save file');
        }

        $ext = $this->extensionGuesser->guess($this->storage->mimeType($filePath));
        $pathWithExt = $filePath.'.'.$ext;
        $this->storage->rename($filePath, $pathWithExt);

        return $pathWithExt;
    }
}
