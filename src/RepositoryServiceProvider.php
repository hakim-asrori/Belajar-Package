<?php

namespace Hakimasrori\Repository;

use Carbon\Laravel\ServiceProvider;
use Hakimasrori\Repository\Contracts\RepositoryContract;
use Illuminate\Filesystem\Filesystem;

class RepositoryServiceProvider extends ServiceProvider
{
  protected Filesystem $filesystem;

  public function register()
  {
    $this->filesystem = $this->app->make(Filesystem::class);
    if ($this->isConfigPublished()) {
      $this->bindAllRepositories();
    }
  }

  public function boot()
  {
  }

  protected function bindAllRepositories()
  {
    $repositoryContracts = $this->getRepositoryPath();

    foreach ($repositoryContracts as $key => $repositoryContract) {
      $repositoryContractClass = config();
    }
  }

  protected function isConfigPublished()
  {
    $path = config_path("repository.php");
    $exists = file_exists($path);

    return $exists;
  }
}
