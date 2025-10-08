@extends('layouts.admin-layout')

@section('title', 'Edit Akun User')

@section('content')
<div class="px-6 py-4">
    <h1 class="text-2xl font-bold mb-6">Edit Akun User</h1>

    {{-- Flash Message --}}
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

    {{-- Form --}}
    <div class="bg-white p-6 rounded shadow max-w-lg">
        <form action="{{ route('admin.akun-user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                    class="mt-1 block w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                    class="mt-1 block w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Role --}}
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select id="role" name="role"
                    class="mt-1 block w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="magang" {{ $user->role == 'magang' ? 'selected' : '' }}>Magang</option>
                    <option value="pelamar" {{ $user->role == 'pelamar' ? 'selected' : '' }}>Pelamar</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status"
                    class="mt-1 block w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                    <option value="on" {{ $user->status == 'on' ? 'selected' : '' }}>Aktif</option>
                    <option value="off" {{ $user->status == 'off' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.akun-user.index') }}" 
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2 hover:bg-gray-400">
                    Batal
                </a>
                <button type="submit" 
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
