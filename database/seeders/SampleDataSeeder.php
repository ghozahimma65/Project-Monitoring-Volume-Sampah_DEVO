<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Depo;
use App\Models\SensorReading;
use App\Models\VolumeHistory;
use App\Models\Report;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        $depos = Depo::all();

        foreach ($depos as $depo) {
            // Tambahkan ini di loop utama foreach ($depos as $depo)
for ($espNumber = 1; $espNumber <= $depo->jumlah_esp; $espNumber++) {
    $espId = "ESP32_{$depo->id}_{$espNumber}";

    for ($hour = 24; $hour >= 0; $hour--) {
        $readingTime = now()->subHours($hour);

        $simulasi_volume = rand(50, 100) / 100 * $depo->volume_maksimal;

        SensorReading::create([
            'depo_id' => $depo->id,
            'esp_id' => $espId,
            'volume' => $simulasi_volume,
            'reading_time' => $readingTime,
        ]);

        // Update volume & persentase di tabel depos
        $depo->update([
            'volume_saat_ini' => $simulasi_volume,
            'persentase_volume' => ($simulasi_volume / $depo->volume_maksimal) * 100,
            'last_updated' => now(),
        ]);

        $depo->updateVolumeStatus();
    }
}

            // Simulasi volume awal acak (0-100%)
            $currentPercentage = rand(0, 100);
            $currentVolume = ($currentPercentage / 100) * $depo->volume_maksimal;

            $depo->update([
                'volume_saat_ini' => $currentVolume,
                'persentase_volume' => $currentPercentage,
                'last_updated' => now(),
            ]);

            $depo->updateVolumeStatus();

            // Simulasi riwayat volume 30 hari ke belakang
            for ($i = 30; $i >= 0; $i--) {
                $date = now()->subDays($i);

                $baseVolume = max(0, $currentVolume - (30 - $i) * 0.5);
                $dailyVolume = $baseVolume + rand(-10, 20) / 100 * $depo->volume_maksimal;
                $dailyVolume = max(0, min($dailyVolume, $depo->volume_maksimal));

                $percentage = ($dailyVolume / $depo->volume_maksimal) * 100;
                $status = $percentage >= 90 ? 'critical' : ($percentage >= 80 ? 'warning' : 'normal');

                VolumeHistory::create([
                    'depo_id' => $depo->id,
                    'volume' => $dailyVolume,
                    'persentase' => $percentage,
                    'status' => $status,
                    'recorded_at' => $date,
                ]);
            }

            // Simulasi 24 jam data sensor_readings terakhir
            for ($hour = 24; $hour >= 0; $hour--) {
                $readingTime = now()->subHours($hour);

                // Simulasi volume sensor acak antara 50%-100%
                $simulasi_volume = rand(50, 100) / 100 * $depo->volume_maksimal;

                $espNumber = 1; // Karena kamu gak pakai per sensor, ini fixed
                $espId = "ESP32_{$depo->id}_{$espNumber}";

                // Simpan ke sensor_readings
                SensorReading::create([
                    'depo_id' => $depo->id,
                    'esp_id' => $espId,
                    'volume' => $simulasi_volume,
                    'reading_time' => $readingTime,
                ]);

                // Update volume_saat_ini dan persen_volume
$depo->update([
    'volume_saat_ini' => $simulasi_volume,
    'persentase_volume' => ($simulasi_volume / $depo->volume_maksimal) * 100,
    'last_updated' => now(),
]);

// Tambahkan ini agar status terupdate
$depo->updateVolumeStatus();

            }
        }

        // Buat data report dummy
        $this->createSampleReports();
    }

   private function createSampleReports()
{
    $depos = Depo::all();

    $sampleReports = [
        [
            'tanggal_laporan' => now()->subDays(5),
            'kategori' => 'overload',
            'deskripsi' => 'Volume melebihi kapasitas maksimal.',
            'status' => 'pending',
            'admin_response' => null,
            'resolved_at' => null,
        ],
        [
            'tanggal_laporan' => now()->subDays(3),
            'kategori' => 'kerusakan_sensor',
            'deskripsi' => 'Sensor tidak mengirim data.',
            'status' => 'resolved',
            'admin_response' => 'Sensor sudah diganti.',
            'resolved_at' => now()->subDays(1),
        ],
        [
            'tanggal_laporan' => now()->subDays(10),
            'kategori' => 'sampah_berserakan',
            'deskripsi' => 'Sampah ditemukan di luar depo.',
            'status' => 'in_progress',
            'admin_response' => 'Sedang ditangani.',
            'resolved_at' => null,
        ],
    ];

    foreach ($sampleReports as $index => $reportData) {
        $depo = $depos->random();

        $reportNumber = str_pad($index + 1, 3, '0', STR_PAD_LEFT);
        $reportId = 'RPT-' . date('Y') . '-' . $reportNumber;

        Report::create([
            'report_id' => $reportId,
            'depo_id' => $depo->id,
            'tanggal_laporan' => $reportData['tanggal_laporan'],
            'kategori' => $reportData['kategori'],
            'deskripsi' => $reportData['deskripsi'],
            'status' => $reportData['status'],
            'admin_response' => $reportData['admin_response'],
            'resolved_at' => $reportData['resolved_at'],
            'created_at' => $reportData['tanggal_laporan'],
            'updated_at' => $reportData['resolved_at'] ?? $reportData['tanggal_laporan'],
        ]);

        $this->command->info("Created report {$reportId} for {$depo->nama_depo} - Status: {$reportData['status']}");
    }

    $this->command->info('Sample reports created successfully!');}
}
