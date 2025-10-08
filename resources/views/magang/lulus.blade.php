@extends('layouts.pelamar')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow-md rounded p-6 mt-10 text-center">
    <h1 class="text-2xl font-bold text-blue-600 mb-4">Status Magang: Lulus</h1>
    <p class="text-gray-700 mb-4">
        Halo, {{ $peserta->nama }}. Kamu telah Menyelesaikan Magang bersama kami.
    </p>
    <p class="text-gray-500 mb-6">
        Terima kasih atas kontribusimu selama magang di instansi kami.
    </p>
    <p class="text-gray-500 mb-6">
        Untuk Percetakan sertifikat Silahkan Kontak Mentor Anda, Terima kasih.
    </p>

    <a href="/" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Kembali ke Beranda
    </a>
    <div x-data="{ showpermohonanMagangKembali: false }" class="mt-6">
    <button type="button"
        @click="showpermohonanMagangKembali = true"
        class="w-full px-4 py-2 bg-gradient-to-r from-green-300 to-green-400 hover:from-green-400 hover:to-green-500 
               text-green-900 font-semibold text-sm rounded-lg shadow-md transition-all duration-200 flex items-center justify-center gap-2">
        <span class="text-lg">➕</span> Ajukan Permohonan Magang Kembali
    </button>

    <!-- Modal -->
    <div x-show="showpermohonanMagangKembali"
         x-cloak
         x-transition.opacity
         @click.self="showpermohonanMagangKembali = false"
         class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 backdrop-blur-sm">

        <div class="bg-white p-6 rounded-2xl shadow-xl w-[28rem] transform transition-all duration-300 scale-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4 text-center border-b pb-2">
                Ajukan Permohonan Magang Kembali
            </h2>

            <form action="{{ route('magang.periode.permohonanmagangkembali') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" required
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-300 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" required
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-300 focus:outline-none">
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-4 border-t">
                    <button type="button"
                        @click="showpermohonanMagangKembali = false"
                        class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-100 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-orange-500 text-white hover:bg-orange-600 shadow-md transition">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


    
</div>
@endsection
