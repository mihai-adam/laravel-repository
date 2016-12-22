<?php

namespace Dynamicart\Repository\Adapters;

use Dynamicart\Repository\Contracts\RepositoryCreateContract as Create;
use Dynamicart\Repository\Contracts\RepositoryReadContract as Read;
use Dynamicart\Repository\Contracts\RepositoryUpdateContract as Update;
use Dynamicart\Repository\Contracts\RepositoryDeleteContract as Delete;
use Dynamicart\Repository\Repository;

/**
 * Eloquent Repository Adapter
 *
 * Class EloquentRepositoryAdapter
 * @package Dynamicart\Repository\Adapters\Eloquent
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