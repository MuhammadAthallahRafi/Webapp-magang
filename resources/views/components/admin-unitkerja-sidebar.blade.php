@php
    $active = request()->path();
    $user = auth()->user();
@endphp

<aside class="w-64 bg-gradient-to-b from-blue-800 via-blue-700 to-blue-600 text-white shadow-xl min-h-screen flex flex-col">
    <!-- Header Sidebar -->
    <div class="p-6 border-b border-blue-600">
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
                        <div class="text-blue-900 text-center w-full h-full flex flex-col items-center justify-center">
                            <i class="fas fa-building text-3xl mb-2"></i>
                            <p class="text-xs font-semibold">UNIT KERJA</p>
                            <p class="text-xs">Badan Kepegawaian</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Informasi Instansi -->
            <div class="text-center">
                <h2 class="font-bold text-lg">Unit Kerja</h2>
                <h3 class="font-semibold text-sm text-blue-200">Badan Kepegawaian Negara</h3>
                <p class="text-xs text-blue-300 mt-1">Panel Admin Unit Kerja</p>
            </div>
            
            <!-- Informasi Pengguna -->
            @if($user)
                <div class="mt-6 pt-4 border-t border-blue-600 w-full text-center">
                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center mx-auto mb-2">
                        <span class="font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <p class="text-sm font-medium truncate">{{ $user->name }}</p>
                    <p class="text-xs text-blue-300 capitalize">Admin Unit Kerja</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Menu Navigasi -->
    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="space-y-1">
            <!-- Dashboard -->
            <li>
                <a href="/dashboard/admin-unitkerja"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ request()->is('dashboard/admin-unitkerja') ? 'bg-white text-blue-800 font-semibold shadow-md' : 'hover:bg-blue-700 hover:text-white hover:shadow-sm' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 
                        {{ request()->is('dashboard/admin-unitkerja') ? 'bg-blue-100' : 'bg-blue-600' }}">
                        <i class="fas fa-tachometer-alt {{ request()->is('dashboard/admin-unitkerja') ? 'text-blue-700' : 'text-blue-300' }}"></i>
                    </div>
                    <span>Dashboard</span>
                    @if(request()->is('dashboard/admin-unitkerja'))
                        <div class="ml-auto w-2 h-2 bg-blue-500 rounded-full active-menu-indicator"></div>
                    @endif
                </a>
            </li>

            <!-- Karyawan Magang -->
            <li>
                <a href="{{ route('admin-unitkerja.peserta-magang') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ request()->is('admin-unitkerja/peserta-magang*') ? 'bg-white text-blue-800 font-semibold shadow-md' : 'hover:bg-blue-700 hover:text-white hover:shadow-sm' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 
                        {{ request()->is('admin-unitkerja/peserta-magang*') ? 'bg-blue-100' : 'bg-blue-600' }}">
                        <i class="fas fa-user-tie {{ request()->is('admin-unitkerja/peserta-magang*') ? 'text-blue-700' : 'text-blue-300' }}"></i>
                    </div>
                    <span>Karyawan Magang</span>
                    @if(request()->is('admin-unitkerja/peserta-magang*'))
                        <div class="ml-auto w-2 h-2 bg-blue-500 rounded-full active-menu-indicator"></div>
                    @endif
                </a>
            </li>

            <!-- Permohonan Periode -->
            <li>
                <a href="{{ route('admin-unitkerja.permohonan-periode') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($active, 'permohonan-periode') ? 'bg-white text-blue-800 font-semibold shadow-md' : 'hover:bg-blue-700 hover:text-white hover:shadow-sm' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 
                        {{ str_contains($active, 'permohonan-periode') ? 'bg-blue-100' : 'bg-blue-600' }}">
                        <i class="fas fa-calendar-alt {{ str_contains($active, 'permohonan-periode') ? 'text-blue-700' : 'text-blue-300' }}"></i>
                    </div>
                    <span>Permohonan Periode</span>
                    @if(str_contains($active, 'permohonan-periode'))
                        <div class="ml-auto w-2 h-2 bg-blue-500 rounded-full active-menu-indicator"></div>
                    @endif
                </a>
            </li>

            <!-- Karyawan Lulus -->
            <li>
                <a href="{{ route('admin-unitkerja.peserta-lulus.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($active, 'lulus') ? 'bg-white text-blue-800 font-semibold shadow-md' : 'hover:bg-blue-700 hover:text-white hover:shadow-sm' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 
                        {{ str_contains($active, 'lulus') ? 'bg-blue-100' : 'bg-blue-600' }}">
                        <i class="fas fa-graduation-cap {{ str_contains($active, 'lulus') ? 'text-blue-700' : 'text-blue-300' }}"></i>
                    </div>
                    <span>Karyawan Lulus</span>
                    @if(str_contains($active, 'lulus'))
                        <div class="ml-auto w-2 h-2 bg-blue-500 rounded-full active-menu-indicator"></div>
                    @endif
                </a>
            </li>
        </ul>
    </nav>

    <!-- Footer Sidebar -->
    <div class="p-4 border-t border-blue-600 bg-blue-800/50">
        <div class="text-center">
            <p class="text-xs text-blue-300">Admin Unit Kerja BKN</p>
            <p class="text-xs text-blue-400 mt-1">v1.0 • {{ date('Y') }}</p>
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