<?php

declare(strict_types=1);

namespace App\Providers;

use App\DownloaderInterface;
use App\Services\DownloadService;
use App\SimpleDownloader;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesserInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(DownloaderInterface::class, SimpleDownloader::class);
        $this->app->singleton(ExtensionGuesserInterface::class, function (Application $app): ExtensionGuesser {
            return ExtensionGuesser::getInstance();
        });

        $this->app->bind(SimpleDownloader::class, function (Application $app): SimpleDownloader {
            return new SimpleDownloader($app->make(Filesystem::class), $app->make(ExtensionGuesserInterface::class));
        });

        $this->app->when(DownloadService::class)
            ->needs('$path')
            ->give('/public/download-files/');
    }
}
