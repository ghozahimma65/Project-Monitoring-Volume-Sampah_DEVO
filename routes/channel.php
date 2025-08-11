<?php
// routes/channels.php
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
*/

// Public channel untuk dashboard umum
Broadcast::channel('public-dashboard', function () {
    return true; // Public access
});

// Public channel untuk critical alerts
Broadcast::channel('critical-alerts', function () {
    return true; // Public access
});

// Private channel untuk admin dashboard
Broadcast::channel('admin-dashboard', function ($user) {
    return $user && $user->isAdmin();
});

// Private channel untuk admin notifications
Broadcast::channel('admin-notifications', function ($user) {
    return $user && $user->isAdmin();
});