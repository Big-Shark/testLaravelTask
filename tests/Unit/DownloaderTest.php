<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\SimpleDownloader;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesserInterface;
use Tests\TestCase;

class DownloaderTest extends TestCase
{
    public function testDdownload()
    {
        $filePath = 'downloader_test';
        $filePath = $this->getDownloader()->download('https://picsum.photos/200/300?image=0', $filePath);

        $filesystem = $this->getFilesystem();

        $file = new \SplFileObject($filesystem->path($filePath));
        $this->assertEquals($file->isFile(), true);
        $this->assertEquals($file->getSize(), 9996);
        $filesystem->delete($filePath);
    }

    /**
     * @return FilesystemAdapter
     */
    private function getFilesystem(): FilesystemAdapter
    {
        Storage::persistentFake('test');

        return $this->app->make('filesystem')->drive('test');
    }

    private function getDownloader()
    {
        return new SimpleDownloader($this->getFilesystem(), $this->app->make(ExtensionGuesserInterface::class));
    }
}
