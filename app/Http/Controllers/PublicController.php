<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use App\Models\Depo;
use Carbon\Carbon;

class PublicController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function dashboard()
    {
        // Ambil semua depo aktif
        $depos = Depo::where('is_active', true)->get();

        // Cek depo critical dan buat notifikasi
        $criticalDepos = $depos->filter(function ($depo) {
            return $depo->persentase_volume >= 90;
        });

        foreach ($criticalDepos as $depo) {
            $this->notificationService->createCriticalVolumeNotification($depo);
        }

        // Hapus notifikasi untuk depo yang sudah tidak critical
        $normalDepos = $depos->filter(function ($depo) {
            return $depo->persentase_volume < 90;
        });

        foreach ($normalDepos as $depo) {
            $this->notificationService->removeCriticalVolumeNotification($depo->id);
        }

        // hitung statistik sederhana (contoh)
        $statistics = [
            'total'    => $depos->count(),
            'critical' => $criticalDepos->count(),
            'normal'   => $normalDepos->count(),
        ];

        return view('public.dashboard', compact('depos', 'statistics'));
    }

    public function getChartData(Depo $depo)
    {
        // Ambil data histori volume dari 24 jam terakhir
        $history = $depo->volumeHistory()
                        ->where('recorded_at', '>=', Carbon::now()->subHours(24))
                        ->where('persentase', '>', 0)
                        ->orderBy('recorded_at', 'asc')
                        ->get();

        // Siapkan data untuk dikirim ke grafik
        $labels = $history->map(fn($item) => Carbon::parse($item->recorded_at)->format('H:i'));
        $data   = $history->pluck('persentase');

        return response()->json([
            'labels' => $labels,
            'data'   => $data,
        ]);
    }
}
