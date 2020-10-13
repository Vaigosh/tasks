<?php

namespace App\Repositories;

use App\Task;

/**
 * Class TaskRepository
 * @package App\Repositories
 * @method Task getModel()
 */
class TaskRepository extends Repository
{
    /**
     * @param $id
     * @return array
     */
    public function getAllTaskForUser($id): array
    {
        $tasks = $this->getModel()
            ->newQuery()
            ->where('user_id', $id)
            ->get()
            ->jsonSerialize(JSON_UNESCAPED_UNICODE);
        return array_values($tasks);
    }

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Task::class;
    }
}
