<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DownloadTaskTransition extends Enum
{
    const Download = 'download';
    const Successfully = 'successfully';
    const Failure = 'failure';
}
