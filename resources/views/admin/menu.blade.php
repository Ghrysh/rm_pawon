@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h1 class="page-title" style="margin-bottom:0;">Daftar Menu</h1>
    <a href="{{ route('admin.menu.create') }}" class="btn-tambah-menu" style="text-decoration:none;">+ Tambah Menu</a>
</div>

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
    <div class="table-header" style="justify-content: flex-end;">
        <input type="text" class="search-input-table" placeholder="Cari Menu">
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>Keterangan</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $index => $m)
                <tr>
                    <td><strong>{{ $index + 1 }}</strong></td>
                    <td>
                        @if($m->image)
                            <img src="{{ asset($m->image) }}" alt="{{ $m->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                        @else
                            <div class="menu-img-preview-sm" style="font-size:0.6rem;">No Img</div>
                        @endif
                    </td>
                    <td><strong>{{ $m->name }}</strong></td>
                    <td><strong>Rp.{{ number_format($m->price, 0, ',', '.') }}</strong></td>
                    <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><strong>{{ $m->description }}</strong></td>
                    <td><strong>{{ $m->stok }}</strong></td>
                    <td><strong>{{ $m->category ? $m->category->name : '-' }}</strong></td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.menu.show', $m->id) }}" class="btn-icon btn-blue">
                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                            <a href="{{ route('admin.menu.edit', $m->id) }}" class="btn-icon btn-yellow">
                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                            <button class="btn-icon btn-red" onclick="confirmDelete('{{ $m->id }}')">
                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($menus->count() == 0)
                <tr>
                    <td colspan="7" style="text-align:center; padding: 2rem;">Belum ada menu.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="confirmDeleteModal" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:10000; justify-content:center; align-items:center;">
    <div class="admin-modal confirm-modal-box" style="background:#fff; padding:2.5rem 2.5rem; border-radius:24px; text-align:center; width:90%; max-width:500px; box-shadow:0 10px 40px rgba(0,0,0,0.1);">
        <div style="width:100px; height:100px; border-radius:50%; border:4px solid #666; display:flex; justify-content:center; align-items:center; margin:0 auto 1rem;">
            <span style="font-size:4rem; font-weight:800; color:#666; font-family:sans-serif;">!</span>
        </div>
        <h3 style="font-size:1.6rem; font-weight:800; margin-bottom:0.5rem; color:#000;">Yakin ingin menghapus?</h3>
        <p style="font-size:1.1rem; color:#111; margin-bottom:1.5rem;">Menu akan dihapus permanen</p>
        <div class="confirm-actions" style="display:flex; justify-content:center; gap:1rem;">
            <form id="formDeleteMenu" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" style="background:#3358d4; color:#fff; border:none; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Ya, Hapus</button>
            </form>
            <button type="button" onclick="closeModal('confirmDeleteModal')" style="background:#fff; color:#555; border:1px solid #666; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Batal</button>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function confirmDelete(id) {
        document.getElementById('formDeleteMenu').action = '{{ url("admin/menu") }}/' + id;
        openModal('confirmDeleteModal');
    }
</script>
@endsection
