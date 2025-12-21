@php
    $active = request()->path();
    $user = auth()->user();
@endphp

<aside class="w-64 bg-gradient-to-b from-orange-600 via-orange-500 to-orange-400 text-white shadow-xl min-h-screen flex flex-col">
    <!-- Header Sidebar -->
    <div class="p-6 border-b border-orange-500">
        <div class="flex flex-col items-center justify-center">
            <!-- Logo BKN -->
            <div class="mb-4">
                <div class="bg-white w-40 h-24 rounded-lg flex items-center justify-center shadow-lg p-2">
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" 
                             alt="Logo BKN" 
                             class="h-full w-auto object-contain">
                    @else
                        <!-- Fallback jika logo tidak ditemukan -->
                        <div class="text-orange-900 text-center w-full h-full flex flex-col items-center justify-center">
                            <i class="fas fa-user-graduate text-3xl mb-2"></i>
                            <p class="text-xs font-semibold">PESERTA</p>
                            <p class="text-xs">MAGANG BKN</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Informasi Instansi -->
            <div class="text-center">
                <h2 class="font-bold text-lg">Peserta Magang</h2>
                <h3 class="font-semibold text-sm text-orange-200">Badan Kepegawaian Negara</h3>
                <p class="text-xs text-orange-300 mt-1">Panel Peserta Magang</p>
            </div>
            
            <!-- Informasi Pengguna -->
            @if($user && $user->pelamar)
                <div class="mt-6 pt-4 border-t border-orange-500 w-full text-center">
                    <div class="w-10 h-10 rounded-full bg-orange-700 flex items-center justify-center mx-auto mb-2">
                        <span class="font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <p class="text-sm font-medium truncate">{{ $user->name }}</p>
                    <p class="text-xs text-orange-300 capitalize">Peserta Magang</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Menu Navigasi -->
    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="space-y-1">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard.magang') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ request()->routeIs('dashboard.magang') ? 'bg-white text-orange-700 font-semibold shadow-md' : 'hover:bg-orange-600 hover:text-white hover:shadow-sm' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 
                        {{ request()->routeIs('dashboard.magang') ? 'bg-orange-100' : 'bg-orange-700' }}">
                        <i class="fas fa-tachometer-alt {{ request()->routeIs('dashboard.magang') ? 'text-orange-600' : 'text-orange-300' }}"></i>
                    </div>
                    <span>Dashboard</span>
                    @if(request()->routeIs('dashboard.magang'))
                        <div class="ml-auto w-2 h-2 bg-orange-600 rounded-full active-menu-indicator"></div>
                    @endif
                </a>
            </li>

            <!-- Riwayat Absensi -->
            <li>
                <a href="{{ route('magang.riwayat') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ request()->routeIs('magang.riwayat') ? 'bg-white text-orange-700 font-semibold shadow-md' : 'hover:bg-orange-600 hover:text-white hover:shadow-sm' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 
                        {{ request()->routeIs('magang.riwayat') ? 'bg-orange-100' : 'bg-orange-700' }}">
                        <i class="fas fa-calendar-check {{ request()->routeIs('magang.riwayat') ? 'text-orange-600' : 'text-orange-300' }}"></i>
                    </div>
                    <span>Riwayat Absensi</span>
                    @if(request()->routeIs('magang.riwayat'))
                        <div class="ml-auto w-2 h-2 bg-orange-600 rounded-full active-menu-indicator"></div>
                    @endif
                </a>
            </li>

            <!-- Data Diri -->
            <li>
                <a href="{{ route('magang.data-diri') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ request()->routeIs('magang.data-diri') ? 'bg-white text-orange-700 font-semibold shadow-md' : 'hover:bg-orange-600 hover:text-white hover:shadow-sm' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 
                        {{ request()->routeIs('magang.data-diri') ? 'bg-orange-100' : 'bg-orange-700' }}">
                        <i class="fas fa-user-circle {{ request()->routeIs('magang.data-diri') ? 'text-orange-600' : 'text-orange-300' }}"></i>
                    </div>
                    <span>Data Diri</span>
                    @if(request()->routeIs('magang.data-diri'))
                        <div class="ml-auto w-2 h-2 bg-orange-600 rounded-full active-menu-indicator"></div>
                    @endif
                </a>
            </li>
        </ul>

        <!-- Divider -->
        <div class="my-6 border-t border-orange-500"></div>

        <!-- Quick Info -->
        <div class="px-4 py-3 bg-orange-600/50 rounded-lg">
            <h4 class="text-xs font-semibold text-orange-300 uppercase tracking-wider mb-2">Informasi Cepat</h4>
            <div class="space-y-2">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-orange-300 text-xs mr-2"></i>
                    <span class="text-xs text-orange-200">Panel peserta magang</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-shield-alt text-orange-300 text-xs mr-2"></i>
                    <span class="text-xs text-orange-200">Akses terbatas</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Footer Sidebar -->
    <div class="p-4 border-t border-orange-500 bg-orange-700/50">
        <div class="text-center">
            <p class="text-xs text-orange-300">Peserta Magang BKN</p>
            <p class="text-xs text-orange-400 mt-1">v1.0 • {{ date('Y') }}</p>
        </div>
        
        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors text-sm">
                <i class="fas fa-sign-out-alt mr-2"></i>
                Keluar Sistem
            </button>
        </form>
    </div>
</aside>

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Custom scrollbar untuk sidebar */
    aside nav::-webkit-scrollbar {
        width: 4px;
    }
    
    aside nav::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }
    
    aside nav::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }
    
    aside nav::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }
    
    /* Animasi untuk menu aktif */
    .active-menu-indicator {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ripple effect untuk menu
        const menuItems = document.querySelectorAll('aside nav a');
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.3);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    width: ${size}px;
                    height: ${size}px;
                    top: ${y}px;
                    left: ${x}px;
                    pointer-events: none;
                `;
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    if (ripple.parentNode === this) {
                        ripple.remove();
                    }
                }, 600);
            });
        });
    });
</script>