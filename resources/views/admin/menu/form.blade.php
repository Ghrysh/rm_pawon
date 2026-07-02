@extends('admin.layout')

@section('content')
<h1 class="page-title">
    @if($mode == 'create') Tambah Menu
    @elseif($mode == 'edit') Edit Menu
    @else Detail Menu
    @endif
</h1>

<div style="background:#fff; border-radius:12px; padding:2rem; box-shadow:0 4px 15px rgba(0,0,0,0.05); max-width: 900px;">
    <form id="menuForm" action="{{ $mode == 'edit' ? route('admin.menu.update', $menu->id) : route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($mode == 'edit') @method('PUT') @endif
        
        <div style="display:flex; gap:3rem; align-items:flex-start; flex-wrap: wrap;">
            
            <!-- Left Side (Inputs) -->
            <div style="flex:1; min-width: 300px;">
                <div style="margin-bottom: 1.5rem;">
                    <label style="display:block; font-weight:700; margin-bottom:0.5rem; color:#111; font-size:1rem;">Nama Menu</label>
                    <input type="text" name="name" class="form-input" style="width: 100%; border-radius: 8px; border: 1px solid #ccc; padding: 0.8rem;" value="{{ $menu->name ?? '' }}" {{ $mode == 'show' ? 'readonly' : 'required' }}>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display:block; font-weight:700; margin-bottom:0.5rem; color:#111; font-size:1rem;">Harga</label>
                    <input type="number" name="price" class="form-input" style="width: 100%; border-radius: 8px; border: 1px solid #ccc; padding: 0.8rem;" value="{{ $menu->price ?? '' }}" {{ $mode == 'show' ? 'readonly' : 'required' }}>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display:block; font-weight:700; margin-bottom:0.5rem; color:#111; font-size:1rem;">Keterangan</label>
                    <textarea name="description" class="form-input" style="width: 100%; border-radius: 8px; border: 1px solid #ccc; padding: 0.8rem; height: 120px; resize:none;" placeholder="Keterangan" {{ $mode == 'show' ? 'readonly' : '' }}>{{ $menu->description ?? '' }}</textarea>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display:block; font-weight:700; margin-bottom:0.5rem; color:#111; font-size:1rem;">Stok</label>
                    <input type="number" name="stok" class="form-input" style="width: 100%; border-radius: 8px; border: 1px solid #ccc; padding: 0.8rem;" value="{{ $menu->stok ?? '' }}" {{ $mode == 'show' ? 'readonly' : 'required' }}>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display:block; font-weight:700; margin-bottom:0.5rem; color:#111; font-size:1rem;">Kategori</label>
                    @if($mode == 'show')
                        <input type="text" class="form-input" style="width: 100%; border-radius: 8px; border: 1px solid #ccc; padding: 0.8rem;" value="{{ $menu->category ? $menu->category->name : '-' }}" readonly>
                    @else
                        <select class="form-input" name="category_id" style="width: 100%; border-radius: 8px; border: 1px solid #ccc; padding: 0.8rem; background-color: #fff;" required>
                            <option value="" disabled {{ !isset($menu) ? 'selected' : '' }}>-- Pilih Kategori --</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}" {{ (isset($menu) && $menu->category_id == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>

            <!-- Right Side (Image) -->
            <div style="flex:1; min-width: 300px;">
                <label style="display:block; font-weight:700; margin-bottom:0.5rem; color:#111; font-size:1rem;">Gambar</label>
                
                @if($mode != 'show')
                <div style="display: flex; align-items: center; border: 1px solid #ccc; border-radius: 8px; overflow: hidden; margin-bottom: 1rem;">
                    <label for="imageUpload" style="background:#e0e0e0; padding:0.8rem 1.5rem; cursor:pointer; font-weight:600; color:#555; border-right:1px solid #ccc;">Choose File</label>
                    <span id="fileName" style="padding:0.8rem 1rem; color:#777;">No File Chosen</span>
                    <input type="file" name="image" id="imageUpload" style="display:none;" accept="image/*" onchange="previewFormImage(this)">
                </div>
                @endif
                
                <div id="imagePreviewContainer" style="width: 100%; height: 250px; background: #e0e0e0; border-radius: 8px; display: flex; justify-content: center; align-items: center; overflow: hidden;">
                    @if(isset($menu) && $menu->image)
                        <img id="formPreviewImg" src="{{ asset($menu->image) }}" style="width:100%; height:100%; object-fit:cover;">
                        <span id="formPreviewText" style="display:none; font-weight:700; color:#555; font-size:1.1rem;">Gambar</span>
                    @else
                        <img id="formPreviewImg" src="" style="width:100%; height:100%; object-fit:cover; display:none;">
                        <span id="formPreviewText" style="font-weight:700; color:#555; font-size:1.1rem;">Gambar</span>
                    @endif
                </div>
            </div>
            
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
            @if($mode == 'edit')
            <button type="button" onclick="openConfirmModal()" style="background:#3358d4; color:#fff; border:none; padding:0.6rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1rem; display:flex; align-items:center; gap:0.5rem;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Simpan
            </button>
            @elseif($mode == 'create')
            <button type="submit" style="background:#3358d4; color:#fff; border:none; padding:0.6rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1rem; display:flex; align-items:center; gap:0.5rem;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Simpan
            </button>
            @endif
            <a href="{{ route('admin.menu') }}" style="text-decoration:none; background:#fff; color:#555; border:1px solid #555; padding:0.6rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1rem; display:flex; align-items:center; gap:0.5rem;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Batal
            </a>
        </div>
    </form>
</div>

@if($mode == 'edit')
<!-- Modal Konfirmasi Edit -->
<div id="confirmEditModal" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:10000; justify-content:center; align-items:center;">
    <div class="admin-modal confirm-modal-box" style="background:#fff; padding:2.5rem 2.5rem; border-radius:24px; text-align:center; width:90%; max-width:500px; box-shadow:0 10px 40px rgba(0,0,0,0.1);">
        <div style="width:100px; height:100px; border-radius:50%; border:4px solid #666; display:flex; justify-content:center; align-items:center; margin:0 auto 1rem;">
            <span style="font-size:4rem; font-weight:800; color:#666; font-family:sans-serif;">!</span>
        </div>
        <h3 style="font-size:1.6rem; font-weight:800; margin-bottom:0.5rem; color:#000;">Yakin ingin mengedit?</h3>
        <p style="font-size:1.1rem; color:#111; margin-bottom:1.5rem;">Menu akan diedit permanen</p>
        <div class="confirm-actions" style="display:flex; justify-content:center; gap:1rem;">
            <button type="button" onclick="document.getElementById('menuForm').submit()" style="background:#3358d4; color:#fff; border:none; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Ya, Edit</button>
            <button type="button" onclick="closeConfirmModal()" style="background:#fff; color:#555; border:1px solid #666; padding:0.8rem 2rem; border-radius:30px; font-weight:700; cursor:pointer; font-size:1.1rem; min-width: 140px;">Batal</button>
        </div>
    </div>
</div>
@endif

<script>
    function openConfirmModal() {
        document.getElementById('confirmEditModal').style.display = 'flex';
    }
    function closeConfirmModal() {
        document.getElementById('confirmEditModal').style.display = 'none';
    }

    function previewFormImage(input) {
        if (input.files && input.files[0]) {
            document.getElementById('fileName').innerText = input.files[0].name;
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.getElementById('formPreviewImg');
                img.src = e.target.result;
                img.style.display = 'block';
                document.getElementById('formPreviewText').style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
