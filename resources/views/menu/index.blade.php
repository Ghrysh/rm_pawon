<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Rumah Makan Pawon Kang Bima</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="mobile-container menu-container">
        
        <div class="header">
            <a href="javascript:void(0)" onclick="document.getElementById('confirmBackModal').style.display='flex'" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </a>
            <div class="search-container">
                <input type="text" id="searchInput" class="search-input" placeholder="Lagi mau makan apa?" data-url="{{ route('menu.search') }}">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </div>
        </div>

        <div class="menu-list" id="menuList">
            @include('menu.partials.list', ['menus' => $menus])
        </div>

        @if(session('cart') && count(session('cart')) > 0)
        @php
            $totalQty = 0;
            $totalPrice = 0;
            foreach(session('cart') as $item) {
                $totalQty += $item['qty'];
                $totalPrice += ($item['qty'] * $item['price']);
            }
        @endphp
        <div class="cart-container">
            <a href="{{ route('cart.index') }}" class="cart-bar">
                <div class="cart-info">
                    <svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
                    <span>Rp.{{ number_format($totalPrice, 0, ',', '.') }} ({{ $totalQty }})</span>
                </div>
                <div class="btn-lihat-keranjang">
                    Lihat Keranjang
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
        </div>
        @endif

        <button class="floating-filter" id="filterBtn" @if(session('cart') && count(session('cart')) > 0) style="bottom: 110px;" @endif>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
            <span id="filterText">Menu</span>
        </button>

        <div class="modal-overlay" id="filterModal">
            <div class="modal-content" @if(session('cart') && count(session('cart')) > 0) style="margin-bottom: 160px;" @endif>
                <div class="category-item active" data-id="">
                    <span>Semua Menu</span>
                    <span></span>
                </div>
                @foreach($categories as $category)
                <div class="category-item" data-id="{{ $category->id }}">
                    <span>{{ $category->name }}</span>
                    <span>{{ $category->menus_count }}</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Back Modals -->
    <div id="confirmBackModal" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div class="admin-modal confirm-modal-box" style="background:#fff; padding:2.5rem 2rem; border-radius:12px; text-align:center; width:90%; max-width:400px; box-shadow:0 10px 25px rgba(0,0,0,0.2);">
            <div class="confirm-icon icon-warn" style="width:80px; height:80px; border-radius:50%; border:2px solid #555; display:flex; justify-content:center; align-items:center; font-size:3rem; font-weight:700; color:#555; margin:0 auto 1.5rem;">!</div>
            <h3 style="font-size:1.5rem; font-weight:700; margin-bottom:2rem; color:#111;">Yakin ingin kembali?</h3>
            <div class="confirm-actions" style="display:flex; justify-content:center; gap:1rem;">
                <button style="background:#3252b3; color:#fff; border:none; padding:0.6rem 2.5rem; border-radius:20px; font-weight:700; cursor:pointer; font-size:1rem;" onclick="document.getElementById('confirmBackModal').style.display='none'; document.getElementById('successBackModal').style.display='flex'">Yakin</button>
                <button style="background:#fff; color:#111; border:1px solid #777; padding:0.6rem 2.5rem; border-radius:20px; font-weight:700; cursor:pointer; font-size:1rem;" onclick="document.getElementById('confirmBackModal').style.display='none'">Batal</button>
            </div>
        </div>
    </div>

    <div id="successBackModal" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div class="admin-modal confirm-modal-box" style="background:#fff; padding:2.5rem 2rem; border-radius:12px; text-align:center; width:90%; max-width:400px; box-shadow:0 10px 25px rgba(0,0,0,0.2);">
            <div class="confirm-icon icon-success" style="width:80px; height:80px; border-radius:50%; border:2px solid #555; display:flex; justify-content:center; align-items:center; color:#555; margin:0 auto 1.5rem;">
                <svg viewBox="0 0 24 24" width="45" height="45" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <h3 style="font-size:1.5rem; font-weight:700; margin-bottom:0.8rem; color:#111;">Berhasil</h3>
            <p style="color:#555; font-size:0.95rem; font-weight:600; margin-bottom:2rem;">Anda akan dialihkan ke halaman awal.</p>
            <div class="confirm-actions" style="display:flex; justify-content:center;">
                <button type="button" style="background:#3252b3; color:#fff; border:none; padding:0.6rem 3rem; border-radius:20px; font-weight:700; cursor:pointer; font-size:1rem;" onclick="window.location.href='{{ url('/') }}'">Oke</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
