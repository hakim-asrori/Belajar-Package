<?php

namespace Hakimasrori\Repository;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class RepositoryServiceProvider extends ServiceProvider
{
    private Filesystem $filesystem;

    public function register()
    {
        $this->filesystem = app()->make(Filesystem::class);
        if ($this->isConfigPublished()) {
            $this->bindAllRepositories();
        }
    }

    public function boot()
    {
        //
    }

    private function bindAllRepositories()
    {
        $repositoryContracts = glob($this->app->basePath() . "/" . config("repository.contract_directory") . "/*.php");
        $repositoryImplements = glob($this->app->basePath() . "/" . config("repository.repository_directory") . "/*.php");

        foreach ($repositoryContracts as $key => $contract) {
            $this->app->bind(config("repository.contract_namespace") . '\\' . File::name($contract), config("repository.repository_namespace") . '\\' . File::name($repositoryImplements[$key]));
        }
    }

    private function isConfigPublished()
    {
        $path = config_path("repository.php");
        $exists = file_exists($path);

        return $exists;
    }
}
