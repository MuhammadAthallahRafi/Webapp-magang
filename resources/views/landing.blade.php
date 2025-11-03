{{-- resources/views/landing.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Beranda - Pendaftaran Magang</title>
@vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Tailwind --}}
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- Navbar --}}
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-600">MagangApp</h1>
        <div class="space-x-4">
            @auth
                <span class="text-gray-700">Halo, {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Login</a>
                <a href="{{ route('register') }}" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">Register</a>
            @endauth
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="text-center mt-24">
        <h2 class="text-4xl font-semibold mb-4">Selamat datang di Sistem Pendaftaran Magang</h2>
        <p class="mb-8 text-gray-600">
            Silakan login atau daftar untuk melanjutkan proses pendaftaran.
        </p>
        @guest
    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
        Daftar Sekarang
    </a>
        @endguest

        @auth
           @php $user = auth()->user(); @endphp

        @if ($user->role === 'pelamar' && !$user->pelamar)
            {{-- Kalau role pelamar tapi belum isi form --}}
            <a href="{{ route('form.pendaftaran') }}" 
            class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 transition">
                Lanjut Mendaftar
            </a>

        @elseif ($user->role === 'pelamar' && $user->pelamar->status === 'perbaikan')
            {{-- Kalau pelamar statusnya perbaikan --}}
            <a href="{{ route('pelamar.center', $user->pelamar->id) }}" 
            class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 transition">
                Perbaiki Formulir
            </a>

        @else
            {{-- Kalau sudah lengkap, masuk ke dashboard sesuai role --}}
            <a href="/redirect-role" 
            class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 transition">
                Masuk ke Dashboard
            </a>
        @endif

        @endauth
    </section>


    
</body>
</html>
