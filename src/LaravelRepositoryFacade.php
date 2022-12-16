<?php

namespace Hakimasrori\Repository;

use Illuminate\Support\Facades\Facade;

class LaravelRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-repository';
    }
}
