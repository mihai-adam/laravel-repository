<?php

namespace Dynamicart\Repository;

/**
 * Base Repository Class
 *
 * Class Repository
 * @package Dynamicart\Repository
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