<?php

// app/Services/SensorService.php
namespace App\Services;

use App\Models\Depo;
use App\Models\SensorReading;
use Carbon\Carbon;

class SensorService
{
    public function validateSensorData(array $data): bool
    {
        $required = ['esp_id', 'depo_id', 'sensors'];
        
        foreach ($required as $field) {
            if (!isset($data[$field])) {
                return false;
            }
        }

        if (!is_array($data['sensors']) || empty($data['sensors'])) {
            return false;
        }

        foreach ($data['sensors'] as $sensor) {
            if (!isset($sensor['sensor_number']) || !isset($sensor['distance_cm'])) {
                return false;
            }
            
            // Validasi range sensor (HC-SR04: 2cm - 400cm)
            if ($sensor['distance_cm'] < 2 || $sensor['distance_cm'] > 400) {
                return false;
            }
        }

        return true;
    }

    public function processSensorDataBatch(array $batchData): array
    {
        $results = [];
        $volumeService = new VolumeCalculationService();

        foreach ($batchData as $data) {
            if (!$this->validateSensorData($data)) {
                $results[] = [
                    'success' => false,
                    'message' => 'Invalid sensor data format',
                    'data' => $data
                ];
                continue;
            }

            $depo = Depo::find($data['depo_id']);
            if (!$depo) {
                $results[] = [
                    'success' => false,
                    'message' => 'Depo not found',
                    'data' => $data
                ];
                continue;
            }

            try {
                $volumeService->processNewSensorData($depo, $data['sensors']);
                
                $results[] = [
                    'success' => true,
                    'message' => 'Data processed successfully',
                    'depo_id' => $depo->id,
                    'volume_percentage' => $depo->persentase_volume,
                    'status' => $depo->status,
                ];
            } catch (\Exception $e) {
                $results[] = [
                    'success' => false,
                    'message' => 'Error processing data: ' . $e->getMessage(),
                    'data' => $data
                ];
            }
        }

        return $results;
    }

    public function getSensorHealth(Depo $depo): array
    {
        $cutoffTime = now()->subHours(2);
        
        // Ambil data sensor 2 jam terakhir
        $recentReadings = SensorReading::where('depo_id', $depo->id)
            ->where('reading_time', '>=', $cutoffTime)
            ->get()
            ->groupBy(['esp_id', 'sensor_number']);

        $sensorHealth = [];
        
        // Generate expected sensor list berdasarkan konfigurasi depo
        for ($esp = 1; $esp <= $depo->jumlah_esp; $esp++) {
            $sensorsPerEsp = min(4, $depo->jumlah_sensor - (($esp - 1) * 4));
            
            for ($sensor = 1; $sensor <= $sensorsPerEsp; $sensor++) {
                $espId = "ESP32_{$depo->id}_{$esp}";
                $key = "{$espId}.{$sensor}";
                
                $readings = $recentReadings->get($espId)?->get($sensor) ?? collect();
                
                $sensorHealth[$key] = [
                    'esp_id' => $espId,
                    'sensor_number' => $sensor,
                    'last_reading' => $readings->max('reading_time'),
                    'reading_count' => $readings->count(),
                    'avg_distance' => $readings->avg('distance_cm'),
                    'status' => $this->determineSensorStatus($readings, $cutoffTime),
                ];
            }
        }

        return $sensorHealth;
    }

    private function determineSensorStatus($readings, Carbon $cutoffTime): string
    {
        if ($readings->isEmpty()) {
            return 'offline';
        }

        $latestReading = $readings->sortByDesc('reading_time')->first();
        $timeDiff = now()->diffInMinutes($latestReading->reading_time);

        if ($timeDiff > 60) {
            return 'warning'; // No data for more than 1 hour
        }

        if ($timeDiff > 120) {
            return 'offline'; // No data for more than 2 hours
        }

        // Check for erratic readings
        $distances = $readings->pluck('distance_cm');
        $stdDev = $this->calculateStandardDeviation($distances->toArray());
        
        if ($stdDev > 50) { // High variance in readings
            return 'unstable';
        }

        return 'healthy';
    }

    private function calculateStandardDeviation(array $values): float
    {
        if (count($values) < 2) {
            return 0;
        }

        $mean = array_sum($values) / count($values);
        $squaredDifferences = array_map(function($value) use ($mean) {
            return pow($value - $mean, 2);
        }, $values);

        $variance = array_sum($squaredDifferences) / count($values);
        return sqrt($variance);
    }
}