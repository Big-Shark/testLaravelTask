<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\CreateDownloadTask;
use App\Http\Requests\CreateDownloadTaskRequest;
use App\Services\DownloadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class WebController extends Controller
{
    public function getTasks(DownloadService $service, Request $request)
    {
        $status = $request->session()->get('status');

        return view('tasks', ['tasks' => $service->getAll(), 'status' => $status]);
    }

    public function createTask(EventDispatcherInterface $eventDispatcher, CreateDownloadTaskRequest $request)
    {
        $eventDispatcher->dispatch(new CreateDownloadTask($request->get('url')));
        $request->session()->flash('status', 'Task created successful!');

        return Redirect::back();
    }
}
