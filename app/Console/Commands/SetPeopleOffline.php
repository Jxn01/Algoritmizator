<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

/**
 * Class SetPeopleOffline
 *
 * The SetPeopleOffline class is a console command that sets all users offline whose last_online was more than 30 minutes ago.
 * It extends the base Command class provided by Laravel.
 */
class SetPeopleOffline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-people-offline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set all users offline whose last_online was more than 30 minutes ago';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $users = User::where('last_online', '<', now()->subMinutes(20))
            ->update(['is_online' => false]);
    }
}
