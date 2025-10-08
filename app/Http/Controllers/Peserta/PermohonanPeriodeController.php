<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeriodeMagang;
use App\Models\PermohonanPeriode;
use Illuminate\Support\Facades\Auth;

class PermohonanPeriodeController extends Controller
{

    private function hasActivePermohonan($pesertaId, $jenis = null)
{
    $query = PermohonanPeriode::where('peserta_id', $pesertaId)
        ->whereIn('status', ['pending']);

    if ($jenis) {
        $query->where('jenis_permohonan', $jenis);
    }

    return $query->exists();
}


    /**
     * Permohonan percepatan selesai magang
     */
   public function permohonanPercepat(Request $request)
    {
    $request->validate([
        'tanggal_selesai' => 'required|date|after_or_equal:today',
        'alasan'          => 'required|string|max:500',
    ]);

    $user    = Auth::user();
    $peserta = $user->pesertaMagang; // relasi hasOne

    if (! $peserta) {
        return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
    }

    // Ambil periode aktif langsung dari DB
    $periodeAktif = PeriodeMagang::where('status', 'aktif')
    ->where('peserta_id', $peserta->id)
    ->first();


    if (!$periodeAktif) {
    return redirect()->back()->with('error', 'Tidak ada periode aktif.');
    }

   
    if ($this->hasActivePermohonan($peserta->id, 'percepat')) {
    return redirect()->route('magang.data-diri')
        ->with('info', 'Anda masih memiliki permohonan percepat periode yang belum selesai.');
}

    // Buat permohonan percepatan
    $permohonan = PermohonanPeriode::create([
        'peserta_id'           => $peserta->id,
        'periode_id'           => $periodeAktif->id,
        'jenis_permohonan'     => 'percepat',
        'tanggal_mulai'        => $periodeAktif->tanggal_mulai,
        'tanggal_selesai'      => $request->tanggal_selesai,
        'tanggal_selesai_lama' => $periodeAktif->tanggal_selesai,
        'alasan'               => $request->alasan,
        'tanggal_pengajuan'    => now()->toDateString(),
        'status'               => 'pending',
    ]);

    // update pointer periode aktif
    $peserta->update([
        'periode_aktif_id' => $periodeAktif->id,
    ]);

   
    return redirect()->route('magang.data-diri')
        ->with('success', 'Permohonan percepatan berhasil diajukan.');
}


/**
 * Permohonan penambahan periode magang
 */
public function permohonanTambah(Request $request)
{
    $request->validate([
        'tanggal_mulai' => 'required|date|after_or_equal:today',
        'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        'alasan'          => 'required|string|max:500',
    ]);

    $user = Auth::user();
    $peserta = $user->pesertaMagang;

    if (! $peserta) {
        return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
    }
    if ($this->hasActivePermohonan($peserta->id, 'tambah')) {
    return redirect()->route('magang.data-diri')
        ->with('info', 'Anda masih memiliki permohonan tambah periode yang belum selesai.');
    }

    // Ambil periode aktif terakhir untuk referensi (optional)
    $periodeAktif = $peserta->periodeAktif;

    PermohonanPeriode::create([
        'peserta_id'           => $peserta->id,
        'periode_id'           => $periodeAktif?->id, // boleh null juga
        'jenis_permohonan'     => 'tambah',
        'tanggal_mulai'        => $request->tanggal_mulai,
        'tanggal_selesai'      => $request->tanggal_selesai,
        'tanggal_selesai_lama' => null,
        'alasan'               => $request->alasan,
        'tanggal_pengajuan'    => now(),
        'status'               => 'pending',
    ]);
    return redirect()->route('magang.data-diri')
        ->with('success', 'Permohonan penambahan berhasil diajukan.');
}

public function permohonanMundur(Request $request) 
{
    $request->validate([
        'alasan' => 'required|string|max:500',
    ]);

    $user    = Auth::user();
    $peserta = $user->pesertaMagang;

    if (! $peserta) {
        return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
    }

    $periodeAktif = PeriodeMagang::where('status', 'aktif')
        ->where('peserta_id', $peserta->id)
        ->first();

    if (! $periodeAktif) {
        return redirect()->back()->with('error', 'Tidak ada periode aktif.');
    }
   if ($this->hasActivePermohonan($peserta->id, 'mundur')) {
    return redirect()->route('magang.data-diri')
        ->with('info', 'Anda masih memiliki permohonan mundur periode yang belum selesai.');
}


    PermohonanPeriode::create([
        'peserta_id'           => $peserta->id,
        'periode_id'           => $periodeAktif->id,
        'jenis_permohonan'     => 'mundur',
        'tanggal_mulai'        => $periodeAktif->tanggal_mulai,
        'tanggal_selesai'      => now()->toDateString(),
        'tanggal_selesai_lama' => $periodeAktif->tanggal_selesai,
        'alasan'               => $request->alasan,
        'tanggal_pengajuan'    => now()->toDateString(),
        'status'               => 'pending',
    ]);

    
    return redirect()->route('magang.data-diri')
        ->with('success', 'Permohonan mundur berhasil diajukan. Menunggu persetujuan admin.');
}
// C:\laragon\www\magangbkn\app\Http\Controllers\Peserta\PermohonanPeriodeController.php
public function permohonanMagangKembali(Request $request)
{
    $request->validate([
        'tanggal_mulai' => 'required|date|after_or_equal:today',
        'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        'alasan' => 'nullable|string|max:500',

    ]);

    $user = Auth::user();
    $peserta = $user->pesertaMagang;

    if (! $peserta) {
        return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
    }

    // Cegah duplikasi
    $existing = PermohonanPeriode::where('peserta_id', $peserta->id)
        ->where('jenis_permohonan', 'permohonanmagangkembali')
        ->whereIn('status', ['pending'])
        ->exists();

   if ($this->hasActivePermohonan($peserta->id, 'permohonanmagangkembali')) {
    return redirect()->route('magang.data-diri')
        ->with('info', 'Anda masih memiliki permohonan magang kembali periode yang belum selesai.');
}


    // Ambil periode aktif terakhir (opsional)
    $periodeAktif = $peserta->periodeAktif;

    PermohonanPeriode::create([
        'peserta_id'           => $peserta->id,
        'periode_id'           => $periodeAktif?->id,
        'jenis_permohonan'     => 'permohonanmagangkembali',
        'tanggal_mulai'        => $request->tanggal_mulai,
        'tanggal_selesai'      => $request->tanggal_selesai,
        'tanggal_selesai_lama' => null,
        'alasan'               => $request->alasan ?? null,
        'tanggal_pengajuan'    => now(),
        'status'               => 'pending',
    ]);

    return redirect()->route('magang.status')
        ->with('success', 'Permohonan magang kembali berhasil diajukan.');
}
// C:\laragon\www\magangbkn\app\Http\Controllers\Peserta\PermohonanPeriodeController.php
public function status()
{
    $user = Auth::user();
    $peserta = $user->pesertaMagang;

    $permohonan = \App\Models\PermohonanPeriode::where('peserta_id', $peserta->id)
        ->where('jenis_permohonan', 'permohonanmagangkembali')
        ->orderByDesc('id') // lebih aman dibanding ->latest()
        ->first();

    return view('magang.status', compact('permohonan', 'peserta'));
}



}
