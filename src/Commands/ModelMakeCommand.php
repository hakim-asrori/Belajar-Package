<?php

namespace Hakimasrori\Repository\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand as ConsoleModelMakeCommand;

class ModelMakeCommand extends ConsoleModelMakeCommand
{
  protected $description = 'Create a new Eloquent model class';

  public function handle()
  {
    if (parent::handle() === false && !$this->option('force')) {
      return false;
    }

    if ($this->option('repository')) {
      $this->createRepository();
    }
  }

  public function createRepository()
  {
    $this->call('make:repository', [
      'name' => $this->argument('name'),
    ]);
  }
}
