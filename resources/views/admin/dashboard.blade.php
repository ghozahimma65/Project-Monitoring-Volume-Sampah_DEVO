<?php
// resources/views/admin/dashboard.blade.php
?>
@extends('layouts.admin')

@section('title', 'Admin Dashboard - DEVO')
@section('page-title', 'Dashboard Admin')

@section('content')
{{-- KARTU ALERT DEPO KRITIS (DIKONTROL OLEH JAVASCRIPT) --}}
<div class="row mb-4" id="critical-alert-section" style="display: none;">
    <div class="col-12">
        <div class="alert alert-danger alert-modern" data-aos="fade-up">
            <div class="alert-header">
                <div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="alert-content">
                    <h5>Depo Critical - Perlu Perhatian Segera!</h5>
                    <p class="mb-0"><span id="critical-depo-count">0</span> depo memerlukan tindakan segera</p>
                </div>
            </div>
            <div class="row mt-3" id="critical-depos-list">
                {{-- Bagian ini akan diisi oleh JavaScript --}}
            </div>
        </div>
    </div>
</div>



{{-- BLOK PERINGATAN (DENGAN ID UNIK DAN POSISI BENAR) --}}
@if($peringatan->isNotEmpty())
<div id="abnormal-warning-card" class="card shadow mb-4 border-left-danger" data-aos="fade-down">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-danger">
            <i class="fas fa-exclamation-triangle"></i>
            Peringatan Pembacaan Tidak Normal
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Nama Depo</th>
                        <th>Catatan</th>
                        <th style="width: 5%;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="warning-table-body">
                    @foreach($peringatan as $item)
                    <tr>
                        <td>{{ $item->created_at->diffForHumans() }}</td>
                        <td>{{ $item->depo->nama_depo }}</td>
                        <td>{{ $item->catatan }}</td>
                        <td>
                            <button onclick="acknowledgeWarning(this, {{ $item->id }})" class="btn btn-sm btn-success" title="Tandai sudah dibaca">
                                <i class="fas fa-check"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
{{-- AKHIR BLOK PERINGATAN --}}


