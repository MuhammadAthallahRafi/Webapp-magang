@extends('layouts.admin-layout')

@section('title', 'Daftar Pelamar Magang ditolak')

@section('content')
<div class="px-6 py-4">
    <h1 class="text-2xl font-bold mb-6">Daftar Pelamar Magang ditolak</h1>

    {{-- Search --}}
<div class="mb-4">
    <form method="GET" class="mb-4">
        <input name="search" type="text" placeholder="Cari nama..." value="{{ request('search') }}"
               class="border rounded px-4 py-2 w-1/3 text-sm focus:outline-none focus:ring">
        <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded text-sm">Cari</button>
    </form>
</div>


   {{-- Table --}}
<div class="overflow-x-auto bg-white rounded shadow">
    <table class="w-full text-sm text-left text-gray-800 table-auto">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="px-3 py-2">Nama</th>
                <th class="px-3 py-2">Kampus</th>
                <th class="px-3 py-2">Jurusan</th>
                <th class="px-3 py-2">status</th>
                <th class="px-3 py-2">tanggal mulai</th>
                <th class="px-3 py-2">tanggal selesai</th>
                <th class="px-3 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pelamars as $pelamar)
                <tr class="border-b hover:bg-gray-50">
                    <td>{{ $pelamar->nama ?? '-' }}</td>
                    <td>{{ $pelamar->kampus ?? '-' }}</td>
                    <td>{{ $pelamar->jurusan ?? '-' }}</td>
                    <td>{{ $pelamar->status ?? '-' }}</td>
                    <td>{{ $pelamar->tanggal_mulai ?? '-' }}</td>
                    <td>{{ $pelamar->tanggal_selesai ?? '-' }}</td>

                    <td class="px-3 py-2">
                        <a href="{{ route('admin.pelamarditolak.lihat', $pelamar->id) }}" 
                           class="bg-blue-100 text-blue-800 px-3 py-1 rounded border border-blue-500 hover:bg-blue-200 text-xs font-medium">
                            👁️ Lihat
                        </a>
                    </td>
                </tr>
                <tr class="{{ optional($pelamar->user)->status === 'ditolak' ? 'bg-red-50 text-red-700' : '' }}">

            @empty
                <tr>
                    <td colspan="5" class="px-3 py-3 text-center text-gray-500">Tidak ada data pelamar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

    </div>
</div>
@endsection
