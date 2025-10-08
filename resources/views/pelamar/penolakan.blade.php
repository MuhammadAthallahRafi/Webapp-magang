@extends('layouts.pelamar')

@section('content')
<div class="max-w-xl mx-auto mt-20 text-center">
    <h1 class="text-2xl font-bold text-red-600">Maaf, Belum Bisa Diterima</h1>
    <p class="mt-4 text-gray-700">
        Terima kasih sudah mendaftar. Namun, saat ini kamu belum bisa diterima.
    </p>
    <div class="mt-4 bg-red-50 border border-red-300 p-4 rounded">
        <strong>Alasan:</strong>
        <p class="mt-1 text-gray-600">{{ $alasan }}</p>
    </div>
</div>
@endsection
