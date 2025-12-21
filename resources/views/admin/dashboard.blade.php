@extends('layouts.admin-layout')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-6 min-h-screen bg-gradient-to-br from-slate-50 to-blue-50/30">
    <!-- Header -->
     <!-- <div class="flex justify-between items-center">
        <div>
            <h3 class="font-semibold text-green-800">🔄 Aktivasi Periode Hari Ini</h3>
            <p class="text-sm text-green-600 mt-1">
                Jalankan untuk mengaktifkan periode yang tanggal mulainya <strong>hari ini</strong>
            </p>
        </div>
        <form action="{{ route('admin.activate-today-periods') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                🚀 Aktifkan Periode Hari Ini
            </button>
        </form>
    </div> -->

    <!-- tambahkan di admin dashboard atau halaman permohonan -->
<div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
    
    
    <!-- Tampilkan output jika ada -->
    @if(session('output'))
    <div class="mt-3 p-3 bg-gray-100 rounded text-sm font-mono">
        <pre>{{ session('output') }}</pre>
    </div>
    @endif
</div>
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-3">📊 Dashboard Admin</h1>
        <p class="text-gray-600 text-lg">Ringkasan statistik dan aktivitas sistem</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto mb-12">
        @php
            $stats = [
                ['title' => 'Pelamar Pending', 'count' => $pelamarPending, 'icon' => '📥', 'color' => 'from-blue-500 to-blue-600', 'bg' => 'bg-blue-50', 'text' => 'text-blue-700'],
                ['title' => 'Pelamar Diterima', 'count' => $pelamarDiterima, 'icon' => '✅', 'color' => 'from-green-500 to-green-600', 'bg' => 'bg-green-50', 'text' => 'text-green-700'],
                ['title' => 'Pelamar Ditolak', 'count' => $pelamarDitolak, 'icon' => '❌', 'color' => 'from-red-500 to-red-600', 'bg' => 'bg-red-50', 'text' => 'text-red-700'],
                ['title' => 'Peserta Aktif', 'count' => $pesertaAktif, 'icon' => '👥', 'color' => 'from-indigo-500 to-indigo-600', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-700'],
                ['title' => 'Peserta Lulus', 'count' => $pesertaLulus, 'icon' => '🎓', 'color' => 'from-teal-500 to-teal-600', 'bg' => 'bg-teal-50', 'text' => 'text-teal-700'],
                ['title' => 'Permohonan Pending', 'count' => $permohonanPending, 'icon' => '📋', 'color' => 'from-purple-500 to-purple-600', 'bg' => 'bg-purple-50', 'text' => 'text-purple-700'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="group relative">
            <div class="relative bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all duration-300 hover:shadow-lg hover:scale-[1.02]">
                <!-- Icon Background -->
                <div class="absolute top-4 right-4 w-16 h-16 rounded-full {{ $stat['bg'] }} opacity-50"></div>
                
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm font-medium mb-1">{{ $stat['title'] }}</p>
                        <h3 class="text-3xl font-bold {{ $stat['text'] }} mb-2">{{ $stat['count'] }}</h3>
                        <div class="w-12 h-1 bg-gradient-to-r {{ $stat['color'] }} rounded-full"></div>
                    </div>
                    <div class="text-3xl p-3 rounded-xl {{ $stat['bg'] }}">
                        {{ $stat['icon'] }}
                    </div>
                </div>
                
                <!-- Progress bar (optional) -->
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full bg-gradient-to-r {{ $stat['color'] }}" 
                             style="width: {{ min(($stat['count'] / ($pelamarPending + $pelamarDiterima + $pelamarDitolak + $pesertaTotal + $pesertaLulus + $permohonanPending)) * 100, 100) }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Total Summary Card -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-gradient-to-r from-slate-800 to-slate-700 rounded-2xl shadow-xl p-8 text-gray">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">📈 Total Data Sistem</h2>
                    <p class="text-slate-300 text-lg">Seluruh entitas yang tercatat dalam sistem</p>
                </div>
                <div class="text-right">
                    <p id="totalCounter" class="text-5xl font-bold text-gray mb-1">
                        {{ $pelamarPending + $pelamarDiterima + $pelamarDitolak + $pesertaTotal + $pesertaLulus + $permohonanPending }}
                    </p>
                    <p class="text-slate-300 text-sm">Total Records</p>
                </div>
            </div>
            
            <!-- Mini stats row -->
            <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-slate-600">
                <div class="text-center">
                    <p class="text-2xl font-bold text-blue-300">{{ $pelamarPending + $pelamarDiterima + $pelamarDitolak }}</p>
                    <p class="text-slate-400 text-sm">Total Berkas Pelamar</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-green-300">{{ $pesertaTotal }}</p>
                    <p class="text-slate-400 text-sm">Total Peserta Absolute</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-purple-300">{{ $permohonanPending}}</p>
                    <p class="text-slate-400 text-sm">Total Berkas Permohonan</p>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Animated counter for total
    const totalElement = document.getElementById("totalCounter");
    const target = parseInt(totalElement.innerText);
    let current = 0;
    const duration = 2000; // 2 seconds
    const steps = 60;
    const increment = target / steps;
    const stepTime = duration / steps;

    const counter = setInterval(() => {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(counter);
        }
        totalElement.innerText = Math.floor(current).toLocaleString();
    }, stepTime);

    // Add hover effects to cards
    const cards = document.querySelectorAll('.group');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.group {
    animation: fadeInUp 0.6s ease-out forwards;
}

.group:nth-child(1) { animation-delay: 0.1s; }
.group:nth-child(2) { animation-delay: 0.2s; }
.group:nth-child(3) { animation-delay: 0.3s; }
.group:nth-child(4) { animation-delay: 0.4s; }
.group:nth-child(5) { animation-delay: 0.5s; }
.group:nth-child(6) { animation-delay: 0.6s; }
</style>
@endsection