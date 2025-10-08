<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\User;
use App\Models\Pelamar;
use App\Models\PeriodeMagang;
use App\Models\PermohonanPeriode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $query = Peserta::with('user');

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
             $query->where(function ($q) use ($searchTerm) {
            $q->where('nama', 'like', '%' . $searchTerm . '%') // cari di tabel pelamars
              ->orWhereHas('user', function ($q2) use ($searchTerm) {
                  $q2->where('name', 'like', '%' . $searchTerm . '%'); // cari di relasi users
                  });
            });
        }

        $pesertas = $query->get();
        return view('admin.Peserta-magang', compact('pesertas'));

    }
    public function updateDivisi(Request $request, $id)
    {
            $peserta = \App\Models\Peserta::findOrFail($id);
            $peserta->divisi = $request->input('divisi');
            $peserta->save();

        return redirect()->back()->with('success', 'Divisi diperbarui.');
    }
    public function updateNilai(Request $request, $id)
    {
        $peserta = \App\Models\Peserta::findOrFail($id);
        $peserta->nilai = $request->input('nilai'); // huruf kecil semua
        $peserta->save();

        return redirect()->back()->with('success', 'Nilai diperbarui.');
    }
    public function updateStatus(Request $request, $id)
    {
        $peserta = \App\Models\Peserta::findOrFail($id);
        $peserta->status = $request->input('status'); // huruf kecil semua
        $peserta->save();

        return redirect()->back()->with('success', 'status diperbarui.');
    }


    public function show($id)
    {
        $peserta = Peserta::with('user')->findOrFail($id); // Ambil pelamar berdasarkan ID
        return view('admin.detail-Peserta', compact('peserta')); // Kirim ke view detail
    }

    public function absensi($id)
{
    $peserta = Peserta::with('absensi')->findOrFail($id);
    return view('admin.absensi.index', compact('peserta'));
}
    public function updateKeterangan(Request $request, $id)
    {
        $Absensi = \App\Models\Absensi::findOrFail($id);
        $Absensi->keterangan = $request->input('keterangan'); // huruf kecil semua
        $Absensi->save();

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

        return view('admin.periode', [
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

    // 🔹 Update status & nilai peserta
    $peserta->update([
        'nilai'  => $request->nilai,
        'status' => 'lulus',
        'tanggal_selesai' => now()->toDateString(),
    ]);

    // 🔹 Ambil periode aktif terakhir
    $periodeAktif = \App\Models\PeriodeMagang::where('peserta_id', $peserta->id)
        ->where('status', 'aktif')
        ->orderByDesc('periode_ke')
        ->first();

    // 🔹 Kalau ada, ubah jadi selesai
    if ($periodeAktif) {
        $periodeAktif->update([
            'status' => 'selesai',
            'tanggal_selesai_lama' => $periodeAktif->tanggal_selesai,
            'tanggal_selesai' => now()->toDateString(),
        ]);
    }

    return redirect()->route('admin.peserta-magang')
        ->with('success', 'Peserta berhasil diluluskan dengan nilai ' . $request->nilai);
}


public function mundur(Request $request, $id)
{
    $request->validate([
        'alasan' => 'required|string|max:255',
    ]);

    $peserta = Peserta::findOrFail($id);

    // Update status peserta
    $peserta->update([
        'status' => 'mundur',
        'alasan' => $request->alasan,
        'tanggal_selesai' => now(),
    ]);

    // 🔹 Cari periode magang aktif peserta
    $periodeAktif = \App\Models\PeriodeMagang::where('peserta_id', $peserta->id)
        ->where('status', 'aktif')
        ->latest('id')
        ->first();

    // 🔹 Kalau ada, ubah jadi dibatalkan
    if ($periodeAktif) {
        $periodeAktif->update([
            'status' => 'dibatalkan',
            'tanggal_selesai_lama' => $periodeAktif->tanggal_selesai,
            'tanggal_selesai' => now()->toDateString(),
        ]);
    }

    return redirect()->route('admin.peserta-magang')
        ->with('success', 'Peserta berhasil dimundurkan dan periode magangnya dibatalkan.');
}


}



