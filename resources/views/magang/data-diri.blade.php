
@extends('layouts.magang-layout')

@section('title', 'Data Diri')
@section('page-title', 'Data Diri')

@section('content')
<div class="space-y-6">

    <!-- Informasi Peserta -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Informasi Peserta Magang</h2>
        <div class="grid grid-cols-2 gap-4">
            <div><strong>Nama:</strong> <p>{{ $peserta->nama }}</p></div>
            <div><strong>ID Magang:</strong><p>{{ $peserta->id_magang ?? '-' }}</p></div>
            <div><strong>Divisi:</strong><p>{{ $peserta->divisi ?? '-' }}</p></div>
            <div><strong>NIK:</strong> <p>{{ $peserta->nik }}</p></div>
            <div><strong>Kampus:</strong> <p>{{ $peserta->kampus }}</p></div>
            <div><strong>Jurusan:</strong> <p>{{ $peserta->jurusan }}</p></div>
            <div><strong>Tanggal Mulai:</strong> <p>{{ $peserta->tanggal_mulai }}</p></div>
            <div><strong>Tanggal Selesai:</strong> <p>{{ $peserta->tanggal_selesai }}</p></div>         
            <div><strong>No. Telepon:</strong> <p>{{ $peserta->no_telp }}</p></div>
            <div><strong>Alamat:</strong><p>{{ $peserta->alamat }}</p></div>
        </div>
        <button type="button"
        onclick="document.getElementById('modal-pendidikan-{{ $peserta->id }}').classList.remove('hidden')"
        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
    Tambah Pendidikan
</button>

<div id="modal-pendidikan-{{ $peserta->id }}"
     class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-lg w-96 p-5">
        <h2 class="text-lg font-semibold mb-3 border-b pb-2 text-gray-700">Tambah Pendidikan</h2>
        <form action="{{ route('magang.data-diri.tambahPendidikan', $peserta->id) }}" method="POST">
            @csrf
            <input type="text" name="pendidikan_baru" required
                   class="w-full border rounded px-3 py-2 mb-3 text-sm"
                   placeholder="Masukkan nama sekolah / kampus baru...">
            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="document.getElementById('modal-pendidikan-{{ $peserta->id }}').classList.add('hidden')"
                        class="px-3 py-1 border rounded text-sm">Batal</button>
                <button type="submit"
                        class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">Tambah</button>
            </div>
        </form>
    </div>
