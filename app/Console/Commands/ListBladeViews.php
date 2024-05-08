<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Class ListBladeViews
 *
 * The ListBladeViews class is a console command that lists all Blade view files in the application.
 * It extends the base Command class provided by Laravel.
 */
class ListBladeViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists all Blade view files';

    /**
     * Execute the console command.
     *
     * This method is called when the command is executed.
     * It gets all files in the 'views' directory, and for each file, if the file name contains '.blade.php', it outputs the file name.
     */
    public function handle(): void
    {
        $files = File::allFiles(resource_path('views'));

        foreach ($files as $file) {
            if (str_contains($file, '.blade.php')) {
                $this->info($file);
            }
        }
    }
}
