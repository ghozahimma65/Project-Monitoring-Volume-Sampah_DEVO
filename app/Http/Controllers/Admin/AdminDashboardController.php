<?php
// app/Http/Controllers/Admin/AdminDashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depo;
use App\Models\Report;
use App\Services\DepoCalculationService;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    protected $depoService;
    protected $notificationService;

    public function __construct(DepoCalculationService $depoService, NotificationService $notificationService)
    {
        // REMOVE middleware call - it's handled by routes
        $this->depoService = $depoService;
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $statistics = $this->depoService->getDepoStatistics();
        $criticalDepos = Depo::where('status', 'critical')->where('is_active', true)->get();
        $recentReports = Report::with('depo')->orderBy('created_at', 'desc')->limit(5)->get();
        $notifications = $this->notificationService->getUnreadNotifications('admin');
        $peringatan = \App\Models\AbnormalReading::whereNull('acknowledged_at')
                                         ->with('depo')
                                         ->latest()
                                         ->take(5)
                                         ->get();
        $volumeData = Depo::where('is_active', true)->get()->map(function($depo) {
            return [
                'name' => $depo->nama_depo,
                'volume' => $depo->persentase_volume,
                'status' => $depo->status,
            ];
        });

        $statusDistribution = [
            'normal' => $statistics['normal'],
            'warning' => $statistics['warning'],
            'critical' => $statistics['critical'],
        ];

        return view('admin.dashboard', [
        'statistics' => $statistics,
        'criticalDepos' => $criticalDepos,
        'recentReports' => $recentReports,
        'notifications' => $notifications,
        'volumeData' => $volumeData,
        'peringatan' => $peringatan,
        ]);
    }

    public function notifications()
    {
        $notifications = $this->notificationService->getUnreadNotifications('admin');
        return response()->json($notifications);
    }

    public function markNotificationsRead()
    {
        $this->notificationService->markAllAsRead('admin');
        return response()->json(['success' => true]);
    }
}
