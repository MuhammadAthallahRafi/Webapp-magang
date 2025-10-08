<?php

namespace App\Http\Controllers\Adminunitkerja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermohonanPeriode;
use App\Models\Peserta;
use App\Models\User;
use App\Models\PeriodeMagang;
use Carbon\Carbon;

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
            WHEN status = 'selesai' THEN 4
            ELSE 5
        END
    ")->orderByDesc('id');

    // Pagination tetap jalan
    $permohonan = $query->paginate(20)->withQueryString();

    return view('admin-unitkerja.permohonan-periode', compact('permohonan'));
}



   public function approve($id)
{
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
        $pesertaId = $permohonan->peserta_id;
        $periodeKeTerakhir = PeriodeMagang::where('peserta_id', $pesertaId)->max('periode_ke') ?? 0;
        $periodeKeBaru = $periodeKeTerakhir + 1;

        $statusPeriode = $permohonan->tanggal_mulai <= now()->toDateString()
            ? 'aktif'
            : 'menunggu';

        $periodeBaru = PeriodeMagang::create([
            'peserta_id'      => $pesertaId,
            'periode_ke'      => $periodeKeBaru,
            'tanggal_mulai'   => $permohonan->tanggal_mulai,
            'tanggal_selesai' => $permohonan->tanggal_selesai,
            'status'          => $statusPeriode,
        ]);

        $permohonan->peserta->update([
            'periode_aktif_id' => $periodeBaru->id,
            'tanggal_mulai'    => $periodeBaru->tanggal_mulai,
            'tanggal_selesai'  => $periodeBaru->tanggal_selesai,
        ]);
    }

    // ===== 3. MUNDUR =====
    if ($permohonan->jenis_permohonan === 'mundur') {
        $periodeLama = PeriodeMagang::find($permohonan->periode_id);

        if ($periodeLama) {
            $periodeLama->update([
                'tanggal_selesai_lama' => $periodeLama->tanggal_selesai,
                'tanggal_selesai'      => now()->toDateString(),
            ]);
        }

        if ($peserta) {
            $peserta->update([
                'tanggal_selesai_lama' => $peserta->tanggal_selesai,
                'tanggal_selesai'      => now()->toDateString(),
                'status'               => 'mundur',
                'alasan'               => $permohonan->alasan,
            ]);
        }
    }

    // ===== 4. MAGANG KEMBALI =====
    if ($permohonan->jenis_permohonan === 'permohonanmagangkembali') {
        $pesertaId = $permohonan->peserta_id;
        $peserta = Peserta::find($pesertaId);
        if (!$peserta) {
            return back()->with('error', 'Data peserta tidak ditemukan.');
        }

        $periodeKe = PeriodeMagang::where('peserta_id', $pesertaId)->max('periode_ke') ?? 0;
        $periodeKe++;

        PeriodeMagang::create([
            'peserta_id'      => $pesertaId,
            'periode_ke'      => $periodeKe,
            'tanggal_mulai'   => $permohonan->tanggal_mulai,
            'tanggal_selesai' => $permohonan->tanggal_selesai,
            'status'          => 'aktif',
        ]);

        $peserta->update([
            'tanggal_selesai_lama' => $peserta->tanggal_selesai,
            'tanggal_selesai'      => $permohonan->tanggal_selesai,
            'status'               => 'aktif',
        ]);
    }

    return redirect()->route('admin.permohonan-periode')
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
}
