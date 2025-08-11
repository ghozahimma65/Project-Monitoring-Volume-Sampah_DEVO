<?php
// resources/views/admin/reports/index.blade.php
?>
@extends('layouts.admin')


@section('title', 'Kelola Laporan - Admin DEVO')
@section('page-title', 'Kelola Laporan')


@push('styles')
<style>
    .reports-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }


    .filter-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }


    .reports-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }


    .reports-card .card-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 1.5rem;
        border: none;
    }


    .modern-select, .modern-input {
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.9);
    }


    .modern-select:focus, .modern-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
    }


    .btn-filter {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }


    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }


    .btn-reset {
        background: linear-gradient(135deg, #6b7280 0%, #9ca3af 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }


    .btn-reset:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(107, 114, 128, 0.4);
        color: white;
    }


    .table-hover tbody tr {
        transition: all 0.3s ease;
    }


    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
        transform: scale(1.01);
    }


    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }


    .status-pending { background: #fef3c7; color: #92400e; }
    .status-in_progress { background: #dbeafe; color: #1e40af; }
    .status-resolved { background: #d1fae5; color: #065f46; }
    .status-rejected { background: #fee2e2; color: #991b1b; }


    .category-badge {
        padding: 0.3rem 0.6rem;
        border-radius: 15px;
        font-size: 0.75rem;
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: #374151;
        font-weight: 600;
    }


    .action-btn {
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        margin: 0 0.1rem;
        transition: all 0.3s ease;
        border: none;
    }


    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }


    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
    }


    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }


    .stats-badge {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
    }


    /* Perbaikan warna sesuai konsep */
    .btn-outline-primary {
        color: #667eea;
        border-color: #667eea;
    }
    
    .btn-outline-primary:hover {
        background-color: #667eea;
        border-color: #667eea;
        color: white;
    }
    
    .btn-outline-info {
        color: #1e40af;
        border-color: #1e40af;
    }
    
    .btn-outline-info:hover {
        background-color: #1e40af;
        border-color: #1e40af;
        color: white;
    }
    
    .btn-outline-success {
        color: #065f46;
        border-color: #065f46;
    }
    
    .btn-outline-success:hover {
        background-color: #065f46;
        border-color: #065f46;
        color: white;
    }
    
    .btn-outline-danger {
        color: #991b1b;
        border-color: #991b1b;
    }
    
    .btn-outline-danger:hover {
        background-color: #991b1b;
        border-color: #991b1b;
        color: white;
    }
    
    .btn-outline-warning {
        color: #92400e;
        border-color: #92400e;
    }
    
    .btn-outline-warning:hover {
        background-color: #92400e;
        border-color: #92400e;
        color: white;
    }


    @media (max-width: 768px) {
        .reports-header {
            padding: 1.5rem;
            text-align: center;
        }
        
        .table-responsive {
            border-radius: 10px;
        }
        
        .action-btn {
            margin: 0.1rem;
        }
    }
</style>
@endpush


@section('content')


<!-- Filter Section -->
<div class="filter-card">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-bold">
                    <i class="fas fa-flag me-1"></i>Status
                </label>
                <select name="status" class="form-select modern-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">
                    <i class="fas fa-tags me-1"></i>Kategori
                </label>
                <select name="kategori" class="form-select modern-select">
                    <option value="">Semua Kategori</option>
                    <option value="overload" {{ request('kategori') == 'overload' ? 'selected' : '' }}>Kelebihan Kapasitas</option>
                    <option value="kerusakan_sensor" {{ request('kategori') == 'kerusakan_sensor' ? 'selected' : '' }}>Kerusakan Sensor</option>
                    <option value="sampah_berserakan" {{ request('kategori') == 'sampah_berserakan' ? 'selected' : '' }}>Sampah Berserakan</option>
                    <option value="bau_tidak_sedap" {{ request('kategori') == 'bau_tidak_sedap' ? 'selected' : '' }}>Bau Tidak Sedap</option>
                    <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">
                    <i class="fas fa-search me-1"></i>Pencarian
                </label>
                <input type="text" name="search" class="form-control modern-input"
                       placeholder="Cari berdasarkan ID, nama depo, kategori..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-filter">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-reset btn-sm">
                        <i class="fas fa-times me-1"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Reports List -->
<div class="reports-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>Daftar Laporan
        </h5>
        <span class="stats-badge">{{ $reports->total() }} laporan</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="fw-bold">
                            <i class="fas fa-hashtag me-1"></i>ID
                        </th>
                        <th class="fw-bold">
                            <i class="fas fa-map-marker-alt me-1"></i>Depo
                        </th>
                        <th class="fw-bold">
                            <i class="fas fa-tags me-1"></i>Kategori
                        </th>
                        <th class="fw-bold">
                            <i class="fas fa-calendar me-1"></i>Tanggal
                        </th>
                        <th class="fw-bold">
                            <i class="fas fa-flag me-1"></i>Status
                        </th>
                        <th class="fw-bold text-center">
                            <i class="fas fa-cogs me-1"></i>Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td>
                                <span class="fw-bold text-primary">#{{ $report->id }}</span>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $report->depo->nama_depo }}</strong>
                                    <br><small class="text-muted">{{ $report->depo->lokasi }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="category-badge">
                                    {{ $report->kategori_text ?? ucfirst(str_replace('_', ' ', $report->kategori)) }}
                                </span>
                            </td>
                            <td>
                                <div>
                                    {{ \Carbon\Carbon::parse($report->tanggal_laporan)->format('d/m/Y') }}
                                    <br><small class="text-muted">{{ $report->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $report->status }}">
                                    {{ $report->status_text ?? ucfirst(str_replace('_', ' ', $report->status)) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <!-- Detail Button - Always Show -->
                                    <a href="{{ route('admin.reports.show', $report) }}"
                                       class="btn btn-outline-primary action-btn"
                                       title="Detail Laporan"
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-eye"></i>
                                    </a>


                                    <!-- Action buttons based on status -->
                                    @if($report->status === 'pending')
                                        <!-- For pending reports: show Setuju, In Progress, and Tolak -->
                                        <button class="btn btn-outline-success action-btn"
                                                onclick="updateStatus({{ $report->id }}, 'resolved')"
                                                title="Setuju & Tandai Selesai"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-outline-info action-btn"
                                                onclick="updateStatus({{ $report->id }}, 'in_progress')"
                                                title="Set In Progress"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-clock"></i>
                                        </button>
                                        <button class="btn btn-outline-danger action-btn"
                                                onclick="updateStatus({{ $report->id }}, 'rejected')"
                                                title="Tolak Laporan"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @elseif($report->status === 'in_progress')
                                        <!-- For in_progress reports: show Selesai and Tolak -->
                                        <button class="btn btn-outline-success action-btn"
                                                onclick="updateStatus({{ $report->id }}, 'resolved')"
                                                title="Tandai Selesai"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-outline-danger action-btn"
                                                onclick="updateStatus({{ $report->id }}, 'rejected')"
                                                title="Tolak Laporan"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @elseif($report->status === 'resolved')
                                        <!-- For resolved reports: show reopen option -->
                                        <button class="btn btn-outline-warning action-btn"
                                                onclick="updateStatus({{ $report->id }}, 'in_progress')"
                                                title="Buka Kembali"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    @elseif($report->status === 'rejected')
                                        <!-- For rejected reports: show reopen options -->
                                        <button class="btn btn-outline-success action-btn"
                                                onclick="updateStatus({{ $report->id }}, 'resolved')"
                                                title="Tandai Selesai"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-outline-info action-btn"
                                                onclick="updateStatus({{ $report->id }}, 'in_progress')"
                                                title="Set In Progress"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-clock"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <h5>Tidak ada laporan yang ditemukan</h5>
                                <p>Coba ubah filter pencarian atau buat laporan baru</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($reports->hasPages())
            <div class="p-3 border-top">
                <div class="d-flex justify-content-center">
                    {{ $reports->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});


function updateStatus(reportId, newStatus) {
    let title, text, confirmText, icon, confirmColor;
    
    switch(newStatus) {
        case 'resolved':
            title = 'Tandai Sebagai Selesai';
            text = 'Apakah masalah pada laporan ini sudah diselesaikan?';
            confirmText = 'Ya, Tandai Selesai';
            icon = 'success';
            confirmColor = '#065f46';
            break;
        case 'in_progress':
            title = 'Set In Progress';
            text = 'Tandai laporan ini sedang dalam penanganan?';
            confirmText = 'Ya, Set In Progress';
            icon = 'info';
            confirmColor = '#1e40af';
            break;
        case 'rejected':
            title = 'Tolak Laporan';
            text = 'Apakah Anda yakin ingin menolak laporan ini?';
            confirmText = 'Ya, Tolak Laporan';
            icon = 'warning';
            confirmColor = '#991b1b';
            break;
        default:
            title = 'Update Status';
            text = 'Apakah Anda yakin ingin mengubah status laporan ini?';
            confirmText = 'Ya, Update Status';
            icon = 'question';
            confirmColor = '#6b7280';
    }
    
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: 'Batal',
        confirmButtonColor: confirmColor,
        cancelButtonColor: '#6b7280',
        input: newStatus === 'resolved' || newStatus === 'rejected' ? 'textarea' : null,
        inputPlaceholder: newStatus === 'resolved' || newStatus === 'rejected' ? 'Catatan admin (opsional)' : null,
        showLoaderOnConfirm: true,
        preConfirm: (inputValue) => {
            const adminResponse = inputValue || '';
            
            // Buat form data untuk dikirim
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            formData.append('_method', 'PUT');
            formData.append('status', newStatus);
            formData.append('admin_response', adminResponse);
            
            return fetch(`/admin/reports/${reportId}/status`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.showValidationMessage('Terjadi kesalahan saat memperbarui status');
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            if (result.value.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: result.value.message || 'Status laporan berhasil diperbarui',
                    icon: 'success',
                    confirmButtonColor: '#065f46'
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: result.value.message || 'Gagal memperbarui status laporan',
                    icon: 'error',
                    confirmButtonColor: '#991b1b'
                });
            }
        }
    });
}
</script>
@endpush
@endsection



