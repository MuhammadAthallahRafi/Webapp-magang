@extends('layouts.admin-layout')

@section('title', 'Daftar Pelamar Magang')

@section('content')
<div class="px-6 py-4">
    <h1 class="text-2xl font-bold mb-6">Daftar Pelamar Magang</h1>

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
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Tanggal Mulai</th>
                    <th class="px-3 py-2">Tanggal Selesai</th>
                    <th class="px-3 py-2 text-center">Aksi</th>
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

                        <td class="px-3 py-2 text-center">
                            {{-- Cek apakah pelamar ini punya permohonan magang kembali --}}
                            @php
                                $permohonan = $pelamar->permohonanPeriode
                                    ->where('jenis_permohonan', 'permohonanmagangkembali')
                                    ->where('status', 'pending')
                                    ->first();
                            @endphp

                            @if($permohonan)
                                {{-- Tombol Approve & Reject --}}
                                <form action="{{ route('admin.periode.approve', $permohonan->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-xs font-medium">Approve</button>
                                </form>

                                <form action="{{ route('admin.periode.reject', $permohonan->id) }}" method="POST" class="inline-block ml-1">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-xs font-medium">Reject</button>
                                </form>
                            @else
                                {{-- Tombol lihat pelamar biasa --}}
                                <a href="{{ route('admin.pelamar.lihat', $pelamar->id) }}" 
                                   class="bg-blue-100 text-blue-800 px-3 py-1 rounded border border-blue-500 hover:bg-blue-200 text-xs font-medium">
                                    👁️ Lihat
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-3 py-3 text-center text-gray-500">Tidak ada data pelamar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
