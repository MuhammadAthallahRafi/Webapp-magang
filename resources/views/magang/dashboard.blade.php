@php
    // Ambil bulan dari tanggal pertama di kalender
    $bulan = $kalender && count($kalender) > 0
        ? \Carbon\Carbon::parse($kalender[0]['tanggal'])->translatedFormat('F Y')
        : '';
@endphp

@extends('layouts.magang-layout')
@section('title', 'Dashboard Magang')
@section('page-title', 'Dashboard')
@section('content')
    

    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">Absensi Hari Ini</h1>

                    {{-- Dropdown Absensi --}}
            <form action="{{ route('dashboard.magang.absensi') }}" method="POST" class="inline-block">
                @csrf
                <select name="keterangan" class="border p-2 rounded" {{ $absensiHariIni ? 'disabled' : '' }}>
                    <option value="">-- Pilih --</option>
                    <option value="Hadir">✅Hadir</option>
                    <option value="Sakit">🤒Sakit</option>
                    <option value="Izin">📝Izin</option>
                    <option value="Alfa">⚠️Alfa</option>
                </select>
                <button type="submit" class="bg-green-500 text-white p-2 rounded" {{ $absensiHariIni ? 'disabled' : '' }}>
                    Absen
                </button>
            </form>

            {{-- Tombol Pulang --}}
            <form action="{{ route('dashboard.magang.pulang') }}"  method="POST" class="inline-block ml-4">
                @csrf
                <button type="submit" 
                    class="p-2 rounded {{ $absensiHariIni && !$absensiHariIni->jam_keluar ? 'bg-red-500 text-white' : 'bg-gray-400' }}"
                    {{ !$absensiHariIni || $absensiHariIni->jam_keluar ? 'disabled' : '' }}>
                    Pulang
                </button>
            </form>


        {{-- Kalender Kehadiran --}}
        
<h2 class="text-lg font-semibold mt-8">
    Kalender Kehadiran {{ $bulan ? '(' . $bulan . ')' : '' }}
</h2>
        <div class="grid grid-cols-7 gap-2 mt-4">
            @foreach ($kalender as $day)
                <div class="p-2 border rounded text-center"
                    title="{{ $day['jam_masuk'] ? 'Masuk: '.$day['jam_masuk'].' | Pulang: '.$day['jam_keluar'] : '' }}">
                    @if ($day['status'] == 'Hadir') ✅
                    @elseif ($day['status'] == 'Izin') 📝
                    @elseif ($day['status'] == 'Sakit') 🤒
                    @elseif ($day['status'] == 'Alfa') ⚠️
                    @elseif ($day['status'] == 'Libur') 🔴
                    @else ⤷💼ˎˊ˗
                    @endif
                    <div>{{ \Carbon\Carbon::parse($day['tanggal'])->format('d') }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
