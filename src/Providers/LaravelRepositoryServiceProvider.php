<?php

namespace Hakimasrori\Repository\Providers;

use Hakimasrori\Repository\Commands\MakeRepositoryCommand;
use Hakimasrori\Repository\Commands\ModelMakeCommand;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelRepositoryServiceProvider extends PackageServiceProvider
{
  public function register()
  {
    $this->registeringPackage();

    $this->package = new Package();
    $this->package->setBasePath($this->getPackageBaseDir());
    $this->configurePackage($this->package);

    if (empty($this->package->name)) {
      throw InvalidPackage::nameIsRequired();
    }

    foreach ($this->package->configFileNames as $configFileName) {
      $this->mergeConfigFrom($this->package->basePath("/../../config/{$configFileName}"), $configFileName);
    }

    $this->mergeConfigFrom(__DIR__ . '/../../config/repository-name.php', 'repository-name');

    $this->packageRegistered();
    $this->overrideCommands();

    return $this;
  }

  public function configurePackage(Package $package): void
  {
    $package
      ->name('laravel-repository')
      ->hasConfigFile()
      ->hasCommand(MakeRepositoryCommand::class);
  }

  public function overrideCommands()
  {
    $this->app->extend('command.model.make', function () {
      return app()->make(ModelMakeCommand::class);
    });
  }
}
