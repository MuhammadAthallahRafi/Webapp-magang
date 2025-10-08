@extends('layouts.magang-layout')

@section('title', 'Riwayat Absensi')
@section('page-title', 'Riwayat Absensi')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Riwayat Absensi</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Tanggal</th>
                    <th class="border px-4 py-2">Jam Masuk</th>
                    <th class="border px-4 py-2">Jam Pulang</th>
                    <th class="border px-4 py-2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayat as $absen)
                    <tr>
                        <td class="border px-4 py-2">{{ $absen->tanggal }}</td>
                        <td class="border px-4 py-2">{{ $absen->jam_masuk ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $absen->jam_keluar ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $absen->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
