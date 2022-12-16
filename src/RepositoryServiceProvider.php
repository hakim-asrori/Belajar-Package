<?php

namespace Hakimasrori\Repository;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class RepositoryServiceProvider extends ServiceProvider
{
    protected Filesystem $filesystem;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->filesystem = $this->app->make(Filesystem::class);
        if ($this->isConfigPublished()) {
            $this->bindAllRepositories();
        }
    }

    protected function bindAllRepositories()
    {
        $repositoryContracts = $this->getContractPath();
        // $repositoryImplements = $this->getRepositoryPath();

        foreach ($repositoryContracts as $repositoryContract) {
            $repositoryContractClass = config('repository.contract_namespace') . '\\'
                . $repositoryContract . '\\'
                . $repositoryContract
                . config('repository-name.repository_interface_suffix');

            $repositoryImplementClass = config('repository.repository_namespace') . '\\'
                . $repositoryContract . '\\'
                . $repositoryContract
                . config('repository-name.repository_suffix');

            $this->app->bind($repositoryContractClass, $repositoryImplementClass);
        }

        // foreach ($repositoryContracts as $key => $repositoryContract) {
        //     $repositoryContractClass = config('repository.contract_namespace') . '\\'
        //         . $repositoryContract . '\\'
        //         . $repositoryContract
        //         . config('repository-name.repository_interface_suffix');

        //     $repositoryImplementClass = config('repository.repository_namespace') . '\\'
        //         . $repositoryContract . '\\'
        //         . $repositoryContract
        //         . config('repository-name.repository_suffix');

        //     $this->app->bind($repositoryContractClass, $repositoryImplementClass);
        // }
    }

    protected function getContractPath()
    {
        $folders = [];
        if (file_exists($this->app->basePath() . '/' . config('repository.contract_directory'))) {
            $dirs = File::directories($this->app->basePath() . '/' . config('repository.contract_directory'));
            foreach ($dirs as $dir) {
                $dir = str_replace('\\', '/', $dir);
                $arr = explode("/", $dir);

                $folders[] = end($arr);
            }
        }

        return $folders;
    }

    protected function getRepositoryPath()
    {
        $folders = [];
        if (file_exists($this->app->basePath() . '/' . config('repository.repository_directory'))) {
            $dirs = File::directories($this->app->basePath() . '/' . config('repository.repository_directory'));
            foreach ($dirs as $dir) {
                $dir = str_replace('\\', '/', $dir);
                $arr = explode("/", $dir);

                $folders[] = end($arr);
            }
        }

        return $folders;
    }

    protected function isConfigPublished()
    {
        $path = config_path('repository.php');
        $exists = file_exists($path);

        return $exists;
    }
}
