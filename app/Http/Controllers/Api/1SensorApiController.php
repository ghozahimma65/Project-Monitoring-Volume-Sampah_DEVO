<?php
// app/Http/Controllers/Api/SensorApiController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SensorApiController extends Controller
{
    public function receiveSensorData(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Data received',
            'data' => $request->all(),
        ])
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
        ->header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin');
}

    public function receiveBatchData(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Batch received',
            'data' => $request->all(),
        ]);
    }
}
