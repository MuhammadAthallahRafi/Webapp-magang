@extends('layouts.pelamar')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow mt-10">
    <h2 class="text-xl font-semibold mb-4">Formulir Pendaftaran Magang</h2>

    <form action="{{ route('form.pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block font-medium">Nama</label>
            <input type="text" name="nama" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">NIK</label>
            <input type="text" name="nik" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Kampus</label>
            <input type="text" name="kampus" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Jurusan</label>
            <input type="text" name="jurusan" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">No Telepon</label>
            <input type="text" name="no_telp" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Email</label>
            <input type="email" name="email" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Alamat</label>
            <textarea name="alamat" class="form-textarea w-full" required></textarea>
        </div>

        <div class="mb-4">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai Magang</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control">
        </div>

        <div class="mb-4">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai Magang</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Upload CV (PDF)</label>
            <input type="file" name="cv" class="form-input w-full" accept="application/pdf" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Upload Transkrip (PDF)</label>
            <input type="file" name="transkrip" class="form-input w-full" accept="application/pdf" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Upload Surat Pengantar (PDF)</label>
            <input type="file" name="surat" class="form-input w-full" accept="application/pdf" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Kirim Pendaftaran
        </button>
    </form>
</div>
@endsection

@if (session('error'))
    <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
