<?php
// resources/views/public/depo-detail.blade.php
?>
@extends('layouts.app')

@section('title', $depo->nama_depo . ' - Detail Depo')

@section('content')
<div class="container">
    <!-- Enhanced Header Section -->
    <div class="detail-header mb-5" data-aos="fade-down">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb modern-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">
                                <i class="fas fa-home me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ $depo->nama_depo }}</li>
                    </ol>
                </nav>
                <div class="header-content">
                    <h1 class="page-title heading-font">{{ $depo->nama_depo }}</h1>
                    <p class="page-subtitle">
                        <i class="fas fa-map-marker-alt me-2"></i>{{ $depo->lokasi }}
                    </p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="header-actions">
                    <div class="status-display mb-3">
                        <span class="status-badge-large status-{{ $depo->status }}">
                            @if($depo->status === 'normal')
                                <i class="fas fa-check-circle me-2"></i>Normal
                            @elseif($depo->status === 'warning')
                                <i class="fas fa-exclamation-triangle me-2"></i>Warning
                            @else
                                <i class="fas fa-times-circle me-2"></i>Critical
                            @endif
                        </span>
                        <div class="led-indicator-large {{ $depo->led_status ? 'led-on' : 'led-off' }}" 
                             title="LED Status: {{ $depo->led_status ? 'ON' : 'OFF' }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Volume Status Section -->
    <div class="row mb-5">
        <div class="col-lg-6 mb-4">
            <div class="volume-card" data-aos="fade-right">
                <div class="volume-card-header">
                    <h5><i class="fas fa-tachometer-alt me-2"></i>Status Volume Saat Ini</h5>
                </div>
                <div class="volume-display">
                    <div class="gauge-container">
                        <canvas id="volumeGauge" width="250" height="250"></canvas>
                        <div class="gauge-center">
                            <div class="volume-percentage" id="volume-percentage">--%</div>
                            <div class="gauge-label">Volume</div>
                        </div> 
                    </div>
                </div>
                
                @if($estimatedFull)
                <div class="estimation-card">
                    <div class="estimation-header">
                        <i class="fas fa-clock me-2"></i>
                        <span class="fw-semibold">Estimasi Penuh</span>
                    </div>
                    <div class="estimation-content">
                        <div class="estimation-date">{{ $estimatedFull->format('d/m/Y H:i') }}</div>
                        <div class="estimation-time">{{ $estimatedFull->diffForHumans() }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="specs-card" data-aos="fade-left">
                <div class="specs-header">
                    <h5><i class="fas fa-info-circle me-2"></i>Spesifikasi Depo</h5>
                </div>
                <div class="specs-grid">
                    <div class="spec-item">
                        <div class="spec-icon">
                            <i class="fas fa-cube"></i>
                        </div>
                        <div class="spec-content">
                            <span class="spec-label">Dimensi</span>
                            <span class="spec-value">{{ $depo->panjang }} × {{ $depo->lebar }} × {{ $depo->tinggi }} m</span>
                        </div>
                    </div>
                    
                    <div class="spec-item">
                        <div class="spec-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="spec-content">
                            <span class="spec-label">Kapasitas Total</span>
                            <span class="spec-value">{{ number_format($depo->volume_maksimal, 2) }}</span>
                        </div>
                    </div>
                    
                    <div class="spec-item">
                        <div class="spec-icon">
                            <i class="fas fa-satellite-dish"></i>
                        </div>
                        <div class="spec-content">
                            <span class="spec-label">Sensor</span>
                            <span class="spec-value">{{ $depo->jumlah_sensor }} unit</span>
                        </div>
                    </div>
                    
                    <div class="spec-item">
                        <div class="spec-icon">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <div class="spec-content">
                            <span class="spec-label">ESP32 Controller</span>
                            <span class="spec-value">{{ $depo->jumlah_esp }} unit</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Chart Section -->
    <div class="chart-section" data-aos="fade-up">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <h5><i class="fas fa-chart-line me-2"></i>Grafik Volume Real-time</h5>
                    <p class="chart-subtitle">Monitoring trend volume sampah dalam periode waktu</p>
                </div>
                <div class="chart-controls">
                    <div class="period-selector">
                        <button class="period-btn active" data-period="hourly">
                            <i class="fas fa-clock me-1"></i>24 Jam
                        </button>
                        <button class="period-btn" data-period="daily">
                            <i class="fas fa-calendar-day me-1"></i>7 Hari
                        </button>
                        <button class="period-btn" data-period="monthly">
                            <i class="fas fa-calendar me-1"></i>30 Hari
                        </button>
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="volumeChart"></canvas>
            </div>
            <div class="chart-legend">
                <div class="legend-item">
                    <div class="legend-color normal"></div>
                    <span>Normal (0-80%)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color warning"></div>
                    <span>Warning (80-90%)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color critical"></div>
                    <span>Critical (90-100%)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loading-overlay" style="display: none;">
        <div class="loading-spinner">
            <div class="spinner"></div>
            <p>Memperbarui data...</p>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Enhanced Header */
    .detail-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }

    .detail-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
    }

    .modern-breadcrumb {
        background: none;
        padding: 0;
        margin: 0;
    }

    .modern-breadcrumb .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
    }

    .modern-breadcrumb .breadcrumb-item a:hover {
        color: var(--primary-dark);
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .page-subtitle {
        font-size: 1.1rem;
        color: #6b7280;
        margin: 0;
    }

    /* Status Badge Colors */
    .status-badge-large {
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
    }

    .status-badge-large.status-normal {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .status-badge-large.status-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    .status-badge-large.status-critical {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        animation: criticalPulse 2s infinite;
    }

    @keyframes criticalPulse {
        0%, 100% { transform: scale(1); box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3); }
        50% { transform: scale(1.05); box-shadow: 0 4px 25px rgba(239, 68, 68, 0.5); }
    }

    .led-indicator-large {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: inline-block;
        margin-left: 1rem;
    }

    .led-indicator-large.led-on {
        background: #ef4444;
        box-shadow: 0 0 20px #ef4444, inset 0 2px 4px rgba(255,255,255,0.3);
        animation: ledPulse 2s infinite;
    }

    .led-indicator-large.led-off {
        background: #9ca3af;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.3);
    }

    /* Enhanced Volume Card */
    .volume-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        height: 100%;
        max-width: 500px;
        margin: 0 auto;
    }

    .volume-card-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .volume-card-header h5 {
        margin: 0;
        font-weight: 700;
    }

    .volume-display {
        padding: 1.5rem;
        text-align: center;
    }

    .gauge-container {
        position: relative;
        width: 220px;
        height: 110px;
        margin: 0 auto 1.5rem auto;
    }

    .gauge-center {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -20%);
        text-align: center;
    }

    .volume-percentage {
        font-size: 2.2rem;
        font-weight: 900;
        color: var(--dark-color);
        line-height: 1;
    }

    .gauge-label {
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 600;
        margin-top: 0.25rem;
    }

    .estimation-card {
        background: rgba(6, 182, 212, 0.1);
        border: 2px solid rgba(6, 182, 212, 0.2);
        border-radius: var(--border-radius);
        padding: 1.25rem;
        margin: 1.25rem;
        text-align: center;
    }

    .estimation-header {
        color: var(--accent-color);
        font-weight: 700;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
    }

    .estimation-date {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark-color);
    }

    .estimation-time {
        color: #6b7280;
        font-weight: 500;
        font-size: 0.9rem;
    }

    /* Enhanced Specs Card */
    .specs-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
        height: 100%;
        max-width: 500px;
        margin: 0 auto;
    }

    .specs-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 1.5rem;
        border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
    }

    .specs-header h5 {
        margin: 0;
        font-weight: 700;
    }

    .specs-grid {
        padding: 1.5rem;
        display: grid;
        gap: 1.25rem;
    }

    .spec-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.7);
        border-radius: var(--border-radius);
        transition: var(--transition);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .spec-item:hover {
        transform: translateX(8px);
        box-shadow: var(--shadow-md);
        background: rgba(255, 255, 255, 0.9);
    }

    .spec-icon {
        width: 44px;
        height: 44px;
        background: var(--primary-gradient);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .spec-content {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .spec-label {
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 600;
    }

    .spec-value {
        font-size: 1rem;
        color: var(--dark-color);
        font-weight: 700;
    }

    /* Enhanced Chart Section */
    .chart-section {
        margin-bottom: 3rem;
    }

    .chart-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
    }

    .chart-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .chart-title h5 {
        margin: 0;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .chart-subtitle {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }

    .chart-controls {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .period-selector {
        display: flex;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 0.25rem;
    }

    .period-btn {
        background: transparent;
        border: none;
        color: white;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
        cursor: pointer;
        font-size: 0.85rem;
    }

    .period-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .period-btn.active {
        background: rgba(255, 255, 255, 0.9);
        color: var(--primary-color);
        font-weight: 700;
    }

    .chart-container {
        padding: 2rem;
        min-height: 500px;
        position: relative;
    }

    .chart-legend {
        display: flex;
        justify-content: center;
        gap: 2rem;
        padding: 1rem 2rem 2rem 2rem;
        background: rgba(0, 0, 0, 0.02);
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .legend-color {
        width: 16px;
        height: 16px;
        border-radius: 4px;
    }

    .legend-color.normal { 
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .legend-color.warning { 
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    
    .legend-color.critical { 
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .loading-spinner {
        text-align: center;
    }

    .spinner {
        width: 60px;
        height: 60px;
        border: 4px solid rgba(102, 126, 234, 0.1);
        border-left: 4px solid var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }

        .chart-header {
            flex-direction: column;
            text-align: center;
        }

        .period-selector {
            flex-direction: column;
            width: 100%;
        }

        .period-btn {
            width: 100%;
            margin-bottom: 0.25rem;
        }

        .gauge-container {
            width: 200px;
            height: 100px;
        }

        .volume-percentage {
            font-size: 1.8rem;
        }

        .chart-legend {
            flex-direction: column;
            gap: 1rem;
        }

        .volume-card, .specs-card {
            max-width: none;
        }
    }

    /* Animation Enhancements */
    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .pulse-glow {
        animation: pulseGlow 2s infinite;
    }

    @keyframes pulseGlow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
        }
        50% {
            box-shadow: 0 0 40px rgba(102, 126, 234, 0.6);
        }
    }
</style>
@endpush

@push('scripts')
<script>
// Initialize charts
let volumeChart;

// Function to get volume color based on percentage
function getVolumeColor(percentage) {
    if (percentage >= 90) {
        return '#ef4444'; // Red for critical
    } else if (percentage >= 80) {
        return '#f59e0b'; // Yellow for warning
    } else {
        return '#10b981'; // Green for normal
    }
}

// Function to get status based on percentage
function getStatusFromPercentage(percentage) {
    if (percentage >= 90) return 'critical';
    if (percentage >= 80) return 'warning';
    return 'normal';
}

// Enhanced Volume gauge (doughnut chart)
const gaugeCtx = document.getElementById('volumeGauge').getContext('2d');
let currentPercentage = 0;

const volumeGauge = new Chart(gaugeCtx, {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [currentPercentage, 100 - currentPercentage],
            backgroundColor: [
                getVolumeColor(currentPercentage),
                'rgba(0, 0, 0, 0.1)'
            ],
            borderWidth: 0,
            cutout: '75%'
        }]
    },
    options: {
        circumference: 180,
        rotation: 270,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                enabled: false
            }
        },
        maintainAspectRatio: false,
        responsive: true,
        animation: {
            animateRotate: true,
            duration: 2000,
            easing: 'easeOutQuart'
        }
    }
});

