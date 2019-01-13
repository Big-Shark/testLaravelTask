<?php

declare(strict_types=1);

namespace App;

/**
 * Interface DownloaderInterface.
 */
interface DownloaderInterface
{
    /**
     * @param string $url
     * @param $file
     *
     * @return mixed
     */
    public function download(string $url, $file);
}
