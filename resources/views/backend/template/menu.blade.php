<!-- Sidebar Logo Header -->
<div class="d-flex align-items-center justify-content-center px-3" style="height: 70px; border-bottom: 1px solid rgba(255,255,255,0.06);">
    @php
        $logoPath = isset($settings['logo']) && $settings['logo'] ? asset('storage/' . $settings['logo']) : asset('logoposeidonputih.png');
    @endphp
    <a href="/admin/dashboard" class="d-block text-center w-100">
        <img src="{{ $logoPath }}" alt="logo" style="max-height: 38px; object-fit: contain;">
    </a>
</div>

<ul class="nav">
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
    <li class="nav-item {{ Request::is('admin/kursi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.kursi') }}">
            <i class="mdi mdi-chair-school menu-icon text-warning"></i>
            <span class="menu-title">Manajemen Kursi</span>
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
        <a class="nav-link" href="/admin/playlist">
            <i class="mdi mdi-youtube menu-icon text-danger"></i>
            <span class="menu-title">Playlist Studio</span>
        </a>
    </li>
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