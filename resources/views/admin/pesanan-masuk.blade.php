@extends('admin.layout')

@section('content')
<h1 class="page-title">Daftar Pesanan Masuk</h1>

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
                    <td class="status-waiting">
                        <span style="font-weight: 700; color: #111;">Menunggu Pembayaran</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon btn-blue" onclick="openModal('detailModal{{ $order->id }}')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                            <button class="btn-icon btn-yellow" onclick="openModal('editModal{{ $order->id }}')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </button>
                            <button class="btn-icon btn-red" onclick="openModal('confirmDeleteModal{{ $order->id }}')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($orders->count() == 0)
                <tr>
                    <td colspan="7" style="text-align:center; padding: 2rem;">Belum ada pesanan masuk.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@foreach($orders as $order)
<!-- Modal Detail -->
<div id="detailModal{{ $order->id }}" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div class="admin-modal" style="width: 90%; max-width: 700px; max-height: 90vh; background:#fff; border-radius:8px; overflow: hidden; border: 1px solid #111; padding-bottom: 0; display: flex; flex-direction: column; position: relative;">
        <div class="admin-modal-header" style="padding: 1rem 1.5rem; border-bottom: 1px solid #111; display:flex; justify-content:space-between; align-items:center; flex-shrink: 0;">
            <h2 style="margin:0; font-size:1.4rem; font-weight: 800;">Detail Pesanan</h2>
            <button onclick="closeModal('detailModal{{ $order->id }}')" style="background:none; border:none; font-size:1.8rem; cursor:pointer; color:#111; line-height:1;">&times;</button>
        </div>
        <div class="admin-modal-body" style="padding: 0; overflow-y: auto; flex: 1;">
            <div class="split-modal" style="display:flex; flex-wrap:wrap; min-height: 400px;">
                <div class="split-left" style="flex:1; padding: 1.5rem; border-right: 1px solid #111; min-width: 300px; display: flex; flex-direction: column;">
                    <div class="receipt-header" style="text-align:center; margin-bottom:1rem;">
                        <h2 style="margin:0; font-size:1.4rem; line-height:1.2; font-weight: 800;">Pawon<br>Kang Bima</h2>
                        <p style="font-size:0.85rem; margin-top:0.5rem; color:#888; font-weight: 700;">Jl. Raya Ciwidey - Patengan, Patengan,<br>Kec. Ciwidey, Kabupaten Bandung, Jawa<br>Barat 40973</p>
                    </div>
                    <hr class="dashed" style="border-top:2px dashed #aaa; margin: 1rem 0;">
                    <div class="receipt-info" style="font-size:0.9rem; font-weight:800; color: #111;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.4rem;">Waktu Pesan <span>{{ $order->created_at->format('d/m/Y H:i:s') }}</span></div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.4rem;">Nama <span>{{ $order->nama_pl }}</span></div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.4rem;">Meja <span>{{ str_pad($order->no_meja, 2, '0', STR_PAD_LEFT) }}</span></div>
                    </div>
                    <hr class="dashed" style="border-top:2px dashed #aaa; margin: 1rem 0;">
                    <div class="receipt-items" style="font-size:0.9rem; font-weight:800; color: #111;">
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
                    <br><br><br>
                    <hr class="dashed" style="border-top:2px dashed #aaa; margin: 1rem 0;">
                    <div class="receipt-summary" style="font-size:0.9rem; font-weight:800; color: #111;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.4rem;">Subtotal Pesanan <span>{{ $totalQty }} Item</span></div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.4rem;">Total Harga <span>{{ number_format($order->total_harga, 0, ',', '.') }}</span></div>
                    </div>
                    <hr class="dashed" style="border-top:2px dashed #aaa; margin: 1rem 0;">
                    <div class="receipt-payment" style="font-size:0.9rem; font-weight:800; color: #111;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.4rem;">Metode Pembayaran <span id="r_metode_{{ $order->id }}">-</span></div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.4rem;">Dibayar <span id="r_dibayar_val_{{ $order->id }}">-</span></div>
                        <div id="receipt_tunai_kembalian_{{ $order->id }}" style="display:flex; justify-content:space-between; margin-bottom:0;">Kembalian <span id="r_kembalian_val_{{ $order->id }}">-</span></div>
                    </div>
                    <hr class="dashed" style="border-top:2px dashed #aaa; margin: 1rem 0;">
                    <div class="receipt-footer" style="text-align:center; margin-top: auto; padding-top: 1rem;">
                        <h3 style="margin:0; font-weight: 800; font-size: 1.3rem;">Terima Kasih</h3>
                    </div>
                </div>
                <div class="split-right" style="flex:1; padding: 1.5rem; background:#fff; min-width: 300px; display: flex; flex-direction: column;">
                    <div class="form-group-modal" style="margin-bottom: 1.5rem; text-align: center;">
                        <label style="display:block; font-weight:800; font-size:1.2rem; margin-bottom:0.5rem; color:#111;">Metode Pembayaran</label>
                        <select id="metodePembayaran_{{ $order->id }}" class="modal-input custom-select-arrow" style="width:100%; text-align:left; padding:0.8rem 1rem; border-radius:8px; border:1px solid #111; font-weight:800; font-size: 1rem; background-color: #fff;" onchange="togglePayment('{{ $order->id }}')">
                            <option value="Tunai">Tunai</option>
                            <option value="Qris">Qris</option>
                        </select>
                    </div>
                    
                    <div class="form-group-modal" style="text-align: center; margin-bottom: 1.5rem;">
                        <label class="center-label" style="display:block; font-weight:800; font-size:1.2rem; margin-bottom:0.5rem; color:#111;">Total Harga</label>
                        <input type="text" class="modal-input large-input" value="Rp. {{ number_format($order->total_harga, 0, ',', '.') }}" readonly style="width:100%; text-align:left; padding:0.8rem 1rem; border-radius:8px; border:1px solid #111; font-weight:800; font-size:1.2rem; background:#fff; color:#888;">
                        <input type="hidden" id="totalHarga_{{ $order->id }}" value="{{ $order->total_harga }}">
                    </div>
                    
                    <div id="tunaiFields_{{ $order->id }}">
                        <div class="form-group-modal" style="text-align: center; margin-bottom: 1.5rem;">
                            <label class="center-label" style="display:block; font-weight:800; font-size:1.2rem; margin-bottom:0.5rem; color:#111;">Dibayar</label>
                            <input type="text" id="inputDibayarText_{{ $order->id }}" class="modal-input large-input" placeholder="Rp. 0" style="width:100%; text-align:left; padding:0.8rem 1rem; border-radius:8px; border:1px solid #111; font-weight:800; font-size:1.2rem; background:#fff; color:#111;" oninput="formatCurrencyInput(this, '{{ $order->id }}')">
                            <input type="hidden" id="inputDibayar_{{ $order->id }}" value="0">
                        </div>
                        
                        <div class="form-group-modal" style="text-align: center; margin-bottom: 1.5rem;">
                            <label class="center-label" style="display:block; font-weight:800; font-size:1.2rem; margin-bottom:0.5rem; color:#111;">Kembalian</label>
                            <input type="text" id="inputKembalian_{{ $order->id }}" class="modal-input large-input" value="Rp. 0" readonly style="width:100%; text-align:left; padding:0.8rem 1rem; border-radius:8px; border:1px solid #111; font-weight:800; font-size:1.2rem; background:#fff; color:#888;">
                            <input type="hidden" id="kembalianVal_{{ $order->id }}" value="0">
                        </div>
                    </div>

                    <div class="modal-actions-right" style="margin-bottom: 1rem; display: flex; justify-content: flex-end;">
                        <button type="button" id="btnAction_{{ $order->id }}" style="width:150px; background:#9e1b1b; color:#fff; border:none; padding:0.6rem; border-radius:20px; font-weight:800; font-size:1rem; cursor:pointer;" onclick="handleActionClick('{{ $order->id }}')">Bayar</button>
                    </div>
                    
                    <div class="modal-footer-right" style="position: absolute; bottom: 1.5rem; right: 2.3rem; z-index: 100;">
                        <button type="button" id="btnCetak_{{ $order->id }}" disabled style="width:150px; background:#ccc; color:#fff; border:none; padding:0.6rem; border-radius:20px; font-weight:800; font-size:1rem; cursor:not-allowed;" onclick="handleCetakStruk('{{ $order->id }}')">Cetak Struk</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Bayar -->
