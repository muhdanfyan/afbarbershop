<!-- Top Header Bar (sits to the right of sidebar) -->
<nav class="navbar default-layout-navbar p-0 d-flex flex-row" style="position: sticky; top: 0; z-index: 1000; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin: 0 !important; padding: 0 !important; width: 100% !important; max-width: 100% !important; left: 0 !important;">
    <!-- Header Content Area -->
    <div class="navbar-menu-wrapper d-flex justify-content-between px-4 w-100" style="background: #ffffff; border-bottom: 1px solid #f1f5f9; height: 70px;">
        
        <!-- Left: Toggle & Search -->
        <div class="d-flex align-items-center">
            <button class="navbar-toggler align-self-center d-none d-lg-flex align-items-center justify-content-center mr-3" type="button" data-toggle="minimize" style="border: none; background: #f8fafc; color: #475569; width: 38px; height: 38px; border-radius: 10px; transition: all 0.2s ease;">
                <i class="mdi mdi-menu m-0" style="font-size: 1.4rem;"></i>
            </button>
        </div>

        <!-- Right: User Profile -->
        <div class="d-flex">
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