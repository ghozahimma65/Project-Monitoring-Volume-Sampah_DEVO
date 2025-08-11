<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'depo_id',
        'esp_id',
        'volume',
        'reading_time',
    ];

    protected $casts = [
        'volume' => 'decimal:4',
        'reading_time' => 'datetime',
    ];

    // Relationships
    public function depo()
    {
        return $this->belongsTo(Depo::class);
    }
}

    // Methods
//     public function calculateVolumeContribution()
//     {
//         // Setiap sensor mengcover area 2m x 2m = 4m²
//         $coverageArea = 4; // m²
        
//         // Jarak dari sensor ke sampah
//         $distanceToWaste = $this->distance_cm / 100; // convert to meters
        
//         // Tinggi sampah = tinggi depo - jarak sensor
//         $wasteHeight = $this->depo->tinggi - $distanceToWaste;
        
//         // Volume kontribusi = area coverage × tinggi sampah
//         $volumeContribution = $coverageArea * max(0, $wasteHeight);
        
//         // Assign the numeric value directly; Eloquent will cast to decimal
//         $this->volume_contribution = round($volumeContribution, 4);
//         $this->save();
        
//         return $volumeContribution;
//     }
// }
