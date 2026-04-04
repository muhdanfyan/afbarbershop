<!-- partial:partials/_navbar.html -->
<nav class="navbar col-lg-12 col-12 p-0 d-flex flex-row" style="border: none; background: transparent;">
    <!-- Logo Area (Top of Sidebar) -->
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" style="background: #111827 !important; border-bottom: none; width: 240px; flex: 0 0 240px;">
        @php
            $logoPath = isset($settings['logo']) && $settings['logo'] ? asset('storage/' . $settings['logo']) : asset('logoposeidonputih.png');
        @endphp
        <a class="brand-logo px-3 w-100 text-center" href="/admin/dashboard" style="display:block;">
            <img src="{{ $logoPath }}" alt="logo" style="max-height: 40px; border-radius: 8px; object-fit: contain;">
        </a>
    </div>
    
    <!-- Top Header Area (Right of Sidebar) -->
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between px-4" style="background: #ffffff; border-bottom: 1px solid #f1f5f9; width: calc(100% - 240px); margin-left: auto;">
        
        <!-- Left Side: Hamburger & Search -->
        <div class="d-flex align-items-center">
            <!-- Sidebar Toggler Desktop -->
            <button class="navbar-toggler align-self-center d-none d-lg-flex align-items-center justify-content-center mr-4" type="button" data-toggle="minimize" style="border: none; background: #f8fafc; color: #475569; width: 40px; height: 40px; border-radius: 12px; transition: all 0.3s ease;">
                <i class="mdi mdi-menu m-0" style="font-size: 1.5rem;"></i>
            </button>
            
            <!-- Search Glass -->
            <div class="search-wrapper d-none d-md-flex align-items-center">
                <div class="input-group d-flex align-items-center" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 0.4rem 1.2rem; transition: background 0.3s ease;">
                    <i class="mdi mdi-magnify mr-2" style="font-size: 1.2rem; color: #94a3b8;"></i>
                    <input type="text" class="form-control border-0 bg-transparent p-0 shadow-none" placeholder="Cari data..." style="height: auto; font-size: 0.85rem; width: 220px; color: #334155;">
                </div>
            </div>
        </div>

        <!-- Right Side: User Profile -->
        <div class="d-flex align-items-center">
            <ul class="navbar-nav navbar-nav-right ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center px-3 py-2 m-0" href="#" data-toggle="dropdown" id="profileDropdown" style="background: #f8fafc; border-radius: 12px; transition: background 0.3s ease; border: 1px solid #e2e8f0;">
                        <img src="{{ auth()->user()->foto ? asset('storage/'.auth()->user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=111827&color=fff' }}" alt="profile" class="rounded-circle mr-3" style="width: 32px; height: 32px; border: 2px solid #e2e8f0;"/>
                        <div class="d-flex flex-column justify-content-center text-left mr-2">
                            <span class="nav-profile-name small font-weight-bold d-block line-height-1 mb-0 pb-0" style="color: #1e293b;">{{ auth()->user()->name }}</span>
                            <span class="small font-weight-normal d-block line-height-1 mt-1" style="font-size: 0.7rem; color: #64748b;">Administrator</span>
                        </div>
                        <i class="mdi mdi-chevron-down ml-1 text-muted" style="font-size: 1.2rem;"></i>
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown" style="border-radius: 14px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 10px 30px rgba(0,0,0,0.08); padding: 0.5rem; margin-top: 10px;">
                        <a href="/admin/setting" class="dropdown-item d-flex align-items-center py-2" style="border-radius: 8px; color: #475569; transition: all 0.2s ease;">
                            <div class="bg-light-primary rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 32px; height: 32px; background: rgba(37,99,235,0.1) !important;">
                                <i class="mdi mdi-settings text-primary m-0" style="font-size: 1.1rem;"></i>
                            </div>
                            <span style="font-weight: 500;">Settings Konfigurasi</span>
                        </a>
                        <div class="dropdown-divider" style="border-top: 1px solid #f1f5f9; margin: 0.5rem 0;"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center py-2" style="border-radius: 8px; color: #ef4444; transition: all 0.2s ease; cursor: pointer;">
                                <div class="bg-light-danger rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 32px; height: 32px; background: rgba(239,68,68,0.1) !important;">
                                    <i class="mdi mdi-logout text-danger m-0" style="font-size: 1.1rem;"></i>
                                </div>
                                <span style="font-weight: 500;">Logout Session</span>
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
            
            <!-- Sidebar Toggler Mobile -->
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ml-2" type="button" data-toggle="offcanvas" style="color: #475569;">
                <span class="mdi mdi-menu" style="font-size: 1.8rem;"></span>
            </button>
        </div>
    </div>
</nav>
<!-- partial -->