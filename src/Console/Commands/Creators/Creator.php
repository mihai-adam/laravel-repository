<?php

namespace Dynamicart\Repository\Console\Commands\Creators;

/**
 * Abstract class extended by all creators
 * Contains some basic functionality
 *
 * Class Creator
 * @package Dynamicart\Repository\Console\Commands\Creators
 */
abstract class Creator
{

    /**
     * Get Namespace and Class. Helps when has to apply to a namespace like App\Models
     * a class from a path like User/Posts/Like
     * Example: getClassInfo('App\Models', User/Posts/Like)
     * [
     *      'namespace'=>'App\Models\User\Posts,
     *      'class'=>'Like'
     * ]
     *
     * @param $namespace
     * @param $class
     * @return array
     */
    protected function getClassInfo($namespace, $class)
    {
        $parts = explode('/', implode('/', array_filter([
            str_replace('\\', '/', $namespace),
            str_replace('\\', '/', $class)
        ])));
        $class = $parts[count($parts) - 1];
        unset($parts[count($parts) - 1]);
        return [
            'namespace' => implode('\\', $parts),
            'class' => $class
        ];
    }

    /**
     * Return class name
     *
     * @see Creator::getClassInfo();
     * @param string $namespace Class namespace
     * @param string $class string
     * @param bool $ns If true will prefix with full namespace
     * @return mixed|string
     */
    protected function getClassName($namespace, $class, $ns = false)
    {
        $info = $this->getClassInfo($namespace, $class);
        return ($ns) ? implode('\\', $info) : $info['class'];
    }

    /**
     * Return class namespace only
     *
     * @see Creator::getClassInfo();
     * @param string $namespace Class namespace
     * @param string $class string
     * @param bool $ns If true will prefix with full namespace
     * @return mixed|string
     */
    protected function getClassNamespace($namespace, $class)
    {
        $info = $this->getClassInfo($namespace, $class);
        return $info['namespace'];
    }

    /**
     * Check if a class exists
     *
     * @see Creator::getClassInfo();
     * @param string $namespace Class namespace
     * @param string $class string
     * @return mixed|string
     */
    protected function classExists($namespace, $class)
    {
        return class_exists(implode('\\', $this->getClassInfo($namespace, $class)));
    }
}