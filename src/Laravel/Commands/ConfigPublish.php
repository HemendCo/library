<?php

namespace Hemend\Library\Laravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ConfigPublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:library-config';

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
        $sourceFilePath = __DIR__ . '/../config/config.php';
        $destinationPath = config_path('library.php');

        $success = File::copy($sourceFilePath, $destinationPath);

        if($success) {
            $this->info('Library config file published successfully.');
        } else {
            $this->warn('Error publishing library config file.');
        }
    }
}
