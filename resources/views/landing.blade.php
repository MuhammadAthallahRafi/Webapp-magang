{{-- resources/views/landing.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Pendaftaran Magang - Kantor Pusat Kepegawaian Negara">
    <title>Sistem Pendaftaran Magang - Kantor Pusat Kepegawaian Negara</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts untuk tampilan formal -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Source Sans Pro', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .font-inter {
            font-family: 'Inter', sans-serif;
        }
        .header-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }
        .btn-primary {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
        }
        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
        }
        .nav-shadow {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white nav-shadow sticky top-0 z-50 border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-3">
                <!-- Logo dan Identitas Instansi -->
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-900 w-12 h-12 rounded flex items-center justify-center">
                        <i class="fas fa-landmark text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">Kantor Pusat Kepegawaian Negara</h1>
                        <p class="text-xs text-gray-600 -mt-1">Sistem Pendaftaran Magang</p>
                    </div>
                </div>

                <!-- Menu -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="hidden md:flex items-center space-x-3">
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-600 capitalize">
                                    @if(auth()->user()->role === 'pelamar')
                                        Calon Peserta Magang
                                    @elseif(auth()->user()->role === 'admin')
                                        Administrator
                                    @elseif(auth()->user()->role === 'unitkerja')
                                        Admin Unit Kerja
                                    @else
                                        {{ auth()->user()->role }}
                                    @endif
                                </p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-blue-800 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm transition-colors flex items-center space-x-2">
                                    <i class="fas fa-sign-out-alt text-xs"></i>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                        <!-- Mobile Menu Button -->
                        <div class="md:hidden">
                            <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-700">
                                <i class="fas fa-bars text-lg"></i>
                            </button>
                        </div>
                    @else
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('login') }}" 
                               class="text-blue-700 hover:text-blue-800 font-medium px-4 py-2 hover:bg-blue-50 rounded transition-colors text-sm">
                                <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                            </a>
                            <a href="{{ route('register') }}" 
                               class="btn-primary text-white px-5 py-2.5 rounded font-medium transition-all duration-300 shadow-sm hover:shadow flex items-center text-sm">
                                <i class="fas fa-user-plus mr-2"></i>Daftar
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            @auth
                <div id="mobile-menu" class="md:hidden hidden bg-white rounded-lg shadow-lg mt-2 py-3 px-4 border border-gray-200">
                    <div class="flex items-center space-x-3 mb-4 pb-4 border-b border-gray-200">
                        <div class="w-12 h-12 rounded-full bg-blue-800 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-gray-600 capitalize">
                                @if(auth()->user()->role === 'pelamar')
                                    Calon Peserta Magang
                                @elseif(auth()->user()->role === 'admin')
                                    Administrator
                                @elseif(auth()->user()->role === 'unitkerja')
                                    Admin Unit Kerja
                                @else
                                    {{ auth()->user()->role }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded transition-colors flex items-center justify-center space-x-2 text-sm">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Keluar dari Sistem</span>
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="header-gradient py-12 md:py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto text-center text-white">
                    <!-- Logo Instansi -->
                    <div class="mb-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-sm rounded-full mb-4">
                            <i class="fas fa-landmark text-white text-3xl"></i>
                        </div>
                        <h2 class="text-sm font-semibold uppercase tracking-widest text-blue-200 mb-2">
                            Kantor Pusat Kepegawaian Negara
                        </h2>
                    </div>
                    
                    <!-- Judul Utama -->
                    <h1 class="text-3xl md:text-5xl font-bold mb-6 leading-tight">
                        Program Magang<br>
                        <span class="text-blue-100">Kantor Pusat Kepegawaian Negara</span>
                    </h1>
                    
                    <!-- Deskripsi -->
                    <p class="text-xl text-blue-100 mb-10 max-w-3xl mx-auto leading-relaxed">
                        Wadah pengembangan kompetensi dan pengalaman kerja bagi calon pegawai negeri 
                        melalui program magang yang terstruktur dan bermakna.
                    </p>
                    
                    <!-- CTA Section -->
                    <div class="mb-16">
                        @guest
                            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                <a href="{{ route('register') }}" 
                                   class="group bg-white hover:bg-blue-50 text-blue-900 px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 inline-flex items-center">
                                    <i class="fas fa-file-alt mr-3"></i>
                                    Daftar Sekarang
                                    <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform"></i>
                                </a>
                                
                                <a href="{{ route('login') }}" 
                                   class="bg-transparent border-2 border-white text-white hover:bg-white/10 px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 inline-flex items-center">
                                    <i class="fas fa-sign-in-alt mr-3"></i>
                                    Masuk ke Sistem
                                </a>
                            </div>
                            <p class="text-blue-200 text-sm mt-4">
                                <i class="fas fa-info-circle mr-1"></i>
                                Pendaftaran dibuka untuk mahasiswa S1/D4 semua jurusan
                            </p>
                        @endguest

                        @auth
                            @php $user = auth()->user(); @endphp

                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 max-w-2xl mx-auto">
                                @if ($user->role === 'pelamar' && !$user->pelamar)
                                    <!-- Belum isi formulir -->
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-file-alt text-yellow-600 text-2xl"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-white mb-2">Lengkapi Formulir Pendaftaran</h3>
                                        <p class="text-blue-100 mb-6">Anda belum mengisi formulir pendaftaran magang</p>
                                        <a href="{{ route('form.pendaftaran') }}" 
                                           class="inline-flex items-center justify-center bg-white text-blue-900 hover:bg-blue-50 px-6 py-3 rounded-lg font-semibold transition-colors">
                                            <i class="fas fa-edit mr-2"></i>
                                            Isi Formulir Sekarang
                                        </a>
                                    </div>

                                @elseif ($user->role === 'pelamar' && $user->pelamar)
                                    <!-- Status berdasarkan kondisi -->
                                    @php
                                        $statusConfig = [
                                            'perbaikan' => [
                                                'color' => 'bg-yellow-100 text-yellow-800',
                                                'icon' => 'fas fa-edit',
                                                'title' => 'Perbaikan Formulir Diperlukan',
                                                'desc' => 'Formulir Anda memerlukan perbaikan. Silakan periksa catatan dari admin.',
                                                'btn' => 'Perbaiki Formulir',
                                                'route' => 'pelamar.center'
                                            ],
                                            'pending' => [
                                                'color' => 'bg-blue-100 text-blue-800',
                                                'icon' => 'fas fa-clock',
                                                'title' => 'Sedang Ditinjau',
                                                'desc' => 'Formulir Anda sedang dalam proses peninjauan oleh admin.',
                                                'btn' => 'Lihat Status',
                                                'route' => 'pelamar.center'
                                            ],
                                            'telahdiperbaiki' => [
                                                'color' => 'bg-purple-100 text-purple-800',
                                                'icon' => 'fas fa-check-circle',
                                                'title' => 'Formulir Telah Diperbaiki',
                                                'desc' => 'Formulir Anda sudah diperbaiki dan menunggu peninjauan ulang.',
                                                'btn' => 'Lihat Detail',
                                                'route' => 'pelamar.center'
                                            ],
                                            'ditolak' => [
                                                'color' => 'bg-red-100 text-red-800',
                                                'icon' => 'fas fa-times-circle',
                                                'title' => 'Pendaftaran Ditolak',
                                                'desc' => 'Maaf, pendaftaran Anda ditolak. Silakan cek detail penolakan.',
                                                'btn' => 'Lihat Alasan',
                                                'route' => 'pelamar.center'
                                            ],
                                            'diterima' => [
                                                'color' => 'bg-green-100 text-green-800',
                                                'icon' => 'fas fa-check-circle',
                                                'title' => 'Selamat! Diterima',
                                                'desc' => 'Pendaftaran Anda diterima. Silakan lanjutkan ke dashboard.',
                                                'btn' => 'Ke Dashboard',
                                                'route' => '/redirect-role'
                                            ],
                                            'default' => [
                                                'color' => 'bg-green-100 text-green-800',
                                                'icon' => 'fas fa-tachometer-alt',
                                                'title' => 'Akses Dashboard',
                                                'desc' => 'Akses dashboard untuk melihat informasi lengkap Anda.',
                                                'btn' => 'Masuk Dashboard',
                                                'route' => '/redirect-role'
                                            ]
                                        ];
                                        
                                        $status = $user->pelamar->status ?? '';
                                        $config = $statusConfig[$status] ?? $statusConfig['default'];
                                    @endphp

                                    <div class="text-center">
                                        <div class="w-16 h-16 {{ $config['color'] }} rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="{{ $config['icon'] }} text-xl"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-white mb-2">{{ $config['title'] }}</h3>
                                        <p class="text-blue-100 mb-6">{{ $config['desc'] }}</p>
                                        <a href="{{ route($config['route'], isset($user->pelamar->id) ? $user->pelamar->id : '') }}" 
                                           class="inline-flex items-center justify-center bg-white text-blue-900 hover:bg-blue-50 px-6 py-3 rounded-lg font-semibold transition-colors">
                                            <i class="{{ $config['icon'] }} mr-2"></i>
                                            {{ $config['btn'] }}
                                        </a>
                                    </div>

                                @else
                                    <!-- Untuk role admin/unitkerja -->
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-user-shield text-blue-600 text-2xl"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-white mb-2">Panel {{ ucfirst($user->role) }}</h3>
                                        <p class="text-blue-100 mb-6">Akses sistem pengelolaan sesuai peran Anda</p>
                                        <a href="/redirect-role" 
                                           class="inline-flex items-center justify-center bg-white text-blue-900 hover:bg-blue-50 px-6 py-3 rounded-lg font-semibold transition-colors">
                                            <i class="fas fa-tachometer-alt mr-2"></i>
                                            Masuk ke Dashboard
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <!-- Info Section -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Informasi Program Magang</h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Program magang yang diselenggarakan oleh Kantor Pusat Kepegawaian Negara 
                        bertujuan untuk membangun talenta bangsa yang kompeten di bidang kepegawaian.
                    </p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="stat-card rounded-xl p-8 hover:shadow-lg transition-shadow duration-300">
                        <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Durasi Program</h3>
                        <p class="text-gray-600">Program magang berlangsung selama 3-6 bulan dengan jadwal yang terstruktur.</p>
                    </div>
                    
                    <div class="stat-card rounded-xl p-8 hover:shadow-lg transition-shadow duration-300">
                        <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-user-graduate text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Persyaratan</h3>
                        <p class="text-gray-600">Mahasiswa aktif S1/D4 dari perguruan tinggi terakreditasi minimal B.</p>
                    </div>
                    
                    <div class="stat-card rounded-xl p-8 hover:shadow-lg transition-shadow duration-300">
                        <div class="w-14 h-14 bg-purple-100 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-award text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Sertifikasi</h3>
                        <p class="text-gray-600">Peserta yang menyelesaikan program akan mendapatkan sertifikat resmi.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 text-center">
                        <div class="text-3xl font-bold text-blue-700 mb-2">1.000+</div>
                        <div class="text-gray-600 text-sm">Alumni Magang</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 text-center">
                        <div class="text-3xl font-bold text-blue-700 mb-2">50+</div>
                        <div class="text-gray-600 text-sm">Perguruan Tinggi Mitra</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 text-center">
                        <div class="text-3xl font-bold text-blue-700 mb-2">95%</div>
                        <div class="text-gray-600 text-sm">Tingkat Kepuasan</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 text-center">
                        <div class="text-3xl font-bold text-blue-700 mb-2">80%</div>
                        <div class="text-gray-600 text-sm">Rekrutmen Lanjutan</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Info -->
        <section class="py-12 bg-blue-900 text-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h3 class="text-xl font-semibold mb-4">Butuh Bantuan?</h3>
                <p class="text-blue-200 mb-6 max-w-2xl mx-auto">
                    Hubungi admin sistem untuk pertanyaan seputar pendaftaran magang
                </p>
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-8">
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-blue-300 mr-3"></i>
                        <span>magang@kepegawaian.go.id</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-phone text-blue-300 mr-3"></i>
                        <span>(021) 1234-5678</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock text-blue-300 mr-3"></i>
                        <span>Selasa - Jumat, 08:00 - 16:00 WIB</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0 text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start space-x-2 mb-4">
                        <div class="bg-white w-8 h-8 rounded flex items-center justify-center">
                            <i class="fas fa-landmark text-blue-900"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold">Kantor Pusat Kepegawaian Negara</h2>
                            <p class="text-gray-400 text-xs">Republik Indonesia</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Jalan Mayjend Sutoyo No. 12, Cililitan, Kramat Jati, Jakarta Timur 13640<br>
                        Telp: (021) 1234-5678 | Fax: (021) 1234-5679
                    </p>
                </div>
                
                <div class="text-center md:text-right">
                    <p class="text-gray-400 text-sm mb-2">&copy; {{ date('Y') }} Kantor Pusat Kepegawaian Negara</p>
                    <p class="text-gray-500 text-xs">Sistem Pendaftaran Magang v1.0</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Menu Toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    mobileMenu.classList.toggle('hidden');
                });
                
                // Close menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            }
            
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        e.preventDefault();
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>