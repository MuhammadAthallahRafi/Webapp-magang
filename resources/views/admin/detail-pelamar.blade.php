@extends('layouts.admin-layout')

@section('title', 'Detail Pelamar')

@section('content')
<div class="px-6 py-4">
    <h1 class="text-2xl font-bold mb-6">Detail Pelamar Magang</h1>

    <div class="bg-white rounded shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <strong>Nama Lengkap:</strong>
                <p>{{ $pelamar->nama }}</p>
            </div>
            <div>
                <strong>Nama Akun:</strong>
                <p>{{ $pelamar->user->name }}</p>
            </div>
            <div>
                <strong>nik:</strong>
                <p>{{ $pelamar->nik }}</p>
            </div>
            <div>
                <strong>>Instansi Pendidikan (Kampus atau SMK,SMA):</strong>
                <p>{{ $pelamar->kampus }}</p>
            </div>
            <div>
                <strong>Jurusan:</strong>
                <p>{{ $pelamar->jurusan }}</p>
            </div>
            <div>
                <strong>Telepon:</strong>
                <p>{{ $pelamar->no_telp }}</p>
            </div>
            <div>
                <strong>Email:</strong>
                <p>{{ $pelamar->email }}</p>
            </div>
            <div>
                <strong>Alamat:</strong>
                <p>{{ $pelamar->alamat }}</p>
            </div>
            <div x-data="{ openMulai: false, openSelesai: false }" x-cloak class="flex flex-col sm:flex-row gap-4 mt-4">

    {{-- 🔹 Tombol Tanggal Mulai --}}
    <button 
        @click="openMulai = true"
        class="px-4 py-2 rounded-xl bg-white/20 backdrop-blur-sm shadow-md border border-gray-200 text-gray-800 hover:shadow-lg transition-all duration-200 w-full sm:w-auto text-center">
        <span class="font-medium">Mulai:</span>
        <span class="ml-1 text-blue-600 font-semibold">{{ $pelamar->tanggal_mulai ?? '-' }}</span>
    </button>

    {{-- 🔹 Tombol Tanggal Selesai --}}
    <button 
        @click="openSelesai = true"
        class="px-4 py-2 rounded-xl bg-white/20 backdrop-blur-sm shadow-md border border-gray-200 text-gray-800 hover:shadow-lg transition-all duration-200 w-full sm:w-auto text-center">
        <span class="font-medium">Selesai:</span>
        <span class="ml-1 text-emerald-600 font-semibold">{{ $pelamar->tanggal_selesai ?? '-' }}</span>
    </button>

    {{-- ✅ Modal Ubah Tanggal Mulai --}}
    <div 
        x-show="openMulai"
        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
        x-transition
    >
        <div class="bg-white p-5 rounded-xl shadow-lg w-96 relative">
            <form method="POST" action="{{ route('pelamar.updateTanggalMulai', $pelamar->id) }}">
                @csrf
                @method('PUT')

                <h2 class="text-lg font-semibold mb-4 text-gray-800">Ubah Tanggal Mulai</h2>

                <div class="mb-3">
                    <label for="tanggal_mulai_{{ $pelamar->id }}" class="block text-sm font-medium text-gray-700">
                        Tanggal Mulai Baru
                    </label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai_{{ $pelamar->id }}"
                        value="{{ $pelamar->tanggal_mulai }}"
                        class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

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

    {{-- ✅ Modal Ubah Tanggal Selesai --}}
    <div 
        x-show="openSelesai"
        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
        x-transition
    >
        <div class="bg-white p-5 rounded-xl shadow-lg w-96 relative">
            <form method="POST" action="{{ route('pelamar.updateTanggalSelesai', $pelamar->id) }}">
                @csrf
                @method('PUT')

                <h2 class="text-lg font-semibold mb-4 text-gray-800">Ubah Tanggal Selesai</h2>

                <div class="mb-3">
                    <label for="tanggal_selesai_{{ $pelamar->id }}" class="block text-sm font-medium text-gray-700">
                        Tanggal Selesai Baru
                    </label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai_{{ $pelamar->id }}"
                        value="{{ $pelamar->tanggal_selesai }}"
                        class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400" required>
                </div>

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

</div>



            <div>
    {{-- CV --}}
    @if ($pelamar->cv)
        <div class="mt-4">
            <p class="font-semibold">CV Pelamar:</p>
            <a href="{{ asset('storage/' . $pelamar->cv) }}" target="_blank"
               class="text-blue-600 underline hover:text-blue-800">Lihat CV</a>
        </div>
    @else
        <p class="text-gray-500 italic">CV belum diunggah.</p>
    @endif

    {{-- Transkrip --}}
    @if ($pelamar->transkrip)
        <div class="mt-4">
            <p class="font-semibold">Transkrip Nilai:</p>
            <a href="{{ asset('storage/' . $pelamar->transkrip) }}" target="_blank"
               class="text-blue-600 underline hover:text-blue-800">Lihat Transkrip</a>
        </div>
    @else
        <p class="text-gray-500 italic">Transkrip belum diunggah.</p>
    @endif

    {{-- Surat Pengantar --}}
    @if ($pelamar->surat)
        <div class="mt-4">
            <p class="font-semibold">Surat Pengajuan Magang:</p>
            <a href="{{ asset('storage/' . $pelamar->surat) }}" target="_blank"
               class="text-blue-600 underline hover:text-blue-800">Lihat Surat</a>
        </div>
    @else
        <p class="text-gray-500 italic">Surat belum diunggah.</p>
    @endif
