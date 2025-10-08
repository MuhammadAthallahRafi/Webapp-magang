@extends('layouts.admin-layout')

@section('title', 'Buat Admin Unit Kerja')

@section('content')
<div class="px-6 py-4">
    <h1 class="text-2xl font-bold mb-6">Buat Admin Unit Kerja</h1>

    <div class="bg-white rounded shadow p-6">
        <form action="{{ route('admin.akun-user.store-unitkerja') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="border rounded w-full px-3 py-2 text-sm">
                @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="border rounded w-full px-3 py-2 text-sm">
                @error('email') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password"
                       class="border rounded w-full px-3 py-2 text-sm">
                @error('password') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                       class="border rounded w-full px-3 py-2 text-sm">
            </div>

           <div>
                <label class="block text-sm font-medium">Role</label>
                <select name="role" class="border rounded w-full px-3 py-2 text-sm">
                    <option value="admin-unitkerja" selected>Admin Unit Kerja</option>
                </select>
                @error('role') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>

    <div>
        <label class="block text-sm font-medium">Divisi</label>
        <select name="divisi" class="border rounded w-full px-3 py-2 text-sm">
            <option value="">-- Pilih Divisi --</option>
            <option value="IT" {{ old('divisi') == 'IT' ? 'selected' : '' }}>IT</option>
            <option value="HRD" {{ old('divisi') == 'HRD' ? 'selected' : '' }}>HRD</option>
            <option value="Keuangan" {{ old('divisi') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
            <option value="Pemasaran" {{ old('divisi') == 'Pemasaran' ? 'selected' : '' }}>Pemasaran</option>
        </select>
        @error('divisi') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
    </div>


            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded shadow">Simpan</button>
                <a href="{{ route('admin.akun-user.index') }}" class="px-4 py-2 bg-gray-200 rounded shadow">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
