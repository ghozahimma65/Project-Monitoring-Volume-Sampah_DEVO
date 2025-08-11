<?php

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

    public function updateDepoVolume($depoId, $newVolume)
    {
        $depo = Depo::find($depoId);
        if (!$depo) return;

        $oldStatus = $depo->status;
        $depo->persentase_volume = $newVolume;
        
        // Determine new status
        if ($newVolume >= 90) {
            $depo->status = 'critical';
        } elseif ($newVolume >= 70) {
            $depo->status = 'warning';
        } else {
            $depo->status = 'normal';
        }

        $depo->save();

        // Broadcast status update
        broadcast(new CriticalVolumeAlert($depo)); 
        // Send critical alert if status changed to critical
        if ($depo->status === 'critical' && $oldStatus !== 'critical') {
            broadcast(new CriticalVolumeAlert($depo));
        }

        return $depo;
    }
}


