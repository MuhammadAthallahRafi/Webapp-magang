<!-- C:\laragon\www\magangbkn\resources\views\admin\detail-peserta.blade.php -->
@extends('layouts.admin-layout')

@section('title', 'Detail Peserta')

@section('content')
<div class="px-6 py-4">
    <h1 class="text-2xl font-bold mb-6">Detail Peserta</h1>

    <div class="bg-white rounded shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div><strong>ID Magang:</strong><p>{{ $peserta->id_magang ?? '-' }}</p></div>
            <div><strong>Divisi:</strong><p>{{ $peserta->divisi ?? '-' }}</p></div>
            <div><strong>Nilai:</strong><p>{{ $peserta->nilai ?? '-' }}</p></div>
            <div><strong>Status:</strong><p>{{ ucfirst($peserta->status) ?? '-' }}</p></div>
            <div class="md:col-span-2"><strong>Catatan Admin:</strong><p>{{ $peserta->catatan_admin ?? '-' }}</p></div>
        </div>

            <div>
                <strong>Nama Lengkap:</strong>
                <p>{{ $peserta->nama }}</p>
            </div>
            <div>
                <strong>Nama Akun:</strong>
                <p>{{ $peserta->user->name }}</p>
            </div>
            <div>
                <strong>nik:</strong>
                <p>{{ $peserta->nik }}</p>
            </div>
            <div>
                <strong>>Instansi Pendidikan (Kampus atau SMK,SMA)</strong>
                <p>{{ $peserta->kampus }}</p>
            </div>
            <div>
                <strong>Jurusan:</strong>
                <p>{{ $peserta->jurusan }}</p>
            </div>
            <div>
                <strong>Telepon:</strong>
                <p>{{ $peserta->no_telp }}</p>
            </div>
            <div>
                <strong>Email:</strong>
                <p>{{ $peserta->user->email }}</p>
            </div>
            <div>
                <strong>Alamat:</strong>
                <p>{{ $peserta->alamat }}</p>
            </div>
            <div>
                <strong>Tanggal mulai:</strong>
                <p>{{ $peserta->tanggal_mulai }}</p>
            </div>
            <div>
                <strong>Tanggal Selesai:</strong>
                <p>{{ $peserta->tanggal_selesai }}</p>
            </div>
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

        <!-- Tombol Aksi hanya untuk status aktif -->
        @if($peserta->status === 'aktif')
        <div class="mt-6 flex gap-2">
            <!-- Tombol Luluskan -->
            <button type="button"
                    onclick="document.getElementById('modal-lulus-{{ $peserta->id }}').classList.remove('hidden')"
                    class="bg-green-600 text-gray px-3 py-1 rounded hover:bg-green-700 text-sm transition">
                Luluskan
            </button>

            <!-- Tombol Mundurkan -->
            <button type="button"
                    onclick="document.getElementById('modal-mundur-{{ $peserta->id }}').classList.remove('hidden')"
                    class="bg-red-500 text-gray px-3 py-1 rounded hover:bg-red-600 text-sm">
                Mundurkan
            </button>
        </div>
        @else
        <div class="mt-6">
            <p class="text-gray-500 italic text-sm">
                Tombol aksi tidak tersedia untuk peserta dengan status {{ $peserta->status }}.
            </p>
        </div>
        @endif

        <!-- Modal Lulus -->
        @if($peserta->status === 'aktif')
        <div id="modal-lulus-{{ $peserta->id }}"
             class="hidden fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center">
            <div class="bg-white rounded-2xl shadow-lg w-[500px] transform transition-all p-5 overflow-y-auto max-h-[90vh]">

                <h2 class="text-lg font-semibold mb-3 text-gray-700 border-b pb-2">Penilaian Kelulusan</h2>

                <form action="{{ route('admin.peserta-magang.lulus', $peserta->id) }}" method="POST">
    @csrf

    <!-- ✅ Disiplin -->
    <h3 class="font-semibold text-gray-700 mt-2">A. Disiplin</h3>
    <div class="grid grid-cols-2 gap-3 mt-1">
        <div>
            <label class="text-xs text-gray-600">Ketepatan Waktu</label>
            <input type="number" name="disiplin_tepat_waktu"
                class="border rounded px-2 py-1 w-full no-spinner" 
                min="0" max="100" required>
        </div>
        <div>
            <label class="text-xs text-gray-600">Kehadiran</label>
            <input type="number" name="disiplin_kehadiran"
                class="border rounded px-2 py-1 w-full no-spinner" 
                min="0" max="100" required>
        </div>
        <div>
            <label class="text-xs text-gray-600">Tata Tertib</label>
            <input type="number" name="disiplin_tata_tertib"
                class="border rounded px-2 py-1 w-full no-spinner" 
                min="0" max="100" required>
        </div>
    </div>

    <!-- ✅ Kinerja -->
    <h3 class="font-semibold text-gray-700 mt-3">B. Kinerja</h3>
    <div class="grid grid-cols-2 gap-3 mt-1">
        <div>
            <label class="text-xs text-gray-600">Keterampilan</label>
            <input type="number" name="kerja_keterampilan"
                class="border rounded px-2 py-1 w-full no-spinner" 
                min="0" max="100" required>
        </div>
        <div>
            <label class="text-xs text-gray-600">Kualitas Kerja</label>
            <input type="number" name="kerja_kualitas"
                class="border rounded px-2 py-1 w-full no-spinner" 
                min="0" max="100" required>
        </div>
        <div>
            <label class="text-xs text-gray-600">Tanggung Jawab</label>
            <input type="number" name="kerja_tanggung_jawab"
                class="border rounded px-2 py-1 w-full no-spinner" 
                min="0" max="100" required>
        </div>
    </div>

    <!-- ✅ Sosial -->
    <h3 class="font-semibold text-gray-700 mt-3">C. Sosial</h3>
    <div class="grid grid-cols-2 gap-3 mt-1">
        <div>
            <label class="text-xs text-gray-600">Komunikasi</label>
            <input type="number" name="sosial_komunikasi"
                class="border rounded px-2 py-1 w-full no-spinner" 
                min="0" max="100" required>
        </div>
        <div>
            <label class="text-xs text-gray-600">Kerjasama</label>
            <input type="number" name="sosial_kerjasama"
                class="border rounded px-2 py-1 w-full no-spinner" 
                min="0" max="100" required>
        </div>
        <div>
            <label class="text-xs text-gray-600">Inisiatif</label>
            <input type="number" name="sosial_inisiatif"
                class="border rounded px-2 py-1 w-full no-spinner" 
                min="0" max="100" required>
        </div>
    </div>

    <!-- ✅ Lain-lain -->
    <h3 class="font-semibold text-gray-700 mt-3">D. Lain-lain</h3>
    <div class="grid grid-cols-2 gap-3 mt-1">
        <div>
            <label class="text-xs text-gray-600">Etika</label>
            <input type="number" name="lain_etika"
                class="border rounded px-2 py-1 w-full no-spinner" 
                min="0" max="100" required>
        </div>
        <div>
            <label class="text-xs text-gray-600">Penampilan</label>
            <input type="number" name="lain_penampilan"
                class="border rounded px-2 py-1 w-full no-spinner" 
                min="0" max="100" required>
        </div>
    </div>

    <!-- ✅ Action -->
    <div class="flex justify-end gap-2 mt-5">
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

