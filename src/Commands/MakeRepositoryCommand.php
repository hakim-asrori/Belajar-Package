<?php

namespace Hakimasrori\Repository\Commands;

use Hakimasrori\Repository\CreateFile;
use Hakimasrori\Repository\Traits\NamespaceFixer;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class MakeRepositoryCommand extends Command
{
    use NamespaceFixer;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name : The name of the repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new repository class';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $repositoryName = $this->argument('name');
        if ($repositoryName === '' || is_null($repositoryName) || empty($repositoryName)) {
            $this->error('Name Invalid..!');
        }

        if (!$this->isConfigPublished()) {
            $this->error('Config has not been published yet..!');
            return true;
        }

        $isContractCreated = $this->createContract($repositoryName);
        if (!$isContractCreated) {
            return;
        }

        $this->createRepository($repositoryName);
    }

    public function createContract($name)
    {
        // if (!File::exists($this->getBaseDirectory("Contracts\\" . $name))) {
        //     File::makeDirectory($this->getBaseDirectory("Contracts\\" . $name), 0777, true);
        // }

        $title = $this->title($name) . config('repository-name.repository_interface_suffix');
        $baseName = $this->getBaseFileName($name) . config('repository-name.repository_interface_suffix');

        $contractPath = config('repository.repository_directory') . "/$name/" . $title;
        $filePath = $contractPath . '.php';
        $contractNamespacePath = $filePath;

        $stubProperties = [
            "{contractName}" => $baseName,
            "{nameSpace}" => config('repository.repository_namespace') . "\\$name",
        ];

        if (!File::exists($filePath)) {
            $fileContent = __DIR__ . "/stub/repository-contract.stub";

            new CreateFile($stubProperties, $contractNamespacePath, $fileContent);

            $this->info('Contract Created Successfully.');
            return true;
        } else {
            $this->error('Repository Already Exists.');
            return false;
        }
    }

    public function createRepository($name)
    {
        if (!File::exists($this->getBaseDirectory($name))) {
            File::makeDirectory($this->getBaseDirectory($name), 0775, true);
        }

        $titleContract = $this->title($name) . config('repository-name.repository_interface_suffix');
        $contract = $this->getBaseFileName($name) . config('repository-name.repository_interface_suffix');

        $contractPath = config('repository.repository_directory') . "/$name/" . $titleContract;
        $contractNamespace = Str::ucfirst($this->getNameSpace($contractPath));

        $title = $this->getBaseFileName($name);
        $titleRepository = $this->title($name) . config("repository-name.repository_suffix");
        $baseName = $this->getBaseFileName($name) . config("repository-name.repository_suffix");

        $repoPath = config('repository.repository_directory') . '/$name/' . $titleRepository;
        $filePath = $repoPath . ".php";

        $repositoryNamespacePath = $filePath;

        $stubProperties = [
            "{contractName}" => $contract,
            "{repositoryName}" => $baseName,
            "{nameSpace}" => config('repository.repository_namespace') . "\\$name",
            "{model}" => $title,
            "{modelVariable}" => Str::camel($title),
            "{contractNamespace}" => $contractNamespace,
        ];

        if (!File::exists($filePath)) {
            $fileContent = __DIR__ . "/stub/repository.stub";

            new CreateFile(
                $stubProperties,
                $repositoryNamespacePath,
                $fileContent
            );

            $this->info('Repository Created Successfully.');
            return true;
        } else {
            $this->error('Repository Already Exists.');
            return false;
        }
    }

    public function title($name)
    {
        return Str::remove(' ', ucwords(Str::of($name)->replace('_', ' ')));
    }

    private function isConfigPublished()
    {
        $path = config_path("repository.php");
        $exists = file_exists($path);

        return $exists;
    }
}