<div id="confirmBayarModal{{ $order->id }}" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:10000; justify-content:center; align-items:center;">
    <div class="admin-modal confirm-modal-box" style="background:#fff; padding:2.5rem 2.5rem; border-radius:24px; text-align:center; width:90%; max-width:500px; box-shadow:0 10px 40px rgba(0,0,0,0.1);">
        <div style="width:100px; height:100px; border-radius:50%; border:4px solid #666; display:flex; justify-content:center; align-items:center; margin:0 auto 1rem;">
            <span style="font-size:4rem; font-weight:800; color:#666; font-family:sans-serif;">?</span>
        </div>
        <h3 style="font-size:1.6rem; font-weight:800; margin-bottom:0.5rem; color:#000;">Konfirmasi Pembayaran?</h3>
        <p style="font-size:1.1rem; color:#111; margin-bottom:1.5rem;">Pastikan uang yang diterima sudah sesuai</p>
        <div class="confirm-actions" style="display:flex; justify-content:center; gap:1rem;">
            <button type="button" style="background:#3358d4; color:#fff; border:none; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;" onclick="confirmPaymentUI('{{ $order->id }}')">Ya, Bayar</button>
            <button type="button" onclick="closeModal('confirmBayarModal{{ $order->id }}')" style="background:#fff; color:#555; border:1px solid #666; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Batal</button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Selesai -->
