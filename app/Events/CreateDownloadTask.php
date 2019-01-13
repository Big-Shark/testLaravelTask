<?php

declare(strict_types=1);

namespace App\Events;

class CreateDownloadTask
{
    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }
}
