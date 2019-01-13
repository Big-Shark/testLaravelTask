<?php

declare(strict_types=1);

return [
    'download-task' => [
        // class of your domain object
        'class' => App\DownloadTask::class,

        // name of the graph (default is "default")
        'graph' => 'default',

        // property of your object holding the actual state (default is "state")
        'property_path' => 'status',

        // list of all possible states
        'states' => \App\Enums\DownloadTaskStatus::getValues(),

        // list of all possible transitions
        'transitions' => [
            \App\Enums\DownloadTaskTransition::Download => [
                'from' => [\App\Enums\DownloadTaskStatus::Pending],
                'to' => \App\Enums\DownloadTaskStatus::Downloading,
            ],
            \App\Enums\DownloadTaskTransition::Successfully => [
                'from' => [\App\Enums\DownloadTaskStatus::Downloading],
                'to' => \App\Enums\DownloadTaskStatus::Complete,
            ],
            \App\Enums\DownloadTaskTransition::Failure => [
                'from' => [\App\Enums\DownloadTaskStatus::Downloading],
                'to' => \App\Enums\DownloadTaskStatus::Error,
            ],
        ],

        // list of all callbacks
        'callbacks' => [
            // will be called when testing a transition
            'guard' => [],

            // will be called before applying a transition
            'before' => [],

            // will be called after applying a transition
            'after' => [
            //    \App\Enums\DownloadTaskTransition::Download => [
            //        'on' => \App\Enums\DownloadTaskTransition::Download,
            //        'do' => [\App\Services\DownloadService::class, 'run'],
            //        'args' => ['object'],
            //    ],
            ],
        ],
    ],
];
