<?php
// app/Events/NewReportSubmitted.php
namespace App\Events;

use App\Models\Report;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewReportSubmitted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('admin-notifications'),
        ];
    }

    public function broadcastWith()
    {
        return [
            'type' => 'new_report',
            'report' => [
                'id' => $this->report->id,
                'depo_name' => $this->report->depo->nama_depo,
                'category' => $this->report->kategori_text,
                'reporter' => $this->report->nama_pelapor,
                'created_at' => $this->report->created_at->format('d/m/Y H:i'),
            ],
            'message' => "Laporan baru dari {$this->report->nama_pelapor} untuk {$this->report->depo->nama_depo}",
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ];
    }
}