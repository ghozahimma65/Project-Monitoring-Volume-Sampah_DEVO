<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Mengambil notifikasi terbaru yang belum dibaca oleh admin.
     */
    public function getLatest()
    {
        // Ambil notifikasi yang belum dibaca milik user yang sedang login
        $notifications = auth()->user()->unreadNotifications;
        
        // Kirim sebagai response JSON
        return response()->json($notifications);
    }
}