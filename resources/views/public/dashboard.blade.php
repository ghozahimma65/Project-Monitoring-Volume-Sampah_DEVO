<?php
// resources/views/public/dashboard.blade.php
?>
@extends('layouts.app')

@section('title', 'Dashboard Monitoring Depo Sampah')

@section('content')
<div class="container">
    <!-- Hero Section with Real-time Stats -->
    <div class="hero-section mb-5" data-aos="fade-up">
        <div class="hero-content text-center">
            <h1 class="hero-title heading-font">Dashboard Monitoring</h1>
            <p class="hero-subtitle">Sistem monitoring volume sampah real-time untuk pengelolaan yang lebih efektif</p>
            <div class="real-time-indicator justify-content-center">
                <div class="pulse-dot"></div>
                <span class="real-time-text">Live Data</span>
            </div>
        </div>
    </div>

    <!-- Enhanced Statistics Cards - Sama seperti Admin -->
    <div class="row mb-5" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="enhanced-stats-card primary-card" data-aos="zoom-in" data-aos-delay="200">
                <div class="stats-content">
                    <div class="stats-icon">
                        <i class="fas fa-warehouse"></i>
                        <div class="icon-bg"></div>
                    </div>
                    <div class="stats-info">
                        <h3 class="stats-number" data-counter="{{ $statistics['total_depo'] }}" id="total-depo">{{ $statistics['total_depo'] }}</h3>
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
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="enhanced-stats-card success-card" data-aos="zoom-in" data-aos-delay="300">
                <div class="stats-content">
                    <div class="stats-icon">
                        <i class="fas fa-check-circle"></i>
                        <div class="icon-bg"></div>
                    </div>
                    <div class="stats-info">
                        <h3 class="stats-number" data-counter="{{ $statistics['normal'] }}" id="normal-count">{{ $statistics['normal'] }}</h3>
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
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="enhanced-stats-card warning-card" data-aos="zoom-in" data-aos-delay="400">
                <div class="stats-content">
                    <div class="stats-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div class="icon-bg"></div>
                    </div>
                    <div class="stats-info">
                        <h3 class="stats-number" data-counter="{{ $statistics['warning'] }}" id="warning-count">{{ $statistics['warning'] }}</h3>
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
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="enhanced-stats-card danger-card" data-aos="zoom-in" data-aos-delay="500">
                <div class="stats-content">
                    <div class="stats-icon">
                        <i class="fas fa-times-circle"></i>
                        <div class="icon-bg"></div>
                    </div>
                    <div class="stats-info">
                        <h3 class="stats-number" data-counter="{{ $statistics['critical'] }}" id="critical-count">{{ $statistics['critical'] }}</h3>
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

    <!-- Enhanced Filter & Search Section - Layout Improved -->
    <div class="filter-search-section" data-aos="fade-up" data-aos-delay="200">
        <div class="filter-header">
            <h5 class="section-title">
                <i class="fas fa-sliders-h me-2"></i>Filter & Pencarian
            </h5>
            <div class="filter-actions">
                @if(request('status') || request('search'))
                    <button class="action-btn reset-btn" onclick="resetFilters()">
                        <i class="fas fa-undo me-2"></i>Reset Filter
                    </button>
                @endif
            </div>
        </div>
        
        <div class="filter-content">
            <!-- Filter Buttons Row -->
            <div class="filter-row">
                <div class="filter-group">
                    <label class="filter-label">Status Depo:</label>
                    <div class="filter-buttons">
                        <button class="filter-btn filter-btn-all {{ !request('status') || request('status') === 'all' ? 'active' : '' }}"
                                onclick="setFilter('status', 'all')">
                            <i class="fas fa-list me-2"></i>
                            <span>Semua</span>
                            <span class="filter-count" id="all-count">{{ $statistics['total_depo'] }}</span>
                        </button>
                        <button class="filter-btn filter-btn-normal {{ request('status') === 'normal' ? 'active' : '' }}"
                                onclick="setFilter('status', 'normal')">
                            <i class="fas fa-check-circle me-2"></i>
                            <span>Normal</span>
                            <span class="filter-count" id="normal-filter-count">{{ $statistics['normal'] }}</span>
                        </button>
                        <button class="filter-btn filter-btn-warning {{ request('status') === 'warning' ? 'active' : '' }}"
                                onclick="setFilter('status', 'warning')">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <span>Warning</span>
                            <span class="filter-count" id="warning-filter-count">{{ $statistics['warning'] }}</span>
                        </button>
                        <button class="filter-btn filter-btn-critical {{ request('status') === 'critical' ? 'active' : '' }}"
                                onclick="setFilter('status', 'critical')">
                            <i class="fas fa-times-circle me-2"></i>
                            <span>Critical</span>
                            <span class="filter-count" id="critical-filter-count">{{ $statistics['critical'] }}</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Search Row -->
            <div class="search-row">
                <div class="search-group">
                    <label class="filter-label">Pencarian:</label>
                    <div class="search-container">
                        <div class="search-input-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="search-input" class="search-input"
                                   placeholder="Cari nama depo atau lokasi..."
                                   value="{{ request('search') }}">
                            <button class="search-clear" id="search-clear" onclick="clearSearch()" style="display: {{ request('search') ? 'flex' : 'none' }};">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <button class="search-btn" onclick="applySearch()">
                            <i class="fas fa-search me-2"></i>
                            <span>Cari</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Depo Cards -->
    <div class="depo-grid" id="depo-container">
        @forelse($depos as $depo)
            <div class="depo-item" data-status="{{ $depo->status }}" data-name="{{ strtolower($depo->nama_depo) }}" data-location="{{ strtolower($depo->lokasi) }}">
                <div class="depo-card {{ $depo->status }}" data-depo-id="{{ $depo->id }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <!-- Card Header -->
                    <div class="depo-card-header">
                        <div class="depo-info">
                            <h5 class="depo-title">{{ $depo->nama_depo }}</h5>
                            <p class="depo-location">
                                <i class="fas fa-map-marker-alt me-1"></i>{{ $depo->lokasi }}
                            </p>
                        </div>
                        <div class="depo-status">
                            <span class="status-badge status-{{ $depo->status }}" id="status-badge-public-{{ $depo->id }}">
                                @if($depo->status === 'normal')
                                    <i class="fas fa-check-circle me-1"></i>Normal
                                @elseif($depo->status === 'warning')
                                    <i class="fas fa-exclamation-triangle me-1"></i>Warning
                                @else
                                    <i class="fas fa-times-circle me-1"></i>Critical
                                @endif
                            </span>
                            <div class="led-indicator {{ $depo->led_status ? 'led-on' : 'led-off' }}"
                                 title="LED Status: {{ $depo->led_status ? 'ON' : 'OFF' }}"></div>
                        </div>
                    </div>
                    
                    <!-- Volume Indicator -->
                    <div class="volume-section">
                        <div class="volume-header">
                            <span class="volume-label">Volume Sampah</span>
                            <span class="volume-percentage" id="volume-percentage-public-{{ $depo->id }}">{{ number_format($depo->persentase_volume, 1) }}%</span>
                        </div>
                        <div class="volume-progress">
                            <div class="progress-bar status-{{ $depo->status }}" id="progress-bar-public-{{ $depo->id }}" style="width: {{ $depo->persentase_volume }}%;"></div>
                        </div>
                    </div>

                    <!-- Depo Details -->
                    <div class="depo-details">
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-cube"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">Dimensi</span>
                                <span class="detail-value">{{ $depo->panjang }}×{{ $depo->lebar }}×{{ $depo->tinggi }}m</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Actions -->
                    <div class="depo-actions">
                        <a href="{{ route('depo.detail', $depo) }}" class="btn btn-primary btn-detail">
                            <i class="fas fa-eye me-2"></i>Lihat Detail
                            <i class="fas fa-arrow-right ms-auto"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state" data-aos="fade-up">
                <div class="empty-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h4>Tidak ada depo yang ditemukan</h4>
                <p class="text-muted">Silakan ubah filter atau kata kunci pencarian Anda.</p>
                <button class="btn btn-primary" onclick="resetFilters()">
                    <i class="fas fa-undo me-2"></i>Reset Filter
                </button>
            </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
    :root {
        --primary-color: #667eea;
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --danger-gradient: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        --dark-color: #1f2937;
        --border-radius: 12px;
        --border-radius-lg: 20px;
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 20px 60px rgba(0, 0, 0, 0.15);
        --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Hero Section */
    .hero-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        padding: 3rem 2rem;
        text-align: center;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1rem;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        color: #6b7280;
        margin-bottom: 1.5rem;
    }

    .real-time-indicator {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #059669;
        font-size: 0.95rem;
        font-weight: 600;
    }

    .pulse-dot {
        width: 10px;
        height: 10px;
        background: #059669;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    /* Enhanced Stats Cards - Same as Admin */
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

    /* Enhanced Filter & Search Section */
    .filter-search-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .filter-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .section-title {
        margin: 0;
        font-weight: 700;
        color: var(--dark-color);
        font-size: 1.2rem;
    }

    .filter-actions {
        display: flex;
        gap: 0.75rem;
    }

    .action-btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: var(--border-radius);
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: white;
        font-size: 0.85rem;
        font-weight: 500;
        transition: var(--transition);
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .filter-content {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .filter-row, .search-row {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .filter-group, .search-group {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .filter-label {
        font-weight: 600;
        color: var(--dark-color);
        font-size: 0.95rem;
    }

    .filter-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .filter-btn {
        padding: 1rem 1.5rem;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: var(--border-radius);
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        transition: var(--transition);
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--dark-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }

    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-color);
    }

    .filter-btn.active {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
        box-shadow: var(--shadow-md);
    }

    .filter-btn-normal.active {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .filter-btn-warning.active {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .filter-btn-critical.active {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .filter-count {
        background: rgba(255, 255, 255, 0.2);
        color: inherit;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        min-width: 24px;
        text-align: center;
    }

    .filter-btn:not(.active) .filter-count {
        background: var(--primary-color);
        color: white;
    }

    .search-container {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1;
        min-width: 0;
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        z-index: 1;
    }

    .search-input {
        width: 100%;
        padding: 1rem 1rem 1rem 2.75rem;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: var(--border-radius);
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        transition: var(--transition);
        font-size: 0.95rem;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        padding-right: 3rem;
    }

    .search-clear {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: #9ca3af;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.8rem;
    }

    .search-clear:hover {
        background: #6b7280;
    }

    .search-btn {
        padding: 1rem 1.5rem;
        border: none;
        border-radius: var(--border-radius);
        background: var(--primary-gradient);
        color: white;
        font-size: 0.95rem;
        font-weight: 500;
        transition: var(--transition);
        cursor: pointer;
        display: flex;
        align-items: center;
        white-space: nowrap;
        min-width: 120px;
        justify-content: center;
    }

    .search-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Enhanced Depo Grid */
    .depo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .depo-item {
        display: flex;
        flex-direction: column;
    }

    /* Enhanced Depo Cards */
    .depo-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: var(--transition);
        overflow: hidden;
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .depo-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: var(--shadow-xl);
    }

    .depo-card-header {
        padding: 1.5rem 1.5rem 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .depo-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--dark-color);
        margin: 0;
        line-height: 1.2;
    }

    .depo-location {
        color: #6b7280;
        margin: 0.5rem 0 0 0;
        font-size: 0.9rem;
    }

    .depo-status {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* Status Badge Colors */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        white-space: nowrap;
    }

    .status-badge.status-normal {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .status-badge.status-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }

    .status-badge.status-critical {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        animation: criticalPulse 2s infinite;
    }

    @keyframes criticalPulse {
        0%, 100% { transform: scale(1); box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3); }
        50% { transform: scale(1.05); box-shadow: 0 2px 15px rgba(239, 68, 68, 0.5); }
    }

    /* LED Indicator */
    .led-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        transition: var(--transition);
    }

    .led-indicator.led-on {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.6);
        animation: ledPulse 2s infinite;
    }

    .led-indicator.led-off {
        background: #9ca3af;
        box-shadow: none;
    }

    .led-indicator.led-critical {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 0 15px rgba(239, 68, 68, 0.8);
        animation: ledCriticalPulse 1s infinite;
    }

    @keyframes ledPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }

    @keyframes ledCriticalPulse {
        0%, 100% { 
            opacity: 1; 
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.8);
        }
        50% { 
            opacity: 0.7; 
            box-shadow: 0 0 25px rgba(239, 68, 68, 1);
        }
    }

    /* Volume Section */
    .volume-section {
        padding: 1rem 1.5rem;
        background: rgba(0, 0, 0, 0.02);
    }

    .volume-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .volume-label {
        font-weight: 600;
        color: var(--dark-color);
        font-size: 0.9rem;
    }

    .volume-percentage {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--dark-color);
    }

    /* Volume Progress Bar Colors */
    .volume-progress {
        height: 20px;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .volume-progress .progress-bar {
        height: 100%;
        border-radius: 8px;
        position: relative;
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    /* Progress Bar Colors Based on Status */
    .volume-progress .progress-bar.status-normal {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 0 15px rgba(16, 185, 129, 0.4);
    }

    .volume-progress .progress-bar.status-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.4);
    }

    .volume-progress .progress-bar.status-critical {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 0 15px rgba(239, 68, 68, 0.4);
        animation: criticalGlow 2s infinite;
    }

    @keyframes criticalGlow {
        0%, 100% {
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.4);
        }
        50% {
            box-shadow: 0 0 25px rgba(239, 68, 68, 0.7);
        }
    }

    /* Progress Bar Shimmer Effect */
    .volume-progress .progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(
            45deg,
            rgba(255, 255, 255, 0.3) 25%,
            transparent 25%,
            transparent 50%,
            rgba(255, 255, 255, 0.3) 50%,
            rgba(255, 255, 255, 0.3) 75%,
            transparent 75%
        );
        background-size: 20px 20px;
        animation: progressShimmer 2.5s linear infinite;
    }

    @keyframes progressShimmer {
        0% { transform: translateX(-20px); }
        100% { transform: translateX(20px); }
    }

    .volume-details {
        margin-top: 0.5rem;
        text-align: center;
    }

    .depo-details {
        padding: 1rem 1.5rem;
        flex: 1;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .detail-item:last-child {
        margin-bottom: 0;
    }

    .detail-icon {
        width: 40px;
        height: 40px;
        background: rgba(102, 126, 234, 0.1);
        color: var(--primary-color);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .detail-content {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .detail-label {
        font-size: 0.8rem;
        color: #6b7280;
        font-weight: 500;
    }

    .detail-value {
        font-size: 0.9rem;
        color: var(--dark-color);
        font-weight: 600;
    }

    .depo-actions {
        padding: 1.5rem;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .btn-detail {
        width: 100%;
        border-radius: var(--border-radius);
        padding: 0.75rem 1rem;
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
    }

    .btn-detail:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: white;
    }

    /* Empty State */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 4rem 2rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        background: rgba(102, 126, 234, 0.1);
        color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem auto;
        font-size: 3rem;
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

    /* Responsive Design */
    @media (max-width: 1200px) {
        .filter-buttons {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .depo-grid {
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1rem;
        }

        .enhanced-stats-card {
            height: auto;
            min-height: 180px;
            padding: 1.5rem;
        }

        .stats-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .stats-number {
            font-size: 2rem;
        }

        .filter-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .filter-content {
            padding: 1.5rem;
        }

        .filter-buttons {
            grid-template-columns: 1fr;
        }

        .search-container {
            flex-direction: column;
            align-items: stretch;
        }

        .search-btn {
            width: 100%;
        }

        .depo-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .volume-progress {
            height: 16px;
        }

        .volume-percentage {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 576px) {
        .hero-section {
            padding: 2rem 1rem;
        }

        .hero-title {
            font-size: 2rem;
        }

        .filter-search-section {
            margin: 0 -1rem 2rem -1rem;
            border-radius: 0;
        }

        .filter-header,
        .filter-content {
            padding: 1rem;
        }

        .enhanced-stats-card {
            padding: 1rem;
            height: auto;
        }

        .stats-icon {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }

        .stats-number {
            font-size: 1.8rem;
        }

        .depo-grid {
            margin: 0 -1rem;
        }

        .depo-card {
            margin: 0 1rem;
        }
    }
</style>
@endpush
@push('scripts')
<script>
function setFilter(type, value) {
    // bikin url base tanpa query lama
    let baseUrl = window.location.origin + window.location.pathname;

    if (type === 'status' && value !== 'all') {
        window.location.href = baseUrl + '?status=' + value;
    } else {
        window.location.href = baseUrl; // kalau all balik ke / tanpa query
    }
}
</script>

<script>
function updateDepoCardUI(depoData) {
    const depoId = depoData.id;
    const percentage = parseFloat(depoData.persentase_volume);
    const status = depoData.status;

    // Cari elemen berdasarkan ID unik
    const percentageElement = document.getElementById(`volume-percentage-public-${depoId}`);
    const progressBarElement = document.getElementById(`progress-bar-public-${depoId}`);
    const statusBadgeElement = document.getElementById(`status-badge-public-${depoId}`);
    const cardElement = document.querySelector(`.depo-item[data-depo-id="${depoId}"] .depo-card`);

    if (percentageElement) {
        percentageElement.textContent = `${percentage.toFixed(1)}%`;
    }

    if (progressBarElement) {
        progressBarElement.style.width = `${percentage}%`;
        progressBarElement.className = `progress-bar status-${status}`;
    }

    if (statusBadgeElement) {
        let icon = 'fa-check-circle';
        if (status === 'warning') icon = 'fa-exclamation-triangle';
        if (status === 'critical') icon = 'fa-times-circle';
        statusBadgeElement.innerHTML = `<i class="fas ${icon} me-1"></i>${status.charAt(0).toUpperCase() + status.slice(1)}`;
        statusBadgeElement.className = `status-badge status-${status}`;
    }
    
    if (cardElement) {
        cardElement.className = `depo-card ${status}`;
    }
}
async function refreshAllDepoCards() {
    try {
        const url = new URL('{{ route("public.realtime.volumes") }}', window.location.origin);
        if (currentStatus && currentStatus !== 'all') {
            url.searchParams.set('status', currentStatus);
        }
        if (currentSearch) {
            url.searchParams.set('search', currentSearch);
        }
        const response = await fetch(url.toString());
    } catch (error) {
        console.warn('Gagal mengambil data volume publik:', error);
    }
}


document.addEventListener('DOMContentLoaded', function() {
    // Jalankan fungsi baru
    refreshAllDepoCards();
    setInterval(refreshAllDepoCards, 10000);
    

// Global variables for filtering
let currentStatus = '{{ request("status") ?? "all" }}';
let currentSearch = '{{ request("search") ?? "" }}';

// Filter functions
function setFilter(type, value) {
    const url = new URL(window.location.origin + window.location.pathname);

    if (type === 'status' && value !== 'all') {
        url.searchParams.set('status', value);
    }

    window.location.href = url.toString();
}


function applySearch() {
    const searchInput = document.getElementById('search-input');
    const searchValue = searchInput.value.trim();
   
    const url = new URL(window.location);
    if (searchValue) {
        url.searchParams.set('search', searchValue);
    } else {
        url.searchParams.delete('search');
    }
   
    window.location.href = url.toString();
}

function clearSearch() {
    const searchInput = document.getElementById('search-input');
    searchInput.value = '';
    document.getElementById('search-clear').style.display = 'none';
    
    const url = new URL(window.location);
    url.searchParams.delete('search');
    window.location.href = url.toString();
}

function resetFilters() {
    window.location.href = window.location.pathname; // ⬅️ clear semua query string
}

// Search input events
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const searchClear = document.getElementById('search-clear');
    
    // Show/hide clear button based on input value
    searchInput.addEventListener('input', function() {
        if (this.value.trim()) {
            searchClear.style.display = 'flex';
        } else {
            searchClear.style.display = 'none';
        }
    });
    
    // Search on Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applySearch();
        }
    });
});

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

// Function to update LED status based on volume
function updateLEDStatus(depoCard, percentage) {
    const ledIndicator = depoCard.querySelector('.led-indicator');
    if (ledIndicator) {
        if (percentage > 90) {
            ledIndicator.className = 'led-indicator led-critical';
            ledIndicator.title = 'LED Status: CRITICAL - ON';
        } else {
            ledIndicator.className = 'led-indicator led-on';
            ledIndicator.title = 'LED Status: ON';
        }
    }
}

// Function to update status badge based on volume
function updateStatusBadge(depoCard, status) {
    const statusBadge = depoCard.querySelector('.status-badge');
    if (statusBadge) {
        statusBadge.className = `status-badge status-${status}`;
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
function updateProgressBar(depoCard, percentage, status) {
    const progressBar = depoCard.querySelector('.volume-progress .progress-bar');
    if (progressBar) {
        progressBar.className = `progress-bar status-${status}`;
        progressBar.style.width = percentage + '%';
    }
}

// Function to count depos by status and update statistics
function updateStatisticsCards() {
    const depoItems = document.querySelectorAll('.depo-item');
    let counts = {
        total: 0,
        normal: 0,
        warning: 0,
        critical: 0
    };

    depoItems.forEach(item => {
        const volumePercentageElement = item.querySelector('.volume-percentage');
        if (volumePercentageElement) {
            const percentageText = volumePercentageElement.textContent;
            const percentage = parseFloat(percentageText.replace('%', ''));
            
            if (!isNaN(percentage)) {
                counts.total++;
                const status = getStatusFromVolume(percentage);
                counts[status]++;
            }
        }
    });

    // Update the statistics cards
    const totalDepoElement = document.getElementById('total-depo');
    const normalCountElement = document.getElementById('normal-count');
    const warningCountElement = document.getElementById('warning-count');
    const criticalCountElement = document.getElementById('critical-count');

    if (totalDepoElement) totalDepoElement.textContent = counts.total;
    if (normalCountElement) normalCountElement.textContent = counts.normal;
    if (warningCountElement) warningCountElement.textContent = counts.warning;
    if (criticalCountElement) criticalCountElement.textContent = counts.critical;

    // Update progress bars in statistics
    const normalProgress = document.getElementById('normal-progress');
    const warningProgress = document.getElementById('warning-progress');
    const criticalProgress = document.getElementById('critical-progress');

    if (counts.total > 0) {
        if (normalProgress) normalProgress.style.width = (counts.normal / counts.total * 100) + '%';
        if (warningProgress) warningProgress.style.width = (counts.warning / counts.total * 100) + '%';
        if (criticalProgress) criticalProgress.style.width = (counts.critical / counts.total * 100) + '%';
    }

    // Update percentage displays in stats cards
    const normalPercentageElement = document.getElementById('normal-percentage');
    const warningPercentageElement = document.getElementById('warning-percentage');
    const criticalPercentageElement = document.getElementById('critical-percentage');

    if (normalPercentageElement) normalPercentageElement.textContent = (counts.normal / counts.total * 100).toFixed(1) + '%';
    if (warningPercentageElement) warningPercentageElement.textContent = (counts.warning / counts.total * 100).toFixed(1) + '%';
    if (criticalPercentageElement) criticalPercentageElement.textContent = (counts.critical / counts.total * 100).toFixed(1) + '%';

    // Update filter button counts
    const allCountElement = document.getElementById('all-count');
    const normalFilterCountElement = document.getElementById('normal-filter-count');
    const warningFilterCountElement = document.getElementById('warning-filter-count');
    const criticalFilterCountElement = document.getElementById('critical-filter-count');

    if (allCountElement) allCountElement.textContent = counts.total;
    if (normalFilterCountElement) normalFilterCountElement.textContent = counts.normal;
    if (warningFilterCountElement) warningFilterCountElement.textContent = counts.warning;
    if (criticalFilterCountElement) criticalFilterCountElement.textContent = counts.critical;
}

// Function to animate counters
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

// Function to fetch volume data from API
async function fetchVolume() {
    try {
const response = await fetch('{{ url("/api/latest-volume") }}');
        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();
        const volume = parseFloat(data.volume).toFixed(1);

        // Update all volume displ ays
        const volumePercentageElements = document.querySelectorAll('.volume-percentage');
        volumePercentageElements.forEach(element => {
            element.textContent = `${volume}%`;
        });

        // Update all depo cards based on new volume
        const depoCards = document.querySelectorAll('.depo-card');
        depoCards.forEach(depoCard => {
            const percentage = parseFloat(volume);
            const status = getStatusFromVolume(percentage);
            
            // Update depo item status attribute
            const depoItem = depoCard.closest('.depo-item');
            if (depoItem) {
                depoItem.setAttribute('data-status', status);
            }

            // Update depo card class
            depoCard.className = depoCard.className.replace(/\b(normal|warning|critical)\b/, status);

            // Update status badge
            updateStatusBadge(depoCard, status);

            // Update progress bar
            updateProgressBar(depoCard, percentage, status);

            // Update LED status
            updateLEDStatus(depoCard, percentage);
        });

        // Update statistics cards
        updateStatisticsCards();

    } catch (error) {
        console.error('Gagal mengambil data volume:', error);
    }
}

// Update progress bar from span (for initial load)
function updateProgressBarFromSpan() {
    const depoCards = document.querySelectorAll('.depo-card');
    
    depoCards.forEach(depoCard => {
        const percentageElement = depoCard.querySelector('.volume-percentage');
        if (percentageElement) {
            const percentageText = percentageElement.textContent;
            const percentage = parseFloat(percentageText.replace('%', '').trim());

            if (!isNaN(percentage)) {
                const status = getStatusFromVolume(percentage);
                
                // Update depo item status attribute
                const depoItem = depoCard.closest('.depo-item');
                if (depoItem) {
                    depoItem.setAttribute('data-status', status);
                }

                // Update depo card class
                depoCard.className = depoCard.className.replace(/\b(normal|warning|critical)\b/, status);

                // Update status badge
                updateStatusBadge(depoCard, status);

                // Update progress bar
                updateProgressBar(depoCard, percentage, status);

                // Update LED status
                updateLEDStatus(depoCard, percentage);
            }
        }
    });

    // Update statistics after updating all cards
    updateStatisticsCards();
}

// Notification function
function showNotification(message, type) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
   
    document.body.appendChild(toast);
   
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 5000);
}

// Initialize animations
function initializeAnimations() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 600,
            easing: 'ease-out-cubic',
            once: true
        });
    }
   
    const cards = document.querySelectorAll('.depo-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set initial volume display and update status
    updateProgressBarFromSpan();
    
    // Initialize animations
    initializeAnimations();
    
    // Animate counters on load
    setTimeout(animateCounters, 500);
    
    // Fetch volume data immediately
    fetchVolume();
    
    // Set up intervals
    setInterval(fetchVolume, 1000); // Update every 1 second
    
    // Add smooth scrolling for page navigation
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const parallax = document.querySelector('.hero-section');
        if (parallax) {
            const speed = scrolled * 0.3;
            parallax.style.transform = `translateY(${speed}px)`;
        }
    });
});

// Function to send sensor data (example)
function sendSensorData(sensorData) {
    fetch('/api/v1/sensor-data', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(sensorData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Data berhasil dikirim:', data);
        updateDashboard(data);
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Gagal mengirim data sensor: ' + error.message, 'error');
    });
}

// Function to update dashboard
function updateDashboard(data) {
    if(data.success) {
        showNotification('Data sensor berhasil diperbarui', 'success');
        fetchVolume(); // Refresh data
    }
}
</script>
@endpush


@endsection