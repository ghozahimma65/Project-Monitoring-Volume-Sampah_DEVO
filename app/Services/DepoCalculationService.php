<?php

// app/Services/DepoCalculationService.php
namespace App\Services;

use App\Models\Depo;

class DepoCalculationService
{
    const SENSOR_COVERAGE_AREA = 255; //15cm per sensor
    const MAX_SENSOR_PER_ESP = 4;

    public function calculateSensorCount(float $panjang, float $lebar): int
    {
 $totalArea = $panjang * $lebar; // cm²
        return ceil($totalArea / self::SENSOR_COVERAGE_AREA);
    }

    public function calculateEspCount(int $sensorCount): int
    {
        return ceil($sensorCount / self::MAX_SENSOR_PER_ESP);
    }

    public function calculateMaxVolume(float $panjang, float $lebar, float $tinggi): float
    {
        return $panjang * $lebar * $tinggi;
    }

    public function prepareDepoData(array $input): array
    {
        $sensorCount = $this->calculateSensorCount($input['panjang'], $input['lebar']);
        $espCount = $this->calculateEspCount($sensorCount);
        $maxVolume = $this->calculateMaxVolume(
            $input['panjang'], 
            $input['lebar'], 
            $input['tinggi']
        );

        return array_merge($input, [
            'jumlah_sensor' => $sensorCount,
            'jumlah_esp' => $espCount,
            'volume_maksimal' => $maxVolume,
        ]);
    }

    public function getDepoStatistics()
    {
        return [
            'total_depo' => Depo::active()->count(),
            'normal' => Depo::active()->normal()->count(),
            'warning' => Depo::active()->warning()->count(),
            'critical' => Depo::active()->critical()->count(),
            'total_volume' => Depo::active()->sum('volume_saat_ini'),
            'total_capacity' => Depo::active()->sum('volume_maksimal'),
        ];
    }
}

// app/Services/VolumeCalculationService.php
namespace App\Services;

use App\Models\Depo;
use App\Models\SensorReading;
use App\Events\DepoStatusUpdated;
use App\Events\CriticalVolumeAlert;

class VolumeCalculationService
{
    public function processNewSensorData(Depo $depo, array $sensorData): void
    {
        // Simpan data sensor individual
        foreach ($sensorData as $data) {
            $reading = SensorReading::create([
                'depo_id' => $depo->id,
                'esp_id' => $data['esp_id'],
                'sensor_number' => $data['sensor_number'],
                'distance_cm' => $data['distance_cm'],
                'reading_time' => now(),
                'raw_data' => $data,
            ]);

            // Hitung kontribusi volume dari sensor ini
            $reading->calculateVolumeContribution();
        }

        // Hitung total volume depo
        $this->calculateTotalVolume($depo);
    }

    public function calculateTotalVolume(Depo $depo): void
    {
        // Ambil reading terbaru dari semua sensor
        $latestReadings = SensorReading::where('depo_id', $depo->id)
            ->where('reading_time', '>=', now()->subMinutes(5)) // data 5 menit terakhir
            ->get()
            ->groupBy(['esp_id', 'sensor_number'])
            ->map(function ($group) {
                return $group->sortByDesc('reading_time')->first();
            })
            ->flatten();

        if ($latestReadings->isEmpty()) {
            return;
        }

        // Jumlahkan kontribusi volume dari semua sensor
        $totalVolume = $latestReadings->sum('volume_contribution');
        
        // Update status depo
        $previousStatus = $depo->status;
        $depo->volume_saat_ini = min($totalVolume, $depo->volume_maksimal);
        $depo->updateVolumeStatus();

        // Trigger events jika status berubah
        if ($previousStatus !== $depo->status) {
            event(new DepoStatusUpdated($depo, $previousStatus));
            
            if ($depo->status === 'critical') {
                event(new CriticalVolumeAlert($depo));
            }
        }
    }

