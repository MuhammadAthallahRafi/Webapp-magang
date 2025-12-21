@extends('layouts.admin-layout')

@section('title', 'Detail Pelamar')

@section('content')
<div class="px-4 py-6 sm:px-6 lg:px-8">
    {{-- Header dengan tombol kembali --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Pelamar Magang</h1>
                <p class="text-sm text-gray-500 mt-1">Informasi lengkap pelamar dan dokumen terkait</p>
            </div>
            <a href="{{ route('admin.pelamar') }}"
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

    {{-- 📋 Informasi Pelamar --}}
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
                        <p class="text-sm text-gray-900 font-medium">{{ $pelamar->nama }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Akun</label>
                        <p class="text-sm text-gray-900">{{ $pelamar->user->name ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">NIK</label>
                        <p class="text-sm text-gray-900">{{ $pelamar->nik }}</p>
                    </div>
                </div>

                {{-- Kolom 2 --}}
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Instansi Pendidikan</label>
                        <p class="text-sm text-gray-900">{{ $pelamar->kampus }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Jurusan</label>
                        <p class="text-sm text-gray-900">{{ $pelamar->jurusan }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Telepon</label>
                        <p class="text-sm text-gray-900">{{ $pelamar->no_telp }}</p>
                    </div>
                </div>

                {{-- Kolom 3 --}}
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email</label>
                        <p class="text-sm text-gray-900">{{ $pelamar->email }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Alamat</label>
                        <p class="text-sm text-gray-900">{{ $pelamar->alamat }}</p>
                    </div>
                </div>
            </div>

            {{-- Tanggal Mulai & Selesai --}}
            <div class="mt-8 pt-6 border-t border-gray-200" x-data="{ openMulai: false, openSelesai: false }" x-cloak>
                <h3 class="text-sm font-medium text-gray-900 mb-4">Periode Magang</h3>
                <div class="flex flex-col sm:flex-row gap-3">
                    {{-- Tombol Tanggal Mulai --}}
                    <button @click="openMulai = true"
                            class="inline-flex items-center justify-between px-4 py-3 bg-blue-50 border border-blue-100 rounded-lg text-sm font-medium text-blue-800 hover:bg-blue-100 transition duration-200 w-full sm:w-auto">
                        <span>Tanggal Mulai</span>
                        <span class="ml-2 font-semibold">{{ $pelamar->tanggal_mulai ? \Carbon\Carbon::parse($pelamar->tanggal_mulai)->format('d/m/Y') : '-' }}</span>
                    </button>

                    {{-- Tombol Tanggal Selesai --}}
                    <button @click="openSelesai = true"
                            class="inline-flex items-center justify-between px-4 py-3 bg-green-50 border border-green-100 rounded-lg text-sm font-medium text-green-800 hover:bg-green-100 transition duration-200 w-full sm:w-auto">
                        <span>Tanggal Selesai</span>
                        <span class="ml-2 font-semibold">{{ $pelamar->tanggal_selesai ? \Carbon\Carbon::parse($pelamar->tanggal_selesai)->format('d/m/Y') : '-' }}</span>
                    </button>
                </div>

                {{-- Modal Ubah Tanggal Mulai --}}
                <div x-show="openMulai" 
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full" @click.away="openMulai = false">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Ubah Tanggal Mulai</h3>
                        </div>
                        <form method="POST" action="{{ route('pelamarditolak.updateTanggalMulai', $pelamar->id) }}" class="p-6">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Mulai Baru
                                </label>
                                <input type="date" 
                                       name="tanggal_mulai" 
                                       id="tanggal_mulai"
                                       value="{{ $pelamar->tanggal_mulai }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                       required>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button"
                                        @click="openMulai = false"
                                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                    Batal
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Modal Ubah Tanggal Selesai --}}
                <div x-show="openSelesai" 
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full" @click.away="openSelesai = false">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Ubah Tanggal Selesai</h3>
                        </div>
                        <form method="POST" action="{{ route('pelamarditolak.updateTanggalSelesai', $pelamar->id) }}" class="p-6">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Selesai Baru
                                </label>
                                <input type="date" 
                                       name="tanggal_selesai" 
                                       id="tanggal_selesai"
                                       value="{{ $pelamar->tanggal_selesai }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                       required>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button"
                                        @click="openSelesai = false"
                                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                                    Batal
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 📄 Dokumen Pelamar --}}
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
                    @if ($pelamar->cv)
                        <a href="{{ asset('storage/' . $pelamar->cv) }}" target="_blank"
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
                    @if ($pelamar->transkrip)
                        <a href="{{ asset('storage/' . $pelamar->transkrip) }}" target="_blank"
                           class="inline-flex items-center px-3 py-1.5 bg-purple-50 text-purple-700 text-xs font-medium rounded hover:bg-purple-100 transition duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11 ше 0 3 3 0 016 0z" />
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
                    @if ($pelamar->surat)
                        <a href="{{ asset('storage/' . $pelamar->surat) }}" target="_blank"
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

    {{-- ✅ Aksi Admin --}}
    <div class="bg-white shadow-sm rounded-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Aksi Administrasi</h2>
        </div>
        
        <div class="p-6">
            <div class="flex flex-col sm:flex-row gap-4">
                {{-- Tombol Terima --}}
                <button type="button"
                        onclick="document.getElementById('modal-terima').classList.remove('hidden')"
                        class="inline-flex items-center justify-center px-4 py-3 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200 shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Terima Pelamar
                </button>

                {{-- Tombol Perbaikan --}}
                <button type="button"
                        onclick="document.getElementById('modal-perbaikan').classList.remove('hidden')"
                        class="inline-flex items-center justify-center px-4 py-3 bg-yellow-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200 shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Minta Perbaikan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Terima --}}
<div id="modal-terima" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Terima Pelamar</h3>
            <p class="text-sm text-gray-500 mt-1">Pilih unit kerja dan berikan catatan</p>
        </div>
        <form method="POST" action="{{ route('admin.pelamar.terima', $pelamar->id) }}" class="p-6">
            @csrf
            <div class="mb-4">
                <label for="divisi" class="block text-sm font-medium text-gray-700 mb-2">Unit Kerja</label>
                <select name="divisi" id="divisi"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                        required>
                    <option value="">-- Pilih Unit Kerja --</option>
                    <option value="IT">IT</option>
                    <option value="HRD">HRD</option>
                    <option value="Finance">Finance</option>
                    <option value="Marketing">Marketing</option>
                </select>
            </div>
            <div class="mb-6">
                <label for="catatan_admin" class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin</label>
                <textarea name="catatan_admin" 
                         id="catatan_admin" 
                         rows="3"
                         class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                         placeholder="Berikan catatan untuk pelamar..."></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button"
                        onclick="document.getElementById('modal-terima').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                    Terima Pelamar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Perbaikan --}}
<div id="modal-perbaikan" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Minta Perbaikan</h3>
            <p class="text-sm text-gray-500 mt-1">Berikan alasan untuk perbaikan dokumen</p>
        </div>
        <form action="{{ route('admin.pelamar.perbaikan', $pelamar->id) }}" method="POST" class="p-6">
            @csrf
            <div class="mb-6">
                <label for="alasan_perbaikan" class="block text-sm font-medium text-gray-700 mb-2">
                    Alasan Perbaikan
                </label>
                <textarea name="alasan_perbaikan" 
                         id="alasan_perbaikan" 
                         rows="4"
                         class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"
                         placeholder="Jelaskan bagian mana yang perlu diperbaiki..."
                         required></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button"
                        onclick="document.getElementById('modal-perbaikan').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-yellow-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200">
                    Kirim Permintaan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Tolak --}}
<div id="modal-tolak" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Tolak Pelamar</h3>
            <p class="text-sm text-gray-500 mt-1">Berikan alasan penolakan yang jelas</p>
        </div>
        <form action="{{ route('admin.pelamar.tolak', $pelamar->id) }}" method="POST" class="p-6">
            @csrf
            <div class="mb-6">
                <label for="alasan_penolakan" class="block text-sm font-medium text-gray-700 mb-2">
                    Alasan Penolakan
                </label>
                <textarea name="alasan_penolakan" 
                         id="alasan_penolakan" 
                         rows="4"
                         class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                         placeholder="Jelaskan alasan penolakan..."
                         required></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button"
                        onclick="document.getElementById('modal-tolak').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                    Tolak Pelamar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection