<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
    use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

//Schedule::command('reservations:send-reminders')->dailyAt('21:08');
Schedule::command('reservations:send-reminders')
    ->everyFiveMinutes();

Schedule::command('app:send-match-reminder')
    ->everyMinute();