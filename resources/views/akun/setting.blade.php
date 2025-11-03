<x-guest-layout>
    <form method="POST" action="{{ route('akun.update') }}">
        @csrf

        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Pengaturan Akun</h2>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" class="block mt-1 w-full"
                          type="text"
                          name="name"
                          :value="old('name', $user->name)"
                          required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password Baru (Opsional)')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation"
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Info -->
        <div class="mt-4 text-sm text-gray-600">
            <p>Setelah memperbarui akun, Anda akan otomatis logout dan perlu login kembali.</p>
        </div>

        <!-- Tombol -->
        <div class="flex items-center justify-end mt-6">
            <a href="{{ url()->previous() }}"
               class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Kembali') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Simpan Perubahan') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
