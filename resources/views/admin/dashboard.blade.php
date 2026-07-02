@extends('admin.layout')

@section('content')
<h1 class="page-title">Dashboard</h1>

<div class="stats-grid">
    <div class="stat-card" style="background-color: #bb1f21;">
        <div class="stat-content">
            <div class="stat-value">{{ $pesananMasukCount }}</div>
            <div class="stat-label">Pesanan Masuk</div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            </div>
        </div>
        <div class="stat-footer"><a href="{{ route('admin.pesanan-masuk') }}" style="color:#fff; text-decoration:none;">Detail ></a></div>
    </div>
    
    <div class="stat-card" style="background-color: #1f9435;">
        <div class="stat-content">
            <div class="stat-value">{{ $pesananDiprosesCount }}</div>
            <div class="stat-label">Pesanan Diproses</div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
        </div>
        <div class="stat-footer"><a href="{{ route('admin.pesanan-diproses') }}" style="color:#fff; text-decoration:none;">Detail ></a></div>
    </div>

    <div class="stat-card" style="background-color: #2e53b2;">
        <div class="stat-content">
            <div class="stat-value">{{ $riwayatTransaksiCount }}</div>
            <div class="stat-label">Pesanan Selesai</div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><path d="M9 15l2 2 4-4"></path></svg>
            </div>
        </div>
        <div class="stat-footer"><a href="{{ route('admin.riwayat') }}" style="color:#fff; text-decoration:none;">Detail ></a></div>
    </div>

    <div class="stat-card" style="background-color: #d1b110; justify-content: center; padding-bottom: 1.5rem;">
        <div class="stat-content">
            <div class="stat-value">Rp.{{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line><circle cx="16" cy="15" r="1"></circle></svg>
            </div>
        </div>
    </div>
</div>

<div class="chart-box">
    <h3 class="chart-title">Tabel Pendapatan</h3>
    <div class="dummy-chart">
        <div class="y-axis">
            <span>Rp.{{ number_format($maxIncome, 0, ',', '.') }}</span>
            <span>Rp.{{ number_format($maxIncome * 0.75, 0, ',', '.') }}</span>
            <span>Rp.{{ number_format($maxIncome * 0.5, 0, ',', '.') }}</span>
            <span>Rp.{{ number_format($maxIncome * 0.25, 0, ',', '.') }}</span>
            <span>0</span>
        </div>
        <div class="chart-area">
            <div class="grid-lines">
                <div class="g-line"></div>
                <div class="g-line"></div>
                <div class="g-line"></div>
                <div class="g-line"></div>
                <div class="g-line"></div>
            </div>
            <div class="bars">
                @forelse($chartData as $data)
                @php
                    $percentage = ($data->total / $maxIncome) * 100;
                    if ($percentage > 100) $percentage = 100;
                @endphp
                <div class="bar-group">
                    <div class="bar" style="height: {{ $percentage }}%;" title="Rp. {{ number_format($data->total, 0, ',', '.') }}"></div>
                    <div class="x-label">{{ \Carbon\Carbon::parse($data->date)->format('d/m/Y') }}</div>
                </div>
                @empty
                <div style="display:flex; justify-content:center; align-items:center; height:100%; width:100%; color:#777; font-weight:bold;">
                    Belum ada data pendapatan.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
