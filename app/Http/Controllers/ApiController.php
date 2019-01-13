<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\CreateDownloadTask;
use App\Http\Requests\CreateDownloadTaskRequest;
use App\Services\DownloadService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ApiController extends Controller
{
    public function getTasks(DownloadService $service)
    {
        return JsonResponse::create($service->getAll());
    }

    public function createTask(EventDispatcherInterface $eventDispatcher, CreateDownloadTaskRequest $request)
    {
        $eventDispatcher->dispatch(new CreateDownloadTask($request->get('url')));

        return JsonResponse::create([]);
    }
}
