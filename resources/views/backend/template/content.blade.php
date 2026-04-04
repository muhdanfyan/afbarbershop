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
        .nav-link {
            border: none;
        }
        /* --- Premium Sidebar & Navbar Enhancements --- */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap');
        
        .sidebar {
            background: #111827 !important;
            box-shadow: 4px 0 20px rgba(0,0,0,0.05);
            border-right: none !important;
            padding-top: 0 !important;
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
            padding-top: 1rem;
            margin-bottom: 0.1rem;
            padding-bottom: 0.1rem;
            margin-right: 1.5rem;
            margin-left: 1.5rem;
            font-family: 'Montserrat', sans-serif;
        }
        .sidebar .nav .nav-category:first-of-type {
            padding-top: 0.25rem !important;
        }
        .sidebar .nav .nav-item .nav-link {
            color: #d1d5db !important;
            padding: 0.65rem 1.25rem !important;
            margin: 0.25rem 1.25rem !important;
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
            font-size: 1.25rem;
            margin-right: 1rem;
        }
        .sidebar .nav .nav-item .nav-link .menu-title {
            font-weight: 700;
            font-size: 0.85rem;
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
        
        /* Main Body Background */
        body, .page-body-wrapper {
            background: #f8fafc !important; /* Soft premium gray/white for content */
        }
        
        /* Icon-only sidebar handling */
        .sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-title,
        .sidebar-icon-only .sidebar .nav .nav-category {
            display: none !important;
        }
        .sidebar-icon-only .sidebar .nav .nav-item .nav-link {
            justify-content: center !important;
            padding: 0.8rem !important;
        }
        .sidebar-icon-only .sidebar .nav .nav-item .nav-link i.menu-icon {
            margin-right: 0 !important;
            font-size: 1.5rem !important;
        }
    </style>
</head>

<body>
    <div class="container-scroller">

        @include('backend.template.navbar')

        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                @include('backend.template.menu')
            </nav>
            @yield('content')
        </div>
        <!-- page-body-wrapper ends -->
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