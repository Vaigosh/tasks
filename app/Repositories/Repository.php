<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected $model;

    abstract protected function getModelClass();

    /**
     * @return Model
     */
    protected function getModel()
    {
        if (empty($this->model)) {
            $model = $this->getModelClass();
            $this->model = new $model();
        }

        return $this->model;
    }
}