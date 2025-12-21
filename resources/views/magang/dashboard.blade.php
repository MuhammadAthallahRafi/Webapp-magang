@extends('layouts.magang-layout')
@section('title', 'Dashboard Magang')
@section('page-title', 'Dashboard')
@section('content')

@php
    $bulan = isset($kalender) && count($kalender) > 0
        ? \Carbon\Carbon::parse($kalender[0]['tanggal'])->translatedFormat('F Y')
        : '';
@endphp

<div class="px-4 py-6 sm:px-6 lg:px-8">
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

    {{-- Popup Catatan Admin --}}
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
             
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full" @click.stop>
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-comment-alt text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Pesan dari Admin</h3>
                            <p class="text-sm text-gray-500">Informasi penting untuk Anda</p>
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
                        <input type="checkbox" x-model="janganTampilkanLagi" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Jangan tampilkan lagi</span>
                    </label>
                    <button @click="closeModal" 
                            class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                        Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== JIKA STATUS AKTIF ===== --}}
    @if($peserta->status == 'aktif')
        {{-- Header Dashboard --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Dashboard Magang</h1>
            <p class="text-gray-600 mt-1">Selamat datang di panel peserta magang BKN</p>
        </div>

        {{-- Kartu Informasi Peserta --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-id-card text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">ID Magang</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $peserta->id_magang ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-sitemap text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Divisi</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $peserta->divisi ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-alt text-orange-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Periode</h3>
                        <p class="text-lg font-semibold text-gray-900">
                            @if($peserta->tanggal_mulai && $peserta->tanggal_selesai)
                                {{ \Carbon\Carbon::parse($peserta->tanggal_mulai)->format('d/m') }} - 
                                {{ \Carbon\Carbon::parse($peserta->tanggal_selesai)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Absensi Hari Ini --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Absensi Hari Ini</h2>
                <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
            
            <div class="p-6">
                @if($absensiHariIni)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-green-800">✅ Sudah Absen</h3>
                                <p class="text-green-700 mt-1">
                                    Status: <span class="font-semibold">{{ $absensiHariIni->keterangan }}</span>
                                </p>
                                <p class="text-green-600 text-sm mt-2">
                                    Jam Masuk: <span class="font-medium">{{ $absensiHariIni->jam_masuk }}</span>
                                    @if($absensiHariIni->jam_keluar)
                                        • Jam Keluar: <span class="font-medium">{{ $absensiHariIni->jam_keluar }}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="text-4xl">
                                @if($absensiHariIni->keterangan == 'Hadir') ✅
                                @elseif($absensiHariIni->keterangan == 'Sakit') 🤒
                                @elseif($absensiHariIni->keterangan == 'Izin') 📝
                                @elseif($absensiHariIni->keterangan == 'Alfa') ⚠️
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- Tombol Pulang --}}
                    @if(!$absensiHariIni->jam_keluar)
                        <form action="{{ route('dashboard.magang.pulang') }}" method="POST" class="text-center">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-red-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200 shadow-sm">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Tandai Pulang
                            </button>
                            <p class="text-gray-500 text-xs mt-2">Klik tombol ini saat selesai bekerja hari ini</p>
                        </form>
                    @else
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-700">✅ Anda sudah pulang hari ini</p>
                            <p class="text-gray-500 text-sm mt-1">Terima kasih atas kerja kerasnya!</p>
                        </div>
                    @endif
                @else
                    {{-- Form Absensi --}}
                    <div class="text-center">
                        <form action="{{ route('dashboard.magang.absensi') }}" method="POST" class="inline-block">
                            @csrf
                            <div class="mb-4">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Pilih Status Kehadiran</label>
                                <select name="keterangan" id="keterangan" 
                                        class="w-full md:w-64 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Hadir">✅ Hadir</option>
                                    <option value="Sakit">🤒 Sakit</option>
                                    <option value="Izin">📝 Izin</option>
                                    <option value="Alfa">⚠️ Alfa</option>
                                </select>
                            </div>
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200 shadow-sm">
                                <i class="fas fa-check-circle mr-2"></i>
                                Absen Sekarang
                            </button>
                        </form>
                        <p class="text-gray-500 text-sm mt-4">Silakan pilih status kehadiran Anda hari ini</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Kalender Kehadiran --}}
        @if(!empty($kalender))
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Kalender Kehadiran</h2>
                    <p class="text-sm text-gray-500 mt-1">Bulan {{ $bulan }}</p>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-7 gap-2 mb-4">
                        @foreach(['M', 'S', 'S', 'R', 'K', 'J', 'S'] as $day)
                            <div class="text-center text-sm font-medium text-gray-500 py-2">{{ $day }}</div>
                        @endforeach
                    </div>
                    
                    <div class="grid grid-cols-7 gap-2">
                        @foreach ($kalender as $day)
                            <div class="p-2 border rounded-lg text-center transition-all duration-200 hover:shadow-md
                                @if($day['status'] == 'Hadir') bg-green-50 border-green-200 
                                @elseif($day['status'] == 'Izin') bg-blue-50 border-blue-200 
                                @elseif($day['status'] == 'Sakit') bg-yellow-50 border-yellow-200 
                                @elseif($day['status'] == 'Alfa') bg-red-50 border-red-200 
                                @elseif($day['status'] == 'Libur') bg-gray-100 border-gray-200 
                                @else bg-white border-gray-200 
                                @endif">
                                <div class="text-xs text-gray-500 mb-1">
                                    {{ \Carbon\Carbon::parse($day['tanggal'])->format('D') }}
                                </div>
                                <div class="text-lg font-semibold text-gray-900 mb-1">
                                    {{ \Carbon\Carbon::parse($day['tanggal'])->format('d') }}
                                </div>
                                <div class="text-xs">
                                    @if ($day['status'] == 'Hadir') 
                                        <span class="text-green-600">✅</span>
                                    @elseif ($day['status'] == 'Izin') 
                                        <span class="text-blue-600">📝</span>
                                    @elseif ($day['status'] == 'Sakit') 
                                        <span class="text-yellow-600">🤒</span>
                                    @elseif ($day['status'] == 'Alfa') 
                                        <span class="text-red-600">⚠️</span>
                                    @elseif ($day['status'] == 'Libur') 
                                        <span class="text-gray-500">🔴</span>
                                    @else 
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Legend --}}
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Keterangan:</h4>
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center">
                                <span class="text-green-600 mr-2">✅</span>
                                <span class="text-sm text-gray-600">Hadir</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-blue-600 mr-2">📝</span>
                                <span class="text-sm text-gray-600">Izin</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-yellow-600 mr-2">🤒</span>
                                <span class="text-sm text-gray-600">Sakit</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-red-600 mr-2">⚠️</span>
                                <span class="text-sm text-gray-600">Alfa</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-500 mr-2">🔴</span>
                                <span class="text-sm text-gray-600">Libur</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    {{-- ===== JIKA STATUS MUNDUR ATAU LULUS ===== --}}
    @elseif(in_array($peserta->status, ['mundur', 'lulus']))
        <div class="max-w-3xl mx-auto">
            {{-- Header --}}
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Status Magang</h1>
                <p class="text-gray-600 mt-1">Informasi status magang Anda di BKN</p>
            </div>

            {{-- Kartu Status --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="p-8 text-center">
                    @if($peserta->status == 'lulus')
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-graduation-cap text-green-600 text-3xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-green-800 mb-3">Selamat! Anda Telah Lulus</h2>
                        <p class="text-green-700 text-lg mb-4">
                            Terima kasih atas dedikasi dan kontribusi selama periode magang
                        </p>
                        <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                            <i class="fas fa-award mr-2"></i>
                            Peserta Magang Berprestasi
                        </div>
                    @elseif($peserta->status == 'mundur')
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-handshake text-blue-600 text-3xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-blue-800 mb-3">Terima Kasih</h2>
                        <p class="text-blue-700 text-lg mb-4">
                            Terima kasih telah menjadi bagian dari program magang BKN
                        </p>
                        <div class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                            <i class="fas fa-users mr-2"></i>
                            Alumni Magang BKN
                        </div>
                    @endif
                </div>
            </div>

            {{-- Informasi Permohonan --}}
            @if ($permohonan)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Detail Permohonan</h2>
                        <p class="text-sm text-gray-500 mt-1">Informasi permohonan yang telah diajukan</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Informasi Umum</h3>
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-xs text-gray-500">Jenis Permohonan</dt>
                                        <dd class="text-sm font-medium text-gray-900 capitalize">
                                            @if($permohonan->jenis_permohonan == 'permohonanmagangkembali')
                                                Magang Kembali
                                            @else
                                                {{ $permohonan->jenis_permohonan }}
                                            @endif
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500">Tanggal Pengajuan</dt>
                                        <dd class="text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($permohonan->tanggal_pengajuan)->translatedFormat('d F Y') }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500">Status Permohonan</dt>
                                        <dd class="text-sm">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'disetujui' => 'bg-green-100 text-green-800',
                                                    'ditolak' => 'bg-red-100 text-red-800'
                                                ];
                                                $statusColor = $statusColors[$permohonan->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                                <i class="fas 
                                                    @if($permohonan->status == 'pending') fa-clock 
                                                    @elseif($permohonan->status == 'disetujui') fa-check-circle 
                                                    @elseif($permohonan->status == 'ditolak') fa-times-circle 
                                                    @endif mr-1">
                                                </i>
                                                {{ ucfirst($permohonan->status) }}
                                            </span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Periode yang Diajukan</h3>
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-xs text-gray-500">Tanggal Mulai</dt>
                                        <dd class="text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($permohonan->tanggal_mulai)->translatedFormat('d F Y') }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500">Tanggal Selesai</dt>
                                        <dd class="text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($permohonan->tanggal_selesai)->translatedFormat('d F Y') }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500">Durasi</dt>
                                        <dd class="text-sm font-medium text-gray-900">
                                            @php
                                                $mulai = \Carbon\Carbon::parse($permohonan->tanggal_mulai);
                                                $selesai = \Carbon\Carbon::parse($permohonan->tanggal_selesai);
                                                $durasi = $selesai->diffInDays($mulai);
                                            @endphp
                                            {{ $durasi }} hari
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        
                        @if ($permohonan->status == 'pending')
                            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-clock text-yellow-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-yellow-800">Permohonan sedang dalam proses peninjauan</p>
                                        <p class="text-sm text-yellow-700 mt-1">Admin akan memproses permohonan Anda secepatnya.</p>
                                    </div>
                                </div>
                            </div>
                        @elseif ($permohonan->status == 'ditolak')
                            <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-times-circle text-red-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-red-800">Permohonan tidak disetujui</p>
                                        <p class="text-sm text-red-700 mt-1">Silakan hubungi admin untuk informasi lebih lanjut.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

    {{-- ===== JIKA STATUS LAINNYA ===== --}}
    @else
        <div class="max-w-md mx-auto text-center py-12">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-info-circle text-gray-500 text-3xl"></i>
            </div>
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Status: {{ ucfirst($peserta->status) }}</h2>
            <p class="text-gray-600 mb-6">Status magang Anda sedang dalam peninjauan</p>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm text-gray-700">Untuk informasi lebih lanjut, silakan hubungi admin melalui:</p>
                <div class="mt-3 space-y-2">
                    <div class="flex items-center justify-center text-sm text-gray-600">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>magang@kepegawaian.go.id</span>
                    </div>
                    <div class="flex items-center justify-center text-sm text-gray-600">
                        <i class="fas fa-phone mr-2"></i>
                        <span>(021) 1234-5678</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
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

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@endsection