@extends('layouts.magang-layout')

@section('title', 'Data Diri')
@section('page-title', 'Data Diri')

@section('content')
<div class="px-4 py-6 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Data Diri Peserta Magang</h1>
        <p class="text-gray-600 mt-1">Informasi lengkap dan dokumen pendaftaran magang</p>
    </div>

    <!-- Flash Messages -->
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

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Informasi Peserta -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-orange-100">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-900">Informasi Peserta</h2>
                        <button type="button"
                                onclick="showEditDataDiriModal()"
                                class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-200 shadow-sm">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Data Diri
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kolom 1 -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                                <p class="text-sm font-medium text-gray-900">{{ $peserta->nama }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">NIK</label>
                                <p class="text-sm text-gray-700">{{ $peserta->nik }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Instansi Pendidikan</label>
                                <p class="text-sm text-gray-700">{{ $peserta->kampus }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Jurusan</label>
                                <p class="text-sm text-gray-700">{{ $peserta->jurusan }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">No. Telepon</label>
                                <p class="text-sm text-gray-700">{{ $peserta->no_telp }}</p>
                            </div>
                        </div>
                        
                        <!-- Kolom 2 -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">ID Magang</label>
                                <p class="text-sm font-medium text-gray-900">{{ $peserta->id_magang ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Unit Kerja</label>
                                <p class="text-sm text-gray-700">{{ $peserta->divisi ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Status</label>
                                @php
                                    $statusColors = [
                                        'aktif' => 'bg-green-100 text-green-800',
                                        'mundur' => 'bg-red-100 text-red-800',
                                        'lulus' => 'bg-blue-100 text-blue-800',
                                        'selesai' => 'bg-purple-100 text-purple-800'
                                    ];
                                    $statusColor = $statusColors[$peserta->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                    <i class="fas 
                                        @if($peserta->status == 'aktif') fa-check-circle 
                                        @elseif($peserta->status == 'mundur') fa-sign-out-alt 
                                        @elseif($peserta->status == 'lulus') fa-graduation-cap 
                                        @endif mr-1">
                                    </i>
                                    {{ ucfirst($peserta->status) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tanggal Mulai</label>
                                <p class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($peserta->tanggal_mulai)->translatedFormat('d F Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tanggal Selesai</label>
                                <p class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($peserta->tanggal_selesai)->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Alamat -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Alamat</label>
                        <p class="text-sm text-gray-700">{{ $peserta->alamat }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dokumen Pendaftaran -->
        <div>
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Dokumen Pendaftaran</h2>
                    <p class="text-sm text-gray-500 mt-1">Dokumen yang telah diunggah</p>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- CV -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-200">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Curriculum Vitae (CV)</h3>
                                    <p class="text-xs text-gray-500">Dokumen riwayat hidup</p>
                                </div>
                                <div class="bg-blue-100 p-2 rounded-lg">
                                    <i class="fas fa-file-alt text-blue-600"></i>
                                </div>
                            </div>
                            @if($peserta->cv)
                                <a href="{{ Storage::url($peserta->cv) }}" target="_blank"
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded hover:bg-blue-100 transition duration-200">
                                    <i class="fas fa-eye mr-1"></i>
                                    Lihat Dokumen
                                </a>
                            @else
                                <p class="text-sm text-gray-400 italic">Belum diunggah</p>
                            @endif
                        </div>

                        <!-- Transkrip -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-200">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Transkrip Nilai</h3>
                                    <p class="text-xs text-gray-500">Dokumen akademik</p>
                                </div>
                                <div class="bg-green-100 p-2 rounded-lg">
                                    <i class="fas fa-graduation-cap text-green-600"></i>
                                </div>
                            </div>
                            @if($peserta->transkrip)
                                <a href="{{ Storage::url($peserta->transkrip) }}" target="_blank"
                                   class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 text-xs font-medium rounded hover:bg-green-100 transition duration-200">
                                    <i class="fas fa-eye mr-1"></i>
                                    Lihat Dokumen
                                </a>
                            @else
                                <p class="text-sm text-gray-400 italic">Belum diunggah</p>
                            @endif
                        </div>

                        <!-- Surat Pengantar -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-200">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Surat Pengantar</h3>
                                    <p class="text-xs text-gray-500">Surat pengajuan magang</p>
                                </div>
                                <div class="bg-purple-100 p-2 rounded-lg">
                                    <i class="fas fa-envelope text-purple-600"></i>
                                </div>
                            </div>
                            @if($peserta->surat)
                                <a href="{{ Storage::url($peserta->surat) }}" target="_blank"
                                   class="inline-flex items-center px-3 py-1.5 bg-purple-50 text-purple-700 text-xs font-medium rounded hover:bg-purple-100 transition duration-200">
                                    <i class="fas fa-eye mr-1"></i>
                                    Lihat Dokumen
                                </a>
                            @else
                                <p class="text-sm text-gray-400 italic">Belum diunggah</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Tambah Pendidikan -->
            <div class="mt-6">
                <button type="button"
                        onclick="document.getElementById('modal-pendidikan').classList.remove('hidden')"
                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 shadow-sm">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Tambah Pendidikan
                </button>
            </div>
        </div>
    </div>

    <!-- Tombol Permohonan Magang Kembali (Hanya untuk mundur/lulus) -->
    @if(in_array($peserta->status, ['mundur', 'lulus']))
        @php
            $permohonanPending = $permohonans->where('jenis_permohonan', 'permohonanmagangkembali')
                                            ->where('status', 'pending')
                                            ->first();
            $permohonanDitolak = $permohonans->where('jenis_permohonan', 'permohonanmagangkembali')
                                            ->where('status', 'ditolak')
                                            ->first();
        @endphp

        <div class="mt-8" x-data="{ showPermohonanMagangKembali: false }">
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-redo-alt text-yellow-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Permohonan Magang Kembali</h2>
                        <p class="text-sm text-gray-600 mt-1">
                            @if($peserta->status == 'mundur')
                                Ajukan permohonan untuk bergabung kembali
                            @else
                                Ajukan permohonan untuk magang kembali
                            @endif
                        </p>
                    </div>
                </div>
                
                <!-- Status Message -->
                @if($permohonanPending)
                    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock text-blue-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-blue-800">Permohonan Sedang Diproses</p>
                                <p class="text-sm text-blue-700 mt-1">Silakan tunggu konfirmasi dari admin.</p>
                            </div>
                        </div>
                    </div>
                @elseif($permohonanDitolak)
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-times-circle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">Permohonan Ditolak</p>
                                @if($permohonanDitolak->alasan)
                                    <p class="text-sm text-red-700 mt-1">{{ $permohonanDitolak->alasan }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Tombol Ajukan/Edit -->
                <button type="button"
                    @click="showPermohonanMagangKembali = true"
                    class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 border border-transparent rounded-lg text-sm font-medium text-white hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200 shadow-sm">
                    <i class="fas fa-redo-alt mr-2"></i>
                    {{ $permohonanPending ? 'Edit Permohonan' : 'Ajukan Permohonan Magang Kembali' }}
                </button>
            </div>

            <!-- Modal Permohonan Magang Kembali -->
            <div x-show="showPermohonanMagangKembali"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4"
                 @click.self="showPermohonanMagangKembali = false">
                 
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">{{ $permohonanPending ? 'Edit Permohonan' : 'Ajukan Permohonan Magang Kembali' }}</h3>
                    </div>
                    
                    <form action="{{ route('magang.periode.permohonanmagangkembali') }}" method="POST" class="p-6" enctype="multipart/form-data">
                        @csrf
                        @if($permohonanPending)
                            @method('PUT')
                            <input type="hidden" name="permohonan_id" value="{{ $permohonanPending->id }}">
                        @endif

                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai *</label>
                                    <input type="date" name="tanggal_mulai" required
                                           value="{{ $permohonanPending->tanggal_mulai ?? ($permohonanDitolak->tanggal_mulai ?? '') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai *</label>
                                    <input type="date" name="tanggal_selesai" required
                                           value="{{ $permohonanPending->tanggal_selesai ?? ($permohonanDitolak->tanggal_selesai ?? '') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan (Opsional)</label>
                                <textarea name="alasan" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                          placeholder="Mengapa Anda ingin magang kembali?">{{ $permohonanPending->alasan ?? ($permohonanDitolak->alasan ?? '') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Upload Surat Permohonan
                                    @if(!$permohonanPending) * @endif
                                </label>
                                <input type="file" name="surat" 
                                       @if(!$permohonanPending) required @endif
                                       accept=".pdf,.doc,.docx"
                                       class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                <p class="text-xs text-gray-500 mt-1">
                                    Format: PDF, DOC, DOCX (Maksimal 2MB)
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button"
                                    @click="showPermohonanMagangKembali = false"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                                @if($permohonanPending)
                                    <i class="fas fa-save mr-1"></i>Update Permohonan
                                @else
                                    <i class="fas fa-paper-plane mr-1"></i>Kirim Permohonan
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Tombol untuk Peserta Aktif -->
    @if($peserta->status == 'aktif')
        @php
            $permohonanPending = \App\Models\PermohonanPeriode::where('peserta_id', $peserta->id)
                ->where('status', 'pending')
                ->exists();
        @endphp

        <div class="mt-8" x-data="{ showMainModal: false, showPercepat: false, showTambah: false, showMundur: false }">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-file-contract text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Permohonan Periode</h2>
                        <p class="text-sm text-gray-600 mt-1">Ajukan perubahan periode magang</p>
                    </div>
                </div>

                @if($permohonanPending)
                    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock text-yellow-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-yellow-800">Permohonan Sedang Diproses</p>
                                <p class="text-sm text-yellow-700 mt-1">Tunggu hingga permohonan sebelumnya diproses.</p>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" disabled
                            class="w-full inline-flex items-center justify-center px-6 py-3 bg-gray-300 border border-transparent rounded-lg text-sm font-medium text-gray-500 cursor-not-allowed">
                        <i class="fas fa-clock mr-2"></i>
                        Ajukan Permohonan Periode
                    </button>
                @else
                    <button type="button"
                            @click="showMainModal = true"
                            class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 shadow-sm">
                        <i class="fas fa-file-alt mr-2"></i>
                        Ajukan Permohonan Periode
                    </button>
                @endif
            </div>

            <!-- Modal Pilihan Jenis Permohonan -->
            <div x-show="showMainModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4"
                 @click.self="showMainModal = false">
                 
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Pilih Jenis Permohonan</h3>
                    </div>
                    
                    <div class="p-6 space-y-3">
                        <button type="button"
                                @click="showMainModal = false; showPercepat = true"
                                class="w-full flex items-center justify-between p-4 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition duration-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-rocket text-red-600"></i>
                                </div>
                                <div class="text-left">
                                    <p class="font-medium text-gray-900">Percepatan Magang</p>
                                    <p class="text-sm text-gray-500">Selesaikan magang lebih cepat</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </button>

                        <button type="button"
                                @click="showMainModal = false; showTambah = true"
                                class="w-full flex items-center justify-between p-4 bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg transition duration-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar-plus text-green-600"></i>
                                </div>
                                <div class="text-left">
                                    <p class="font-medium text-gray-900">Tambah Periode</p>
                                    <p class="text-sm text-gray-500">Perpanjang masa magang</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </button>

                        <button type="button"
                                @click="showMainModal = false; showMundur = true"
                                class="w-full flex items-center justify-between p-4 bg-orange-50 hover:bg-orange-100 border border-orange-200 rounded-lg transition duration-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-sign-out-alt text-orange-600"></i>
                                </div>
                                <div class="text-left">
                                    <p class="font-medium text-gray-900">Pengunduran Diri</p>
                                    <p class="text-sm text-gray-500">Ajukan pengunduran diri</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </button>
                    </div>
                    
                    <div class="px-6 py-4 border-t border-gray-200">
                        <button type="button"
                                @click="showMainModal = false"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            Batal
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Percepatan -->
            <div x-show="showPercepat"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4"
                 @click.self="showPercepat = false">
                 
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Ajukan Percepatan Magang</h3>
                    </div>
                    
                    <form action="{{ route('magang.periode.percepat') }}" method="POST" class="p-6" enctype="multipart/form-data">
                        @csrf
                        @if($periodeAktif)
                            <input type="hidden" name="periode_id" value="{{ $periodeAktif->id }}">
                        @endif

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai Baru *</label>
                                <input type="date" name="tanggal_selesai" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                                @if($periodeAktif)
                                    <p class="text-xs text-gray-500 mt-1">
                                        Tanggal selesai saat ini: {{ \Carbon\Carbon::parse($periodeAktif->tanggal_selesai)->format('d/m/Y') }}
                                    </p>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan *</label>
                                <textarea name="alasan" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                          placeholder="Jelaskan alasan percepatan magang..."></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Surat (Opsional)</label>
                                <input type="file" name="surat" accept=".pdf"
                                       class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                <p class="text-xs text-gray-500 mt-1">Format: PDF (Maksimal 2MB)</p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button"
                                    @click="showPercepat = false"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                                Kirim Permohonan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Tambah Periode -->
            <div x-show="showTambah"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4"
                 @click.self="showTambah = false">
                 
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Ajukan Tambah Periode</h3>
                    </div>
                    
                    <form action="{{ route('magang.periode.tambah') }}" method="POST" class="p-6" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan *</label>
                                <textarea name="alasan" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                          placeholder="Jelaskan alasan penambahan periode..."></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai *</label>
                                    <input type="date" name="tanggal_mulai" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai *</label>
                                    <input type="date" name="tanggal_selesai" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Surat (Opsional)</label>
                                <input type="file" name="surat" accept=".pdf"
                                       class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                <p class="text-xs text-gray-500 mt-1">Format: PDF (Maksimal 2MB)</p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button"
                                    @click="showTambah = false"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                                Kirim Permohonan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Pengunduran Diri -->
            <div x-show="showMundur"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4"
                 @click.self="showMundur = false">
                 
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Ajukan Pengunduran Diri</h3>
                    </div>
                    
                    <form action="{{ route('magang.periode.mundur') }}" method="POST" class="p-6" enctype="multipart/form-data">
                        @csrf
                        @if($periodeAktif)
                            <input type="hidden" name="periode_id" value="{{ $periodeAktif->id }}">
                        @endif

                        <div class="space-y-4">
                            <div class="p-4 bg-orange-50 border border-orange-200 rounded-lg">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle text-orange-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-orange-800">Perhatian!</p>
                                        <p class="text-sm text-orange-700 mt-1">
                                            Pengunduran diri akan mengakhiri seluruh aktivitas magang Anda.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Pengunduran Diri *</label>
                                <textarea name="alasan" rows="4" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm"
                                          placeholder="Jelaskan alasan pengunduran diri..."></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Surat (Opsional)</label>
                                <input type="file" name="surat" accept=".pdf"
                                       class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                                <p class="text-xs text-gray-500 mt-1">Format: PDF (Maksimal 2MB)</p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button"
                                    @click="showMundur = false"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-200">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-orange-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-200">
                                Kirim Pengunduran Diri
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Riwayat Permohonan -->
    <div class="mt-8">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Riwayat Permohonan Periode</h2>
                <p class="text-sm text-gray-500 mt-1">Daftar permohonan yang telah diajukan</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                            <th scope="col" class="px 6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($permohonans as $p)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @switch($p->jenis_permohonan)
                                        @case('tambah')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-calendar-plus mr-1"></i>
                                                Tambah Periode
                                            </span>
                                            @break
                                        @case('percepat')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-rocket mr-1"></i>
                                                Percepatan
                                            </span>
                                            @break
                                        @case('mundur')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                <i class="fas fa-sign-out-alt mr-1"></i>
                                                Pengunduran Diri
                                            </span>
                                            @break
                                        @case('permohonanmagangkembali')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-redo-alt mr-1"></i>
                                                Magang Kembali
                                            </span>
                                            @break
                                        @default
                                            <span class="text-gray-500">-</span>
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ Str::limit($p->alasan, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $p->tanggal_pengajuan?->translatedFormat('d F Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($p->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Pending
                                        </span>
                                    @elseif($p->status === 'disetujui')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Disetujui
                                        </span>
                                    @elseif($p->status === 'ditolak')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($p->status === 'pending')
                                        <div class="flex space-x-2">
                                            <button onclick="showModal{{ $p->id }}()"
                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                                <i class="fas fa-edit mr-1"></i>
                                                Edit
                                            </button>
                                            <button onclick="confirmBatalkan({{ $p->id }}, '{{ $p->jenis_permohonan }}')"
                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                                                <i class="fas fa-times mr-1"></i>
                                                Batalkan
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-file-alt text-gray-400 text-3xl mb-2"></i>
                                        <p>Belum ada permohonan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Data Diri -->
<div id="modal-edit-data-diri" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Edit Data Diri</h3>
        </div>
        
        <form action="{{ route('magang.data-diri.update', $peserta->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                    <input type="text" name="nama" value="{{ $peserta->nama }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK *</label>
                    <input type="text" name="nik" value="{{ $peserta->nik }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instansi Pendidikan *</label>
                    <input type="text" name="kampus" value="{{ $peserta->kampus }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan *</label>
                    <input type="text" name="jurusan" value="{{ $peserta->jurusan }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon *</label>
                    <input type="text" name="no_telp" value="{{ $peserta->no_telp }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai *</label>
                    <input type="date" name="tanggal_mulai" value="{{ $peserta->tanggal_mulai }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai *</label>
                    <input type="date" name="tanggal_selesai" value="{{ $peserta->tanggal_selesai }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat *</label>
                <textarea name="alamat" rows="3" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">{{ $peserta->alamat }}</textarea>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button"
                        onclick="hideEditDataDiriModal()"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-200">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-orange-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Pendidikan -->
<div id="modal-pendidikan" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Tambah Pendidikan</h3>
        </div>
        
        <form action="{{ route('magang.data-diri.tambahPendidikan', $peserta->id) }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Instansi Pendidikan *</label>
                <input type="text" name="pendidikan_baru" placeholder="Contoh: Universitas Indonesia" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button"
                        onclick="document.getElementById('modal-pendidikan').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    Simpan Pendidikan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Permohonan -->
@foreach($permohonans as $p)
    @if($p->status === 'pending')
        <div id="modal-{{ $p->id }}" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Edit Permohonan</h3>
                </div>
                
                <form action="{{ route('magang.permohonan.update', $p->id) }}" method="POST" class="p-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Permohonan *</label>
                            <textarea name="alasan" rows="4" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ $p->alasan }}</textarea>
                        </div>

                        @if(in_array($p->jenis_permohonan, ['tambah', 'percepat', 'permohonanmagangkembali']))
                            <div class="grid grid-cols-2 gap-4">
                                @if($p->jenis_permohonan === 'tambah' || $p->jenis_permohonan === 'permohonanmagangkembali')
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai *</label>
                                        <input type="date" name="tanggal_mulai" value="{{ $p->tanggal_mulai }}" required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    </div>
                                @endif
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai *</label>
                                    <input type="date" name="tanggal_selesai" value="{{ $p->tanggal_selesai }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Surat Baru (Opsional)</label>
                            <input type="file" name="surat" accept=".pdf"
                                   class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">Format: PDF (Maksimal 2MB)</p>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200 flex justify-end space-x-3">
                        <button type="button"
                                onclick="hideModal{{ $p->id }}()"
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

        <!-- Form untuk Batalkan -->
        <form id="form-batalkan-{{ $p->id }}" action="{{ route('magang.permohonan.batalkan', $p->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endforeach

<script>
// Fungsi untuk modal edit data diri
function showEditDataDiriModal() {
    document.getElementById('modal-edit-data-diri').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function hideEditDataDiriModal() {
    document.getElementById('modal-edit-data-diri').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Fungsi untuk modal edit permohonan
@foreach($permohonans as $p)
    @if($p->status === 'pending')
        function showModal{{ $p->id }}() {
            document.getElementById('modal-{{ $p->id }}').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function hideModal{{ $p->id }}() {
            document.getElementById('modal-{{ $p->id }}').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    @endif
@endforeach

// Konfirmasi batalkan permohonan
function confirmBatalkan(id, jenis) {
    const jenisText = {
        'tambah': 'Tambah Periode',
        'percepat': 'Percepatan', 
        'mundur': 'Pengunduran Diri',
        'permohonanmagangkembali': 'Magang Kembali'
    }[jenis] || jenis;

    if (confirm(`Anda yakin ingin membatalkan permohonan "${jenisText}"? Tindakan ini tidak dapat dibatalkan!`)) {
        document.getElementById(`form-batalkan-${id}`).submit();
    }
}

// Close modal dengan ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        hideEditDataDiriModal();
        @foreach($permohonans as $p)
            @if($p->status === 'pending')
                hideModal{{ $p->id }}();
            @endif
        @endforeach
        document.getElementById('modal-pendidikan').classList.add('hidden');
    }
});
</script>

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@if(!$periodeAktif && $peserta->status == 'aktif')
    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-500"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800">Belum ada periode terdaftar</p>
                <p class="text-sm text-red-700 mt-1">Hubungi admin jika ini keliru.</p>
            </div>
        </div>
    </div>
@endif
@endsection