<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewReportNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public function via($notifiable)
    {
        return ['database']; // Simpan notifikasi ke database
    }

    public function toArray($notifiable)
    {
        return [
            'report_id' => $this->report->id,
            'nama_depo' => $this->report->depo->nama_depo,
            'pesan' => "Laporan baru kategori '{$this->report->kategori}' telah dikirim.",
            'url' => route('admin.reports.show', $this->report->id),
        ];
    }
}