// Store historical data
let historicalData = {
    hourly: { labels: [], data: [] },
    daily: { labels: [], data: [] },
    monthly: { labels: [], data: [] }
};

// Function to add new data point to historical data
function addDataPoint(volume, timestamp = new Date()) {
    const volumeValue = parseFloat(volume);
    
    // Add to hourly data (last 24 hours, every 30 minutes)
    const hourlyTime = timestamp.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    historicalData.hourly.labels.push(hourlyTime);
    historicalData.hourly.data.push(volumeValue);
    
    // Keep only last 48 points (24 hours * 2 = 48 points for 30-minute intervals)
    if (historicalData.hourly.labels.length > 48) {
        historicalData.hourly.labels.shift();
        historicalData.hourly.data.shift();
    }
    
    // Add to daily data (last 7 days)
    const dailyTime = timestamp.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit' });
    if (historicalData.daily.labels[historicalData.daily.labels.length - 1] !== dailyTime) {
        historicalData.daily.labels.push(dailyTime);
        historicalData.daily.data.push(volumeValue);
        
        // Keep only last 7 points
        if (historicalData.daily.labels.length > 7) {
            historicalData.daily.labels.shift();
            historicalData.daily.data.shift();
        }
    } else {
        // Update today's value
        historicalData.daily.data[historicalData.daily.data.length - 1] = volumeValue;
    }
    
    // Add to monthly data (last 30 days)
    if (historicalData.monthly.labels[historicalData.monthly.labels.length - 1] !== dailyTime) {
        historicalData.monthly.labels.push(dailyTime);
        historicalData.monthly.data.push(volumeValue);
        
        // Keep only last 30 points
        if (historicalData.monthly.labels.length > 30) {
            historicalData.monthly.labels.shift();
            historicalData.monthly.data.shift();
        }
    } else {
        // Update today's value
        historicalData.monthly.data[historicalData.monthly.data.length - 1] = volumeValue;
    }
}

