<?php
// app/Services/NotificationService.php

namespace App\Services;

use App\Models\Notification;
use App\Models\Depo;
use App\Models\Report;
use App\Events\CriticalVolumeAlert;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function createCriticalVolumeNotification(Depo $depo): void
    {
        // Cek apakah sudah ada notifikasi critical untuk depo ini yang belum dibaca
        $existingNotification = Notification::where('type', 'critical_volume')
            ->where('data->depo_id', $depo->id)
            ->where('is_read', false)
            ->first();

        if ($existingNotification) {
            // Update notifikasi yang sudah ada
            $existingNotification->update([
                'data' => [
                    'depo_id' => $depo->id,
                    'depo_name' => $depo->nama_depo,
                    'location' => $depo->lokasi,
                    'volume_percentage' => (float) $depo->persentase_volume,
                    'status' => 'critical',
                    'message' => "PERINGATAN: Depo {$depo->nama_depo} telah mencapai kapasitas " . number_format($depo->persentase_volume, 1) . "%!"
                ],
                'created_at' => now(),
            ]);
        } else {
            // Buat notifikasi baru
            Notification::create([
                'type' => 'critical_volume',
                'data' => [
                    'depo_id' => $depo->id,
                    'depo_name' => $depo->nama_depo,
                    'location' => $depo->lokasi,
                    'volume_percentage' => (float) $depo->persentase_volume,
                    'status' => 'critical',
                    'message' => "PERINGATAN: Depo {$depo->nama_depo} telah mencapai kapasitas " . number_format($depo->persentase_volume, 1) . "%!"
                ],
                'created_at' => now(),
                'target_audience' => 'public',
            ]);
        }

        // Broadcast event
        try {
            event(new CriticalVolumeAlert($depo));
        } catch (\Exception $e) {
            Log::error('Failed to broadcast critical volume alert: ' . $e->getMessage());
        }
    }

    public function removeCriticalVolumeNotification(int $depoId): void
    {
        // Hapus notifikasi critical untuk depo ini
        Notification::where('type', 'critical_volume')
            ->where('data->depo_id', $depoId)
            ->delete();
    }

    public function getCriticalNotifications(): array
    {
        return Notification::where('type', 'critical_volume')
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'depo' => [
                        'id' => $notification->data['depo_id'],
                        'nama_depo' => $notification->data['depo_name'],
                        'lokasi' => $notification->data['location'],
                        'persentase_volume' => $notification->data['volume_percentage'],
                        'status' => 'critical'
                    ],
                    'message' => $notification->data['message'],
                    'timestamp' => $notification->created_at->toISOString(),
                ];
            })
            ->toArray();
    }

    public function getUnreadNotifications(string $audience = 'admin'): array
    {
        return Notification::unread()
            ->where('target_audience', $audience)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function markAllAsRead(string $audience = 'admin'): void
    {
        Notification::unread()
            ->where('target_audience', $audience)
            ->update(['is_read' => true]);
    }
}