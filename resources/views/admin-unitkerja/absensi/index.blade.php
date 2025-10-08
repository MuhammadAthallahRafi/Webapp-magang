@extends('layouts.admin-unitkerja-layout')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="px-6 py-4">
    <h1 class="text-2xl font-bold mb-6">Riwayat Absensi - {{ $peserta->nama }}</h1>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full table-auto border-collapse text-sm text-left text-gray-800">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-3 py-2">#</th>
                    <th class="px-3 py-2">Tanggal</th>
                    <th class="px-3 py-2">Jam Masuk</th>
                    <th class="px-3 py-2">Jam Keluar</th>
                    <th class="px-3 py-2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peserta->absensi as $absen)
                    <tr class="border-b">
                        <td class="px-3 py-2">{{ $loop->iteration }}</td>
                        <td class="px-3 py-2">{{ $absen->tanggal }}</td>
                        <td class="px-3 py-2">{{ $absen->jam_masuk ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $absen->jam_keluar ?? '-' }}</td>
                        <td class="px-3 py-2">
                            <form action="{{ route('admin-unitkerja.absensi.update-keterangan', $absen->id) }}" method="POST">
                                @csrf
                                <select name="keterangan" onchange="this.form.submit()" class="text-sm border rounded px-2 py-1">
                                    <option value="hadir"  {{ $absen->keterangan == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="sakit"  {{ $absen->keterangan == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                    <option value="dispen" {{ $absen->keterangan == 'dispen' ? 'selected' : '' }}>Dispen</option>
                                    <option value="alfa"   {{ $absen->keterangan == 'alfa' ? 'selected' : '' }}>Alfa</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Belum ada data absensi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
