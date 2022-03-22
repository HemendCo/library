<?php

namespace Hemend\Library\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

class LibraryServiceProvider extends ServiceProvider
{
    
    /**
     * Booting the package.
     */
    public function boot()
    {
        $this->app->register(ConsoleServiceProvider::class);

        $configPath = __DIR__ . '/../../../config/config.php';

        $this->mergeConfigFrom($configPath, 'library');

        $this->publishes([
            $configPath => config_path('library.php'),
        ], 'config');
    }
    
    /**
     * Register the service provider.
     */
    public function register()
    {

    }
}
