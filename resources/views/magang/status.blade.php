@extends('layouts.pelamar')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">
        📋 Status Permohonan Magang Kembali
    </h1>
@if (session('success'))
    <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-3">
        {{ session('success') }}
    </div>
@endif
    @if ($permohonan)
        <div class="text-left space-y-4">
            <p class="text-gray-700">
                Hai, <span class="font-semibold">{{ $peserta->nama }}</span> 👋
            </p>
            <p class="text-gray-600">
                Berikut adalah detail permohonan magang kembali yang telah kamu ajukan.
            </p>

            <div class="border-t pt-4 text-sm">
                <div class="flex justify-between py-1">
                    <span class="font-medium text-gray-700">Tanggal Pengajuan:</span>
                    <span>{{ \Carbon\Carbon::parse($permohonan->tanggal_pengajuan)->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="font-medium text-gray-700">Tanggal Mulai:</span>
                    <span>{{ \Carbon\Carbon::parse($permohonan->tanggal_mulai)->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="font-medium text-gray-700">Tanggal Selesai:</span>
                    <span>{{ \Carbon\Carbon::parse($permohonan->tanggal_selesai)->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="font-medium text-gray-700">Status:</span>
                    <span class="
                        px-3 py-1 rounded-full text-xs font-semibold
                        @if ($permohonan->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif ($permohonan->status == 'disetujui') bg-green-100 text-green-800
                        @elseif ($permohonan->status == 'ditolak') bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($permohonan->status) }}
                    </span>
                </div>
            </div>

            @if ($permohonan->status == 'pending')
                <p class="mt-4 text-yellow-700 bg-yellow-50 border border-yellow-200 p-3 rounded-md text-sm">
                    ⏳ Permohonan kamu sedang menunggu konfirmasi dari admin. Mohon bersabar ya!
                </p>
            @elseif ($permohonan->status == 'disetujui')
                <p class="mt-4 text-green-700 bg-green-50 border border-green-200 p-3 rounded-md text-sm">
                    ✅ Selamat! Permohonan magang kamu telah <strong>disetujui</strong>. Silakan tunggu jadwal resmi dari admin.
                </p>
            @elseif ($permohonan->status == 'ditolak')
                <p class="mt-4 text-red-700 bg-red-50 border border-red-200 p-3 rounded-md text-sm">
                    ❌ Maaf, permohonan kamu <strong>ditolak</strong>. Kamu bisa menghubungi admin untuk info lebih lanjut.
                </p>
            @endif

            <div class="mt-6 text-center">
                <a href="/" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Kembali ke Beranda
    </a>
            </div>
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-600">Belum ada permohonan magang kembali yang diajukan.</p>
            <a href="{{ route('dashboard.pelamar') }}"
               class="mt-4 inline-block px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm">
                ← Kembali ke Dashboard
            </a>
        </div>
    @endif
</div>
@endsection
