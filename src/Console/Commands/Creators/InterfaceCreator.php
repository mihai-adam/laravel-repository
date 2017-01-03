<?php

namespace Dynamicart\LaravelRepository\Console\Commands\Creators;

use Illuminate\Support\Facades\Config;
use Dynamicart\LaravelRepository\Exceptions\ModelNotFoundException;
use Dynamicart\LaravelRepository\Exceptions\InterfaceExistsException;

/**
 * Create a new interface file
 *
 * Class InterfaceCreator
 * @package Dynamicart\LaravelRepository\Console\Commands\Creators
 */
class InterfaceCreator extends FileCreator
{
    /**
     * @var
     */
    protected $model;

    /**
     * Full class name prefixed by namespace of the new created file
     * @return string
     */
    public function info()
    {
        return $this->getClassName(Config::get('repository.namespace'), $this->name(), true);
    }

    /**
     * Create a new Interface file
     * @param $model
     * @return $this
     * @throws InterfaceExistsException
     * @throws ModelNotFoundException
     */
    public function create($model)
    {
        if (!$this->classExists(Config::get('repository.model.namespace'), $model)) {
            $message = 'Unable to load model ';
            $message .= $this->getClassName(Config::get('repository.model.namespace'), $model, true) . ' model';
            throw new ModelNotFoundException($message);
        }
        $this->model = $model;
        if ($this->classExists(Config::get('repository.namespace'), $this->name())) {
            $message = 'Repository ' . $this->getClassName(Config::get('repository.namespace'), $this->name(), true);
            $message .= ' already exists';
            throw new InterfaceExistsException($message);
        }
        $this->write('interface');
        return $this;
    }

    /**
     * @return string
     */
    protected function file()
    {
        return $this->getClassName('', $this->name(true));
    }

    /**
     * @return string
     */
    protected function path()
    {
        $ns = $this->getClassNamespace(Config::get('repository.path'), $this->name());
        return str_replace('\\', DIRECTORY_SEPARATOR, $ns);
    }

    /**
     * @return array
     */
    protected function data()
    {
        $namespace = Config::get('repository.namespace');
        return [
            'class' => $this->getClassName($namespace, $this->name()),
            'namespace' => $this->getClassNamespace($namespace, $this->name())
        ];
    }

    /**
     * Get the interface name.
     *
     * @return mixed|string
     */
    protected function name($file = false)
    {
        $name = $this->model;
        if (!strpos($name, 'Repository') !== false) {
            // Append 'Repository' if not.
            $name .= 'Repository';
        }
        return ($file) ? $name . '.php' : $name;
    }
}