<?php

namespace App\Notifications;

use App\Models\Depo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class DepoCriticalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $depo;

    public function __construct(Depo $depo)
    {
        $this->depo = $depo;
    }

    /**
     * Ubah channel pengiriman menjadi 'database'.
     */
    public function via($notifiable)
    {
        return ['database']; // Ganti dari ['mail'] menjadi ['database']
    }

    /**
     * Tentukan data yang akan disimpan di database.
     */
    public function toArray($notifiable)
    {
        return [
            'depo_id' => $this->depo->id,
            'nama_depo' => $this->depo->nama_depo,
            'pesan' => "Volume di {$this->depo->nama_depo} telah mencapai level kritis!",
            'url' => route('admin.depos.show', $this->depo->id),
        ];
        
    }
    public function getLatest()
{
    $notifications = auth()->user()->unreadNotifications;
    return response()->json($notifications);
}
}