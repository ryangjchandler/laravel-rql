<?php

namespace RyanChandler\Rql\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RyanChandler\Rql\Rql
 */
class Rql extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-rql';
    }
}
