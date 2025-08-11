<?php
// app/Jobs/ProcessSensorData.php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Depo;
use App\Services\VolumeCalculationService;

class ProcessSensorData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $depoId;
    protected $sensorData;

    public function __construct($depoId, $sensorData)
    {
        $this->depoId = $depoId;
        $this->sensorData = $sensorData;
    }

    public function handle(VolumeCalculationService $volumeService)
    {
        $depo = Depo::find($this->depoId);
        
        if ($depo) {
            $volumeService->processNewSensorData($depo, $this->sensorData);
        }
    }
}