<style>
/* Hilangkan tombol spinner di semua browser */
.no-spinner::-webkit-outer-spin-button,
.no-spinner::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.no-spinner {
    -moz-appearance: textfield;
    appearance: none;
}
</style>

            </div>
        </div>

        <!-- Modal Mundur -->
        <div id="modal-mundur-{{ $peserta->id }}"
            class="hidden fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center">
            <div class="bg-white rounded-2xl shadow-lg w-96 transform transition-all p-5">
                <h2 class="text-lg font-semibold mb-3 text-gray-700 border-b pb-2">
                    Mundurkan Peserta
                </h2>

                <form action="{{ route('admin.peserta-magang.mundur', $peserta->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="alasan" class="block text-sm font-medium text-gray-700 mb-1">
                            Alasan Mundur
                        </label>
                        <textarea name="alasan" id="alasan" rows="3" required
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
                                class="px-4 py-1 text-sm bg-red-500 text-gray rounded hover:bg-red-600">
                            Simpan & Mundurkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <div class="mt-6 flex gap-2">
            <a href="{{ route('admin.peserta-magang') }}"
               class="px-4 py-2 bg-cyan-200 hover:bg-cyan-300 text-black font-semibold rounded shadow-md text-sm">
               ← Kembali
            </a>
        </div>
    </div>
</div>
@endsection