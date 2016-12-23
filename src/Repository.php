<?php

namespace Dynamicart\LaravelRepository;

/**
 * Base Repository Class
 *
 * Class Repository
 * @package Dynamicart\LaravelRepository
 */
abstract class Repository
{

    /**
     * Model class name
     *
     * @return string
     */
    public abstract function getModelClass();


}