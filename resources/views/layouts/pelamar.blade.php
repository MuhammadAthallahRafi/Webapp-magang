<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pelamar - MagangApp')</title>

    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    {{-- ===== Navbar ===== --}}
<nav class="bg-white shadow p-4 flex justify-between items-center sticky top-0 z-50">
    <div class="text-xl font-bold text-blue-600">
        MagangApp <span class="text-gray-500 text-sm"> Pelamar</span>
    </div>

    {{-- Dropdown Akun --}}
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open"
                class="flex items-center gap-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
            👋 {{ auth()->user()->name }}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        {{-- Menu Dropdown --}}
        <div x-show="open"
             @click.away="open = false"
             x-transition
             class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden z-50">

            {{-- Pengaturan Akun --}}
            <button @click="window.location='{{ route('akun.setting') }}'"
                    class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                ⚙️ Pengaturan Akun
            </button>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                    🚪 Logout
                </button>
            </form>
        </div>
    </div>
</nav>


    {{-- ===== Kontainer utama ===== --}}
    <div class="flex flex-1">

        {{-- Sidebar (jika ada) --}}
        @includeWhen(View::exists('components.pelamar-sidebar'), 'components.pelamar-sidebar')

        {{-- Konten Halaman --}}
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    {{-- ===== Footer ===== --}}
    <footer class="bg-white text-center text-sm text-gray-500 py-3 border-t">
        &copy; {{ date('Y') }} MagangApp. Semua hak dilindungi.
    </footer>

</body>
</html>
