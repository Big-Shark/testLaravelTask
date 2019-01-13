<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DownloadTaskStatus extends Enum
{
    const Pending = 'pending';
    const Downloading = 'downloading';
    const Complete = 'complete';
    const Error = 'error';
}
