<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Magang')</title>
    @vite('resources/css/app.css') {{-- Tailwind CSS --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        {{-- Sidebar --}}
        @include('components.magang-sidebar')
        
        {{-- Konten utama --}}
        <div class="flex flex-col flex-1">
            {{-- Header --}}
            <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold">@yield('page-title')</h1>

                <div class="flex items-center space-x-4">
                    <span>Halo, {{ Auth::user()->name }} 👋</span>
                    
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
                </div>
            </header>

            {{-- Konten --}}
            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts') {{-- ✅ Tambahkan ini untuk custom scripts --}}
</body>
</html>