<?php
// resources/views/admin/depos/index.blade.php
?>
@extends('layouts.admin')

@section('title', 'Kelola Depo - Admin DEVO')
@section('page-title', 'Kelola Depo')

@section('content')
<!-- Header Section -->
<div class="header-section mb-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-1">
                        <i class="fas fa-warehouse me-2 text-primary"></i>Daftar Depo
                    </h4>
                    <p class="card-text text-muted mb-0">Kelola dan monitor semua depo sampah</p>
                </div>
                <a href="{{ route('admin.depos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Depo Baru
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Depo List -->
<div class="card shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>Data Depo
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="depos-table">
                <thead class="table-light">
                    <tr>
                        <th>Nama Depo</th>
                        <th>Lokasi</th>
                        <th>Dimensi</th>
                        <th>Volume</th>
                        <th>Status</th>
                        <th>Sensor/ESP</th>
                        <th>Update Terakhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($depos as $depo)
                        <tr data-depo-id="{{ $depo->id }}" class="depo-row">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="depo-icon me-3">
                                        <i class="fas fa-cube text-primary"></i>
                                    </div>
                                    <div>
                                        <strong class="text-dark">{{ $depo->nama_depo }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                {{ $depo->lokasi }}
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $depo->panjang }}×{{ $depo->lebar }}×{{ $depo->tinggi }}</span>
                            </td>
                            <td>
                                <div class="volume-container">
                                    <div class="progress volume-progress mb-1" style="height: 20px;">
                                        <div class="progress-bar volume-bar status-normal" 
                                             role="progressbar" 
                                             style="width: 0%"
                                             aria-valuenow="0" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100"
                                             id="progress-bar-{{ $depo->id }}">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="volume-percentage text-dark fw-bold" id="volume-percentage-{{ $depo->id }}">0%</span>
                                        <small class="text-muted volume-details" id="volume-details-{{ $depo->id }}">
                                            0 / {{ number_format($depo->panjang * $depo->lebar * $depo->tinggi, 2) }} m³
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge status-badge status-normal" id="status-badge-{{ $depo->id }}">
                                    <i class="fas fa-check-circle me-1"></i>Normal
                                </span>
                            </td>
                            <td>
                                <div class="tech-info">
                                    <div class="mb-1">
                                        <i class="fas fa-satellite-dish text-info me-1"></i> 
                                        <span class="fw-semibold">{{ $depo->jumlah_sensor }}</span> sensors
                                    </div>
                                    <div>
                                        <i class="fas fa-microchip text-warning me-1"></i> 
                                        <span class="fw-semibold">{{ $depo->jumlah_esp }}</span> ESP32
                                    </div>
                                </div>
                            </td>
                            <td class="last-updated" data-updated="{{ $depo->updated_at->timestamp }}">
                                <small class="text-muted">{{ $depo->updated_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.depos.show', $depo) }}" class="btn btn-outline-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.depos.edit', $depo) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-outline-danger" onclick="confirmDelete({{ $depo->id }}, '{{ $depo->nama_depo }}')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada depo yang terdaftar</h5>
                                    <p class="text-muted mb-3">Mulai dengan menambahkan depo pertama Anda</p>
                                    <a href="{{ route('admin.depos.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Tambah Depo Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('styles')
<style>
    .header-section .card {
        border-radius: 12px;
        border: none;
    }
    
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }
    
    .card-header {
        border-radius: 12px 12px 0 0 !important;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        padding: 1.25rem 1.5rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .depo-icon {
        width: 40px;
        height: 40px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .volume-container {
        min-width: 200px;
    }
    
    .volume-progress {
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .volume-bar {
        border-radius: 10px;
        transition: width 0.5s ease;
    }
    
    .volume-bar.status-normal {
        background-color: #10b981;
    }
    
    .volume-bar.status-warning {
        background-color: #f59e0b;
    }
    
    .volume-bar.status-critical {
        background-color: #ef4444;
    }
    
    .volume-percentage {
        font-size: 0.95rem;
    }
    
    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }
    
    .status-badge.status-normal {
        background-color: #10b981;
        color: white;
    }
    
    .status-badge.status-warning {
        background-color: #f59e0b;
        color: white;
    }
    
    .status-badge.status-critical {
        background-color: #ef4444;
        color: white;
    }
    
    .tech-info {
        font-size: 0.85rem;
    }
    
    .tech-info i {
        width: 16px;
    }
    
    .empty-state {
        padding: 2rem;
    }
    
    .btn-group-sm .btn {
        padding: 0.375rem 0.5rem;
        border-radius: 6px;
    }
    
    .table th {
        font-weight: 600;
        color: #374151;
        border-bottom: 2px solid #e5e7eb;
        padding: 1rem 0.75rem;
    }
    
    .table td {
        padding: 1rem 0.75rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    
    /* Notification style */
    .custom-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        max-width: 400px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border: none;
        overflow: hidden;
    }
    
    .notification-success {
        background-color: #1e40af;
        color: white;
    }
    
    .notification-error {
        background-color: #b91c1c;
        color: white;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .volume-container {
            min-width: 150px;
        }
        
        .tech-info {
            font-size: 0.8rem;
        }
        
        .btn-group-sm .btn {
            padding: 0.25rem 0.4rem;
        }
    }
</style>
@endpush

@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Global variables to store data
let depoData = {};

// Function to get status based on percentage
function getStatusFromVolume(percentage) {
    if (percentage >= 0 && percentage <= 80) {
        return 'normal';
    } else if (percentage > 80 && percentage <= 90) {
        return 'warning';
    } else if (percentage > 90 && percentage <= 100) {
        return 'critical';
    }
    return 'normal'; // default
}

// Function to update status badge based on volume
function updateStatusBadge(depoId, status) {
    const statusBadge = document.getElementById(`status-badge-${depoId}`);
    if (statusBadge) {
        statusBadge.className = `badge status-badge status-${status}`;
        if (status === 'normal') {
            statusBadge.innerHTML = '<i class="fas fa-check-circle me-1"></i>Normal';
        } else if (status === 'warning') {
            statusBadge.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Warning';
        } else {
            statusBadge.innerHTML = '<i class="fas fa-times-circle me-1"></i>Critical';
        }
    }
}

// Function to update progress bar based on status
function updateProgressBar(depoId, percentage, status) {
    const progressBar = document.getElementById(`progress-bar-${depoId}`);
    if (progressBar) {
        progressBar.className = `progress-bar volume-bar status-${status}`;
        progressBar.style.width = percentage + '%';
        progressBar.setAttribute('aria-valuenow', percentage);
    }
}

// Function to fetch volume from API
async function fetchVolume() {
    try {
        const response = await fetch('http://172.16.100.106:8000/api/latest-volume');
        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();
        const volume = parseFloat(data.volume).toFixed(1);
        const newPercentage = parseFloat(volume);
        
        // Update all depo cards with the same volume
        const depoRows = document.querySelectorAll('.depo-row');
        depoRows.forEach(row => {
            const depoId = row.getAttribute('data-depo-id');
            updateDepoVolume(depoId, newPercentage);
        });
        
    } catch (error) {
        console.error('Gagal mengambil data volume:', error);
    }
}

// Function to update depo volume display
function updateDepoVolume(depoId, percentage) {
    const status = getStatusFromVolume(percentage);
    
    // Update progress bar
    updateProgressBar(depoId, percentage, status);
    
    // Update percentage display
    const percentageDisplay = document.getElementById(`volume-percentage-${depoId}`);
    if (percentageDisplay) {
        percentageDisplay.textContent = `${percentage}%`;
    }
    
    // Update status badge
    updateStatusBadge(depoId, status);
    
    // Update volume details
    const volumeDetails = document.getElementById(`volume-details-${depoId}`);
    if (volumeDetails) {
        // Calculate current volume based on percentage and max volume
        const maxVolumeText = volumeDetails.textContent.split(' / ')[1];
        if (maxVolumeText) {
            const maxVolume = parseFloat(maxVolumeText.replace(' m³', ''));
            const currentVolume = (percentage / 100) * maxVolume;
            volumeDetails.textContent = `${currentVolume.toFixed(2)} / ${maxVolume.toFixed(2)} m³`;
        }
    }
    
    // Update last updated time
    const row = document.querySelector(`tr[data-depo-id="${depoId}"]`);
    if (row) {
        const lastUpdated = row.querySelector('.last-updated');
        if (lastUpdated) {
            const now = new Date();
            lastUpdated.innerHTML = '<small class="text-muted">Baru saja</small>';
            lastUpdated.setAttribute('data-updated', Math.floor(now.getTime() / 1000));
        }
    }
}

// Function to update progress bar from span
function updateProgressBarFromSpan() {
    const depoRows = document.querySelectorAll('.depo-row');
    
    depoRows.forEach(row => {
        const depoId = row.getAttribute('data-depo-id');
        const percentageElement = document.getElementById(`volume-percentage-${depoId}`);
        
        if (percentageElement) {
            const percentageText = percentageElement.textContent;
            const percentage = parseFloat(percentageText.replace('%', '').trim());

            if (!isNaN(percentage)) {
                const status = getStatusFromVolume(percentage);
                
                // Update status badge
                updateStatusBadge(depoId, status);

                // Update progress bar
                updateProgressBar(depoId, percentage, status);
            }
        }
    });
}

// Enhanced delete confirmation function
function confirmDelete(depoId, depoName) {
    Swal.fire({
        title: 'Konfirmasi Hapus Depo',
        html: `
            <div style="text-align: left;">
                <p>Apakah Anda yakin ingin menghapus depo berikut?</p>
                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin: 1rem 0;">
                    <strong>Nama Depo:</strong> ${depoName}<br>
                    <strong>ID:</strong> ${depoId}
                </div>
                <div style="color: #dc3545; font-size: 0.9rem;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan. 
                    Semua data terkait depo ini akan dihapus secara permanen.
                </div>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus Depo',
        cancelButtonText: '<i class="fas fa-times me-2"></i>Batal',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return deleteDepo(depoId);
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            showNotification('Depo berhasil dihapus dari database', 'success');
        }
    });
}

// Function to delete depo from database
async function deleteDepo(depoId) {
    try {
        // Show loading state
        const row = document.querySelector(`tr[data-depo-id="${depoId}"]`);
        if (row) {
            row.style.opacity = '0.5';
            row.style.pointerEvents = 'none';
        }
        
        // Send delete request
        const response = await fetch(`{{ url('/admin/depos') }}/${depoId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin'
        });
        
        // Handle response
        let result;
        const contentType = response.headers.get('content-type');
        
        if (contentType && contentType.includes('application/json')) {
            result = await response.json();
        } else {
            const textResponse = await response.text();
            console.error('Non-JSON response:', textResponse);
            throw new Error('Server mengembalikan respons yang tidak valid. Periksa log server.');
        }
        
        if (response.ok && result.success) {
            // Remove row from table
            if (row) {
                row.remove();
                
                // Check if table is empty
                const remainingRows = document.querySelectorAll('.depo-row');
                if (remainingRows.length === 0) {
                    location.reload();
                }
            }
            
            return true;
        } else {
            throw new Error(result.message || 'Gagal menghapus depo');
        }
        
    } catch (error) {
        console.error('Error deleting depo:', error);
        
        // Restore row state
        const row = document.querySelector(`tr[data-depo-id="${depoId}"]`);
        if (row) {
            row.style.opacity = '1';
            row.style.pointerEvents = 'auto';
        }
        
        showNotification('Gagal menghapus depo: ' + error.message, 'error');
        return false;
    }
}

// Helper function to format relative time
function formatRelativeTime(seconds) {
    const intervals = {
        tahun: 31536000,
        bulan: 2592000,
        minggu: 604800,
        hari: 86400,
        jam: 3600,
        menit: 60,
        detik: 1
    };
    
    for (const [unit, secondsInUnit] of Object.entries(intervals)) {
        const interval = Math.floor(seconds / secondsInUnit);
        if (interval >= 1) {
            return interval === 1 ? `1 ${unit} yang lalu` : `${interval} ${unit} yang lalu`;
        }
    }
    return 'Baru saja';
}

// Initialize relative time updates
function updateRelativeTimes() {
    const lastUpdatedElements = document.querySelectorAll('.last-updated');
    lastUpdatedElements.forEach(element => {
        const updatedTime = parseInt(element.getAttribute('data-updated'));
        if (!isNaN(updatedTime)) {
            const now = Math.floor(Date.now() / 1000);
            const seconds = now - updatedTime;
            element.innerHTML = `<small class="text-muted">${formatRelativeTime(seconds)}</small>`;
        }
    });
}

// Initialize volume display from existing data
function initializeVolumeDisplay() {
    const depoRows = document.querySelectorAll('.depo-row');
    depoRows.forEach(row => {
        const depoId = row.getAttribute('data-depo-id');
        const volumeDetails = document.getElementById(`volume-details-${depoId}`);
        
        if (volumeDetails) {
            const maxVolumeText = volumeDetails.textContent.split(' / ')[1];
            if (maxVolumeText) {
                const maxVolume = parseFloat(maxVolumeText.replace(' m³', ''));
                // Set initial volume to 0
                updateDepoVolume(depoId, 0);
            }
        }
    });
}

// Notification function
function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `custom-notification ${type === 'success' ? 'notification-success' : 'notification-error'}`;
    
    // Notification content
    notification.innerHTML = `
        <div class="d-flex align-items-center p-3">
            <div class="flex-shrink-0 me-3">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} fa-lg"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-1">${type === 'success' ? 'Berhasil' : 'Error'}</h6>
                <p class="mb-0 small">${message}</p>
            </div>
            <button type="button" class="btn-close btn-close-white" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;
    
    // Add to document
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize relative time updates
    updateRelativeTimes();
    
    // Update relative times every minute
    setInterval(updateRelativeTimes, 60000);
    
    // Set initial volume display and update status
    updateProgressBarFromSpan();
    
    // Initialize volume display
    initializeVolumeDisplay();
    
    // Fetch initial volume data
    fetchVolume();
    
    // Auto refresh every 1 second
    setInterval(fetchVolume, 1000);
    
    console.log('Admin Dashboard initialized successfully');
});
</script>
@endpush
@endsection