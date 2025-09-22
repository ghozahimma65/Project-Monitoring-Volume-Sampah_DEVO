<?php

// resources/views/admin/depos/edit.blade.php
?>
@extends('layouts.admin')

@section('title', 'Edit Depo - Admin DEVO')
@section('page-title', 'Edit Depo: ' . $depo->nama_depo)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Depo: {{ $depo->nama_depo }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.depos.update', $depo) }}" method="POST" id="depoEditForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Info -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_depo" class="form-label">Nama Depo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_depo') is-invalid @enderror" 
                                   name="nama_depo" id="nama_depo" value="{{ old('nama_depo', $depo->nama_depo) }}" required>
                            @error('nama_depo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                   name="lokasi" id="lokasi" value="{{ old('lokasi', $depo->lokasi) }}" required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Current Status -->
                    <div class="alert alert-info mb-3">
                        <h6>Status Saat Ini:</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Volume:</strong> {{ number_format($depo->persentase_volume, 1) }}%
                            </div>
                            <div class="col-md-3">
                                <strong>Status:</strong> {{ $depo->status_text }}
                            </div>
                            <div class="col-md-3">
                                <strong>Sensor:</strong> {{ $depo->jumlah_sensor }} unit
                            </div>
                            <div class="col-md-3">
                                <strong>ESP32:</strong> {{ $depo->jumlah_esp }} unit
                            </div>
                        </div>
                    </div>

                    <!-- Dimensions -->
                    <div class="mb-3">
                        <label class="form-label">Dimensi Depo <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="panjang" class="form-label small">Panjang (m)</label>
                                <input type="number" step="0.1" min="0" max="50" 
                                       class="form-control @error('panjang') is-invalid @enderror" 
                                       name="panjang" id="panjang" value="{{ old('panjang', $depo->panjang) }}" 
                                       required onchange="calculateSensors()">
                                @error('panjang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="lebar" class="form-label small">Lebar (m)</label>
                                <input type="number" step="0.1" min="0" max="50" 
                                       class="form-control @error('lebar') is-invalid @enderror" 
                                       name="lebar" id="lebar" value="{{ old('lebar', $depo->lebar) }}" 
                                       required onchange="calculateSensors()">
                                @error('lebar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="tinggi" class="form-label small">Tinggi (m)</label>
                                <input type="number" step="0.1" min="0" max="5000" 
                                       class="form-control @error('tinggi') is-invalid @enderror" 
                                       name="tinggi" id="tinggi" value="{{ old('tinggi', $depo->tinggi) }}" 
                                       required onchange="calculateSensors()">
                                @error('tinggi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Calculation Preview -->
                    <div class="card bg-light mb-3" id="calculationPreview">
                        <div class="card-body">
                            <h6 class="card-title">Preview Perhitungan Baru</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="small text-muted">Luas Area</label>
                                    <div id="preview-area" class="fw-bold">{{ $depo->panjang * $depo->lebar }} m²</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="small text-muted">Volume Maksimal</label>
                                    <div id="preview-volume" class="fw-bold">{{ number_format($depo->volume_maksimal, 2) }} m³</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="small text-muted">Jumlah Sensor</label>
                                    <div id="preview-sensors" class="fw-bold text-primary">{{ $depo->jumlah_sensor }} unit</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="small text-muted">Jumlah ESP32</label>
                                    <div id="preview-esp" class="fw-bold text-success">{{ $depo->jumlah_esp }} unit</div>
                                </div>
                            </div>
                            <div class="mt-2" id="change-warning" style="display: none;">
                                <div class="alert alert-warning small mb-0">
                                    <i class="fas fa-exclamation-triangle"></i> 
                                    Perubahan dimensi akan mempengaruhi perhitungan volume pada siklus pengukuran berikutnya.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.depos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Depo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let originalValues = {
    panjang: {{ $depo->panjang }},
    lebar: {{ $depo->lebar }},
    tinggi: {{ $depo->tinggi }}
};

function calculateSensors() {
    const panjang = parseFloat(document.getElementById('panjang').value);
    const lebar = parseFloat(document.getElementById('lebar').value);
    const tinggi = parseFloat(document.getElementById('tinggi').value);
    
    if (panjang && lebar && tinggi) {
        // Check if values changed
        const hasChanged = panjang !== originalValues.panjang || 
                          lebar !== originalValues.lebar || 
                          tinggi !== originalValues.tinggi;
        
        document.getElementById('change-warning').style.display = hasChanged ? 'block' : 'none';
        
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
                
                // Highlight changes
                if (calc.jumlah_sensor !== {{ $depo->jumlah_sensor }}) {
                    document.getElementById('preview-sensors').classList.add('text-warning');
                }
                if (calc.jumlah_esp !== {{ $depo->jumlah_esp }}) {
                    document.getElementById('preview-esp').classList.add('text-warning');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}

// Calculate on page load
calculateSensors();
</script>
@endpush
@endsection