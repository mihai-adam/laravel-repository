<?php

namespace Dynamicart\LaravelRepository\Adapters;

use Dynamicart\LaravelRepository\Contracts\RepositoryCreateContract as Create;
use Dynamicart\LaravelRepository\Contracts\RepositoryReadContract as Read;
use Dynamicart\LaravelRepository\Contracts\RepositoryUpdateContract as Update;
use Dynamicart\LaravelRepository\Contracts\RepositoryDeleteContract as Delete;
use Dynamicart\LaravelRepository\Repository;

/**
 * Eloquent Repository Adapter
 *
 * Class EloquentRepositoryAdapter
 * @package Dynamicart\LaravelRepository\Adapters\Eloquent
 */
abstract class EloquentRepositoryAdapter extends Repository implements Create, Read, Update, Delete
{

    protected $model;

    protected function model()
    {
        if (null == $this->model) {
            $class = $this->getModelClass();
            $this->model = new $class;
        }
        return $this->model;
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model()->select($columns)->find($id);
    }
}