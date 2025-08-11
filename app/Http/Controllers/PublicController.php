<?php
// Di controller dashboard Anda (misal PublicController.php)

use App\Services\NotificationService;

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
}