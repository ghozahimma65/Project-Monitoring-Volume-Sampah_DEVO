<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Depo;
use App\Models\Report;
use App\Models\User;
// ====================================================================
// ===== PERBAIKAN UTAMA ADA DI SINI (ALAMAT FILE DIPERBAIKI)     =====
// ====================================================================
use App\Notifications\NewReportNotification; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicReportController extends Controller
{
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
            'nama_pelapor' => 'nullable|string|max:255',
            'email_pelapor' => 'nullable|email|max:255',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Buat laporan
        $report = Report::create($validator->validated());

        // Mengirim notifikasi hanya ke user dengan ID 1 (Admin Utama)
        $admin = User::find(1);
        if ($admin) {
            $admin->notify(new NewReportNotification($report));
        }

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim. Terima kasih atas partisipasi Anda.',
            'report_id' => $report->id,
        ]);
    }

    public function track()
    {
        $reports = Report::with('depo')->latest()->paginate(10);
        return view('public.report-list', compact('reports'));
    }

    public function getReportStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'report_id' => 'required|integer',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Data tidak valid'], 422);
        }

        $report = Report::where('id', $request->report_id)
                        ->where('email_pelapor', $request->email)
                        ->with('depo')
                        ->first();

        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Laporan tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'report' => [
                'id' => $report->id,
                'depo_name' => $report->depo->nama_depo,
                'kategori' => $report->kategori_text,
                'tanggal_laporan' => $report->tanggal_laporan ? $report->tanggal_laporan->format('d/m/Y') : '',
                'status' => $report->status_text,
                'status_color' => $report->status_color,
                'admin_response' => $report->admin_response,
                'resolved_at' => $report->resolved_at?->format('d/m/Y H:i'),
            ],
        ]);
    }
    public function getPublicReports()
{
    try {
        $reports = Report::with('depo')->latest()->paginate(10); //
        return response()->json([
            'success' => true,
            'data' => $reports
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}
