<?php

namespace Hakimasrori\Repository\Commands;

use Illuminate\Console\Command;

class MakeRepositoryCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'make:repository';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    return Command::SUCCESS;
  }
}
