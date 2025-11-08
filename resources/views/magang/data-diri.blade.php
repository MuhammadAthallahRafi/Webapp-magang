@extends('layouts.magang-layout')

@section('title', 'Data Diri')
@section('page-title', 'Data Diri')

@section('content')
<div class="space-y-6">

    <!-- Informasi Peserta -->
<div class="bg-white p-6 rounded shadow">
    
    <div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Informasi Peserta Magang</h2>
        <button type="button"
                onclick="showEditDataDiriModal()"
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition font-medium flex items-center gap-2 text-sm">
            ✏️ Edit Data Diri
        </button>
    </div>
    
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div><strong>Nama:</strong> <span class="text-gray-600">{{ $peserta->nama }}</span></div>
        <div><strong>ID Magang:</strong> <span class="text-gray-600">{{ $peserta->id_magang ?? '-' }}</span></div>
        <div><strong>Unit Kerja:</strong> <span class="text-gray-600">{{ $peserta->divisi ?? '-' }}</span></div>
        <div><strong>NIK:</strong> <span class="text-gray-600">{{ $peserta->nik }}</span></div>
        <div><strong>Status:</strong> 
            <span class="
                px-2 py-1 rounded-full text-xs font-semibold
                @if($peserta->status == 'aktif') bg-green-100 text-green-800
                @elseif($peserta->status == 'mundur') bg-red-100 text-red-800
                @elseif($peserta->status == 'lulus') bg-blue-100 text-blue-800
                @endif
            ">
                {{ ucfirst($peserta->status) }}
            </span>
        </div>
        <div><strong>Instansi Pendidikan:</strong> <span class="text-gray-600">{{ $peserta->kampus }}</span></div>
        <div><strong>Jurusan:</strong> <span class="text-gray-600">{{ $peserta->jurusan }}</span></div>
        <div><strong>Tanggal Mulai:</strong> <span class="text-gray-600">{{ $peserta->tanggal_mulai }}</span></div>
        <div><strong>Tanggal Selesai:</strong> <span class="text-gray-600">{{ $peserta->tanggal_selesai }}</span></div>         
        <div><strong>No. Telepon:</strong> <span class="text-gray-600">{{ $peserta->no_telp }}</span></div>
        <div class="col-span-2"><strong>Alamat:</strong> <span class="text-gray-600">{{ $peserta->alamat }}</span></div>
    </div>

    <!-- Dokumen Pendaftaran -->
    <div class="mt-4 pt-4 border-t">
        <h3 class="font-semibold mb-3 text-sm">Dokumen</h3>
        
        <div class="flex gap-3">
            <!-- CV -->
            <div class="text-center">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-1">
                    <span class="text-blue-600 text-sm">📄</span>
                </div>
                <div class="text-xs font-medium text-gray-700 mb-1">CV</div>
                @if($peserta->cv)
                    <a href="{{ Storage::url($peserta->cv) }}" 
                       target="_blank"
                       class="text-blue-600 hover:text-blue-800 text-xs underline">
                        Lihat
                    </a>
                @else
                    <p class="text-gray-400 text-xs">-</p>
                @endif
            </div>

            <!-- Transkrip -->
            <div class="text-center">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-1">
                    <span class="text-green-600 text-sm">🎓</span>
                </div>
                <div class="text-xs font-medium text-gray-700 mb-1">Transkrip</div>
                @if($peserta->transkrip)
                    <a href="{{ Storage::url($peserta->transkrip) }}" 
                       target="_blank"
                       class="text-blue-600 hover:text-blue-800 text-xs underline">
                        Lihat
                    </a>
                @else
                    <p class="text-gray-400 text-xs">-</p>
                @endif
            </div>

            <!-- Surat Pengantar -->
            <div class="text-center">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-1">
                    <span class="text-purple-600 text-sm">📝</span>
                </div>
                <div class="text-xs font-medium text-gray-700 mb-1">Surat</div>
                @if($peserta->surat)
                    <a href="{{ Storage::url($peserta->surat) }}" 
                       target="_blank"
                       class="text-blue-600 hover:text-blue-800 text-xs underline">
                        Lihat
                    </a>
                @else
                    <p class="text-gray-400 text-xs">-</p>
                @endif
            </div>
        </div>
    </div>

   <div>
    <!-- Tombol Tambah Pendidikan -->
    <button type="button"
        onclick="document.getElementById('modal-pendidikan-{{ $peserta->id }}').classList.remove('hidden')"
        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
        + Tambah Pendidikan
    </button>

    <!-- Modal Overlay -->
    <div id="modal-pendidikan-{{ $peserta->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <!-- Modal Content -->
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 hover:scale-100">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">Tambah Pendidikan</h3>
                    <button type="button" 
                            onclick="document.getElementById('modal-pendidikan-{{ $peserta->id }}').classList.add('hidden')"
                            class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-4">
                <form action="{{ route('magang.data-diri.tambahPendidikan', $peserta->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Instansi Pendidikan *</label>
                            <input type="text" name="kampus" value="{{ old('kampus', $peserta->kampus) }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none">
                        </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 pt-4 mt-6 border-t border-gray-200">
                        <button type="button"
                                onclick="document.getElementById('modal-pendidikan-{{ $peserta->id }}').classList.add('hidden')"
                                class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all duration-200 border border-gray-300">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition-all duration-200 shadow-md hover:shadow-lg">
                            Simpan Pendidikan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal Edit Data Diri -->
