@extends('layouts.pelamar')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow mt-10">
    <h2 class="text-xl font-semibold mb-4">Edit Formulir Pendaftaran Magang</h2>

    <form action="{{ route('form-pendaftaran.update', $pelamar->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium">Nama</label>
            <input type="text" name="nama" value="{{ old('nama', $pelamar->nama) }}" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label class="block font-medium">Jenis Kelamin</label>
            <select name="kelamin" class="form-input w-full" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L" {{ old('kelamin', $pelamar->kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('kelamin', $pelamar->kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-medium">NIK</label>
            <input type="text" name="nik" value="{{ old('nik', $pelamar->nik) }}" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Kampus</label>
            <input type="text" name="kampus" value="{{ old('kampus', $pelamar->kampus) }}" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Jurusan</label>
            <input type="text" name="jurusan" value="{{ old('jurusan', $pelamar->jurusan) }}" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">No Telepon</label>
            <input type="text" name="no_telp" value="{{ old('no_telp', $pelamar->no_telp) }}" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $pelamar->email) }}" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Alamat</label>
            <textarea name="alamat" class="form-textarea w-full" required>{{ old('alamat', $pelamar->alamat) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai Magang</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                   value="{{ old('tanggal_mulai', $pelamar->tanggal_mulai) }}"
                   class="form-input w-full">
        </div>

        <div class="mb-4">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai Magang</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                   value="{{ old('tanggal_selesai', $pelamar->tanggal_selesai) }}"
                   class="form-input w-full">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Upload CV (PDF)</label>
            <input type="file" name="cv" class="form-input w-full" accept="application/pdf">
            @if($pelamar->cv)
                <p class="text-xs mt-1">File sekarang: 
                    <a href="{{ Storage::url($pelamar->cv) }}" target="_blank" class="text-blue-600 underline">Lihat CV</a>
                </p>
            @endif
        </div>

        <div class="mb-4">
            <label class="block font-medium">Upload Transkrip (PDF)</label>
            <input type="file" name="transkrip" class="form-input w-full" accept="application/pdf">
            @if($pelamar->transkrip)
                <p class="text-xs mt-1">File sekarang: 
                    <a href="{{ Storage::url($pelamar->transkrip) }}" target="_blank" class="text-blue-600 underline">Lihat Transkrip</a>
                </p>
            @endif
        </div>

        <div class="mb-4">
            <label class="block font-medium">Upload Surat Pengantar (PDF)</label>
            <input type="file" name="surat" class="form-input w-full" accept="application/pdf">
            @if($pelamar->surat)
                <p class="text-xs mt-1">File sekarang: 
                    <a href="{{ Storage::url($pelamar->surat) }}" target="_blank" class="text-blue-600 underline">Lihat Surat</a>
                </p>
            @endif
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection

@if (session('error'))
    <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
