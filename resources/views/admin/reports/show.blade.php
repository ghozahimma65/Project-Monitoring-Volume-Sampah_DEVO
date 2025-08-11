<?php
// resources/views/admin/reports/show.blade.php
?>
@extends('layouts.admin')

@section('title', 'Detail Laporan #' . $report->id . ' - Admin DEVO')

@push('styles')
<style>
    .detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .detail-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .detail-card .card-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 1.5rem;
        border: none;
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-item:hover {
        background-color: rgba(102, 126, 234, 0.05);
    }

    .info-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: #374151;
        font-size: 1.2rem;
    }

    .info-content h6 {
        margin: 0;
        font-weight: 700;
        color: #374151;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-content .value {
        margin: 0.25rem 0 0 0;
        color: #1f2937;
        font-size: 1rem;
        font-weight: 600;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-in_progress { background: #dbeafe; color: #1e40af; }
    .status-resolved { background: #d1fae5; color: #065f46; }
    .status-rejected { background: #fee2e2; color: #991b1b; }

    .category-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: #374151;
        font-weight: 600;
    }

    .description-card {
        background: #f8fafc;
        border-radius: 12px;
        padding: 2rem;
        border-left: 4px solid #667eea;
    }

    .description-text {
        line-height: 1.7;
        color: #374151;
        font-size: 1rem;
        margin: 0;
    }

    .admin-response-card {
        background: #f0f9ff;
        border-radius: 12px;
        padding: 2rem;
        border-left: 4px solid #0ea5e9;
    }

    .response-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        color: #0369a1;
        font-weight: 700;
    }

    .response-text {
        line-height: 1.7;
        color: #374151;
        font-size: 1rem;
        margin: 0;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-back {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: white;
    }

    .btn-resolve {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-progress {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }

    .btn-reject {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .timeline {
        position: relative;
        padding: 1rem 0;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #667eea, #764ba2);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
        padding-left: 3rem;
    }

    .timeline-marker {
        position: absolute;
        left: 12px;
        top: 0.5rem;
        width: 16px;
        height: 16px;
        background: white;
        border: 3px solid #667eea;
        border-radius: 50%;
    }

    .timeline-content {
        background: rgba(255, 255, 255, 0.8);
        padding: 1.5rem;
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .depo-info-card {
        background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%);
        border-radius: 12px;
        padding: 1.5rem;
        color: #92400e;
    }

    .depo-info-card h6 {
        color: #78350f;
        margin-bottom: 0.5rem;
    }

    @media (max-width: 768px) {
        .detail-header {
            padding: 1.5rem;
            text-align: center;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-action {
            width: 100%;
            justify-content: center;
        }
        
        .info-item {
            flex-direction: column;
            text-align: center;
        }
        
        .info-icon {
            margin-right: 0;
            margin-bottom: 1rem;
        }
    }
</style>
@endpush

@section('content')

<div class="row">
    <!-- Main Information -->
    <div class="col-lg-8">
        <!-- Report Details -->
        <div class="detail-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Laporan
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-hashtag"></i>
                    </div>
                    <div class="info-content">
                        <h6>ID Laporan</h6>
                        <p class="value">#{{ $report->id }}</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="info-content">
                        <h6>Pelapor</h6>
                        <p class="value">
                            {{ $report->nama_pelapor ?: 'Anonim' }}
                            @if($report->email_pelapor)
                                <br><small class="text-muted">{{ $report->email_pelapor }}</small>
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="info-content">
                        <h6>Tanggal Kejadian</h6>
                        <p class="value">{{ \Carbon\Carbon::parse($report->tanggal_laporan)->format('d F Y') }}</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-content">
                        <h6>Dilaporkan</h6>
                        <p class="value">{{ $report->created_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="info-content">
                        <h6>Kategori</h6>
                        <p class="value">
                            <span class="category-badge">
                                {{ $report->kategori_text ?? ucfirst(str_replace('_', ' ', $report->kategori)) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="detail-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-comment-alt me-2"></i>Deskripsi Masalah
                </h5>
            </div>
            <div class="card-body">
                <div class="description-card">
                    <p class="description-text">{{ $report->deskripsi }}</p>
                </div>
            </div>
        </div>

        <!-- Admin Response -->
        @if($report->admin_response)
            <div class="detail-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-reply me-2"></i>Respons Admin
                    </h5>
                </div>
                <div class="card-body">
                    <div class="admin-response-card">
                        <div class="response-header">
                            <i class="fas fa-user-shield me-2"></i>
                            Respons dari Admin
                        </div>
                        <p class="response-text">{{ $report->admin_response }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Timeline -->
        <div class="detail-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>Timeline
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6 class="text-primary">Laporan Dibuat</h6>
                            <p class="mb-1">{{ $report->created_at->format('d F Y, H:i') }} WIB</p>
                            <small class="text-muted">Laporan diterima dari {{ $report->nama_pelapor ?: 'pengguna anonim' }}</small>
                        </div>
                    </div>
                    
                    @if($report->status !== 'pending')
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="text-info">Status Diperbarui</h6>
                                <p class="mb-1">{{ $report->updated_at->format('d F Y, H:i') }} WIB</p>
                                <small class="text-muted">
                                    Status diubah menjadi 
                                    <span class="status-badge status-{{ $report->status }} d-inline-block">
                                        {{ $report->status_text ?? ucfirst(str_replace('_', ' ', $report->status)) }}
                                    </span>
                                </small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Depo Information -->
        <div class="detail-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-map-marker-alt me-2"></i>Informasi Depo
                </h5>
            </div>
            <div class="card-body">
                <div class="depo-info-card">
                    <h6>{{ $report->depo->nama_depo }}</h6>
                    <p class="mb-2">
                        <i class="fas fa-location-dot me-2"></i>
                        {{ $report->depo->lokasi }}
                    </p>
                    @if($report->depo->kapasitas)
                        <p class="mb-2">
                            <i class="fas fa-weight-scale me-2"></i>
                            Kapasitas: {{ $report->depo->kapasitas }} kg
                        </p>
                    @endif
                    @if($report->depo->status)
                        <p class="mb-0">
                            <i class="fas fa-circle-info me-2"></i>
                            Status: {{ ucfirst($report->depo->status) }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="detail-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Statistik Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <h4 class="text-primary mb-1">{{ $report->created_at->diffInHours(now()) }}</h4>
                        <small class="text-muted">Jam yang lalu</small>
                    </div>
                    <div class="col-6 mb-3">
                        <h4 class="text-info mb-1">{{ strlen($report->deskripsi) }}</h4>
                        <small class="text-muted">Karakter deskripsi</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="detail-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>Aksi
                </h5>
            </div>
            <div class="card-body">
                <div class="action-buttons">
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-action btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                    
                    @if($report->status !== 'resolved')
                        <button class="btn btn-action btn-resolve" onclick="updateStatus({{ $report->id }}, 'resolved')">
                            <i class="fas fa-check"></i>
                            Selesai
                        </button>
                    @endif
                    
                    @if($report->status === 'pending')
                        <button class="btn btn-action btn-progress" onclick="updateStatus({{ $report->id }}, 'in_progress')">
                            <i class="fas fa-clock"></i>
                            In Progress
                        </button>
                        
                        <button class="btn btn-action btn-reject" onclick="updateStatus({{ $report->id }}, 'rejected')">
                            <i class="fas fa-times"></i>
                            Tolak
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateStatus(reportId, newStatus) {
    let title, text, confirmText, icon;
    
    switch(newStatus) {
        case 'resolved':
            title = 'Tandai Sebagai Selesai';
            text = 'Apakah masalah pada laporan ini sudah diselesaikan?';
            confirmText = 'Ya, Tandai Selesai';
            icon = 'success';
            break;
        case 'in_progress':
            title = 'Set In Progress';
            text = 'Tandai laporan ini sedang dalam penanganan?';
            confirmText = 'Ya, Set In Progress';
            icon = 'info';
            break;
        case 'rejected':
            title = 'Tolak Laporan';
            text = 'Apakah Anda yakin ingin menolak laporan ini?';
            confirmText = 'Ya, Tolak Laporan';
            icon = 'warning';
            break;
    }
    
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: 'Batal',
        confirmButtonColor: newStatus === 'resolved' ? '#10b981' : newStatus === 'in_progress' ? '#3b82f6' : '#ef4444',
        input: newStatus === 'resolved' || newStatus === 'rejected' ? 'textarea' : null,
        inputPlaceholder: newStatus === 'resolved' || newStatus === 'rejected' ? 'Catatan admin (opsional)' : null,
        inputAttributes: {
            'aria-label': 'Catatan admin'
        },
        showLoaderOnConfirm: true,
        preConfirm: (inputValue) => {
            return fetch(`/admin/reports/${reportId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: newStatus,
                    admin_response: inputValue || null
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
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
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: result.value.message || 'Gagal memperbarui status laporan',
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            }
        }
    });
}
</script>
@endpush
@endsection