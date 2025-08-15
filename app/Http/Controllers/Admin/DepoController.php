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
        $validatedData = $request->validated();
        $data = $this->depoService->prepareDepoData($validatedData);

        // Memastikan depo baru selalu dibuat dengan volume 0
        $data['volume_saat_ini'] = 0;
        $data['persentase_volume'] = 0;
        $data['status'] = 'normal';

        Depo::create($data);

        return redirect()->route('admin.depos.index')->with('success', 'Depo berhasil ditambahkan');
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
        $data = $this->depoService->prepareDepoData($validatedData);
        $depo->update($data);

        return redirect()->route('admin.depos.index')->with('success', 'Depo berhasil diperbarui');
    }

    public function destroy(Depo $depo)
    {
        try {
            $depo->delete();
            if (request()->wantsJson()) {
                return response()->json(['success' => true, 'message' => "Depo '{$depo->nama_depo}' berhasil dihapus."]);
            }
            return redirect()->route('admin.depos.index')->with('success', "Depo '{$depo->nama_depo}' berhasil dihapus.");
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
            'panjang' => 'required|numeric|min:1|max:50',
            'lebar' => 'required|numeric|min:1|max:50',
            'tinggi' => 'required|numeric|min:1|max:10',
        ]);

        $panjang = $validatedData['panjang'];
        $lebar = $validatedData['lebar'];
        $tinggi = $validatedData['tinggi'];

        $sensorCount = $this->depoService->calculateSensorCount($panjang, $lebar);
        $espCount = $this->depoService->calculateEspCount($sensorCount);
        $maxVolume = $this->depoService->calculateMaxVolume($panjang, $lebar, $tinggi);

        return response()->json([
            'success' => true,
            'calculations' => [
                'jumlah_sensor' => $sensorCount,
                'jumlah_esp' => $espCount,
                'volume_maksimal' => $maxVolume,
                'area_coverage' => $panjang * $lebar,
            ],
        ]);
    }

    /**
     * API BARU: Mengambil data volume real-time untuk semua depo.
     */
    public function getRealtimeVolumes()
    {
        $volumes = Depo::where('is_active', true)
                       ->get(['id', 'persentase_volume', 'volume_saat_ini', 'volume_maksimal', 'status', 'updated_at']);
        
        return response()->json($volumes);
    }
}
