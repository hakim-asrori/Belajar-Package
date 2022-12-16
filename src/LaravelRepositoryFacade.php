<?php

namespace Hakimasrori\Repository;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hakimasrori\Repository\LaravelRepository
 */
class LaravelRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-repository';
    }
}
