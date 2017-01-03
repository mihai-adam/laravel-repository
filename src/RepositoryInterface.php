<?php

namespace Dynamicart\LaravelRepository;

/**
 * Interface RepositoryInterface
 * @package Dynamicart\LaravelRepository
 */
interface RepositoryInterface
{
    /**
     * @param $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($attributes);

    /**
     * @param null $limit
     * @return mixed
     */
    public function paginate($limit = null);

    /**
     * @param null $limit
     * @return mixed
     */
    public function paginateSimple($limit = null);

    /**
     * @return mixed
     */
    public function collection();

    /**
     * @return mixed
     */
    public function first();

    /**
     * @param $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreate($attributes);

    /**
     * @return bool|null
     */
    public function delete();

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findId($id, $columns = ['*']);

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findIdOrFail($id, $columns = ['*']);

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findByField($field, $value, $columns = ['*']);

    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*']);

    /**
     * @param $field
     * @param array $values
     * @param array $columns
     * @return mixed
     */
    public function findWhereIn($field, array $values, $columns = ['*']);

    /**
     * @param $field
     * @param array $values
     * @param array $columns
     * @return mixed
     */
    public function findWhereNotIn($field, array $values, $columns = ['*']);

    /**
     * @param array $columns
     * @return mixed
     */
    public function findAll($columns = ['*']);

    /**
     * @param $id
     * @param $attributes
     * @return mixed
     */
    public function updateId($id, $attributes);

    /**
     * @param $field
     * @param null $value
     * @param array $attributes
     * @return mixed
     */
    public function updateByField($field, $value = null, $attributes = []);

    /**
     * @param $where
     * @param array $attributes
     * @return bool
     */
    public function updateWhere($where, array $attributes);

    /**
     * @param $field
     * @param array $values
     * @param array $attributes
     * @return mixed
     */
    public function updateWhereIn($field, array $values, array $attributes);

    /**
     * @param $field
     * @param array $values
     * @param array $attributes
     * @return mixed
     */
    public function updateWhereNotIn($field, array $values, array $attributes);

    /**
     * @param array $attributes
     * @return bool
     */
    public function updateAll(array $attributes);

    /**
     * @param $id
     * @return mixed
     */
    public function deleteId($id);

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function deleteByField($field, $value);

    /**
     * @param $field
     * @param array $values
     * @return mixed
     */
    public function deleteWhereIn($field, array $values);

    /**
     * @param $field
     * @param array $values
     * @return mixed
     */
    public function deleteWhereNotIn($field, array $values);

    /**
     * @return mixed
     */
    public function deleteAll();
}