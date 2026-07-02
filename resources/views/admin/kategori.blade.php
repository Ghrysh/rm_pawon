@extends('admin.layout')

@section('content')

<!-- TABLE VIEW -->
<div id="kategoriTableView">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h1 class="page-title" style="margin-bottom:0;">Kategori Menu</h1>
        <button class="btn-tambah-menu" onclick="showView('tambahKategoriView')">+ Tambah Kategori</button>
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
            <input type="text" class="search-input-table" placeholder="Cari Kategori">
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="width: 70%; text-align: left; padding-left: 1rem;">Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $index => $kategori)
                    <tr>
                        <td><strong>{{ $index + 1 }}</strong></td>
                        <td style="text-align: left; padding-left: 1rem;"><strong>{{ $kategori->name }}</strong></td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon btn-yellow" onclick="editKategori('{{ $kategori->id }}', '{{ $kategori->name }}')">
                                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>
                                <button class="btn-icon btn-red" onclick="confirmDelete('{{ $kategori->id }}')">
                                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @if($categories->count() == 0)
                    <tr>
                        <td colspan="3" style="text-align:center; padding: 2rem;">Belum ada kategori.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- TAMBAH KATEGORI VIEW -->
<div id="tambahKategoriView" style="display:none;">
    <h1 class="page-title">Tambah Kategori</h1>

    <div style="background:#fff; border-radius:12px; padding:2rem; box-shadow:0 4px 15px rgba(0,0,0,0.05); max-width: 900px; border: 1px solid #ddd;">
        <form action="{{ route('admin.kategori.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 2rem;">
                <label style="display:block; font-weight:700; margin-bottom:0.5rem; color:#111; font-size:1rem;">Nama Kategori</label>
                <input type="text" name="name" class="form-input" style="width: 100%; max-width: 500px; border-radius: 8px; border: 1px solid #ccc; padding: 0.8rem;" placeholder="" required>
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="background:#3358d4; color:#fff; border:none; padding:0.6rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1rem; display:flex; align-items:center; gap:0.5rem;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Simpan
                </button>
                <button type="button" style="background:#fff; color:#555; border:1px solid #555; padding:0.6rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1rem; display:flex; align-items:center; gap:0.5rem;" onclick="showView('kategoriTableView')">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- EDIT KATEGORI VIEW -->
<div id="editKategoriView" style="display:none;">
    <h1 class="page-title">Edit Kategori</h1>

    <div style="background:#fff; border-radius:12px; padding:2rem; box-shadow:0 4px 15px rgba(0,0,0,0.05); max-width: 900px; border: 1px solid #ddd;">
        <form id="formEditKategori" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 2rem;">
                <label style="display:block; font-weight:700; margin-bottom:0.5rem; color:#111; font-size:1rem;">Nama Kategori</label>
                <input type="text" id="editKategoriName" name="name" class="form-input" style="width: 100%; max-width: 500px; border-radius: 8px; border: 1px solid #ccc; padding: 0.8rem;" required>
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <button type="button" onclick="openModal('confirmEditKategoriModal')" style="background:#3358d4; color:#fff; border:none; padding:0.6rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1rem; display:flex; align-items:center; gap:0.5rem;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Simpan
                </button>
                <button type="button" style="background:#fff; color:#555; border:1px solid #555; padding:0.6rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1rem; display:flex; align-items:center; gap:0.5rem;" onclick="showView('kategoriTableView')">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Edit -->
<div id="confirmEditKategoriModal" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:10000; justify-content:center; align-items:center;">
    <div class="admin-modal confirm-modal-box" style="background:#fff; padding:2.5rem 2.5rem; border-radius:24px; text-align:center; width:90%; max-width:500px; box-shadow:0 10px 40px rgba(0,0,0,0.1);">
        <div style="width:100px; height:100px; border-radius:50%; border:4px solid #666; display:flex; justify-content:center; align-items:center; margin:0 auto 1rem;">
            <span style="font-size:4rem; font-weight:800; color:#666; font-family:sans-serif;">!</span>
        </div>
        <h3 style="font-size:1.6rem; font-weight:800; margin-bottom:0.5rem; color:#000;">Yakin ingin menyimpan?</h3>
        <p style="font-size:1.1rem; color:#111; margin-bottom:1.5rem;">Kategori akan disimpan permanen</p>
        <div class="confirm-actions" style="display:flex; justify-content:center; gap:1rem;">
            <button type="button" onclick="document.getElementById('formEditKategori').submit()" style="background:#3358d4; color:#fff; border:none; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Ya, Edit</button>
            <button type="button" onclick="closeModal('confirmEditKategoriModal')" style="background:#fff; color:#555; border:1px solid #666; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Batal</button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="confirmDeleteModal" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:10000; justify-content:center; align-items:center;">
    <div class="admin-modal confirm-modal-box" style="background:#fff; padding:2.5rem 2.5rem; border-radius:24px; text-align:center; width:90%; max-width:500px; box-shadow:0 10px 40px rgba(0,0,0,0.1);">
        <div style="width:100px; height:100px; border-radius:50%; border:4px solid #666; display:flex; justify-content:center; align-items:center; margin:0 auto 1rem;">
            <span style="font-size:4rem; font-weight:800; color:#666; font-family:sans-serif;">!</span>
        </div>
        <h3 style="font-size:1.6rem; font-weight:800; margin-bottom:0.5rem; color:#000;">Yakin ingin menghapus?</h3>
        <p style="font-size:1.1rem; color:#111; margin-bottom:1.5rem;">Kategori akan dihapus permanen</p>
        <div class="confirm-actions" style="display:flex; justify-content:center; gap:1rem;">
            <form id="formDeleteKategori" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" style="background:#3358d4; color:#fff; border:none; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Ya, Hapus</button>
            </form>
            <button type="button" onclick="closeModal('confirmDeleteModal')" style="background:#fff; color:#555; border:1px solid #666; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Batal</button>
        </div>
    </div>
</div>

<script>
    function showView(viewId) {
        document.getElementById('kategoriTableView').style.display = 'none';
        document.getElementById('tambahKategoriView').style.display = 'none';
        document.getElementById('editKategoriView').style.display = 'none';
        document.getElementById(viewId).style.display = 'block';
    }

    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function editKategori(id, name) {
        document.getElementById('editKategoriName').value = name;
        document.getElementById('formEditKategori').action = '/admin/kategori/' + id;
        showView('editKategoriView');
    }

    function confirmDelete(id) {
        document.getElementById('formDeleteKategori').action = '/admin/kategori/' + id;
        openModal('confirmDeleteModal');
    }
</script>
@endsection
