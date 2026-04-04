<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }} - @yield('title')</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('/') }}tem_admin/template/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}tem_admin/template/vendors/feather/feather.css">
    <link rel="stylesheet" href="{{ asset('/') }}tem_admin/template/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('/') }}tem_admin/template/vendors/flag-icon-css/css/flag-icon.min.css" />
    <link rel="stylesheet" href="{{ asset('/') }}tem_admin/template/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}tem_admin/template/vendors/jquery-bar-rating/fontawesome-stars-o.css">
    <link rel="stylesheet" href="{{ asset('/') }}tem_admin/template/vendors/jquery-bar-rating/fontawesome-stars.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('/') }}tem_admin/template/css/style.css">
    <link rel="stylesheet" href="{{ asset('/') }}css/modern-dashboard.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('logo-icon.png') }}" />
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        .nav-link {
            border: none;
        }
        /* --- Premium Sidebar & Navbar Enhancements --- */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap');
        
        .container-scroller, .page-body-wrapper, .main-panel, .sidebar, .navbar {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }
        .sidebar {
            background: #111827 !important;
            box-shadow: 4px 0 20px rgba(0,0,0,0.05);
            border-right: none !important;
            position: relative;
            z-index: 1010;
        }
        .page-body-wrapper { 
            height: 100vh;
            max-height: 100vh;
            display: flex; 
            flex-direction: row;
            background: #f8fafc;
            overflow: hidden;
        }
        .main-panel {
            flex: 1;
            height: 100vh;
            max-height: 100vh;
            overflow-y: auto;
            background: #f8fafc;
            padding-left: 0;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        .sidebar .nav {
            padding-top: 0.5rem !important;
        }
        .sidebar .nav .nav-category {
            color: #9ca3af !important; /* Muted text */
            text-transform: uppercase;
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 2px;
            letter-spacing: 2px;
            padding-top: 0.5rem;
            margin-bottom: 0px;
            padding-bottom: 0px;
            margin-right: 1.5rem;
            margin-left: 1.5rem;
            font-family: 'Montserrat', sans-serif;
        }
        .sidebar .nav .nav-category:first-of-type {
            padding-top: 0.25rem !important;
        }
        .sidebar .nav .nav-item .nav-link {
            color: #d1d5db !important;
            padding: 0.4rem 1.25rem !important;
            margin: 0.1rem 1.25rem !important;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            align-items: center;
        }
        .sidebar .nav .nav-item.active > .nav-link, 
        .sidebar .nav .nav-item .nav-link:hover {
            background: linear-gradient(135deg, #d4af37, #c5a028) !important; /* Signature Gold Gradient */
            color: #111827 !important; /* Deep Navy contrast */
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.25);
            transform: translateX(5px);
        }
        .sidebar .nav .nav-item .nav-link i.menu-icon {
            color: inherit !important;
            font-size: 1.15rem;
            margin-right: 1rem;
        }
        .sidebar .nav .nav-item .nav-link .menu-title {
            font-weight: 700;
            font-size: 0.8rem;
            font-family: 'Montserrat', sans-serif;
            color: inherit !important;
            letter-spacing: 0.3px;
        }
        
        /* Navbar Layout Tuning */
        .navbar {
            background: transparent !important;
            box-shadow: none !important;
            border-bottom: none !important;
        }
        .navbar .navbar-brand-wrapper {
            background: #111827 !important;
        }
        
        /* Main Body Background & Full Width Layout */
        body, .page-body-wrapper {
            background: #f8fafc !important; /* Soft premium gray/white for content */
        }
        
        .content-wrapper {
            padding: 1rem 1.5rem !important;
            width: 100% !important;
            max-width: 100% !important;
            flex-grow: 1;
        }

        .card {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 4px 25px rgba(0,0,0,0.04) !important;
            width: 100% !important;
            margin-bottom: 1rem;
        }

        .table-responsive {
            width: 100% !important;
            border: none !important;
        }

        .table {
            width: 100% !important;
            margin-bottom: 0 !important;
        }

        .table thead th {
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 1px;
            border-top: none !important;
            padding: 0.75rem 1rem !important;
        }

        .table tbody td {
            padding: 0.75rem 1rem !important;
            vertical-align: middle !important;
        }

        /* Icon-only sidebar handling (For precise centering) */
        .sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-title,
        .sidebar-icon-only .sidebar .nav .nav-category {
            display: none !important;
        }
        .sidebar-icon-only .sidebar .nav .nav-item .nav-link {
            justify-content: center !important;
            padding: 0.8rem 0 !important;
            margin: 0.25rem 0 !important;
            border-radius: 0 !important;
            width: 100% !important;
        }
        .sidebar-icon-only .sidebar .nav .nav-item.active > .nav-link, 
        .sidebar-icon-only .sidebar .nav .nav-item .nav-link:hover {
            transform: none !important; /* Disable slide on compact mode */
        }
        .sidebar-icon-only .sidebar .nav .nav-item .nav-link i.menu-icon {
            margin-right: 0 !important;
            font-size: 1.4rem !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* Premium Button System */
        .btn-premium-add {
            background: linear-gradient(135deg, #d4af37, #b8972e);
            color: #000 !important;
            font-weight: 700;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            padding: 0.6rem 1.25rem;
        }
        .btn-premium-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
            filter: brightness(1.1);
        }
        .btn-premium-edit {
            background: #e0f2fe;
            color: #0369a1 !important;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }
        .btn-premium-edit:hover {
            background: #bae6fd;
            transform: scale(1.05);
        }
        .btn-premium-delete {
            background: #fee2e2;
            color: #b91c1c !important;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }
        .btn-premium-delete:hover {
            background: #fecaca;
            transform: scale(1.05);
        }
        .btn-premium-view {
            background: #f1f5f9;
            color: #475569 !important;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }
        .btn-premium-view:hover {
            background: #e2e8f0;
            transform: scale(1.05);
        }
        .btn-premium-add i, .btn-premium-edit i, .btn-premium-delete i, .btn-premium-view i {
            margin-right: 6px;
            font-size: 1.1rem;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar (Pillar Mode) -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                @include('backend.template.menu')
            </nav>
            
            <!-- Main Content Area -->
            <div class="main-panel">
                @include('backend.template.navbar')
                
                <div class="content-wrapper">
                    @yield('content')
                </div>
                
                @include('backend.template.footer')
            </div>
        </div>
    </div>
    <!-- container-scroller -->

    <!-- base:js -->
    <script src="{{ asset('/') }}tem_admin/template/vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="{{ asset('/') }}tem_admin/template/js/off-canvas.js"></script>
    <script src="{{ asset('/') }}tem_admin/template/js/hoverable-collapse.js"></script>
    <script src="{{ asset('/') }}tem_admin/template/js/template.js"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <script src="{{ asset('/') }}tem_admin/template/vendors/chart.js/Chart.min.js"></script>
    <script src="{{ asset('/') }}tem_admin/template/vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="{{ asset('/') }}tem_admin/template/js/dashboard.js"></script>
    <!-- End custom js for this page-->
</body>

</html>