<div id="modal-edit-data-diri" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    ✏️ Edit Data Diri
                </h2>
                <button onclick="hideEditDataDiriModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                    ×
                </button>
            </div>

            <form action="{{ route('magang.data-diri.update', $peserta->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                        <input type="text" name="nama" value="{{ $peserta->nama }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>

                    <!-- NIK -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">NIK *</label>
                        <input type="text" name="nik" value="{{ $peserta->nik }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>

                    <!-- Instansi Pendidikan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Instansi Pendidikan *</label>
                        <input type="text" name="kampus" value="{{ $peserta->kampus }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>

                    <!-- Jurusan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jurusan *</label>
                        <input type="text" name="jurusan" value="{{ $peserta->jurusan }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>

                    <!-- No. Telepon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon *</label>
                        <input type="text" name="no_telp" value="{{ $peserta->no_telp }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>

                    <!-- Tanggal Mulai -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai *</label>
                        <input type="date" name="tanggal_mulai" value="{{ $peserta->tanggal_mulai }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai *</label>
                        <input type="date" name="tanggal_selesai" value="{{ $peserta->tanggal_selesai }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat *</label>
                    <textarea name="alamat" rows="3" required
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
                              placeholder="Masukkan alamat lengkap...">{{ $peserta->alamat }}</textarea>
                </div>

                <!-- Informasi -->
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center gap-2">
                        <span class="text-blue-600">ℹ️</span>
                        <p class="text-sm text-blue-700">
                            Field yang bertanda <strong>*</strong> wajib diisi. 
                            Perubahan akan langsung tersimpan di database.
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button" 
                            onclick="hideEditDataDiriModal()"
                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-6 py-2 bg-green-600 text-gray rounded-lg hover:bg-green-700 transition font-medium flex items-center gap-2">
                        💾 Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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

// Close modal ketika klik di luar
document.addEventListener('click', function(event) {
    if (event.target.id === 'modal-edit-data-diri') {
        hideEditDataDiriModal();
    }
});

// Close modal dengan ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        hideEditDataDiriModal();
    }
});
</script>

 <!-- ===== TOMBOL PERMOHONAN MAGANG KEMBALI (HANYA UNTUK MUNDUR/LULUS) ===== -->
@if(in_array($peserta->status, ['mundur', 'lulus']))
@php
    // FILTER PERMOHONAN: hanya ambil yang pending untuk tombol Edit
    $permohonanPending = $permohonans->where('jenis_permohonan', 'permohonanmagangkembali')
                                    ->where('status', 'pending')
                                    ->first();
    
    // Cek apakah ada permohonan ditolak untuk tampilkan status
    $permohonanDitolak = $permohonans->where('jenis_permohonan', 'permohonanmagangkembali')
                                    ->where('status', 'ditolak')
                                    ->first();
@endphp

<div x-data="{ showpermohonanMagangKembali: false }" class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
    <h2 class="text-lg font-semibold mb-3 text-yellow-800">🔄 Permohonan Magang Kembali</h2>
    
    {{-- Status Message -- HANYA TAMPILKAN UNTUK PENDING DAN DITOLAK --}}
    @if($permohonanPending)
        <div class="mb-4 p-4 rounded border bg-blue-50 border-blue-200">
            <p class="text-blue-700">
                ⏳ <strong>Permohonan Sedang Diproses</strong><br>
                Silakan tunggu konfirmasi dari admin.
            </p>
        </div>
    @elseif($permohonanDitolak)
        <div class="mb-4 p-4 rounded border bg-red-50 border-red-200">
            <p class="text-red-700">
                ❌ <strong>Permohonan Ditolak</strong><br>
                @if($permohonanDitolak->alasan)
                    <strong>Alasan:</strong> {{ $permohonanDitolak->alasan }}
                @else
                    Kamu bisa mengajukan ulang dengan data yang diperbaiki.
                @endif
            </p>
        </div>
    @else
        {{-- Untuk yang belum ada permohonan atau yang sudah disetujui --}}
        <p class="text-gray-600 mb-4">
            @if($peserta->status == 'mundur')
                Kamu telah mengundurkan diri. Ajukan permohonan magang kembali untuk dapat bergabung lagi.
            @else
                Kamu telah lulus. Ajukan permohonan magang kembali jika ingin bergabung lagi.
            @endif
        </p>
    @endif

    {{-- Tombol Ajukan/Edit --}}
    <button type="button"
        @click="showpermohonanMagangKembali = true"
        class="w-full px-4 py-3 bg-gradient-to-r from-green-400 to-green-500 hover:from-green-500 hover:to-green-600 
            text-gray font-semibold text-lg rounded-lg shadow-md transition-all duration-200 flex items-center justify-center gap-2">
        <span class="text-xl">🔄</span> 
        {{ $permohonanPending ? 'Edit Permohonan' : 'Ajukan Permohonan Magang Kembali' }}
    </button>

    <!-- Modal Permohonan Magang Kembali -->
    <div x-show="showpermohonanMagangKembali"
        x-cloak
        x-transition.opacity
        @click.self="showpermohonanMagangKembali = false"
        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 backdrop-blur-sm">

        <div class="bg-white p-6 rounded-2xl shadow-xl w-[32rem] transform transition-all duration-300 scale-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4 text-center border-b pb-2">
                {{ $permohonanPending ? 'Edit Permohonan' : 'Ajukan Permohonan Magang Kembali' }}
            </h2>

            <form action="{{ route('magang.periode.permohonanmagangkembali') }}" method="POST" 
                  class="space-y-4" enctype="multipart/form-data"
                  onsubmit="return confirm('Yakin ingin {{ $permohonanPending ? 'mengedit' : 'mengajukan' }} permohonan magang kembali?')">
                @csrf
                
                @if($permohonanPending)
                    @method('PUT')
                    <input type="hidden" name="permohonan_id" value="{{ $permohonanPending->id }}">
                @endif

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai *</label>
                        <input type="date" name="tanggal_mulai" required
                            min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}"
                            value="{{ $permohonanPending->tanggal_mulai ?? ($permohonanDitolak->tanggal_mulai ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-300 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai *</label>
                        <input type="date" name="tanggal_selesai" required
                            value="{{ $permohonanPending->tanggal_selesai ?? ($permohonanDitolak->tanggal_selesai ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-300 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan (Opsional)</label>
                    <textarea name="alasan" rows="3" 
                        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-300 focus:outline-none"
                        placeholder="Mengapa kamu ingin magang kembali?">{{ $permohonanPending->alasan ?? ($permohonanDitolak->alasan ?? '') }}</textarea>
                </div>

                <!-- FIELD SURAT -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Upload Surat Permohonan 
                        @if(!$permohonanPending) * @endif
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <input type="file" name="surat" 
                            @if(!$permohonanPending) required @endif
                            accept=".pdf,.doc,.docx"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        <p class="text-xs text-gray-500 mt-2">
                            Format: PDF, DOC, DOCX (Maksimal 2MB)<br>
                            @if(($permohonanPending || $permohonanDitolak) && ($permohonanPending->surat ?? $permohonanDitolak->surat))
                                <strong>Surat saat ini:</strong> 
                                <a href="{{ asset('storage/' . ($permohonanPending->surat ?? $permohonanDitolak->surat)) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                    Lihat Surat
                                </a><br>
                                Kosongkan jika tidak ingin mengganti surat.
                            @else
                                Surat harus bermaterai dan ditandatangani
                            @endif
                        </p>
                    </div>
                    @error('surat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                    <p class="text-yellow-700 text-sm">
                        📝 <strong>Perhatian:</strong> 
                        @if($permohonanPending)
                            Mengedit permohonan akan mengubah status menjadi "pending" kembali.
                        @else
                            Permohonan magang kembali wajib melampirkan surat resmi yang ditandatangani.
                        @endif
                    </p>
                </div>

                <div class="flex justify-end gap-2 pt-4 border-t">
                    <button type="button"
                        @click="showpermohonanMagangKembali = false"
                        class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-100 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-green-500 text-gray hover:bg-green-600 shadow-md transition">
                        @if($permohonanPending)
                            ✏️ Update Permohonan
                        @else
                            📄 Kirim Permohonan
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formMagangKembali');
    
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            try {
                const response = await fetch('{{ route('magang.check-pending-permohonan') }}');
                const data = await response.json();
                
                if (data.hasPending) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Permohonan Sedang Diproses',
                        text: 'Kamu masih memiliki permohonan magang kembali yang sedang diproses. Tunggu sampai selesai sebelum mengajukan lagi.',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }
                
                // Submit form jika tidak ada pending
                form.submit();
                
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Silakan coba lagi.',
                    confirmButtonText: 'OK'
                });
            }
        });
    }
});
</script>