<div id="confirmSelesaiModal{{ $order->id }}" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:10000; justify-content:center; align-items:center;">
    <div class="admin-modal confirm-modal-box" style="background:#fff; padding:2.5rem 2.5rem; border-radius:24px; text-align:center; width:90%; max-width:500px; box-shadow:0 10px 40px rgba(0,0,0,0.1);">
        <div style="width:100px; height:100px; border-radius:50%; border:4px solid #666; display:flex; justify-content:center; align-items:center; margin:0 auto 1rem;">
            <svg viewBox="0 0 24 24" width="50" height="50" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round" style="color: #666;"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
        <h3 style="font-size:1.6rem; font-weight:800; margin-bottom:0.5rem; color:#000;">Selesaikan Pesanan?</h3>
        <p style="font-size:1.1rem; color:#111; margin-bottom:1.5rem;">Pesanan akan diproses ke dapur.</p>
        <div class="confirm-actions" style="display:flex; justify-content:center; gap:1rem;">
            <form action="{{ route('admin.pesanan.pay', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="metode_pembayaran" id="submitMetode_{{ $order->id }}" value="Tunai">
                <input type="hidden" name="dibayar" id="submitDibayar_{{ $order->id }}" value="0">
                <input type="hidden" name="kembalian" id="submitKembalian_{{ $order->id }}" value="0">
                <button type="button" style="background:#3358d4; color:#fff; border:none; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;" onclick="submitPayment('{{ $order->id }}', this)">Ya, Selesai</button>
            </form>
            <button type="button" onclick="closeModal('confirmSelesaiModal{{ $order->id }}')" style="background:#fff; color:#555; border:1px solid #666; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Batal</button>
        </div>
    </div>
</div>

