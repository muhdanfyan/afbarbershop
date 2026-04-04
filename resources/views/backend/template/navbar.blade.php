<!-- Top Header Bar (sits to the right of sidebar) -->
<nav class="navbar default-layout-navbar p-0 d-flex flex-row" style="position: sticky; top: 0; z-index: 1000; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin: 0 !important; padding: 0 !important; width: 100% !important; max-width: 100% !important; left: 0 !important;">
    <!-- Header Content Area -->
    <div class="navbar-menu-wrapper d-flex justify-content-between px-4 w-100" id="admin-navbar-wrapper" style="background: #ffffff; border-bottom: 1px solid #f1f5f9; height: 70px; transition: background 0.3s, border-color 0.3s;">
        
        <!-- Left: Toggle & Search -->
        <div class="d-flex align-items-center">
            <button class="navbar-toggler align-self-center d-none d-lg-flex align-items-center justify-content-center mr-3" type="button" data-toggle="minimize" style="border: none; background: #f8fafc; color: #475569; width: 38px; height: 38px; border-radius: 10px; transition: all 0.2s ease;">
                <i class="mdi mdi-menu m-0" style="font-size: 1.4rem;"></i>
            </button>
        </div>

        <!-- Right: Theme Toggle + User Profile -->
        <div class="d-flex align-items-center">
            <!-- Dark/Light Toggle -->
            <button id="admin-theme-toggle" onclick="adminToggleTheme()" title="Toggle Dark/Light Mode"
                style="border: none; background: #f8fafc; color: #475569; width: 38px; height: 38px; border-radius: 10px; transition: all 0.2s ease; display:flex; align-items:center; justify-content:center; margin-right: 12px; cursor:pointer;">
                <i id="admin-icon-moon" class="mdi mdi-weather-night" style="font-size: 1.3rem;"></i>
                <i id="admin-icon-sun" class="mdi mdi-weather-sunny" style="font-size: 1.3rem; display:none;"></i>
            </button>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex px-3 py-2 m-0" href="#" data-toggle="dropdown" id="profileDropdown" style="background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <img src="{{ auth()->user()->foto ? asset('storage/'.auth()->user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=111827&color=fff' }}" alt="profile" class="rounded-circle mr-2" style="width: 30px; height: 30px; border: 2px solid #e2e8f0;"/>
                        <div class="d-flex flex-column justify-content-center text-left mr-1">
                            <span class="small font-weight-bold d-block" style="color: #1e293b; line-height: 1.2;">{{ auth()->user()->name }}</span>
                            <span class="small d-block" style="font-size: 0.65rem; color: #64748b; line-height: 1.2;">Administrator</span>
                        </div>
                        <i class="mdi mdi-chevron-down ml-1" style="font-size: 1rem; color: #94a3b8;"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.08); padding: 0.5rem; margin-top: 8px;">
                        <a href="/admin/setting" class="dropdown-item d-flex align-items-center py-2 px-3" style="border-radius: 8px; color: #475569;">
                            <i class="mdi mdi-settings mr-2 text-primary" style="font-size: 1.1rem;"></i>
                            Settings
                        </a>
                        <div class="dropdown-divider" style="border-top: 1px solid #f1f5f9; margin: 0.3rem 0;"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center py-2 px-3" style="border-radius: 8px; color: #ef4444; cursor: pointer;">
                                <i class="mdi mdi-logout mr-2 text-danger" style="font-size: 1.1rem;"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ml-2" type="button" data-toggle="offcanvas" style="color: #475569;">
                <span class="mdi mdi-menu" style="font-size: 1.6rem;"></span>
            </button>
        </div>
    </div>
</nav>

