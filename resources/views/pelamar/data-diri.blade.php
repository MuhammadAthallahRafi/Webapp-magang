@extends('layouts.pelamar')

@section('title', 'Data Diri')
@section('page-title', 'Data Diri')

@section('content')
<div class="max-w-4xl mx-auto bg-white/80 backdrop-blur-sm shadow-xl rounded-3xl p-8 border border-blue-100">
    <div class="mb-6 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">📋 Data Diri Pelamar</h1>
        <p class="text-gray-500 text-sm">Berikut adalah informasi yang telah kamu kirimkan pada saat pendaftaran.</p>
    </div>

    <div class="grid grid-cols-2 gap-x-8 gap-y-4 text-gray-800">
        <div>
            <strong>Nama Lengkap</strong>
            <p class="text-gray-700">{{ $pelamar->nama }}</p>
        </div>

        <div>
            <strong>Kelamin</strong>
            <p class="text-gray-700">{{ $pelamar->kelamin }}</p>
        </div>

        <div>
            <strong>NIK</strong>
            <p class="text-gray-700">{{ $pelamar->nik ?? '-' }}</p>
        </div>

        <div>
            <strong>Asal Kampus / Sekolah</strong>
            <p class="text-gray-700">{{ $pelamar->kampus }}</p>
        </div>
        <div>
            <strong>Jurusan</strong>
            <p class="text-gray-700">{{ $pelamar->jurusan }}</p>
        </div>

        <div>
            <strong>No. Telepon</strong>
            <p class="text-gray-700">{{ $pelamar->no_telp }}</p>
        </div>
        <div>
            <strong>Email</strong>
            <p class="text-gray-700">{{ $pelamar->email }}</p>
        </div>

        <div>
            <strong>Alamat</strong>
            <p class="text-gray-700">{{ $pelamar->alamat }}</p>
        </div>

        <div>
            <strong>Tanggal Mulai</strong>
            <p class="text-gray-700">{{ $pelamar->tanggal_mulai }}</p>
        </div>

        <div>
            <strong>Tanggal selesai</strong>
            <p class="text-gray-700">{{ $pelamar->tanggal_selesai }}</p>
        </div>

        <div>
            <strong>Tanggal Melamar</strong>
            <p class="text-gray-700">{{ $pelamar->created_at->format('d M Y') }}</p>
        </div>

        <div>
            <strong>Status Lamaran</strong>
            @if ($pelamar->status === 'pending')
                <p class="px-2 py-1 inline-block bg-blue-100 text-blue-700 rounded">Menunggu</p>
            @elseif ($pelamar->status === 'perbaikan')
                <p class="px-2 py-1 inline-block bg-yellow-100 text-yellow-700 rounded">Perlu Perbaikan</p>
            @elseif ($pelamar->status === 'ditolak')
                <p class="px-2 py-1 inline-block bg-red-100 text-red-700 rounded">Ditolak</p>
            @elseif ($pelamar->status === 'diterima')
                <p class="px-2 py-1 inline-block bg-green-100 text-green-700 rounded">Diterima</p>
            @elseif ($pelamar->status === 'telahdiperbaiki')
                <p class="px-2 py-1 inline-block bg-green-100 text-green-700 rounded">Telah memperbaiki</p>
            @else
                <p class="text-gray-700">-</p>
            @endif
        </div>

         {{-- Dokumen --}}
    @if ($pelamar->cv)
        <div>
            <strong>CV</strong>
            <p>
                <a href="{{ asset('storage/'.$pelamar->cv) }}" 
                   target="_blank" 
                   class="text-blue-600 hover:underline">📄 Lihat CV</a>
            </p>
        </div>
    @endif

    @if ($pelamar->transkrip)
        <div>
            <strong>Transkrip Nilai</strong>
            <p>
                <a href="{{ asset('storage/'.$pelamar->transkrip) }}" 
                   target="_blank" 
                   class="text-blue-600 hover:underline">📘 Lihat Transkrip</a>
            </p>
        </div>
    @endif

    @if ($pelamar->surat)
        <div>
            <strong>Surat Pengantar</strong>
            <p>
                <a href="{{ asset('storage/'.$pelamar->surat) }}" 
                   target="_blank" 
                   class="text-blue-600 hover:underline">📨 Lihat Surat Pengantar</a>
            </p>
        </div>
    @endif
</div>

    <div class="mt-8 border-t pt-6 text-center">
        <a href="{{ route('pelamar.center') }}" 
           class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-gray px-5 py-2.5 rounded-lg shadow hover:from-blue-600 hover:to-blue-700 transition">
            ⬅️ Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
