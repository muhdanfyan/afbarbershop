<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">
</head>

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen transition-colors duration-300">
    <nav class="bg-gray-800 dark:bg-black p-4 text-white mb-8">
        <div class="container mx-auto flex justify-between items-center">
            <div class="font-bold text-xl">Admin Panel</div>
            <div class="flex items-center">
                <button onclick="toggleTheme()" class="mr-4 p-2 rounded-full hover:bg-gray-700 transition-colors">
                    <i class="fas fa-moon dark:hidden"></i>
                    <i class="fas fa-sun hidden dark:inline"></i>
                </button>
                <a href="/admin/dashboard" class="mr-4 hover:underline">Dashboard</a>
                <a href="/admin/transaksi" class="mr-4 hover:underline">Transaksi</a>
                <a href="/admin/vouchers" class="mr-4 hover:underline">Voucher</a>
                <a href="/admin/logout" class="hover:underline">Logout</a>
            </div>
        </div>
    </nav>
    <main>
        @yield('content')
    </main>
</body>

</html>