</div>

        </div>

      <!-- Tambahkan script SweetAlert2 sekali saja di layout -->

<div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Form TERIMA dengan Catatan Admin -->
    <!-- Tombol Terima -->
        <button type="button"
                onclick="document.getElementById('modal-terima-{{ $pelamar->id }}').classList.remove('hidden')"
                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
            ✅ Terima
        </button>

<!-- Modal Terima -->
    <div id="modal-terima-{{ $pelamar->id }}" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
        <div class="bg-white p-5 rounded shadow-md w-96">
            <form method="POST" action="{{ route('admin.pelamar.terima', $pelamar->id) }}">
                @csrf

                <!-- Pilih Unit Kerja -->
                <!-- Pilih Divisi (Unit Kerja) -->
                <div class="mb-3">
                    <label for="divisi_{{ $pelamar->id }}" class="block text-sm font-medium text-gray-700">Unit Kerja</label>
                    <select name="divisi" id="divisi_{{ $pelamar->id }}"
                            class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400" required>
                        <option value="">-- Pilih Unit Kerja --</option>
                        <option value="IT">IT</option>
                        <option value="HRD">HRD</option>
                        <option value="Finance">Finance</option>
                        <option value="Marketing">Marketing</option>
                        <!-- nanti bisa diisi dinamis dari database -->
                    </select>
                </div>

                <!-- Catatan Admin -->
                <div class="mb-3">
                    <label class="block text-sm font-semibold mb-1">Catatan Admin</label>
                    <textarea name="catatan_admin" rows="3"
                            class="w-full border border-green-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"
                            placeholder="Tulis catatan admin..."></textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end space-x-2">
                    <button type="button"
                            onclick="document.getElementById('modal-terima-{{ $pelamar->id }}').classList.add('hidden')"
                            class="px-3 py-1 rounded border">Batal</button>
                    <button type="submit"
                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm font-semibold shadow-md">
                        ✅ Terima & Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

<!-- Tombol Perbaikan --> 
    <button type="button"
        onclick="document.getElementById('modal-perbaikan-{{ $pelamar->id }}').classList.remove('hidden')" 
        class="bg-orange-500 text-white px-2 py-1 rounded text-xs hover:bg-orange-500">
        ✏️ Perbaikan
    </button>


<!-- Modal Perbaikan --> 
    <div id="modal-perbaikan-{{ $pelamar->id }}" 
        class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center"> 
        <div class="bg-white p-5 rounded shadow-md w-96">
            <form action="{{ route('admin.pelamar.perbaikan', $pelamar->id) }}" method="POST"> 
                @csrf
                <div class="p-3">
                    <label for="alasan_perbaikan" class="block text-sm font-medium text-gray-700">
                        Alasan Perbaikan
                    </label> 
                    <textarea name="alasan_perbaikan" id="alasan_perbaikan" 
                            class="w-full border rounded p-2" required></textarea> 
                </div>

                <div class="flex justify-end space-x-2 p-3">
                    <button type="button"
                        onclick="document.getElementById('modal-perbaikan-{{ $pelamar->id }}').classList.add('hidden')" 
                        class="px-3 py-1 rounded border">Batal</button>
                    <button type="submit" 
                            class="bg-orange-500 text-white px-3 py-1 rounded hover:bg-orange-600 font-semibold">
                        Simpan Perbaikan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Form TOLAK -->
    <!-- Tombol Tolak -->
<button type="button"
        onclick="document.getElementById('modal-tolak-{{ $pelamar->id }}').classList.remove('hidden')"
        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
    ❌ Tolak
</button>

<!-- Modal Tolak -->
<div id="modal-tolak-{{ $pelamar->id }}" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
    <div class="bg-white p-5 rounded shadow-md w-96">
        <form action="{{ route('admin.pelamar.tolak', $pelamar->id) }}" method="POST">
            @csrf
            <div class="p-3">
                <label for="alasan_penolakan" class="block text-sm font-medium text-gray-700">
                    Alasan Penolakan
                </label>
                <textarea name="alasan_penolakan" id="alasan_penolakan"
                          class="w-full border rounded p-2" required></textarea>
            </div>

            <div class="flex justify-end space-x-2 p-3">
                <button type="button"
                        onclick="document.getElementById('modal-tolak-{{ $pelamar->id }}').classList.add('hidden')"
                        class="px-3 py-1 rounded border">Batal</button>
                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>



    <!-- Tombol Kembali -->
        <div class="md:col-span-2">
            <a href="{{ route('admin.pelamar') }}"
            class="inline-block mt-4 bg-cyan-200 hover:bg-cyan-300 text-black font-semibold px-5 py-2 rounded shadow-md text-sm">
                ← Kembali ke daftar pelamar
            </a>
        </div>
</div>


<script>
function konfirmasiterima(id) {
    Swal.fire({
        title: 'Yakin?',
        text: "Yakin Pecundang ini diterima??",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formTerima' + id).submit();
        }
    });
}

function konfirmasitolak(id) {
    Swal.fire({
        title: 'Yakin?',
        text: "Tolak Pecundang ini??",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Tolak!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formTolak' + id).submit();
        }
    });
}
</script>

            
        </div>
    </div>
</div>
@endsection
