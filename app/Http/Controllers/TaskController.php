<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use App\Services\TaskService;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * TaskController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Возвращает все задачи указанного пользователя
     *
     * @param TaskRepository $taskRepository
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function index(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository->getAllTaskForUser(Auth::id());
        return response($tasks, Response::HTTP_OK);
    }

    /**
     * Добавление задачи
     *
     * @param TaskRequest $request
     * @param TaskService $taskService
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function store(TaskRequest $request, TaskService $taskService)
    {
        $task = $taskService->fillingData($request, new Task());

        if (empty($task)) {
            return response(null, Response::HTTP_BAD_GATEWAY);
        }

        return response($task->jsonSerialize(), Response::HTTP_CREATED);
    }

    /**
     * Изменение задачи
     *
     * @param TaskRequest $request
     * @param Task $task
     * @param TaskService $taskService
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function update(TaskRequest $request, Task $task, TaskService $taskService)
    {
        $task = $taskService->fillingData($request, $task);

        if (empty($task)) {
            return response(null, Response::HTTP_BAD_GATEWAY);
        }

        return response($task->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Удаление задачи
     *
     * @param Task $task
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     * @throws \Exception
     */
    public function destroy(Task $task)
    {
        if ($task->user_id != Auth::id()) {
            return response(null, Response::HTTP_BAD_GATEWAY);
        }
        $task->delete();
        return response(null, Response::HTTP_OK);
    }
}
