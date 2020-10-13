<?php

namespace App\Services;

use App\Priority;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    /**
     * @param TaskRequest $request
     * @param Task $task
     * @return Task|null
     */
    public function fillingData(TaskRequest $request, Task $task): ?Task
    {
        $task->title = $request->post('title');
        $task->priority_id = $request->post('priority_id');
        $task->status = $request->post('status');
        $task->tags = collect($request->post('tags'))->toJson();
        $task->user_id = Auth::id();
        $task->save();

        return $task;
    }
}