// Function to get chart data for specific period
function getChartData(period) {
    return {
        labels: [...historicalData[period].labels],
        data: [...historicalData[period].data]
    };
}

// Function to initialize historical data with current volume
function initializeHistoricalData() {
    const now = new Date();
    
    // Initialize with current volume if available, otherwise use 0
    const initialVolume = currentPercentage || 0;
    
    // Initialize hourly data (48 points for last 24 hours)
    for (let i = 47; i >= 0; i--) {
        const time = new Date(now.getTime() - (i * 30 * 60 * 1000));
        const timeLabel = time.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        historicalData.hourly.labels.push(timeLabel);
        
        // Only show current volume for the latest data point, others show 0 (no data yet)
        const value = i === 0 ? initialVolume : 0;
        historicalData.hourly.data.push(value);
    }
    
    // Initialize daily data (7 points for last 7 days)
    for (let i = 6; i >= 0; i--) {
        const date = new Date(now.getTime() - (i * 24 * 60 * 60 * 1000));
        const dateLabel = date.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit' });
        historicalData.daily.labels.push(dateLabel);
        
        // Only show current volume for today, others show 0
        const value = i === 0 ? initialVolume : 0;
        historicalData.daily.data.push(value);
    }
    
    // Initialize monthly data (30 points for last 30 days)
    for (let i = 29; i >= 0; i--) {
        const date = new Date(now.getTime() - (i * 24 * 60 * 60 * 1000));
        const dateLabel = date.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit' });
        historicalData.monthly.labels.push(dateLabel);
        
        // Only show current volume for today, others show 0
        const value = i === 0 ? initialVolume : 0;
        historicalData.monthly.data.push(value);
    }
}

