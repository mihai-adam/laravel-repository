<?php

namespace Dynamicart\Repository\Console\Commands;

use Illuminate\Console\Command;
use Dynamicart\Repository\Console\Commands\Creators\CriteriaCreator;

/**
 * TODO write this class functionality
 * Console command to generate repository for a criteria
 *
 * Class MakeCriteriaCommand *
 * @package Dynamicart\Repository\Console\Commands
 */
class MakeCriteriaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:criteria';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new criteria class';

    /**
     * @var
     */
    protected $creator;

    /**
     * @var
     */
    protected $composer;

    /**
     * @param CriteriaCreator $creator
     */
    public function __construct(CriteriaCreator $creator)
    {
        parent::__construct();

        // Set the creator.
        $this->creator = $creator;

        // Set the composer.
        $this->composer = app()['composer'];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the arguments.
        $arguments = $this->argument();

        // Get the options.
        $options = $this->option();

        // Write criteria.
        $this->writeCriteria($arguments, $options);
        $criteria = $arguments['criteria'];

        // Set model.
        $model = $options['model'];

        // Create the criteria.
        if ($this->creator->create($this->argument(''), $model)) {
            // Information message.
            $this->info("Succesfully created the criteria class.");
        }

        // Dump autoload.
        $this->composer->dumpAutoloads();
    }

    /**
     * Write the criteria.
     *
     * @param $arguments
     * @param $options
     */
    public function writeCriteria($arguments, $options)
    {
        // Set criteria.

    }


}
