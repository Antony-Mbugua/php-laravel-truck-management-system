<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Maintenance;
use App\Models\User;
use App\Console\Commands\Notification;
use App\Console\Commands\MaintenanceReminder;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\MakeFilamentUser::class, // Register the custom Filament user creation command
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Define your scheduled tasks here, if any.
        // Example:
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $maintenances = Maintenance::where('scheduled_date', now()->toDateString())->get();
            foreach ($maintenances as $maintenance) {
                // Send notifications
                $users = User::whereIn('role', ['driver', 'manager', 'dispatcher'])->get();
                Notification::send($users, new MaintenanceReminder());
            }
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected $routeMiddleware = [
        // ...
        'dispatcher' => \App\Http\Middleware\EnsureUserIsDispatcher::class,
        'driver' => \App\Http\Middleware\EnsureUserIsDriver::class,
    ];
    
}
