@if($menus->isEmpty())
    <div class="empty-state">
        <p>Menu tidak ditemukan.</p>
    </div>
@else
    @foreach($menus as $menu)
    <div class="menu-card">
        <div class="menu-image">
            @if($menu->image)
                <img src="{{ asset($menu->image) }}" alt="{{ $menu->name }}">
            @else
                <img src="{{ asset('assets/bg_mobile.png') }}" alt="{{ $menu->name }}">
            @endif
        </div>
        <div class="menu-details">
            <div>
                <h3 class="menu-title">{{ $menu->name }}</h3>
                <p class="menu-desc" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;">{{ $menu->description }}</p>
                <div class="menu-price">Rp. {{ number_format($menu->price, 0, ',', '.') }}</div>
            </div>
            <a href="{{ route('menu.show', $menu->id) }}" class="btn-order">Buat Pesanan</a>
        </div>
    </div>
    @endforeach
@endif
