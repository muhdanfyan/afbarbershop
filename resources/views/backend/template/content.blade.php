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
            background: #111827 !important; /* Premium Dark Navy/Black */
            box-shadow: 4px 0 20px rgba(0,0,0,0.05);
            border-right: none !important;
        }
        .sidebar .nav .nav-category {
            color: #9ca3af !important; /* Muted text */
            text-transform: uppercase;
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 2px;
            padding-top: 2rem;
            margin-bottom: 0.5rem;
            padding-bottom: 0.5rem;
            margin-right: 1.5rem;
            margin-left: 1.5rem;
            font-family: 'Montserrat', sans-serif;
        }
        .sidebar .nav .nav-item .nav-link {
            color: #d1d5db !important;
            padding: 0.8rem 1.25rem !important;
            margin: 0.25rem 1rem !important;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            align-items: center;
        }
        .sidebar .nav .nav-item.active > .nav-link, 
        .sidebar .nav .nav-item .nav-link:hover {
            background: linear-gradient(135deg, #d4af37, #b8972e) !important; /* Signature Gold */
            color: #000 !important;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
            transform: translateX(4px);
        }
        .sidebar .nav .nav-item .nav-link i.menu-icon {
            color: inherit !important;
            font-size: 1.2rem;
            margin-right: 1rem;
        }
        .sidebar .nav .nav-item .nav-link .menu-title {
            font-weight: 600;
            font-size: 0.85rem;
            font-family: 'Montserrat', sans-serif;
            color: inherit !important;
        }
        
        /* Navbar to Match Sidebar */
        .navbar.fixed-top {
            background: #111827 !important;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .navbar .navbar-brand-wrapper {
            background: #111827 !important;
        }
        
        /* Main Body Background */
        body, .page-body-wrapper {
            background: #f8fafc !important; /* Soft premium gray/white for content */
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