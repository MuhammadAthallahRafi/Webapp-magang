@extends('layouts.magang-layout')
@section('title', 'Dashboard Magang')
@section('page-title', 'Dashboard')
@section('content')

@php
    // Ambil bulan dari tanggal pertama di kalender (jika ada)
    $bulan = isset($kalender) && count($kalender) > 0
        ? \Carbon\Carbon::parse($kalender[0]['tanggal'])->translatedFormat('F Y')
        : '';
@endphp

<div class="p-6">
    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif
<!-- Popup Catatan Admin - Ukuran Pas -->
<div x-data="catatanAdmin()" x-init="init()">
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
         @click="closeModal">
         
        <div class="bg-white border border-gray-300 rounded-lg shadow-xl w-96" @click.stop>
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <span class="text-blue-600 text-sm">💬</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Catatan Admin</h3>
                        <p class="text-sm text-gray-500">Pesan penting untuk Anda</p>
                    </div>
                </div>
            </div>
            
            <!-- Content -->
            <div class="px-6 py-4 max-h-60 overflow-y-auto">
                <p class="text-gray-700 whitespace-pre-line leading-relaxed" x-text="catatan"></p>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 rounded-b-lg flex justify-between items-center">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" x-model="janganTampilkanLagi" class="w-4 h-4 rounded border-gray-300">
                    <span class="text-sm text-gray-600">Jangan tampilkan lagi</span>
                </label>
                <button @click="closeModal" 
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition font-medium">
                    Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('catatanAdmin', () => ({
        showModal: false,
        janganTampilkanLagi: false,
        catatan: @json($peserta->catatan_admin ?? ''),
        
        init() {
            const sudahDitutup = localStorage.getItem('catatanAdminDitutup');
            const adaCatatan = this.catatan && this.catatan.trim() !== '';
            
            if (!sudahDitutup && adaCatatan) {
                this.$nextTick(() => {
                    setTimeout(() => {
                        this.showModal = true;
                        document.body.style.overflow = 'hidden';
                    }, 300);
                });
            }
        },
        
        closeModal() {
            if (this.janganTampilkanLagi) {
                localStorage.setItem('catatanAdminDitutup', 'true');
            }
            this.showModal = false;
            document.body.style.overflow = 'auto';
        }
    }));
});
</script>
    {{-- ===== JIKA STATUS AKTIF ===== --}}
    @if($peserta->status == 'aktif')
        <h1 class="text-xl font-bold mb-4">Absensi Hari Ini</h1>

        {{-- Dropdown Absensi --}}
        <form action="{{ route('dashboard.magang.absensi') }}" method="POST" class="inline-block">
            @csrf
            <select name="keterangan" class="border p-2 rounded" {{ $absensiHariIni ? 'disabled' : '' }}>
                <option value="">-- Pilih --</option>
                <option value="Hadir">✅Hadir</option>
                <option value="Sakit">🤒Sakit</option>
                <option value="Izin">📝Izin</option>
                <option value="Alfa">⚠️Alfa</option>
            </select>
            <button type="submit" class="bg-green-500 text-white p-2 rounded" {{ $absensiHariIni ? 'disabled' : '' }}>
                Absen
            </button>
        </form>

        {{-- Tombol Pulang --}}
        <form action="{{ route('dashboard.magang.pulang') }}" method="POST" class="inline-block ml-4">
            @csrf
            <button type="submit" 
                class="p-2 rounded {{ $absensiHariIni && !$absensiHariIni->jam_keluar ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-gray-400 cursor-not-allowed' }}"
                {{ !$absensiHariIni || $absensiHariIni->jam_keluar ? 'disabled' : '' }}>
                Pulang
            </button>
        </form>

        {{-- Kalender Kehadiran --}}
        @if(!empty($kalender))
            <h2 class="text-lg font-semibold mt-8">
                Kalender Kehadiran {{ $bulan ? '(' . $bulan . ')' : '' }}
            </h2>
            <div class="grid grid-cols-7 gap-2 mt-4">
                @foreach ($kalender as $day)
                    <div class="p-2 border rounded text-center
                        @if($day['status'] == 'Hadir') bg-green-50 
                        @elseif($day['status'] == 'Izin') bg-blue-50 
                        @elseif($day['status'] == 'Sakit') bg-yellow-50 
                        @elseif($day['status'] == 'Alfa') bg-red-50 
                        @elseif($day['status'] == 'Libur') bg-gray-100 
                        @endif">
                        @if ($day['status'] == 'Hadir') ✅
                        @elseif ($day['status'] == 'Izin') 📝
                        @elseif ($day['status'] == 'Sakit') 🤒
                        @elseif ($day['status'] == 'Alfa') ⚠️
                        @elseif ($day['status'] == 'Libur') 🔴
                        @else ⤷
                        @endif
                        <div class="text-sm font-medium">{{ \Carbon\Carbon::parse($day['tanggal'])->format('d') }}</div>
                    </div>
                @endforeach
            </div>
        @endif

    {{-- ===== JIKA STATUS MUNDUR ATAU LULUS ===== --}}
    @elseif(in_array($peserta->status, ['mundur', 'lulus']))
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                📋 Status Permohonan Magang Kembali
            </h1>

            {{-- PESAN TERIMA KASIH BERDASARKAN STATUS --}}
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6 mb-6 text-center">
                @if($peserta->status == 'lulus')
                    <div class="text-4xl mb-3">🎓</div>
                    <h2 class="text-xl font-bold text-blue-800 mb-2">Selamat! Kamu Telah Lulus</h2>
                    <p class="text-blue-700 mb-3">
                        Terima kasih atas dedikasi dan kontribusi yang telah kamu berikan selama periode magang. 
                        Semoga pengalaman ini bermanfaat untuk karir kamu ke depannya!
                    </p>
                    <p class="text-blue-600 text-sm">
                        Kami berharap dapat bekerja sama lagi di kesempatan berikutnya. Sukses selalu! 🚀
                    </p>
                @elseif($peserta->status == 'mundur')
                    <div class="text-4xl mb-3">👋</div>
                    <h2 class="text-xl font-bold text-purple-800 mb-2">Terima Kasih atas Partisipasinya</h2>
                    <p class="text-purple-700 mb-3">
                        Terima kasih telah menjadi bagian dari program magang kami. 
                        Kami menghargai waktu dan usaha yang telah kamu berikan selama bergabung dengan kami.
                    </p>
                    <p class="text-purple-600 text-sm">
                        Semoga sukses dalam perjalanan karir dan studi kamu selanjutnya! 🌟
                    </p>
                @endif
            </div>

            @if ($permohonan)
                <div class="text-left space-y-4">
                    <p class="text-gray-700">
                        Hai, <span class="font-semibold">{{ $peserta->nama }}</span> 👋
                    </p>
                    <p class="text-gray-600">
                        @if($permohonan->jenis_permohonan == 'permohonanmagangkembali')
                            Berikut adalah detail permohonan <strong>magang kembali</strong> yang telah kamu ajukan.
                        @else
                            Berikut adalah detail permohonan <strong>{{ $permohonan->jenis_permohonan }}</strong> yang telah kamu ajukan.
                        @endif
                    </p>

                    <div class="border-t pt-4 text-sm">
                        <div class="flex justify-between py-1">
                            <span class="font-medium text-gray-700">Jenis Permohonan:</span>
                            <span class="capitalize">
                                @if($permohonan->jenis_permohonan == 'permohonanmagangkembali')
                                    Magang Kembali
                                @else
                                    {{ $permohonan->jenis_permohonan }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="font-medium text-gray-700">Tanggal Pengajuan:</span>
                            <span>{{ \Carbon\Carbon::parse($permohonan->tanggal_pengajuan)->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="font-medium text-gray-700">Tanggal Mulai:</span>
                            <span>{{ \Carbon\Carbon::parse($permohonan->tanggal_mulai)->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="font-medium text-gray-700">Tanggal Selesai:</span>
                            <span>{{ \Carbon\Carbon::parse($permohonan->tanggal_selesai)->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="font-medium text-gray-700">Status:</span>
                            <span class="
                                px-3 py-1 rounded-full text-xs font-semibold
                                @if ($permohonan->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif ($permohonan->status == 'disetujui') bg-green-100 text-green-800
                                @elseif ($permohonan->status == 'ditolak') bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($permohonan->status) }}
                            </span>
                        </div>
                    </div>

                    @if ($permohonan->status == 'pending')
                        <p class="mt-4 text-yellow-700 bg-yellow-50 border border-yellow-200 p-3 rounded-md text-sm">
                            ⏳ Permohonan kamu sedang menunggu konfirmasi dari admin. Mohon bersabar ya!
                        </p>
                    @elseif ($permohonan->status == 'ditolak')
                        <p class="mt-4 text-red-700 bg-red-50 border border-red-200 p-3 rounded-md text-sm">
                            ❌ Maaf, permohonan kamu <strong>ditolak</strong>. Kamu bisa menghubungi admin untuk info lebih lanjut.
                        </p>
                    @endif
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-600">Belum ada permohonan magang kembali yang diajukan.</p>
                    <p class="text-gray-500 text-sm mt-2">
                        @if($peserta->status == 'mundur')
                            Kamu telah mengundurkan diri. Ajukan permohonan magang kembali untuk dapat bergabung lagi.
                        @else
                            Kamu telah lulus. Ajukan permohonan magang kembali jika ingin bergabung lagi.
                        @endif
                    </p>
                </div>
            @endif
        </div>

    {{-- ===== JIKA STATUS LAINNYA ===== --}}
    @else
        <div class="text-center py-8">
            <p class="text-gray-600">Status kamu: <strong>{{ $peserta->status }}</strong></p>
            <p class="text-gray-500 mt-2">Silakan hubungi admin untuk informasi lebih lanjut.</p>
        </div>
    @endif
</div>
@endsection