<?php

namespace Dynamicart\Repository\Console\Commands;

use Illuminate\Console\Command;
use Dynamicart\Repository\Exceptions\RepositoryException;
use Dynamicart\Repository\Providers\RepositoryServiceProvider;
use Dynamicart\Repository\Console\Commands\Creators\BindingCreator;
use Dynamicart\Repository\Console\Commands\Creators\InterfaceCreator;
use Dynamicart\Repository\Console\Commands\Creators\RepositoryCreator;

/**
 * Console command to generate repository for a model
 * Actions:
 *  - A new Interface is created
 *  - A new repository that implements the interface is created
 *  - A new line is created to config file repository.php to create the binding
 *
 * RepositoryServiceProvider will bind based on repository.php
 *
 * Arguments:
 * @string model: Model name relative to value from config file repository.php
 *          Model must be created before, and if not exists an error will be displayed
 *
 * Class MakeRepositoryCommand
 * @package Dynamicart\Repository\Console\Commands
 */
class MakeRepositoryCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * @var RepositoryCreator
     */
    protected $repository;

    /**
     * @var InterfaceCreator
     */
    protected $interface;

    /**
     * @var BindingCreator
     */
    protected $binding;

    /**
     * @var
     */
    protected $composer;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {model}';

    /**
     * MakeRepositoryCommand constructor.
     * @param RepositoryCreator $repository
     * @param InterfaceCreator $interface
     * @param BindingCreator $binding
     */
    public function __construct(RepositoryCreator $repository, InterfaceCreator $interface, BindingCreator $binding)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->interface = $interface;
        $this->binding = $binding;
        $this->composer = app()['composer'];
    }

    /**
     * Command handler
     * @return void
     */
    public function handle()
    {

        if (!file_exists(config_path('repository.php'))) {
            $this->call('vendor:publish', [
                '--provider' => RepositoryServiceProvider::class
            ]);
        }

        try {
            $this->interface->create($this->argument('model'));
            $this->info("Successfully created the interface");

            $this->repository->setInterface($this->interface)
                ->create($this->argument('model'));
            $this->info("Successfully created the repository class");

            if ($this->binding->bind($this->interface->info(), $this->repository->info())) {
                // Information message.
                $this->info("Successfully created the binging");
            }

            $this->composer->dumpAutoloads();
        } catch (RepositoryException $e) {
            $this->error($e->getMessage());
        }
    }

}