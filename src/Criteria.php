<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 1/3/2017
 * Time: 10:29 PM
 */

namespace Dynamicart\LaravelRepository;

/**
 * Class Criteria
 * @package Dynamicart\LaravelRepository
 */
class Criteria
{
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function apply()
    {

    }

    public function push(CriteriaInterface $criteria)
    {

    }


    public function all()
    {

    }
}