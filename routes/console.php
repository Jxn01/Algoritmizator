<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/**
 * Register the "inspire" console command.
 *
 * This command displays an inspiring quote when it is run.
 * It is scheduled to run hourly.
 */
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

/**
 * Schedule the "auth:clear-resets" command.
 *
 * This command clears expired password reset tokens.
 * It is scheduled to run every fifteen minutes.
 */
Schedule::command('auth:clear-resets')->everyFifteenMinutes()->evenInMaintenanceMode();
Schedule::command('app:set-people-offline')->everyMinute()->evenInMaintenanceMode();
