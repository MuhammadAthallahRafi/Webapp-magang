<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat</title>
    <style>
        body { font-family: sans-serif; text-align: center; }
        .title { font-size: 28px; font-weight: bold; margin-top: 50px; }
        .content { margin-top: 40px; font-size: 18px; }
    </style>
</head>
<body>
    <div class="title">SERTIFIKAT KELULUSAN MAGANG</div>

    <div class="content">
        <p>Diberikan kepada:</p>
        <h2>{{ $peserta->nama }}</h2>
        <p>NIM: {{ $peserta->nik }}</p>
        <p>Kampus: {{ $peserta->kampus }}</p>
        <p>Jurusan: {{ $peserta->jurusan }}</p>

        <p>
            Telah menyelesaikan program magang pada periode 
            {{ $periode->tanggal_mulai }} s/d {{ $periode->tanggal_selesai }}.
        </p>

        <br><br><br>
        <p>______________________________</p>
        <p><strong>Direktur HRD</strong></p>
    </div>
</body>
</html>
