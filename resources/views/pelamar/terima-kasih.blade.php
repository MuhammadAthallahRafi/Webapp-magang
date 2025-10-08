@extends('layouts.pelamar')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow mt-10 text-center">
    <h2 class="text-2xl font-semibold mb-4 text-green-600">Terima kasih!</h2>
    <p class="text-gray-700">Pendaftaran magang kamu telah berhasil dikirim.</p>
    <p class="mt-2 text-sm text-gray-500">Kami akan segera memprosesnya. Semoga beruntung!</p>
    <br>

    @if(auth()->user()->pelamar)
        <a href="{{ route('form-pendaftaran.edit', auth()->user()->pelamar->id) }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
           Edit Formulir
        </a>
    @else
        <a href="{{ route('form-pendaftaran.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
           Isi Formulir
        </a>
    @endif
</div>
@endsection

@if (session('info'))
    <div class="bg-blue-100 text-blue-800 p-3 rounded mb-4">
        {{ session('info') }}
    </div>
@endif
