<?php

namespace Dynamicart\LaravelRepository\Providers;

use Dynamicart\LaravelRepository\Console\Commands\MakeRepositoryCommand;
use Dynamicart\LaravelRepository\Console\Commands\MakeCriteriaCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

/**
 * Laravel Package ServiceProvider
 *
 * Class RepositoryServiceProvider
 * @package Dynamicart\LaravelRepository\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{


    /**
     * Boot
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->configFile('repository.php') => config_path('repository.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeRepositoryCommand::class,
                MakeCriteriaCommand::class,
            ]);
        }
        $this->mergeConfigFrom(
            $this->configFile('repository.php'), 'repository'
        );

        foreach (Config::get('repository.bindings') as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Register
     * @return void
     */
    public function register()
    {

    }

    /**
     * Get a package config file
     * @param string $file File name
     * @return string
     */
    private function configFile($file)
    {
        return __DIR__ . '/../../config/' . $file;
    }
}