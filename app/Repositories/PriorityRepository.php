<?php

namespace App\Repositories;

use App\Priority;

/**
 * Class PriorityRepository
 *
 * @package App\Repositories
 * @method Priority getModel()
 */
class PriorityRepository extends Repository
{
    /**
     * @return string
     */
    public function getAllJson(): string
    {
        return $this->getModel()
            ->all()
            ->keyBy('id')
            ->toJson();
    }

    protected function getModelClass()
    {
        return Priority::class;
    }
}
