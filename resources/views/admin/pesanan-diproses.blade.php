@extends('admin.layout')

@section('content')
<h1 class="page-title">Daftar Pesanan Diproses</h1>

@if(session('success'))
<div id="successModal" class="admin-modal-overlay" style="display:flex; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:10000; justify-content:center; align-items:center;">
    <div class="admin-modal" style="background:#fff; padding:2.5rem 2.5rem; border-radius:24px; text-align:center; width:90%; max-width:500px; box-shadow:0 10px 40px rgba(0,0,0,0.1);">
        <div style="width:100px; height:100px; border-radius:50%; border:4px solid #666; display:flex; justify-content:center; align-items:center; margin:0 auto 1rem;">
            <svg viewBox="0 0 24 24" width="60" height="60" fill="none" stroke="#666" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" style="margin-top: 5px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
        <h3 style="font-size:1.6rem; font-weight:800; margin-bottom:0.5rem; color:#000;">Berhasil</h3>
        <p style="font-size:1.1rem; color:#111; margin-bottom:1.5rem;">{{ session('success') }}</p>
        <button type="button" onclick="document.getElementById('successModal').style.display='none'" style="background:#3358d4; color:#fff; border:none; padding:0.8rem 3rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; width: 200px;">Oke</button>
    </div>
</div>
@endif

<div class="table-card">
    <div class="table-header">
        <input type="text" class="search-input-table" placeholder="Cari Pesanan">
    </div>
    
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                <tr>
                    <td><strong>{{ $index + 1 }}</strong></td>
                    <td class="date-col"><strong>{{ $order->created_at->format('H.i.s-d-m-Y') }}</strong></td>
                    <td><strong>{{ $order->nama_pl }}</strong></td>
                    <td class="meja-col"><strong>{{ $order->no_meja }}</strong></td>
                    <td><strong>Rp.{{ number_format($order->total_harga, 0, ',', '.') }}</strong></td>
                    <td class="status-process">
                        <button type="button" style="background:#3252b3; color:#fff; border:none; padding:0.5rem 1rem; border-radius:20px; font-weight:700; cursor:pointer; font-size:0.85rem;" onclick="openModal('confirmSelesaiModal{{ $order->id }}')">Selesaikan Pesanan</button>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon btn-blue" onclick="openModal('detailModal{{ $order->id }}')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($orders->count() == 0)
                <tr>
                    <td colspan="7" style="text-align:center; padding: 2rem;">Belum ada pesanan diproses.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@foreach($orders as $order)
