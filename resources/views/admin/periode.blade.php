@extends('layouts.admin-layout')

@section('title', 'Riwayat Periode & Permohonan Peserta')

@section('content')
<div class="px-6 py-4">
    <h1 class="text-2xl font-bold mb-6">Riwayat Periode & Permohonan Magang</h1>

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

    {{-- Riwayat Periode --}}
<div class="bg-white shadow rounded-lg p-4 mb-6">
    <h3 class="font-semibold text-lg mb-3 text-blue-600">📅 Riwayat Periode Magang</h3>

    @if($riwayatPeriode->isEmpty())
        <p class="text-gray-500 text-sm">Belum ada data periode magang.</p>
    @else
        <table class="w-full text-sm border">
            <thead class="bg-blue-50 text-gray-700">
                <tr>
                    <th class="px-3 py-2 border">Periode Ke</th>
                    <th class="px-3 py-2 border">Tanggal Mulai</th>
                    <th class="px-3 py-2 border">Tanggal Selesai</th>
                    <th class="px-3 py-2 border">Status</th>
                    <th class="px-3 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayatPeriode as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center font-semibold">{{ $p->periode_ke }}</td>
                        <td class="border px-3 py-2">{{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d/m/Y') }}</td>
                        <td class="border px-3 py-2">{{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d/m/Y') }}</td>
                        <td class="border px-3 py-2 text-center">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                @if($p->status === 'aktif') bg-green-100 text-green-800
                                @elseif($p->status === 'selesai') bg-blue-100 text-blue-800
                                @elseif($p->status === 'rencana') bg-yellow-100 text-yellow-800
                                @elseif($p->status === 'dibatalkan') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td class="border px-3 py-2 text-center">
                            <button 
                                type="button"
                                onclick="showSikapModal({{ $p->id }})"
                                class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 flex items-center gap-1 mx-auto transition-colors">
                                👁️ Lihat Sikap
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- Modal Sikap -->
<div id="sikapModal" class="modal hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-[95%] max-w-7xl max-h-[90vh] overflow-hidden">
        <!-- Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800" id="modalTitle">📊 Data Sikap</h2>
            <button type="button" 
                    onclick="hideSikapModal()"
                    class="text-gray-500 hover:text-gray-700 text-xl rounded-full hover:bg-gray-100 w-8 h-8 flex items-center justify-center">
                ×
            </button>
        </div>

        <!-- Content -->
        <div class="p-6 overflow-y-auto max-h-[70vh]" id="modalContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-3 p-6 border-t border-gray-200 bg-gray-50">
            <button type="button" 
                    onclick="hideSikapModal()"
                    class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function showSikapModal(periodeId) {
    // Cari data periode
    const periodeData = {
        @foreach($riwayatPeriode as $p)
            {{ $p->id }}: {
                periode_ke: {{ $p->periode_ke }},
                tanggal_mulai: '{{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }}',
                tanggal_selesai: '{{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}',
                sikap: @json($p->penilaian)
            },
        @endforeach
    };

    const data = periodeData[periodeId];
    const modal = document.getElementById('sikapModal');
    const title = document.getElementById('modalTitle');
    const content = document.getElementById('modalContent');

    title.textContent = `📊 Data Sikap - Periode ${data.periode_ke}`;
    
    if (data.sikap) {
        content.innerHTML = `
            <div>
                <!-- Info Peserta -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="grid grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-blue-700">Nama:</span>
                            <p class="text-blue-900">{{ $peserta->nama }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-blue-700">Periode:</span>
                            <p class="text-blue-900">${data.periode_ke}</p>
                        </div>
                        <div>
                            <span class="font-medium text-blue-700">Tanggal Mulai:</span>
                            <p class="text-blue-900">${data.tanggal_mulai}</p>
                        </div>
                        <div>
                            <span class="font-medium text-blue-700">Tanggal Selesai:</span>
                            <p class="text-blue-900">${data.tanggal_selesai}</p>
                        </div>
                    </div>
                </div>

                <!-- SEMUA DATA DALAM SATU BARIS PANJANG -->
                <div class="flex gap-4 overflow-x-auto pb-4">
                    <!-- Disiplin -->
                    <div class="border border-blue-200 rounded-lg p-4 bg-blue-50 min-w-[200px]">
                        <h3 class="font-semibold text-lg mb-4 text-blue-700 text-center">
                            ⏰ Disiplin
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-blue-800">Ketepatan Waktu:</span>
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded font-bold text-lg">${data.sikap.disiplin_tepat_waktu || 0}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-800">Kehadiran:</span>
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded font-bold text-lg">${data.sikap.disiplin_kehadiran || 0}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-800">Tata Tertib:</span>
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded font-bold text-lg">${data.sikap.disiplin_tata_tertib || 0}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Kinerja -->
                    <div class="border border-green-200 rounded-lg p-4 bg-green-50 min-w-[200px]">
                        <h3 class="font-semibold text-lg mb-4 text-green-700 text-center">
                            💼 Kinerja
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-green-800">Keterampilan:</span>
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded font-bold text-lg">${data.sikap.kerja_keterampilan || 0}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-green-800">Kualitas Kerja:</span>
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded font-bold text-lg">${data.sikap.kerja_kualitas || 0}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-green-800">Tanggung Jawab:</span>
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded font-bold text-lg">${data.sikap.kerja_tanggung_jawab || 0}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Sosial -->
                    <div class="border border-purple-200 rounded-lg p-4 bg-purple-50 min-w-[200px]">
                        <h3 class="font-semibold text-lg mb-4 text-purple-700 text-center">
                            👥 Sosial
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-purple-800">Komunikasi:</span>
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded font-bold text-lg">${data.sikap.sosial_komunikasi || 0}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-purple-800">Kerjasama:</span>
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded font-bold text-lg">${data.sikap.sosial_kerjasama || 0}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-purple-800">Inisiatif:</span>
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded font-bold text-lg">${data.sikap.sosial_inisiatif || 0}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Lain-lain -->
                    <div class="border border-orange-200 rounded-lg p-4 bg-orange-50 min-w-[200px]">
                        <h3 class="font-semibold text-lg mb-4 text-orange-700 text-center">
                            ⭐ Lain-lain
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-orange-800">Etika:</span>
                                <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded font-bold text-lg">${data.sikap.lain_etika || 0}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-orange-800">Penampilan:</span>
                                <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded font-bold text-lg">${data.sikap.lain_penampilan || 0}</span>
                            </div>
                            <div class="h-6"></div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-800 text-white min-w-[250px]">
                        <h3 class="font-semibold text-lg mb-4 text-center text-white">
                            📈 Summary
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-300">Total Nilai:</span>
                                <span class="bg-blue-500 text-white px-2 py-1 rounded font-bold text-lg">${data.sikap.jumlah_nilai || 0}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-300">Rata-rata:</span>
                                <span class="bg-green-500 text-white px-2 py-1 rounded font-bold text-lg">${data.sikap.nilai_rata_rata || 0}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-300">Persentase:</span>
                                <span class="bg-yellow-500 text-white px-2 py-1 rounded font-bold text-lg">${Math.round((data.sikap.jumlah_nilai || 0) / 1300 * 100)}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    } else {
        content.innerHTML = `
            <div class="text-center py-12">
                <div class="text-6xl mb-4 text-gray-400">📝</div>
                <h3 class="text-xl font-semibold text-gray-700 mb-3">Belum Ada Data Sikap</h3>
                <p class="text-gray-500 text-sm">Data penilaian sikap untuk periode ini belum tersedia.</p>
            </div>
        `;
    }

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function hideSikapModal() {
    document.getElementById('sikapModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal ketika klik di luar
document.getElementById('sikapModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideSikapModal();
    }
});

// Close modal dengan ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideSikapModal();
    }
});
</script>

<style>
.hidden {
    display: none !important;
}
.modal {
    transition: opacity 0.3s ease;
}
</style>

    {{-- Riwayat Permohonan --}}
<div class="bg-white shadow rounded-lg p-4">
    <h3 class="font-semibold text-lg mb-3 text-blue-600">📝 Riwayat Permohonan Periode</h3>

    @if($permohonan->isEmpty())
        <p class="text-gray-500 text-sm">Belum ada data permohonan periode.</p>
    @else
        <table class="w-full text-sm border">
            <thead class="bg-blue-50 text-gray-700">
                <tr>
                    <th class="px-3 py-2 border">Jenis Permohonan</th>
                    <th class="px-3 py-2 border">Tanggal Mulai</th>
                    <th class="px-3 py-2 border">Tanggal Selesai</th>
                    <th class="px-3 py-2 border">Status</th>
                    <th class="px-3 py-2 border">Tanggal Pengajuan</th>
                    <th class="px-3 py-2 border">Surat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permohonan as $m)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 capitalize">
                            @switch($m->jenis_permohonan)
                                @case('tambah') ➕ Tambah Periode @break
                                @case('percepat') 🚀 Percepatan @break
                                @case('mundur') 🚪 Mundur @break
                                @case('permohonanmagangkembali') 🔄 Magang Kembali @break
                                @default {{ $m->jenis_permohonan }}
                            @endswitch
                        </td>
                        <td class="border px-3 py-2">{{ $m->tanggal_mulai ? \Carbon\Carbon::parse($m->tanggal_mulai)->format('d/m/Y') : '-' }}</td>
                        <td class="border px-3 py-2">{{ $m->tanggal_selesai ? \Carbon\Carbon::parse($m->tanggal_selesai)->format('d/m/Y') : '-' }}</td>
                        <td class="border px-3 py-2">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                {{ $m->status == 'disetujui' ? 'bg-green-100 text-green-800' : 
                                   ($m->status == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($m->status) }}
                            </span>
                        </td>
                        <td class="border px-3 py-2">{{ $m->tanggal_pengajuan ? \Carbon\Carbon::parse($m->tanggal_pengajuan)->format('d/m/Y') : '-' }}</td>
                        <td class="border px-3 py-2 text-center">
                            @if($m->surat)
                                <a href="{{ asset('storage/' . $m->surat) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-1 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-xs">
                                    📄 Lihat
                                </a>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

    {{-- Tombol kembali --}}
    <div class="mt-6">
        <a href="{{ route('admin.peserta-magang') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded">
           ← Kembali
        </a>
    </div>
</div>
@endsection