<!-- Modal Peringatan Uang Kurang -->
<div id="warningKurangModal{{ $order->id }}" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:10000; justify-content:center; align-items:center;">
    <div class="admin-modal confirm-modal-box" style="background:#fff; padding:2.5rem 2.5rem; border-radius:24px; text-align:center; width:90%; max-width:500px; box-shadow:0 10px 40px rgba(0,0,0,0.1);">
        <div style="width:100px; height:100px; border-radius:50%; border:4px solid #bb1f21; display:flex; justify-content:center; align-items:center; margin:0 auto 1rem;">
            <span style="font-size:4rem; font-weight:800; color:#bb1f21; font-family:sans-serif;">!</span>
        </div>
        <h3 style="font-size:1.6rem; font-weight:800; margin-bottom:0.5rem; color:#000;">Niminal Uang Kurang!</h3>
        <p style="font-size:1.1rem; color:#111; margin-bottom:1.5rem;">Maaf, nominal uang yang dibayar kurang dari total harga.</p>
        <div class="confirm-actions" style="display:flex; justify-content:center; gap:1rem;">
            <button type="button" onclick="closeModal('warningKurangModal{{ $order->id }}')" style="background:#3358d4; color:#fff; border:none; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Oke Mengerti</button>
        </div>
    </div>
</div>

<!-- Modal Edit Pesanan -->
<div id="editModal{{ $order->id }}" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div class="admin-modal" style="width:90%; max-width: 700px; max-height: 90vh; padding:0; border-radius: 12px; background:#f8f8f8; overflow:hidden; display: flex; flex-direction: column;">
        <div class="admin-modal-header" style="border-bottom: 1px solid #ccc; padding: 1rem 1.5rem; background:#fff; display:flex; justify-content:space-between; align-items:center; flex-shrink: 0;">
            <h3 style="margin:0; font-size:1.2rem;">Edit Pesanan</h3>
            <button type="button" onclick="closeModal('editModal{{ $order->id }}')" style="background:none; border:none; font-size:1.8rem; cursor:pointer; color:#111; line-height:1;">&times;</button>
        </div>
        <form id="editForm{{ $order->id }}" action="{{ route('admin.pesanan.items', $order->id) }}" method="POST" style="display: flex; flex-direction: column; overflow: hidden; flex: 1;">
            @csrf
            @method('PUT')
            <div class="admin-modal-body" style="padding: 1.5rem; overflow-y: auto; flex: 1;">
                @foreach($order->items as $item)
                <div class="edit-item-card" style="background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.05); margin-bottom:1rem; overflow:hidden;" id="itemCard_{{ $item->id }}">
                    <div class="edit-item-header" style="display:flex; justify-content:space-between; align-items:center; padding:1rem; border-bottom:1px solid #eee;">
                        <h4 style="margin:0; font-size:1rem;">Nama Pesanan</h4>
                        <button type="button" style="background:#ff4d4f; color:#fff; border:none; width:28px; height:28px; border-radius:6px; font-weight:bold; cursor:pointer; display:flex; justify-content:center; align-items:center;" onclick="removeItem('{{ $item->id }}')">
                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </button>
                    </div>
                    <div class="edit-item-body" style="padding:1rem;">
                        <div style="font-weight: 800; font-size:1.1rem; margin-bottom: 0.2rem;">{{ $item->menu->name }}</div>
                        <div style="font-size: 0.85rem; font-weight: 700; margin-bottom: 0.2rem;">Harga</div>
                        <div class="item-price" style="color: #777; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem;">Rp. {{ number_format($item->price, 0, ',', '.') }}</div>
                        <div style="font-size: 0.85rem; font-weight: 700;">Catatan: {{ $item->catatan }}</div>
                        <div class="qty-control-wrapper" style="display:flex; justify-content:flex-end; margin-top:0.5rem;">
                            <div class="qty-control-edit" style="display:flex; align-items:center; background:#f0f0f0; border-radius:20px; padding:0.2rem;">
                                <button type="button" style="width:28px; height:28px; border-radius:50%; background:#fff; border:1px solid #ddd; font-weight:bold; cursor:pointer; display:flex; justify-content:center; align-items:center;" onclick="updateQty('{{ $item->id }}', -1)">-</button>
                                <input type="text" name="items[{{ $item->id }}]" id="qty_{{ $item->id }}" value="{{ $item->qty }}" readonly style="width:40px; text-align:center; border:none; background:transparent; font-weight:bold; font-size:1rem;">
                                <button type="button" style="width:28px; height:28px; border-radius:50%; background:#fff; border:1px solid #ddd; font-weight:bold; cursor:pointer; display:flex; justify-content:center; align-items:center;" onclick="updateQty('{{ $item->id }}', 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="admin-modal-footer" style="padding: 1rem 1.5rem; background:#fff; display:flex; justify-content:flex-end; gap:1rem; border-top:1px solid #ccc; flex-shrink: 0;">
                <button type="button" class="btn-edit-simpan" style="font-size: 1rem; padding: 0.6rem 2rem; border-radius: 20px; background:#3252b3; color:#fff; border:none; font-weight:bold; cursor:pointer;" onclick="openModal('confirmEditModal{{ $order->id }}')">Simpan</button>
                <button type="button" style="font-size: 1rem; padding: 0.6rem 2rem; border-radius: 20px; background:#fff; color:#111; border:1px solid #777; font-weight:bold; cursor:pointer;" onclick="closeModal('editModal{{ $order->id }}')">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Edit Pesanan -->
