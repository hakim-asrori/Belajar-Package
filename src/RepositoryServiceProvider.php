<?php

namespace Hakimasrori\Repository;

use Hakimasrori\Repository\Contracts\RepositoryContract;
use Hakimasrori\Repository\Repository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    $this->app->bind(RepositoryContract::class, Repository::class);
  }
}
