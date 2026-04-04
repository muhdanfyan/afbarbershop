<!-- partial:partials/_navbar.html -->
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row" style="background:#111827; border-bottom: 1px solid rgba(255,255,255,0.05); box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" style="background:#111827;">
        @php
            $logoPath = isset($settings['logo']) && $settings['logo'] ? asset('storage/' . $settings['logo']) : asset('logoposeidonputih.png');
        @endphp
        <a class="brand-logo px-3 w-100 text-center" href="/admin/dashboard" style="display:block;">
            <img src="{{ $logoPath }}" alt="logo" style="max-height: 40px; border-radius: 8px; object-fit: contain;">
        </a>
    </div>
    
    <!-- Navbar Content Area -->
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between px-4">
        
        <!-- Left Side: Hamburger & Search -->
        <div class="d-flex align-items-center">
            <!-- Sidebar Toggler Desktop -->
            <button class="navbar-toggler align-self-center d-none d-lg-flex align-items-center justify-content-center mr-4" type="button" data-toggle="minimize" style="border: none; background: rgba(255,255,255,0.05); color: #d4af37; width: 40px; height: 40px; border-radius: 12px; transition: all 0.3s ease;">
                <i class="mdi mdi-menu m-0" style="font-size: 1.5rem;"></i>
            </button>
            
            <!-- Search Glass -->
            <div class="search-wrapper d-none d-md-flex align-items-center">
                <div class="input-group d-flex align-items-center" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 0.4rem 1.2rem; transition: background 0.3s ease;">
                    <i class="mdi mdi-magnify mr-2" style="font-size: 1.2rem; color: #9ca3af;"></i>
                    <input type="text" class="form-control border-0 bg-transparent p-0 text-white shadow-none" placeholder="Cari data..." style="height: auto; font-size: 0.85rem; width: 200px; color: #e5e7eb;">
                </div>
            </div>
        </div>

        <!-- Right Side: User Profile -->
        <div class="d-flex align-items-center">
            <ul class="navbar-nav navbar-nav-right ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center px-3 py-2 m-0" href="#" data-toggle="dropdown" id="profileDropdown" style="background: rgba(255,255,255,0.03); border-radius: 12px; color: #e5e7eb; transition: background 0.3s ease;">
                        <img src="{{ auth()->user()->foto ? asset('storage/'.auth()->user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=2a2a2a&color=d4af37' }}" alt="profile" class="rounded-circle mr-3" style="width: 32px; height: 32px; border: 2px solid rgba(212, 175, 55, 0.5);"/>
                        <div class="d-flex flex-column justify-content-center text-left mr-2">
                            <span class="nav-profile-name small font-weight-bold d-block line-height-1 mb-0 pb-0" style="color: #f3f4f6;">{{ auth()->user()->name }}</span>
                            <span class="small font-weight-normal d-block line-height-1" style="font-size: 0.7rem; color: #d4af37;">Administrator</span>
                        </div>
                        <i class="mdi mdi-chevron-down ml-1 text-muted" style="font-size: 1.2rem;"></i>
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown" style="border-radius: 14px; border: 1px solid rgba(255,255,255,0.1); background: #1f2937; box-shadow: 0 10px 30px rgba(0,0,0,0.3); padding: 0.5rem; margin-top: 10px;">
                        <a href="/admin/setting" class="dropdown-item d-flex align-items-center py-2" style="border-radius: 8px; color: #e5e7eb; transition: all 0.2s ease;">
                            <div class="bg-light-primary rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 32px; height: 32px; background: rgba(37,99,235,0.1) !important;">
                                <i class="mdi mdi-settings text-primary m-0" style="font-size: 1.1rem;"></i>
                            </div>
                            Settings Konfigurasi
                        </a>
                        <div class="dropdown-divider" style="border-top: 1px solid rgba(255,255,255,0.05); margin: 0.5rem 0;"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center py-2" style="border-radius: 8px; color: #ef4444; transition: all 0.2s ease; cursor: pointer;">
                                <div class="bg-light-danger rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 32px; height: 32px; background: rgba(239,68,68,0.1) !important;">
                                    <i class="mdi mdi-logout text-danger m-0" style="font-size: 1.1rem;"></i>
                                </div>
                                Logout Session
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
            
            <!-- Sidebar Toggler Mobile -->
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ml-2" type="button" data-toggle="offcanvas" style="color: #d4af37;">
                <span class="mdi mdi-menu" style="font-size: 1.8rem;"></span>
            </button>
        </div>
    </div>
</nav>
<!-- partial -->