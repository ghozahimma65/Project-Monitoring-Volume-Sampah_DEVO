<?php
// resources/views/admin/depos/create.blade.php
?>
@extends('layouts.admin')

@section('title', 'Tambah Depo Baru - Admin DEVO')
@section('page-title', 'Tambah Depo Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Tambah Depo Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.depos.store') }}" method="POST" id="depoForm">
                    @csrf
                    
                    <!-- Basic Info -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_depo" class="form-label">Nama Depo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_depo') is-invalid @enderror" 
                                   name="nama_depo" id="nama_depo" value="{{ old('nama_depo') }}" required>
                            @error('nama_depo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                   name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Dimensions -->
                    <div class="mb-3">
                        <label class="form-label">Dimensi Depo <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="panjang" class="form-label small">Panjang (cm)</label>
                                <input type="number" step="0.1" min="0.1" max="5000" 
                                       placeholder="Contoh: 150.5"
                                       class="form-control @error('panjang') is-invalid @enderror" 
                                       name="panjang" id="panjang" value="{{ old('panjang') }}" 
                                       required oninput="calculateSensors()">
                                @error('panjang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="lebar" class="form-label small">Lebar (cm)</label>
                                <input type="number" step="0.1" min="0.1" max="5000" 
                                       placeholder="Contoh: 80"
                                       class="form-control @error('lebar') is-invalid @enderror" 
                                       name="lebar" id="lebar" value="{{ old('lebar') }}" 
                                       required oninput="calculateSensors()">
                                @error('lebar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="tinggi" class="form-label small">Tinggi (cm)</label>
                                <input type="number" step="0.1" min="0.1" max="5000" 
                                       placeholder="Contoh: 75.2"
                                       class="form-control @error('tinggi') is-invalid @enderror" 
                                       name="tinggi" id="tinggi" value="{{ old('tinggi') }}" 
                                       required oninput="calculateSensors()">
                                @error('tinggi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Calculation Preview -->
                    <div class="card bg-light mb-3" id="calculationPreview" style="display: none;">
                        <div class="card-body">
                            <h6 class="card-title">Preview Perhitungan Otomatis</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="small text-muted">Luas Area</label>
                                    <div id="preview-area" class="fw-bold">-</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="small text-muted">Volume Maksimal</label>
                                    <div id="preview-volume" class="fw-bold">-</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="small text-muted">Jumlah Sensor</label>
                                    <div id="preview-sensors" class="fw-bold text-primary">-</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="small text-muted">Jumlah ESP32</label>
                                    <div id="preview-esp" class="fw-bold text-success">-</div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> 
                                    Perhitungan berdasarkan coverage area 15×15 cm per sensor dan maksimal 4 sensor per ESP32
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.depos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Depo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function calculateSensors() {
    const panjang = parseFloat(document.getElementById('panjang').value);
    const lebar = parseFloat(document.getElementById('lebar').value);
    const tinggi = parseFloat(document.getElementById('tinggi').value);
    
    if (panjang && lebar && tinggi) {
        fetch('{{ route("admin.depos.preview-calculation") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                panjang: panjang,
                lebar: lebar,
                tinggi: tinggi
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const calc = data.calculations;
                document.getElementById('preview-area').textContent = calc.area_coverage.toFixed(2) + ' m²';
                document.getElementById('preview-volume').textContent = calc.volume_maksimal.toFixed(2) + ' m³';
                document.getElementById('preview-sensors').textContent = calc.jumlah_sensor + ' unit';
                document.getElementById('preview-esp').textContent = calc.jumlah_esp + ' unit';
                document.getElementById('calculationPreview').style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    } else {
        document.getElementById('calculationPreview').style.display = 'none';
    }
}
</script>
@endpush
@endsection