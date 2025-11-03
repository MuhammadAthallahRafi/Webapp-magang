@extends('layouts.admin-layout')

@section('title', 'Permohonan Periode Magang')

@section('content')
<div class="px-6 py-4" x-data="filterState()">
    <h1 class="text-2xl font-bold mb-6">📋 Daftar Permohonan Periode Magang</h1>

    <!-- Header dengan Search dan Filter Button -->
    <div class="flex justify-between items-center mb-6">
        <!-- Search Box -->
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari nama peserta atau NIK..." 
                   class="border rounded-lg px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-500 text-gray px-4 py-2 rounded-lg hover:bg-blue-600">
                🔍 Cari
            </button>
        </form>
        
        <!-- Filter Button -->
        <button type="button" 
                @click="openFilterModal()"
                class="bg-gray-500 text-gray px-4 py-2 rounded-lg hover:bg-gray-600 flex items-center gap-2">
            ⚙️ Filter
            @if(request()->anyFilled(['jenis_permohonan', 'status', 'tahun_mulai', 'tahun_selesai']))
            <span class="bg-red-500 text-gray rounded-full w-2 h-2"></span>
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
                <h2 class="text-xl font-bold text-gray-800">Filter Permohonan Periode</h2>
                <button type="button" 
                        @click="closeFilterModal()"
                        class="text-gray-500 hover:text-gray-700 text-xl rounded-full hover:bg-gray-100 w-8 h-8 flex items-center justify-center">
                    ×
                </button>
            </div>

            <!-- Filter Form -->
            <form method="GET" class="p-6 space-y-4">
                <!-- Jenis Permohonan & Status - Horizontal -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Permohonan</label>
                        <select name="jenis_permohonan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Jenis</option>
                            <option value="percepat" {{ request('jenis_permohonan') == 'percepat' ? 'selected' : '' }}>Percepat</option>
                            <option value="tambah" {{ request('jenis_permohonan') == 'tambah' ? 'selected' : '' }}>Tambah</option>
                            <option value="mundur" {{ request('jenis_permohonan') == 'mundur' ? 'selected' : '' }}>Mundur</option>
                            <option value="permohonanmagangkembali" {{ request('jenis_permohonan') == 'permohonanmagangkembali' ? 'selected' : '' }}>Magang Kembali</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
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

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" 
                            @click="closeFilterModal()"
                            class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition text-sm">
                        Batal
                    </button>
                    <a href="{{ request()->url() }}" 
                       class="px-4 py-2 bg-gray-500 text-gray rounded-lg hover:bg-gray-600 transition text-sm">
                        🔄 Reset
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-500 text-gray rounded-lg hover:bg-blue-600 transition text-sm font-medium">
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
    <div class="overflow-x-auto bg-white rounded-lg shadow-sm border">
        <table class="w-full text-sm text-left text-gray-800">
            <thead class="bg-blue-600 text-gray">
                <tr>
                    <th class="px-4 py-3 font-semibold">Peserta</th>
                    <th class="px-4 py-3 font-semibold">Jenis</th>
                    <th class="px-4 py-3 font-semibold">Alasan</th>
                    <th class="px-4 py-3 font-semibold">Tanggal Mulai</th>
                    <th class="px-4 py-3 font-semibold">Tanggal Selesai</th>
                    <th class="px-4 py-3 font-semibold">Surat</th>
                    <th class="px-4 py-3 font-semibold">Status</th>
                    <th class="px-4 py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permohonan as $p)
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 font-medium">{{ $p->peserta->user->name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 capitalize">
                                @switch($p->jenis_permohonan)
                                    @case('tambah')
                                        ➕ Tambah Periode
                                        @break
                                    @case('percepat')
                                        🚀 Percepatan
                                        @break
                                    @case('mundur')
                                        🚪 Mundur
                                        @break
                                    @case('permohonanmagangkembali')
                                        🔄 Magang Kembali
                                        @break
                                    @default
                                        {{ $p->jenis_permohonan }}
                                @endswitch
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ Str::limit($p->alasan, 50) ?: '-' }}</td>
                        <td class="px-4 py-3">{{ $p->tanggal_mulai ? \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') : '-' }}</td>
                        <td class="px-4 py-3">{{ $p->tanggal_selesai ? \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') : '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($p->surat)
                                <a href="{{ asset('storage/' . $p->surat) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 hover:underline">
                                    📄 Lihat
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $p->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($p->status == 'disetujui' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <!-- Tombol Lihat Detail -->
                                <a href="{{ route('admin.permohonan-periode.lihat', $p->id) }}" 
                                   class="bg-blue-500 text-gray px-3 py-1 rounded text-xs hover:bg-blue-600 transition-colors">
                                    👁️ Detail
                                </a>
                                
                                @if($p->status == 'pending')
                                    <form action="{{ route('admin.permohonan-periode.approve', $p->id) }}" method="POST" class="inline form-approve">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-gray px-3 py-1 rounded text-xs hover:bg-green-600 transition-colors">
                                            ✅ Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.permohonan-periode.reject', $p->id) }}" method="POST" class="inline form-reject">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-gray px-3 py-1 rounded text-xs hover:bg-red-600 transition-colors">
                                            ❌ Tolak
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs">Selesai</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <span class="text-4xl mb-2">📭</span>
                                <p class="text-lg font-medium">Tidak ada permohonan</p>
                                <p class="text-sm">Belum ada permohonan periode magang</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($permohonan->hasPages())
    <div class="mt-6">
        {{ $permohonan->links() }}
    </div>
    @endif
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

// SweetAlert untuk konfirmasi
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.form-approve').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Setujui Permohonan?',
                text: "Data akan disetujui dan tidak bisa dibatalkan!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    document.querySelectorAll('.form-reject').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Tolak Permohonan?',
                text: "Data akan ditandai sebagai ditolak!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection