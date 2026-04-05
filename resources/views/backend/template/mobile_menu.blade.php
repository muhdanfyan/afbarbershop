<div class="mobile-top-nav-wrapper d-lg-none">
    <div class="mobile-top-nav">
        <a href="/admin/dashboard" class="nav-item-mobile {{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <i class="mdi mdi-view-dashboard"></i>
            <span>Dash</span>
        </a>
        <a href="/admin/barang" class="nav-item-mobile {{ Request::is('admin/barang') ? 'active' : '' }}">
            <i class="mdi mdi-package-variant"></i>
            <span>Barang</span>
        </a>
        <a href="/admin/jasa" class="nav-item-mobile {{ Request::is('admin/jasa') ? 'active' : '' }}">
            <i class="mdi mdi-scissors-cutting"></i>
            <span>Jasa</span>
        </a>
        <a href="/admin/kapster" class="nav-item-mobile {{ Request::is('admin/kapster') ? 'active' : '' }}">
            <i class="mdi mdi-account-star"></i>
            <span>Kapster</span>
        </a>
        <a href="/admin/kasir" class="nav-item-mobile {{ Request::is('admin/kasir') ? 'active' : '' }}">
            <i class="mdi mdi-cash-register"></i>
            <span>Kasir</span>
        </a>
        <a href="/admin/transaksi" class="nav-item-mobile {{ Request::is('admin/transaksi') ? 'active' : '' }}">
            <i class="mdi mdi-swap-horizontal"></i>
            <span>Trx</span>
        </a>
        <a href="/admin/laporan" class="nav-item-mobile {{ Request::is('admin/laporan') ? 'active' : '' }}">
            <i class="mdi mdi-file-document-box-multiple"></i>
            <span>Laporan</span>
        </a>
        <a href="/admin/user" class="nav-item-mobile {{ Request::is('admin/user') ? 'active' : '' }}">
            <i class="mdi mdi-account-multiple"></i>
            <span>User</span>
        </a>
        <a href="/admin/member" class="nav-item-mobile {{ Request::is('admin/member') ? 'active' : '' }}">
            <i class="mdi mdi-account-card-details"></i>
            <span>Member</span>
        </a>
        <a href="/admin/playlist" class="nav-item-mobile {{ Request::is('admin/playlist') ? 'active' : '' }}">
            <i class="mdi mdi-youtube text-danger"></i>
            <span>Music</span>
        </a>
        <a href="/admin/gallery" class="nav-item-mobile {{ Request::is('admin/gallery') ? 'active' : '' }}">
            <i class="mdi mdi-image-multiple"></i>
            <span>Gallery</span>
        </a>
        <a href="/admin/setting" class="nav-item-mobile {{ Request::is('admin/setting') ? 'active' : '' }}">
            <i class="mdi mdi-settings"></i>
            <span>Set</span>
        </a>
    </div>
</div>
