<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Menu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="mobile-container">
        <div class="header" style="position: sticky; top: 0; z-index: 10; padding: 1rem;">
            <a href="{{ $inCart ? route('cart.index') : route('menu.index') }}" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </a>
        </div>

        <div class="detail-img-container" style="padding: 0 1rem;">
            @if($menu->image)
                <img src="{{ asset($menu->image) }}" alt="{{ $menu->name }}" style="border-radius: 8px;">
            @else
                <img src="{{ asset('assets/bg_mobile.png') }}" alt="{{ $menu->name }}" style="border-radius: 8px;">
            @endif
        </div>

        <div class="detail-card">
            <h1 class="detail-title">{{ $menu->name }}</h1>
            <p class="detail-desc">{{ $menu->description }}</p>
            <div class="detail-price">Rp. {{ number_format($menu->price, 0, ',', '.') }}</div>
            <div class="detail-stock" style="margin-bottom: 1rem; font-weight: 700; color: #666;">Stok: {{ $menu->stok }}</div>

            <form action="{{ route('cart.add') }}" method="POST" class="detail-form" id="addToCartForm">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                <input type="hidden" name="qty" id="inputQty" value="{{ $inCart ? $cartItem['qty'] : 1 }}">
                <input type="hidden" name="is_update" value="{{ $inCart ? '1' : '0' }}">
                
                <label>Catatan</label>
                <textarea name="catatan" placeholder="Masukan Catatan...">{{ $inCart ? $cartItem['catatan'] : '' }}</textarea>
            </form>
        </div>

        <div class="detail-bottom">
            <div class="qty-control">
                <button type="button" class="btn-qty" id="btnMinus">-</button>
                <span class="qty-val" id="qtyDisplay">{{ $inCart ? $cartItem['qty'] : 1 }}</span>
                <button type="button" class="btn-qty" id="btnPlus">+</button>
            </div>
            <button type="button" class="btn-add-cart" id="btnSubmitForm">
                {{ $inCart ? 'Ubah' : 'Tambah - ' . number_format($menu->price * ($inCart ? $cartItem['qty'] : 1), 0, ',', '.') }}
            </button>
        </div>
    </div>

    <script>
        const basePrice = {{ $menu->price }};
        let qty = {{ $inCart ? $cartItem['qty'] : 1 }};
        const inCart = {{ $inCart ? 'true' : 'false' }};

        const btnMinus = document.getElementById('btnMinus');
        const btnPlus = document.getElementById('btnPlus');
        const qtyDisplay = document.getElementById('qtyDisplay');
        const inputQty = document.getElementById('inputQty');
        const btnSubmitForm = document.getElementById('btnSubmitForm');
        const addToCartForm = document.getElementById('addToCartForm');

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }

        function updateDisplay() {
            qtyDisplay.innerText = qty;
            inputQty.value = qty;
            if (inCart) {
                btnSubmitForm.innerText = 'Ubah';
            } else {
                btnSubmitForm.innerText = 'Tambah - ' + formatRupiah(basePrice * qty);
            }
        }

        const maxQty = {{ $menu->stok }};

        btnMinus.addEventListener('click', () => {
            if (qty > 1) {
                qty--;
                updateDisplay();
            }
        });

        btnPlus.addEventListener('click', () => {
            if (qty < maxQty) {
                qty++;
                updateDisplay();
            } else {
                alert('Maksimal stok untuk menu ini adalah ' + maxQty);
            }
        });

        btnSubmitForm.addEventListener('click', () => {
            if (maxQty === 0) {
                alert('Mohon maaf, stok sedang kosong');
                return;
            }
            if (qty > maxQty) {
                alert('Maksimal pembelian adalah ' + maxQty);
                return;
            }
            addToCartForm.submit();
        });
    </script>
</body>
</html>
