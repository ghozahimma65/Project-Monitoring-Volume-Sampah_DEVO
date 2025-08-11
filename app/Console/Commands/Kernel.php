<?php
// app/Console/Kernel.php (add to schedule method)

namespace App\Console\Commands;

use App\Http\Middleware\Authenticate;
use Illuminate\Console\Scheduling\Schedule;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Clean up old data daily at 2 AM
        $schedule->command('cleanup:old-data')->dailyAt('02:00');
        
        // Generate daily volume history summary
        $schedule->call(function () {
            // Aggregate hourly data into daily summaries
            // This would be implemented based on specific requirements
        })->daily();
    }
    protected $routeMiddleware = [
    'auth' => Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => RedirectIfAuthenticated::class,
    'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
    'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    
    // TAMBAHKAN LINE INI:
    'admin' => \App\Http\Middleware\AdminAuth::class,
];
}