// Enhanced Volume history chart
function initVolumeChart() {
    const ctx = document.getElementById('volumeChart').getContext('2d');
    
    if (volumeChart) {
        volumeChart.destroy();
    }
    
    const chartData = getChartData('hourly'); // Default to 24 hours
    
    volumeChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Volume (%)',
                data: chartData.data,
                borderColor: '#667eea',
                backgroundColor: function(context) {
                    const chart = context.chart;
                    const {ctx, chartArea} = chart;
                    if (!chartArea) {
                        return null;
                    }
                    const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                    gradient.addColorStop(0, 'rgba(102, 126, 234, 0.1)');
                    gradient.addColorStop(1, 'rgba(102, 126, 234, 0.3)');
                    return gradient;
                },
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: function(context) {
                    const value = context.parsed.y;
                    return getVolumeColor(value);
                },
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    top: 20,
                    bottom: 20,
                    left: 20,
                    right: 20
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: function(context) {
                            const value = context.tick.value;
                            if (value === 80) return 'rgba(245, 158, 11, 0.3)'; // Warning line
                            if (value === 90) return 'rgba(239, 68, 68, 0.3)'; // Critical line
                            return 'rgba(0, 0, 0, 0.1)';
                        },
                        drawBorder: false
                    },
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        },
                        color: function(context) {
                            const value = context.tick.value;
                            if (value === 80) return '#f59e0b'; // Warning
                            if (value === 90) return '#ef4444'; // Critical
                            return '#6b7280';
                        },
                        font: {
                            weight: '600'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Volume (%)',
                        color: '#374151',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            weight: '600'
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#374151',
                    bodyColor: '#6b7280',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    cornerRadius: 12,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        title: function(context) {
                            return 'Waktu: ' + context[0].label;
                        },
                        label: function(context) {
                            const value = context.parsed.y;
                            const status = value >= 90 ? 'Critical' : (value >= 80 ? 'Warning' : 'Normal');
                            return [`Volume: ${value}%`, `Status: ${status}`];
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });
}

// Chart period buttons with enhanced UX
document.querySelectorAll('.period-btn').forEach(button => {
    button.addEventListener('click', function() {
        const period = this.dataset.period;
        loadChartData(period);
        
        // Update active button with animation
        document.querySelectorAll('.period-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.style.transform = 'scale(1)';
        });
        this.classList.add('active');
        this.style.transform = 'scale(1.05)';
        setTimeout(() => {
            this.style.transform = 'scale(1)';
        }, 200);
    });
});

function loadChartData(period) {
    const loadingOverlay = document.getElementById('loading-overlay');
    
    loadingOverlay.style.display = 'flex';
    
    // Use actual historical data instead of generating random data
    setTimeout(() => {
        const chartData = getChartData(period);
        
        // Update chart data with smooth animation
        volumeChart.data.labels = chartData.labels;
        volumeChart.data.datasets[0].data = chartData.data;
        volumeChart.update('active');
        
        showNotification('Chart berhasil diperbarui', 'success');
        
        setTimeout(() => {
            loadingOverlay.style.display = 'none';
        }, 500);
    }, 1000);
}

