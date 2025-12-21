@extends('layouts.admin-unitkerja-layout')

@section('title', 'Detail Peserta Unit Kerja')

@section('content')
<div class="px-4 py-6 sm:px-6 lg:px-8">
    {{-- Header dengan tombol kembali --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Peserta Magang</h1>
                <p class="text-sm text-gray-500 mt-1">Informasi lengkap peserta dan dokumen terkait</p>
            </div>
            <a href="{{ route('admin-unitkerja.peserta-magang') }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    {{-- ✅ Flash Message --}}
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- 📋 Informasi Status Peserta --}}
    <div class="bg-white shadow-sm rounded-xl overflow-hidden mb-8">
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Status Magang</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">ID Magang</label>
                    <p class="text-sm text-gray-900 font-semibold">{{ $peserta->id_magang ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Divisi</label>
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ $peserta->divisi ?? '-' }}
                    </span>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nilai</label>
                    <p class="text-sm text-gray-900 font-semibold">{{ $peserta->nilai ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Status</label>
                    @php
                        $statusColors = [
                            'aktif' => 'bg-green-100 text-green-800',
                            'lulus' => 'bg-blue-100 text-blue-800',
                            'mundur' => 'bg-red-100 text-red-800',
                            'selesai' => 'bg-purple-100 text-purple-800'
                        ];
                        $statusColor = $statusColors[$peserta->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }} capitalize">
                        {{ $peserta->status ?? '-' }}
                    </span>
                </div>
            </div>
            
            @if($peserta->catatan_admin)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Catatan Admin</label>
                <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg">{{ $peserta->catatan_admin }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- 📋 Informasi Pribadi Peserta --}}
    <div class="bg-white shadow-sm rounded-xl overflow-hidden mb-8">
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Kolom 1 --}}
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                        <p class="text-sm text-gray-900 font-medium">{{ $peserta->nama }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Akun</label>
                        <p class="text-sm text-gray-900">{{ $peserta->user->name ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">NIK</label>
                        <p class="text-sm text-gray-900">{{ $peserta->nik }}</p>
                    </div>
                </div>

                {{-- Kolom 2 --}}
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Instansi Pendidikan</label>
                        <p class="text-sm text-gray-900">{{ $peserta->kampus }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Jurusan</label>
                        <p class="text-sm text-gray-900">{{ $peserta->jurusan }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Telepon</label>
                        <p class="text-sm text-gray-900">{{ $peserta->no_telp }}</p>
                    </div>
                </div>

                {{-- Kolom 3 --}}
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email</label>
                        <p class="text-sm text-gray-900">{{ $peserta->user->email ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Alamat</label>
                        <p class="text-sm text-gray-900">{{ $peserta->alamat }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Mulai</label>
                            <p class="text-sm text-gray-900">{{ $peserta->tanggal_mulai ? \Carbon\Carbon::parse($peserta->tanggal_mulai)->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Selesai</label>
                            <p class="text-sm text-gray-900">{{ $peserta->tanggal_selesai ? \Carbon\Carbon::parse($peserta->tanggal_selesai)->format('d/m/Y') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 📄 Dokumen Peserta --}}
    <div class="bg-white shadow-sm rounded-xl overflow-hidden mb-8">
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Dokumen Pendukung</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- CV --}}
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-200">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Curriculum Vitae (CV)</h3>
                            <p class="text-xs text-gray-500">Dokumen riwayat hidup</p>
                        </div>
                        <div class="bg-blue-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    @if ($peserta->cv)
                        <a href="{{ asset('storage/' . $peserta->cv) }}" target="_blank"
                           class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded hover:bg-blue-100 transition duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Lihat Dokumen
                        </a>
                    @else
                        <p class="text-sm text-gray-400 italic">Belum diunggah</p>
                    @endif
                </div>

                {{-- Transkrip --}}
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-200">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Transkrip Nilai</h3>
                            <p class="text-xs text-gray-500">Dokumen akademik</p>
                        </div>
                        <div class="bg-purple-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    @if ($peserta->transkrip)
                        <a href="{{ asset('storage/' . $peserta->transkrip) }}" target="_blank"
                           class="inline-flex items-center px-3 py-1.5 bg-purple-50 text-purple-700 text-xs font-medium rounded hover:bg-purple-100 transition duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Lihat Dokumen
                        </a>
                    @else
                        <p class="text-sm text-gray-400 italic">Belum diunggah</p>
                    @endif
                </div>

                {{-- Surat Pengantar --}}
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-200">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Surat Pengantar</h3>
                            <p class="text-xs text-gray-500">Surat pengajuan magang</p>
                        </div>
                        <div class="bg-green-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    @if ($peserta->surat)
                        <a href="{{ asset('storage/' . $peserta->surat) }}" target="_blank"
                           class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 text-xs font-medium rounded hover:bg-green-100 transition duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Lihat Dokumen
                        </a>
                    @else
                        <p class="text-sm text-gray-400 italic">Belum diunggah</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Aksi Admin Unit Kerja --}}
    @if($peserta->status === 'aktif')
    <div class="bg-white shadow-sm rounded-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Aksi Administrasi Unit Kerja</h2>
        </div>
        
        <div class="p-6">
            <div class="flex flex-col sm:flex-row gap-4">
                {{-- Tombol Luluskan --}}
                <button type="button"
                        onclick="document.getElementById('modal-lulus').classList.remove('hidden')"
                        class="inline-flex items-center justify-center px-4 py-3 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200 shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Luluskan Peserta
                </button>

                {{-- Tombol Mundurkan --}}
                <button type="button"
                        onclick="document.getElementById('modal-mundur').classList.remove('hidden')"
                        class="inline-flex items-center justify-center px-4 py-3 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200 shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Mundurkan Peserta
                </button>
            </div>
        </div>
    </div>
    @else
    <div class="bg-gray-50 rounded-xl p-6 mb-8">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h3 class="text-sm font-medium text-gray-900">Tombol aksi tidak tersedia</h3>
                <p class="text-sm text-gray-500 mt-1">Status peserta saat ini adalah <span class="font-semibold">{{ $peserta->status }}</span>. Aksi hanya tersedia untuk peserta dengan status aktif.</p>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Modal Lulus --}}
@if($peserta->status === 'aktif')
<div id="modal-lulus" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Penilaian Kelulusan</h3>
            <p class="text-sm text-gray-500 mt-1">Isi form penilaian untuk meluluskan peserta</p>
        </div>
        <form action="{{ route('admin-unitkerja.peserta-magang.lulus', $peserta->id) }}" method="POST" class="p-6">
            @csrf

            {{-- Disiplin --}}
            <div class="mb-6">
                <h4 class="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wide">A. Disiplin</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Ketepatan Waktu</label>
                        <input type="number" name="disiplin_tepat_waktu" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm no-spinner"
                               min="0" max="100" placeholder="0-100" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Kehadiran</label>
                        <input type="number" name="disiplin_kehadiran"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm no-spinner"
                               min="0" max="100" placeholder="0-100" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Tata Tertib</label>
                        <input type="number" name="disiplin_tata_tertib"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm no-spinner"
                               min="0" max="100" placeholder="0-100" required>
                    </div>
                </div>
            </div>

            {{-- Kinerja --}}
            <div class="mb-6">
                <h4 class="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wide">B. Kinerja</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Keterampilan</label>
                        <input type="number" name="kerja_keterampilan"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm no-spinner"
                               min="0" max="100" placeholder="0-100" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Kualitas Kerja</label>
                        <input type="number" name="kerja_kualitas"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm no-spinner"
                               min="0" max="100" placeholder="0-100" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Tanggung Jawab</label>
                        <input type="number" name="kerja_tanggung_jawab"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm no-spinner"
                               min="0" max="100" placeholder="0-100" required>
                    </div>
                </div>
            </div>

            {{-- Sosial --}}
            <div class="mb-6">
                <h4 class="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wide">C. Sosial</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Komunikasi</label>
                        <input type="number" name="sosial_komunikasi"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm no-spinner"
                               min="0" max="100" placeholder="0-100" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Kerjasama</label>
                        <input type="number" name="sosial_kerjasama"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm no-spinner"
                               min="0" max="100" placeholder="0-100" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Inisiatif</label>
                        <input type="number" name="sosial_inisiatif"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm no-spinner"
                               min="0" max="100" placeholder="0-100" required>
                    </div>
                </div>
            </div>

            {{-- Lain-lain --}}
            <div class="mb-8">
                <h4 class="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wide">D. Lain-lain</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Etika</label>
                        <input type="number" name="lain_etika"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm no-spinner"
                               min="0" max="100" placeholder="0-100" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Penampilan</label>
                        <input type="number" name="lain_penampilan"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm no-spinner"
                               min="0" max="100" placeholder="0-100" required>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                <button type="button"
                        onclick="document.getElementById('modal-lulus').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                    Simpan & Luluskan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Mundur --}}
<div id="modal-mundur" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Mundurkan Peserta</h3>
            <p class="text-sm text-gray-500 mt-1">Berikan alasan untuk mundurkan peserta</p>
        </div>
        <form action="{{ route('admin-unitkerja.peserta-magang.mundur', $peserta->id) }}" method="POST" class="p-6">
            @csrf
            <div class="mb-6">
                <label for="alasan" class="block text-sm font-medium text-gray-700 mb-2">
                    Alasan Mundur
                </label>
                <textarea name="alasan" 
                         id="alasan" 
                         rows="4"
                         class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                         placeholder="Jelaskan alasan peserta mundur..."
                         required></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button"
                        onclick="document.getElementById('modal-mundur').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                    Simpan & Mundurkan
                </button>
            </div>
        </form>
    </div>
</div>
@endif

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
@endsection