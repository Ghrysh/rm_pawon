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
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; margin-bottom:1.5rem; background:#fff; padding:1.5rem; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.05);">
        <div style="display:flex; gap:1rem; align-items:center; flex-wrap:wrap;">
            <div style="display:flex; gap:0.5rem; background:#f0f2f5; padding:0.4rem; border-radius:10px;">
                <button type="button" class="filter-tab active" data-value="semua" onclick="setFilterType(this)">Semua</button>
                <button type="button" class="filter-tab" data-value="dine-in" onclick="setFilterType(this)">Dine In</button>
                <button type="button" class="filter-tab" data-value="take-away" onclick="setFilterType(this)">Take Away</button>
            </div>
            <input type="hidden" id="filterType" value="semua">
            
            <style>
            .filter-tab {
                background: transparent;
                color: #555;
                border: none;
                padding: 0.6rem 1.2rem;
                border-radius: 8px;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s ease;
            }
            .filter-tab.active {
                background: #fff;
                color: #3252b3;
                box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            }
            </style>
            <div style="display:flex; align-items:center; gap:0.5rem; background:#fff; border:1px solid #ccc; border-radius:8px; padding:0 1rem;">
                <label for="filterDate" style="font-weight:700; color:#555;">Tanggal:</label>
                <input type="date" id="filterDate" style="padding:0.8rem 0.5rem; border:none; font-weight:600; outline:none; background:transparent;" onchange="filterRiwayat()">
                <button type="button" onclick="document.getElementById('filterDate').value=''; filterRiwayat();" style="background:none; border:none; color:#999; cursor:pointer; font-weight:700;">&times;</button>
            </div>
        </div>
        <div>
            <input type="text" class="search-input-table" id="searchInput" placeholder="Cari Pesanan" style="padding:0.8rem 1rem; border-radius:8px; border:1px solid #ccc; font-weight:600; outline:none; width: 250px;">
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table" id="riwayatTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama PL</th>
                    <th>No Meja</th>
                    <th>Pesanan</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                <tr class="data-row">
                    <td><strong>{{ $index + 1 }}</strong></td>
                    <td><strong>{{ $order->created_at->format('H.i.s-d-m-Y') }}</strong></td>
                    <td><strong>{{ $order->nama_pl }}</strong></td>
                    <td class="col-meja"><strong>{{ $order->no_meja }}</strong></td>
                    <td class="col-pesanan" style="max-width: 250px;">
                        @php
                            $pesananArr = [];
                            foreach($order->items as $item) {
                                $pesananArr[] = $item->menu->name . ' (' . $item->qty . ')';
                            }
                            echo '<strong>' . implode(', ', $pesananArr) . '</strong>';
                        @endphp
                    </td>
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
                <tr id="emptyRow" style="display:none;">
                    <td colspan="8" style="text-align:center; padding: 2rem;">Data tidak ditemukan.</td>
                </tr>
                @if($orders->count() == 0)
                <tr>
                    <td colspan="8" style="text-align:center; padding: 2rem;">Belum ada riwayat transaksi.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@foreach($orders as $order)
<div id="detailModal{{ $order->id }}" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div class="admin-modal" style="max-width: 450px; max-height: 90vh; background:#fff; border-radius:12px; display: flex; flex-direction: column; overflow: hidden; position: relative;">
        <div class="admin-modal-header" style="padding: 1rem 1.5rem; border-bottom: 1px solid #eee; display:flex; justify-content:space-between; align-items:center; flex-shrink: 0;">
            <h3 style="margin:0;">Detail Pesanan</h3>
            <button onclick="closeModal('detailModal{{ $order->id }}')" style="background:none; border:none; font-size:1.8rem; cursor:pointer; color:#111; line-height:1;">&times;</button>
        </div>
        <div class="admin-modal-body" style="padding: 1.5rem; font-family: monospace; overflow-y: auto; flex: 1;">
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

    // Prevent global search logic from layout.blade.php
    document.getElementById('searchInput').addEventListener('input', function(e) {
        e.stopPropagation();
        filterRiwayat();
    });

    function setFilterType(btn) {
        document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('filterType').value = btn.getAttribute('data-value');
        filterRiwayat();
    }

    function filterRiwayat() {
        const type = document.getElementById('filterType').value;
        const dateRaw = document.getElementById('filterDate').value;
        const search = document.getElementById('searchInput').value.toLowerCase();
        
        // Format date from YYYY-MM-DD to DD-MM-YYYY to match table format "H.i.s-d-m-Y"
        let dateFormatted = "";
        if (dateRaw) {
            const parts = dateRaw.split('-');
            if (parts.length === 3) {
                dateFormatted = parts[2] + '-' + parts[1] + '-' + parts[0];
            }
        }

        const table = document.getElementById('riwayatTable');
        const rows = table.querySelectorAll('tbody tr.data-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const noMeja = row.querySelector('.col-meja').innerText.trim().toLowerCase();
            const dateStr = row.cells[1].innerText.trim();
            const textContent = row.innerText.toLowerCase();
            
            let showType = true;
            if (type === 'dine-in') showType = noMeja !== 'take away';
            if (type === 'take-away') showType = noMeja === 'take away';

            let showDate = true;
            if (dateFormatted) {
                // dateStr format is H.i.s-d-m-Y e.g. 15.30.00-04-07-2026
                showDate = dateStr.includes(dateFormatted);
            }

            let showSearch = true;
            if (search) {
                showSearch = textContent.includes(search);
            }

            if (showType && showDate && showSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const emptyRow = document.getElementById('emptyRow');
        if (emptyRow) {
            emptyRow.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
        }
    }

    function exportToExcel() {
        var table = document.getElementById("riwayatTable");
        var wb = XLSX.utils.book_new();
        
        var wsData = [];
        var rows = table.querySelectorAll('tr');
        
        for (var i = 0; i < rows.length; i++) {
            if (rows[i].style.display === 'none') continue; // Skip hidden rows from filter
            
            var row = [];
            var cols = rows[i].querySelectorAll('th, td');
            
            if (cols.length === 1 && cols[0].colSpan > 1) continue; // skip "Belum ada" / empty row
            
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
