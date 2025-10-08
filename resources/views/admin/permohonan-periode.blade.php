@extends('layouts.admin-layout')

@section('content')
<div class="p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">📋 Daftar Permohonan Periode Magang</h2>
    
    {{-- Search --}}
    <form method="GET" class="mb-4">
        <input name="search" type="text" placeholder="Cari nama..." value="{{ request('search') }}"
               class="border rounded px-4 py-2 w-1/3 text-sm focus:outline-none focus:ring">
        <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded text-sm">Cari</button>
    </form>

    <table class="w-full border-collapse border text-sm">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Peserta</th>
                <th class="border p-2">Jenis</th>
                <th class="border p-2">Alasan</th>
                <th class="border p-2">Tanggal</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permohonan as $p)
                <tr>
                    <td class="border p-2">{{ $p->peserta->user->name ?? '-' }}</td>
                    <td class="border p-2 capitalize">{{ $p->jenis_permohonan }}</td>
                    <td class="border p-2">{{ $p->alasan }}</td>
                    <td class="border p-2">{{ $p->tanggal_pengajuan }}</td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded 
                            {{ $p->status == 'pending' ? 'bg-yellow-200' : 
                               ($p->status == 'disetujui' ? 'bg-green-200' : 'bg-red-200') }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td class="border p-2">
                        <div class="flex gap-2">
                            @if($p->status == 'pending')
                                <form action="{{ route('admin.permohonan.approve', $p->id) }}" method="POST" class="form-approve">
                                    @csrf
                                  
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Setujui</button>
                                </form>
                                <form action="{{ route('admin.permohonan.reject', $p->id) }}" method="POST" class="form-reject">
                                    @csrf
                                  
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Tolak</button>
                                </form>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center p-4">Tidak ada permohonan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
                confirmButtonText: 'Ya, Setujui'
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
                confirmButtonText: 'Ya, Tolak'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
