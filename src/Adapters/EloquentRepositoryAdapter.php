<?php

namespace Dynamicart\LaravelRepository\Adapters;

use Dynamicart\LaravelRepository\Repository;
use Dynamicart\LaravelRepository\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;


/**
 * Eloquent Repository Adapter
 *
 * Class EloquentRepositoryAdapter
 * @package Dynamicart\LaravelRepository\Adapters\Eloquent
 */
abstract class EloquentRepositoryAdapter extends Repository implements RepositoryInterface
{

    /**
     * @var \Illuminate\Database\Eloquent\Model;
     */
    protected $model;

    /**
     * @return \Illuminate\Database\Eloquent\Model;
     */
    protected function model()
    {
        if (null == $this->model) {
            $class = $this->getModelClass();
            $this->model = new $class;
        }
        return $this->model;
    }


    /**
     * @return $this
     */
    protected function reset()
    {
        $this->model = null;
        return $this;
    }


    /**
     * @param $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($attributes)
    {
        $output = $this->model()->fill($attributes);
        $this->reset();
        return $output;
    }

    /**
     * @param null $limit
     * @return mixed
     */
    public function paginate($limit = null)
    {
        $limit = is_null($limit) ? config('repository.pagination.limit', 8) : $limit;
        $output = $this->model()->paginate($limit);
        $this->reset();
        return $output;
    }

    /**
     * @param null $limit
     * @return mixed
     */
    public function paginateSimple($limit = null)
    {
        $limit = is_null($limit) ? config('repository.pagination.limit', 8) : $limit;
        $output = $this->model()->simplePaginate($limit);
        $this->reset();
        return $output;
    }

    /**
     * @return mixed
     */
    public function collection()
    {
        $output = $this->model()->get();
        $this->reset();
        return $output;
    }

    /**
     * @return mixed
     */
    public function first()
    {
        $output = $this->model->first();
        $this->reset();
        return $output;
    }

    /**
     * @param $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreate($attributes)
    {
        $this->criteria()->apply();
        $output = $this->model()->firstOrCreate($attributes);
        $this->reset();
        return $output;
    }

    /**
     * @return bool|null
     */
    public function delete()
    {
        $output = $this->model()->delete();
        $this->reset();
        return $output;
    }


    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findId($id, $columns = ['*'])
    {
        $this->criteria()->apply();
        $output = $this->model()->find($id, $columns);
        $this->reset();
        return $output;
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findIdOrFail($id, $columns = ['*'])
    {
        $this->criteria()->apply();
        $output = $this->model()->findOrFail($id, $columns);
        $this->reset();
        return $output;
    }


    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findByField($field, $value, $columns = ['*'])
    {
        $this->criteria()->apply();
        $this->model = $this->model()->select($columns)->where($field, '=', $value);
        return $this;
    }

    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*'])
    {
        $this->criteria()->apply();
        $this->model = $this->model()->select($columns);
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($condition, $val) = $value;
                $this->model = $this->model()->where($field, $condition, $val);
            } else {
                $this->model = $this->model()->where($field, '=', $value);
            }
        }
        return $this;
    }

    /**
     * @param $field
     * @param array $values
     * @param array $columns
     * @return mixed
     */
    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        $this->criteria()->apply();
        $this->model = $this->model()->select($columns)->whereIn($field, $values);
        return $this;
    }

    /**
     * @param $field
     * @param array $values
     * @param array $columns
     * @return mixed
     */
    public function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        $this->criteria()->apply();
        $output = $this->model()->whereNotIn($field, $values)->get($columns);
        $this->reset();
        return $output;
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function findAll($columns = ['*'])
    {
        $this->criteria()->apply();
        $this->model = $this->model()->select($columns);
        return $this;
    }

    /**
     * @param $id
     * @param $attributes
     * @return mixed
     */
    public function updateId($id, $attributes)
    {
        return $this->model()->findOrFail($id)->fill($attributes);
    }

    /**
     * @param $field
     * @param null $value
     * @param array $attributes
     * @return mixed
     */
    public function updateByField($field, $value = null, $attributes = [])
    {
        return $this->model()->where($field, '=', $value)->update($attributes);
    }

    /**
     * @param $where
     * @param array $attributes
     * @return bool
     */
    public function updateWhere($where, array $attributes)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($condition, $val) = $value;
                $this->model = $this->model()->where($field, $condition, $val);
            } else {
                $this->model = $this->model()->where($field, '=', $value);
            }
        }
        $output = $this->model()->update($attributes);
        $this->reset();
        return $output;
    }


    /**
     * @param $field
     * @param array $values
     * @param array $attributes
     * @return mixed
     */
    public function updateWhereIn($field, array $values, array $attributes)
    {
        return $this->model()->whereIn($field, $values)->update($attributes);
    }

    /**
     * @param $field
     * @param array $values
     * @param array $attributes
     * @return mixed
     */
    public function updateWhereNotIn($field, array $values, array $attributes)
    {
        return $this->model()->whereNotIn($field, $values)->update($attributes);
    }


    /**
     * @param array $attributes
     * @return bool
     */
    public function updateAll(array $attributes)
    {
        return $this->model()->update($attributes);
    }


    /**
     * @param $id
     * @return mixed
     */
    public function deleteId($id)
    {
        return $this->findIdOrFail($id, ['id'])->delete();
    }

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function deleteByField($field, $value)
    {
        return $this->findByField($field, $value, ['id'])->delete();
    }

    /**
     * @param $field
     * @param array $values
     * @return mixed
     */
    public function deleteWhereIn($field, array $values)
    {
        return $this->findWhereIn($field, $values, ['id'])->delete();
    }

    /**
     * @param $field
     * @param array $values
     * @return mixed
     */
    public function deleteWhereNotIn($field, array $values)
    {
        return $this->findWhereNotIn($field, $values, ['id'])->delete();
    }

    /**
     * @return mixed
     */
    public function deleteAll()
    {
        return $this->findAll(['id'])->delete();
    }

}