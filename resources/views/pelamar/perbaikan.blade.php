@extends('layouts.pelamar')

@section('content')
<div class="max-w-xl mx-auto mt-20 text-center">
    <h1 class="text-2xl font-bold text-red-600">⚠️ Formulir Perlu Perbaikan</h1>
    <p class="mt-4 text-gray-700">
        Admin memberikan catatan perbaikan untuk formulir Anda.  
        Silakan periksa catatan di bawah ini, lalu lakukan perubahan pada formulir.
    </p>
    <!-- Catatan Admin -->
<div class="mt-4 bg-red-50 border border-red-300 p-4 rounded">
    <strong>Catatan Admin:</strong>
    <p class="mt-1 text-gray-600">{{ $alasan }}</p>
</div>

<!-- Tombol Edit -->
<div class="text-right mt-6">
    <a href="{{ route('form-pendaftaran.edit', auth()->user()->pelamar->id) }}"
       class="inline-block bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">
        ✏️ Perbaiki Formulir
    </a>
</div>
</div>
@endsection