<!-- ===== TOMBOL UNTUK PESERTA AKTIF ===== -->
@if($peserta->status == 'aktif')
    @php
        // Cek apakah ada permohonan yang masih pending
        $permohonanPending = \App\Models\PermohonanPeriode::where('peserta_id', $peserta->id)
            ->where('status', 'pending')
            ->exists();
    @endphp

    @if($permohonanPending)
        <!-- NOTIFIKASI JIKA ADA PERMOHONAN PENDING -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0">
                    <span class="text-yellow-600 text-xl">⏳</span>
                </div>
                <div class="flex-1">
                    <h3 class="text-yellow-800 font-semibold">Permohonan Sedang Diproses</h3>
                    <p class="text-yellow-700 text-sm mt-1">
                        Anda memiliki permohonan yang sedang dalam proses review. 
                        Silakan tunggu hingga permohonan sebelumnya selesai diproses 
                        sebelum mengajukan permohonan baru.
                    </p>
                </div>
            </div>
        </div>

        <!-- TOMBOL DINONAKTIFKAN -->
        <div class="bg-gray-100 p-4 rounded-lg border border-gray-200">
            <button type="button"
                    disabled
                    class="w-full px-4 py-3 bg-gray-300 text-gray-500 rounded-lg shadow font-semibold text-lg flex items-center justify-center gap-2 cursor-not-allowed">
                ⏳ Ajukan Permohonan Periode
            </button>
            <p class="text-gray-500 text-sm text-center mt-2">
                Tombol dinonaktifkan sementara menunggu permohonan sebelumnya diproses
            </p>
        </div>
    @else
        <!-- TOMBOL AKTIF JIKA TIDAK ADA PENDING -->
        <div x-data="{ showMainModal: false, showPercepat: false, showTambah: false, showMundur: false }" class="space-y-4">

            <!-- Tombol Utama -->
            <div class="bg-white p-4 rounded shadow">
                <button type="button"
                        @click="showMainModal = true"
                        class="w-full px-4 py-3 bg-blue-100 hover:bg-blue-200 rounded-lg shadow font-semibold text-lg flex items-center justify-center gap-2 transition-all duration-200">
                    📝 Ajukan Permohonan Periode
                </button>
            </div>

            <!-- Modal Utama (Pilihan Jenis Permohonan) -->
            <div x-show="showMainModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white p-5 rounded shadow-md w-[28rem] mx-4">
                    <h2 class="text-lg font-bold mb-4 text-center">Pilih Jenis Permohonan</h2>
                    
                    <div class="space-y-3">
                        <!-- Pilihan Percepatan -->
                        <button type="button"
                                @click="showMainModal = false; showPercepat = true"
                                class="w-full px-4 py-3 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg flex items-center justify-between transition">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">🚀</span>
                                <div class="text-left">
                                    <div class="font-semibold text-red-700">Percepatan Magang</div>
                                    <div class="text-xs text-red-600">Selesaikan magang lebih cepat</div>
                                </div>
                            </div>
                            <span class="text-red-500">→</span>
                        </button>

                        <!-- Pilihan Tambah Periode -->
                        <button type="button"
                                @click="showMainModal = false; showTambah = true"
                                class="w-full px-4 py-3 bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg flex items-center justify-between transition">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">➕</span>
                                <div class="text-left">
                                    <div class="font-semibold text-green-700">Tambah Periode</div>
                                    <div class="text-xs text-green-600">Perpanjang masa magang</div>
                                </div>
                            </div>
                            <span class="text-green-500">→</span>
                        </button>

                        <!-- Pilihan Mundur -->
                        <button type="button"
                                @click="showMainModal = false; showMundur = true"
                                class="w-full px-4 py-3 bg-orange-50 hover:bg-orange-100 border border-orange-200 rounded-lg flex items-center justify-between transition">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">🚪</span>
                                <div class="text-left">
                                    <div class="font-semibold text-orange-700">Mundur</div>
                                    <div class="text-xs text-orange-600">Ajukan pengunduran diri</div>
                                </div>
                            </div>
                            <span class="text-orange-500">→</span>
                        </button>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="button" @click="showMainModal = false"
                                class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100 transition">
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
                 class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white p-5 rounded shadow-md w-[28rem] mx-4">
                    <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                        🚀 Ajukan Percepatan Magang
                    </h2>
                    <form action="{{ route('magang.periode.percepat') }}" method="POST" enctype="multipart/form-data" 
                          x-data="percepatanForm()" @submit="validatePercepatan">
                        @csrf
                        @if($periodeAktif)
                            <input type="hidden" name="periode_id" value="{{ $periodeAktif->id }}">
                            <input type="hidden" id="tanggal_selesai_sekarang" value="{{ $periodeAktif->tanggal_selesai }}">
                        @endif

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700">Tanggal Selesai Baru *</label>
                            <input type="date" 
                                   name="tanggal_selesai" 
                                   x-model="tanggalSelesai"
                                   @change="validateTanggalPercepatan()"
                                   :class="{
                                       'border-red-300': errors.tanggalSelesai,
                                       'border-green-300': isValid.tanggalSelesai,
                                       'border-gray-300': !errors.tanggalSelesai && !isValid.tanggalSelesai
                                   }"
                                   required 
                                   class="w-full border rounded p-2 focus:ring-2 focus:ring-red-300 transition-colors">
                            
                            <!-- Error Message -->
                            <template x-if="errors.tanggalSelesai">
                                <p class="text-red-500 text-xs mt-1" x-text="errors.tanggalSelesai"></p>
                            </template>
                            
                            <!-- Success Message -->
                            <template x-if="isValid.tanggalSelesai">
                                <p class="text-green-500 text-xs mt-1" x-text="isValid.tanggalSelesai"></p>
                            </template>

                            <!-- Info Tanggal Saat Ini -->
                            <div class="mt-2 p-2 bg-blue-50 rounded text-xs text-blue-700">
                                <strong>Info:</strong> Tanggal selesai periode saat ini: 
                                <span class="font-semibold">{{ $periodeAktif->tanggal_selesai ?? 'Tidak tersedia' }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700">Alasan *</label>
                            <textarea name="alasan" 
                                      rows="3" 
                                      x-model="alasan"
                                      @input="validateAlasan()"
                                      :class="{
                                          'border-red-300': errors.alasan,
                                          'border-green-300': isValid.alasan,
                                          'border-gray-300': !errors.alasan && !isValid.alasan
                                      }"
                                      required 
                                      class="w-full border rounded p-2 focus:ring-2 focus:ring-red-300 transition-colors"
                                      placeholder="Jelaskan alasan percepatan magang..."></textarea>
                            
                            <template x-if="errors.alasan">
                                <p class="text-red-500 text-xs mt-1" x-text="errors.alasan"></p>
                            </template>
                            
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>Minimal 10 karakter</span>
                                <span x-text="`${alasan.length}/500`"></span>
                            </div>
                        </div>
                        
                        {{-- Input Upload Surat --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                📎 Upload Surat Permohonan (Opsional)
                            </label>
                            <input type="file" 
                                   name="surat" 
                                   @change="validateSurat($el)"
                                   accept=".pdf"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                            
                            <template x-if="errors.surat">
                                <p class="text-red-500 text-xs mt-1" x-text="errors.surat"></p>
                            </template>
                            
                            <p class="text-xs text-gray-500 mt-1">
                                Format: PDF saja (Maks: 2MB)
                            </p>
                        </div>

                        <div class="flex justify-end mt-4 gap-2">
                            <button type="button" @click="showPercepat = false"
                                    class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100 transition">
                                Batal
                            </button>
                            <button type="submit"
                                    :disabled="!formValid"
                                    :class="{
                                        'bg-red-500 hover:bg-red-600': formValid,
                                        'bg-red-300 cursor-not-allowed': !formValid
                                    }"
                                    class="px-4 py-2 text-white rounded transition font-medium">
                                Kirim Permohonan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Tambah -->
            <div x-show="showTambah" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white p-5 rounded shadow-md w-[28rem] mx-4">
                    <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                        ➕ Ajukan Tambah Periode
                    </h2>
                    <form action="{{ route('magang.periode.tambah') }}" method="POST" enctype="multipart/form-data"
                          x-data="tambahPeriodeForm()" @submit="validateTambahPeriode">
                        @csrf

                        @if($periodeAktif)
                            <input type="hidden" id="tanggal_selesai_terakhir" value="{{ $periodeAktif->tanggal_selesai }}">
                        @endif

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700">Alasan *</label>
                            <textarea name="alasan" 
                                      rows="3" 
                                      x-model="alasan"
                                      @input="validateAlasan()"
                                      :class="{
                                          'border-red-300': errors.alasan,
                                          'border-green-300': isValid.alasan,
                                          'border-gray-300': !errors.alasan && !isValid.alasan
                                      }"
                                      required 
                                      class="w-full border rounded p-2 focus:ring-2 focus:ring-green-300 transition-colors"
                                      placeholder="Jelaskan alasan penambahan periode..."></textarea>
                            
                            <template x-if="errors.alasan">
                                <p class="text-red-500 text-xs mt-1" x-text="errors.alasan"></p>
                            </template>
                            
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>Minimal 10 karakter</span>
                                <span x-text="`${alasan.length}/500`"></span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Mulai *</label>
                                <input type="date" 
                                       name="tanggal_mulai" 
                                       x-model="tanggalMulai"
                                       @change="validateTanggalTambahPeriode()"
                                       :class="{
                                           'border-red-300': errors.tanggalMulai,
                                           'border-green-300': isValid.tanggalMulai,
                                           'border-gray-300': !errors.tanggalMulai && !isValid.tanggalMulai
                                       }"
                                       required 
                                       class="w-full border rounded p-2 focus:ring-2 focus:ring-green-300 transition-colors">
                                
                                <template x-if="errors.tanggalMulai">
                                    <p class="text-red-500 text-xs mt-1" x-text="errors.tanggalMulai"></p>
                                </template>
                                
                                <template x-if="isValid.tanggalMulai">
                                    <p class="text-green-500 text-xs mt-1" x-text="isValid.tanggalMulai"></p>
                                </template>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Selesai *</label>
                                <input type="date" 
                                       name="tanggal_selesai" 
                                       x-model="tanggalSelesai"
                                       @change="validateTanggalTambahPeriode()"
                                       :class="{
                                           'border-red-300': errors.tanggalSelesai,
                                           'border-green-300': isValid.tanggalSelesai,
                                           'border-gray-300': !errors.tanggalSelesai && !isValid.tanggalSelesai
                                       }"
                                       required 
                                       class="w-full border rounded p-2 focus:ring-2 focus:ring-green-300 transition-colors">
                                
                                <template x-if="errors.tanggalSelesai">
                                    <p class="text-red-500 text-xs mt-1" x-text="errors.tanggalSelesai"></p>
                                </template>
                                
                                <template x-if="isValid.tanggalSelesai">
                                    <p class="text-green-500 text-xs mt-1" x-text="isValid.tanggalSelesai"></p>
                                </template>
                            </div>
                        </div>

                        <!-- Info Periode Saat Ini -->
                        @if($periodeAktif)
                        <div class="mb-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-yellow-700 text-sm">
                                <strong>Periode Saat Ini:</strong><br>
                                Mulai: {{ $periodeAktif->tanggal_mulai }}<br>
                                Selesai: {{ $periodeAktif->tanggal_selesai }}
                            </p>
                        </div>
                        @endif

                        {{-- Input Upload Surat --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                📎 Upload Surat Permohonan (Opsional)
                            </label>
                            <input type="file" 
                                   name="surat" 
                                   @change="validateSurat($el)"
                                   accept=".pdf"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            
                            <template x-if="errors.surat">
                                <p class="text-red-500 text-xs mt-1" x-text="errors.surat"></p>
                            </template>
                            
                            <p class="text-xs text-gray-500 mt-1">
                                Format: PDF saja (Maks: 2MB)
                            </p>
                        </div>

                        <div class="flex justify-end mt-4 gap-2">
                            <button type="button" @click="showTambah = false"
                                    class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100 transition">
                                Batal
                            </button>
                            <button type="submit"
                                    :disabled="!formValid"
                                    :class="{
                                        'bg-green-500 hover:bg-green-600': formValid,
                                        'bg-green-300 cursor-not-allowed': !formValid
                                    }"
                                    class="px-4 py-2 text-white rounded transition font-medium">
                                Kirim Permohonan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Mundur -->
            <div x-show="showMundur" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white p-5 rounded shadow-md w-[28rem] mx-4">
                    <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                        🚪 Ajukan Pengunduran Diri
                    </h2>
                    
                    <!-- Warning Box -->
                    <div class="mb-4 p-4 bg-orange-50 border border-orange-200 rounded-lg">
                        <div class="flex items-start gap-3">
                            <span class="text-orange-500 text-xl mt-0.5">⚠️</span>
                            <div>
                                <h3 class="font-semibold text-orange-800">Perhatian!</h3>
                                <p class="text-orange-700 text-sm mt-1">
                                    Pengajuan mundur dari program magang akan mengakhiri seluruh aktivitas magang Anda.
                                    Pastikan ini adalah keputusan yang sudah dipertimbangkan matang-matang.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('magang.periode.mundur') }}" method="POST" enctype="multipart/form-data"
                          x-data="mundurForm()" @submit="validateMundur">
                        @csrf

                        @if($periodeAktif)
                            <input type="hidden" name="periode_id" value="{{ $periodeAktif->id }}">
                        @endif

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Pengunduran Diri *</label>
                            <textarea name="alasan" 
                                      rows="4" 
                                      x-model="alasan"
                                      @input="validateAlasan()"
                                      :class="{
                                          'border-red-300': errors.alasan,
                                          'border-green-300': isValid.alasan,
                                          'border-gray-300': !errors.alasan && !isValid.alasan
                                      }"
                                      required 
                                      class="w-full border rounded p-3 focus:ring-2 focus:ring-orange-300 transition-colors"
                                      placeholder="Jelaskan alasan mengundurkan diri dari program magang..."></textarea>
                            
                            <template x-if="errors.alasan">
                                <p class="text-red-500 text-xs mt-1" x-text="errors.alasan"></p>
                            </template>
                            
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>Minimal 20 karakter</span>
                                <span x-text="`${alasan.length}/500`"></span>
                            </div>
                        </div>

                        {{-- Input Upload Surat --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                📎 Upload Surat Pengunduran Diri (Opsional)
                            </label>
                            <input type="file" 
                                   name="surat" 
                                   @change="validateSurat($el)"
                                   accept=".pdf"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                            
                            <template x-if="errors.surat">
                                <p class="text-red-500 text-xs mt-1" x-text="errors.surat"></p>
                            </template>
                            
                            <p class="text-xs text-gray-500 mt-1">
                                Format: PDF saja (Maks: 2MB)
                            </p>
                        </div>

                        <!-- Confirmation Checkbox -->
                        <div class="mb-4">
                            <label class="flex items-start gap-3">
                                <input type="checkbox" 
                                       x-model="confirmed"
                                       class="mt-1 rounded border-gray-300 text-orange-500 focus:ring-orange-500 transition">
                                <span class="text-sm text-gray-700">
                                    Saya menyadari bahwa pengunduran diri ini akan mengakhiri seluruh aktivitas magang saya dan tidak dapat dibatalkan setelah disetujui.
                                </span>
                            </label>
                            <template x-if="errors.confirmation">
                                <p class="text-red-500 text-xs mt-1" x-text="errors.confirmation"></p>
                            </template>
                        </div>

                        <div class="flex justify-end mt-4 gap-2">
                            <button type="button" @click="showMundur = false"
                                    class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100 transition">
                                Batal
                            </button>
                            <button type="submit"
                                    :disabled="!formValid"
                                    :class="{
                                        'bg-orange-500 hover:bg-orange-600': formValid,
                                        'bg-orange-300 cursor-not-allowed': !formValid
                                    }"
                                    class="px-4 py-2 text-white rounded transition font-medium">
                                Ajukan Pengunduran Diri
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    @endif
@endif

<script>
// Alpine.js Components untuk Form Validation
function percepatanForm() {
    return {
        tanggalSelesai: '',
        alasan: '',
        errors: {
            tanggalSelesai: '',
            alasan: '',
            surat: ''
        },
        isValid: {
            tanggalSelesai: '',
            alasan: ''
        },
        formValid: false,

        validateTanggalPercepatan() {
            const tanggalSelesaiSekarang = document.getElementById('tanggal_selesai_sekarang')?.value;
            const selectedDate = new Date(this.tanggalSelesai);
            const currentEndDate = new Date(tanggalSelesaiSekarang);
            const today = new Date();
            
            this.errors.tanggalSelesai = '';
            this.isValid.tanggalSelesai = '';

            if (!this.tanggalSelesai) {
                this.errors.tanggalSelesai = 'Tanggal selesai harus diisi';
            } else if (selectedDate >= currentEndDate) {
                this.errors.tanggalSelesai = 'Tanggal selesai baru harus LEBIH AWAL dari tanggal selesai saat ini';
            } else if (selectedDate < today) {
                this.errors.tanggalSelesai = 'Tanggal selesai tidak boleh lebih awal dari hari ini';
            } else {
                const diffTime = currentEndDate - selectedDate;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                this.isValid.tanggalSelesai = `✅ Valid - Magang dipercepat ${diffDays} hari`;
            }
            
            this.checkFormValidity();
        },

        validateAlasan() {
            this.errors.alasan = '';
            this.isValid.alasan = '';

            if (!this.alasan) {
                this.errors.alasan = 'Alasan harus diisi';
            } else if (this.alasan.length < 10) {
                this.errors.alasan = 'Alasan minimal 10 karakter';
            } else if (this.alasan.length > 500) {
                this.errors.alasan = 'Alasan maksimal 500 karakter';
            } else {
                this.isValid.alasan = '✅ Alasan valid';
            }
            
            this.checkFormValidity();
        },

        validateSurat(fileInput) {
            this.errors.surat = '';
            
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const fileSize = file.size / 1024 / 1024; // MB
                const fileType = file.type;
                
                if (fileType !== 'application/pdf') {
                    this.errors.surat = 'File harus berupa PDF';
                } else if (fileSize > 2) {
                    this.errors.surat = 'Ukuran file maksimal 2MB';
                }
            }
            
            this.checkFormValidity();
        },

        checkFormValidity() {
            this.formValid = 
                !this.errors.tanggalSelesai && 
                !this.errors.alasan && 
                !this.errors.surat &&
                this.tanggalSelesai !== '' &&
                this.alasan.length >= 10;
        },

        validatePercepatan(e) {
            this.validateTanggalPercepatan();
            this.validateAlasan();
            
            if (!this.formValid) {
                e.preventDefault();
                // Scroll ke error pertama
                const firstError = document.querySelector('.border-red-300');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        }
    }
}

function tambahPeriodeForm() {
    return {
        tanggalMulai: '',
        tanggalSelesai: '',
        alasan: '',
        errors: {
            tanggalMulai: '',
            tanggalSelesai: '',
            alasan: '',
            surat: ''
        },
        isValid: {
            tanggalMulai: '',
            tanggalSelesai: ''
        },
        formValid: false,

        validateTanggalTambahPeriode() {
            const tanggalSelesaiTerakhir = document.getElementById('tanggal_selesai_terakhir')?.value;
            const startDate = new Date(this.tanggalMulai);
            const endDate = new Date(this.tanggalSelesai);
            const lastEndDate = new Date(tanggalSelesaiTerakhir);
            const today = new Date();
            
            // Reset messages
            this.errors.tanggalMulai = '';
            this.errors.tanggalSelesai = '';
            this.isValid.tanggalMulai = '';
            this.isValid.tanggalSelesai = '';

            // Validasi Tanggal Mulai
            if (!this.tanggalMulai) {
                this.errors.tanggalMulai = 'Tanggal mulai harus diisi';
            } else if (startDate <= lastEndDate) {
                this.errors.tanggalMulai = 'Tanggal mulai harus SETELAH tanggal selesai periode sebelumnya';
            } else if (startDate < today) {
                this.errors.tanggalMulai = 'Tanggal mulai tidak boleh lebih awal dari hari ini';
            } else {
                this.isValid.tanggalMulai = '✅ Tanggal mulai valid';
            }

            // Validasi Tanggal Selesai
            if (!this.tanggalSelesai) {
                this.errors.tanggalSelesai = 'Tanggal selesai harus diisi';
            } else if (endDate <= startDate) {
                this.errors.tanggalSelesai = 'Tanggal selesai harus SETELAH tanggal mulai';
            } else {
                const diffTime = endDate - startDate;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                this.isValid.tanggalSelesai = `✅ Valid - Periode ${diffDays} hari`;
            }
            
            this.checkFormValidity();
        },

        validateAlasan() {
            this.errors.alasan = '';
            this.isValid.alasan = '';

            if (!this.alasan) {
                this.errors.alasan = 'Alasan harus diisi';
            } else if (this.alasan.length < 10) {
                this.errors.alasan = 'Alasan minimal 10 karakter';
            } else if (this.alasan.length > 500) {
                this.errors.alasan = 'Alasan maksimal 500 karakter';
            } else {
                this.isValid.alasan = '✅ Alasan valid';
            }
            
            this.checkFormValidity();
        },

        validateSurat(fileInput) {
            this.errors.surat = '';
            
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const fileSize = file.size / 1024 / 1024; // MB
                const fileType = file.type;
                
                if (fileType !== 'application/pdf') {
                    this.errors.surat = 'File harus berupa PDF';
                } else if (fileSize > 2) {
                    this.errors.surat = 'Ukuran file maksimal 2MB';
                }
            }
            
            this.checkFormValidity();
        },

        checkFormValidity() {
            this.formValid = 
                !this.errors.tanggalMulai && 
                !this.errors.tanggalSelesai && 
                !this.errors.alasan && 
                !this.errors.surat &&
                this.tanggalMulai !== '' &&
                this.tanggalSelesai !== '' &&
                this.alasan.length >= 10;
        },

        validateTambahPeriode(e) {
            this.validateTanggalTambahPeriode();
            this.validateAlasan();
            
            if (!this.formValid) {
                e.preventDefault();
                // Scroll ke error pertama
                const firstError = document.querySelector('.border-red-300');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        }
    }
}

function mundurForm() {
    return {
        alasan: '',
        confirmed: false,
        errors: {
            alasan: '',
            surat: '',
            confirmation: ''
        },
        isValid: {
            alasan: ''
        },
        formValid: false,

        validateAlasan() {
            this.errors.alasan = '';
            this.isValid.alasan = '';

            if (!this.alasan) {
                this.errors.alasan = 'Alasan pengunduran diri harus diisi';
            } else if (this.alasan.length < 20) {
                this.errors.alasan = 'Alasan minimal 20 karakter';
            } else if (this.alasan.length > 500) {
                this.errors.alasan = 'Alasan maksimal 500 karakter';
            } else {
                this.isValid.alasan = '✅ Alasan valid';
            }
            
            this.checkFormValidity();
        },

        validateSurat(fileInput) {
            this.errors.surat = '';
            
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const fileSize = file.size / 1024 / 1024; // MB
                const fileType = file.type;
                
                if (fileType !== 'application/pdf') {
                    this.errors.surat = 'File harus berupa PDF';
                } else if (fileSize > 2) {
                    this.errors.surat = 'Ukuran file maksimal 2MB';
                }
            }
            
            this.checkFormValidity();
        },

        checkFormValidity() {
            this.errors.confirmation = this.confirmed ? '' : 'Anda harus menyetujui pernyataan ini';
            
            this.formValid = 
                !this.errors.alasan && 
                !this.errors.surat && 
                !this.errors.confirmation &&
                this.alasan.length >= 20 &&
                this.confirmed;
        },

        validateMundur(e) {
            this.validateAlasan();
            this.checkFormValidity();
            
            if (!this.formValid) {
                e.preventDefault();
                // Scroll ke error pertama
                const firstError = document.querySelector('.border-red-300');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        }
    }
}
</script>

  <!-- Riwayat Permohonan -->
<div class="mt-8">
    <h2 class="text-lg font-semibold mb-3">Riwayat Permohonan Periode</h2>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-sm text-left text-gray-800">
            <thead class="bg-orange-500 text-gray">
                <tr>
                    <th class="px-3 py-2">Jenis</th>
                    <th class="px-3 py-2">Alasan</th>
                    <th class="px-3 py-2">Tanggal mulai</th>
                    <th class="px-3 py-2">Tanggal selesai baru</th>
                    <th class="px-3 py-2">Tanggal selesai lama</th>
                    <th class="px-3 py-2">Surat</th>
                    <th class="px-3 py-2">Tanggal Pengajuan</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Tanggal Disetujui</th>
                    <th class="px-3 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($permohonans as $p)
                    <tr class="border-b">
                        <td class="px-3 py-2 capitalize">
                            @switch($p->jenis_permohonan)
                                @case('tambah') Tambah Periode @break
                                @case('percepat') Percepatan @break
                                @case('mundur') Pengunduran Diri @break
                                @case('permohonanmagangkembali') 
                                    <span class="text-green-600 font-semibold">Magang Kembali</span>
                                @break
                                @default -
                            @endswitch
                        </td>
                        <td class="px-3 py-2">{{ $p->alasan }}</td>
                        <td class="px-3 py-2">{{ $p->tanggal_mulai }}</td>
                        <td class="px-3 py-2">{{ $p->tanggal_selesai}}</td>
                        <td class="px-3 py-2">{{ $p->tanggal_selesai_lama}}</td>
                        <td class="px-3 py-2">
                            @if($p->surat)
                                <a href="{{ asset('storage/' . $p->surat) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                                    📄 Lihat Surat
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-3 py-2">{{ $p->tanggal_pengajuan?->format('d M Y') }}</td>
                        <td class="px-3 py-2">
                            @if($p->status === 'pending')
                                <span class="px-2 py-1 bg-yellow-200 rounded text-yellow-800 text-xs font-medium">Pending</span>
                            @elseif($p->status === 'disetujui')
                                <span class="px-2 py-1 bg-green-200 rounded text-green-800 text-xs font-medium">Disetujui</span>
                            @elseif($p->status === 'ditolak')
                                <span class="px-2 py-1 bg-red-200 rounded text-red-800 text-xs font-medium">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            {{ $p->tanggal_disetujui ? $p->tanggal_disetujui->format('d M Y') : '-' }}
                        </td>
                        <td class="px-3 py-2">
                            @if($p->status === 'pending')
                            <div class="flex flex-col gap-1">
                                <!-- Tombol Edit -->
                                <button onclick="showModal{{ $p->id }}()" 
                                        class="px-3 py-1 bg-blue-500 text-gray rounded hover:bg-blue-600 text-xs transition">
                                    ✏️ Edit
                                </button>
                                <!-- Tombol Batalkan -->
                                <button onclick="confirmBatalkan({{ $p->id }}, '{{ $p->jenis_permohonan }}')" 
                                        class="px-3 py-1 bg-red-500 text-gray rounded hover:bg-red-600 text-xs transition">
                                    ❌ Batalkan
                                </button>
                            </div>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-gray-500">Belum ada permohonan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- FORM UNTUK BATALKAN (HIDDEN) -->
@foreach($permohonans as $p)
    @if($p->status === 'pending')
    <form id="form-batalkan-{{ $p->id }}" action="{{ route('magang.permohonan.batalkan', $p->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
    @endif
@endforeach

<!-- MODAL EDIT -->
@foreach($permohonans as $p)
    @if($p->status === 'pending')
    <!-- Modal -->
    <div id="modal-{{ $p->id }}" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        ✏️ Edit Permohonan
                        <span class="text-sm font-normal text-gray-600 capitalize">({{ $p->jenis_permohonan }})</span>
                    </h2>
                    <button onclick="hideModal{{ $p->id }}()" class="text-gray-400 hover:text-gray-600 text-2xl">
                        ×
                    </button>
                </div>

                <form action="{{ route('magang.permohonan.update', $p->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Alasan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Permohonan *</label>
                        <textarea name="alasan" rows="4" required 
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                  placeholder="Jelaskan alasan permohonan Anda...">{{ $p->alasan }}</textarea>
                    </div>

                    <!-- Tanggal Mulai & Selesai -->
                    @if(in_array($p->jenis_permohonan, ['tambah', 'percepat', 'permohonanmagangkembali']))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($p->jenis_permohonan === 'tambah' || $p->jenis_permohonan === 'permohonanmagangkembali')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai *</label>
                            <input type="date" name="tanggal_mulai" 
                                   value="{{ $p->tanggal_mulai }}"
                                   required 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                @if($p->jenis_permohonan === 'percepat')
                                    Tanggal Selesai Baru *
                                @else
                                    Tanggal Selesai *
                                @endif
                            </label>
                            <input type="date" name="tanggal_selesai" 
                                   value="{{ $p->tanggal_selesai }}"
                                   required 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    @endif

                    <!-- Upload Surat -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            📎 Upload Surat Permohonan Baru (Opsional)
                        </label>
                        <input type="file" name="surat" 
                               accept=".pdf"
                               class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                        <p class="text-xs text-gray-500 mt-2">
                            Format: PDF (Maksimal 2MB)
                        </p>
                        
                        @if($p->surat)
                        <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-700">
                                <strong>Surat saat ini:</strong> 
                                <a href="{{ asset('storage/' . $p->surat) }}" 
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-800 underline ml-1">
                                    📄 Lihat Surat
                                </a>
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" 
                                onclick="hideModal{{ $p->id }}()"
                                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-gray rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2">
                            💾 Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script untuk modal ini -->
    <script>
    function showModal{{ $p->id }}() {
        console.log('Membuka modal {{ $p->id }}');
        document.getElementById('modal-{{ $p->id }}').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function hideModal{{ $p->id }}() {
        console.log('Menutup modal {{ $p->id }}');
        document.getElementById('modal-{{ $p->id }}').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal ketika klik di luar
    document.addEventListener('click', function(event) {
        if (event.target.id === 'modal-{{ $p->id }}') {
            hideModal{{ $p->id }}();
        }
    });

    // Close modal dengan ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            hideModal{{ $p->id }}();
        }
    });
    </script>
    @endif
@endforeach

<!-- SCRIPT UNTUK KONFIRMASI BATALKAN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmBatalkan(id, jenis) {
    const jenisText = {
        'tambah': 'Tambah Periode',
        'percepat': 'Percepatan', 
        'mundur': 'Pengunduran Diri',
        'permohonanmagangkembali': 'Magang Kembali'
    }[jenis] || jenis;

    Swal.fire({
        title: 'Batalkan Permohonan?',
        html: `Anda yakin ingin membatalkan permohonan <strong>${jenisText}</strong>?<br><br>
              <span class="text-red-600">⚠️ Tindakan ini tidak dapat dibatalkan!</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Batalkan!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form batalkan
            document.getElementById(`form-batalkan-${id}`).submit();
        }
    });
}
</script>

@if(!$periodeAktif && $peserta->status == 'aktif')
    <p class="text-sm text-red-500 mt-2">Belum ada periode terdaftar. Hubungi admin jika ini keliru.</p>
@endif

<div x-data="{ test: false }">
    <button @click="test = !test" class="bg-green-500 text-gray px-4 py-2 rounded">
        Test Alpine: <span x-text="test ? 'ON' : 'OFF'"></span>
    </button>
</div>
@endsection