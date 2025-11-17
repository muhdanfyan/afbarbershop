<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Affan - PWA Mobile HTML Template">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Title -->
    <title>Affan - PWA Mobile HTML Template</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('/') }}afan/img/core-img/favicon.ico">
    <link rel="apple-touch-icon" href="{{ asset('/') }}afan/img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('/') }}afan/img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('/') }}afan/img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/') }}afan/img/icons/icon-180x180.png">

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}afan/style.css">

    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('/') }}afan/manifest.json">
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Internet Connection Status -->
    <div class="internet-connection-status" id="internetStatus"></div>

    <!-- Back Button -->
    <div class="login-back-button">
        <a href="hero-blocks.html">
            <i class="bi bi-arrow-left-short"></i>
        </a>
    </div>

    <!-- Login Wrapper Area -->
    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <div class="custom-container">
            <div class="text-center px-4">
                <img class="login-intro-img" src="{{ asset('/') }}afan/img/bg-img/36.png" alt="">
            </div>

            <!-- Register Form -->
            <div class="register-form mt-4">
                <h6 class="mb-3 text-center">Log in to continue to the Affan</h6>

                <livewire:login-index />

            </div>

            <!-- Login Meta -->
            <div class="login-meta-data text-center">
                <a class="stretched-link forgot-password d-block mt-3 mb-1" href="forget-password.html">Forgot
                    Password?</a>
                <p class="mb-0">Didn't have an account? <a class="stretched-link" href="register.html">Register Now</a>
                </p>
            </div>
        </div>
    </div>

    <!-- All JavaScript Files -->
    <script src="{{ asset('/') }}afan/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/') }}afan/js/slideToggle.min.js"></script>
    <script src="{{ asset('/') }}afan/js/internet-status.js"></script>
    <script src="{{ asset('/') }}afan/js/tiny-slider.js"></script>
    <script src="{{ asset('/') }}afan/js/venobox.min.js"></script>
    <script src="{{ asset('/') }}afan/js/countdown.js"></script>
    <script src="{{ asset('/') }}afan/js/rangeslider.min.js"></script>
    <script src="{{ asset('/') }}afan/js/vanilla-dataTables.min.js"></script>
    <script src="{{ asset('/') }}afan/js/index.js"></script>
    <script src="{{ asset('/') }}afan/js/imagesloaded.pkgd.min.js"></script>
    <script src="{{ asset('/') }}afan/js/isotope.pkgd.min.js"></script>
    <script src="{{ asset('/') }}afan/js/dark-rtl.js"></script>
    <script src="{{ asset('/') }}afan/js/active.js"></script>
    <script src="{{ asset('/') }}afan/js/pwa.js"></script>
</body>

</html>