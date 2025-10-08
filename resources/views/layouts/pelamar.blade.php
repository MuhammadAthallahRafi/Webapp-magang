<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pelamar - MagangApp</title>
    @vite('resources/css/app.css')
    <style>
    [x-cloak] { display: none !important; }
</style>

</head>
<body class="bg-gray-100 text-gray-800">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    {{-- Navbar --}}
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <div class="text-xl font-bold text-blue-600">Pelamar - MagangApp</div>

        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-700">Halo, {{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    {{-- Konten halaman --}}
    <main class="p-6">
        @yield('content')
    </main>

</body>
</html>
