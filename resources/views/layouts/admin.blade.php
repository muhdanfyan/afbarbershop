<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-gray-800 p-4 text-white mb-8">
        <div class="container mx-auto flex justify-between items-center">
            <div class="font-bold text-xl">Admin Panel</div>
            <div>
                <a href="/admin/dashboard" class="mr-4 hover:underline">Dashboard</a>
                <a href="/admin/transaksi" class="mr-4 hover:underline">Transaksi</a>
                <a href="/admin/logout" class="hover:underline">Logout</a>
            </div>
        </div>
    </nav>
    <main>
        @yield('content')
    </main>
</body>

</html>