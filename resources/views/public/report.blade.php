<?php
// resources/views/public/report.blade.php
?>
@extends('layouts.app')

@section('title', 'Sistem Laporan Depo')

@section('content')
<div class="container-fluid px-3">
    <!-- Header Section -->
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <div class="system-header" data-aos="fade-down">
                <div class="header-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h1 class="system-title">Sistem Laporan Depo</h1>
                <p class="system-subtitle">Sistem Pelaporan dan Monitoring Pengelolaan Sampah</p>
                
                <!-- Navigation Tabs -->
                <div class="nav-tabs-container">
                    <div class="nav-tabs-wrapper">
                        <button class="nav-tab active" data-tab="buat-laporan">
                            <i class="fas fa-edit me-2"></i>Buat Laporan
                        </button>
                        <button class="nav-tab" data-tab="tinjauan-laporan">
                            <i class="fas fa-list me-2"></i>Tinjauan Laporan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Buat Laporan Tab -->
    <div class="tab-content active" id="buat-laporan">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Report Form -->
                <div class="report-card-main" data-aos="fade-up">
                    <div class="report-card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-file-alt me-2"></i>Buat Laporan Baru
                        </h5>
                        <span class="badge bg-primary">Anonim</span>
                    </div>
                    <div class="report-card-body">
                        <form id="reportForm">
                            @csrf
                            
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-lg-6">
                                    <!-- Depo Selection -->
                                    <div class="form-group mb-4">
                                        <label for="depo_id" class="form-label">
                                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                            Pilih Depo <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select modern-select" name="depo_id" id="depo_id" required>
                                            <option value="">-- Pilih Depo --</option>
                                            @foreach($depos as $depo)
                                                <option value="{{ $depo->id }}" data-location="{{ $depo->lokasi }}">
                                                    {{ $depo->nama_depo }} - {{ $depo->lokasi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Date -->
                                    <div class="form-group mb-4">
                                        <label for="tanggal_laporan" class="form-label">
                                            <i class="fas fa-calendar me-2 text-primary"></i>
                                            Tanggal Kejadian <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control modern-input" name="tanggal_laporan" id="tanggal_laporan" 
                                               value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                                    </div>

                                    <!-- Category -->
                                    <div class="form-group mb-4">
                                        <label for="kategori" class="form-label">
                                            <i class="fas fa-tags me-2 text-primary"></i>
                                            Kategori Masalah <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select modern-select" name="kategori" id="kategori" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            <option value="overload">🗑️ Kelebihan Kapasitas</option>
                                            <option value="kerusakan_sensor">🔧 Kerusakan Sensor</option>
                                            <option value="sampah_berserakan">🧹 Sampah Berserakan</option>
                                            <option value="bau_tidak_sedap">💨 Bau Tidak Sedap</option>
                                            <option value="lainnya">📝 Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Right Column -->
                                <div class="col-lg-6">
                                    <!-- Description -->
                                    <div class="form-group mb-4">
                                        <label for="deskripsi" class="form-label">
                                            <i class="fas fa-comment-alt me-2 text-primary"></i>
                                            Deskripsi Masalah <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control modern-textarea" name="deskripsi" id="deskripsi" rows="8" 
                                                placeholder="Jelaskan secara detail masalah yang Anda temui...&#10;&#10;Contoh:&#10;- Waktu kejadian&#10;- Kondisi yang terlihat&#10;- Dampak yang dirasakan" required></textarea>
                                        <div class="form-text">
                                            <span id="char-count">0</span>/500 karakter (minimal 20 karakter)
                                        </div>
                                    </div>
                                    
                                    <!-- Guidelines Card -->
                                    <div class="guidelines-card">
                                        <h6 class="guidelines-title">
                                            <i class="fas fa-lightbulb me-2"></i>Tips Pelaporan
                                        </h6>
                                        <ul class="guidelines-list">
                                            <li>📋 Berikan deskripsi yang jelas dan detail</li>
                                            <li>⏰ Laporan akan ditinjau dalam 24 jam</li>
                                            <li>🔒 Identitas pelapor dijaga kerahasiaan</li>
                                            <li>📊 Pantau status laporan secara real-time</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="form-actions">
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo me-2"></i>Reset Form
                                </button>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tinjauan Laporan Tab -->
    <div class="tab-content" id="tinjauan-laporan">
        <div class="report-review-container" data-aos="fade-up">
            <!-- Filter Section -->
            <div class="review-header">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Tinjauan Laporan
                    </h5>
                    <div class="review-stats">
                        <span class="stat-item">
                            <i class="fas fa-clipboard-list me-1"></i>
                            Total: <span id="total-reports">0</span>
                        </span>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-4">
                        <select class="form-select" id="filter-status">
                            <option value="all">Semua Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="in_progress">Diproses</option>
                            <option value="resolved">Selesai</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="filter-kategori">
                            <option value="all">Semua Kategori</option>
                            <option value="overload">Kelebihan Kapasitas</option>
                            <option value="kerusakan_sensor">Kerusakan Sensor</option>
                            <option value="sampah_berserakan">Sampah Berserakan</option>
                            <option value="bau_tidak_sedap">Bau Tidak Sedap</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search-reports" placeholder="Cari laporan...">
                            <button class="btn btn-outline-secondary" type="button" id="btn-search">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading -->
            <div id="reports-loading" class="text-center py-5" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted">Memuat laporan...</p>
            </div>

            <!-- Reports List -->
            <div id="reports-container">
                <!-- Reports will be loaded here -->
            </div>

            <!-- Pagination -->
            <div id="pagination-container" class="d-flex justify-content-center mt-4">
                <!-- Pagination will be loaded here -->
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    :root {
        --primary-color: #2563eb;
        --primary-gradient: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
        --secondary-gradient: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
        --dark-color: #1f2937;
        --border-radius: 10px;
        --border-radius-lg: 15px;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* System Header - Improved Layout */
    .system-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        padding: 2.5rem 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
        text-align: center;
        margin-bottom: 2rem;
    }

    .system-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--secondary-gradient);
    }

    .header-icon {
        width: 80px;
        height: 80px;
        background: var(--secondary-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem auto;
        font-size: 2rem;
        color: white;
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.3);
    }

    .system-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
    }

    .system-subtitle {
        font-size: 1rem;
        color: #6b7280;
        margin-bottom: 1.5rem;
    }

    /* Navigation Tabs - Fixed Layout */
    .nav-tabs-container {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
    }

    .nav-tabs-wrapper {
        display: flex;
        background: rgba(255, 255, 255, 0.8);
        border-radius: var(--border-radius-lg);
        padding: 0.5rem;
        box-shadow: var(--shadow-sm);
        gap: 0.5rem;
    }

    .nav-tab {
        background: transparent;
        border: none;
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        color: #6b7280;
        transition: var(--transition);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        min-width: 180px;
    }

    .nav-tab.active {
        background: var(--primary-gradient);
        color: white;
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .nav-tab:hover:not(.active) {
        background: rgba(37, 99, 235, 0.1);
        color: var(--primary-color);
    }

    /* Tab Content */
    .tab-content {
        display: none;
        animation: fadeIn 0.5s ease-out;
    }

    .tab-content.active {
        display: block;
    }

    /* Report Card - Expanded */
    .report-card-main {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        margin-bottom: 2rem;
        width: 100%;
    }

    .report-card-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem;
        display: flex;
        justify-content: between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .report-card-header h5 {
        margin: 0;
        font-weight: 700;
        font-size: 1.25rem;
        flex: 1;
    }

    .report-card-body {
        padding: 2.5rem;
    }

    /* Form Elements */
    .form-group {
        position: relative;
    }

    .form-label {
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        font-size: 0.95rem;
    }

    .modern-select,
    .modern-input {
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: var(--border-radius);
        padding: 0.875rem 1rem;
        font-size: 0.95rem;
        transition: var(--transition);
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
    }

    .modern-select:focus,
    .modern-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: rgba(255, 255, 255, 1);
    }

    .modern-textarea {
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: var(--border-radius);
        padding: 1rem;
        font-size: 0.95rem;
        transition: var(--transition);
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        resize: vertical;
        min-height: 180px;
    }

    .modern-textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: rgba(255, 255, 255, 1);
    }

    .form-text {
        color: #6b7280;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    /* Guidelines Card */
    .guidelines-card {
        background: rgba(59, 130, 246, 0.05);
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .guidelines-title {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .guidelines-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .guidelines-list li {
        padding: 0.5rem 0;
        color: #374151;
        font-size: 0.9rem;
        border-bottom: 1px solid rgba(59, 130, 246, 0.1);
    }

    .guidelines-list li:last-child {
        border-bottom: none;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .btn {
        padding: 0.875rem 2rem;
        font-weight: 600;
        border-radius: var(--border-radius);
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 140px;
    }

    .btn-primary {
        background: var(--primary-gradient);
        border: none;
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-outline-secondary {
        border: 2px solid #6b7280;
        color: #6b7280;
        background: transparent;
    }

    .btn-outline-secondary:hover {
        background: #6b7280;
        color: white;
        transform: translateY(-2px);
    }

    /* Report Review Styles */
    .report-review-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 2rem;
        width: 100%;
    }

    .review-header h5 {
        color: var(--dark-color);
        font-weight: 700;
    }

    .review-stats {
        display: flex;
        gap: 1rem;
    }

    .stat-item {
        color: #6b7280;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .report-item {
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: var(--transition);
    }

    .report-item:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .report-id {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .report-date {
        color: #6b7280;
        font-size: 0.85rem;
    }

    .report-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.85rem;
    }

    .report-description {
        color: var(--dark-color);
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-in_progress {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-resolved {
        background: #d1fae5;
        color: #065f46;
    }

    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .category-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        background: rgba(37, 99, 235, 0.1);
        color: var(--primary-color);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .admin-response {
        background: #f0f9ff;
        border-left: 4px solid #0ea5e9;
        padding: 1rem;
        border-radius: 0 8px 8px 0;
        margin-top: 1rem;
    }

    .admin-response-header {
        color: #0369a1;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .admin-response-content {
        color: #374151;
        line-height: 1.5;
    }

    /* Character Counter */
    #char-count {
        font-weight: 600;
        color: var(--primary-color);
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .container-fluid {
            padding: 0 1rem;
        }
    }

    @media (max-width: 768px) {
        .system-title {
            font-size: 1.8rem;
        }

        .nav-tabs-wrapper {
            flex-direction: column;
            gap: 0.5rem;
        }

        .nav-tab {
            min-width: auto;
            width: 100%;
        }

        .report-card-body {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .system-header {
            padding: 2rem 1.5rem;
        }

        .report-meta {
            flex-direction: column;
            gap: 0.5rem;
        }

        .review-stats {
            flex-direction: column;
            gap: 0.5rem;
        }

        .report-card-header {
            flex-direction: column;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .system-header {
            padding: 1.5rem 1rem;
        }

        .system-title {
            font-size: 1.5rem;
        }

        .report-card-body {
            padding: 1rem;
        }

        .modern-textarea {
            min-height: 120px;
        }
    }

    /* Loading State */
    .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none !important;
    }

    /* Animation */
    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Pagination */
    .pagination {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .page-link {
        padding: 0.5rem 1rem;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: var(--border-radius);
        color: var(--primary-color);
        text-decoration: none;
        transition: var(--transition);
    }

    .page-link:hover {
        background: var(--primary-color);
        color: white;
    }

    .page-link.active {
        background: var(--primary-color);
        color: white;
    }

    /* Fix for navbar alignment */
    @media (max-width: 991.98px) {
        .navbar-toggler {
            margin-left: auto;
        }
        
        .navbar-brand {
            margin-right: auto;
        }
        
        .navbar-collapse {
            margin-top: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
// Global variables
let currentPage = 1;
let isLoading = false;

// Tab switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.nav-tab');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all tabs and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding content
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
            
            // Load reports when switching to tinjauan tab
            if (targetTab === 'tinjauan-laporan') {
                loadReports();
            }
        });
    });
    
    // Initialize filters
    initializeFilters();
});

// Character counter for description
document.getElementById('deskripsi').addEventListener('input', function() {
    const charCount = this.value.length;
    const counter = document.getElementById('char-count');
    counter.textContent = charCount;
    
    if (charCount < 20) {
        counter.style.color = '#ef4444';
    } else if (charCount > 450) {
        counter.style.color = '#f59e0b';
    } else {
        counter.style.color = 'var(--primary-color)';
    }
});

// Form validation
function validateForm() {
    const deskripsi = document.getElementById('deskripsi').value;
    const depo = document.getElementById('depo_id').value;
    const kategori = document.getElementById('kategori').value;
    const tanggal = document.getElementById('tanggal_laporan').value;
    
    if (!depo) {
        Swal.fire('Error', 'Silakan pilih depo terlebih dahulu', 'error');
        return false;
    }
    
    if (!tanggal) {
        Swal.fire('Error', 'Silakan isi tanggal kejadian', 'error');
        return false;
    }
    
    if (!kategori) {
        Swal.fire('Error', 'Silakan pilih kategori masalah', 'error');
        return false;
    }
    
    if (deskripsi.length < 20) {
        Swal.fire('Error', 'Deskripsi masalah minimal 20 karakter', 'error');
        return false;
    }
    
    if (deskripsi.length > 500) {
        Swal.fire('Error', 'Deskripsi masalah maksimal 500 karakter', 'error');
        return false;
    }
    
    return true;
}

// Form submission
document.getElementById('reportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!validateForm()) {
        return;
    }
    
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim Laporan...';
    
    const formData = new FormData(this);
    
    fetch('{{ route("report.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(async response => {
        const data = await response.json();
        if (!response.ok) {
            throw new Error(data.message || 'Gagal mengirim laporan');
        }
        return data;
    })
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Laporan Berhasil Dikirim!',
                html: `
                    <div class="text-start">
                        <div class="alert alert-success">
                            <h6><i class="fas fa-check-circle me-2"></i>Laporan Anda telah berhasil dikirim</h6>
                            <hr>
                            <p><strong>ID Laporan:</strong> <span class="badge bg-primary">#${data.report_id}</span></p>
                            <p><strong>Status:</strong> <span class="badge bg-warning">Menunggu Tinjauan</span></p>
                            <p class="mb-0"><strong>Estimasi Respons:</strong> 24 jam</p>
                        </div>
                        <p class="text-muted small mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Anda dapat melihat status laporan di halaman "Tinjauan Laporan"
                        </p>
                    </div>
                `,
                confirmButtonText: 'Lihat Tinjauan Laporan',
                showCancelButton: true,
                cancelButtonText: 'Tutup',
                confirmButtonColor: 'var(--primary-color)',
                customClass: {
                    popup: 'swal-wide'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Switch to tinjauan laporan tab
                    document.querySelector('[data-tab="tinjauan-laporan"]').click();
                } else {
                    // Reset form
                    document.getElementById('reportForm').reset();
                    document.getElementById('char-count').textContent = '0';
                    document.getElementById('char-count').style.color = 'var(--primary-color)';
                }
            });
        } else {
            throw new Error(data.message || 'Gagal mengirim laporan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal Mengirim Laporan',
            text: error.message || 'Terjadi kesalahan saat mengirim laporan. Silakan coba lagi.',
            confirmButtonColor: '#ef4444'
        });
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

