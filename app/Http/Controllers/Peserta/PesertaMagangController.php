<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Absensi;
use App\Models\PeriodeMagang;
use App\Models\PermohonanPeriode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PesertaMagangController extends Controller
{
    /**
     * Menampilkan dashboard peserta magang
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function dashboard()
    {
        // Cek apakah user memiliki data peserta
        if (!Auth::user()->peserta) {
            return redirect()->route('login')->with('error', 'Data magang tidak ditemukan.');
        }

        $peserta = Auth::user()->peserta;
        $pesertaId = $peserta->id;

        // Inisialisasi semua variabel
        $absensiHariIni = null;
        $kalender = [];
        $permohonan = null;

        // Jika status aktif, siapkan data absensi
        if ($peserta->status == 'aktif') {
            // Cek absensi hari ini
            $today = Carbon::today();
            $absensiHariIni = Absensi::where('peserta_id', $pesertaId)
                ->whereDate('tanggal', $today)
                ->first();

            // Data kalender bulan ini
            $kalender = $this->getKalender($pesertaId);
        }
        // Jika status mundur atau lulus, siapkan data permohonan MAGANG KEMBALI
        elseif (in_array($peserta->status, ['mundur', 'lulus'])) {
            $permohonan = PermohonanPeriode::where('peserta_id', $pesertaId)
                ->where('jenis_permohonan', 'permohonanmagangkembali')
                ->whereIn('status', ['pending', 'ditolak'])
                ->latest()
                ->first();
        }

        return view('magang.dashboard', compact(
            'absensiHariIni', 
            'kalender', 
            'peserta', 
            'permohonan'
        ));
    }

    /**
     * Menyimpan data absensi masuk peserta
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function absensi(Request $request)
    {
        // Validasi input keterangan absensi
        $request->validate([
            'keterangan' => 'required|in:Hadir,Sakit,Izin,Alfa'
        ]);

        $pesertaId = Auth::user()->peserta->id;
        $today = Carbon::today();

        // Cegah absen lebih dari sekali per hari
        if (Absensi::where('peserta_id', $pesertaId)->whereDate('tanggal', $today)->exists()) {
            return back()->with('error', 'Kamu sudah melakukan absensi hari ini.');
        }

        // Simpan data absensi
        Absensi::create([
            'peserta_id' => $pesertaId,
            'tanggal' => $today,
            'jam_masuk' => Carbon::now()->format('H:i:s'),
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Absensi berhasil disimpan.');
    }

    /**
     * Menyimpan data absensi pulang peserta
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pulang()
    {
        $pesertaId = Auth::user()->peserta->id;
        $today = Carbon::today();

        // Cari data absensi hari ini
        $absensi = Absensi::where('peserta_id', $pesertaId)
            ->whereDate('tanggal', $today)
            ->first();

        // Validasi: harus sudah absensi masuk dulu
        if (!$absensi) {
            return back()->with('error', 'Belum melakukan absensi masuk.');
        }

        // Validasi: cegah absensi pulang dua kali
        if ($absensi->jam_keluar) {
            return back()->with('error', 'Sudah melakukan absensi pulang.');
        }

        // Update jam pulang
        $absensi->update([
            'jam_keluar' => Carbon::now()->format('H:i:s')
        ]);

        return back()->with('success', 'Absensi pulang berhasil.');
    }

    /**
     * Mengambil data kalender absensi untuk bulan berjalan
     * 
     * @param int $pesertaId
     * @return array
     */
    private function getKalender($pesertaId)
    {
        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();

        // Ambil data absensi bulan ini
        $absensiBulan = Absensi::where('peserta_id', $pesertaId)
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->get()
            ->keyBy('tanggal');

        $kalender = [];
        
        // Loop melalui setiap hari dalam bulan
        for ($date = $startOfMonth->copy(); $date <= $endOfMonth; $date->addDay()) {
            $status = null;
            
            // Tentukan status berdasarkan data absensi
            if (isset($absensiBulan[$date->toDateString()])) {
                $status = $absensiBulan[$date->toDateString()]->keterangan;
            } elseif ($date->isWeekend()) {
                $status = 'Libur';
            } elseif ($date->isPast()) {
                $status = 'Alfa';
            } else {
                $status = 'Mendatang';
            }

            // Tambahkan data ke kalender
            $kalender[] = [
                'tanggal' => $date->format('Y-m-d'),
                'status' => $status,
                'jam_masuk' => $absensiBulan[$date->toDateString()]->jam_masuk ?? null,
                'jam_keluar' => $absensiBulan[$date->toDateString()]->jam_keluar ?? null
            ];
        }

        return $kalender;
    }

    /**
     * Menampilkan riwayat absensi peserta
     * 
     * @return \Illuminate\View\View
     */
    public function riwayat()
    {
        $pesertaId = Auth::user()->peserta->id;

        // Ambil semua riwayat absensi (terbaru di atas)
        $riwayat = Absensi::where('peserta_id', $pesertaId)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('magang.riwayat', compact('riwayat'));
    }

    /**
     * Menampilkan halaman data diri peserta
     * 
     * @return \Illuminate\View\View
     */
    public function dataDiri()
    {
        $user = Auth::user();
        $peserta = $user->peserta;

        $periodeAktif = null;
        // Ambil periode aktif jika ada
        if ($peserta && $peserta->periodeAktif) {
            $periodeAktif = $peserta->periodeAktif;
        }

        // Ambil riwayat permohonan periode
        $permohonans = $peserta 
            ? PermohonanPeriode::where('peserta_id', $peserta->id)->latest()->get()
            : collect();

        return view('magang.data-diri', compact('peserta', 'periodeAktif', 'permohonans'));
    }

    /**
     * Memperbarui data diri peserta
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDataDiri(Request $request, $id)
    {
        // Validasi input data diri
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'kampus' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ]);

        $user = Auth::user();
        $peserta = $user->peserta;

        // Pastikan hanya pemilik yang bisa edit
        if (!$peserta || $peserta->id != $id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengedit data ini.');
        }

        // Update data peserta
        $peserta->update($request->all());

        return redirect()->route('magang.data-diri')
            ->with('success', 'Data diri berhasil diperbarui.');
    }

    /**
     * Menambah data pendidikan peserta
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
   public function tambahPendidikan(Request $request, $id)
{
    $request->validate([
        'pendidikan_baru' => 'required|string|max:255',
    ]);

    $peserta = Peserta::findOrFail($id);
    $pendidikanBaru = trim($request->pendidikan_baru);

    // Pisahkan data kampus yang sudah ada
    $list = array_map('trim', explode(',', $peserta->kampus ?? ''));

    // Tambahkan pendidikan baru jika belum ada (hindari duplikat)
    if (!in_array($pendidikanBaru, $list)) {
        $list[] = $pendidikanBaru;
    }

    // Update data kampus
    $peserta->update([
        'kampus' => implode(', ', $list),
    ]);

    return redirect()
        ->route('magang.data-diri')
        ->with('success', 'Pendidikan baru berhasil ditambahkan.');
}

}