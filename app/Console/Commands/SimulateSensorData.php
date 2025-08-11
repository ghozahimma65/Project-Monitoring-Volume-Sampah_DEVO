<?php
// app/Console/Commands/SimulateSensorData.php (untuk testing)
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Depo;
use App\Services\VolumeCalculationService;
use App\Models\SensorReading;

class SimulateSensorData extends Command
{
    protected $signature = 'sensor:simulate {depo_id?} {--increment=0.1}';
    protected $description = 'Simulate sensor data for testing';

    public function handle()
    {
        $depoId = $this->argument('depo_id');
        $increment = $this->option('increment');

        if ($depoId) {
            $depos = Depo::where('id', $depoId)->get();
        } else {
            $depos = Depo::active()->get();
        }

        $volumeService = new VolumeCalculationService();

        foreach ($depos as $depo) {
            $this->info("Simulating data for Depo: {$depo->nama_depo}");
            
            $sensorData = [];
            for ($i = 1; $i <= $depo->jumlah_sensor; $i++) {
                $espNumber = ceil($i / 4);
                $sensorNumber = (($i - 1) % 4) + 1;
                
                // Simulate gradual filling
                $currentVolume = $depo->volume_saat_ini;
                $fillLevel = ($currentVolume / $depo->volume_maksimal) * $depo->tinggi;
                $distance = ($depo->tinggi - $fillLevel) * 100; // cm
                
                // Add some random variation
                $distance += rand(-5, 5);
                $distance = max(2, min(400, $distance)); // Sensor limits
                
                $sensorData[] = [
                    'esp_id' => "ESP32_{$depo->id}_{$espNumber}",
                    'sensor_number' => $sensorNumber,
                    'distance_cm' => $distance,
                ];
            }

            $volumeService->processNewSensorData($depo, $sensorData);
            
            // Simulate volume increase
            $newVolume = min($depo->volume_saat_ini + $increment, $depo->volume_maksimal);
            $depo->update(['volume_saat_ini' => $newVolume]);
            $depo->updateVolumeStatus();
            
            $this->info("Volume updated to: {$depo->persentase_volume}%");
        }

        $this->info('Sensor data simulation completed!');
    }
}