// Reset form handler
document.querySelector('button[type="reset"]').addEventListener('click', function() {
    setTimeout(() => {
        document.getElementById('char-count').textContent = '0';
        document.getElementById('char-count').style.color = 'var(--primary-color)';
    }, 10);
});

// Reports loading functions
function initializeFilters() {
    const filterStatus = document.getElementById('filter-status');
    const filterKategori = document.getElementById('filter-kategori');
    const searchInput = document.getElementById('search-reports');
    const searchBtn = document.getElementById('btn-search');
    
    if (filterStatus) {
        filterStatus.addEventListener('change', () => {
            currentPage = 1;
            loadReports();
        });
    }
    
    if (filterKategori) {
        filterKategori.addEventListener('change', () => {
            currentPage = 1;
            loadReports();
        });
    }
    
    if (searchInput) {
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                currentPage = 1;
                loadReports();
            }
        });
    }
    
    if (searchBtn) {
        searchBtn.addEventListener('click', () => {
            currentPage = 1;
            loadReports();
        });
    }
}

function loadReports(page = 1) {
    if (isLoading) return;
    
    isLoading = true;
    currentPage = page;
    
    const loading = document.getElementById('reports-loading');
    const container = document.getElementById('reports-container');
    
    if (loading) loading.style.display = 'block';
    if (container) container.innerHTML = '';
    
    const params = new URLSearchParams({
        page: currentPage,
        status: document.getElementById('filter-status')?.value || 'all',
        kategori: document.getElementById('filter-kategori')?.value || 'all',
        search: document.getElementById('search-reports')?.value || ''
    });
    
    fetch(`{{ route('report.public.list') }}?${params}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayReports(data.data);
            updateStats(data.data);
        } else {
            throw new Error(data.message || 'Gagal memuat laporan');
        }
    })
    .catch(error => {
        console.error('Error loading reports:', error);
        if (container) {
            container.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h5>Gagal Memuat Laporan</h5>
                    <p>${error.message || 'Terjadi kesalahan saat memuat laporan'}</p>
                    <button class="btn btn-primary" onclick="loadReports()">
                        <i class="fas fa-redo me-2"></i>Coba Lagi
                    </button>
                </div>
            `;
        }
    })
    .finally(() => {
        isLoading = false;
        if (loading) loading.style.display = 'none';
    });
}

