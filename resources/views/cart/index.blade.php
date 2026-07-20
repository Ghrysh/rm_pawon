<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Rumah Makan Pawon Kang Bima</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="mobile-container menu-container">
        
        <div class="header" style="position: sticky; top: 0; z-index: 10;">
            <a href="{{ route('menu.index') }}" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </a>
        </div>

        <div class="menu-list" style="padding-top: 1rem;">
            @php $totalPrice = 0; @endphp
            @forelse($cart as $id => $item)
            @php $totalPrice += ($item['qty'] * $item['price']); @endphp
            <div class="menu-card">
                <div class="menu-image">
                    @if(isset($item['image']) && $item['image'])
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
                    @else
                        <img src="{{ asset('assets/bg_mobile.png') }}" alt="{{ $item['name'] }}">
                    @endif
                </div>
                <div class="menu-details">
                    <div>
                        <h3 class="menu-title">{{ $item['name'] }}</h3>
                        <p class="menu-desc" style="color: #000;">
                            <strong>Catatan:</strong> {{ $item['catatan'] ?? '-' }}
                        </p>
                        <div class="menu-price">Rp. {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</div>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
                        <span style="font-weight: 700; font-size: 0.9rem; color: #000;">x{{ $item['qty'] }}</span>
                        <div style="display:flex; gap:0.5rem;">
                            <a href="{{ route('menu.show', $id) }}" class="btn-order" style="width: auto; padding: 0.3rem 1.2rem;">Ubah</a>
                            <button type="button" onclick="confirmRemoveCartItem('{{ $id }}')" style="background-color:#e74c3c; color:#fff; border:none; border-radius:30px; font-weight:700; cursor:pointer; width:auto; padding: 0.3rem 0.8rem;">x</button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <p>Keranjang Anda masih kosong.</p>
            </div>
            @endforelse
        </div>

        @if(count($cart) > 0)
        <form id="checkoutForm" action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <div class="cart-details-section" style="padding: 1rem; color: #fff;">
                <h4 style="margin-bottom: 0.5rem; font-size: 0.95rem;">Nomor Meja</h4>
                <select name="meja" id="mejaSelect" class="form-control" style="background: #fff; margin-bottom: 0.3rem; font-weight: 700;" required>
                    <option value="" disabled selected>Pilih Nomor Meja</option>
                    <option value="Dibungkus">Dibungkus</option>
                    @for($i = 1; $i <= 10; $i++)
                        @php 
                            $mejaNum = str_pad($i, 2, '0', STR_PAD_LEFT); 
                            $isBooked = in_array($mejaNum, $bookedTables ?? []);
                        @endphp
                        <option value="{{ $mejaNum }}" {{ $isBooked ? 'disabled style=color:#aaa;' : '' }}>
                            Meja {{ $mejaNum }} {{ $isBooked ? '(Dipesan)' : '' }}
                        </option>
                    @endfor
                </select>
                <div id="mejaError" style="color: #ff6b6b; font-size: 0.8rem; font-weight: 600; margin-bottom: 1.2rem; display: none;">* Silakan pilih nomor meja terlebih dahulu</div>

                <h4 style="margin-bottom: 0.5rem; font-size: 0.95rem;">Detail Pesanan</h4>
                <div style="background: #fff; border-radius: 8px; padding: 1rem; color: #000;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="font-weight: 700; font-size: 0.9rem;">Nama</span>
                        <span style="font-weight: 700; font-size: 0.9rem;">{{ session('nama') }}</span>
                    </div>
                    <hr style="border: none; border-top: 1.5px dashed #999; margin: 0.8rem 0;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-weight: 700; font-size: 0.9rem;">Total</span>
                        <span style="font-weight: 800; font-size: 0.9rem;">{{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="cart-container" style="background: transparent; box-shadow: none;">
                <button type="button" id="btnPesanSekarang" class="cart-bar" style="border: none; cursor: pointer; display: flex; justify-content: center; font-size: 1rem; font-weight: 700;">
                    Pesan Sekarang
                </button>
            </div>
        </form>
        @endif

    </div>

    <!-- Modals -->
    <div id="confirmModal" class="full-modal" style="display: none;">
        <div class="modal-box">
            <div class="modal-icon">?</div>
            <h2>Apakah pesanan<br>sudah benar ?</h2>
            <p>Pastikan pesanan sudah benar !!</p>
            <div class="modal-buttons">
                <button type="button" class="btn-belum" id="btnBelum">Belum</button>
                <button type="button" class="btn-sudah" id="btnSudah">Ya, Sudah</button>
            </div>
        </div>
    </div>

    <div id="successModal" class="full-modal" style="display: none;">
        <div class="modal-box">
            <div class="modal-icon-success">
                <svg viewBox="0 0 24 24" fill="none" stroke="#26160F" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <h2>Berhasil !</h2>
            <p>Pesanan anda sudah masuk</p>
            <div class="modal-alert">
                "SILAHKAN PERGI KE KASIR UNTUK MELAKUKAN PEMBAYARAN"
            </div>
            <button type="button" class="btn-oke" id="btnOke">OKE</button>
        </div>
    </div>

    <div id="confirmRemoveItemModal" class="full-modal" style="display: none;">
        <div class="modal-box">
            <div class="modal-icon icon-warn" style="font-size:3rem; font-weight:800; color:#555; width:80px; height:80px; border-radius:50%; border:4px solid #555; display:flex; justify-content:center; align-items:center; margin:0 auto 1rem;">!</div>
            <h3>Yakin ingin menghapus pesanan ini?</h3>
            <div class="modal-buttons" style="margin-top:2rem;">
                <button type="button" class="btn-belum" onclick="closeModal('confirmRemoveItemModal')">Batal</button>
                <form id="removeCartItemForm" method="POST" action="" style="flex: 1; margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sudah" style="width: 100%;">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmRemoveCartItem(id) {
            document.getElementById('removeCartItemForm').action = '{{ url("cart/remove") }}/' + id;
            document.getElementById('confirmRemoveItemModal').style.display = 'flex';
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }

        const btnPesanSekarang = document.getElementById('btnPesanSekarang');
        const mejaSelect = document.getElementById('mejaSelect');
        const mejaError = document.getElementById('mejaError');
        const confirmModal = document.getElementById('confirmModal');
        const successModal = document.getElementById('successModal');
        const btnBelum = document.getElementById('btnBelum');
        const btnSudah = document.getElementById('btnSudah');
        const btnOke = document.getElementById('btnOke');
        const checkoutForm = document.getElementById('checkoutForm');

        if (mejaSelect) {
            mejaSelect.addEventListener('change', () => {
                if (mejaSelect.value) {
                    mejaError.style.display = 'none';
                }
            });
        }

        if (btnPesanSekarang) {
            btnPesanSekarang.addEventListener('click', () => {
                if (!mejaSelect.value) {
                    mejaError.style.display = 'block';
                    mejaSelect.focus();
                    return;
                }
                mejaError.style.display = 'none';
                confirmModal.style.display = 'flex';
            });
        }

        if (btnBelum) {
            btnBelum.addEventListener('click', () => {
                confirmModal.style.display = 'none';
            });
        }

        if (btnSudah) {
            btnSudah.addEventListener('click', () => {
                confirmModal.style.display = 'none';
                successModal.style.display = 'flex';
            });
        }

        if (btnOke) {
            btnOke.addEventListener('click', () => {
                checkoutForm.submit();
            });
        }
    </script>
</body>
</html>
