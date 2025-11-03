@extends('layouts.pelamar') 
{{-- atau ganti ke layouts.admin-layout kalau mau nuansa dashboard admin --}}

@section('title', 'Akun Dinonaktifkan')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-b from-blue-50 to-blue-100 px-4">
    <div class="bg-white/90 backdrop-blur shadow-xl rounded-2xl p-10 max-w-md w-full text-center border border-blue-200 animate-fade-in">
        {{-- Icon --}}
        <div class="flex justify-center mb-4">
            <div class="bg-red-100 text-red-600 rounded-full p-4 shadow-inner">
                <i class="fas fa-user-slash text-3xl"></i>
            </div>
        </div>

        {{-- Title --}}
        <h1 class="text-2xl font-extrabold text-gray-800 mb-3">Akun Anda Dinonaktifkan</h1>

        {{-- Description --}}
        <p class="text-gray-600 leading-relaxed mb-8">
            Maaf, akun Anda saat ini berstatus 
            <span class="font-semibold text-red-500">OFF</span> dan tidak dapat digunakan sementara waktu.
            <br><br>
            Silakan hubungi pihak 
            <span class="font-semibold text-blue-600">Admin Magang BKN</span> untuk informasi lebih lanjut.
        </p>

        {{-- Logout Button --}}
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium shadow transition">
            <i class="fas fa-sign-out-alt"></i> 
            Kembali ke Login
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>

    <footer class="mt-10 text-sm text-gray-500">
        © {{ date('Y') }} <span class="font-semibold text-blue-700">BKN Magang Center</span>. All rights reserved.
    </footer>
</div>

{{-- Animasi --}}
<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 0.6s ease-out;
}
</style>
@endsection
