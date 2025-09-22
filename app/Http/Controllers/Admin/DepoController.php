<?php
// app/Http/Controllers/Admin/DepoController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depo;
use App\Http\Requests\DepoRequest;
use App\Services\DepoCalculationService;
use App\Services\SensorService;
use Illuminate\Http\Request;

class DepoController extends Controller
{
    protected $depoService;
    protected $sensorService;

    public function __construct(DepoCalculationService $depoService, SensorService $sensorService)
    {
        $this->depoService = $depoService;
        $this->sensorService = $sensorService;
    }

    public function index()
    {
        $depos = Depo::all();
        return view('admin.depos.index', compact('depos'));
    }

    public function create()
    {
        return view('admin.depos.create');
    }

    public function store(DepoRequest $request)
    {
        // 1. Ambil data yang sudah divalidasi
        $validatedData = $request->validated();

        $panjang = $validatedData['panjang']; // cm
        $lebar   = $validatedData['lebar'];   // cm
        $tinggi  = $validatedData['tinggi'];  // cm

        // 2. Gunakan service untuk perhitungan
        $sensorCount = $this->depoService->calculateSensorCount($panjang, $lebar);
        $espCount    = $this->depoService->calculateEspCount($sensorCount);
        $maxVolume   = $this->depoService->calculateMaxVolume($panjang, $lebar, $tinggi);

        // 3. Siapkan semua data yang akan disimpan
        $dataToStore = [
            'nama_depo'       => $validatedData['nama_depo'],
            'lokasi'          => $validatedData['lokasi'],
            'panjang'         => $panjang,
            'lebar'           => $lebar,
            'tinggi'          => $tinggi,
            'volume_maksimal' => $maxVolume,
            'jumlah_sensor'   => $sensorCount,
            'jumlah_esp'      => $espCount,
        ];

        // 4. Simpan data
        Depo::create($dataToStore);

        return redirect()->route('admin.depos.index')->with('success', 'Depo berhasil ditambahkan.');
    }

    public function show(Depo $depo)
    {
        return view('admin.depos.show', compact('depo'));
    }

    public function edit(Depo $depo)
    {
        return view('admin.depos.edit', compact('depo'));
    }

    public function update(DepoRequest $request, Depo $depo)
    {
        $validatedData = $request->validated();

        // tetap gunakan service agar konsisten
        $sensorCount = $this->depoService->calculateSensorCount($validatedData['panjang'], $validatedData['lebar']);
        $espCount    = $this->depoService->calculateEspCount($sensorCount);
        $maxVolume   = $this->depoService->calculateMaxVolume($validatedData['panjang'], $validatedData['lebar'], $validatedData['tinggi']);

        $data = [
            'nama_depo'       => $validatedData['nama_depo'],
            'lokasi'          => $validatedData['lokasi'],
            'panjang'         => $validatedData['panjang'],
            'lebar'           => $validatedData['lebar'],
            'tinggi'          => $validatedData['tinggi'],
            'volume_maksimal' => $maxVolume,
            'jumlah_sensor'   => $sensorCount,
            'jumlah_esp'      => $espCount,
        ];

        $depo->update($data);

        return redirect()->route('admin.depos.index')->with('success', 'Depo berhasil diperbarui');
    }

    public function destroy(Depo $depo)
    {
        try {
            $depoName = $depo->nama_depo;
            $depo->delete();
            if (request()->wantsJson()) {
                return response()->json(['success' => true, 'message' => "Depo '{$depoName}' berhasil dihapus."]);
            }
            return redirect()->route('admin.depos.index')->with('success', "Depo '{$depoName}' berhasil dihapus.");
        } catch (\Exception $e) {
            \Log::error('Error deleting depo: ' . $e->getMessage());
            if (request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus depo.'], 500);
            }
            return redirect()->route('admin.depos.index')->with('error', 'Gagal menghapus depo.');
        }
    }
    
    public function previewCalculation(Request $request)
    {
        $validatedData = $request->validate([
            'panjang' => 'required|numeric|min:0.1|max:5000',
            'lebar'   => 'required|numeric|min:0.1|max:5000',
            'tinggi'  => 'required|numeric|min:0.1|max:5000',
        ]);

        $panjang = $validatedData['panjang'];
        $lebar   = $validatedData['lebar'];
        $tinggi  = $validatedData['tinggi'];

        $sensorCount = $this->depoService->calculateSensorCount($panjang, $lebar);
        $espCount    = $this->depoService->calculateEspCount($sensorCount);
        $maxVolume   = $this->depoService->calculateMaxVolume($panjang, $lebar, $tinggi);

        return response()->json([
            'success' => true,
            'calculations' => [
                'jumlah_sensor'    => $sensorCount,
                'jumlah_esp'       => $espCount,
                'volume_maksimal'  => $maxVolume,
                'area_coverage'    => $panjang * $lebar,
            ],
        ]);
    }

    public function getRealtimeVolumes()
    {
        $volumes = Depo::where('is_active', true)
                       ->get(['id', 'persentase_volume', 'volume_saat_ini', 'volume_maksimal', 'status', 'updated_at']);
        
        return response()->json($volumes);
    }

    public function getPublicDashboardData()
    {
        $depos = Depo::with(['sensorReadings' => function ($query) {
            $query->latest('created_at')->limit(1);
        }])->get();

        $data = $depos->map(function ($depo) {
            $latestReading = $depo->sensorReadings->first();
            $volumeSaatIni = $latestReading ? $latestReading->volume : 0;

            $status = 'Normal';
            if ($volumeSaatIni > 90) {
                $status = 'Penuh';
            } elseif ($volumeSaatIni > 75) {
                $status = 'Hampir Penuh';
            }

            return [
                'id'             => $depo->id,
                'nama_depo'      => $depo->nama_depo,
                'volume_saat_ini'=> $volumeSaatIni,
                'status'         => $status
            ];
        });

        return response()->json(['success' => true, 'data' => $data]);
    }
}