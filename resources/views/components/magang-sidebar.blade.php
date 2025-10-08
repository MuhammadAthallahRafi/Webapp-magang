<aside class="w-64 bg-orange-500 text-white flex flex-col">
    <div class="p-6 text-2xl font-bold border-b border-orange-400">
        Magang Panel
    </div>
    <nav class="flex-1 p-4 space-y-2">
        <a href="{{ route('dashboard.magang') }}" 
           class="block px-4 py-2 rounded hover:bg-orange-400 {{ request()->routeIs('dashboard.magang') ? 'bg-orange-400' : '' }}">
           📊 Dashboard
        </a>
        <a href="{{ route('magang.riwayat') }}" 
           class="block px-4 py-2 rounded hover:bg-orange-400 {{ request()->routeIs('magang.riwayat') ? 'bg-orange-400' : '' }}">
           📅 Riwayat Absensi
        </a>
        <a href="{{ route('magang.data-diri') }}" 
           class="block px-4 py-2 rounded hover:bg-orange-400 {{ request()->routeIs('magang.data-diri') ? 'bg-orange-400' : '' }}">
           📄 Data Diri
        </a>
    </nav>
</aside>
