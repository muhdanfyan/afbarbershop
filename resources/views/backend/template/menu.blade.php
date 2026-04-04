<ul class="nav">
    <!-- Dedicated Sidebar Toggle Button -->
    <li class="nav-item d-none d-lg-flex justify-content-center w-100 mb-2 mt-2 sidebar-toggler-container">
        <button class="btn p-1 rounded-circle d-flex align-items-center justify-content-center" type="button" data-toggle="minimize" onclick="toggleSidebarIcon()" style="width: 32px; height: 32px; border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: #d4af37;">
            <i class="mdi mdi-chevron-left" id="sidebarToggleIcon" style="font-size: 1.2rem; transition: transform 0.3s ease;"></i>
        </button>
    </li>
    <script>
        function toggleSidebarIcon() {
            setTimeout(() => {
                const icon = document.getElementById('sidebarToggleIcon');
                if(document.body.classList.contains('sidebar-icon-only')) {
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    icon.style.transform = 'rotate(0deg)';
                }
            }, 50);
        }
    </script>
    <li class="nav-category">Main</li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/dashboard">
            <i class="mdi mdi-view-dashboard menu-icon"></i>
            <span class="menu-title">Dashboard</span>
        </a>
    </li>

    <li class="nav-category">Master Data</li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/barang">
            <i class="mdi mdi-package-variant menu-icon"></i>
            <span class="menu-title">Barang</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/jasa">
            <i class="mdi mdi-scissors-cutting menu-icon"></i>
            <span class="menu-title">Jasa</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/kapster">
            <i class="mdi mdi-account-star menu-icon"></i>
            <span class="menu-title">Kapster</span>
        </a>
    </li>

    <li class="nav-category">Operations</li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/kasir">
            <i class="mdi mdi-cash-register menu-icon"></i>
            <span class="menu-title">Kasir</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/transaksi">
            <i class="mdi mdi-swap-horizontal menu-icon"></i>
            <span class="menu-title">Transaksi</span>
        </a>
    </li>

    <li class="nav-category">Reports & Users</li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/laporan">
            <i class="mdi mdi-file-document-box-multiple menu-icon"></i>
            <span class="menu-title">Laporan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/user">
            <i class="mdi mdi-account-multiple menu-icon"></i>
            <span class="menu-title">User</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/member">
            <i class="mdi mdi-account-card-details menu-icon"></i>
            <span class="menu-title">Member</span>
        </a>
    </li>

    <li class="nav-category">System</li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/gallery">
            <i class="mdi mdi-image-multiple menu-icon"></i>
            <span class="menu-title">Gallery</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/setting">
            <i class="mdi mdi-settings menu-icon"></i>
            <span class="menu-title">Setting</span>
        </a>
    </li>
</ul>