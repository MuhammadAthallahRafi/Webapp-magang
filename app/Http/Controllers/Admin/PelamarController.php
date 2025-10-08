<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pelamar;
use App\Models\Peserta;
use App\Models\PeriodeMagang;
use App\Models\permohonanPeriode;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PelamarController extends Controller
{
    
    /**
     * Tampilkan daftar semua pelamar (dari tabel pelamars + relasi ke users).
     */
   public function index(Request $request)
{
    // --- 1️⃣ Ambil pelamar baru
    $pelamarAktif = Pelamar::with('user')
        ->whereNotIn('status', ['ditolak', 'diterima'])
        ->when($request->filled('search'), function ($q) use ($request) {
            $term = $request->input('search');
            $q->where('nama', 'like', "%{$term}%")
              ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$term}%"));
        })
        ->get();

    // --- 2️⃣ Ambil peserta dengan permohonan magang kembali
    $pelamarKembali = Peserta::whereHas('permohonanPeriode', function ($q) {
            $q->where('jenis_permohonan', 'permohonanmagangkembali')
              ->where('status', 'pending');
        })
        ->with(['user', 'permohonanPeriode'])
        ->get();

    // --- 3️⃣ Gabungkan keduanya jadi satu koleksi unik
    $semuaPelamar = $pelamarAktif->concat($pelamarKembali)->unique('id');

    // --- 4️⃣ Kirim ke view
    return view('admin.pelamar', [
        'active' => 'pelamar',
        'pelamars' => $semuaPelamar
    ]);
}







    

    /**
     * Tampilkan detail satu pelamar berdasarkan ID pelamars.
     */
    public function show($id)
{
    $pelamar = Pelamar::with('user')->findOrFail($id);
    return view('admin.detail-pelamar', compact('pelamar'));
}


    /**
     * Admin menerima pelamar menjadi magang (mengubah role & status di tabel users).
     */

    public function daftarMagang()
    {
        // Ambil semua user yang sudah jadi magang
        $magangs = \App\Models\User::with('pelamar')
                    ->where('role', 'magang')
                    ->get();

        return view('admin.peserta-magang', compact('magangs'));
    }


        public function terima(Request $request, $id)
{
    $pelamar = Pelamar::with('user')->findOrFail($id);
    $user = $pelamar->user;

    abort_if($user->role !== 'pelamar', 403, 'Data bukan pelamar!');

    $request->validate([
        'divisi'        => 'required|string|max:100',
        'catatan_admin' => 'nullable|string|max:500',
    ]);

    // Generate ID Magang
    $prefix = 'MAG';
    $now = Carbon::now();
    $bulanTahun = $now->format('Ym');
    $count = Peserta::whereDate('created_at', '>=', $now->startOfMonth())
                    ->whereDate('created_at', '<=', $now->endOfMonth())
                    ->count() + 1;
    $nomorUrut = str_pad($count, 3, '0', STR_PAD_LEFT);
    $idMagang = $prefix . '-' . $bulanTahun . '-' . $nomorUrut;

    // Masukkan ke Peserta
    $peserta = Peserta::create([
        'user_id'           => $user->id,
        'id_magang'         => $idMagang,
        'nama'              => $pelamar->nama,
        'nik'               => $pelamar->nik,
        'kampus'            => $pelamar->kampus,
        'jurusan'           => $pelamar->jurusan,
        'batch'             => $pelamar->batch,
        'no_telp'           => $pelamar->no_telp,
        'alamat'            => $pelamar->alamat,
        'divisi'            => $request->input('divisi'),
        'tanggal_mulai'     => $pelamar->tanggal_mulai,
        'tanggal_selesai'   => $pelamar->tanggal_selesai,
        'catatan_admin'     => $request->input('catatan_admin'),
        'cv'                => $pelamar->cv,
        'transkrip'         => $pelamar->transkrip,
        'surat'             => $pelamar->surat,
        'status'            => 'aktif',  
    ]);

    // Buat periode magang pertama
    $periode = PeriodeMagang::create([
        'peserta_id'           => $peserta->id,
        'periode_ke'           => 1,
        'tanggal_mulai'        => $pelamar->tanggal_mulai,
        'tanggal_selesai'      => $pelamar->tanggal_selesai,
        'tanggal_selesai_lama' => null,
        'status'               => 'aktif',
    ]);

    $peserta->update([
    'periode_aktif_id' => $periode->id,
    ]);

    // Update role user
    $user->update([
        'role' => 'magang',
    ]);

    // Update status pelamar
    $pelamar->update([
        'status' => 'diterima',
    ]);

    return redirect()->route('admin.peserta-magang')
        ->with('success', 'Pelamar diterima sebagai Peserta magang.');
}

    public function tolak(Request $request, $id)
{
    $request->validate([
        'alasan_penolakan' => 'required|string|max:255',
    ]);

    $pelamar = Pelamar::findOrFail($id);

    $pelamar->update([
        'alasan_penolakan' => $request->alasan_penolakan,
        'status'           => 'ditolak',
    ]);

    return redirect()->route('admin.pelamar')
                    ->with('success', 'Pelamar berhasil ditolak.');
}

public function perbaikan(Request $request, $id)
{
    $request->validate([
        'alasan_perbaikan' => 'required|string|max:500',
    ]);

    $pelamar = Pelamar::findOrFail($id);

    $pelamar->update([
        'alasan_perbaikan' => $request->alasan_perbaikan,
        'status'           => 'perbaikan',
    ]);

    return redirect()->route('admin.pelamar')
                    ->with('success', 'Pelamar diminta melakukan perbaikan.');
}






    
}
