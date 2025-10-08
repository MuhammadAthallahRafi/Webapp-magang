@extends('layouts.admin-layout')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-8 min-h-screen bg-gradient-to-br from-gray-100 via-gray-50 to-gray-100">
    <h1 class="text-3xl font-bold mb-10 text-gray-800 text-center">📈 Pusat Kontrol Admin</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center">

        @php
            $cards = [
                ['name' => 'Pelamar Pending', 'value' => $pelamarPending, 'color' => 'blue', 'icon' => '💼'],
                ['name' => 'Pelamar Diterima', 'value' => $pelamarDiterima, 'color' => 'green', 'icon' => '✅'],
                ['name' => 'Pelamar Ditolak', 'value' => $pelamarDitolak, 'color' => 'red', 'icon' => '❌'],
                ['name' => 'Peserta Aktif', 'value' => $pesertaTotal, 'color' => 'indigo', 'icon' => '👷‍♂️'],
                ['name' => 'Peserta Lulus', 'value' => $pesertaLulus, 'color' => 'teal', 'icon' => '🎓'],
                ['name' => 'Permohonan Pending', 'value' => $permohonanPending, 'color' => 'purple', 'icon' => '📄'],
            ];
        @endphp

        @foreach($cards as $index => $c)
            <div 
                class="relative bg-white/70 backdrop-blur-xl border border-gray-200 shadow-md rounded-2xl w-60 h-60 flex flex-col items-center justify-center text-center transform transition-all duration-500 hover:scale-105 hover:shadow-xl animate-fade-in"
                style="animation-delay: {{ $index * 0.1 }}s;"
            >
                <div class="text-5xl mb-2">{{ $c['icon'] }}</div>
                <div class="text-5xl font-extrabold text-{{ $c['color'] }}-600 drop-shadow-sm">{{ $c['value'] }}</div>
                <p class="mt-3 text-gray-700 font-semibold">{{ $c['name'] }}</p>
                <div class="absolute inset-0 rounded-2xl border-t-4 border-{{ $c['color'] }}-400 opacity-20"></div>
            </div>
        @endforeach

    </div>

    {{-- 🔹 Total Data --}}
    <div class="mt-16 flex justify-center">
        <div class="bg-white/80 backdrop-blur-md border border-blue-200 rounded-2xl shadow-xl px-12 py-8 text-center">
            <h2 class="text-lg font-semibold text-blue-700 mb-2">🧮 Total Data Sistem</h2>
            <p id="totalCounter" class="text-5xl font-extrabold text-blue-600 mb-2">
                {{ $pelamarPending + $pelamarDiterima + $pelamarDitolak + $pesertaTotal + $pesertaLulus + $permohonanPending }}
            </p>
            <p class="text-sm text-gray-500 italic">Semua entitas yang tercatat di sistem</p>
        </div>
    </div>
</div>

{{-- ✨ Animasi --}}
<style>
@keyframes fade-in {
    from { opacity: 0; transform: scale(0.8); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fade-in {
    animation: fade-in 0.5s ease forwards;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const totalElement = document.getElementById("totalCounter");
    const target = parseInt(totalElement.innerText);
    let current = 0;
    const step = target / 40;
    const counter = setInterval(() => {
        current += step;
        if (current >= target) {
            current = target;
            clearInterval(counter);
        }
        totalElement.innerText = Math.floor(current);
    }, 25);
});
</script>
@endsection
