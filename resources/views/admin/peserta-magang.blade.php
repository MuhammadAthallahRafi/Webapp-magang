@extends('layouts.admin-layout')

@section('title', 'Peserta Magang')

@section('content')
<div class="px-6 py-4" x-data="filterState()">
    <h1 class="text-2xl font-bold mb-6">Daftar Peserta Magang</h1>

    <!-- Header dengan Search dan Filter Button -->
    <div class="flex justify-between items-center mb-6">
        <!-- Search Box -->
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari nama, NIK, atau ID..." 
                   class="border rounded-lg px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                🔍 Cari
            </button>
        </form>
        
        <!-- Filter Button -->
        <button type="button" 
                @click="openFilterModal()"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 flex items-center gap-2">
            ⚙️ Filter
            @if(request()->anyFilled(['status', 'divisi', 'kelamin', 'tahun_mulai', 'tahun_selesai', 'nilai_min', 'nilai_max']))
            <span class="bg-red-500 text-white rounded-full w-2 h-2"></span>
            @endif
        </button>
    </div>

    <!-- Filter Modal -->
    <div x-show="isFilterModalOpen" 
         x-cloak
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 backdrop-blur-sm"
         @click.self="closeFilterModal()"
         @keydown.escape="closeFilterModal()">
         
        <div class="bg-white rounded-2xl shadow-xl w-[32rem] transform transition-all duration-300 scale-100">
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Filter Data Peserta</h2>
                <button type="button" 
                        @click="closeFilterModal()"
                        class="text-gray-500 hover:text-gray-700 text-xl rounded-full hover:bg-gray-100 w-8 h-8 flex items-center justify-center">
                    ×
                </button>
            </div>

            <!-- Filter Form -->
            <form method="GET" class="p-6 space-y-4">
                <!-- Status & Divisi - Horizontal -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="mundur" {{ request('status') == 'mundur' ? 'selected' : '' }}>Mundur</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Divisi</label>
                        <select name="divisi" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Divisi</option>
                            @foreach($filterOptions['divisiOptions'] as $divisi)
                            <option value="{{ $divisi }}" {{ request('divisi') == $divisi ? 'selected' : '' }}>
                                {{ $divisi }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Jenis Kelamin & Batch - Horizontal -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                        <select name="kelamin" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua</option>
                            <option value="L" {{ request('kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ request('kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    
                    
                </div>

                <!-- Tahun Mulai & Selesai - Horizontal -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Mulai</label>
                        <select name="tahun_mulai" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Tahun</option>
                            @foreach($filterOptions['tahunOptions'] as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun_mulai') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Selesai</label>
                        <select name="tahun_selesai" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Tahun</option>
                            @foreach($filterOptions['tahunOptions'] as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun_selesai') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Rentang Nilai - Horizontal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Nilai</label>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="number" name="nilai_min" value="{{ request('nilai_min') }}" 
                               placeholder="Nilai minimal" min="0" max="100"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <input type="number" name="nilai_max" value="{{ request('nilai_max') }}" 
                               placeholder="Nilai maksimal" min="0" max="100"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" 
                            @click="closeFilterModal()"
                            class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition text-sm">
                        Batal
                    </button>
                    <a href="{{ request()->url() }}" 
                       class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition text-sm">
                        🔄 Reset
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-medium">
                        ✅ Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Flash Message -->
    @if (session('success'))
        <div 
            x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 3000)" 
            x-show="show"
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"
        >
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div 
            x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 3000)" 
            x-show="show"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"
        >
            {{ session('error') }}
        </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-sm text-left text-gray-800">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-3 py-2">Nama</th>
                    <th class="px-3 py-2">No. Tlp</th>
                    <th class="px-3 py-2">Email</th>
                    <th class="px-3 py-2">Tanggal Mulai</th>
                    <th class="px-3 py-2">Tanggal Selesai</th>
                    <th class="px-3 py-2">Unit Kerja</th>
                    <th class="px-3 py-2">Nilai</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesertas as $peserta)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-3 py-2">{{ $peserta->nama }}</td>
                        <td class="px-3 py-2">{{ $peserta->no_telp }}</td>
                        <td class="px-3 py-2">{{ $peserta->user->email }}</td>
                        <td class="px-3 py-2">{{ $peserta->tanggal_mulai ? \Carbon\Carbon::parse($peserta->tanggal_mulai)->format('d/m/Y') : '-' }}</td>
                        <td class="px-3 py-2">{{ $peserta->tanggal_selesai ? \Carbon\Carbon::parse($peserta->tanggal_selesai)->format('d/m/Y') : '-' }}</td>         
                        <td class="px-3 py-2">{{ $peserta->divisi ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $peserta->nilai ?? '-' }}</td>
                        <td class="px-3 py-2">
                            <span class="px-2 py-1 rounded-full text-xs 
                                @if($peserta->status == 'aktif') bg-green-100 text-green-800
                                @elseif($peserta->status == 'lulus') bg-blue-100 text-blue-800
                                @elseif($peserta->status == 'gagal') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($peserta->status) }}
                            </span>
                        </td>
                        <td class="px-3 py-2 flex items-center gap-2">
                            <!-- Detail Peserta -->
                            <a href="{{ route('admin.peserta-magang.lihat', $peserta->id) }}"
                               class="p-2 rounded-full bg-blue-100 hover:bg-blue-200 text-blue-700 transition text-lg"
                               title="Detail Peserta">
                                🧍
                            </a>

                            <!-- Riwayat Absensi -->
                            <a href="{{ route('admin.peserta-magang.absensi', $peserta->id) }}"
                               class="p-2 rounded-full bg-green-100 hover:bg-green-200 text-green-700 transition text-lg"
                               title="Riwayat Absensi">
                                📅
                            </a>

                            <!-- Riwayat Periode -->
                            <a href="{{ route('admin.peserta-magang.periode', $peserta->id) }}"
                               class="p-2 rounded-full bg-yellow-100 hover:bg-yellow-200 text-yellow-700 transition text-lg"
                               title="Periode & Permohonan">
                                ⏳
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-gray-500">
                            Tidak ada data peserta yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function filterState() {
    return {
        isFilterModalOpen: false,
        
        openFilterModal() {
            this.isFilterModalOpen = true;
            document.body.classList.add('overflow-hidden');
        },
        
        closeFilterModal() {
            this.isFilterModalOpen = false;
            document.body.classList.remove('overflow-hidden');
        }
    }
}
</script>
@endsection