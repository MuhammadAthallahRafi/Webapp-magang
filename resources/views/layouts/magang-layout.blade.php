<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Magang')</title>
    @vite('resources/css/app.css') {{-- Tailwind CSS --}}
</head>
<body class="bg-gray-100">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

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
    
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button 
            type="submit" 
            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none"
        >
            🚪 Logout
        </button>
    </form>
</div>

            </header>

            {{-- Konten --}}
            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
