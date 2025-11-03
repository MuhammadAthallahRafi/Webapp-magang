<?php

namespace App\Http\Controllers\Adminunitkerja;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\PeriodeMagang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;


class PesertaLulusController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Ambil hanya peserta yang status "lulus" dan divisi sesuai admin
    $pesertaLulus = Peserta::where('status', 'lulus')
        ->where('divisi', $user->divisi)
        ->with('periodeMagang')
        ->get();

    return view('admin-unitkerja.peserta-lulus.index', compact('pesertaLulus'));
}

    public function cetakSertifikat($id)
    {
        $peserta = Peserta::with('periodeMagang')->findOrFail($id);

        // Ambil periode terakhir untuk referensi tanggal
        $periodeTerakhir = $peserta->periodeMagang->sortByDesc('periode_ke')->first();

        $pdf = PDF::loadView('admin-unitkerja.peserta-lulus.sertifikat', [
            'peserta' => $peserta,
            'periode' => $periodeTerakhir
        ]);

        return $pdf->download("Sertifikat-{$peserta->nama}.pdf");
    }
}