<div id="confirmEditModal{{ $order->id }}" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:10000; justify-content:center; align-items:center;">
    <div class="admin-modal confirm-modal-box" style="background:#fff; padding:2.5rem 2.5rem; border-radius:24px; text-align:center; width:90%; max-width:500px; box-shadow:0 10px 40px rgba(0,0,0,0.1);">
        <div style="width:100px; height:100px; border-radius:50%; border:4px solid #666; display:flex; justify-content:center; align-items:center; margin:0 auto 1rem;">
            <span style="font-size:4rem; font-weight:800; color:#666; font-family:sans-serif;">!</span>
        </div>
        <h3 style="font-size:1.6rem; font-weight:800; margin-bottom:0.5rem; color:#000;">Yakin ingin mengedit?</h3>
        <p style="font-size:1.1rem; color:#111; margin-bottom:1.5rem;">Pesanan akan diedit permanen</p>
        <div class="confirm-actions" style="display:flex; justify-content:center; gap:1rem;">
            <button type="button" onclick="document.getElementById('editForm{{ $order->id }}').submit()" style="background:#3358d4; color:#fff; border:none; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Ya, Edit</button>
            <button type="button" onclick="closeModal('confirmEditModal{{ $order->id }}')" style="background:#fff; color:#555; border:1px solid #666; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Batal</button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Pesanan -->
<div id="confirmDeleteModal{{ $order->id }}" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:10000; justify-content:center; align-items:center;">
    <div class="admin-modal confirm-modal-box" style="background:#fff; padding:2.5rem 2.5rem; border-radius:24px; text-align:center; width:90%; max-width:500px; box-shadow:0 10px 40px rgba(0,0,0,0.1);">
        <div style="width:100px; height:100px; border-radius:50%; border:4px solid #666; display:flex; justify-content:center; align-items:center; margin:0 auto 1rem;">
            <span style="font-size:4rem; font-weight:800; color:#666; font-family:sans-serif;">!</span>
        </div>
        <h3 style="font-size:1.6rem; font-weight:800; margin-bottom:0.5rem; color:#000;">Yakin ingin menghapus?</h3>
        <p style="font-size:1.1rem; color:#111; margin-bottom:1.5rem;">Pesanan akan hapus permanen</p>
        <div class="confirm-actions" style="display:flex; justify-content:center; gap:1rem;">
            <form action="{{ route('admin.pesanan.destroy', $order->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" style="background:#3358d4; color:#fff; border:none; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Ya, Hapus</button>
            </form>
            <button type="button" onclick="closeModal('confirmDeleteModal{{ $order->id }}')" style="background:#fff; color:#555; border:1px solid #666; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Batal</button>
        </div>
    </div>
</div>
@endforeach

