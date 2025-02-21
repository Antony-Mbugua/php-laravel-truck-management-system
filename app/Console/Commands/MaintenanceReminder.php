<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Maintenance;
use Carbon\Carbon;

class MaintenanceReminder extends Command
{
    protected $signature = 'maintenance:reminder';
    protected $description = 'Send reminders for upcoming maintenance';

    public function handle()
    {
        // Get upcoming maintenance (for example, within the next 7 days)
        $upcomingMaintenances = Maintenance::where('scheduled_date', '>=', Carbon::now())
            ->where('scheduled_date', '<=', Carbon::now()->addDays(7))
            ->get();

        if ($upcomingMaintenances->isEmpty()) {
            $this->info('No upcoming maintenance reminders.');
            return;
        }

        foreach ($upcomingMaintenances as $maintenance) {
            $this->info("Reminder: Maintenance for Truck ID {$maintenance->truck_id} is scheduled on {$maintenance->scheduled_date}");
        }

        $this->info('Maintenance reminders sent successfully.');
    }
}
