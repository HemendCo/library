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
    }
    
    /**
     * Register the service provider.
     */
    public function register()
    {

    }
}
