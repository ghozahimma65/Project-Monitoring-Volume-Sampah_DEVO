<?php
// database/seeders/DepoSeeder.php
namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Depo;
use Illuminate\Database\Seeder;
use App\Services\DepoCalculationService;

class DepoSeeder extends Seeder
{
    public function run()
    {
        $depoService = new DepoCalculationService();
        
        $depos = [
           [
                'nama_depo' => 'Depo Merah',
                'lokasi' => 'Jl. Sudirman No. 12, Jakarta Pusat',
                'panjang' => 7.00,
                'lebar' => 4.50,
                'tinggi' => 3.20,
                'jumlah_sensor' => 4,
                'jumlah_esp' => 2,
                'volume_maksimal' => 100.80,
                'is_active' => true,
                'target_volume' => 64.5 // 64%
            ],
            [
                'nama_depo' => 'Depo Kuning',
                'lokasi' => 'Jl. Thamrin No. 89, Jakarta Barat',
                'panjang' => 6.00,
                'lebar' => 5.00,
                'tinggi' => 3.00,
                'jumlah_sensor' => 4,
                'jumlah_esp' => 2,
                'volume_maksimal' => 90.00,
                'is_active' => true,
                'target_volume' => 76.5 // 85%
            ],
            [
                'nama_depo' => 'Depo Hijau',
                'lokasi' => 'Jl. Gatot Subroto No. 45, Jakarta Selatan',
                'panjang' => 8.00,
                'lebar' => 5.00,
                'tinggi' => 3.50,
                'jumlah_sensor' => 6,
                'jumlah_esp' => 3,
                'volume_maksimal' => 140.00,
                'is_active' => true,
                'target_volume' => 133.0 // 95%
            ]
        ];

                foreach ($depos as $depoData) {
                    $targetVolume = $depoData['target_volume'];
                    unset($depoData['target_volume']);
                    
                    $depo = Depo::create($depoData);
                    // You can use $targetVolume and $depo here if needed
                }
            }
        }

            