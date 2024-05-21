<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\Process\Process;

/**
 * Class RunPint
 *
 * The RunPint class is a console command that runs Laravel Pint to fix code style issues.
 * It extends the base Command class provided by Laravel.
 */
class RunPint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:pint';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Laravel Pint to fix code style issues';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Running Laravel Pint...');

        $process = new Process(['./vendor/bin/pint']);
        $process->setTty(Process::isTtySupported());
        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        $this->info('Laravel Pint execution completed.');

        return CommandAlias::SUCCESS;
    }
}
