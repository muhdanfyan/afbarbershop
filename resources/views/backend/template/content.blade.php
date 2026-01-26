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
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('/') }}tem_admin/template/images/favicon.png" />
    <style>
        .nav-link {
            border: none;
        }
    </style>
</head>

<body>
    <div class="container-scroller">

        @include('backend.template.navbar')

        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar" style="background-color:grey !important;">
                <div class="user-profile">
                    <div class="user-image">
                        @php
                            $foto = auth()->user()->foto ?? null;
                        @endphp
                        @if ($foto)
                            <img src="{{ asset('storage/' . $foto) }}" class="img-thumbnail rounded-circle" width="60">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}"
                                class="img-thumbnail rounded-circle" width="60">
                        @endif
                    </div>
                    <div class="user-name">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="user-designation">
                        Admin
                    </div>
                </div>

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