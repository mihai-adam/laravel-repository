<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 1/3/2017
 * Time: 9:55 PM
 */

namespace Dynamicart\LaravelRepository;


/**
 * Class Repository
 * @package Dynamicart\LaravelRepository
 */
abstract class Repository
{

    protected $criteria;

    /**
     * Model class name
     *
     * @return string
     */
    public abstract function getModelClass();

    /**
     * @return Criteria
     */
    public function criteria()
    {
        if (null == $this->criteria) {
            $this->criteria = new Criteria($this);
        }
        return $this->criteria;
    }

}