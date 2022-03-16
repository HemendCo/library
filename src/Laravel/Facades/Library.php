<?php

namespace Hemend\Library\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class Library extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'library';
    }
}
