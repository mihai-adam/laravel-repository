<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 1/3/2017
 * Time: 10:25 PM
 */

namespace Dynamicart\LaravelRepository\Criteria;


interface CriteriaInterface
{

    /**
     * @return mixed
     */
    public function apply();
}