<div id="detailModal{{ $order->id }}" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div class="admin-modal" style="max-width: 450px; background:#fff; border-radius:12px;">
        <div class="admin-modal-header" style="padding: 1rem 1.5rem; border-bottom: 1px solid #eee; display:flex; justify-content:space-between; align-items:center;">
            <h3 style="margin:0;">Detail Pesanan</h3>
            <button onclick="closeModal('detailModal{{ $order->id }}')" style="background:none; border:none; font-size:1.8rem; cursor:pointer; color:#111; line-height:1;">&times;</button>
        </div>
        <div class="admin-modal-body" style="padding: 1.5rem; font-family: monospace;">
            <div class="receipt-header" style="text-align:center; margin-bottom:1rem;">
                <h2 style="margin:0; font-size:1.5rem; line-height:1.2;">Pawon<br>Kang Bima</h2>
                <p style="font-size:0.8rem; margin-top:0.5rem; color:#555;">Jl. Raya Ciwidey - Patengan, Patengan,<br>Kec. Ciwidey, Kabupaten Bandung, Jawa Barat 40973</p>
            </div>
            <hr class="dashed" style="border-top:1px dashed #ccc; margin: 1rem 0;">
            <div class="receipt-info" style="font-size:0.9rem; font-weight:700;">
                <div style="display:flex; justify-content:space-between; margin-bottom:0.3rem;">Waktu Pesan <span>{{ $order->created_at->format('d/m/Y H:i:s') }}</span></div>
                <div style="display:flex; justify-content:space-between; margin-bottom:0.3rem;">Nama <span>{{ $order->nama_pl }}</span></div>
                <div style="display:flex; justify-content:space-between; margin-bottom:0.3rem;">Meja <span>{{ $order->no_meja }}</span></div>
            </div>
            <hr class="dashed" style="border-top:1px dashed #ccc; margin: 1rem 0;">
            <div class="receipt-items" style="font-size:0.9rem; font-weight:700;">
                @php $totalQty = 0; @endphp
                @foreach($order->items as $item)
                @php $totalQty += $item->qty; @endphp
                <div style="display:flex; justify-content:space-between; margin-bottom:0.8rem; align-items:flex-start;">
                    <div style="flex:1; display:block;">
                        <div style="font-weight: 800; display:block;">{{ $item->menu->name }}</div>
                        @if($item->catatan)
                        <div style="font-size: 0.8rem; color: #555; font-weight: 600; margin-top: 2px; display:block;">Catatan: {{ $item->catatan }}</div>
                        @endif
                    </div>
                    <div style="text-align: right; padding-left: 10px; display:block;">
                        <div style="font-weight: 800; display:block;">{{ number_format($item->qty * $item->price, 0, ',', '.') }}</div>
                        <div style="font-size: 0.85rem; color: #555; font-weight: 700; margin-top: 2px; display:block;">x{{ $item->qty }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            <br><br>
            <hr class="dashed" style="border-top:1px dashed #ccc; margin: 1rem 0;">
            <div class="receipt-summary" style="font-size:0.9rem; font-weight:700;">
                <div style="display:flex; justify-content:space-between; margin-bottom:0.3rem;">Subtotal Pesanan <span>{{ $totalQty }} Item</span></div>
                <div style="display:flex; justify-content:space-between; margin-bottom:0.3rem; font-size:1rem; font-weight:800;">Total Harga <span>{{ number_format($order->total_harga, 0, ',', '.') }}</span></div>
            </div>
            <hr class="dashed" style="border-top:1px dashed #ccc; margin: 1rem 0;">
            <div class="receipt-payment" style="font-size:0.9rem; font-weight:700;">
                <div style="display:flex; justify-content:space-between; margin-bottom:0.3rem;">Metode Pembayaran <span>{{ $order->metode_pembayaran ?? 'Tunai' }}</span></div>
                <div style="display:flex; justify-content:space-between; margin-bottom:0.3rem;">Dibayar <span>{{ number_format($order->dibayar ?? 0, 0, ',', '.') }}</span></div>
                <div style="display:flex; justify-content:space-between; margin-bottom:0;">Kembalian <span>{{ number_format($order->kembalian ?? 0, 0, ',', '.') }}</span></div>
            </div>
            <hr class="dashed" style="border-top:1px dashed #ccc; margin: 1rem 0;">
            <div class="receipt-footer" style="text-align:center;">
                <h3 style="margin:0;">Terima Kasih</h3>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Selesai (Di Proses -> Selesai) -->
<div id="confirmSelesaiModal{{ $order->id }}" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:10000; justify-content:center; align-items:center;">
    <div class="admin-modal confirm-modal-box" style="background:#fff; padding:2.5rem 2.5rem; border-radius:24px; text-align:center; width:90%; max-width:500px; box-shadow:0 10px 40px rgba(0,0,0,0.1);">
        <div style="width:100px; height:100px; border-radius:50%; border:4px solid #666; display:flex; justify-content:center; align-items:center; margin:0 auto 1rem;">
            <svg viewBox="0 0 24 24" width="50" height="50" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round" style="color: #666;"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
        <h3 style="font-size:1.6rem; font-weight:800; margin-bottom:0.5rem; color:#000;">Selesaikan Pesanan?</h3>
        <p style="font-size:1.1rem; color:#111; margin-bottom:1.5rem;">Tandai pesanan ini sudah selesai dan dihidangkan.</p>
        <div class="confirm-actions" style="display:flex; justify-content:center; gap:1rem;">
            <form action="{{ route('admin.pesanan.status', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="selesai">
                <button type="submit" style="background:#3358d4; color:#fff; border:none; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Ya, Selesai</button>
            </form>
            <button type="button" onclick="closeModal('confirmSelesaiModal{{ $order->id }}')" style="background:#fff; color:#555; border:1px solid #666; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Batal</button>
        </div>
    </div>
</div>
@endforeach

<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
</script>
@endsection
