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
            <a href="{{ url('/') }}" class="btn-back">
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
                    <span>Semua Kategori</span>
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

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
