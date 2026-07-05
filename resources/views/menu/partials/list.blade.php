@if($menus->isEmpty())
    <div class="empty-state">
        <p>Menu tidak ditemukan.</p>
    </div>
@else
    @foreach($menus as $menu)
    @php $isOutOfStock = $menu->stok == 0; @endphp
    <div class="menu-card {{ $isOutOfStock ? 'out-of-stock' : '' }}" style="cursor: {{ $isOutOfStock ? 'not-allowed' : 'pointer' }};" {!! $isOutOfStock ? '' : 'onclick="window.location.href=\''.route('menu.show', $menu->id).'\'"' !!}>
        <div class="menu-image {{ $isOutOfStock ? 'out-of-stock' : '' }}">
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
            @if($isOutOfStock)
                <button type="button" class="btn-order out-of-stock">Habis</button>
            @else
                <a href="{{ route('menu.show', $menu->id) }}" class="btn-order">Buat Pesanan</a>
            @endif
        </div>
    </div>
    @endforeach
@endif
