<?php

namespace App\Http\Controllers\Adminunitkerja;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\PermohonanPeriode;
use App\Models\Peserta;
use App\Models\User;
use App\Models\PeriodeMagang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // ✅ TAMBAHKAN INI

class PermohonanPeriodeController extends Controller
{
     public function index(Request $request)
{
    $user = Auth::user(); // ambil unit/divisi admin login

    // Query dasar
    $query = PermohonanPeriode::with(['peserta.user', 'periode'])
        ->whereHas('peserta', function ($q) use ($user) {
            // pastikan hanya peserta yang divisinya sama dengan admin
            $q->where('divisi', $user->divisi);
        });

        // Apply filters menggunakan FilterController
        $query = FilterController::applyJenisPermohonanFilter($query, $request->jenis_permohonan);
        $query = FilterController::applyStatusFilter($query, $request->status);
        $query = FilterController::applyTahunMulaiFilter($query, $request->tahun_mulai);
        $query = FilterController::applyTahunSelesaiFilter($query, $request->tahun_selesai);

    // Filter pencarian
    if ($request->filled('search')) {
        $term = $request->input('search');

        $query->where(function ($q) use ($term) {
            $q->where('jenis_permohonan', 'like', "%{$term}%")
              ->orWhere('alasan', 'like', "%{$term}%")
              ->orWhereHas('peserta', function ($q2) use ($term) {
                  $q2->where('nama', 'like', "%{$term}%")
                     ->orWhereHas('user', function ($q3) use ($term) {
                         $q3->where('name', 'like', "%{$term}%");
                     });
              });
        });
    }

    // Urutan status prioritas + urut ID desc
    $query->orderByRaw("
        CASE 
            WHEN status = 'pending' THEN 1
            WHEN status = 'disetujui' THEN 2
            WHEN status = 'ditolak' THEN 3
            ELSE 5
        END
    ")->orderByDesc('id');

    // Pagination tetap jalan
    $permohonan = $query->paginate(20)->withQueryString();
    
    $filterOptions = [
            'tahunOptions' => FilterController::getTahunOptions(),
        ];

    return view('admin-unitkerja.permohonan-periode', compact('permohonan', 'filterOptions'));
}



   public function approve($id)
{
    //mengambil data permohonan peserta 
    $permohonan = PermohonanPeriode::with('periode.peserta')->findOrFail($id);
    $peserta = $permohonan->peserta;

    // Update status permohonan jadi disetujui
    $permohonan->update([
        'status' => 'disetujui',
        'tanggal_disetujui' => now(),
    ]);

    $periodeLama = $permohonan->periode;
    $peserta = $periodeLama?->peserta;

    // ===== 1. PERCEPAT =====
    if ($permohonan->jenis_permohonan === 'percepat') {
        if ($periodeLama) {
            $periodeLama->update([
                'tanggal_selesai_lama' => $periodeLama->tanggal_selesai,
                'tanggal_selesai' => $permohonan->tanggal_selesai,
            ]);
        }

        if ($peserta) {
            $peserta->update([
                'tanggal_selesai_lama' => $periodeLama->tanggal_selesai_lama,
                'tanggal_selesai' => $permohonan->tanggal_selesai,
            ]);
        }
    }

    // ===== 2. TAMBAH =====
    if ($permohonan->jenis_permohonan === 'tambah') {
        DB::transaction(function () use ($permohonan) {
        $pesertaId = $permohonan->peserta_id;
        $peserta   = Peserta::find($pesertaId);

        if (!$peserta) {
            throw new \Exception('Data peserta tidak ditemukan.');
        }

        $periodeKeTerakhir = PeriodeMagang::where('peserta_id', $pesertaId)->max('periode_ke') ?? 0;
        $periodeKeBaru = $periodeKeTerakhir + 1;

        // Tentukan status awal periode baru
        $statusPeriode = $permohonan->tanggal_mulai <= now()->toDateString()
            ? 'aktif'
            : 'rencana';

        // Buat periode baru
        $periodeBaru = PeriodeMagang::create([
            'peserta_id'      => $pesertaId,
            'periode_ke'      => $periodeKeBaru,
            'tanggal_mulai'   => $permohonan->tanggal_mulai,
            'tanggal_selesai' => $permohonan->tanggal_selesai,
            'status'          => $statusPeriode,
        ]);

        // Jika periode BARU sudah aktif → Nonaktifkan periode lama
        if ($statusPeriode === 'aktif') {
            $periodeLama = PeriodeMagang::where('peserta_id', $pesertaId)
                ->where('id', '!=', $periodeBaru->id)
                ->where('status', 'aktif')
                ->first();

            if ($periodeLama) {
                $periodeLama->update([
                    'status' => 'selesai',
                    'tanggal_selesai_lama' => $periodeLama->tanggal_selesai,
                ]);
            }

            // Update peserta menjadi aktif di periode baru
            $peserta->update([
                'status'               => 'aktif',
            ]);
        }

        
    });
    }

    // ===== 3. MUNDUR =====
    if ($permohonan->jenis_permohonan === 'mundur') {
    // 🔹 Cari periode terakhir (aktif) dari peserta
    $periodeAktif = \App\Models\PeriodeMagang::where('peserta_id', $peserta->id ?? null)
        ->where('status', 'aktif')
        ->orderByDesc('periode_ke')
        ->first();

    // 🔹 Update data peserta
    if ($peserta) {
            $peserta->update([
                'status'               => 'mundur',
                'periode_aktif_id'     => null,
                'alasan'               => $permohonan->alasan,
            ]);
            }

    // 🔹 Kalau ada, ubah jadi dibatalkan
    if ($periodeAktif) {
        $periodeAktif->update([
            'status'               => 'dibatalkan',
            'alasan'               => $permohonan->alasan,
        ]);
    }
}


    // ===== 4. MAGANG KEMBALI =====
    if ($permohonan->jenis_permohonan === 'permohonanmagangkembali') {
        DB::transaction(function () use ($permohonan) {
            $pesertaId = $permohonan->peserta_id;
            $peserta = Peserta::find($pesertaId);
            if (!$peserta) {
                throw new \Exception('Data peserta tidak ditemukan.');
            }

            $periodeKe = PeriodeMagang::where('peserta_id', $pesertaId)->max('periode_ke') ?? 0;
            $periodeKe++;

            $periodeBaru = PeriodeMagang::create([
                'peserta_id'      => $pesertaId,
                'periode_ke'      => $periodeKe,
                'tanggal_mulai'   => $permohonan->tanggal_mulai,
                'tanggal_selesai' => $permohonan->tanggal_selesai,
                'status'          => 'aktif',
            ]);

            // Nonaktifkan periode lama
            $periodeLama = PeriodeMagang::where('peserta_id', $pesertaId)
                ->where('id', '!=', $periodeBaru->id)
                ->where('status', 'aktif')
                ->first();

            if ($periodeLama) {
                $periodeLama->update([
                    'status' => 'selesai',
                    'tanggal_selesai_lama' => $periodeLama->tanggal_selesai,
                ]);
            }

            // Update peserta — **penting untuk naik periode aktif**
            $peserta->update([
                'periode_aktif_id'      => $periodeBaru->id,
                'tanggal_mulai'       => $permohonan->tanggal_mulai,
                'tanggal_selesai_lama'  => $peserta->tanggal_selesai,
                'tanggal_selesai'       => $permohonan->tanggal_selesai,
                'status'                => 'aktif',
            ]);

            // Perbaharui status permohonan
            $permohonan->update([
                'status' => 'disetujui',
                'tanggal_disetujui' => now(),
            ]);
        });
    }

    return redirect()->route('admin-unitkerja.permohonan-periode')
        ->with('success', 'Permohonan berhasil disetujui.');
}




    public function reject($id)
    {
        $permohonan = PermohonanPeriode::findOrFail($id);

        $permohonan->status = 'ditolak';
        $permohonan->tanggal_disetujui = null;
        $permohonan->save();

        return redirect()->route('admin-unitkerja.permohonan-periode')
            ->with('error', 'Permohonan ditolak.');
    }

     public function lihat($id)
{
    // Ambil permohonan yang sedang dilihat
    $permohonan = PermohonanPeriode::with('peserta')->findOrFail($id);

    // Ambil peserta dari permohonan
    $peserta = $permohonan->peserta;

    // ✅ AMBIL RIWAYAT SIKAP TERAKHIR
    $riwayatSikap = null;
    if ($peserta) {
        $riwayatSikap = Penilaian::with('periode')
            ->whereHas('periode', function($query) use ($peserta) {
                $query->where('peserta_id', $peserta->id);
            })
            ->orderBy('created_at', 'desc')
            ->first();
    }

    return view('admin-unitkerja.detail-permohonan', compact(
        'peserta', 
        'permohonan', 
        'riwayatSikap'  // ✅ TAMBAHKAN INI
    ));
}
public function updateTanggalMulai(Request $request, $id)
{
    $request->validate([
        'tanggal_mulai' => 'required|date',
    ]);

    $permohonan = PermohonanPeriode::findOrFail($id);

    // Validasi agar tidak melanggar tanggal selesai
    if ($permohonan->tanggal_selesai && $request->tanggal_mulai > $permohonan->tanggal_selesai) {
        return back()->with('error', 'Tanggal mulai tidak boleh setelah tanggal selesai.');
    }

    $permohonan->update(['tanggal_mulai' => $request->tanggal_mulai]);

    return back()->with('success', 'Tanggal mulai permohonan berhasil diperbarui.');
}

public function updateTanggalSelesai(Request $request, $id)
{
    $request->validate([
        'tanggal_selesai' => 'required|date',
    ]);

    $permohonan = PermohonanPeriode::findOrFail($id);

    // Validasi agar tidak lebih awal dari tanggal mulai
    if ($permohonan->tanggal_mulai && $request->tanggal_selesai < $permohonan->tanggal_mulai) {
        return back()->with('error', 'Tanggal selesai tidak boleh sebelum tanggal mulai.');
    }

    $permohonan->update(['tanggal_selesai' => $request->tanggal_selesai]);

    return back()->with('success', 'Tanggal selesai permohonan berhasil diperbarui.');
}

}
