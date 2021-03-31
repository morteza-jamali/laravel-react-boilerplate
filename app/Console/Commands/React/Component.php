<?php

namespace App\Console\Commands\React;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Validator;

class Component extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'react:component {operation*} {--P|path=}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'React component tools';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    $operations = $this->argument('operation');
    $path = $this->option('path');

    try {
      $validator = Validator::make([
        'path' => $path
      ], [
        'path' => ['regex:/^[\w\-\_\.]+\.(j|t)s(x)?$/']
      ]);

      if ($validator->validated()) {
        $path = resource_path("views/components/$path");
        $fileSystem = new Filesystem();
        $fileSystem->put($path, Config('react.templates.component'));

        exec("yarn prettier --write $path");
      }
    } catch (Exception $ex) {
      $this->error($ex->getMessage());
    }

    return 0;
  }
}
