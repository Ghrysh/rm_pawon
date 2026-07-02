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
                <div class="topbar-left" style="cursor: pointer;" onclick="document.body.classList.toggle('minimized')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
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
                    
                    <div style="display: flex; align-items: center; position: relative;">
                        <div class="topbar-icon" id="searchIconBtn" style="cursor: pointer; margin-left: 1rem;" onclick="toggleSearch()">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </div>
                        <div id="searchContainer" style="display: none; margin-left: 0.5rem; position: relative;">
                            <input type="text" id="liveSearchInput" placeholder="Search menu, pesanan..." style="border: 1px solid #ccc; border-radius: 20px; padding: 0.4rem 1rem; outline: none; font-size: 0.9rem; width: 200px;" oninput="performSearch(this.value)">
                            
                            <div id="searchDropdown" style="display: none; position: absolute; top: 120%; right: 0; width: 300px; background: #fff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 1000; max-height: 400px; overflow-y: auto;">
                                <div id="searchResults" style="padding: 0.5rem;"></div>
                            </div>
                        </div>
                    </div>

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
        function toggleSearch() {
            var container = document.getElementById('searchContainer');
            if (container.style.display === 'none') {
                container.style.display = 'block';
                document.getElementById('liveSearchInput').focus();
            } else {
                container.style.display = 'none';
                document.getElementById('searchDropdown').style.display = 'none';
            }
        }

        let searchTimeout;
        function performSearch(val) {
            clearTimeout(searchTimeout);
            var dropdown = document.getElementById('searchDropdown');
            var resultsDiv = document.getElementById('searchResults');
            
            if (val.trim() === '') {
                dropdown.style.display = 'none';
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`{{ route('admin.search') }}?search=${encodeURIComponent(val)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    resultsDiv.innerHTML = '';
                    
                    let html = '';
                    if (data.menus.length > 0) {
                        html += '<div style="font-weight:bold; padding: 0.5rem; border-bottom: 1px solid #eee;">Menu</div>';
                        data.menus.forEach(menu => {
                            html += `<div style="padding: 0.5rem; border-bottom: 1px solid #f9f9f9; cursor:pointer;" onclick="window.location.href='{{ route('admin.menu') }}'">
                                <div>${menu.name}</div>
                                <div style="font-size: 0.8rem; color: #777;">Rp. ${menu.price.toLocaleString('id-ID')}</div>
                            </div>`;
                        });
                    }
                    
                    if (data.orders.length > 0) {
                        html += '<div style="font-weight:bold; padding: 0.5rem; border-bottom: 1px solid #eee; margin-top:0.5rem;">Pesanan</div>';
                        data.orders.forEach(order => {
                            let link = "{{ route('admin.pesanan-masuk') }}";
                            if(order.status == 'diproses') link = "{{ route('admin.pesanan-diproses') }}";
                            if(order.status == 'selesai') link = "{{ route('admin.riwayat') }}";
                            
                            html += `<div style="padding: 0.5rem; border-bottom: 1px solid #f9f9f9; cursor:pointer;" onclick="window.location.href='${link}'">
                                <div>${order.nama_pl} (Meja ${order.no_meja})</div>
                                <div style="font-size: 0.8rem; color: #777;">Rp. ${order.total_harga.toLocaleString('id-ID')} - ${order.status}</div>
                            </div>`;
                        });
                    }
                    
                    if (data.menus.length === 0 && data.orders.length === 0) {
                        html = '<div style="padding: 1rem; text-align: center; color: #777;">Tidak ditemukan data.</div>';
                    }
                    
                    resultsDiv.innerHTML = html;
                    dropdown.style.display = 'block';
                });
            }, 300);
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            var container = document.getElementById('searchContainer');
            var btn = document.getElementById('searchIconBtn');
            if (container && !container.contains(event.target) && !btn.contains(event.target)) {
                container.style.display = 'none';
                document.getElementById('searchDropdown').style.display = 'none';
            }
        });

        // Live Search for Tables
        document.addEventListener('DOMContentLoaded', function() {
            const searchInputs = document.querySelectorAll('.search-input-table');
            
            searchInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const tableCard = this.closest('.table-card') || this.closest('.admin-content');
                    if (!tableCard) return;
                    
                    const table = tableCard.querySelector('.admin-table');
                    if (!table) return;
                    
                    const rows = table.querySelectorAll('tbody tr');
                    let visibleCount = 0;
                    
                    rows.forEach(row => {
                        const firstCell = row.querySelector('td');
                        // Skip if the row is a "Belum ada pesanan" placeholder (has colspan)
                        if (firstCell && firstCell.hasAttribute('colspan')) {
                            return;
                        }
                        
                        const text = row.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });
                    
                    // Handle "No data" message row
                    let emptyRow = table.querySelector('tbody .empty-search-row');
                    if (visibleCount === 0 && rows.length > 0) {
                        if (!emptyRow) {
                            const tbody = table.querySelector('tbody');
                            const colCount = table.querySelector('thead tr').children.length;
                            emptyRow = document.createElement('tr');
                            emptyRow.className = 'empty-search-row';
                            emptyRow.innerHTML = `<td colspan="${colCount}" style="text-align:center; padding:2rem;">Data tidak ditemukan</td>`;
                            tbody.appendChild(emptyRow);
                        } else {
                            emptyRow.style.display = '';
                        }
                    } else if (emptyRow) {
                        emptyRow.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
