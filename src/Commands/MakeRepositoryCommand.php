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

        $isContractCreated = $this->createContract($repositoryName);
        if (!$isContractCreated) {
            return;
        }

        $this->createRepository($repositoryName);
    }

    protected function createContract($name)
    {
        if (!File::exists($this->getBaseDirectory("Contracts\\" . $name))) {
            File::makeDirectory($this->getBaseDirectory("Contracts\\" . $name), 0777, true);
        }

        $title = $this->title($name) . config('repository-name.repository_interface_suffix');
        $baseName = $this->getBaseFileName($name) . config('repository-name.repository_interface_suffix');

        $contractPath = config('repository.contract_directory') . '/' . $title;
        $filePath = $contractPath . '.php';
        $contractNamespacePath = $filePath;

        $stubProperties = [
            "{contractName}" => $baseName
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

    protected function createRepository($name)
    {
        if (!File::exists($this->getBaseDirectory($name))) {
            File::makeDirectory($this->getBaseDirectory($name), 0775, true);
        }

        $titleContract = $this->title($name) . config('repository-name.repository_interface_suffix');
        $contract = $this->getBaseFileName($name) . config('repository-name.repository_interface_suffix');

        $contractPath = config('repository.contract_directory') . '/' . $titleContract;
        $contractNamespace = Str::ucfirst($this->getNameSpace($contractPath));

        $title = $this->getBaseFileName($name);
        $titleRepository = $this->title($name) . config("repository-name.repository_suffix");
        $baseName = $this->getBaseFileName($name) . config("repository-name.repository_suffix");

        $repoPath = config('repository.repository_directory') . $titleRepository;
        $filePath = $repoPath . ".php";

        $repositoryNamespacePath = $filePath;

        $stubProperties = [
            "{contractName}" => $contract,
            "{repositoryName}" => $baseName,
            "{model}" => $title,
            "{modelVariable}" => Str::camel($title),
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

    protected function title($name)
    {
        return Str::remove(' ', ucwords(Str::of($name)->replace('_', ' ')));
    }
}