function displayReports(reportsData) {
    const container = document.getElementById('reports-container');
    const paginationContainer = document.getElementById('pagination-container');
    
    if (!container) return;
    
    if (reportsData.data.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-clipboard-list"></i>
                <h5>Belum Ada Laporan</h5>
                <p>Belum ada laporan yang ditemukan dengan filter yang dipilih.</p>
            </div>
        `;
        if (paginationContainer) paginationContainer.innerHTML = '';
        return;
    }
    
    let reportsHtml = '';
    reportsData.data.forEach(report => {
        const categoryNames = {
            'overload': 'Kelebihan Kapasitas',
            'kerusakan_sensor': 'Kerusakan Sensor',
            'sampah_berserakan': 'Sampah Berserakan',
            'bau_tidak_sedap': 'Bau Tidak Sedap',
            'lainnya': 'Lainnya'
        };
        
        const statusNames = {
            'pending': 'Menunggu',
            'in_progress': 'Diproses',
            'resolved': 'Selesai',
            'rejected': 'Ditolak'
        };
        
        reportsHtml += `
            <div class="report-item">
                <div class="report-header">
                    <div class="report-id">#${report.report_id}</div>
                    <div class="report-date">${formatDate(report.created_at)}</div>
                </div>
                <div class="report-meta">
                    <div class="meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>${report.depo.nama_depo} - ${report.depo.lokasi}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span>${formatDate(report.tanggal_laporan)}</span>
                    </div>
                    <div class="meta-item">
                        <span class="category-badge">${categoryNames[report.kategori] || report.kategori}</span>
                    </div>
                    <div class="meta-item">
                        <span class="status-badge status-${report.status}">${statusNames[report.status] || report.status}</span>
                    </div>
                </div>
                <div class="report-description">
                    ${report.deskripsi.length > 200 ? report.deskripsi.substring(0, 200) + '...' : report.deskripsi}
                </div>
                ${report.admin_response ? `
                    <div class="admin-response">
                        <div class="admin-response-header">
                            <i class="fas fa-reply me-2"></i>
                            <strong>Respons Admin:</strong>
                        </div>
                        <div class="admin-response-content">
                            ${report.admin_response}
                        </div>
                    </div>
                ` : ''}
            </div>
        `;
    });
    
    container.innerHTML = reportsHtml;
    
    // Generate pagination
    if (paginationContainer && reportsData.last_page > 1) {
        let paginationHtml = '<div class="pagination">';
        
        // Previous button
        if (reportsData.current_page > 1) {
            paginationHtml += `<a href="#" class="page-link" onclick="loadReports(${reportsData.current_page - 1}); return false;">‹ Prev</a>`;
        }
        
        // Page numbers
        const startPage = Math.max(1, reportsData.current_page - 2);
        const endPage = Math.min(reportsData.last_page, reportsData.current_page + 2);
        
        for (let i = startPage; i <= endPage; i++) {
            paginationHtml += `<a href="#" class="page-link ${i === reportsData.current_page ? 'active' : ''}" onclick="loadReports(${i}); return false;">${i}</a>`;
        }
        
        // Next button
        if (reportsData.current_page < reportsData.last_page) {
            paginationHtml += `<a href="#" class="page-link" onclick="loadReports(${reportsData.current_page + 1}); return false;">Next ›</a>`;
        }
        
        paginationHtml += '</div>';
        paginationContainer.innerHTML = paginationHtml;
    } else if (paginationContainer) {
        paginationContainer.innerHTML = '';
    }
}

function updateStats(reportsData) {
    const totalElement = document.getElementById('total-reports');
    if (totalElement) {
        totalElement.textContent = reportsData.total || 0;
    }
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Initialize AOS animations
document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 600,
            easing: 'ease-out-cubic',
            once: true
        });
    }
});
</script>
@endpush
@endsection