<!-- Enhanced Quick Stats Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="enhanced-stats-card primary-card" data-aos="zoom-in" data-aos-delay="100">
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-warehouse"></i>
                    <div class="icon-bg"></div>
                </div>
                <div class="stats-info">
                    <h3 class="stats-number" data-counter="{{ $statistics['total_depo'] }}" id="total-depo-count">0</h3>
                    <p class="stats-label">Total Depo</p>
                    <small class="stats-subtitle">Depo Aktif</small>
                </div>
            </div>
            <div class="stats-progress">
                <div class="progress-line primary-gradient"></div>
            </div>
            <div class="stats-footer">
                <span class="trend-indicator positive">
                    <i class="fas fa-arrow-up"></i> 100%
                </span>
                <span class="trend-label">Beroperasi</span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="enhanced-stats-card success-card" data-aos="zoom-in" data-aos-delay="200">
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-check-circle"></i>
                    <div class="icon-bg"></div>
                </div>
                <div class="stats-info">
                    <h3 class="stats-number" data-counter="{{ $statistics['normal'] }}" id="normal-count">0</h3>
                    <p class="stats-label">Normal</p>
                    <small class="stats-subtitle">Kondisi Optimal</small>
                </div>
            </div>
            <div class="stats-progress">
                <div class="progress-line success-gradient" id="normal-progress" style="width: {{ $statistics['total_depo'] > 0 ? ($statistics['normal'] / $statistics['total_depo'] * 100) : 0 }}%;"></div>
            </div>
            <div class="stats-footer">
                <span class="trend-indicator positive">
                    <i class="fas fa-arrow-up"></i> <span id="normal-percentage">{{ $statistics['total_depo'] > 0 ? round($statistics['normal'] / $statistics['total_depo'] * 100, 1) : 0 }}%</span>
                </span>
                <span class="trend-label">Dari Total</span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="enhanced-stats-card warning-card" data-aos="zoom-in" data-aos-delay="300">
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div class="icon-bg"></div>
                </div>
                <div class="stats-info">
                    <h3 class="stats-number" data-counter="{{ $statistics['warning'] }}" id="warning-count">0</h3>
                    <p class="stats-label">Warning</p>
                    <small class="stats-subtitle">Perlu Perhatian</small>
                </div>
            </div>
            <div class="stats-progress">
                <div class="progress-line warning-gradient" id="warning-progress" style="width: {{ $statistics['total_depo'] > 0 ? ($statistics['warning'] / $statistics['total_depo'] * 100) : 0 }}%;"></div>
            </div>
            <div class="stats-footer">
                <span class="trend-indicator {{ $statistics['warning'] > 0 ? 'warning' : 'neutral' }}">
                    <i class="fas fa-{{ $statistics['warning'] > 0 ? 'exclamation' : 'minus' }}"></i> <span id="warning-percentage">{{ $statistics['total_depo'] > 0 ? round($statistics['warning'] / $statistics['total_depo'] * 100, 1) : 0 }}%</span>
                </span>
                <span class="trend-label">Dari Total</span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="enhanced-stats-card danger-card" data-aos="zoom-in" data-aos-delay="400">
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-times-circle"></i>
                    <div class="icon-bg"></div>
                </div>
                <div class="stats-info">
                    <h3 class="stats-number" data-counter="{{ $statistics['critical'] }}" id="critical-count">0</h3>
                    <p class="stats-label">Critical</p>
                    <small class="stats-subtitle">Tindakan Segera</small>
                </div>
            </div>
            <div class="stats-progress">
                <div class="progress-line danger-gradient" id="critical-progress" style="width: {{ $statistics['total_depo'] > 0 ? ($statistics['critical'] / $statistics['total_depo'] * 100) : 0 }}%;"></div>
            </div>
            <div class="stats-footer">
                <span class="trend-indicator {{ $statistics['critical'] > 0 ? 'negative' : 'neutral' }}">
                    <i class="fas fa-{{ $statistics['critical'] > 0 ? 'arrow-down' : 'minus' }}"></i> <span id="critical-percentage">{{ $statistics['total_depo'] > 0 ? round($statistics['critical'] / $statistics['total_depo'] * 100, 1) : 0 }}%</span>
                </span>
                <span class="trend-label">Dari Total</span>
            </div>
        </div>
    </div>
</div>

<!-- Critical Depos Alert (Dynamic) -->
<div class="row mb-4" id="critical-alert-section" style="display: none;">
    <div class="col-12">
        <div class="alert alert-danger alert-modern" data-aos="fade-up">
            <div class="alert-header">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="alert-content">
                    <h5>Depo Critical - Perlu Perhatian Segera!</h5>
                    <p class="mb-0"><span id="critical-depo-count">0</span> depo memerlukan tindakan segera</p>
                </div>
            </div>
            <div class="row mt-3" id="critical-depos-list">
                <!-- Critical depos will be populated dynamically -->
            </div>
        </div>
    </div>
</div>

<!-- Charts and Data -->
<div class="row mb-4">
    <!-- Status Distribution Chart -->
    <div class="col-md-6">
        <div class="chart-card" data-aos="fade-up" data-aos-delay="200">
            <div class="chart-header">
                <h5 class="chart-title">
                    <i class="fas fa-chart-pie me-2"></i>Distribusi Status Depo
                </h5>
                <div class="chart-actions">
                    <button class="btn btn-sm btn-outline-secondary" onclick="refreshChart('status')">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="statusChart" height="300"></canvas>
            </div>
        </div>
    </div>

