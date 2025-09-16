<?php
// app/Http/Controllers/Admin/ReportController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Depo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Exception;

class ReportController extends Controller
{
    public function __construct()
    {
        // Tidak perlu middleware auth untuk public routes
    }

    // Method untuk menampilkan halaman public report
    public function create()
    {
        $depos = Depo::where('status', 'active')->orderBy('nama_depo')->get();
        return view('public.report', compact('depos'));
    }

    // Method untuk menyimpan laporan baru (yang dipanggil dari form)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'depo_id' => 'required|exists:depos,id',
            'tanggal_laporan' => 'required|date|before_or_equal:today',
            'kategori' => 'required|in:overload,kerusakan_sensor,sampah_berserakan,bau_tidak_sedap,lainnya',
            'deskripsi' => 'required|string|min:20|max:500',
        ], [
            'depo_id.required' => 'Silakan pilih depo',
            'depo_id.exists' => 'Depo yang dipilih tidak valid',
            'tanggal_laporan.required' => 'Tanggal laporan harus diisi',
            'tanggal_laporan.date' => 'Format tanggal tidak valid',
            'tanggal_laporan.before_or_equal' => 'Tanggal tidak boleh lebih dari hari ini',
            'kategori.required' => 'Silakan pilih kategori masalah',
            'kategori.in' => 'Kategori yang dipilih tidak valid',
            'deskripsi.required' => 'Deskripsi masalah harus diisi',
            'deskripsi.min' => 'Deskripsi minimal 20 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Generate unique report ID
            $reportId = 'RPT' . date('Ymd') . str_pad(Report::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);

            $report = Report::create([
                'report_id' => $reportId,
                'depo_id' => $request->depo_id,
                'tanggal_laporan' => $request->tanggal_laporan,
                'kategori' => $request->kategori,
                'deskripsi' => $request->deskripsi,
                'status' => 'pending',
            ]);

            // Log untuk admin (opsional)
            Log::info('New report created', [
                'report_id' => $reportId,
                'depo_id' => $request->depo_id,
                'kategori' => $request->kategori,
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil dikirim',
                'report_id' => $reportId,
                'data' => $report->load('depo'),
            ]);

        } catch (Exception $e) {
            Log::error('Error creating report: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan laporan. Silakan coba lagi.',
            ], 500);
        }
    }

    // Method untuk mengambil laporan publik (AJAX)
    public function getPublicReports(Request $request)
    {
        $query = Report::with('depo')->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('kategori') && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                  ->orWhere('report_id', 'like', "%{$search}%")
                  ->orWhereHas('depo', function($subQuery) use ($search) {
                      $subQuery->where('nama_depo', 'like', "%{$search}%");
                  });
            });
        }

        $reports = $query->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $reports,
        ]);
    }

    // Method untuk halaman admin (FIXED)
    public function index(Request $request)
    {
        $query = Report::with('depo');

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all' && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by kategori
        if ($request->filled('kategori') && $request->kategori !== 'all' && $request->kategori !== '') {
            $query->where('kategori', $request->kategori);
        }

        // Search functionality - disesuaikan dengan field yang ada
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhere('report_id', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhereHas('depo', function($depo) use ($search) {
                      $depo->where('nama_depo', 'like', '%' . $search . '%')
                           ->orWhere('lokasi', 'like', '%' . $search . '%');
                  });
            });
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(15);

        // Append query parameters to pagination links
        $reports->appends($request->query());

        return view('admin.reports.index', compact('reports'));
    }

    public function show(Report $report)
    {
        $report->load('depo');
        return view('admin.reports.show', compact('report'));
    }

    public function updateStatus(Request $request, Report $report)
    {
        try {
            // Log incoming request
            Log::info('Status update request received', [
                'report_id' => $report->id,
                'new_status' => $request->status,
                'admin_response' => $request->admin_response,
                'current_status' => $report->status
            ]);

            $validator = Validator::make($request->all(), [
                'status' => 'required|in:pending,in_progress,resolved,rejected',
                'admin_response' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed for status update', [
                    'report_id' => $report->id,
                    'errors' => $validator->errors()->toArray()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Cek apakah status yang diminta valid untuk transisi
            $allowedTransitions = [
                'pending' => ['in_progress', 'resolved', 'rejected'],
                'in_progress' => ['resolved', 'rejected'],
                'resolved' => ['in_progress'],
                'rejected' => ['in_progress', 'resolved']
            ];

            $currentStatus = $report->status;
            $newStatus = $request->status;

            if (!isset($allowedTransitions[$currentStatus]) || !in_array($newStatus, $allowedTransitions[$currentStatus])) {
                Log::warning('Invalid status transition attempted', [
                    'report_id' => $report->id,
                    'from_status' => $currentStatus,
                    'to_status' => $newStatus
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Transisi status tidak valid dari ' . $currentStatus . ' ke ' . $newStatus,
                ], 400);
            }
            

            // Update report
            $updateData = [
                'status' => $newStatus,
                'admin_response' => $request->admin_response,
            ];

            // Set resolved_at timestamp untuk status resolved/rejected
            if (in_array($newStatus, ['resolved', 'rejected'])) {
                $updateData['resolved_at'] = now();
            } else {
                $updateData['resolved_at'] = null;
            }

            $report->update($updateData);

            Log::info('Report status updated successfully', [
                'report_id' => $report->id,
                'from_status' => $currentStatus,
                'to_status' => $newStatus,
                'admin_response' => $request->admin_response
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status laporan berhasil diperbarui dari ' . $currentStatus . ' ke ' . $newStatus,
                'data' => [
                    'report_id' => $report->id,
                    'old_status' => $currentStatus,
                    'new_status' => $newStatus,
                    'updated_at' => $report->updated_at->format('d/m/Y H:i:s')
                ]
            ]);

        } catch (Exception $e) {
            Log::error('Error updating report status', [
                'report_id' => $report->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui status: ' . $e->getMessage(),
            ], 500);
        }
        
    }
}