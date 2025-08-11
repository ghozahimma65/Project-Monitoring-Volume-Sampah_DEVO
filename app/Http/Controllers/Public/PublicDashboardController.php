<?php

// app/Http/Controllers/Public/PublicDashboardController.php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Depo;
use App\Services\DepoCalculationService;
use App\Services\VolumeCalculationService;
use Illuminate\Http\Request;

class PublicDashboardController extends Controller
{
    protected $depoService;
    protected $volumeService;

    public function __construct(DepoCalculationService $depoService, VolumeCalculationService $volumeService)
    {
        $this->depoService = $depoService;
        $this->volumeService = $volumeService;
    }

    public function index(Request $request)
    {
        $query = Depo::active();

        // Filter berdasarkan status
        if ($request->has('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        }

        // Search nama depo atau lokasi
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_depo', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        $depos = $query->orderBy('nama_depo')->get();
        $statistics = $this->depoService->getDepoStatistics();

        return view('public.dashboard', compact('depos', 'statistics'));
    }

    public function show(Depo $depo, Request $request)
    {
        $period = $request->get('period', 'daily');
        $chartData = $this->volumeService->getVolumeChartData($depo, $period);
        $estimatedFull = $depo->estimateTimeToFull();

        return view('public.depo-detail', compact('depo', 'chartData', 'estimatedFull', 'period'));
    }

    public function api()
    {
        $depos = Depo::active()->get()->map(function($depo) {
            return [
                'id' => $depo->id,
                'nama_depo' => $depo->nama_depo,
                'lokasi' => $depo->lokasi,
                'persentase_volume' => $depo->persentase_volume,
                'status' => $depo->status,
                'status_color' => $depo->status_color,
                'status_text' => $depo->status_text,
                'led_status' => $depo->led_status,
                'last_updated' => $depo->last_updated?->format('d/m/Y H:i'),
            ];
        });

        $statistics = $this->depoService->getDepoStatistics();

        return response()->json([
            'depos' => $depos,
            'statistics' => $statistics,
            'timestamp' => now()->format('d/m/Y H:i:s'),
        ]);
    }

    public function getChartData(Depo $depo, Request $request)
    {
        $period = $request->get('period', 'daily');
        $chartData = $this->volumeService->getVolumeChartData($depo, $period);
        
        return response()->json($chartData);
    }
}



