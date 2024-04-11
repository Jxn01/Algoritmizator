<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class ListBladeViews extends Command
{

    protected $signature = 'view:list';
    protected $description = 'Lists all Blade view files';

    public function handle()
    {
        $files = File::allFiles(resource_path('views'));

        foreach ($files as $file) {
            if (strpos($file, '.blade.php') !== false) {
                $this->info($file);
            }
        }
    }

}
