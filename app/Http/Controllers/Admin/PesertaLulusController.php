<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\PeriodeMagang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class PesertaLulusController extends Controller
{
    public function index()
    {
        // Ambil hanya peserta yang status "lulus"
        $pesertaLulus = Peserta::where('status', 'lulus')->with('periodeMagang')->get();

        return view('admin.peserta-lulus.index', compact('pesertaLulus'));
    }

    public function cetakSertifikat($id)
    {
        $peserta = Peserta::with('periodeMagang')->findOrFail($id);

        // Ambil periode terakhir untuk referensi tanggal
        $periodeTerakhir = $peserta->periodeMagang->sortByDesc('periode_ke')->first();

        $pdf = PDF::loadView('admin.peserta-lulus.sertifikat', [
            'peserta' => $peserta,
            'periode' => $periodeTerakhir
        ]);

        return $pdf->download("Sertifikat-{$peserta->nama}.pdf");
    }
}