<style>
.custom-select-arrow {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='none' stroke='%23111' stroke-width='3' stroke-linecap='round' stroke-linejoin='round' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 16px;
}
</style>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function togglePayment(orderId) {
        try {
            var elMetode = document.getElementById('metodePembayaran_' + orderId);
            if (!elMetode) return;
            var metode = elMetode.value;
            
            var tunaiFields = document.getElementById('tunaiFields_' + orderId);
            
            if (metode === 'Tunai') {
                if (tunaiFields) tunaiFields.style.display = 'block';
                calculateKembalian(orderId);
            } else {
                if (tunaiFields) tunaiFields.style.display = 'none';
            }
        } catch (e) {
            console.error("togglePayment error: ", e);
        }
    }
    
    function formatCurrencyInput(input, orderId) {
        try {
            var rawValue = input.value.replace(/[^0-9]/g, '');
            if (!rawValue) rawValue = '0';
            
            var numericValue = parseInt(rawValue, 10);
            
            if (numericValue === 0) {
                input.value = '';
            } else {
                input.value = 'Rp. ' + numericValue.toLocaleString('id-ID');
            }
            
            var hiddenDibayar = document.getElementById('inputDibayar_' + orderId);
            if (hiddenDibayar) hiddenDibayar.value = numericValue;
            
            calculateKembalian(orderId);
        } catch (e) {
            console.error("formatCurrencyInput error: ", e);
        }
    }
    
    function calculateKembalian(orderId) {
        try {
            var elDibayar = document.getElementById('inputDibayar_' + orderId);
            var dibayar = elDibayar ? (parseFloat(elDibayar.value) || 0) : 0;
            
            var elTotal = document.getElementById('totalHarga_' + orderId);
            var total = elTotal ? (parseFloat(elTotal.value) || 0) : 0;
            
            var kembalian = dibayar - total;
            
            var elInputKembalian = document.getElementById('inputKembalian_' + orderId);
            if (elInputKembalian) {
                if (kembalian < 0) {
                    elInputKembalian.value = '-Rp. ' + Math.abs(kembalian).toLocaleString('id-ID');
                    elInputKembalian.style.color = '#bb1f21';
                } else {
                    elInputKembalian.value = 'Rp. ' + kembalian.toLocaleString('id-ID');
                    elInputKembalian.style.color = '#888';
                }
            }
            
            var elKembalianVal = document.getElementById('kembalianVal_' + orderId);
            if (elKembalianVal) elKembalianVal.value = kembalian;
        } catch (e) {
            console.error("calculateKembalian error: ", e);
        }
    }

    function handleActionClick(orderId) {
        var btn = document.getElementById('btnAction_' + orderId);
        if (btn.innerText === 'Bayar') {
            var metode = document.getElementById('metodePembayaran_' + orderId).value;
            if (metode === 'Tunai') {
                var elDibayar = document.getElementById('inputDibayar_' + orderId);
                var dibayar = elDibayar ? (parseFloat(elDibayar.value) || 0) : 0;
                
                var elTotal = document.getElementById('totalHarga_' + orderId);
                var total = elTotal ? (parseFloat(elTotal.value) || 0) : 0;
                
                if (dibayar < total) {
                    openModal('warningKurangModal' + orderId);
                    return;
                }
            }
            openModal('confirmBayarModal' + orderId);
        } else if (btn.innerText === 'Selesai' && !btn.disabled) {
            openModal('confirmSelesaiModal' + orderId);
        }
    }

    function confirmPaymentUI(orderId) {
        closeModal('confirmBayarModal' + orderId);
        
        // Update Receipt Values on the left
        var metode = document.getElementById('metodePembayaran_' + orderId).value;
        document.getElementById('r_metode_' + orderId).innerText = metode;
        
        var rKembalianRow = document.getElementById('receipt_tunai_kembalian_' + orderId);
        var rDibayarVal = document.getElementById('r_dibayar_val_' + orderId);
        var rKembalianVal = document.getElementById('r_kembalian_val_' + orderId);
        
        var elTotal = document.getElementById('totalHarga_' + orderId);
        var totalHarga = elTotal ? (parseFloat(elTotal.value) || 0) : 0;
        
        if (metode === 'Tunai') {
            if (rKembalianRow) rKembalianRow.style.display = 'flex';
            var dibayar = parseFloat(document.getElementById('inputDibayar_' + orderId).value) || 0;
            var kembalian = parseFloat(document.getElementById('kembalianVal_' + orderId).value) || 0;
            if (rDibayarVal) rDibayarVal.innerText = dibayar.toLocaleString('id-ID');
            if (rKembalianVal) rKembalianVal.innerText = kembalian.toLocaleString('id-ID');
        } else {
            if (rKembalianRow) rKembalianRow.style.display = 'none';
            if (rDibayarVal) rDibayarVal.innerText = totalHarga.toLocaleString('id-ID');
        }
        
        // Disable Inputs
        document.getElementById('metodePembayaran_' + orderId).disabled = true;
        var inputDibayarText = document.getElementById('inputDibayarText_' + orderId);
        if(inputDibayarText) inputDibayarText.disabled = true;
        
        // Enable Cetak Struk button
        var btnCetak = document.getElementById('btnCetak_' + orderId);
        btnCetak.disabled = false;
        btnCetak.style.background = '#3252b3';
        btnCetak.style.cursor = 'pointer';
        
        // Change Bayar to Selesai and disable it initially
        var btnAction = document.getElementById('btnAction_' + orderId);
        btnAction.innerText = 'Selesai';
        btnAction.disabled = true;
        btnAction.style.background = '#ccc';
        btnAction.style.cursor = 'not-allowed';
    }

    function handleCetakStruk(orderId) {
        var printContents = document.querySelector('#detailModal' + orderId + ' .split-left').innerHTML;
        var iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        document.body.appendChild(iframe);
        iframe.contentDocument.write('<html><head><title>Cetak Struk</title>');
        iframe.contentDocument.write('<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">');
        iframe.contentDocument.write('<style>body { font-family: "Poppins", sans-serif; padding: 20px; } .dashed { border-top: 2px dashed #aaa; } .receipt-header h2 { font-weight: 800; font-size: 1.4rem; } .receipt-info, .receipt-items, .receipt-summary, .receipt-payment { font-weight: 800; font-size: 0.9rem; }</style>');
        iframe.contentDocument.write('</head><body>');
        iframe.contentDocument.write(printContents);
        iframe.contentDocument.write('</body></html>');
        iframe.contentDocument.close();
        iframe.contentWindow.focus();
        iframe.contentWindow.print();
        
        setTimeout(function() {
            document.body.removeChild(iframe);
            // After printing, enable the Selesai button
            var btnAction = document.getElementById('btnAction_' + orderId);
            if(btnAction && btnAction.innerText === 'Selesai') {
                btnAction.disabled = false;
                btnAction.style.background = '#9e1b1b';
                btnAction.style.cursor = 'pointer';
            }
        }, 500);
    }

    function submitPayment(orderId, btn) {
        var form = btn.closest('form');
        document.getElementById('submitMetode_' + orderId).value = document.getElementById('metodePembayaran_' + orderId).value;
        var dibayar = document.getElementById('inputDibayar_' + orderId) ? document.getElementById('inputDibayar_' + orderId).value : 0;
        document.getElementById('submitDibayar_' + orderId).value = dibayar || 0;
        var kembalian = document.getElementById('kembalianVal_' + orderId) ? document.getElementById('kembalianVal_' + orderId).value : 0;
        document.getElementById('submitKembalian_' + orderId).value = kembalian || 0;
        form.submit();
    }

    function updateQty(itemId, change) {
        var input = document.getElementById('qty_' + itemId);
        var current = parseInt(input.value) || 1;
        var newValue = current + change;
        if (newValue < 1) newValue = 1;
        input.value = newValue;
    }

    function removeItem(itemId) {
        var input = document.getElementById('qty_' + itemId);
        input.value = 0;
        document.getElementById('itemCard_' + itemId).style.display = 'none';
    }
</script>
@endsection
