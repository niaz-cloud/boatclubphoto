<?php

// use Illuminate\Support\Facades\Artisan;
// use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment('Stay focused and keep coding!');
// })->purpose('Display an inspiring quote');

// Schedule::command('fees:reminder')
//     ->lastDayOfMonth()
//     ->at('18:00');
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment('Stay focused and keep coding!');
})->purpose('Display an inspiring quote');

Schedule::command('fees:reminder')->everyMinute();
