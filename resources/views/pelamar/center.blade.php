@extends('layouts.pelamar')

@section('title', 'Status Pendaftaran')

@section('content')
<div class="max-w-3xl mx-auto bg-white/80 backdrop-blur-sm shadow-xl rounded-3xl p-8 border border-blue-100 relative overflow-hidden">
    {{-- Header --}}
    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 via-indigo-500 to-cyan-400 rounded-t-3xl"></div>

    <h1 class="text-3xl font-extrabold mb-6 text-gray-800 text-center tracking-tight">
        📋 Status Pendaftaran
    </h1>

    {{-- Status Container --}}
    @if ($pelamar->status === 'pending')
        <div class="bg-blue-50 border border-blue-200 p-6 rounded-2xl shadow-inner">
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-blue-100 text-blue-600 flex items-center justify-center rounded-full animate-pulse">
                    ⏳
                </div>
                <h2 class="ml-3 text-xl font-semibold text-blue-700">Sedang Diproses</h2>
            </div>
            <p class="text-blue-700 leading-relaxed">
                Terima kasih sudah mengirimkan formulir lamaran.  
                Tim admin saat ini sedang <strong>memeriksa berkas dan data dirimu</strong>.  
                Mohon tunggu kabar selanjutnya ya!
            </p>
            <a href="{{ route('form-pendaftaran.edit', $pelamar->id) }}"
               class="inline-block mt-5 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-800 font-medium px-5 py-2.5 rounded-xl shadow hover:from-yellow-500 hover:to-yellow-600 transition-all">
               ✏️ Perbarui Data
            </a>
        </div>

    @elseif ($pelamar->status === 'ditolak')
        <div class="bg-red-50 border border-red-200 p-6 rounded-2xl shadow-inner">
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-red-100 text-red-600 flex items-center justify-center rounded-full">
                    ❌
                </div>
                <h2 class="ml-3 text-xl font-semibold text-red-700">Lamaran Ditolak</h2>
            </div>
            <p class="text-gray-700 leading-relaxed">
                Maaf, lamaranmu belum bisa kami terima untuk saat ini.
            </p>
            <p class="text-red-700 mt-2">
                <strong>Alasan:</strong> {{ $pelamar->alasan_penolakan ?? 'Tidak ada alasan diberikan' }}
            </p>
        </div>

    @elseif ($pelamar->status === 'perbaikan')
        <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-2xl shadow-inner">
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-yellow-100 text-yellow-600 flex items-center justify-center rounded-full animate-bounce">
                    ⚠️
                </div>
                <h2 class="ml-3 text-xl font-semibold text-yellow-700">Perlu Perbaikan Data</h2>
            </div>
            <p class="text-gray-700 leading-relaxed">
                Tim kami menemukan beberapa data yang perlu kamu perbarui sebelum proses dilanjutkan.
            </p>
            <p class="text-yellow-700 mt-2">
                <strong>Catatan:</strong> {{ $pelamar->alasan_perbaikan ?? 'Tidak ada alasan diberikan' }}
            </p>
            <a href="{{ route('form-pendaftaran.edit', $pelamar->id) }}"
               class="inline-block mt-5 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-800 font-medium px-5 py-2.5 rounded-xl shadow hover:from-yellow-500 hover:to-yellow-600 transition-all">
               ✏️ Perbarui Data
            </a>
        </div>
    @elseif ($pelamar->status === 'telahdiperbaiki')
        <div class="bg-blue-50 border border-blue-200 p-6 rounded-2xl shadow-inner">
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-blue-100 text-blue-600 flex items-center justify-center rounded-full animate-pulse">
                    ⏳
                </div>
                <h2 class="ml-3 text-xl font-semibold text-blue-700">Sedang Diproses kembali</h2>
            </div>
            <p class="text-blue-700 leading-relaxed">
                Terima kasih sudah mengirimkan formulir lamaran.  
                Tim admin saat ini sedang <strong>memeriksa berkas dan data dirimu kembali</strong>.  
                Mohon tunggu kabar selanjutnya ya!
            </p>
            <p class="text-yellow-700 mt-2">
                <strong>Catatan:</strong> {{ $pelamar->alasan_perbaikan ?? 'Tidak ada alasan diberikan' }}
            </p>
            <a href="{{ route('form-pendaftaran.edit', $pelamar->id) }}"
               class="inline-block mt-5 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-800 font-medium px-5 py-2.5 rounded-xl shadow hover:from-yellow-500 hover:to-yellow-600 transition-all">
               ✏️ Perbarui Data
            </a>
        </div>

    @else
        <div class="bg-gray-50 border border-gray-200 p-6 rounded-2xl shadow-inner text-center text-gray-600">
            <p>📭 Belum ada status pendaftaran saat ini.</p>
        </div>
    @endif
</div>

{{-- Animasi tambahan --}}
<style>
@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
.animate-spin-slow {
    animation: spin-slow 5s linear infinite;
}
</style>
@endsection
