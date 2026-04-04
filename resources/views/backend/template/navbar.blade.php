<!-- partial:partials/_navbar.html -->
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        @php
            $logoPath = isset($settings['logo']) && $settings['logo'] ? asset('storage/' . $settings['logo']) : asset('logoposeidonputih.png');
        @endphp
        <div class="brand-logo px-3">
            <img src="{{ $logoPath }}" alt="logo" style="max-height: 45px; max-width: 100%; object-fit: contain;">
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <div class="search-wrapper d-none d-md-block mr-auto ml-4">
            <div class="input-group" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 5px 15px;">
                <i class="mdi mdi-magnify text-muted mr-2" style="font-size: 1.2rem;"></i>
                <input type="text" class="form-control border-0 bg-transparent p-0 text-white" placeholder="Search..." style="height: 30px; font-size: 0.85rem;">
            </div>
        </div>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center bg-dark text-white rounded-pill px-3 py-2 border border-secondary" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="{{ auth()->user()->foto ? asset('storage/'.auth()->user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}" alt="profile" class="rounded-circle mr-2" style="width: 30px; height: 30px;"/>
                    <span class="nav-profile-name small font-weight-bold">My Account</span>
                    <i class="mdi mdi-chevron-down ml-1"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a href="/admin/setting" class="dropdown-item">
                        <i class="mdi mdi-settings text-primary"></i>
                        Settings
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="mdi mdi-logout text-primary"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
<!-- partial -->