</div>

    </div>

    <div x-data="{ showPercepat: false, showTambah: false }" class="mt-6 space-y-4">

        <!-- Tombol Percepatan -->
        <button type="button"
                @click="showPercepat = true"
                class="w-full px-4 py-2 bg-red-200 hover:bg-red-300 rounded-lg shadow font-semibold text-sm">
            🚀 Ajukan Percepatan Magang
        </button>

        <!-- Modal Percepatan -->
        

        <div x-show="showPercepat" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white p-5 rounded shadow-md w-[28rem]">
                <h2 class="text-lg font-bold mb-4">🚀 Ajukan Percepatan Magang</h2>
                <form action="{{ route('magang.periode.percepat') }}" method="POST">
                    @csrf
                    @if($periodeAktif)
                        <input type="hidden" name="periode_id" value="{{ $periodeAktif->id }}">
                    @endif


                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Tanggal Selesai Baru</label>
                        <input type="date" name="tanggal_selesai" required class="w-full border rounded p-2">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Alasan</label>
                        <textarea name="alasan" rows="3" required class="w-full border rounded p-2"></textarea>
                    </div>

                    <div class="flex justify-end mt-4 gap-2">
                        <button type="button" @click="showPercepat = false"
                                class="px-3 py-1 rounded border">Batal</button>
                        <button type="submit"
                                class="bg-orange-500 text-white px-3 py-1 rounded hover:bg-orange-700">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tombol Tambah Periode -->
        <button type="button"
                @click="showTambah = true"
                class="w-full px-4 py-2 bg-green-200 hover:bg-green-300 rounded-lg shadow font-semibold text-sm">
            ➕ Ajukan Tambah Periode
        </button>

        <!-- Modal Tambah -->
        <div x-show="showTambah" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white p-5 rounded shadow-md w-[28rem]">
                <h2 class="text-lg font-bold mb-4">➕ Ajukan Tambah Periode</h2>
                <form action="{{ route('magang.periode.tambah') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Alasan</label>
                        <textarea name="alasan" rows="3" required class="w-full border rounded p-2"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" required class="w-full border rounded p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" required class="w-full border rounded p-2">
                        </div>
                    </div>

                    <div class="flex justify-end mt-4 gap-2">
                        <button type="button" @click="showTambah = false"
                                class="px-3 py-1 rounded border">Batal</button>
                        <button type="submit"
                                class="bg-orange-500 text-white px-3 py-1 rounded hover:bg-orange-700">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-data="{ showMundur: false }">
    <!-- Tombol untuk buka modal -->
    <button @click="showMundur = true" 
            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700">
        Ajukan Mundur
    </button>

    <!-- Modal -->
    <div x-show="showMundur" 
         class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
         x-cloak>
        <div class="bg-white p-5 rounded shadow-md w-[28rem]">
            <h2 class="text-lg font-bold mb-4">Ajukan Mundur</h2>
            <form action="{{ route('magang.periode.mundur') }}" method="POST">
                @csrf
                @if($periodeAktif)
                    <input type="hidden" name="periode_id" value="{{ $periodeAktif->id }}">
                @endif
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Alasan</label>
                    <textarea name="alasan" rows="3" required class="w-full border rounded p-2"></textarea>
                </div>

                <div class="flex justify-end mt-4 gap-2">
                    <button type="button" @click="showMundur = false"
                            class="px-3 py-1 rounded border">Batal</button>
                    <button type="submit"
                            class="bg-orange-500 text-white px-3 py-1 rounded hover:bg-orange-700">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Riwayat Permohonan -->
    <div class="mt-8">
        <h2 class="text-lg font-semibold mb-3">Riwayat Permohonan Periode</h2>

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="w-full text-sm text-left text-gray-800">
                <thead class="bg-orange-500 text-white">
                    <tr>
                        <th class="px-3 py-2">Jenis</th>
                        <th class="px-3 py-2">Alasan</th>
                        <th class="px-3 py-2">Tanggal Pengajuan</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Tanggal Disetujui</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($permohonans as $p)
                        <tr class="border-b">
                            <td class="px-3 py-2 capitalize">
                                @switch($p->jenis_permohonan)
                                    @case('tambah')
                                        Tambah Periode
                                        @break

                                    @case('percepat')
                                        Percepatan
                                        @break

                                    @case('mundur')
                                        Pengunduran Diri
                                        @break

                                    @case('permohonanmagangkembali')
                                        Permohonan Magang Kembali
                                        @break

                                    @default
                                        -
                                @endswitch

                            </td>
                            <td class="px-3 py-2">{{ $p->alasan }}</td>
                            <td class="px-3 py-2">{{ $p->tanggal_pengajuan?->format('d M Y') }}</td>
                            <td class="px-3 py-2">
                                @if($p->status === 'pending')
                                    <span class="px-2 py-1 bg-yellow-200 rounded">Pending</span>
                                @elseif($p->status === 'disetujui')
                                    <span class="px-2 py-1 bg-green-200 rounded">Disetujui</span>
                                @elseif($p->status === 'ditolak')
                                    <span class="px-2 py-1 bg-red-200 rounded">Ditolak</span>
                                @endif

                            </td>
                            <td class="px-3 py-2">
                                {{ $p->tanggal_disetujui ? $p->tanggal_disetujui->format('d M Y') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Belum ada permohonan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(!$periodeAktif)
        <p class="text-sm text-red-500 mt-2">Belum ada periode terdaftar. Hubungi admin jika ini keliru.</p>
    @endif

</div>
@endsection

