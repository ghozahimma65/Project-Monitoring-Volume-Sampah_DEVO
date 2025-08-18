@extends('layouts.admin')

@section('title', 'Kelola Depo - Admin DEVO')
@section('page-title', 'Kelola Depo')

@section('content')
<!-- Header Section -->
<div class="header-section mb-4">
    <div class="card shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
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

<!-- Depo List -->
<div class="card shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>Data Depo
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Depo</th>
                        <th>Lokasi</th>
                        <th>Dimensi</th>
                        <th>Volume</th>
                        <th>Status</th>
                        <th>Sensor/ESP</th>
                        <th>Update Terakhir</th>
                        <th>Kritis Sejak</th>
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
                                    <strong>{{ $depo->nama_depo }}</strong>
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-map-marker-alt text-muted me-1"></i>{{ $depo->lokasi }}
                            </td>
                            <td>{{ $depo->panjang }}×{{ $depo->lebar }}×{{ $depo->tinggi }}</td>
                            <td>
                                <div class="volume-container">
                                    <div class="progress mb-1" style="height: 20px;">
                                        <div class="progress-bar volume-bar status-{{ strtolower($depo->status) }}"
                                            role="progressbar"
                                            style="width: {{ $depo->persentase_volume ?? 0 }}%"
                                            aria-valuenow="{{ $depo->persentase_volume ?? 0 }}"
                                            aria-valuemin="0" aria-valuemax="100"
                                            id="progress-bar-{{ $depo->id }}">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span id="volume-percentage-{{ $depo->id }}">
                                            {{ number_format($depo->persentase_volume ?? 0, 1) }}%
                                        </span>
                                        <small id="volume-details-{{ $depo->id }}">
                                            {{ number_format($depo->volume_saat_ini ?? 0, 2) }} / {{ number_format($depo->volume_maksimal, 2) }} m³
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge status-badge status-{{ strtolower($depo->status) }}"
                                      id="status-badge-{{ $depo->id }}">
                                    {{ ucfirst($depo->status) }}
                                </span>
                            </td>
                            <td>
                                <div><i class="fas fa-satellite-dish text-info me-1"></i>{{ $depo->jumlah_sensor }} sensors</div>
                                <div><i class="fas fa-microchip text-warning me-1"></i>{{ $depo->jumlah_esp }} ESP32</div>
                            </td>
                            <td class="last-updated">
                                <small class="text-muted">{{ $depo->updated_at?->diffForHumans() ?? 'N/A' }}</small>
                            </td>
                            <td>
                                {{ $depo->waktu_kritis ? \Carbon\Carbon::parse($depo->waktu_kritis)->diffForHumans() : '-' }}
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.depos.show', $depo) }}" class="btn btn-outline-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.depos.edit', $depo) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>
                                    <button class="btn btn-outline-danger" onclick="confirmDelete({{ $depo->id }}, '{{ $depo->nama_depo }}')"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                                <div class="text-muted">Belum ada depo yang terdaftar</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display:none;">@csrf @method('DELETE')</form>
@endsection

@push('styles')
<style>
    .depo-icon { width: 40px; height: 40px; background: rgba(102,126,234,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; }
    .volume-bar.status-normal { background-color: #10b981; }
    .volume-bar.status-warning { background-color: #f59e0b; }
    .volume-bar.status-critical { background-color: #ef4444; }
    .status-badge.status-normal { background-color: #10b981; color: #fff; }
    .status-badge.status-warning { background-color: #f59e0b; color: #fff; }
    .status-badge.status-critical { background-color: #ef4444; color: #fff; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function getStatusFromVolume(p) {
    if (p <= 80) return 'normal';
    if (p <= 90) return 'warning';
    return 'critical';
}

function updateDepoUI(d) {
    let status = getStatusFromVolume(d.persentase_volume);
    document.getElementById(`progress-bar-${d.id}`).className = `progress-bar volume-bar status-${status}`;
    document.getElementById(`progress-bar-${d.id}`).style.width = d.persentase_volume + '%';
    document.getElementById(`volume-percentage-${d.id}`).textContent = d.persentase_volume.toFixed(1) + '%';
    document.getElementById(`volume-details-${d.id}`).textContent = `${d.volume_saat_ini.toFixed(2)} / ${d.volume_maksimal.toFixed(2)} m³`;
    document.getElementById(`status-badge-${d.id}`).className = `badge status-badge status-${status}`;
    document.getElementById(`status-badge-${d.id}`).textContent = status.charAt(0).toUpperCase() + status.slice(1);
}

async function fetchAllVolumes() {
    try {
        const res = await fetch('{{ route("admin.depos.realtime-volumes") }}');
        if (!res.ok) return;
        const data = await res.json();
        data.forEach(updateDepoUI);
    } catch (e) { console.error(e); }
}

function confirmDelete(id, name) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        html: `Hapus depo <strong>${name}</strong>?`,
        icon: 'warning', showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
    }).then(result => {
        if (result.isConfirmed) {
            let form = document.getElementById('delete-form');
            form.action = `/admin/depos/${id}`;
            form.submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    fetchAllVolumes();
    setInterval(fetchAllVolumes, 5000);
});
</script>
@endpush