// Function to fetch volume from API
async function fetchVolume() {
    try {
const response = await fetch('{{ url("/api/latest-volume") }}');
        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();
        const volume = parseFloat(data.volume).toFixed(1);
        
        // Update current percentage
        const newPercentage = parseFloat(volume);
        
        // Only update if there's a change
        if (newPercentage !== currentPercentage) {
            currentPercentage = newPercentage;
            
            // Add new data point to historical data
            addDataPoint(currentPercentage);
            
            // Update gauge
            updateVolumeGauge(currentPercentage);
            
            // Update percentage display
            document.getElementById('volume-percentage').textContent = `${volume}%`;
            
            // Update status badge
            updateStatusBadge(currentPercentage);
            
            // Update chart if currently viewing hourly (real-time period)
            const activeButton = document.querySelector('.period-btn.active');
            if (activeButton && activeButton.dataset.period === 'hourly') {
                updateChartRealTime();
            }
        }
        
    } catch (error) {
        console.error('Gagal mengambil data volume:', error);
    }
}

// Function to update chart in real-time (for hourly view)
function updateChartRealTime() {
    if (volumeChart) {
        const chartData = getChartData('hourly');
        volumeChart.data.labels = chartData.labels;
        volumeChart.data.datasets[0].data = chartData.data;
        volumeChart.update('none'); // Update without animation for smoother real-time updates
    }
}

// Function to update volume gauge
function updateVolumeGauge(percentage) {
    const newColor = getVolumeColor(percentage);
    
    // Update gauge with smooth animation
    volumeGauge.data.datasets[0].data = [percentage, 100 - percentage];
    volumeGauge.data.datasets[0].backgroundColor[0] = newColor;
    volumeGauge.update('active');
}

// Function to update status badge
function updateStatusBadge(percentage) {
    const status = getStatusFromPercentage(percentage);
    const statusBadge = document.querySelector('.status-badge-large');
    
    if (statusBadge) {
        statusBadge.className = `status-badge-large status-${status}`;
        
        let icon, text;
        switch (status) {
            case 'normal':
                icon = '<i class="fas fa-check-circle me-2"></i>';
                text = 'Normal';
                break;
            case 'warning':
                icon = '<i class="fas fa-exclamation-triangle me-2"></i>';
                text = 'Warning';
                break;
            case 'critical':
                icon = '<i class="fas fa-times-circle me-2"></i>';
                text = 'Critical';
                break;
        }
        
        statusBadge.innerHTML = icon + text;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize historical data first
    initializeHistoricalData();
    
    // Fetch initial volume data
    fetchVolume();
    
    // Initialize chart with hourly view (24 jam) using real data
    initVolumeChart();
    
    // Add entrance animations
    const cards = document.querySelectorAll('.volume-card, .specs-card, .chart-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        setTimeout(() => {
            card.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });
    
    // Auto refresh every 1 second
    setInterval(fetchVolume, 1000);
});

// WebSocket updates for this specific depo (if available)
if (typeof pusher !== 'undefined') {
    const depoChannel = pusher.subscribe('public-dashboard');
    depoChannel.bind('depo_status_updated', function(data) {
        if (data.depo.id == {{ $depo->id }}) {
            const newPercentage = parseFloat(data.depo.persentase_volume);
            
            // Update current percentage
            currentPercentage = newPercentage;
            
            // Update gauge
            updateVolumeGauge(newPercentage);
            
            // Update percentage display with animation
            const percentageDisplay = document.querySelector('#volume-percentage');
            if (percentageDisplay) {
                percentageDisplay.style.transform = 'scale(1.2)';
                percentageDisplay.textContent = newPercentage.toFixed(1) + '%';
                setTimeout(() => {
                    percentageDisplay.style.transform = 'scale(1)';
                }, 300);
            }
            
            // Update status badge
            updateStatusBadge(newPercentage);
            
            // Update LED indicator
            const ledIndicator = document.querySelector('.led-indicator-large');
            if (ledIndicator) {
                ledIndicator.className = `led-indicator-large ${data.depo.led_status ? 'led-on' : 'led-off'}`;
            }
            
            showNotification('Data depo berhasil diperbarui', 'info');
        }
    });
}

// Notification function
function showNotification(message, type) {
    // Create toast notification
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : (type === 'error' ? 'danger' : 'info')} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 5000);
}

// Add parallax effect to header
window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    const header = document.querySelector('.detail-header');
    if (header) {
        const speed = scrolled * 0.3;
        header.style.transform = `translateY(${speed}px)`;
    }
});
</script>
@endpush
@endsection