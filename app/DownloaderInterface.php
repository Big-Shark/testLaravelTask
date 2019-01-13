<?php

declare(strict_types=1);

namespace App;

interface DownloaderInterface
{
    public function download(string $url, $file);
}
