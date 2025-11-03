<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelamar;
use App\Models\Peserta;
use App\Models\PermohonanPeriode;

class AdminController extends Controller
{
    public function index()
    {
        // Hitung data pelamar
        $pelamarPending  = Pelamar::where('status', 'pending')->count();
        $pelamarDiterima = Pelamar::where('status', 'diterima')->count();
        $pelamarDitolak  = Pelamar::where('status', 'ditolak')->count();

        // Hitung data peserta
        $pesertaTotal   = Peserta::count();
        $pesertaLulus   = Peserta::where('status', 'lulus')->count();
        $pesertaMundur  = Peserta::where('status', 'mundur')->count();
        $pesertaAktif  = Peserta::where('status', 'aktif')->count();

        // Hitung permohonan periode
        $permohonanPending = PermohonanPeriode::count();

        return view('admin.dashboard', compact(
            'pelamarPending',
            'pelamarDiterima',
            'pelamarDitolak',
            'pesertaTotal',
            'pesertaLulus',
            'pesertaMundur',
            'pesertaAktif',
            'permohonanPending'
        ));
    }
}
