<?php
// app/Http/Controllers/Admin/DepoController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depo;
use App\Services\DepoCalculationService;
use App\Services\SensorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepoController extends Controller
{
    protected $depoService;
    protected $sensorService;

    public function __construct(DepoCalculationService $depoService, SensorService $sensorService)
    {
        // REMOVE middleware call - it's handled by routes
        $this->depoService = $depoService;
        $this->sensorService = $sensorService;
    }

    // ... rest of methods stay the same
    public function index()
    {
        $depos = Depo::all(); // Simplified to avoid relation issues
        return view('admin.depos.index', compact('depos'));
    }

    public function create()
    {
        return view('admin.depos.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_depo' => 'required|string|max:255',
            'lokasi' => 'required|string',
            'panjang' => 'required|numeric|min:1|max:50',
            'lebar' => 'required|numeric|min:1|max:50',
            'tinggi' => 'required|numeric|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $this->depoService->prepareDepoData($request->all());
        $depo = Depo::create($data);

        return redirect()->route('admin.depos.index')->with('success', 'Depo berhasil ditambahkan');
    }

    public function show(Depo $depo)
    {
        $sensorHealth = []; // Simplified for now
        $recentReadings = []; // Simplified for now  
        $estimatedFull = null; // Simplified for now

        return view('admin.depos.show', compact('depo', 'sensorHealth', 'recentReadings', 'estimatedFull'));
    }

    public function edit(Depo $depo)
    {
        return view('admin.depos.edit', compact('depo'));
    }

    public function update(Request $request, Depo $depo)
    {
        $validator = Validator::make($request->all(), [
            'nama_depo' => 'required|string|max:255',
            'lokasi' => 'required|string',
            'panjang' => 'required|numeric|min:1|max:50',
            'lebar' => 'required|numeric|min:1|max:50',
            'tinggi' => 'required|numeric|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $this->depoService->prepareDepoData($request->all());
        $depo->update($data);

        return redirect()->route('admin.depos.index')->with('success', 'Depo berhasil diperbarui');
    }

    // Method untuk nonaktifkan
    public function deactivate(Depo $depo)
    {
        $depo->update(['is_active' => false]);
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Depo berhasil dinonaktifkan'
            ]);
        }
        
        return redirect()->route('admin.depos.index')->with('success', 'Depo berhasil dinonaktifkan');
    }

    // Method untuk hapus permanen - FIXED
    public function destroy(Depo $depo)
    {
        try {
            $depoName = $depo->nama_depo;
            $depo->delete();
            
            // Handle AJAX requests
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Depo '{$depoName}' berhasil dihapus permanen"
                ]);
            }
            
            // Handle regular form submissions
            return redirect()->route('admin.depos.index')
                           ->with('success', "Depo '{$depoName}' berhasil dihapus permanen");
                           
        } catch (\Exception $e) {
            \Log::error('Error deleting depo: ' . $e->getMessage());
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus depo: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.depos.index')
                           ->with('error', 'Gagal menghapus depo: ' . $e->getMessage());
        }
    }

    public function previewCalculation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'panjang' => 'required|numeric|min:1|max:50',
            'lebar' => 'required|numeric|min:1|max:50',
            'tinggi' => 'required|numeric|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $sensorCount = $this->depoService->calculateSensorCount($request->panjang, $request->lebar);
        $espCount = $this->depoService->calculateEspCount($sensorCount);
        $maxVolume = $this->depoService->calculateMaxVolume($request->panjang, $request->lebar, $request->tinggi);

        return response()->json([
            'success' => true,
            'calculations' => [
                'jumlah_sensor' => $sensorCount,
                'jumlah_esp' => $espCount,
                'volume_maksimal' => $maxVolume,
                'area_coverage' => $request->panjang * $request->lebar,
                'sensor_per_esp' => min(4, $sensorCount),
            ],
        ]);
    }
    
}