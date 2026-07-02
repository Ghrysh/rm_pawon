@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h1 class="page-title" style="margin-bottom:0;">Riwayat Transaksi</h1>
    <button class="btn-tambah-menu" style="background-color: #28a745; display:flex; align-items:center; gap:0.5rem;" onclick="openModal('confirmExportModal')">
        Export
        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
    </button>
</div>

<div class="table-card">
    <div class="table-header" style="justify-content: flex-end;">
        <input type="text" class="search-input-table" placeholder="Cari Pesanan">
    </div>

    <div class="table-responsive">
        <table class="admin-table" id="riwayatTable">
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
                    <td><strong>{{ $order->created_at->format('H.i-d-m-Y') }}</strong></td>
                    <td><strong>{{ $order->nama_pl }}</strong></td>
                    <td><strong>{{ $order->no_meja }}</strong></td>
                    <td><strong>Rp.{{ number_format($order->total_harga, 0, ',', '.') }}</strong></td>
                    <td style="color: #3252b3; font-weight:700;">Selesai</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon btn-blue" onclick="openModal('detailModal{{ $order->id }}')">
                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($orders->count() == 0)
                <tr>
                    <td colspan="7" style="text-align:center; padding: 2rem;">Belum ada riwayat transaksi.</td>
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
                <div style="display:flex; justify-content:space-between; margin-bottom:0.3rem;">Waktu Pesan <span>{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
                <div style="display:flex; justify-content:space-between; margin-bottom:0.3rem;">Nama <span>{{ $order->nama_pl }}</span></div>
                <div style="display:flex; justify-content:space-between; margin-bottom:0.3rem;">Meja <span>{{ $order->no_meja }}</span></div>
            </div>
            <hr class="dashed" style="border-top:1px dashed #ccc; margin: 1rem 0;">
            <div class="receipt-items" style="font-size:0.9rem; font-weight:700;">
                @php $totalQty = 0; @endphp
                @foreach($order->items as $item)
                @php $totalQty += $item->qty; @endphp
                <div style="display:flex; justify-content:space-between; margin-bottom:0.3rem;">{{ $item->qty }} {{ $item->menu->name }} <span>{{ number_format($item->qty * $item->price, 0, ',', '.') }}</span></div>
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
@endforeach


<!-- Modal Konfirmasi Export -->
<div id="confirmExportModal" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div class="admin-modal confirm-modal-box" style="background:#fff; padding:2.5rem 2rem; border-radius:12px; text-align:center; width:90%; max-width:400px; box-shadow:0 10px 25px rgba(0,0,0,0.2);">
        <div class="confirm-icon icon-warn" style="width:80px; height:80px; border-radius:50%; border:2px solid #555; display:flex; justify-content:center; align-items:center; font-size:3rem; font-weight:700; color:#555; margin:0 auto 1.5rem;">?</div>
        <h3 style="font-size:1.5rem; font-weight:700; margin-bottom:2rem; color:#111;">Yakin Ingin Export File ?</h3>
        <div class="confirm-actions" style="display:flex; justify-content:center; gap:1rem;">
            <button class="btn-edit-simpan" style="background:#3252b3; color:#fff; border:none; padding:0.6rem 2.5rem; border-radius:20px; font-weight:700; cursor:pointer; font-size:1rem;" onclick="exportToExcel(); closeModal('confirmExportModal')">Yakin</button>
            <button style="background:#fff; color:#111; border:1px solid #777; padding:0.6rem 2.5rem; border-radius:20px; font-weight:700; cursor:pointer; font-size:1rem;" onclick="closeModal('confirmExportModal')">Batal</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function exportToExcel() {
        var table = document.getElementById("riwayatTable");
        var wb = XLSX.utils.book_new();
        
        var wsData = [];
        var rows = table.querySelectorAll('tr');
        
        for (var i = 0; i < rows.length; i++) {
            var row = [];
            var cols = rows[i].querySelectorAll('th, td');
            
            if (cols.length === 1 && cols[0].colSpan > 1) continue; // skip "Belum ada" row
            
            for (var j = 0; j < cols.length - 1; j++) {
                row.push(cols[j].innerText.trim().replace(/\n/g, ' '));
            }
            wsData.push(row);
        }

        var ws = XLSX.utils.aoa_to_sheet(wsData);
        XLSX.utils.book_append_sheet(wb, ws, "Riwayat Transaksi");

        XLSX.writeFile(wb, "riwayat_transaksi_pawon.xlsx");
    }
</script>
@endsection
