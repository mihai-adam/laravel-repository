<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 12/22/2016
 * Time: 10:31 PM
 */

namespace Dynamicart\Repository\Contracts;

/**
 * Find Functionality
 *
 * Interface RepositoryFindContract
 * @package Dynamicart\Repository\Contracts
 */
interface RepositoryReadContract
{

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * Find data by id or throw Exception
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     * @throws ResourceNotFoundException
     */
//    public function findOrFail($id, $columns = ['*']);

    /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
//    public function findByField($field, $value, $columns = ['*']);

    /**
     * Find data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
//    public function findWhere(array $where, $columns = ['*']);

    /**
     * Find data by multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
//    public function findWhereIn($field, array $values, $columns = ['*']);

    /**
     * Find data by excluding multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
//    public function findWhereNotIn($field, array $values, $columns = ['*']);

    /**
     * Retrieve data array for populate field select
     *
     * @param string $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     */
//    public function lists($column, $key = null);

    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
//    public function all($columns = ['*']);

    /**
     * Load relations
     *
     * @param $relations
     *
     * @return $this
     */
//    public function with($relations);

    /**
     * Retrieve all data of repository, paginated
     *
     * @param null $limit
     *
     * @return mixed
     */
//    public function paginate($limit = null);

    /**
     * Order collection by a given column
     *
     * @param string $column
     * @param string $direction
     *
     * @return $this
     */
//    public function orderBy($column, $direction = 'asc');

    /**
     * Set hidden fields
     *
     * @param array $fields
     *
     * @return $this
     */
//    public function hidden(array $fields);

    /**
     * Set visible fields
     *
     * @param array $fields
     *
     * @return $this
     */
//    public function visible(array $fields);
}