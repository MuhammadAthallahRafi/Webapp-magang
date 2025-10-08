<?php

namespace App\Http\Controllers\Adminunitkerja;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\User;
use App\Models\Pelamar;
use App\Models\Absensi;
use App\Models\PeriodeMagang;
use App\Models\PermohonanPeriode;
use Illuminate\Http\Request;

class PesertaMagangUnitKerjaController extends Controller
{
    public function index(Request $request)
    {
        $admin = auth()->user(); // admin unitkerja yang login
        $divisi = $admin->divisi;

        // ambil Peserta magang sesuai divisi
        $query = Peserta::with('user')->where('divisi', $divisi);

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('user', function ($q2) use ($searchTerm) {
                        $q2->where('name', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        $pesertas = $query->get();

        // sesuai file view kamu → Peserta-unit-kerja-magang.blade.php
        return view('admin-unitkerja.peserta-magang', compact('pesertas'));
    }

    public function updateNilai(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->nilai = $request->input('nilai');
        $peserta->save();

        return redirect()->back()->with('success', 'Nilai diperbarui.');
    }

    public function updateStatus(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->status = $request->input('status');
        $peserta->save();

        return redirect()->back()->with('success', 'Status diperbarui.');
    }

    public function show($id)
    {
        $admin = auth()->user();
        $divisi = $admin->divisi;

        $peserta = Peserta::where('id', $id)
            ->where('divisi', $divisi)
            ->firstOrFail();

        // sesuai file view kamu → detail-Peserta-unit-kerja.blade.php
        return view('admin-unitkerja.detail-peserta-unit-kerja', compact('peserta'));
    }

    public function absensi($id)
    {
        $peserta = Peserta::with('absensi')->findOrFail($id);
        return view('admin-unitkerja.absensi.index', compact('peserta'));
    }

    public function updateKeterangan(Request $request, $id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->keterangan = $request->input('keterangan');
        $absensi->save();

        return redirect()->back()->with('success', 'Keterangan diperbarui.');
    }

    public function periode($id)
    {
        // Ambil data peserta dan semua periode magangnya
        $peserta = Peserta::with(['user'])->findOrFail($id);

        // Ambil semua riwayat periode magang
        $riwayatPeriode = PeriodeMagang::where('peserta_id', $id)
            ->orderBy('periode_ke', 'asc')
            ->get();

        // Ambil semua permohonan periode terkait
        $permohonan = PermohonanPeriode::where('peserta_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin-unitkerja.periode', [
            'active' => 'peserta',
            'peserta' => $peserta,
            'riwayatPeriode' => $riwayatPeriode,
            'permohonan' => $permohonan
        ]);
    }

    public function lulus(Request $request, $id)
{
    $request->validate([
        'nilai' => 'required|integer|min:0|max:100',
    ]);

    $peserta = Peserta::findOrFail($id);

    $peserta->update([
        'nilai' => $request->nilai,
        'status' => 'lulus',
    ]);

    return redirect()->route('admin-unitkerja.peserta-magang')
                 ->with('success', 'Peserta berhasil diluluskan dengan nilai ' . $request->nilai);
}

public function mundur(Request $request, $id)
{
    $request->validate([
        'alasan' => 'required|string|max:255',
    ]);

    $peserta = Peserta::findOrFail($id);

    $peserta->update([
        'status' => 'mundur',
        'alasan' => $request->alasan,
        'tanggal_selesai' => now()
    ]);

    return redirect()->route('admin-unitkerja.peserta-magang')
                    ->with('success', 'Peserta berhasil dimundurkan dengan alasan yang dicatat.');
}

}
