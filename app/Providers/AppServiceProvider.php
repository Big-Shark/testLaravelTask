<?php

declare(strict_types=1);

namespace App\Providers;

use App\DownloaderInterface;
use App\Services\DownloadService;
use App\SimpleDownloader;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Mimey\MimeTypes;
use Mimey\MimeTypesInterface;
use SM\Factory\FactoryInterface;
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
        $this->app->singleton(ExtensionGuesserInterface::class, function ($app) {
            return ExtensionGuesser::getInstance();
        });

        $this->app->bind(SimpleDownloader::class, function ($app) {
            return new SimpleDownloader($app->make(Filesystem::class), $app->make(ExtensionGuesserInterface::class));
        });

        //$this->app->bind(MimeTypesInterface::class, MimeTypes::class);

        $this->app->bind(DownloadService::class, function ($app) {
            return new DownloadService(
                '/download-files/',
                $app->make(DownloaderInterface::class),
                $app->make(FactoryInterface::class)
          //      $app->make(MimeTypesInterface::class)
            );
        });
    }
}
