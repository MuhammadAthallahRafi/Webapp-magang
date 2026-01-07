<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi - {{ $peserta->nama }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 16px; font-weight: bold; }
        .info { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN ABSENSI PESERTA MAGANG</div>
    </div>

    <div class="info">
        <p><strong>Nama:</strong> {{ $peserta->nama }}</p>
        <p><strong>NIK:</strong> {{ $peserta->nik ?? '-' }}</p>
        <p><strong>Unit-kerja:</strong> {{ $peserta->divisi ?? '-' }}</p>
        <!-- PASTIKAN $start dan $end ADA -->
        <p><strong>Periode:</strong> 
           {{ date('d-m-Y', strtotime($start)) }} s/d {{ date('d-m-Y', strtotime($end)) }}
        </p>
        <p><strong>Tanggal Cetak:</strong> {{ $tanggal_cetak ?? date('d-m-Y H:i:s') }}</p>
    </div>

    <table border="1">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Keterangan</th>
        </tr>
        @foreach($absensi as $a)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ date('d-m-Y', strtotime($a->tanggal)) }}</td>
            <td>{{ $a->jam_masuk ? date('H:i', strtotime($a->jam_masuk)) : '-' }}</td>
            <td>{{ $a->jam_keluar ? date('H:i', strtotime($a->jam_keluar)) : '-' }}</td>
            <td>
                @if($a->keterangan == 'hadir')
                    <span style="color: green;">Hadir</span>
                @elseif($a->keterangan == 'sakit')
                    <span style="color: orange;">Sakit</span>
                @elseif($a->keterangan == 'dispen')
                    <span style="color: blue;">Dispen</span>
                @elseif($a->keterangan == 'alfa')
                    <span style="color: red;">Alfa</span>
                @else
                    {{ $a->keterangan ?? '-' }}
                @endif
            </td>
        </tr>
        @endforeach
    </table>

    <div style="margin-top: 20px;">
        @php
            $total = $absensi->count();
            $hadir = $absensi->where('keterangan', 'hadir')->count();
            $sakit = $absensi->where('keterangan', 'sakit')->count();
            $dispen = $absensi->where('keterangan', 'dispen')->count();
            $alfa = $absensi->where('keterangan', 'alfa')->count();
        @endphp
        
        <p><strong>Rekapitulasi:</strong></p>
        <p>Total Hari: {{ $total }}</p>
        <p>Hadir: {{ $hadir }} | Sakit: {{ $sakit }} | Dispen: {{ $dispen }} | Alfa: {{ $alfa }}</p>
    </div>
</body>
</html>