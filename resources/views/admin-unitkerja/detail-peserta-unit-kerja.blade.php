@extends('layouts.admin-unitkerja-layout')

@section('title', 'Detail Peserta unit kerja')

@section('content')
<div class="px-6 py-4">
    <h1 class="text-2xl font-bold mb-6">Detail Peserta</h1>

    <div class="bg-white rounded shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

            {{-- Informasi Magang --}}
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><strong>ID Magang:</strong><p>{{ $peserta->id_magang ?? '-' }}</p></div>
                <div><strong>Divisi:</strong><p>{{ $peserta->divisi ?? '-' }}</p></div>
                <div><strong>Nilai:</strong><p>{{ $peserta->nilai ?? '-' }}</p></div>
                <div><strong>Status:</strong><p>{{ ucfirst($peserta->status) ?? '-' }}</p></div>
                <div class="md:col-span-2"><strong>Catatan Admin:</strong><p>{{ $peserta->catatan_admin ?? '-' }}</p></div>
            </div>

            {{-- Data Pribadi --}}
            <div><strong>Nama Lengkap:</strong><p>{{ $peserta->nama }}</p></div>
            <div><strong>Nama Akun:</strong><p>{{ $peserta->user->name ?? '-' }}</p></div>
            <div><strong>nik:</strong><p>{{ $peserta->nik }}</p></div>
            <div><strong>Kampus:</strong><p>{{ $peserta->kampus }}</p></div>
            <div><strong>Jurusan:</strong><p>{{ $peserta->jurusan }}</p></div>
            <div><strong>Telepon:</strong><p>{{ $peserta->no_telp }}</p></div>
            <div><strong>Email:</strong><p>{{ $peserta->user->email ?? '-' }}</p></div>
            <div><strong>Alamat:</strong><p>{{ $peserta->alamat }}</p></div>
            <div><strong>Tanggal Mulai:</strong><p>{{ $peserta->tanggal_mulai }}</p></div>
            <div><strong>Tanggal Selesai:</strong><p>{{ $peserta->tanggal_selesai }}</p></div>

            {{-- CV --}}
<div>
    @if ($peserta->cv)
        <p class="font-semibold mt-4">CV Peserta:</p>
        <a href="{{ asset('storage/' . $peserta->cv) }}" target="_blank"
           class="text-blue-600 underline hover:text-blue-800">Lihat CV</a>
    @else
        <p class="text-gray-500 italic">CV belum tersedia.</p>
    @endif
</div>

{{-- Transkrip --}}
<div>
    @if ($peserta->transkrip)
        <p class="font-semibold mt-4">Transkrip Nilai:</p>
        <a href="{{ asset('storage/' . $peserta->transkrip) }}" target="_blank"
           class="text-blue-600 underline hover:text-blue-800">Lihat Transkrip</a>
    @else
        <p class="text-gray-500 italic">Transkrip belum tersedia.</p>
    @endif
</div>

{{-- Surat Pengajuan --}}
<div>
    @if ($peserta->surat)
        <p class="font-semibold mt-4">Surat Pengajuan Magang:</p>
        <a href="{{ asset('storage/' . $peserta->surat) }}" target="_blank"
           class="text-blue-600 underline hover:text-blue-800">Lihat Surat</a>
    @else
        <p class="text-gray-500 italic">Surat belum tersedia.</p>
    @endif
</div>

<div class="flex gap-2 mt-3">
    <!-- Tombol Luluskan -->
    <button type="button"
            onclick="document.getElementById('modal-lulus-{{ $peserta->id }}').classList.remove('hidden')"
            class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">
        Luluskan
    </button>

    <!-- Tombol Mundurkan -->
    <button type="button"
            onclick="document.getElementById('modal-mundur-{{ $peserta->id }}').classList.remove('hidden')"
            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
        Mundurkan
    </button>
</div>

<!-- Modal Lulus -->
<div id="modal-lulus-{{ $peserta->id }}"
     class="hidden fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-lg w-96 transform transition-all p-5">
        <h2 class="text-lg font-semibold mb-3 text-gray-700 border-b pb-2">Luluskan Peserta</h2>
        <form action="{{ route('admin-unitkerja.peserta-magang.lulus', $peserta->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nilai" class="block text-sm font-medium text-gray-700 mb-1">Nilai Akhir</label>
                <input type="number" name="nilai"
                       value="{{ $peserta->nilai ?? '' }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-green-300"
                       min="0" max="100" required>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="document.getElementById('modal-lulus-{{ $peserta->id }}').classList.add('hidden')"
                        class="px-3 py-1 text-sm border border-gray-400 rounded hover:bg-gray-100">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">
                    Simpan & Luluskan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Mundur -->
<div id="modal-mundur-{{ $peserta->id }}"
     class="hidden fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-lg w-96 transform transition-all p-5">
        <h2 class="text-lg font-semibold mb-3 text-gray-700 border-b pb-2">
            Mundurkan Peserta
        </h2>

        <form action="{{ route('admin-unitkerja.peserta-magang.mundur', $peserta->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="alasan" class="block text-sm font-medium text-gray-700 mb-1">
                    Alasan Mundur
                </label>
                <textarea name="alasan_mundur" id="alasan_mundur" rows="3" required
                          class="w-full text-sm border rounded px-3 py-2 focus:ring focus:ring-red-200 focus:border-red-400"
                          placeholder="Tulis alasan peserta mundur..."></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="document.getElementById('modal-mundur-{{ $peserta->id }}').classList.add('hidden')"
                        class="px-3 py-1 text-sm border border-gray-400 rounded hover:bg-gray-100">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">
                    Simpan & Mundurkan
                </button>
            </div>
        </form>
    </div>
</div>

        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-6 flex gap-2">
    <a href="{{ route('admin-unitkerja.peserta-magang') }}"
       class="px-4 py-2 bg-cyan-200 hover:bg-cyan-300 text-black font-semibold rounded shadow-md text-sm">
       ← Kembali
    </a>
</div>

    </div>
</div>
@endsection
