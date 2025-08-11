<?php

namespace App\Http\Controllers;

use App\Models\Depo;
use App\Services\VolumeCalculationService;
use Illuminate\Http\Request;

class TestNotificationController extends Controller
{
    public function testCritical()
    {
        $service = new VolumeCalculationService();
        
        // Get or create test depo
        $depo = Depo::first() ?? Depo::create([
            'nama_depo' => 'Test Depo Critical',
            'lokasi' => 'Jakarta Pusat',
            'volume_maksimal' => 1000,
            'volume_saat_ini' => 850,
            'is_active' => 1
        ]);
        
        // Simulate critical volume (95%)
        $result = $service->updateDepoVolume($depo->id, 95);
        
        return response()->json([
            'success' => true,
            'message' => 'Critical notification sent!',
            'depo' => $result
        ]);
    }
    
    public function testWarning()
    {
        $service = new VolumeCalculationService();
        
        $depo = Depo::first();
        if (!$depo) {
            return response()->json(['error' => 'No depo found']);
        }
        
        // Simulate warning volume (75%)
        $result = $service->updateDepoVolume($depo->id, 75);
        
        return response()->json([
            'success' => true,
            'message' => 'Warning notification sent!',
            'depo' => $result
        ]);
    }
    
    public function testNormal()
    {
        $service = new VolumeCalculationService();
        
        $depo = Depo::first();
        if (!$depo) {
            return response()->json(['error' => 'No depo found']);
        }
        
        // Simulate normal volume (45%)
        $result = $service->updateDepoVolume($depo->id, 45);
        
        return response()->json([
            'success' => true,
            'message' => 'Volume back to normal!',
            'depo' => $result
        ]);
    }
}