<style>
    /* ===== ADMIN DARK MODE ===== */
    body.admin-dark .page-body-wrapper,
    body.admin-dark .main-panel,
    body.admin-dark .content-wrapper {
        background: #0f172a !important;
    }
    body.admin-dark #admin-navbar-wrapper {
        background: #1e293b !important;
        border-bottom-color: #334155 !important;
    }
    body.admin-dark .card {
        background: #1e293b !important;
        box-shadow: 0 4px 25px rgba(0,0,0,0.3) !important;
    }
    body.admin-dark .card-body,
    body.admin-dark .card-header,
    body.admin-dark .card-title,
    body.admin-dark .card-text {
        color: #e2e8f0 !important;
    }
    body.admin-dark .table thead th {
        background: #0f172a !important;
        color: #94a3b8 !important;
        border-color: #334155 !important;
    }
    body.admin-dark .table tbody td {
        color: #cbd5e1 !important;
        border-color: #1e293b !important;
        background: #1e293b !important;
    }
    body.admin-dark .table tbody tr:hover td {
        background: #273548 !important;
    }
    body.admin-dark h1, body.admin-dark h2, body.admin-dark h3, body.admin-dark h4, body.admin-dark h5, body.admin-dark h6,
    body.admin-dark p, body.admin-dark span, body.admin-dark label, body.admin-dark div {
        color: #e2e8f0;
    }
    body.admin-dark .form-control {
        background: #0f172a !important;
        border-color: #334155 !important;
        color: #e2e8f0 !important;
    }
    body.admin-dark .modal-content {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #e2e8f0 !important;
    }
    body.admin-dark .modal-header, body.admin-dark .modal-footer {
        border-color: #334155 !important;
    }
    body.admin-dark #admin-theme-toggle {
        background: #334155 !important;
        color: #fbbf24 !important;
    }
    body.admin-dark .dropdown-menu {
        background: #1e293b !important;
        border-color: #334155 !important;
    }
    body.admin-dark .dropdown-item {
        color: #cbd5e1 !important;
    }
    body.admin-dark .dropdown-item:hover {
        background: #273548 !important;
    }
    body.admin-dark .dropdown-divider {
        border-color: #334155 !important;
    }
    body.admin-dark nav.sidebar {
        background: #0a0f1a !important;
        box-shadow: 4px 0 20px rgba(0,0,0,0.3) !important;
    }

    /* --- Text Contrast & Utility Overrides --- */
    body.admin-dark .text-dark, 
    body.admin-dark h1, body.admin-dark h2, body.admin-dark h3, 
    body.admin-dark h4, body.admin-dark h5, body.admin-dark h6 {
        color: #f1f5f9 !important;
    }
    body.admin-dark .text-muted {
        color: #94a3b8 !important;
    }
    body.admin-dark .bg-light {
        background-color: #1e293b !important;
    }
    body.admin-dark .border-bottom {
        border-bottom-color: #334155 !important;
    }

    /* --- Stat Cards & Icons --- */
    body.admin-dark .stat-card {
        background: #1e293b !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
    }
    body.admin-dark .bg-light-primary { background: rgba(67, 97, 238, 0.15) !important; color: #818cf8 !important; }
    body.admin-dark .bg-light-success { background: rgba(34, 197, 94, 0.15) !important; color: #4ade80 !important; }
    body.admin-dark .bg-light-info { background: rgba(59, 130, 246, 0.15) !important; color: #60a5fa !important; }
    body.admin-dark .bg-light-danger { background: rgba(239, 68, 68, 0.15) !important; color: #f87171 !important; }
    body.admin-dark .bg-light-warning { background: rgba(245, 158, 11, 0.15) !important; color: #fbbf24 !important; }

    /* --- Charts & Tables --- */
    body.admin-dark .table-premium th {
        background: #0f172a !important;
        color: #94a3b8 !important;
        border-bottom-color: #334155 !important;
    }
    body.admin-dark canvas {
        filter: brightness(0.9) saturate(1.2);
    }
    /* --- Dashboard Specific Overrides --- */
    body.admin-dark .card[style*="background: linear-gradient"] {
        background: #1e293b !important;
    }
    body.admin-dark .greetings-text h2,
    body.admin-dark h3.font-weight-bold.text-dark {
        color: #f8fafc !important;
    }
    body.admin-dark .bg-white {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body.admin-dark .shadow-sm {
        box-shadow: 0 4px 15px rgba(0,0,0,0.4) !important;
    }
    body.admin-dark .border-gray-100 {
        border-color: #334155 !important;
    }
</style>

<script>
    // ===== SIDEBAR PERSISTENCE & MOBILE RESPONSIVENESS =====
    (function () {
        const body = document.body;
        const savedSidebar = localStorage.getItem('sidebarMinimized');
        const isMobile = window.innerWidth < 992;

        // 1. Initial State: Only force minimized on desktop if previously saved as minimized
        if (!isMobile && savedSidebar === 'minimized') {
            body.classList.add('sidebar-icon-only');
        }

        // 2. Monitoring & Persistence
        document.addEventListener('DOMContentLoaded', function() {
            // Monitor desktop toggle button
            const sidebarToggle = document.querySelector('[data-toggle="minimize"]');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    // Small delay to wait for template JS to toggle classes
                    setTimeout(() => {
                        const isMinimized = body.classList.contains('sidebar-icon-only');
                        localStorage.setItem('sidebarMinimized', isMinimized ? 'minimized' : 'expanded');
                    }, 50);
                });
            }

            // 3. Mobile Auto-Shrink on Resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    const mobileNow = window.innerWidth < 992;
                    if (mobileNow) {
                        body.classList.add('sidebar-icon-only');
                    } else if (localStorage.getItem('sidebarMinimized') === 'expanded') {
                        body.classList.remove('sidebar-icon-only');
                    }
                }, 250);
            });
        });
    })();

    // ===== ADMIN DARK MODE TOGGLE =====
    function adminToggleTheme() {
        const body = document.body;
        const isDark = body.classList.toggle('admin-dark');
        localStorage.setItem('adminTheme', isDark ? 'dark' : 'light');
        updateAdminThemeIcons(isDark);
    }

    function updateAdminThemeIcons(isDark) {
        const moonIcon = document.getElementById('admin-icon-moon');
        const sunIcon = document.getElementById('admin-icon-sun');
        if (moonIcon) moonIcon.style.display = isDark ? 'none' : 'block';
        if (sunIcon) sunIcon.style.display = isDark ? 'block' : 'none';
    }

    // Apply saved admin theme on load
    (function () {
        const saved = localStorage.getItem('adminTheme');
        const isDark = saved === 'dark';
        if (isDark) document.body.classList.add('admin-dark');
        document.addEventListener('DOMContentLoaded', function () {
            updateAdminThemeIcons(isDark);
        });
    })();
</script>