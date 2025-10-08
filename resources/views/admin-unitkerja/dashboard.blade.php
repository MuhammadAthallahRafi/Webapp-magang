@extends('layouts.admin-unitkerja-layout')

@section('title', 'Dashboard Admin Unit Kerja')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Dashboard Admin Unit Kerja</h1>
    <p class="text-gray-700">
        Selamat datang, <strong>{{ auth()->user()->name }}</strong>!  
        Gunakan menu di sidebar untuk mengelola Peserta magang.
    </p>
</div>
@endsection
