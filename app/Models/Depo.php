<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Depo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_depo',
        'lokasi',
        'panjang',
        'lebar',
        'tinggi',
        'volume_maksimal',
        'jumlah_sensor',
        'jumlah_esp',
        'is_active',
    ];

    protected $casts = [
        'panjang' => 'decimal:2',
        'lebar' => 'decimal:2',
        'tinggi' => 'decimal:2',
        'volume_maksimal' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Helper methods
    public function getLatestVolumeReading()
    {
        return $this->volumeReadings()->latest('reading_time')->first();
    }

    public function getCurrentVolume()
    {
        $latest = $this->getLatestVolumeReading();
        if (!$latest) return 0;
        
        // Convert persentase ke volume absolut
        return round(($latest->volume_percentage / 100) * $this->volume_maksimal, 4);
    }

    public function getCurrentPercentage()
    {
        $latest = $this->getLatestVolumeReading();
        return $latest ? $latest->volume_percentage : 0;
    }

    public function getCurrentStatus()
    {
        $percentage = $this->getCurrentPercentage();
        
        if ($percentage >= 80) {
            return 'critical';
        } elseif ($percentage >= 60) {
            return 'warning';
        } else {
            return 'normal';
        }
    }

    // Relationships
    public function sensorReadings()
    {
        return $this->hasMany(SensorReading::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function volumeHistory()
    {
        return $this->hasMany(VolumeHistory::class);
    }

    // Accessors & Mutators
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'normal' => 'green',
            'warning' => 'yellow',
            'critical' => 'red',
            default => 'gray'
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'normal' => 'Normal',
            'warning' => 'Warning',
            'critical' => 'Critical',
            default => 'Unknown'
        };
    }

    // Methods
    public function calculateSensorCount()
    {
        // Area maksimum per sensor = 2m x 2m = 4m²
        $areaPerSensor = 4;
        $totalArea = $this->panjang * $this->lebar;
        return ceil($totalArea / $areaPerSensor);
    }

    public function calculateEspCount()
    {
        // Maksimal 4 sensor per ESP32
        $maxSensorPerEsp = 4;
        return ceil($this->jumlah_sensor / $maxSensorPerEsp);
    }

    public function updateVolumeStatus()
{
    if ($this->persentase_volume >= 90) {
    // ...
    if (is_null($this->waktu_kritis)) {
        $this->waktu_kritis = now();

        $admins = User::where('is_admin', true)->get();
        if ($admins->isNotEmpty()) {
            foreach ($admins as $admin) {
                // Baris ini yang memicu notifikasi
                $admin->notify(new DepoCriticalNotification($this));
            }
        }
    }
}
    // Ambil persentase volume terakhir yang valid untuk perbandingan
    $persentaseTerakhir = $this->persentase_volume;
    $persentaseBaru = number_format((($this->volume_saat_ini / $this->volume_maksimal) * 100), 2, '.', '');

    // --- LOGIKA PENGECEKAN DATA ANEH ---
    $isAbnormal = false;
    $catatanAbnormal = '';

    // Aturan 1: Nilai negatif atau di atas 100%
    if ($persentaseBaru < 0 || $persentaseBaru > 100) {
        $isAbnormal = true;
        $catatanAbnormal = "Nilai tidak wajar: {$persentaseBaru}%.";
    }
    // Aturan 2: Perubahan drastis (misal > 50% dalam satu waktu)
    else if (abs($persentaseBaru - $persentaseTerakhir) > 50) {
        $isAbnormal = true;
        $catatanAbnormal = "Perubahan drastis dari {$persentaseTerakhir}% menjadi {$persentaseBaru}%.";
    }

    if ($isAbnormal) {
        // Catat ke buku catatan kita
        \App\Models\AbnormalReading::create([
            'depo_id' => $this->id,
            'nilai_terbaca' => $this->volume_saat_ini, // Catat nilai asli dari sensor
            'catatan' => $catatanAbnormal,
        ]);

        // PENTING: Jangan lanjutkan proses, agar data aneh tidak disimpan
        return; 
    }
    // --- AKHIR LOGIKA PENGECEKAN ---

    // Jika data normal, lanjutkan proses seperti biasa
    $this->persentase_volume = $persentaseBaru;
    
    if ($this->persentase_volume >= 90) {
        $this->status = 'critical';
        $this->led_status = true;

        if (is_null($this->waktu_kritis)) {
            $this->waktu_kritis = now();
        }

    } elseif ($this->persentase_volume >= 80) {
        $this->status = 'warning';
        $this->led_status = false;
        $this->waktu_kritis = null;
    } else {
        $this->status = 'normal';
        $this->led_status = false;
        $this->waktu_kritis = null;
    }

    $this->last_updated = now();
    $this->save();

    // Save to history
    \App\Models\VolumeHistory::create([
        'depo_id' => $this->id,
        'volume' => $this->volume_saat_ini,
        'persentase' => $this->persentase_volume,
        'status' => $this->status,
        'recorded_at' => now(),
        
    ]);
}

    public function getLatestReadings($limit = 100)
    {
        return $this->sensorReadings()
                   ->orderBy('reading_time', 'desc')
                   ->limit($limit)
                   ->get();
    }

    public function getVolumeHistory($period = 'daily', $days = 30)
    {
        $query = $this->volumeHistory()->orderBy('recorded_at', 'desc');

        switch ($period) {
            case 'hourly':
                $query->where('recorded_at', '>=', now()->subHours(24));
                break;
            case 'daily':
                $query->where('recorded_at', '>=', now()->subDays($days));
                break;
            case 'weekly':
                $query->where('recorded_at', '>=', now()->subWeeks(12));
                break;
            case 'monthly':
                $query->where('recorded_at', '>=', now()->subMonths(12));
                break;
        }

        return $query->get();
    }

    public function estimateTimeToFull()
    {
        // Ambil data 7 hari terakhir untuk trend analysis
        $recentData = $this->volumeHistory()
                          ->where('recorded_at', '>=', now()->subDays(7))
                          ->orderBy('recorded_at', 'asc')
                          ->get();

        if ($recentData->count() < 2) {
            return null;
        }

        // Hitung rata-rata kenaikan volume per jam
        $firstReading = $recentData->first();
        $lastReading = $recentData->last();
        
        $volumeIncrease = $lastReading->volume - $firstReading->volume;
        $timeSpan = $lastReading->recorded_at->diffInHours($firstReading->recorded_at);
        
        if ($timeSpan <= 0 || $volumeIncrease <= 0) {
            return null;
        }

        $avgIncreasePerHour = $volumeIncrease / $timeSpan;
        $remainingVolume = $this->volume_maksimal - $this->volume_saat_ini;
        
        if ($avgIncreasePerHour <= 0) {
            return null;
        }

        $hoursToFull = $remainingVolume / $avgIncreasePerHour;
        
        return Carbon::now()->addHours($hoursToFull);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

public function scopeCritical($query)
{
    return $query->where('status', 'critical');
}

public function scopeWarning($query)
{
    return $query->where('status', 'warning');
}

public function scopeNormal($query)
{
    return $query->where('status', 'normal');
}

}
