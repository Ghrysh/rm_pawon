<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Rumah Makan Pawon Kang Bima</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body">
    
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('assets/logo_rm.png') }}" alt="Logo" class="sidebar-logo">
                <div class="sidebar-title">Pawon<br>Kang Bima</div>
            </div>
            
            <ul class="sidebar-menu">
                <li class="menu-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item {{ Route::currentRouteName() == 'admin.pesanan_masuk' || Route::currentRouteName() == 'admin.pesanan-masuk' || Route::currentRouteName() == 'admin.pesanan-diproses' ? 'active open' : '' }}">
                    <a href="#" onclick="this.parentElement.classList.toggle('open'); return false;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span class="menu-text">Pesanan</span>
                        <svg class="dropdown-icon" style="margin-left:auto; width:16px; height:16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('admin.pesanan-masuk') }}" class="{{ request()->routeIs('admin.pesanan-masuk') ? 'active-submenu' : '' }}"><span class="menu-text">Pesanan Masuk</span></a></li>
                        <li><a href="{{ route('admin.pesanan-diproses') }}" class="{{ request()->routeIs('admin.pesanan-diproses') ? 'active-submenu' : '' }}"><span class="menu-text">Pesanan Diproses</span></a></li>
                    </ul>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.menu') ? 'active' : '' }}">
                    <a href="{{ route('admin.menu') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                        <span class="menu-text">Menu</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.kategori') ? 'active' : '' }}">
                    <a href="{{ route('admin.kategori') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <span class="menu-text">Kategori Menu</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.riwayat') ? 'active' : '' }}">
                    <a href="{{ route('admin.riwayat') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><polyline points="12 18 12 12 9 15"></polyline></svg>
                        <span class="menu-text">Riwayat Transaksi</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Topbar -->
            <header class="admin-topbar">
                <div style="display: flex; align-items: center;">
                    <div class="topbar-left" style="cursor: pointer;" onclick="document.body.classList.toggle('minimized')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                    </div>
                    <div style="cursor: pointer; margin-left: 1.5rem; color: #555; display: flex; align-items: center;" onclick="window.location.reload()" title="Refresh Data">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                    </div>
                </div>
                <div class="topbar-right">
                    @php
                        $newOrdersCount = \App\Models\Order::where('status', 'menunggu_pembayaran')->count();
                    @endphp
                    <a href="{{ route('admin.pesanan-masuk') }}" class="topbar-icon" style="position: relative; color: inherit; text-decoration: none;">
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
                        @if($newOrdersCount > 0)
                            <span style="position: absolute; bottom: -5px; right: -5px; background: #bb1f21; color: white; border-radius: 50%; font-size: 0.7rem; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-weight: bold;">{{ $newOrdersCount }}</span>
                        @endif
                    </a>

                    <div class="topbar-divider"></div>
                    <button type="button" class="btn-logout" onclick="document.getElementById('confirmLogoutModal').style.display='flex'">Logout</button>
                </div>
            </header>

            <!-- Page Content -->
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Global Logout Modals -->
    <div id="confirmLogoutModal" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div class="admin-modal confirm-modal-box" style="background:#fff; padding:2.5rem 2rem; border-radius:12px; text-align:center; width:90%; max-width:400px; box-shadow:0 10px 25px rgba(0,0,0,0.2);">
            <div class="confirm-icon icon-warn" style="width:80px; height:80px; border-radius:50%; border:2px solid #555; display:flex; justify-content:center; align-items:center; font-size:3rem; font-weight:700; color:#555; margin:0 auto 1.5rem;">!</div>
            <h3 style="font-size:1.5rem; font-weight:700; margin-bottom:2rem; color:#111;">Yakin ingin logout?</h3>
            <div class="confirm-actions" style="display:flex; justify-content:center; gap:1rem;">
                <button class="btn-edit-simpan" style="background:#3252b3; color:#fff; border:none; padding:0.6rem 2.5rem; border-radius:20px; font-weight:700; cursor:pointer; font-size:1rem;" onclick="document.getElementById('confirmLogoutModal').style.display='none'; document.getElementById('successLogoutModal').style.display='flex'">Yakin</button>
                <button style="background:#fff; color:#111; border:1px solid #777; padding:0.6rem 2.5rem; border-radius:20px; font-weight:700; cursor:pointer; font-size:1rem;" onclick="document.getElementById('confirmLogoutModal').style.display='none'">Batal</button>
            </div>
        </div>
    </div>

    <div id="successLogoutModal" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div class="admin-modal confirm-modal-box" style="background:#fff; padding:2.5rem 2rem; border-radius:12px; text-align:center; width:90%; max-width:400px; box-shadow:0 10px 25px rgba(0,0,0,0.2);">
            <div class="confirm-icon icon-success" style="width:80px; height:80px; border-radius:50%; border:2px solid #555; display:flex; justify-content:center; align-items:center; color:#555; margin:0 auto 1.5rem;">
                <svg viewBox="0 0 24 24" width="45" height="45" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <h3 style="font-size:1.5rem; font-weight:700; margin-bottom:0.8rem; color:#111;">Berhasil</h3>
            <p style="color:#555; font-size:0.95rem; font-weight:600; margin-bottom:2rem;">Anda berhasil logout</p>
            <div class="confirm-actions" style="display:flex; justify-content:center;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-edit-simpan" style="background:#3252b3; color:#fff; border:none; padding:0.6rem 3rem; border-radius:20px; font-weight:700; cursor:pointer; font-size:1rem;">Oke</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script>
        // Global Notification Audio
        const notivAudio = new Audio('{{ asset("assets/notiv.mp3") }}');
        notivAudio.load();

        // Auto Refresh Logic
        setInterval(() => {
            // Pause refresh if any modal is open
            const modals = document.querySelectorAll('.admin-modal-overlay');
            let isModalOpen = false;
            modals.forEach(m => {
                if(m.style.display === 'flex' || m.style.display === 'block') isModalOpen = true;
            });

            // Pause refresh if search input is focused
            const searchInputs = document.querySelectorAll('.search-input-table');
            let isSearching = false;
            searchInputs.forEach(input => {
                if(document.activeElement === input) {
                    isSearching = true;
                }
            });

            // Pause refresh on create/edit form pages
            const isFormPage = window.location.pathname.includes('/create') || window.location.pathname.includes('/edit');

            // Pause refresh if inline category forms are open
            let isInlineFormOpen = false;
            const tambahKategori = document.getElementById('tambahKategoriView');
            if (tambahKategori && tambahKategori.style.display !== 'none') isInlineFormOpen = true;
            const editKategori = document.getElementById('editKategoriView');
            if (editKategori && editKategori.style.display !== 'none') isInlineFormOpen = true;

            if (!isModalOpen && !isSearching && !isFormPage && !isInlineFormOpen) {
                // Save state
                const searchVals = Array.from(document.querySelectorAll('.search-input-table')).map(i => i.value);
                const filterDateEl = document.getElementById('filterDate');
                const filterTypeEl = document.getElementById('filterType');
                const filterDateVal = filterDateEl ? filterDateEl.value : '';
                const filterTypeVal = filterTypeEl ? filterTypeEl.value : '';

                fetch(window.location.href, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    // Replace admin-content inner HTML
                    const newContent = doc.querySelector('.admin-content');
                    if (newContent) {
                        document.querySelector('.admin-content').innerHTML = newContent.innerHTML;
                        
                        // Restore state
                        const newSearchInputs = document.querySelectorAll('.search-input-table');
                        newSearchInputs.forEach((input, index) => {
                            if (searchVals[index] !== undefined) {
                                input.value = searchVals[index];
                                input.dispatchEvent(new Event('input', { bubbles: true }));
                            }
                        });

                        const newFilterDateEl = document.getElementById('filterDate');
                        const newFilterTypeEl = document.getElementById('filterType');
                        
                        if (newFilterDateEl) newFilterDateEl.value = filterDateVal;
                        
                        if (newFilterTypeEl && filterTypeVal) {
                            newFilterTypeEl.value = filterTypeVal;
                            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                            const activeTab = document.querySelector(`.filter-tab[data-value="${filterTypeVal}"]`);
                            if(activeTab) activeTab.classList.add('active');
                        }

                        if (typeof filterRiwayat === 'function') {
                            filterRiwayat();
                        }
                    }
                    
                    // Replace notification badge
                    const oldBadgeSpan = document.querySelector('.topbar-right > a span');
                    const oldBadgeCount = oldBadgeSpan ? parseInt(oldBadgeSpan.textContent.trim()) : 0;

                    const newBadge = doc.querySelector('.topbar-right > a');
                    if (newBadge) {
                        const newBadgeSpan = newBadge.querySelector('span');
                        const newBadgeCount = newBadgeSpan ? parseInt(newBadgeSpan.textContent.trim()) : 0;
                        
                        document.querySelector('.topbar-right > a').innerHTML = newBadge.innerHTML;
                        
                        // Play sound if new order comes in
                        if (newBadgeCount > oldBadgeCount) {
                            notivAudio.currentTime = 0;
                            let playPromise = notivAudio.play();
                            if (playPromise !== undefined) {
                                playPromise.catch(e => console.log('Audio error:', e));
                            }
                            setTimeout(() => {
                                notivAudio.pause();
                                notivAudio.currentTime = 0;
                            }, 3000);
                        }
                    }
                })
                .catch(err => console.error('Auto refresh failed:', err));
            }
        }, 10000); // 10 seconds auto-refresh interval

        // Live Search for Tables using Event Delegation
        document.addEventListener('input', function(e) {
            if (e.target && e.target.classList.contains('search-input-table')) {
                const searchTerm = e.target.value.toLowerCase();
                const tableCard = e.target.closest('.table-card') || e.target.closest('.admin-content');
                if (!tableCard) return;
                
                const table = tableCard.querySelector('.admin-table');
                if (!table) return;
                
                const rows = table.querySelectorAll('tbody tr');
                let visibleCount = 0;
                let dataRowCount = 0;
                let originalEmptyRow = null;
                
                rows.forEach(row => {
                    const firstCell = row.querySelector('td');
                    if (row.classList.contains('empty-search-row')) return;
                    
                    // Skip 'Belum ada pesanan masuk' rows and empty search rows
                    if (firstCell && firstCell.hasAttribute('colspan')) {
                        originalEmptyRow = row;
                        return;
                    }
                    
                    dataRowCount++;
                    
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                let searchEmptyRow = table.querySelector('tbody .empty-search-row');
                
                if (searchTerm !== '') {
                    // If searching, hide the default 'Belum ada pesanan'
                    if (originalEmptyRow) originalEmptyRow.style.display = 'none';
                    
                    if (visibleCount === 0 || dataRowCount === 0) {
                        if (!searchEmptyRow) {
                            const tbody = table.querySelector('tbody');
                            const colCount = table.querySelector('thead tr').children.length;
                            searchEmptyRow = document.createElement('tr');
                            searchEmptyRow.className = 'empty-search-row';
                            searchEmptyRow.innerHTML = `<td colspan="${colCount}" style="text-align:center; padding:2rem;">Data tidak ditemukan</td>`;
                            tbody.appendChild(searchEmptyRow);
                        } else {
                            searchEmptyRow.style.display = '';
                        }
                    } else if (searchEmptyRow) {
                        searchEmptyRow.style.display = 'none';
                    }
                } else {
                    // Not searching, restore original states
                    if (searchEmptyRow) searchEmptyRow.style.display = 'none';
                    
                    if (dataRowCount === 0) {
                        if (originalEmptyRow) originalEmptyRow.style.display = '';
                    } else {
                        if (originalEmptyRow) originalEmptyRow.style.display = 'none';
                    }
                }
            }
        });
    </script>
</body>
</html>
