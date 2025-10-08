@extends('layouts.admin-layout')

@section('title', 'Peserta Magang')

@section('content')
<div class="px-6 py-4">
    <h1 class="text-2xl font-bold mb-6">Daftar Peserta Magang</h1>

    {{-- Search --}}
    <form method="GET" class="mb-4">
        <input name="search" type="text" placeholder="Cari nama..." value="{{ request('search') }}"
               class="border rounded px-4 py-2 w-1/3 text-sm focus:outline-none focus:ring">
        <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded text-sm">Cari</button>
    </form>

{{-- Flash Message --}}
@if (session('success'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 3000)" 
        x-show="show"
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"
    >
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 3000)" 
        x-show="show"
        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"
    >
        {{ session('error') }}
    </div>
@endif
    {{-- Table --}}
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-sm text-left text-gray-800">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-3 py-2">Nama</th>
                    <th class="px-3 py-2">No. Tlf</th>
                    <th class="px-3 py-2">Email</th>
                    <th class="px-3 py-2">Unit kerja</th>
                    <th class="px-3 py-2">Nilai</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesertas as $peserta)
                    <tr class="border-b">
                        <td class="px-3 py-2">{{ $peserta->nama }}</td>
                        <td class="px-3 py-2">{{ $peserta->no_telp }}</td>
                        <td class="px-3 py-2">{{ $peserta->user->email }}</td>
                       <td class="px-3 py-2">
                        <form action="{{ route('admin.peserta-magang.update-divisi', $peserta->id) }}" method="POST">
                            @csrf
                            <select name="divisi" onchange="this.form.submit()" class="text-sm border rounded px-2 py-1 w-full">
                                <option value="">-- Pilih Divisi --</option>
                                <option value="IT" {{ $peserta->divisi == 'IT' ? 'selected' : '' }}>IT</option>
                                <option value="HRD" {{ $peserta->divisi == 'HRD' ? 'selected' : '' }}>HRD</option>
                                <option value="Keuangan" {{ $peserta->divisi == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                            </select>
                        </form>
                    </td>
                        <td class="px-3 py-2"><form action="{{ route('admin.peserta-magang.update-nilai', $peserta->id) }}" method="POST">
                        @csrf
                        <input type="number" name="nilai" value="{{ $peserta->nilai ?? '' }}"
                            class="w-20 text-sm border px-2 py-1 rounded"
                            onchange="this.form.submit()" min="0" max="100">
                        </form>
                    </td>
                        <td class="px-3 py-2"><form action="{{ route('admin.peserta-magang.update-status', $peserta->id) }}" method="POST">
                        @csrf
                        <select name="status" onchange="this.form.submit()" class="text-sm border rounded px-2 py-1 w-full">
                            <option value="aktif" {{ $peserta->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="lulus" {{ $peserta->status == 'lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="mundur" {{ $peserta->status == 'mundur' ? 'selected' : '' }}>Mundur</option>
                        </select>
                    </form>
                    </td>
                        <td class="px-3 py-2 relative" x-data="{ open: false }">
    <button @click="open = !open" class="bg-gray-200 text-sm px-3 py-1 rounded hover:bg-gray-300">
        ⋮ Aksi
    </button>

    <div 
        x-show="open" 
        @click.away="open = false" 
        x-transition 
        class="absolute right-0 mt-1 bg-white border shadow-md rounded z-10 w-48"
        style="display: none;"
    >
        <a href="{{ route('admin.peserta-magang.lihat', $peserta->id) }}" class="block px-4 py-2 hover:bg-gray-100">Detail Peserta</a>
        <a href="{{ route('admin.peserta-magang.absensi', $peserta->id) }}" class="block px-4 py-2 hover:bg-gray-100">Riwayat Absensi</a>
        <a href="{{ route('admin.peserta-magang.periode', $peserta->id) }}" class="block px-4 py-2 hover:bg-gray-100">Riwayat Periode dan Permohonan</a>
    </div>
</td>


                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4">Belum ada Peserta magang.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