    public function getVolumeChartData(Depo $depo, string $period = 'daily'): array
    {
        $history = $depo->getVolumeHistory($period);
        
        return [
            'labels' => $history->pluck('recorded_at')->map(function ($date) use ($period) {
                return match($period) {
                    'hourly' => $date->format('H:i'),
                    'daily' => $date->format('d/m'),
                    'weekly' => $date->format('d/m'),
                    'monthly' => $date->format('M Y'),
                    default => $date->format('d/m/Y'),
                };
            })->reverse()->values(),
            'volumes' => $history->pluck('volume')->reverse()->values(),
            'percentages' => $history->pluck('persentase')->reverse()->values(),
        ];
    }

    public function simulateVolumeIncrease(Depo $depo, float $increaseAmount): array
    {
        $newVolume = $depo->volume_saat_ini + $increaseAmount;
        $newPercentage = ($newVolume / $depo->volume_maksimal) * 100;
        
        $newStatus = 'normal';
        if ($newPercentage >= 95) {
            $newStatus = 'critical';
        } elseif ($newPercentage >= 80) {
            $newStatus = 'warning';
        }

        return [
            'current_volume' => $depo->volume_saat_ini,
            'new_volume' => min($newVolume, $depo->volume_maksimal),
            'current_percentage' => $depo->persentase_volume,
            'new_percentage' => min($newPercentage, 100),
            'current_status' => $depo->status,
            'new_status' => $newStatus,
        ];
    }
}

// app/Services/NotificationService.php
namespace App\Services;

use App\Models\Notification;
use App\Models\Depo;
use App\Models\Report;
use Illuminate\Support\Facades\Broadcast;

class NotificationService
{
    public function createCriticalVolumeNotification(Depo $depo): void
    {
        $notification = Notification::create([
            'type' => 'critical_volume',
            'data' => [
                'depo_id' => $depo->id,
                'depo_name' => $depo->nama_depo,
                'location' => $depo->lokasi,
                'volume_percentage' => $depo->persentase_volume,
                'message' => "Depo {$depo->nama_depo} telah mencapai kapasitas " . strval($depo->persentase_volume) . "%"
            ],
            'created_at' => now(),
            'target_audience' => 'admin',
        ]);

        // Broadcast ke admin
        Broadcast::channel('admin-notifications', $notification);
    }

    public function createNewReportNotification(Report $report): void
    {
        $notification = Notification::create([
            'type' => 'new_report',
            'data' => [
                'report_id' => $report->id,
                'depo_name' => $report->depo->nama_depo,
                'category' => $report->kategori_text,
                'reporter' => $report->nama_pelapor,
                'message' => "Laporan baru dari {$report->nama_pelapor} untuk {$report->depo->nama_depo}"
            ],
            'created_at' => now(),
            'target_audience' => 'admin',
        ]);

        // Broadcast ke admin
        Broadcast::channel('admin-notifications', $notification);
    }

    public function createDepoStatusUpdateNotification(Depo $depo, string $previousStatus): void
    {
        $notification = Notification::create([
            'type' => 'status_change',
            'data' => [
                'depo_id' => $depo->id,
                'depo_name' => $depo->nama_depo,
                'previous_status' => $previousStatus,
                'current_status' => $depo->status,
                'volume_percentage' => $depo->persentase_volume,
                'message' => "Status {$depo->nama_depo} berubah dari {$previousStatus} ke {$depo->status}"
            ],
            'created_at' => now(),
            'target_audience' => 'public',
        ]);

        // Broadcast ke public dashboard
        Broadcast::channel('public-dashboard', [
            'type' => 'depo_updated',
            'depo' => $depo->only(['id', 'nama_depo', 'lokasi', 'persentase_volume', 'status', 'status_color']),
        ]);
    }

    public function getUnreadNotifications(string $audience = 'admin'): array
    {
        return Notification::unread()
            ->where('target_audience', $audience)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function markAllAsRead(string $audience = 'admin'): void
    {
        Notification::unread()
            ->where('target_audience', $audience)
            ->update(['is_read' => true]);
    }
}

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