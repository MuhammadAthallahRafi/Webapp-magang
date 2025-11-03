@extends('layouts.admin-layout')

@section('title', 'Kelola Akun User')

@section('content')
<div class="px-6 py-4">
    <h1 class="text-2xl font-bold mb-6">Kelola Akun User</h1>

    {{-- 🔍 Search --}}
    <form method="GET" class="mb-4 flex items-center gap-2">
        <input name="search" type="text" placeholder="Cari nama atau email..."
               value="{{ request('search') }}"
               class="border border-gray-300 rounded px-4 py-2 w-1/3 text-sm focus:outline-none focus:ring focus:ring-blue-200">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium">
            Cari
        </button>
    </form>

    {{-- ✅ Flash Message --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- ➕ Tombol Buat Admin Unit Kerja --}}
    <a href="{{ route('admin.akun-user.create-unitkerja') }}"
       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm font-medium inline-block mb-4">
        + Buat Admin Unit Kerja
    </a>

    {{-- 📋 Tabel Data User --}}
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-sm text-left text-gray-800">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2 capitalize">{{ $user->role }}</td>

                        {{-- 🟢 Status Badge --}}
                        <td class="px-4 py-2">
                            @if ($user->status === 'off')
                                <span class="px-2 py-1 text-xs font-semibold text-red-600 bg-red-100 rounded-full">
                                    Nonaktif
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded-full">
                                    Aktif
                                </span>
                            @endif
                        </td>

                        {{-- ⚙️ Aksi --}}
                        <td class="px-4 py-2 text-center space-x-2">

                            {{-- Tombol Toggle --}}
                            <form action="{{ route('admin.akun-user.toggle', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin mengubah status akun ini?')">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-1 text-xs font-semibold rounded transition duration-150 
                                    @if($user->status === 'off')
                                        bg-green-500 hover:bg-green-600 text-white
                                    @else
                                        bg-red-500 hover:bg-red-600 text-white
                                    @endif">
                                    @if($user->status === 'off')
                                        Aktifkan
                                    @else
                                        Nonaktifkan
                                    @endif
                                </button>
                            </form>

                            {{-- Tombol Edit --}}
                            <a href="{{ route('admin.akun-user.edit', $user->id) }}"
                               class="text-blue-600 hover:underline text-xs font-semibold">
                                Edit
                            </a>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.akun-user.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus akun ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-xs font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">
                            Belum ada data user.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 📄 Pagination --}}
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
