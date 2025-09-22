@extends('layouts.app') {{-- Pastikan nama layout ini sesuai dengan layout publik Anda --}}

@section('title', 'Tinjauan Laporan - DEVO')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm" data-aos="fade-up">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list-alt me-2"></i>Tinjauan Laporan
            </h5>
            <span class="badge bg-primary rounded-pill">Total: {{ $reports->total() }} Laporan</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID Laporan</th>
                            <th>Depo</th>
                            <th>Kategori</th>
                            <th>Tanggal Dilaporkan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td><strong>#{{ $report->id }}</strong></td>
                                <td>
                                    <div>{{ $report->depo->nama_depo ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $report->depo->lokasi ?? '' }}</small>
                                </td>
                                <td>{{ $report->kategori }}</td>
                                <td>{{ $report->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-info text-dark">{{ $report->status ?? 'Pending' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum ada laporan publik yang tersedia.</h5>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Menampilkan link untuk halaman berikutnya --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