<!-- Volume Real-time Chart -->
<div class="col-md-6">
    <div class="chart-card" data-aos="fade-up" data-aos-delay="300">
        <div class="chart-header">
            <h5 class="chart-title">
                <i class="fas fa-chart-bar me-2"></i>Volume Real-time (3 hari terakhir)
            </h5>
        </div>
        <!-- Bikin tinggi fix biar gak kepanjangan -->
        <div class="chart-body" style="height:350px;">
            <canvas id="volumeChart"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('volumeChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Hari 1", "Hari 2", "Hari 3"],
                datasets: [{
                    label: 'Volume (%)',
                    data: [75, 60, 85], // contoh data
                    borderColor: "rgba(54, 162, 235, 1)",
                    backgroundColor: "rgba(54, 162, 235, 0.2)",
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4,
                    pointBackgroundColor: "rgba(54, 162, 235, 1)"
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // biar ikut tinggi div
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: "Volume (%)"
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    });
</script>

<style>
    /* Tambahan biar rapet */
    .chart-card {
        margin-bottom: 20px; /* jarak ke bawah secukupnya */
    }
    #volumeChart {
        max-height: 250px; /* batasi tinggi canvas */
    }
</style>


<!-- Activity Section -->
<div class="row">
    <!-- Recent Reports -->
    <div class="col-md-7">
        <div class="activity-card" data-aos="fade-up" data-aos-delay="400">
            <div class="activity-header">
                <h5 class="activity-title">
                    <i class="fas fa-clipboard-list me-2"></i>Laporan Terbaru
                </h5>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-eye me-1"></i>Lihat Semua
                </a>
            </div>
            <div class="activity-body">
                @forelse($recentReports as $report)
                    <div class="report-item" data-aos="fade-in" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="report-avatar">
                            <i class="fas fa-{{ $report->kategori === 'overload' ? 'trash-alt' : ($report->kategori === 'kerusakan_sensor' ? 'wrench' : 'exclamation-triangle') }}"></i>
                        </div>
                        <div class="report-content">
                            <div class="report-header-info">
                                <h6 class="report-depo">{{ $report->depo->nama_depo }}</h6>
                                <span class="report-time">{{ $report->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="report-description">
                                {{ Str::limit($report->deskripsi, 80) }}
                            </p>
                            <div class="report-meta">
                                <span class="category-tag">{{ $report->kategori_text }}</span>
                                <span class="status-badge badge-{{ $report->status }}">{{ $report->status_text }}</span>
                            </div>
                        </div>
                        <div class="report-actions">
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-clipboard-list"></i>
                        <p>Tidak ada laporan terbaru</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Enhanced Quick Actions -->
    <div class="col-md-5">
        <div class="actions-card" data-aos="fade-up" data-aos-delay="500">
            <div class="actions-header">
                <h5 class="actions-title">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="actions-body">
                <div class="action-grid">
                    <a href="{{ route('admin.depos.create') }}" class="action-item primary">
                        <div class="action-icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="action-content">
                            <h6>Tambah Depo</h6>
                            <p>Buat depo baru</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.depos.index') }}" class="action-item info">
                        <div class="action-icon">
                            <i class="fas fa-warehouse"></i>
                        </div>
                        <div class="action-content">
                            <h6>Kelola Depo</h6>
                            <p>Manage semua depo</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.reports.index') }}" class="action-item warning">
                        <div class="action-icon">
                            <i class="fas fa-flag"></i>
                            {{-- @if($statistics['pending_reports'] > 0)
                                <span class="notification-badge">{{ $statistics['pending_reports'] }}</span>
                            @endif --}}
                        </div>
                        <div class="action-content">
                            <h6>Review Laporan</h6>
                            <p>Tinjau laporan masuk</p>
                        </div>
                    </a>
                    
                    <button class="action-item success" onclick="refreshDashboard()">
                        <div class="action-icon">
                            <i class="fas fa-sync-alt" id="refresh-icon"></i>
                        </div>
                        <div class="action-content">
                            <h6>Refresh Data</h6>
                            <p>Update informasi</p>
                        </div>
                    </button>
                </div>
                
                <!-- Enhanced System Status -->
                <div class="system-status">
                    <h6 class="status-title">System Performance</h6>
                    <div class="status-items">
                        <div class="status-item">
                            <div class="status-label">Database</div>
                            <div class="status-indicator active">
                                <div class="status-dot"></div>
                                <span>Optimal</span>
                            </div>
                        </div>
                        <div class="status-item">
                            <div class="status-label">Last Update</div>
                            <div class="status-value" id="last-update">
                                {{ now()->format('H:i:s') }}
                            </div>
                        </div>
                        <div class="status-item">
                            <div class="status-label">Active Users</div>
                            <div class="status-value">
                                <i class="fas fa-users me-1"></i>{{ $statistics['active_users'] ?? 1 }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Enhanced Stats Cards */
    .enhanced-stats-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .enhanced-stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, var(--card-gradient));
    }

    .enhanced-stats-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .primary-card {
        --card-gradient: #667eea 0%, #764ba2 100%;
    }

    .success-card {
        --card-gradient: #11998e 0%, #38ef7d 100%;
    }

    .warning-card {
        --card-gradient: #f3dc11 0%, #f5576c 100%;
    }

    .danger-card {
        --card-gradient: #ff6b6b 0%, #ee5a24 100%;
    }

    .stats-content {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        flex: 1;
    }

    .stats-icon {
        position: relative;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--card-gradient));
        color: white;
        font-size: 1.75rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .icon-bg {
        position: absolute;
        top: -10px;
        right: -10px;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    .stats-info {
        flex: 1;
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0 0 0.25rem 0;
        background: linear-gradient(135deg, var(--card-gradient));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stats-label {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
        color: var(--dark-color);
    }

    .stats-subtitle {
        color: #6b7280;
        font-size: 0.85rem;
    }

    .stats-progress {
        height: 6px;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 3px;
        margin: 1rem 0;
        overflow: hidden;
    }

    .progress-line {
        height: 100%;
        border-radius: 3px;
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        width: 100%;
    }

    .primary-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .success-gradient { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
    .warning-gradient { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .danger-gradient { background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); }

    .stats-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .trend-indicator {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .trend-indicator.positive { color: #059669; }
    .trend-indicator.negative { color: #dc2626; }
    .trend-indicator.warning { color: #d97706; }
    .trend-indicator.neutral { color: #6b7280; }

    .trend-label {
        color: #6b7280;
        font-size: 0.8rem;
    }

    /* Critical Alert */
    .alert-modern {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border: none;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(220, 38, 38, 0.1);
    }

    .alert-header {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .alert-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        animation: pulse 2s infinite;
    }

    .critical-depo-item {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .critical-depo-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .depo-name {
        font-weight: 600;
        color: var(--dark-color);
    }

    .depo-location {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .critical-badge {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        margin-right: 0.5rem;
    }

    /* Chart Cards */
    .chart-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .chart-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .chart-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .chart-title {
        margin: 0;
        font-weight: 700;
        color: var(--dark-color);
    }

    .real-time-indicator {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #059669;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        background: #059669;
        border-radius: 50%;
        animation: pulse 1.5s infinite;
    }

    .chart-body {
        padding: 2rem;
    }

    /* Activity Card */
    .activity-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        height: 100%;
    }

    .activity-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .activity-title {
        margin: 0;
        font-weight: 700;
        color: var(--dark-color);
    }

    .activity-body {
        padding: 1.5rem 2rem;
        max-height: 400px;
        overflow-y: auto;
    }

    .report-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        background: rgba(248, 250, 252, 0.5);
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .report-item:hover {
        background: rgba(248, 250, 252, 0.8);
        transform: translateX(4px);
    }

    .report-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .report-content {
        flex: 1;
        min-width: 0;
    }

    .report-header-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .report-depo {
        margin: 0;
        font-weight: 600;
        color: var(--dark-color);
        font-size: 0.95rem;
    }

    .report-time {
        font-size: 0.8rem;
        color: #6b7280;
    }

    .report-description {
        margin: 0 0 0.5rem 0;
        font-size: 0.85rem;
        color: #6b7280;
        line-height: 1.4;
    }

    .report-meta {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .category-tag {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-pending { background: #fef3c7; color: #92400e; }
    .badge-in_progress { background: #dbeafe; color: #1e40af; }
    .badge-resolved { background: #d1fae5; color: #065f46; }
    .badge-rejected { background: #fee2e2; color: #991b1b; }

    .report-actions {
        display: flex;
        align-items: center;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Actions Card */
    .actions-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        height: 100%;
    }

    .actions-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .actions-title {
        margin: 0;
        font-weight: 700;
        color: var(--dark-color);
    }

    .actions-body {
        padding: 1.5rem 2rem;
    }

    .action-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .action-item {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        padding: 1.5rem 1rem;
        background: rgba(248, 250, 252, 0.5);
        border: 2px solid transparent;
        border-radius: 16px;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        cursor: pointer;
    }

    .action-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border-color: var(--action-color);
        color: inherit;
        text-decoration: none;
    }

    .action-item.primary { --action-color: #667eea; }
    .action-item.info { --action-color: #06b6d4; }
    .action-item.warning { --action-color: #f59e0b; }
    .action-item.success { --action-color: #10b981; }

    .action-icon {
        position: relative;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--action-color), var(--action-color));
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin: 0 auto;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .notification-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc2626;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        animation: pulse 2s infinite;
    }

    .action-content {
        text-align: center;
    }

    .action-content h6 {
        margin: 0 0 0.25rem 0;
        font-weight: 600;
        color: var(--dark-color);
        font-size: 0.9rem;
    }

    .action-content p {
        margin: 0;
        font-size: 0.8rem;
        color: #6b7280;
    }

    /* System Status */
    .system-status {
        background: rgba(248, 250, 252, 0.5);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .status-title {
        margin: 0 0 1rem 0;
        font-weight: 600;
        color: var(--dark-color);
        font-size: 0.95rem;
    }

    .status-items {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .status-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .status-label {
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 500;
    }

    .status-indicator {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-indicator.active {
        color: #059669;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        background: #059669;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    .status-value {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--dark-color);
    }

    /* Animations */
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    @keyframes countUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .enhanced-stats-card {
            height: auto;
            min-height: 180px;
        }

        .stats-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .stats-number {
            font-size: 2rem;
        }

        .action-grid {
            grid-template-columns: 1fr;
        }

        .chart-header,
        .activity-header,
        .actions-header {
            padding: 1rem;
        }

        .chart-body,
        .activity-body,
        .actions-body {
            padding: 1rem;
        }

        .report-item {
            flex-direction: column;
            text-align: center;
        }

        .report-header-info {
            flex-direction: column;
            gap: 0.25rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
// FUNGSI BARU UNTUK MENGHILANGKAN PERINGATAN
function acknowledgeWarning(button, warningId) {
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;

    fetch(`/admin/warnings/${warningId}/acknowledge`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = button.closest('tr');
            row.style.transition = 'opacity 0.5s ease';
            row.style.opacity = '0';
            setTimeout(() => {
                row.remove();
                const tbody = document.querySelector('.warning-table-body');
                if (tbody && tbody.children.length === 0) {
                    const warningCard = document.querySelector('#abnormal-warning-card');
                    if(warningCard) {
                        warningCard.style.transition = 'all 0.5s ease';
                        warningCard.style.opacity = '0';
                        warningCard.style.transform = 'scale(0.95)';
                        setTimeout(() => warningCard.remove(), 500);
                    }
                }
            }, 500);
        } else {
            button.innerHTML = '<i class="fas fa-check"></i>';
            button.disabled = false;
            alert('Gagal menandai peringatan.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        button.innerHTML = '<i class="fas fa-check"></i>';
        button.disabled = false;
        alert('Terjadi kesalahan.');
    });
}

// SISA SCRIPT LAMA ANDA
// Global variables
let statusChart, volumeChart;
let realTimeData = {
    total: {{ $statistics['total_depo'] }},
    normal: 0,
    warning: 0,
    critical: 0,
    currentVolume: 0
};

// ... (sisa fungsi JavaScript Anda yang lain dari file asli) ...
// Function to determine status based on volume percentage
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

// Function to update statistics based on real-time volume
function updateStatisticsFromVolume(volumePercentage) {
    // Reset counts
    realTimeData.normal = 0;
    realTimeData.warning = 0;
    realTimeData.critical = 0;
    realTimeData.currentVolume = volumePercentage;

    // Determine status for all depos based on current volume
    const status = getStatusFromVolume(volumePercentage);
    
    if (status === 'normal') {
        realTimeData.normal = realTimeData.total;
    } else if (status === 'warning') {
        realTimeData.warning = realTimeData.total;
    } else {
        realTimeData.critical = realTimeData.total;
    }

    // Update DOM elements
    updateStatisticsDisplay();
}

// Function to update statistics display
function updateStatisticsDisplay() {
    const totalElement = document.getElementById('total-depo-count');
    const normalElement = document.getElementById('normal-count');
    const warningElement = document.getElementById('warning-count');
    const criticalElement = document.getElementById('critical-count');

    if (totalElement) {
        totalElement.textContent = realTimeData.total;
        totalElement.setAttribute('data-counter', realTimeData.total);
    }
    if (normalElement) {
        normalElement.textContent = realTimeData.normal;
        normalElement.setAttribute('data-counter', realTimeData.normal);
    }
    if (warningElement) {
        warningElement.textContent = realTimeData.warning;
        warningElement.setAttribute('data-counter', realTimeData.warning);
    }
    if (criticalElement) {
        criticalElement.textContent = realTimeData.critical;
        criticalElement.setAttribute('data-counter', realTimeData.critical);
    }

    const total = realTimeData.total;
    if (total > 0) {
        const normalProgress = document.getElementById('normal-progress');
        const warningProgress = document.getElementById('warning-progress');
        const criticalProgress = document.getElementById('critical-progress');

        if (normalProgress) normalProgress.style.width = (realTimeData.normal / total * 100) + '%';
        if (warningProgress) warningProgress.style.width = (realTimeData.warning / total * 100) + '%';
        if (criticalProgress) criticalProgress.style.width = (realTimeData.critical / total * 100) + '%';

        const normalPercentageElement = document.getElementById('normal-percentage');
        const warningPercentageElement = document.getElementById('warning-percentage');
        const criticalPercentageElement = document.getElementById('critical-percentage');

        if (normalPercentageElement) normalPercentageElement.textContent = (realTimeData.normal / total * 100).toFixed(1) + '%';
        if (warningPercentageElement) warningPercentageElement.textContent = (realTimeData.warning / total * 100).toFixed(1) + '%';
        if (criticalPercentageElement) criticalPercentageElement.textContent = (realTimeData.critical / total * 100).toFixed(1) + '%';
    }

    updateTrendIndicators();
    updateCriticalAlert();
    if (statusChart) updateStatusChart();
}

// Function to update trend indicators
function updateTrendIndicators() {
    const warningIcon = document.querySelector('.warning-card .trend-indicator i');
    const criticalIcon = document.querySelector('.danger-card .trend-indicator i');

    if (warningIcon) {
        if (realTimeData.warning > 0) {
            warningIcon.className = 'fas fa-exclamation';
            warningIcon.parentElement.className = 'trend-indicator warning';
        } else {
            warningIcon.className = 'fas fa-minus';
            warningIcon.parentElement.className = 'trend-indicator neutral';
        }
    }

    if (criticalIcon) {
        if (realTimeData.critical > 0) {
            criticalIcon.className = 'fas fa-arrow-down';
            criticalIcon.parentElement.className = 'trend-indicator negative';
        } else {
            criticalIcon.className = 'fas fa-minus';
            criticalIcon.parentElement.className = 'trend-indicator neutral';
        }
    }
}

// Function to update critical alert
function updateCriticalAlert() {
    const criticalSection = document.getElementById('critical-alert-section');
    const criticalCountElement = document.getElementById('critical-depo-count');
    const criticalListElement = document.getElementById('critical-depos-list');

    if (realTimeData.critical > 0) {
        criticalSection.style.display = 'block';
        if (criticalCountElement) criticalCountElement.textContent = realTimeData.critical;
        
        if (criticalListElement) {
            criticalListElement.innerHTML = '';
            for (let i = 1; i <= realTimeData.critical; i++) {
                const depoItem = `
                    <div class="col-md-4 mb-2">
                        <div class="critical-depo-item">
                            <div class="depo-info">
                                <div class="depo-name">Depo ${i}</div>
                                <div class="depo-location">Lokasi Depo ${i}</div>
                            </div>
                            <div class="depo-actions">
                                <span class="critical-badge">${realTimeData.currentVolume.toFixed(1)}%</span>
                            </div>
                        </div>
                    </div>
                `;
                criticalListElement.innerHTML += depoItem;
            }
        }
    } else {
        criticalSection.style.display = 'none';
    }
}

// Counter Animation
function animateCounters() {
    const counters = document.querySelectorAll('[data-counter]');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-counter'));
        const increment = target / 50;
        let current = 0;
        
        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.textContent = Math.ceil(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        
        updateCounter();
    });
}

// Status Distribution Chart
function initializeStatusChart() {
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Normal', 'Warning', 'Critical'],
            datasets: [{
                data: [
                        {{ $statistics['normal'] }}, 
                        {{ $statistics['warning'] }}, 
                        {{ $statistics['critical'] }}
],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: { size: 12, weight: 600 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                            return `${context.label}: ${context.raw} (${percentage}%)`;
                        }
                    }
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true,
                duration: 2000
            }
        }
    });
}

// Update Status Chart
function updateStatusChart() {
    if (statusChart) {
        statusChart.data.datasets[0].data = [realTimeData.normal, realTimeData.warning, realTimeData.critical];
        statusChart.update('active');
    }
}

// Real-time Volume Chart
function initializeVolumeChart() {
    const volumeCtx = document.getElementById('volumeChart').getContext('2d');
    volumeChart = new Chart(volumeCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Volume (%)',
                data: [],
                backgroundColor: [],
                borderWidth: 0,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: { display: true, text: 'Volume (%)', font: { size: 12, weight: 600 } },
                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: {
                    grid: { display: false },
                    ticks: { maxRotation: 45, font: { size: 11 } }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Volume: ${context.raw.toFixed(1)}%`;
                        }
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });
}

// Update volume chart with real-time data
async function refreshDashboardData() {
    try {
        const response = await fetch('{{ route("admin.dashboard.stats") }}');
        if (!response.ok) return;

        const data = await response.json();
        
        // 1. Update Kartu Statistik Utama
        const stats = data.statistics;
        document.getElementById('total-depo-count').textContent = stats.total_depo;
        document.getElementById('normal-count').textContent = stats.normal;
        document.getElementById('warning-count').textContent = stats.warning;
        document.getElementById('critical-count').textContent = stats.critical;
        
        const total = stats.total_depo;
        if (total > 0) {
            document.getElementById('normal-progress').style.width = (stats.normal / total * 100) + '%';
            document.getElementById('warning-progress').style.width = (stats.warning / total * 100) + '%';
            document.getElementById('critical-progress').style.width = (stats.critical / total * 100) + '%';
            document.getElementById('normal-percentage').textContent = (stats.normal / total * 100).toFixed(1) + '%';
            document.getElementById('warning-percentage').textContent = (stats.warning / total * 100).toFixed(1) + '%';
            document.getElementById('critical-percentage').textContent = (stats.critical / total * 100).toFixed(1) + '%';
        }

        // 2. Update Kartu Peringatan Depo Kritis
        const criticalDepos = data.critical_depos;
        const criticalSection = document.getElementById('critical-alert-section');
        const criticalCountElement = document.getElementById('critical-depo-count');
        const criticalListElement = document.getElementById('critical-depos-list');

        if (criticalDepos.length > 0) {
            criticalCountElement.textContent = criticalDepos.length;
            criticalListElement.innerHTML = '';

            criticalDepos.forEach(depo => {
                const depoItemHTML = `
                    <div class="col-md-4 mb-2">
                        <div class="critical-depo-item">
                            <div class="depo-info">
                                <div class="depo-name">${depo.nama_depo}</div>
                                <div class="depo-location">${depo.lokasi}</div>
                            </div>
                            <div class="depo-actions">
                                <span class="critical-badge">${parseFloat(depo.persentase_volume).toFixed(1)}%</span>
                            </div>
                        </div>
                    </div>
                `;
                criticalListElement.innerHTML += depoItemHTML;
            });

            criticalSection.style.display = 'block';
        } else {
            criticalSection.style.display = 'none';
        }

    } catch (error) {
        console.warn('Gagal me-refresh data dashboard:', error);
    }
}


// Refresh functions
function refreshChart(type) {
    const refreshBtn = event.target.closest('button');
    const icon = refreshBtn.querySelector('i');
    
    icon.classList.add('fa-spin');
    
    if (type === 'status') {
        setTimeout(() => {
            if (statusChart) {
                statusChart.update();
            }
            icon.classList.remove('fa-spin');
            showNotification('Chart refreshed successfully', 'success');
        }, 1000);
    }
}

function refreshDashboard() {
    const refreshIcon = document.getElementById('refresh-icon');
    refreshIcon.classList.add('fa-spin');
    
    Promise.all([
        updateVolumeChart(),
        fetch('/api/dashboard-stats').then(r => r.json()).catch(() => ({}))
    ]).then(() => {
        showNotification('Dashboard refreshed successfully', 'success');
        animateCounters();
    }).catch(error => {
        console.error('Error refreshing dashboard:', error);
        showNotification('Error refreshing dashboard', 'error');
    }).finally(() => {
        setTimeout(() => {
            refreshIcon.classList.remove('fa-spin');
        }, 1500);
    });
}

// Notification function
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
}

// Update last update time
function updateTime() {
    const timeElement = document.getElementById('last-update');
    if (timeElement) {
        timeElement.textContent = new Date().toLocaleTimeString('id-ID');
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // 1. Isi data ke variabel JavaScript TERLEBIH DAHULU
    const initialNormal = {{ $statistics['normal'] }};
    const initialWarning = {{ $statistics['warning'] }};
    const initialCritical = {{ $statistics['critical'] }};
    
    realTimeData.normal = initialNormal;
    realTimeData.warning = initialWarning;
    realTimeData.critical = initialCritical;

    // 2. BARU panggil fungsi untuk membuat chart
    refreshDashboardData(); 
    initializeStatusChart(); 
    initializeVolumeChart();
    
    // 3. Update tampilan lainnya
    updateStatisticsDisplay();
    setTimeout(animateCounters, 500);
    // ... sisa kodenya sama
});

// Real-time updates via WebSocket (if available)
if (typeof pusher !== 'undefined') {
    const channel = pusher.subscribe('admin-dashboard');
    
    channel.bind('stats-updated', function(data) {
        if (data.volume) {
            updateStatisticsFromVolume(parseFloat(data.volume));
            animateCounters();
        }
    });
    
    channel.bind('volume-updated', function(data) {
        updateVolumeChart();
    });
}
</script>
@endpush
@endsection