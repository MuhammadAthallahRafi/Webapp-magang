@extends('layouts.admin-layout')
@section('title', 'Peserta Lulus')

@section('content')
<div class="p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">📜 Daftar Peserta Lulus</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse border text-sm">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Nama</th>
                <th class="border p-2">NIK</th>
                <th class="border p-2">Kampus</th>
                <th class="border p-2">Jurusan</th>
                <th class="border p-2">Periode Ke</th>
                <th class="border p-2">Tanggal Mulai</th>
                <th class="border p-2">Tanggal Selesai</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesertaLulus as $p)
                @php 
                    $periode = $p->periodeMagang->sortByDesc('periode_ke')->first();
                @endphp
                <tr>
                    <td class="border p-2">{{ $p->nama }}</td>
                    <td class="border p-2">{{ $p->nik }}</td>
                    <td class="border p-2">{{ $p->kampus }}</td>
                    <td class="border p-2">{{ $p->jurusan }}</td>
                    <td class="border p-2">{{ $periode->periode_ke ?? '-' }}</td>
                    <td class="border p-2">{{ $periode->tanggal_mulai ?? '-' }}</td>
                    <td class="border p-2">{{ $periode->tanggal_selesai ?? '-' }}</td>
                    <td class="border p-2">
                        <a href="{{ route('admin.peserta-lulus.sertifikat', $p->id) }}"
                           class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                            Cetak Sertifikat
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center p-4">Belum ada peserta lulus.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
