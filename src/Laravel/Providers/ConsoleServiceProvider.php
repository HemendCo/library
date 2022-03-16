<?php

namespace Hemend\Library\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

use Hemend\Library\Laravel\Commands\ConfigPublish;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * The available commands
     *
     * @var array
     */
    protected $commands = [
        ConfigPublish::class,
    ];

    /**
     * Register the commands.
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * @return array
     */
    public function provides()
    {
        $provides = $this->commands;

        return $provides;
    }
}
