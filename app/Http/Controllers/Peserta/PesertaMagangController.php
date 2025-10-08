<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PesertaMagang;
use App\Models\Absensi;
use App\Models\PeriodeMagang;
use App\Models\PermohonanPeriode;
use App\Models\Peserta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PesertaMagangController extends Controller
{
    public function dashboard()
    {
        if (!Auth::user()->pesertaMagang) {
    return redirect()->route('login')->with('error', 'Data magang tidak ditemukan.');
    }

    $pesertaId = Auth::user()->pesertaMagang->id;

            $pesertaId = Auth::user()->pesertaMagang->id;

        // Cek absensi hari ini
        $today = Carbon::today();
        $absensiHariIni = Absensi::where('peserta_id', $pesertaId)
            ->whereDate('tanggal', $today)
            ->first();

        // Data kalender bulan ini
        $kalender = $this->getKalender($pesertaId);

        return view('magang.dashboard', compact('absensiHariIni', 'kalender'));
    }

    public function absensi(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|in:Hadir,Sakit,Izin,Alfa'
        ]);

        $pesertaId = Auth::user()->pesertaMagang->id;
        $today = Carbon::today();

        // Cegah absen lebih dari sekali per hari
        if (Absensi::where('peserta_id', $pesertaId)->whereDate('tanggal', $today)->exists()) {
            return back()->with('error', 'Kamu sudah melakukan absensi hari ini.');
        }

        Absensi::create([
            'peserta_id' => $pesertaId,
            'tanggal' => $today,
            'jam_masuk' => Carbon::now()->format('H:i:s'),
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Absensi berhasil disimpan.');
    }

    public function pulang()
    {
        $pesertaId = Auth::user()->PersetaMagang->id;
        $today = Carbon::today();

        $absensi = Absensi::where('peserta_id', $pesertaId)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$absensi) {
            return back()->with('error', 'Belum melakukan absensi masuk.');
        }

        if ($absensi->jam_keluar) {
            return back()->with('error', 'Sudah melakukan absensi pulang.');
        }

        $absensi->update([
            'jam_keluar' => Carbon::now()->format('H:i:s')
        ]);

        return back()->with('success', 'Absensi pulang berhasil.');
    }

    private function getKalender($pesertaId)
    {
        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();

        $absensiBulan = Absensi::where('peserta_id', $pesertaId)
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->get()
            ->keyBy('tanggal');

        $kalender = [];
        for ($date = $startOfMonth->copy(); $date <= $endOfMonth; $date->addDay()) {
            $status = null;
            if (isset($absensiBulan[$date->toDateString()])) {
                $status = $absensiBulan[$date->toDateString()]->keterangan;
            } elseif ($date->isWeekend()) {
                $status = 'Libur';
            } elseif ($date->isPast()) {
                $status = 'Alfa';
            } else {
                $status = 'Mendatang';
            }

            $kalender[] = [
                'tanggal' => $date->format('Y-m-d'),
                'status' => $status,
                'jam_masuk' => $absensiBulan[$date->toDateString()]->jam_masuk ?? null,
                'jam_keluar' => $absensiBulan[$date->toDateString()]->jam_keluar ?? null
            ];
        }

        return $kalender;
    }

    public function riwayat()
    {
        $pesertaId = Auth::user()->pesertaMagang->id;

        $riwayat = Absensi::where('peserta_id', $pesertaId)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('magang.riwayat', compact('riwayat'));
    }

   public function dataDiri()
{
    $user = Auth::user();
    $peserta = $user->pesertaMagang; 

    $periodeAktif = null;
    if ($peserta && $peserta->periodeAktif) {
        $periodeAktif = $peserta->periodeAktif; // relasi belongsTo
    }


    $permohonans = $peserta 
        ? PermohonanPeriode::where('peserta_id', $peserta->id)->latest()->get()
        : collect();

    return view('magang.data-diri', compact('peserta', 'periodeAktif', 'permohonans'));
}

public function show($id)
{
    $peserta = PesertaMagang::with('user')->findOrFail($id);

    // Pastikan hanya status 'mundur' atau 'lulus' yang diizinkan
    if (!in_array($peserta->status, ['mundur', 'lulus'])) {
        return redirect('/dashboard/magang')->with('error', 'Peserta ini tidak memiliki status mundur atau lulus.');
    }

    // Tentukan view berdasarkan status
    $view = $peserta->status === 'mundur' 
        ? 'magang.mundur' 
        : 'magang.lulus';

    return view($view, compact('peserta'));
}

public function tambahPendidikan(Request $request, $id)
{
    $request->validate([
        'pendidikan_baru' => 'required|string|max:255',
    ]);

    $peserta = Peserta::findOrFail($id);
    $pendidikanBaru = trim($request->pendidikan_baru);

    // gabungkan tanpa duplikat
    $list = array_map('trim', explode(',', $peserta->kampus ?? ''));
    if (!in_array($pendidikanBaru, $list)) {
        $list[] = $pendidikanBaru;
    }

    $peserta->update([
        'kampus' => implode(', ', $list),
    ]);

    return redirect()->route('magang.data-diri')->with('success', 'Pendidikan baru berhasil ditambahkan.');
}


}
