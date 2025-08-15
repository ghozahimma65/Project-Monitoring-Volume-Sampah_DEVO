<?php
// Di controller dashboard Anda (misal PublicController.php)

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
        // Existing code...
        
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

        return view('public.dashboard', compact('depos', 'statistics'));
    }
    public function getChartData(Depo $depo)
{
    // Ambil data histori volume dari 24 jam terakhir
    $history = $depo->volumeHistory()
                    ->where('recorded_at', '>=', Carbon::now()->subHours(24))
                    
                    // INI BAGIAN PENTING: Hanya ambil data yang nilainya lebih dari 0
                    ->where('persentase', '>', 0) 
                    
                    ->orderBy('recorded_at', 'asc')
                    ->get();

    // Siapkan data untuk dikirim ke grafik
    $labels = $history->map(function ($item) {
        return Carbon::parse($item->recorded_at)->format('H:i'); // Format waktu (Jam:Menit)
    });

    $data = $history->map(function ($item) {
        return $item->persentase; // Ambil nilai persentasenya
    });

    return response()->json([
        'labels' => $labels,
        'data' => $data,
    ]);
    }
}