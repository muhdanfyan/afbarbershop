<ul class="nav">
    <li class="nav-item">
        <a class="nav-link" href="/admin/dashboard" style="border:none;">
            <i class="icon-box menu-icon"></i>
            <span class="menu-title">Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/admin/barang" style="border:none;">
            <i class="icon-box menu-icon"></i>
            <span class="menu-title">Barang</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/jasa" style="border:none;">
            <i class="icon-briefcase menu-icon"></i>
            <span class="menu-title">Jasa</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-transaksi" aria-expanded="false"
            aria-controls="ui-transaksi" style="border:none;">
            <i class="icon-disc menu-icon"></i>
            <span class="menu-title">Transaksi</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-transaksi">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="/mencukur/menunggu" style="border:none;">Menunggu</a>
                </li>
                <li class="nav-item"> <a class="nav-link" href="/mencukur/menunggu" style="border:none;">Proses</a>
                </li>
                <li class="nav-item"> <a class="nav-link" href="/mencukur/menunggu" style="border:none;">Selesai</a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/admin/kasir" style="border:none;">
            <i class="icon-box menu-icon"></i>
            <span class="menu-title">Kasir</span>
        </a>
    </li>
    <li class="nav-item">
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/admin/kapster" style="border:none;">
            <i class="icon-box menu-icon"></i>
            <span class="menu-title">Kapster</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/admin/user" style="border:none;">
            <i class="icon-box menu-icon"></i>
            <span class="menu-title">User</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.profile') }}" style="border:none;">
            <i class="mdi mdi-account-circle menu-icon"></i>
            <span class="menu-title">Profil Saya</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-laporan" aria-expanded="false" aria-controls="ui-laporan"
            style="border:none;">
            <i class="icon-disc menu-icon"></i>
            <span class="menu-title">Laporan</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-laporan">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="/admin/laporan/harian" style="border:none;">Harian</a>
                </li>
                <li class="nav-item"> <a class="nav-link" href="/admin/laporan/mingguan"
                        style="border:none;">Mingguan</a>
                </li>
                <li class="nav-item"> <a class="nav-link" href="/admin/laporan/bulanan" style="border:none;">Bulanan</a>
                </li>
            </ul>
        </div>
    </li>
</ul>