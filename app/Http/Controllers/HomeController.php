<?php

namespace App\Http\Controllers;

use App\Repositories\PriorityRepository;
use App\Task;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Выводит страницу задач
     *
     * @param PriorityRepository $priorityRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(PriorityRepository $priorityRepository)
    {
        $params = [
            'priorities' => $priorityRepository->getAllJson(),
            'statuses' => collect(Task::STATUSES)->toJson(JSON_UNESCAPED_UNICODE)
        ];
        return view('home', $params);
    }
}
