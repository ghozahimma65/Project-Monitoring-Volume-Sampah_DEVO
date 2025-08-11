<?php

namespace App\Events;

use App\Models\Depo;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CriticalVolumeAlert implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $depo;
    public $message;
    public $timestamp;

    public function __construct(Depo $depo)
    {
        $this->depo = $depo;
        
        // ✅ Fix: Explicit casting to avoid decimal/string conversion error
        $percentage = (float) $depo->persentase_volume;
        $this->message = "PERINGATAN: Depo {$depo->nama_depo} telah mencapai kapasitas {$percentage}%!";
        $this->timestamp = now()->toISOString();
    }

    public function broadcastOn()
    {
        return [
            new Channel('public-dashboard'),
            new PrivateChannel('admin-dashboard'),
            new Channel('critical-alerts'),
        ];
    }

    public function broadcastAs()
    {
        return 'critical_volume_alert';
    }

    public function broadcastWith()
    {
        return [
            'type' => 'critical_volume_alert',
            'depo' => [
                'id' => $this->depo->id,
                'nama_depo' => $this->depo->nama_depo,
                'lokasi' => $this->depo->lokasi ?? '',
                'persentase_volume' => (float) $this->depo->persentase_volume,
                'volume_saat_ini' => (float) ($this->depo->volume_saat_ini ?? 0),
                'volume_maksimal' => (float) ($this->depo->volume_maksimal ?? 100),
                'status' => $this->depo->status ?? 'critical',
                'led_status' => true
            ],
            'message' => $this->message,
            'timestamp' => $this->timestamp,
        ];
    }
    
}