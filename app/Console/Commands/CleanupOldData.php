<?php
// app/Console/Commands/CleanupOldData.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SensorReading;
use App\Models\VolumeHistory;
use App\Models\Notification;
use Carbon\Carbon;

class CleanupOldData extends Command
{
    protected $signature = 'cleanup:old-data {--days=30}';
    protected $description = 'Clean up old sensor readings and notifications';

    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);

        // Cleanup old sensor readings (keep only last 30 days)
        $deletedReadings = SensorReading::where('reading_time', '<', $cutoffDate)->delete();
        $this->info("Deleted {$deletedReadings} old sensor readings");

        // Cleanup old notifications (keep only last 7 days)
        $notificationCutoff = Carbon::now()->subDays(7);
        $deletedNotifications = Notification::where('created_at', '<', $notificationCutoff)->delete();
        $this->info("Deleted {$deletedNotifications} old notifications");

        $this->info('Cleanup completed successfully!');
    }
}
