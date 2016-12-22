<?php

namespace Dynamicart\Repository\Console\Commands\Creators;

use Illuminate\Filesystem\Filesystem;
use Dynamicart\Repository\Exceptions\MakeFileException;
use Dynamicart\Repository\Exceptions\RepositoryException;


/**
 * Abstract class extended by all creators who generate files
 * Contains some basic functionality for generating files from stubs
 *
 * Class FileCreator
 * @package Dynamicart\Repository\Console\Commands\Creators
 */
abstract class FileCreator extends Creator
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Logic for new file
     * @param $model
     * @return mixed
     * @return self
     */
    protected abstract function create($model);

    /**
     * New file name
     * @return string
     */
    protected abstract function file();

    /**
     * New file path
     * @return mixed
     */
    protected abstract function path();

    /**
     * Generate data that will be applied to stub
     * @return mixed
     */
    protected abstract function data();


    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Generate content based on stub and save it to file
     * @param string $stub
     * @return string New file content
     * @throws MakeFileException
     */
    public function write($stub)
    {
        try {
            $path = $this->path();
            $content = $this->content($stub);
            if (!$this->filesystem->isDirectory($path)) {
                $this->filesystem->makeDirectory($path, 0755, true);
            }
            $this->filesystem->put($path . DIRECTORY_SEPARATOR . $this->file(), $content);
            return $content;

        } catch (RepositoryException $e) {
            throw new MakeFileException('Unable to write to ' . $path . DIRECTORY_SEPARATOR . $this->file());
        }
    }

    /**
     * Apply to content to stub variables
     * @param string $name Name of target stub
     * @return string content
     */
    protected function content($name)
    {
        $stub = $this->stub($name);
        foreach ($this->data() as $search => $replace) {
            $stub = str_replace($this->syntax($search), $replace, $stub);
        }
        return $stub;
    }


    /**
     * Read a stub file
     * @param $name
     * @return string
     */
    protected function stub($name)
    {
        $stub = __DIR__ . '/../../../../resources/stubs/' . $name . '.stub';
        return $this->filesystem->get($stub);
    }

    /**
     * Identify stub representation of a variable
     * @param $key
     * @return string
     */
    protected function syntax($key)
    {
        return "<__" . $key . '__>';
    }

}