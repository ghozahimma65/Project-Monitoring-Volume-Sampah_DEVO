<?php
// resources/views/admin/depos/show.blade.php
?>
@extends('layouts.admin')

@section('title', $depo->nama_depo . ' - Detail Depo Admin')
@section('page-title', 'Detail Depo: ' . $depo->nama_depo)

@section('content')
<!-- Header Actions -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.depos.index') }}" class="text-decoration-none">
                                    <i class="fas fa-boxes me-1"></i>Kelola Depo
                                </a>
                            </li>
                            <li class="breadcrumb-item active">{{ $depo->nama_depo }}</li>
                        </ol>
                    </nav>
                    <div class="btn-group">
                        
                        <a href="{{ route('admin.depos.edit', $depo) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Edit Depo
                        </a>
                        <a href="{{ route('depo.detail', $depo) }}" class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-external-link-alt me-1"></i> Lihat Public
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Overview -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center p-4 status-{{ $depo->status }}">
                <div class="volume-display">
                    <div class="gauge-container mb-3">
                        <canvas id="volumeGauge" width="200" height="100"></canvas>
                        <div class="gauge-center">
                            <div class="volume-percentage" id="volume-percentage">0%</div>
                            <div class="gauge-label">Volume Saat Ini</div>
                        </div>
                    </div>
                    @if($depo->led_status)
                        <div class="led-status mt-3" id="led-status">
                            <span class="led-indicator led-on me-2"></span>
                            <span class="text-muted">LED Status: ON</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center p-4">
                <div class="d-flex flex-column justify-content-center h-100">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-satellite-dish fa-3x text-primary"></i>
                    </div>
                    <h2 class="mb-1">{{ $depo->jumlah_sensor }}</h2>
                    <p class="text-muted mb-0">Total Sensor</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center p-4">
                <div class="d-flex flex-column justify-content-center h-100">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-microchip fa-3x text-dark"></i>
                    </div>
                    <h2 class="mb-1">{{ $depo->jumlah_esp }}</h2>
                    <p class="text-muted mb-0">ESP32 Nodes</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Depo Information & Volume History -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Depo</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-hover">
                    <tr>
                        <td width="35%"><strong>Nama Depo:</strong></td>
                        <td>{{ $depo->nama_depo }}</td>
                    </tr>
                    <tr>
                        <td><strong>Lokasi:</strong></td>
                        <td>{{ $depo->lokasi }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dimensi:</strong></td>
                        <td>{{ $depo->panjang }} × {{ $depo->lebar }} × {{ $depo->tinggi }} meter</td>
                    </tr>
                    <tr>
                        <td><strong>Kapasitas:</strong></td>
                        <td>{{ number_format($depo->volume_maksimal, 2) }} m³</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            <span class="badge bg-{{ $depo->status === 'normal' ? 'success' : ($depo->status === 'warning' ? 'warning' : 'danger') }}" id="status-badge">
                                {{ ucfirst($depo->status) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Volume History (24 Jam)</h5>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height: 300px;">
                    <canvas id="volumeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Cari card "Informasi Depo" --}}
<div class="card">
    <div class="card-header">
        Informasi Depo
    </div>
    <div class="card-body">
        {{-- ... baris untuk Nama Depo, Lokasi, Dimensi, Kapasitas ... --}}

        <div class="row mb-3">
            <div class="col-sm-4"><strong>Status:</strong></div>
            <div class="col-sm-8">
                <span class="badge bg-danger">{{ $depo->status_text ?? 'Critical' }}</span>
            </div>
        </div>

        {{-- PINDAHKAN BLOK KODE KE SINI --}}
        @if($depo->waktu_kritis)
        <div class="row mb-3">
            <div class="col-sm-4"><strong>Kritis Sejak:</strong></div>
            <div class="col-sm-8">
                {{ \Carbon\Carbon::parse($depo->waktu_kritis)->diffForHumans() }}
                <br>
                <small>({{ \Carbon\Carbon::parse($depo->waktu_kritis)->format('d M Y, H:i') }})</small>
            </div>
        </div>
        @endif
        {{-- AKHIR BLOK KODE --}}

    </div>
</div>

@push('styles')
<style>
    .card {
        border-radius: 12px;
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .card-header {
        border-radius: 12px 12px 0 0 !important;
        font-weight: 600;
    }
    
    .gauge-container {
        position: relative;
        width: 200px;
        height: 100px;
        margin: 0 auto;
    }
    
    .gauge-center {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -20%);
        text-align: center;
    }
    
    .volume-percentage {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        line-height: 1;
        transition: all 0.3s ease;
    }
    
    .gauge-label {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
    }
    
    .led-indicator {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 5px;
    }
    
    .led-on {
        background: #ef4444;
        box-shadow: 0 0 10px #ef4444;
        animation: pulse 1.5s infinite;
    }
    
    .led-off {
        background: #6c757d;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
        100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }
    
    .icon-wrapper {
        color: rgba(0, 0, 0, 0.1);
    }
    
    .status-normal .volume-percentage {
        color: #10b981;
    }
    
    .status-warning .volume-percentage {
        color: #f59e0b;
    }
    
    .status-critical .volume-percentage {
        color: #ef4444;
        animation: pulseText 1.5s infinite;
    }
    
    @keyframes pulseText {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }
    
    .table-borderless tr {
        border-bottom: 1px solid #f1f1f1;
    }
    
    .table-borderless tr:last-child {
        border-bottom: none;
    }
    
    .chart-container {
        position: relative;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Global variables
let volumeGauge, volumeChart;
let currentPercentage = 0;
let historicalData = {
    labels: [],
    data: []
};

// Initialize historical data (same structure as public view)
function initializeHistoricalData() {
    const now = new Date();
    
    // Initialize with 48 points for last 24 hours (30-minute intervals)
    for (let i = 47; i >= 0; i--) {
        const time = new Date(now.getTime() - (i * 30 * 60 * 1000));
        const timeLabel = time.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        historicalData.labels.push(timeLabel);
        historicalData.data.push(0); // Start with 0, will be updated by fetchVolume
    }
}

// Function to add new data point (same as public view)
function addDataPoint(volume) {
    const volumeValue = parseFloat(volume);
    const now = new Date();
    const timeLabel = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    
    // Add new data point
    historicalData.labels.push(timeLabel);
    historicalData.data.push(volumeValue);
    
    // Keep only last 48 points (24 hours * 2 = 48 points for 30-minute intervals)
    if (historicalData.labels.length > 48) {
        historicalData.labels.shift();
        historicalData.data.shift();
    }
}

// Function to get volume color based on percentage (same as public view)
function getVolumeColor(percentage) {
    if (percentage >= 90) return '#ef4444'; // Critical
    if (percentage >= 80) return '#f59e0b'; // Warning
    return '#10b981'; // Normal
}

// Function to get status based on percentage (same as public view)
function getStatusFromPercentage(percentage) {
    if (percentage >= 90) return 'critical';
    if (percentage >= 80) return 'warning';
    return 'normal';
}

// Initialize volume gauge (same configuration as public view)
function initVolumeGauge() {
    const gaugeCtx = document.getElementById('volumeGauge').getContext('2d');
    
    volumeGauge = new Chart(gaugeCtx, {
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
                legend: { display: false },
                tooltip: { enabled: false }
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
}

// Initialize volume chart (same configuration as public view hourly chart)
function initVolumeChart() {
    const chartCtx = document.getElementById('volumeChart').getContext('2d');
    
    volumeChart = new Chart(chartCtx, {
        type: 'line',
        data: {
            labels: [...historicalData.labels],
            datasets: [{
                label: 'Volume (%)',
                data: [...historicalData.data],
                borderColor: '#3b82f6',
                backgroundColor: function(context) {
                    const chart = context.chart;
                    const {ctx, chartArea} = chart;
                    if (!chartArea) {
                        return null;
                    }
                    const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.1)');
                    gradient.addColorStop(1, 'rgba(59, 130, 246, 0.3)');
                    return gradient;
                },
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: function(context) {
                    const value = context.parsed.y;
                    return getVolumeColor(value);
                },
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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
                        }
                    },
                    ticks: {
                        callback: function(value) { return value + '%'; },
                        color: function(context) {
                            const value = context.tick.value;
                            if (value === 80) return '#f59e0b';
                            if (value === 90) return '#ef4444';
                            return '#6b7280';
                        }
                    }
                },
                x: { 
                    grid: { display: false },
                    ticks: { color: '#6b7280' }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#374151',
                    bodyColor: '#6b7280',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    cornerRadius: 8,
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
            }
        }
    });
}

// Function to fetch volume from API (same as public view)
async function fetchVolume() {
    try {
        const response = await fetch('{{ url("/api/latest-volume") }}');
        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();
        const volume = parseFloat(data.volume).toFixed(1);
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
            
            // Update status badge and card class
            updateStatusElements(currentPercentage);
            
            // Update chart with real-time data
            updateChart();
        }
        
    } catch (error) {
        console.error('Gagal mengambil data volume:', error);
    }
}

// Function to update volume gauge (same as public view)
function updateVolumeGauge(percentage) {
    const newColor = getVolumeColor(percentage);
    
    volumeGauge.data.datasets[0].data = [percentage, 100 - percentage];
    volumeGauge.data.datasets[0].backgroundColor[0] = newColor;
    volumeGauge.update('active');
}

// Function to update status elements
function updateStatusElements(percentage) {
    const status = getStatusFromPercentage(percentage);
    
    // Update card status class
    const card = document.querySelector('.volume-display').closest('.card-body');
    card.className = `card-body text-center p-4 status-${status}`;
    
    // Update status badge in table
    const statusBadge = document.getElementById('status-badge');
    if (statusBadge) {
        let badgeClass, badgeText;
        switch (status) {
            case 'normal':
                badgeClass = 'bg-success';
                badgeText = 'Normal';
                break;
            case 'warning':
                badgeClass = 'bg-warning';
                badgeText = 'Warning';
                break;
            case 'critical':
                badgeClass = 'bg-danger';
                badgeText = 'Critical';
                break;
        }
        statusBadge.className = `badge ${badgeClass}`;
        statusBadge.textContent = badgeText;
    }
}

// Function to update chart with new data
function updateChart() {
    if (volumeChart) {
        volumeChart.data.labels = [...historicalData.labels];
        volumeChart.data.datasets[0].data = [...historicalData.data];
        volumeChart.update('none'); // No animation for smoother real-time updates
    }
}

// Initialize everything on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize historical data structure
    initializeHistoricalData();
    
    // Initialize charts
    initVolumeGauge();
    initVolumeChart();
    
    // Fetch initial volume data
    fetchVolume();
    
    // Auto refresh every 1 second (same as public view)
    setInterval(fetchVolume, 1000);
});

// WebSocket updates for this specific depo (enhanced to match public view)
if (typeof pusher !== 'undefined') {
    const depoChannel = pusher.subscribe('admin-dashboard');
    depoChannel.bind('depo_status_updated', function(data) {
        if (data.depo.id == {{ $depo->id }}) {
            const newPercentage = parseFloat(data.depo.persentase_volume);
            
            // Update current percentage
            currentPercentage = newPercentage;
            
            // Add new data point
            addDataPoint(newPercentage);
            
            // Update gauge
            updateVolumeGauge(newPercentage);
            
            // Update percentage display with animation
            const percentageDisplay = document.getElementById('volume-percentage');
            if (percentageDisplay) {
                percentageDisplay.style.transform = 'scale(1.1)';
                percentageDisplay.textContent = newPercentage.toFixed(1) + '%';
                setTimeout(() => {
                    percentageDisplay.style.transform = 'scale(1)';
                }, 300);
            }
            
            // Update status elements
            updateStatusElements(newPercentage);
            
            // Update LED status
            const ledStatus = document.getElementById('led-status');
            if (ledStatus) {
                ledStatus.innerHTML = `
                    <span class="led-indicator ${data.depo.led_status ? 'led-on' : 'led-off'} me-2"></span>
                    <span class="text-muted">LED Status: ${data.depo.led_status ? 'ON' : 'OFF'}</span>
                `;
            }
            
            // Update chart
            updateChart();
        }
    });
}
</script>
@endpush
@endsection