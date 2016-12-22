<?php

namespace Dynamicart\Repository\Console\Commands\Creators;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;

/**
 * Bind an interface to concrete
 *
 * Class BindingCreator
 * @package Dynamicart\Repository\Console\Commands\Creators
 */
class BindingCreator
{
    /**
     * Update existing configuration by adding a new binding
     * @param string $interface
     * @param string $repository
     * @return int
     */
    public function bind($interface, $repository)
    {
        $bindings = "'bindings'=>[" . PHP_EOL;
        foreach (Config::get('repository.bindings') as $key => $value) {
            $bindings .= "      '" . $key . "'=>'" . $value . "'," . PHP_EOL;
        }
        $bindings .= "      '" . $interface . "'=>'" . $repository . "'," . PHP_EOL;
        $bindings .= "    ]";

        $file = new Filesystem();
        $existing = $file->get(config_path('repository.php'));
        $content = preg_replace("/\\'bindings(.*)=>(.*)(\\[)((.|\n)[^\\]]*)(\\])/", $bindings, $existing);
        return $file->put(config_path('repository.php'), $content);
    }
}