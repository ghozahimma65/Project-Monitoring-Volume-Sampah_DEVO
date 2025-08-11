<?php
// app/Http/Controllers/Public/PublicReportController.php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Depo;
use App\Models\Report;
use App\Services\NotificationService;
use App\Events\NewReportSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PublicReportController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $depos = Depo::active()->orderBy('nama_depo')->get();
        return view('public.report', compact('depos'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'depo_id' => 'required|exists:depos,id',
            'tanggal_laporan' => 'required|date',
            'kategori' => 'required|in:overload,kerusakan_sensor,sampah_berserakan,bau_tidak_sedap,lainnya',
            'deskripsi' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Handle foto uploads
        $fotoFiles = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $foto) {
                $filename = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                $path = $foto->storeAs('reports', $filename, 'public');
                $fotoFiles[] = $path;
            }
        }

        // Create report
        $report = Report::create([
            'depo_id' => $request->depo_id,
            'nama_pelapor' => $request->nama_pelapor,
            'email_pelapor' => $request->email_pelapor,
            'no_telepon' => $request->no_telepon,
            'tanggal_laporan' => $request->tanggal_laporan,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoFiles,
        ]);

        // Send notification to admin
        $this->notificationService->createNewReportNotification($report);
        event(new NewReportSubmitted($report));

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim. Terima kasih atas partisipasi Anda.',
            'report_id' => $report->id,
        ]);
    }

    public function track()
    {
        return view('public.track-report');
    }

    public function getReportStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'report_id' => 'required|integer',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
            ], 422);
        }

        $report = Report::where('id', $request->report_id)
                       ->where('email_pelapor', $request->email)
                       ->with('depo')
                       ->first();

        if (!$report) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'report' => [
                'id' => $report->id,
                'depo_name' => $report->depo->nama_depo,
                'kategori' => $report->kategori_text,
                'tanggal_laporan' => $report->tanggal_laporan ? $report->tanggal_laporan->format('d/m/Y') : '',                'status' => $report->status_text,
                'status_color' => $report->status_color,
                'admin_response' => $report->admin_response,
                'resolved_at' => $report->resolved_at?->format('d/m/Y H:i'),
            ],
        ]);
    }
}

