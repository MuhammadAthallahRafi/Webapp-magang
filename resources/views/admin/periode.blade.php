@extends('layouts.admin-layout')

@section('title', 'Riwayat Periode & Permohonan Peserta')

@section('content')
<div class="px-6 py-4">
    <h1 class="text-2xl font-bold mb-6">Riwayat Periode & Permohonan Magang</h1>

    {{-- Info Peserta --}}
    <div class="bg-white shadow rounded-lg p-4 mb-6">
        <h2 class="text-lg font-semibold mb-2">{{ $peserta->nama ?? $peserta->user->name }}</h2>
        <p class="text-sm text-gray-600">{{ $peserta->kampus ?? '-' }} — {{ $peserta->jurusan ?? '-' }}</p>
        <p class="text-sm text-gray-500 mt-1">Status: <span class="font-semibold capitalize">{{ $peserta->status }}</span></p>
    </div>

    {{-- Riwayat Periode --}}
    <div class="bg-white shadow rounded-lg p-4 mb-6">
        <h3 class="font-semibold text-lg mb-3 text-blue-600">📅 Riwayat Periode Magang</h3>

        @if($riwayatPeriode->isEmpty())
            <p class="text-gray-500 text-sm">Belum ada data periode magang.</p>
        @else
            <table class="w-full text-sm border">
                <thead class="bg-blue-50 text-gray-700">
                    <tr>
                        <th class="px-3 py-2 border">Periode Ke</th>
                        <th class="px-3 py-2 border">Tanggal Mulai</th>
                        <th class="px-3 py-2 border">Tanggal Selesai</th>
                        <th class="px-3 py-2 border">Tanggal Selesai Lama</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayatPeriode as $p)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2 text-center">{{ $p->periode_ke }}</td>
                            <td class="border px-3 py-2">{{ $p->tanggal_mulai }}</td>
                            <td class="border px-3 py-2">{{ $p->tanggal_selesai }}</td>
                            <td class="border px-3 py-2">{{ $p->tanggal_selesai_lama ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Riwayat Permohonan --}}
    <div class="bg-white shadow rounded-lg p-4">
        <h3 class="font-semibold text-lg mb-3 text-blue-600">📝 Riwayat Permohonan Periode</h3>

        @if($permohonan->isEmpty())
            <p class="text-gray-500 text-sm">Belum ada data permohonan periode.</p>
        @else
            <table class="w-full text-sm border">
                <thead class="bg-blue-50 text-gray-700">
                    <tr>
                        <th class="px-3 py-2 border">Jenis Permohonan</th>
                        <th class="px-3 py-2 border">Tanggal Mulai</th>
                        <th class="px-3 py-2 border">Tanggal Selesai</th>
                        <th class="px-3 py-2 border">Status</th>
                        <th class="px-3 py-2 border">Tanggal Pengajuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permohonan as $m)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2 capitalize">
                                @switch($m->jenis_permohonan)
                                    @case('tambah') Tambah Periode @break
                                    @case('percepat') Percepatan @break
                                    @case('permohonanmagangkembali') Magang Kembali @break
                                    @default {{ $m->jenis_permohonan }}
                                @endswitch
                            </td>
                            <td class="border px-3 py-2">{{ $m->tanggal_mulai ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $m->tanggal_selesai ?? '-' }}</td>
                            <td class="border px-3 py-2 capitalize">{{ $m->status ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $m->tanggal_pengajuan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Tombol kembali --}}
    <div class="mt-6">
        <a href="{{ route('admin.peserta-magang') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded">
           ← Kembali
        </a>
    </div>
</div>
@endsection
