@extends('layouts.admin-unitkerja-layout')

@section('title', 'Detail Permohonan Magang Kembali')

@section('content')
<div class="px-6 py-4">
    {{-- ✅ TOMBOL KEMBALI --}}
    <div class="mb-4">
        <a href="{{ url()->previous() }}" 
           class="inline-flex items-center gap-2 bg-gray-500 text-gray px-4 py-2 rounded hover:bg-gray-600">
            ← Kembali
        </a>
    </div>

    <h1 class="text-2xl font-bold mb-6">Detail Permohonan Magang Kembali</h1>

    <div class="bg-white shadow rounded-lg p-6">
    {{-- ✅ DATA PESERTA --}}
<h2 class="text-xl font-semibold mb-4">Data Peserta</h2>
<div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
        {{-- Kolom 1 --}}
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">ID Magang:</span>
                <span class="text-gray-900">{{ $peserta->id_magang ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Nama Lengkap:</span>
                <span class="text-gray-900">{{ $peserta->nama ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Jenis Kelamin:</span>
                <span class="text-gray-900">
                    @if($peserta->kelamin === 'L')
                        Laki-laki
                    @elseif($peserta->kelamin === 'P')
                        Perempuan
                    @else
                        -
                    @endif
                </span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">NIK:</span>
                <span class="text-gray-900">{{ $peserta->nik ?? '-' }}</span>
            </div>
        </div>

        {{-- Kolom 2 --}}
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Kampus:</span>
                <span class="text-gray-900">{{ $peserta->kampus ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Jurusan:</span>
                <span class="text-gray-900">{{ $peserta->jurusan ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">No. Telepon:</span>
                <span class="text-gray-900">{{ $peserta->no_telp ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Divisi:</span>
                <span class="text-gray-900">{{ $peserta->divisi ?? '-' }}</span>
            </div>
        </div>

        {{-- Kolom 3 --}}
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Status:</span>
                <span class="px-2 py-1 rounded text-xs font-medium
                    @if($peserta->status === 'aktif') bg-green-100 text-green-800
                    @elseif($peserta->status === 'nonaktif') bg-gray-100 text-gray-800
                    @elseif($peserta->status === 'mundur') bg-red-100 text-red-800
                    @elseif($peserta->status === 'selesai') bg-blue-100 text-blue-800
                    @else bg-yellow-100 text-yellow-800
                    @endif">
                    {{ ucfirst($peserta->status ?? 'tidak diketahui') }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Periode Aktif ID:</span>
                <span class="text-gray-900">{{ $peserta->periode_aktif_id ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Nilai Rata-rata:</span>
                <span class="text-gray-900 font-semibold">
                    @if($peserta->nilai)
                        {{ number_format($peserta->nilai, 2) }}
                    @else
                        -
                    @endif
                </span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Tanggal Mulai:</span>
                <span class="text-gray-900">
                    @if($peserta->tanggal_mulai)
                        {{ \Carbon\Carbon::parse($peserta->tanggal_mulai)->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Tanggal Selesai:</span>
                <span class="text-gray-900">
                    @if($peserta->tanggal_selesai)
                        {{ \Carbon\Carbon::parse($peserta->tanggal_selesai)->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </span>
            </div>
        </div>
    </div>

    {{-- Info Tambahan --}}
    @if($peserta->periodeAktif)
    <div class="mt-4 pt-4 border-t border-gray-200">
        <h3 class="font-semibold text-gray-700 mb-2">Info Periode Aktif</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Periode Ke:</span>
                <span class="text-gray-900">{{ $peserta->periodeAktif->periode_ke ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Status Periode:</span>
                <span class="px-2 py-1 rounded text-xs font-medium
                    @if($peserta->periodeAktif->status === 'aktif') bg-green-100 text-green-800
                    @elseif($peserta->periodeAktif->status === 'selesai') bg-blue-100 text-blue-800
                    @elseif($peserta->periodeAktif->status === 'rencana') bg-yellow-100 text-yellow-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($peserta->periodeAktif->status ?? '-') }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Durasi:</span>
                <span class="text-gray-900">
                    @if($peserta->periodeAktif->tanggal_mulai && $peserta->periodeAktif->tanggal_selesai)
                        {{ \Carbon\Carbon::parse($peserta->periodeAktif->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($peserta->periodeAktif->tanggal_selesai)) }} hari
                    @else
                        -
                    @endif
                </span>
            </div>
        </div>
    </div>
    @endif
</div>

<hr class="my-4">

{{-- ✅ RIWAYAT SIKAP TERAKHIR --}}
@if($riwayatSikap)
<h2 class="text-xl font-semibold mb-4">Riwayat Sikap Terakhir</h2>
<div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
        <!-- Disiplin -->
        <div class="space-y-1">
            <h3 class="font-semibold text-gray-700 border-b pb-1">A. Disiplin</h3>
            <div class="flex justify-between">
                <span>Ketepatan Waktu:</span>
                <span class="font-medium">{{ $riwayatSikap->disiplin_tepat_waktu }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kehadiran:</span>
                <span class="font-medium">{{ $riwayatSikap->disiplin_kehadiran }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tata Tertib:</span>
                <span class="font-medium">{{ $riwayatSikap->disiplin_tata_tertib }}</span>
            </div>
        </div>

        <!-- Kinerja -->
        <div class="space-y-1">
            <h3 class="font-semibold text-gray-700 border-b pb-1">B. Kinerja</h3>
            <div class="flex justify-between">
                <span>Keterampilan:</span>
                <span class="font-medium">{{ $riwayatSikap->kerja_keterampilan }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kualitas Kerja:</span>
                <span class="font-medium">{{ $riwayatSikap->kerja_kualitas }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggung Jawab:</span>
                <span class="font-medium">{{ $riwayatSikap->kerja_tanggung_jawab }}</span>
            </div>
        </div>

        <!-- Sosial -->
        <div class="space-y-1">
            <h3 class="font-semibold text-gray-700 border-b pb-1">C. Sosial</h3>
            <div class="flex justify-between">
                <span>Komunikasi:</span>
                <span class="font-medium">{{ $riwayatSikap->sosial_komunikasi }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kerjasama:</span>
                <span class="font-medium">{{ $riwayatSikap->sosial_kerjasama }}</span>
            </div>
            <div class="flex justify-between">
                <span>Inisiatif:</span>
                <span class="font-medium">{{ $riwayatSikap->sosial_inisiatif }}</span>
            </div>
        </div>

        <!-- Lain-lain -->
        <div class="space-y-1">
            <h3 class="font-semibold text-gray-700 border-b pb-1">D. Lain-lain</h3>
            <div class="flex justify-between">
                <span>Etika:</span>
                <span class="font-medium">{{ $riwayatSikap->lain_etika }}</span>
            </div>
            <div class="flex justify-between">
                <span>Penampilan:</span>
                <span class="font-medium">{{ $riwayatSikap->lain_penampilan }}</span>
            </div>
        </div>
    </div>

    <!-- Summary Nilai -->
    <div class="mt-4 pt-4 border-t border-gray-200">
        <div class="flex justify-between items-center">
            <div>
                <span class="font-semibold text-gray-700">Total Nilai:</span>
                <span class="ml-2 text-lg font-bold text-blue-600">{{ $riwayatSikap->jumlah_nilai ?? '0' }}/1300</span>
            </div>
            <div>
                <span class="font-semibold text-gray-700">Rata-rata:</span>
                <span class="ml-2 text-lg font-bold text-green-600">{{ $riwayatSikap->nilai_rata_rata ?? '0' }}</span>
            </div>
            <div class="text-sm text-gray-500">
                Periode: {{ $riwayatSikap->periode->periode_ke ?? '-' }}
            </div>
        </div>
    </div>
</div>
@else
<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
    <div class="flex items-center gap-2">
        <span class="text-yellow-600">ℹ️</span>
        <p class="text-yellow-700 text-sm">
            Belum ada riwayat penilaian sikap untuk peserta ini.
        </p>
    </div>
</div>
@endif

<hr class="my-4">

{{-- ✅ DETAIL PERMOHONAN AKTIF --}}
<h2 class="text-xl font-semibold mb-4">Permohonan Saat Ini</h2>
<table class="w-full border border-gray-300 text-sm mb-4">
    <tr>
        <td class="px-3 py-2 font-medium w-1/3">Jenis Permohonan</td>
        <td class="px-3 py-2">{{ ucfirst($permohonan->jenis_permohonan) }}</td>
    </tr>
    <tr>
        <td class="px-3 py-2 font-medium">Tanggal Mulai</td>
        <td class="px-3 py-2">{{ $permohonan->tanggal_mulai }}</td>
    </tr>
    <tr>
        <td class="px-3 py-2 font-medium">Tanggal Selesai</td>
        <td class="px-3 py-2">{{ $permohonan->tanggal_selesai }}</td>
    </tr>
    <tr>
        <td class="px-3 py-2 font-medium">Status</td>
        <td class="px-3 py-2">
            <span class="
                @if($permohonan->status == 'disetujui') text-green-600
                @elseif($permohonan->status == 'ditolak') text-red-600
                @else text-yellow-600
                @endif
            ">
                {{ ucfirst($permohonan->status) }}
            </span>
        </td>
    </tr>
</table>

        {{-- ✅ SURAT PERMOHONAN --}}
        @if($permohonan->surat)
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded">
            <h3 class="text-lg font-semibold mb-3">📎 Surat Permohonan</h3>
            <div class="flex items-center gap-4">
                <a href="{{ asset('storage/' . $permohonan->surat) }}" 
                   target="_blank"
                   class="inline-flex items-center gap-2 bg-blue-500 text-gray px-4 py-2 rounded hover:bg-blue-600">
                    📄 Lihat Surat Lengkap
                </a>
                <span class="text-sm text-gray-600">Klik untuk membuka surat di tab baru</span>
            </div>
        </div>
        @endif

        {{-- 🔹 TOMBOL UBAH TANGGAL PERMOHONAN (HANYA UNTUK STATUS PENDING) --}}
        @if($permohonan->status === 'pending')
        <div x-data="{ openMulai: false, openSelesai: false }" x-cloak class="flex flex-col sm:flex-row gap-4 mt-4">

            {{-- 🔹 Tombol Tanggal Mulai Permohonan --}}
            @if(in_array($permohonan->jenis_permohonan, ['tambah', 'permohonanmagangkembali']))
            <button 
                @click="openMulai = true"
                class="px-4 py-2 rounded-xl bg-white/20 backdrop-blur-sm shadow-md border border-gray-200 text-gray-800 hover:shadow-lg transition-all duration-200 w-full sm:w-auto text-center">
                <span class="font-medium">Mulai Permohonan:</span>
                <span class="ml-1 text-blue-600 font-semibold">{{ $permohonan->tanggal_mulai ?? '-' }}</span>
            </button>
            @elseif($permohonan->jenis_permohonan === 'percepat')
            <button 
                disabled
                class="px-4 py-2 rounded-xl bg-gray-100 border border-gray-300 text-gray-500 w-full sm:w-auto text-center cursor-not-allowed">
                <span class="font-medium">Mulai Permohonan:</span>
                <span class="ml-1">{{ $permohonan->tanggal_mulai ?? '-' }}</span>
                <div class="text-xs text-gray-400 mt-1">(Tidak dapat diubah untuk percepatan)</div>
            </button>
            @elseif($permohonan->jenis_permohonan === 'mundur')
            <button 
                disabled
                class="px-4 py-2 rounded-xl bg-gray-100 border border-gray-300 text-gray-500 w-full sm:w-auto text-center cursor-not-allowed">
                <span class="font-medium">Mulai Permohonan:</span>
                <span class="ml-1">{{ $permohonan->tanggal_mulai ?? '-' }}</span>
                <div class="text-xs text-gray-400 mt-1">(Tidak diperlukan untuk pengunduran)</div>
            </button>
            @endif

            {{-- 🔹 Tombol Tanggal Selesai Permohonan --}}
            @if($permohonan->jenis_permohonan !== 'mundur')
            <button 
                @click="openSelesai = true"
                class="px-4 py-2 rounded-xl bg-white/20 backdrop-blur-sm shadow-md border border-gray-200 text-gray-800 hover:shadow-lg transition-all duration-200 w-full sm:w-auto text-center">
                <span class="font-medium">Selesai Permohonan:</span>
                <span class="ml-1 text-emerald-600 font-semibold">{{ $permohonan->tanggal_selesai ?? '-' }}</span>
            </button>
            @else
            <button 
                disabled
                class="px-4 py-2 rounded-xl bg-gray-100 border border-gray-300 text-gray-500 w-full sm:w-auto text-center cursor-not-allowed">
                <span class="font-medium">Selesai Permohonan:</span>
                <span class="ml-1">{{ $permohonan->tanggal_selesai ?? '-' }}</span>
                <div class="text-xs text-gray-400 mt-1">(Tidak diperlukan untuk pengunduran)</div>
            </button>
            @endif

            {{-- ✅ Modal Ubah Tanggal Mulai Permohonan --}}
            @if(in_array($permohonan->jenis_permohonan, ['tambah', 'permohonanmagangkembali']))
            <div 
                x-show="openMulai"
                class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
                x-transition
            >
                <div class="bg-white p-5 rounded-xl shadow-lg w-96 relative">
                    <form method="POST" action="{{ route('admin-unitkerja.permohonan-periode.updateTanggalMulai', $permohonan->id) }}">
                        @csrf
                        @method('PUT')

                        <h2 class="text-lg font-semibold mb-4 text-gray-800">Ubah Tanggal Mulai Permohonan</h2>

                        <div class="mb-3">
                            <label for="tanggal_mulai_{{ $permohonan->id }}" class="block text-sm font-medium text-gray-700">
                                Tanggal Mulai Baru
                            </label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai_{{ $permohonan->id }}"
                                value="{{ $permohonan->tanggal_mulai }}"
                                class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        </div>

                        {{-- Tampilkan pesan error/success --}}
                        @if(session('error'))
                            <div class="mb-3 p-2 bg-red-100 text-red-700 rounded text-sm">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="mb-3 p-2 bg-green-100 text-green-700 rounded text-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="flex justify-end space-x-2 mt-4">
                            <button type="button"
                                @click="openMulai = false"
                                class="px-3 py-1 rounded border text-gray-700 hover:bg-gray-100">
                                Batal
                            </button>
                            <button type="submit"
                                class="bg-blue-600 text-gray px-3 py-1 rounded hover:bg-blue-700 text-sm font-semibold shadow-md">
                                💾 Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            {{-- ✅ Modal Ubah Tanggal Selesai Permohonan --}}
            @if($permohonan->jenis_permohonan !== 'mundur')
            <div 
                x-show="openSelesai"
                class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
                x-transition
            >
                <div class="bg-white p-5 rounded-xl shadow-lg w-96 relative">
                    <form method="POST" action="{{ route('admin-unitkerja.permohonan-periode.updateTanggalSelesai', $permohonan->id) }}">
                        @csrf
                        @method('PUT')

                        <h2 class="text-lg font-semibold mb-4 text-gray-800">Ubah Tanggal Selesai Permohonan</h2>

                        <div class="mb-3">
                            <label for="tanggal_selesai_{{ $permohonan->id }}" class="block text-sm font-medium text-gray-700">
                                Tanggal Selesai Baru
                            </label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai_{{ $permohonan->id }}"
                                value="{{ $permohonan->tanggal_selesai }}"
                                class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400" required>
                        </div>

                        {{-- Tampilkan pesan error/success --}}
                        @if(session('error'))
                            <div class="mb-3 p-2 bg-red-100 text-red-700 rounded text-sm">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="mb-3 p-2 bg-green-100 text-green-700 rounded text-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="flex justify-end space-x-2 mt-4">
                            <button type="button"
                                @click="openSelesai = false"
                                class="px-3 py-1 rounded border text-gray-700 hover:bg-gray-100">
                                Batal
                            </button>
                            <button type="submit"
                                class="bg-emerald-600 text-gray px-3 py-1 rounded hover:bg-emerald-700 text-sm font-semibold shadow-md">
                                💾 Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

        </div>
        @else
        {{-- Pesan jika status bukan pending --}}
        <div class="mt-4 p-3 bg-gray-100 rounded border">
            <p class="text-gray-600 text-sm">
                📝 <strong>Edit tanggal tidak tersedia</strong> - Permohonan sudah {{ $permohonan->status }}.
            </p>
        </div>
        @endif

        {{-- ✅ TOMBOL AKSI --}}
        @if($permohonan->status === 'pending')
            <div class="flex gap-3 mb-6 mt-6">
                <form action="{{ route('admin-unitkerja.permohonan.approve', $permohonan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-gray rounded hover:bg-green-700">
                        Approve
                    </button>
                </form>

                <form action="{{ route('admin-unitkerja.permohonan.reject', $permohonan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-gray rounded hover:bg-red-700">
                        Reject
                    </button>
                </form>
            </div>
        @endif

        <hr class="my-4">

        
    </div>
</div>
@endsection