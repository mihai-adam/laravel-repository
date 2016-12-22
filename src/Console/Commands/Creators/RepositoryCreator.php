<?php

namespace Dynamicart\Repository\Console\Commands\Creators;

use Dynamicart\Repository\Exceptions\ModelNotFoundException;
use Dynamicart\Repository\Exceptions\RepositoryExistsException;
use Illuminate\Support\Facades\Config;

/**
 * Create a new repository file
 *
 * Class RepositoryCreator
 * @package Dynamicart\Repository\Console\Commands\Creators
 */
class RepositoryCreator extends FileCreator
{

    /**
     * @var string
     */
    protected $model;

    /**
     * @var InterfaceCreator
     */
    protected $interface;

    /**
     * @param InterfaceCreator $interface
     * @return $this
     */
    public function setInterface(InterfaceCreator $interface)
    {
        $this->interface = $interface;
        return $this;
    }

    /**
     * Full class name prefixed by namespace of the new created file
     * @return string
     */
    public function info()
    {
        return $this->getClassName(Config::get('repository.namespace'), $this->name(false, true), true);
    }

    /**
     * Create new Repository file
     * @param $model
     * @return string
     * @throws ModelNotFoundException
     * @throws RepositoryExistsException
     */
    public function create($model)
    {
        $this->model = $model;
        if ($this->classExists(Config::get('repository.namespace'), $this->name(false, true))) {
            $message = 'Repository ' . $this->getClassName(Config::get('repository.namespace'), $this->name(false, true), true);
            $message .= ' already exists';
            throw new RepositoryExistsException($message);
        }
        $this->write('repository');
        return $this;
    }

    /**
     * @return string
     */
    protected function file()
    {
        return $this->getClassName('', $this->name(true, true));
    }

    /**
     * @return string
     */
    protected function path()
    {
        $ns = $this->getClassNamespace(Config::get('repository.path'), $this->name(false, true));
        return str_replace('\\', DIRECTORY_SEPARATOR, $ns);
    }

    /**
     * @return array
     */
    protected function data()
    {
        $repo = $this->getClassInfo(Config::get('repository.namespace'), $this->name(false, true));
        $model = $this->getClassInfo(Config::get('repository.model.namespace'), $this->model);
        $interface = $this->getClassInfo((''), $this->interface->info());

        return [
            'repoNamespace' => $repo['namespace'],
            'repoClass' => $repo['class'],
            'modelNamespace' => $model['namespace'],
            'modelClass' => $model['class'],
            'interfaceNamespace' => $interface['namespace'],
            'interfaceClass' => $interface['class'],
            'adapter' => ucfirst(Config::get('repository.adapter'))
        ];
    }


    /**
     * Get the repository name.
     * @param bool $file
     * @param bool $adapter
     * @return string
     */
    protected function name($file = false, $adapter = false)
    {
        $name = ($adapter) ? ucfirst(strtolower(Config::get('repository.adapter'))) . '\\' . $this->model : $this->model;

        if (!strpos($name, 'Repository') !== false) {
            // Append 'Repository' if not.
            $name .= 'Repository';
        }
        return ($file) ? $name . '.php' : $name;
    }


}