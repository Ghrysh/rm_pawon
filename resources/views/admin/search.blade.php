@extends('admin.layout')

@section('content')
<h1 class="page-title">Hasil Pencarian untuk: "{{ $keyword }}"</h1>

<div class="table-card" style="margin-bottom: 2rem;">
    <h2 style="padding: 1rem 1.5rem; border-bottom: 1px solid #eee; margin:0;">Pesanan ({{ $orders->count() }})</h2>
    @if($orders->count() > 0)
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama PL</th>
                    <th>No Meja</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                <tr>
                    <td><strong>{{ $index + 1 }}</strong></td>
                    <td><strong>{{ $order->created_at->format('d/m/Y H:i:s') }}</strong></td>
                    <td><strong>{{ $order->nama_pl }}</strong></td>
                    <td><strong>{{ $order->no_meja }}</strong></td>
                    <td><strong>Rp.{{ number_format($order->total_harga, 0, ',', '.') }}</strong></td>
                    <td>
                        @if($order->status == 'menunggu_pembayaran')
                            <span style="color:#bb1f21; font-weight:700;">Menunggu Pembayaran</span>
                        @elseif($order->status == 'diproses')
                            <span style="color:#1f9435; font-weight:700;">Di Proses</span>
                        @else
                            <span style="color:#3252b3; font-weight:700;">Selesai</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div style="padding: 2rem; text-align: center; color: #777;">Tidak ditemukan pesanan dengan kata kunci tersebut.</div>
    @endif
</div>

<div class="table-card">
    <h2 style="padding: 1rem 1.5rem; border-bottom: 1px solid #eee; margin:0;">Menu ({{ $menus->count() }})</h2>
    @if($menus->count() > 0)
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $index => $menu)
                <tr>
                    <td><strong>{{ $index + 1 }}</strong></td>
                    <td>
                        @if($menu->image)
                            <img src="{{ asset($menu->image) }}" alt="Menu" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                        @else
                            <div style="width: 50px; height: 50px; background: #eee; border-radius: 8px; display:flex; align-items:center; justify-content:center; font-size:12px; color:#888;">No Img</div>
                        @endif
                    </td>
                    <td><strong>{{ $menu->name }}</strong></td>
                    <td><strong>Rp.{{ number_format($menu->price, 0, ',', '.') }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div style="padding: 2rem; text-align: center; color: #777;">Tidak ditemukan menu dengan kata kunci tersebut.</div>
    @endif
</div>

@endsection
