<?php

use App\Services\ReminderService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('reminders:process', function () {
    $service = app(ReminderService::class);
    $count = $service->processDueReminders();
    $this->info("Processed {$count} due reminders.");
})->purpose('Process due memorial reminders');

Schedule::command('reminders:process')->dailyAt('09:00');

Schedule::command('sitemap:generate')->daily();
