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
            // Validasi data dari ESP32
            $validated = $request->validate([
                'esp_id'   => 'required|string',
                'depo_id'  => 'required|integer|exists:depos,id',
                'volume'   => 'required|numeric|min:0|max:100',
            ]);

            $depoId = $validated['depo_id'];
            $persentase = $validated['volume']; // persentase dari ESP32

            // Ambil data depo
            $depo = DB::table('depos')->where('id', $depoId)->first();
            if (!$depo) {
                return response()->json(['message' => 'Depo tidak ditemukan'], 404);
            }

            // Hitung volume_saat_ini (m³)
            $volumeMaks = (float) $depo->volume_maksimal;
            $volumeSaatIni = ($persentase / 100) * $volumeMaks;

            // Tentukan status
            $status = 'normal';
            if ($persentase >= 61) {
                $status = 'critical';
            } elseif ($persentase >= 31) {
                $status = 'warning';
            }

            // LED ON jika critical
            $ledStatus = ($status === 'critical') ? 1 : 0;

            // Update data depo
            DB::table('depos')
                ->where('id', $depoId)
                ->update([
                    'volume_saat_ini'   => $volumeSaatIni,
                    'persentase_volume' => $persentase,
                    'status'            => $status,
                    'led_status'        => $ledStatus,
                    'last_updated'      => now(),
                    'updated_at'        => now(),
                ]);

            // Simpan ke DB
            $inserted = DB::table('sensor_readings')->insert([
                'esp_id'     => $validated['esp_id'],
                'depo_id'    => (int) $validated['depo_id'],
                'volume'     => (float) $validated['volume'],
                'reading_time' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update volume di tabel depo
            $depoModel = Depo::find($validated['depo_id']);
            if ($depoModel) {
                $volumeBaru = ($depoModel->volume_maksimal ?? 100) * ($validated['volume'] / 100);
                $depoModel->update([
                    'volume_saat_ini'     => $volumeBaru,
                    'persentase_volume'   => $validated['volume'],
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

    return response()
        ->json($latest)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
}

}
