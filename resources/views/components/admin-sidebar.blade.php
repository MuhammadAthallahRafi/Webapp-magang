@php
    $active = request()->path();
    $user = auth()->user();
@endphp

<aside class="w-64 bg-gradient-to-b from-blue-900 via-blue-800 to-blue-700 text-white shadow-xl min-h-screen flex flex-col">
    <!-- Header Sidebar -->
    <div class="p-6 border-b border-blue-700">
        <div class="flex flex-col items-center justify-center">
            <!-- Logo BKN - dengan fallback jika gambar tidak ada -->
            <div class="mb-4">
                @if(file_exists(public_path('images/logo.png')))
                    <div class="bg-white w-40 h-24 rounded-lg flex items-center justify-center shadow-lg p-2">
                        <img src="{{ asset('images/logo.png') }}" 
                             alt="Logo BKN" 
                             class="h-full w-auto object-contain"
                             onerror="this.style.display='none'; this.parentNode.innerHTML='<div class=\'text-blue-900 text-center\'><i class=\'fas fa-landmark text-3xl\'></i><p class=\'text-xs mt-1\'>Logo BKN</p></div>'">
                    </div>
                @elseif(file_exists(public_path('images/logo-bkn.png')))
                    <div class="bg-white w-40 h-24 rounded-lg flex items-center justify-center shadow-lg p-2">
                        <img src="{{ asset('images/logo-bkn.png') }}" 
                             alt="Logo BKN" 
                             class="h-full w-auto object-contain"
                             onerror="this.style.display='none'; this.parentNode.innerHTML='<div class=\'text-blue-900 text-center\'><i class=\'fas fa-landmark text-3xl\'></i><p class=\'text-xs mt-1\'>Logo BKN</p></div>'">
                    </div>
                @else
                    <!-- Fallback jika logo tidak ditemukan -->
                    <div class="bg-white w-40 h-24 rounded-lg flex flex-col items-center justify-center shadow-lg p-2">
                        <i class="fas fa-landmark text-blue-900 text-3xl mb-2"></i>
                        <p class="text-blue-900 text-xs font-semibold">BKN</p>
                        <p class="text-blue-700 text-xs">Kantor Pusat</p>
                    </div>
                @endif
            </div>
            
            <!-- Informasi Instansi -->
            <div class="text-center">
                <h2 class="font-bold text-lg">Kantor Pusat</h2>
                <h3 class="font-semibold text-sm text-blue-200">Kepegawaian Negara</h3>
                <p class="text-xs text-blue-300 mt-1">Panel Administrator</p>
            </div>
            
            <!-- Informasi Pengguna -->
            @if($user)
                <div class="mt-6 pt-4 border-t border-blue-700 w-full text-center">
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center mx-auto mb-2">
                        <span class="font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <p class="text-sm font-medium truncate">{{ $user->name }}</p>
                    <p class="text-xs text-blue-300 capitalize">{{ $user->role }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Menu Navigasi -->
    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="space-y-1">
            <!-- Dashboard -->
            <li>
                <a href="/dashboard/admin"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ $active == 'dashboard/admin' ? 'bg-white text-blue-900 font-semibold shadow-md' : 'hover:bg-blue-600 hover:text-white hover:shadow-sm' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 
                        {{ $active == 'dashboard/admin' ? 'bg-blue-100' : 'bg-blue-700' }}">
                        <i class="fas fa-tachometer-alt {{ $active == 'dashboard/admin' ? 'text-blue-700' : 'text-blue-300' }}"></i>
                    </div>
                    <span>Dashboard</span>
                    @if($active == 'dashboard/admin')
                        <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full active-menu-indicator"></div>
                    @endif
                </a>
            </li>

            <!-- Akun User -->
            <li>
                <a href="{{ route('admin.akun-user.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($active, 'akun-user') ? 'bg-white text-blue-900 font-semibold shadow-md' : 'hover:bg-blue-600 hover:text-white hover:shadow-sm' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 
                        {{ str_contains($active, 'akun-user') ? 'bg-blue-100' : 'bg-blue-700' }}">
                        <i class="fas fa-users {{ str_contains($active, 'akun-user') ? 'text-blue-700' : 'text-blue-300' }}"></i>
                    </div>
                    <span>Akun Pengguna</span>
                    @if(str_contains($active, 'akun-user'))
                        <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full active-menu-indicator"></div>
                    @endif
                </a>
            </li>

            <!-- Pelamar Magang -->
            <li>
                <a href="/admin/pelamar"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($active, 'pelamar') && !str_contains($active, 'ditolak') ? 'bg-white text-blue-900 font-semibold shadow-md' : 'hover:bg-blue-600 hover:text-white hover:shadow-sm' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 
                        {{ str_contains($active, 'pelamar') && !str_contains($active, 'ditolak') ? 'bg-blue-100' : 'bg-blue-700' }}">
                        <i class="fas fa-user-graduate {{ str_contains($active, 'pelamar') && !str_contains($active, 'ditolak') ? 'text-blue-700' : 'text-blue-300' }}"></i>
                    </div>
                    <span>Pelamar Magang</span>
                    @if(str_contains($active, 'pelamar') && !str_contains($active, 'ditolak'))
                        <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full active-menu-indicator"></div>
                    @endif
                </a>
            </li>

            <!-- Pelamar Ditolak -->
            <li>
                <a href="/admin/pelamarditolak"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($active, 'pelamarditolak') ? 'bg-white text-blue-900 font-semibold shadow-md' : 'hover:bg-blue-600 hover:text-white hover:shadow-sm' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 
                        {{ str_contains($active, 'pelamarditolak') ? 'bg-blue-100' : 'bg-blue-700' }}">
                        <i class="fas fa-user-times {{ str_contains($active, 'pelamarditolak') ? 'text-blue-700' : 'text-blue-300' }}"></i>
                    </div>
                    <span>Pelamar Ditolak</span>
                    @if(str_contains($active, 'pelamarditolak'))
                        <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full active-menu-indicator"></div>
                    @endif
                </a>
            </li>

            <!-- Peserta Magang -->
            <li>
                <a href="/admin/peserta-magang"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($active, 'magang') && !str_contains($active, 'lulus') ? 'bg-white text-blue-900 font-semibold shadow-md' : 'hover:bg-blue-600 hover:text-white hover:shadow-sm' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 
                        {{ str_contains($active, 'magang') && !str_contains($active, 'lulus') ? 'bg-blue-100' : 'bg-blue-700' }}">
                        <i class="fas fa-user-tie {{ str_contains($active, 'magang') && !str_contains($active, 'lulus') ? 'text-blue-700' : 'text-blue-300' }}"></i>
                    </div>
                    <span>Peserta Magang</span>
                    @if(str_contains($active, 'magang') && !str_contains($active, 'lulus'))
                        <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full active-menu-indicator"></div>
                    @endif
                </a>
            </li>

            <!-- Permohonan Periode -->
            <li>
                <a href="/admin/permohonan-periode"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($active, 'permohonan-periode') ? 'bg-white text-blue-900 font-semibold shadow-md' : 'hover:bg-blue-600 hover:text-white hover:shadow-sm' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 
                        {{ str_contains($active, 'permohonan-periode') ? 'bg-blue-100' : 'bg-blue-700' }}">
                        <i class="fas fa-calendar-alt {{ str_contains($active, 'permohonan-periode') ? 'text-blue-700' : 'text-blue-300' }}"></i>
                    </div>
                    <span>Permohonan Periode</span>
                    @if(str_contains($active, 'permohonan-periode'))
                        <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full active-menu-indicator"></div>
                    @endif
                </a>
            </li>

            <!-- Karyawan Lulus -->
            <li>
                <a href="{{ route('admin.peserta-lulus.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 
                   {{ str_contains($active, 'lulus') ? 'bg-white text-blue-900 font-semibold shadow-md' : 'hover:bg-blue-600 hover:text-white hover:shadow-sm' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 
                        {{ str_contains($active, 'lulus') ? 'bg-blue-100' : 'bg-blue-700' }}">
                        <i class="fas fa-graduation-cap {{ str_contains($active, 'lulus') ? 'text-blue-700' : 'text-blue-300' }}"></i>
                    </div>
                    <span>Karyawan Lulus</span>
                    @if(str_contains($active, 'lulus'))
                        <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full active-menu-indicator"></div>
                    @endif
                </a>
            </li>
        </ul>
    </nav>

    <!-- Footer Sidebar -->
    <div class="p-4 border-t border-blue-700 bg-blue-900/50">
        <div class="text-center">
            <p class="text-xs text-blue-300">Sistem Admin Magang BKN</p>
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
    
    /* Smooth transition untuk logo */
    .logo-container {
        transition: all 0.3s ease;
    }
    
    .logo-container:hover {
        transform: scale(1.05);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah logo berhasil dimuat
        const logoImages = document.querySelectorAll('img[src*="logo"]');
        logoImages.forEach(img => {
            img.addEventListener('error', function() {
                console.log('Logo gagal dimuat:', this.src);
                // Ganti dengan fallback
                this.style.display = 'none';
                const parent = this.parentNode;
                parent.innerHTML = `
                    <div class="text-blue-900 text-center w-full h-full flex flex-col items-center justify-center">
                        <i class="fas fa-landmark text-3xl mb-2"></i>
                        <p class="text-xs font-semibold">BKN</p>
                        <p class="text-xs">Kepegawaian</p>
                    </div>
                `;
            });
            
            img.addEventListener('load', function() {
                console.log('Logo berhasil dimuat:', this.src);
            });
        });
        
        // Debug: Tampilkan path yang dicoba
        console.log('Path logo yang dicoba:');
        console.log('1. {{ asset("images/logo.png") }}');
        console.log('2. {{ asset("images/logo-bkn.png") }}');
        
        // Smooth hover effects untuk menu
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
                    z-index: 1;
                `;
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    if (ripple.parentNode === this) {
                        this.removeChild(ripple);
                    }
                }, 600);
            });
        });
        
        // Tambahkan style untuk ripple animation
        if (!document.querySelector('#ripple-style')) {
            const style = document.createElement('style');
            style.id = 'ripple-style';
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    });
</script>