<?php
// app/Http/Controllers/Api/NotificationController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getCriticalNotifications()
    {
        $notifications = $this->notificationService->getCriticalNotifications();
        
        return response()->json([
            'success' => true,
            'data' => $notifications,
            'count' => count($notifications)
        ]);
    }

    public function getAdminNotifications()
    {
        $notifications = $this->notificationService->getUnreadNotifications('admin');
        
        return response()->json([
            'success' => true,
            'data' => $notifications,
            'count' => count($notifications)
        ]);
    }

    public function markAsRead(Request $request)
    {
        $audience = $request->get('audience', 'public');
        $this->notificationService->markAllAsRead($audience);
        
        return response()->json([
            'success' => true,
            'message' => 'Notifikasi telah ditandai sebagai dibaca'
        ]);
    }
}