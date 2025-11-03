<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pelamar;
use App\Models\Peserta;
use App\Models\PeriodeMagang;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PelamarDitolakController extends Controller
{
    
    /**
     * Tampilkan daftar semua pelamar (dari tabel pelamars + relasi ke users).
     */
   public function index(Request $request)
{
    // Inisialisasi query (jangan langsung get)
    $query = Pelamar::with('user')
    ->where('status', 'ditolak');


    // Search (nama user atau nama di table pelamars)
    if ($request->filled('search')) {
        $term = $request->input('search');
        $query->where(function($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
            ->orWhere('nik', 'like', "%{$term}%") // 🔍 TAMBAH INI
            ->orWhere('email', 'like', "%{$term}%")
            ->orWhere('no_telp', 'like', "%{$term}%")
            ->orWhere('kampus', 'like', "%{$term}%")
              ->orWhereHas('pelamar', function($q2) use ($term) {
                  $q2->where('nama', 'like', "%{$term}%");
              });
        });
    }

    // Eksekusi query
    $pelamars = $query->get();

    return view('admin.pelamarditolak', compact('pelamars'));
}





    /**
     * Tampilkan detail satu pelamar berdasarkan ID pelamars.
     */
    public function show($id)
    {
        $pelamar = Pelamar::with('user')->findOrFail($id);
        $user = $pelamar->user; // Ambil pelamar berdasarkan ID
        return view('admin.detail-pelamarditolak', compact('pelamar','user')); // Kirim ke view detail
    }

    /**
     * Admin menerima pelamar menjadi magang (mengubah role & status di tabel users).
    public function daftarMagang()
    {
        // Ambil semua user yang sudah jadi magang
        $magangs = \App\Models\User::with('pelamar')
                    ->where('role', 'magang')
                    ->get();

        return view('admin.peserta-magang', compact('magangs'));
    }
        */


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
        'kelamin'           => $pelamar->kelamin,
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

    return redirect()->route('admin.pelamarditolak')
                    ->with('success', 'Pelamar diminta melakukan perbaikan.');
}
    

public function updateTanggalMulai(Request $request, $id)
    {
    $request->validate([
        'tanggal_mulai' => 'required|date',
    ]);

    $pelamar = Pelamar::findOrFail($id);

    // Validasi agar tidak melanggar tanggal selesai
    if ($pelamar->tanggal_selesai && $request->tanggal_mulai > $pelamar->tanggal_selesai) {
        return back()->with('error', 'Tanggal mulai tidak boleh setelah tanggal selesai.');
    }

    $pelamar->update(['tanggal_mulai' => $request->tanggal_mulai]);

    return back()->with('success', 'Tanggal mulai berhasil diperbarui.');
    }

    public function updateTanggalSelesai(Request $request, $id)
    {
    $request->validate([
        'tanggal_selesai' => 'required|date',
    ]);

    $pelamar = Pelamar::findOrFail($id);

    // Validasi agar tidak lebih awal dari tanggal mulai
    if ($pelamar->tanggal_mulai && $request->tanggal_selesai < $pelamar->tanggal_mulai) {
        return back()->with('error', 'Tanggal selesai tidak boleh sebelum tanggal mulai.');
    }

    $pelamar->update(['tanggal_selesai' => $request->tanggal_selesai]);

    return back()->with('success', 'Tanggal selesai berhasil diperbarui.');
    }




}
