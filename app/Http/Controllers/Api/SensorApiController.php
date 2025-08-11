<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Depo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\SensorReading;
use Illuminate\Http\JsonResponse;

class SensorApiController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->json()->all();

            // Logging data masuk
            Log::info('Data masuk dari ESP32:', $data);

            // Validasi
            if (
                !isset($data['esp_id']) ||
                !isset($data['depo_id']) ||
                !isset($data['volume'])
            ) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid JSON structure'
                ], 400);
            }

            // Simpan ke DB
            $inserted = DB::table('sensor_readings')->insert([
                'esp_id'     => $data['esp_id'],
                'depo_id'    => (int) $data['depo_id'],
                'volume'     => (float) $data['volume'],
                'reading_time' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update volume di tabel depo
            $depo = Depo::find($data['depo_id']);
            if ($depo) {
                $volumeBaru = ($depo->volume_maksimal ?? 100) * ($data['volume'] / 100);
                $depo->update([
                    'volume_saat_ini'     => $volumeBaru,
                    'persentase_volume'   => $data['volume'],
                ]);
            }

            if ($inserted) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data saved'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to insert data'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Gagal simpan data sensor: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        try {
            $data = DB::table('sensor_readings')
                ->orderByDesc('created_at')
                ->limit(20)
                ->get();

            return response()->json($data, 200, [], JSON_PRETTY_PRINT);

        } catch (\Exception $e) {
            Log::error('Gagal ambil data sensor: ' . $e->getMessage());
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // app/Http/Controllers/Api/SensorApiController.php

    public function getLatestVolume()
{
    $latest = \App\Models\SensorReading::latest('reading_time')->first();
    return response()->json($latest);
}


}
