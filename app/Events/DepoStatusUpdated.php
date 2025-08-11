<?php

// app/Events/DepoStatusUpdated.php
namespace App\Events;

use App\Models\Depo;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DepoStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $depo;
    public $previousStatus;

    public function __construct(Depo $depo, string $previousStatus)
    {
        $this->depo = $depo;
        $this->previousStatus = $previousStatus;
    }

    public function broadcastOn()
    {
        return [
            new Channel('public-dashboard'),
            new PrivateChannel('admin-dashboard'),
        ];
    }

    public function broadcastAs()
    {
        return 'depo_status_updated';
    }
    public function broadcastWith()
    {
        return [
            'type' => 'depo_status_updated',
            'depo' => [
                'id' => $this->depo->id,
                'nama_depo' => $this->depo->nama_depo,
                'lokasi' => $this->depo->lokasi,
                'persentase_volume' => $this->depo->persentase_volume,
                'status' => $this->depo->status,
                'status_color' => $this->depo->status_color,
                'status_text' => $this->depo->status_text,
                'led_status' => $this->depo->led_status,
                'last_updated' => $this->depo->last_updated?->format('d/m/Y H:i'),
            ],
            'previous_status' => $this->previousStatus,
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ];
    }

    private function getStatusText($status)
    {
        return [
            'normal' => 'Normal',
            'warning' => 'Warning', 
            'critical' => 'Critical'
        ][$status] ?? 'Unknown';
    }
    
}