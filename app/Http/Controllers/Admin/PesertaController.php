<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\User;
use App\Models\Pelamar;
use App\Models\PeriodeMagang;
use App\Models\PermohonanPeriode;
use App\Models\Penilaian;
use App\Models\Absensi;
use Illuminate\Support\Str;
use Illuminate\Support\str_slug; // Import helper
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $query = Peserta::with('user');

         // Apply filters menggunakan FilterController
        $query = FilterController::applyStatusFilter($query, $request->status);
        $query = FilterController::applyDivisiFilter($query, $request->divisi);
        $query = FilterController::applyKelaminFilter($query, $request->kelamin);
        $query = FilterController::applyTahunMulaiFilter($query, $request->tahun_mulai);
        $query = FilterController::applyTahunSelesaiFilter($query, $request->tahun_selesai);
        $query = FilterController::applyNilaiFilter($query, $request->nilai_min, $request->nilai_max);

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
             $query->where(function ($q) use ($searchTerm) {
            $q->where('nama', 'like', '%' . $searchTerm . '%') // cari di tabel pelamars
                ->orWhere('nik', 'like', "%{$term}%") // 🔍 TAMBAH INI
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('no_telp', 'like', "%{$term}%")
                ->orWhere('kampus', 'like', "%{$term}%")
                ->orWhereHas('user', function ($q2) use ($searchTerm) {
                  $q2->where('name', 'like', '%' . $searchTerm . '%'); // cari di relasi users
                  });
            });
        }

         // === Urutkan agar 'lulus' & 'mundur' paling bawah ===
            $query->orderByRaw("
                CASE 
                    WHEN status = 'aktif' THEN 1
                    WHEN status = 'lulus' THEN 2
                    WHEN status = 'mundur' THEN 3
                    ELSE 5
                END
            ");

        $pesertas = $query->get();

        // Get filter options for view
        $filterOptions = [
            'divisiOptions' => FilterController::getDivisiOptions(),
            'tahunOptions' => FilterController::getTahunOptions(),
        ];
        return view('admin.Peserta-magang', compact('pesertas','filterOptions'));

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
public function cetakAbsensi(Request $request, $id)
{
    // Validasi
    $validated = $request->validate([
        'start_date' => 'required|date',
        'end_date'   => 'required|date|after_or_equal:start_date',
    ]);

    // Cari peserta
    $peserta = Peserta::findOrFail($id);

    // Ambil absensi
    $absensi = Absensi::where('peserta_id', $id)
        ->whereBetween('tanggal', [
            $validated['start_date'],
            $validated['end_date']
        ])
        ->orderBy('tanggal', 'asc')
        ->get();

    // Error jika tidak ada data
    if ($absensi->isEmpty()) {
        return redirect()->back()
            ->with('error', 'Tidak ada data absensi pada rentang tanggal tersebut.');
    }

    // Data untuk view PDF
    $data = [
        'peserta' => $peserta,
        'absensi' => $absensi,
        'start' => $validated['start_date'], // Dikirim sebagai $start
        'end' => $validated['end_date'],     // Dikirim sebagai $end
        'tanggal_cetak' => now()->format('d-m-Y H:i:s'),
    ];

    // PERBAIKAN: Ganti str_slug() dengan alternatif yang aman
    // Opsi 1: Ganti spasi dengan tanda minus (sederhana)
    $cleanName = str_replace(' ', '-', $peserta->nama);
    
    // Opsi 2: Atau gunakan ID peserta (lebih aman)
    // $cleanName = 'peserta-' . $peserta->id;
    
    $filename = 'absensi-' . $cleanName . 
               '-' . $validated['start_date'] . 
               '-' . $validated['end_date'] . '.pdf';

    // Generate PDF
    $pdf = Pdf::loadView('admin.absensi.pdf', $data)
              ->setPaper('A4', 'portrait');

    return $pdf->download($filename);
}


        public function periode($id)
        {
            // Ambil data peserta dan semua periode magangnya
            $peserta = Peserta::with(['user'])->findOrFail($id);

            // Ambil semua riwayat periode magang
            $riwayatPeriode = PeriodeMagang::where('peserta_id', $id)
                ->with('penilaian') // ⬅️ GUNAKAN penilaian
                ->orderBy('periode_ke', 'asc')
                ->get();

            // Ambil semua permohonan periode terkait
            $permohonan = PermohonanPeriode::where('peserta_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            $riwayatSikap = null;
                if ($peserta) {
                    $riwayatSikap = Penilaian::with('periode')
                        ->whereHas('periode', function($query) use ($peserta) {
                            $query->where('peserta_id', $peserta->id);
                        })
                        ->orderBy('created_at', 'desc')
                        ->first();
                }

            return view('admin.periode', [
                'active' => 'peserta',
                'peserta' => $peserta,
                'riwayatPeriode' => $riwayatPeriode,
                'permohonan' => $permohonan,
                'riwayatSikap'  => $riwayatSikap// ✅ TAMBAHKAN INI
            ]);
        }


    public function lulus(Request $request, $id)
    {
        $request->validate([
            'disiplin_tepat_waktu' => 'required|numeric|min:0|max:100',
            'disiplin_kehadiran' => 'required|numeric|min:0|max:100',
            'disiplin_tata_tertib' => 'required|numeric|min:0|max:100',
            'kerja_keterampilan' => 'required|numeric|min:0|max:100',
            'kerja_kualitas' => 'required|numeric|min:0|max:100',
            'kerja_tanggung_jawab' => 'required|numeric|min:0|max:100',
            'sosial_komunikasi' => 'required|numeric|min:0|max:100',
            'sosial_kerjasama' => 'required|numeric|min:0|max:100',
            'sosial_inisiatif' => 'required|numeric|min:0|max:100',
            'lain_etika' => 'required|numeric|min:0|max:100',
            'lain_penampilan' => 'required|numeric|min:0|max:100',
        ]);

        $peserta = Peserta::findOrFail($id);

        // ✅ Cari periode aktif peserta
        $periodeAktif = \App\Models\PeriodeMagang::where('peserta_id', $peserta->id)
            ->where('status', 'aktif')
            ->orderByDesc('periode_ke')
            ->firstOrFail();

        // ✅ Hitung total & rata-rata nilai
        $jumlahNilai = collect($request->only([
            'disiplin_tepat_waktu',
            'disiplin_kehadiran',
            'disiplin_tata_tertib',
            'kerja_keterampilan',
            'kerja_kualitas',
            'kerja_tanggung_jawab',
            'sosial_komunikasi',
            'sosial_kerjasama',
            'sosial_inisiatif',
            'lain_etika',
            'lain_penampilan'
        ]))->sum();

        $nilaiRataRata = $jumlahNilai / 11;

        // ✅ Simpan ke penilaian
        Penilaian::create([
            'periode_magang_id' => $periodeAktif->id,
            'disiplin_tepat_waktu' => $request->disiplin_tepat_waktu,
            'disiplin_kehadiran' => $request->disiplin_kehadiran,
            'disiplin_tata_tertib' => $request->disiplin_tata_tertib,
            'kerja_keterampilan' => $request->kerja_keterampilan,
            'kerja_kualitas' => $request->kerja_kualitas,
            'kerja_tanggung_jawab' => $request->kerja_tanggung_jawab,
            'sosial_komunikasi' => $request->sosial_komunikasi,
            'sosial_kerjasama' => $request->sosial_kerjasama,
            'sosial_inisiatif' => $request->sosial_inisiatif,
            'lain_etika' => $request->lain_etika,
            'lain_penampilan' => $request->lain_penampilan,
            'jumlah_nilai' => $jumlahNilai,
            'nilai_rata_rata' => $nilaiRataRata
        ]);

        // ✅ TOLAK SEMUA PERMOHONAN PENDING PESERTA INI
        PermohonanPeriode::where('peserta_id', $peserta->id)
        ->where('status', 'pending')
        ->update([
            'status' => 'ditolak',
            'tanggal_disetujui' => null,
        ]);

        // ✅ Peserta tidak memiliki periode aktif lagi
        $peserta->update([
            'periode_aktif_id' => null,
        ]);

    // ✅ Update status peserta menjadi lulus
        $peserta->update([
            'nilai'  => round($nilaiRataRata),
            'status' => 'lulus',
        ]);

        // ✅ Periode aktif menjadi selesai
        $periodeAktif->update([
            'status' => 'selesai',
            'tanggal_selesai_lama' => $periodeAktif->tanggal_selesai_lama ?? $periodeAktif->tanggal_selesai,
        ]);

    


        return redirect()->route('admin.peserta-magang')
            ->with('success', 'Peserta berhasil diluluskan dengan nilai akhir ' . round($nilaiRataRata));
    }



    public function mundur(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|max:255',
        ]);
        
        // ✅ TOLAK SEMUA PERMOHONAN PENDING PESERTA INI
        PermohonanPeriode::where('peserta_id', $peserta->id)
            ->where('status', 'pending')
            ->update([
                'status' => 'ditolak',
                'tanggal_disetujui' => null,
            ]);

        $peserta = Peserta::findOrFail($id);

        // Update status peserta
        $peserta->update([
            'status' => 'mundur',
            'alasan' => $request->alasan,
            'periode_aktif_id'     => null,
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
            ]);
        }

        return redirect()->route('admin.peserta-magang')
            ->with('success', 'Peserta berhasil dimundurkan dan periode magangnya dibatalkan.');
    }

}
