<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 12/22/2016
 * Time: 10:36 PM
 */

namespace Dynamicart\Repository\Contracts;


interface RepositoryUpdateContract
{
    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
//    public function update(array $attributes, $id);

    /**
     * Update or Create an entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param array $values
     *
     * @return mixed
     */
//    public function updateOrCreate(array $attributes, array $values = []);


}