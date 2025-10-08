@extends('layouts.admin-layout')

@section('title', 'Kelola Akun User')

@section('content')
<div class="px-6 py-4">
    <h1 class="text-2xl font-bold mb-6">Kelola Akun User</h1>

    {{-- Search --}}
    <form method="GET" class="mb-4">
        <input name="search" type="text" placeholder="Cari nama/email..." value="{{ request('search') }}"
               class="border rounded px-4 py-2 w-1/3 text-sm focus:outline-none focus:ring">
        <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded text-sm">Cari</button>
    </form>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.akun-user.create-unitkerja') }}"
       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm">
        + Buat Admin Unit Kerja
    </a>
</div>


    {{-- Table --}}
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-sm text-left text-gray-800">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-3 py-2">Nama</th>
                    <th class="px-3 py-2">Email</th>
                    <th class="px-3 py-2">Role</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b">
                        <td class="px-3 py-2">{{ $user->name }}</td>
                        <td class="px-3 py-2">{{ $user->email }}</td>
                        <td class="px-3 py-2">{{ $user->role }}</td>
                        <td class="px-3 py-2">{{ $user->status }}</td>
                        <td class="px-3 py-2">
                            <a href="{{ route('admin.akun-user.edit', $user->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('admin.akun-user.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus akun ini?')" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-4">Belum ada user.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
