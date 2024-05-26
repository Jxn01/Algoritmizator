<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/**
 * Registers an artisan command to display an inspiring quote.
 */
Artisan::command('inspire', function () {
    // Display an inspiring quote
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

/**
 * Schedules the command to clear auth resets every fifteen minutes,
 * even during maintenance mode.
 */
Schedule::command('auth:clear-resets')->everyFifteenMinutes()->evenInMaintenanceMode();

/**
 * Schedules the command to set people offline every minute,
 * even during maintenance mode.
 */
Schedule::command('app:set-people-offline')->everyMinute()->evenInMaintenanceMode();
