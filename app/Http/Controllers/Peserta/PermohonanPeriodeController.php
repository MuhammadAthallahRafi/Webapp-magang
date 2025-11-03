<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeriodeMagang;
use App\Models\PermohonanPeriode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PermohonanPeriodeController extends Controller
{
    private function hasActivePermohonan($pesertaId, $jenis = null)
    {
        $query = PermohonanPeriode::where('peserta_id', $pesertaId)
            ->whereIn('status', ['pending']); // Hanya cek pending

        if ($jenis) {
            $query->where('jenis_permohonan', $jenis);
        }

        return $query->exists();
    }

    /**
     * Cek apakah ada permohonan pending
     */
    public function checkPendingPermohonan()
    {
        $user = Auth::user();
        $peserta = $user->peserta; // ✅ DIUBAH: pesertaMagang -> peserta

        if (!$peserta) {
            return response()->json(['hasPending' => false]);
        }

        $hasPending = PermohonanPeriode::where('peserta_id', $peserta->id)
            ->where('jenis_permohonan', 'permohonanmagangkembali')
            ->where('status', 'pending')
            ->exists();

        return response()->json(['hasPending' => $hasPending]);
    }

    /**
     * Permohonan percepatan selesai magang
     */
    public function permohonanPercepat(Request $request)
    {
        $request->validate([
            'tanggal_selesai' => 'required|date|after_or_equal:today',
            'alasan'          => 'required|string|max:500',
            'surat'           => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $user    = Auth::user();
        $peserta = $user->peserta; // ✅ DIUBAH: pesertaMagang -> peserta

        if (!$peserta) {
            return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
        }

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

        // ✅ Handle file upload
        $suratPath = null;
        if ($request->hasFile('surat')) {
            $suratPath = $request->file('surat')->store('surat-permohonan', 'public');
        }

        $permohonan = PermohonanPeriode::create([
            'peserta_id'           => $peserta->id,
            'periode_id'           => $periodeAktif->id,
            'jenis_permohonan'     => 'percepat',
            
            'tanggal_selesai'      => $request->tanggal_selesai,
            'tanggal_selesai_lama' => $periodeAktif->tanggal_selesai,
            'alasan'               => $request->alasan,
            'surat'                => $suratPath,
            'tanggal_pengajuan'    => now()->toDateString(),
            'status'               => 'pending',
        ]);

        $peserta->update([
            'periode_aktif_id' => $periodeAktif->id,
        ]);

        return redirect()->route('magang.data-diri')
            ->with('success', 'Permohonan percepatan berhasil diajukan.');
    }

    /**
     * Permohonan tambah periode magang
     */
    public function permohonanTambah(Request $request)
    {
        $request->validate([
            'tanggal_mulai'   => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'alasan'          => 'required|string|max:500',
            'surat'           => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $user = Auth::user();
        $peserta = $user->peserta; // ✅ DIUBAH: pesertaMagang -> peserta

        if (!$peserta) {
            return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
        }

        if ($this->hasActivePermohonan($peserta->id, 'tambah')) {
            return redirect()->route('magang.data-diri')
                ->with('info', 'Anda masih memiliki permohonan tambah periode yang belum selesai.');
        }

        $periodeAktif = $peserta->periodeAktif;

        // ✅ Handle file upload
        $suratPath = null;
        if ($request->hasFile('surat')) {
            $suratPath = $request->file('surat')->store('surat-permohonan', 'public');
        }

        PermohonanPeriode::create([
            'peserta_id'           => $peserta->id,
            'periode_id'           => $periodeAktif?->id,
            'jenis_permohonan'     => 'tambah',
            'tanggal_mulai'        => $request->tanggal_mulai,
            'tanggal_selesai'      => $request->tanggal_selesai,
            'tanggal_selesai_lama' => null,
            'alasan'               => $request->alasan,
            'surat'                => $suratPath,
            'tanggal_pengajuan'    => now(),
            'status'               => 'pending',
        ]);

        return redirect()->route('magang.data-diri')
            ->with('success', 'Permohonan penambahan berhasil diajukan.');
    }

    /**
     * Permohonan mundur dari magang
     */
    public function permohonanMundur(Request $request)
    {
        $request->validate([
            'alasan' => 'required|string|max:500',
            'surat' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $user    = Auth::user();
        $peserta = $user->peserta; // ✅ DIUBAH: pesertaMagang -> peserta

        if (!$peserta) {
            return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
        }

        $periodeAktif = PeriodeMagang::where('status', 'aktif')
            ->where('peserta_id', $peserta->id)
            ->first();

        if (!$periodeAktif) {
            return redirect()->back()->with('error', 'Tidak ada periode aktif.');
        }

        if ($this->hasActivePermohonan($peserta->id, 'mundur')) {
            return redirect()->route('magang.data-diri')
                ->with('info', 'Anda masih memiliki permohonan mundur periode yang belum selesai.');
        }

        // ✅ Handle file upload
        $suratPath = null;
        if ($request->hasFile('surat')) {
            $suratPath = $request->file('surat')->store('surat-permohonan', 'public');
        }

        PermohonanPeriode::create([
            'peserta_id'           => $peserta->id,
            'periode_id'           => $periodeAktif->id,
            'jenis_permohonan'     => 'mundur',
            'alasan'               => $request->alasan,
            'surat'                => $suratPath,
            'tanggal_pengajuan'    => now()->toDateString(),
            'status'               => 'pending',
        ]);

        return redirect()->route('magang.data-diri')
            ->with('success', 'Permohonan mundur berhasil diajukan. Menunggu persetujuan admin.');
    }

    /**
     * Permohonan magang kembali
     */
    public function permohonanMagangKembali(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'alasan' => 'nullable|string|max:500',
            'surat' => 'required|mimes:pdf|max:2048',
        ]);

        $user = Auth::user();
        $peserta = $user->peserta; // ✅ DIUBAH: pesertaMagang -> peserta

        if (!$peserta) {
            return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
        }

        // Validasi status peserta
        if (!in_array($peserta->status, ['mundur', 'lulus'])) {
            return redirect()->route('magang.data-diri')
                ->with('error', 'Hanya peserta yang telah mundur atau lulus yang dapat mengajukan permohonan magang kembali.');
        }

        // Cek permohonan pending
        if ($this->hasActivePermohonan($peserta->id, 'permohonanmagangkembali')) {
            return redirect()->route('magang.data-diri')
                ->with('info', 'Anda masih memiliki permohonan magang kembali yang sedang diproses.');
        }

        // Upload surat
        $suratPath = $request->file('surat')->store('surat-permohonan', 'public');

        // Ambil periode aktif terakhir
        $periodeAktif = $peserta->periodeAktif;

        PermohonanPeriode::create([
            'peserta_id'           => $peserta->id,
            'periode_id'           => $periodeAktif?->id,
            'jenis_permohonan'     => 'permohonanmagangkembali',
            'tanggal_mulai'        => $request->tanggal_mulai,
            'tanggal_selesai'      => $request->tanggal_selesai,
            'tanggal_selesai_lama' => null,
            'alasan'               => $request->alasan ?? 'Permohonan magang kembali',
            'surat'                => $suratPath,
            'tanggal_pengajuan'    => now(),
            'status'               => 'pending',
        ]);

        return redirect()->route('magang.data-diri')
            ->with('success', 'Permohonan magang kembali berhasil diajukan! Silakan tunggu konfirmasi admin.');
    }

    /**
     * Update permohonan magang kembali
     */
    public function updatePermohonanMagangKembali(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'alasan' => 'nullable|string|max:500',
            'surat' => 'sometimes|mimes:pdf,doc,docx|max:2048',
        ]);

        $user = Auth::user();
        $peserta = $user->peserta; // ✅ DIUBAH: pesertaMagang -> peserta

        if (!$peserta) {
            return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
        }

        $permohonan = PermohonanPeriode::where('id', $request->permohonan_id)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        // Update data
        $updateData = [
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan ?? 'Permohonan magang kembali',
            'status' => 'pending',
            'tanggal_pengajuan' => now(),
        ];

        // Upload surat baru jika ada
        if ($request->hasFile('surat')) {
            $suratPath = $request->file('surat')->store('surat-permohonan', 'public');
            $updateData['surat'] = $suratPath;
        }

        $permohonan->update($updateData);

        return redirect()->route('magang.data-diri')
            ->with('success', 'Permohonan magang kembali berhasil diperbarui!');
    }

    /**
     * Update permohonan
     */
    public function updatePermohonan(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|max:500',
            'surat' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $user = Auth::user();
        $peserta = $user->peserta; // ✅ DIUBAH: pesertaMagang -> peserta

        if (!$peserta) {
            return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
        }

        // Cari permohonan yang akan diupdate
        $permohonan = PermohonanPeriode::where('id', $id)
            ->where('peserta_id', $peserta->id)
            ->where('status', 'pending')
            ->firstOrFail();

        // Validasi tambahan berdasarkan jenis permohonan
        if (in_array($permohonan->jenis_permohonan, ['tambah', 'permohonanmagangkembali'])) {
            $request->validate([
                'tanggal_mulai' => 'required|date|after_or_equal:today',
                'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            ]);
        }

        if ($permohonan->jenis_permohonan === 'percepat') {
            $request->validate([
                'tanggal_selesai' => 'required|date|after_or_equal:today',
            ]);
        }

        // Handle file upload
        $suratPath = $permohonan->surat;
        if ($request->hasFile('surat')) {
            // Hapus file lama jika ada
            if ($suratPath && Storage::disk('public')->exists($suratPath)) {
                Storage::disk('public')->delete($suratPath);
            }
            // Upload file baru
            $suratPath = $request->file('surat')->store('surat-permohonan', 'public');
        }

        // Update data permohonan
        $updateData = [
            'alasan' => $request->alasan,
            'surat' => $suratPath,
        ];

        // Update tanggal berdasarkan jenis permohonan
        if (in_array($permohonan->jenis_permohonan, ['tambah', 'permohonanmagangkembali'])) {
            $updateData['tanggal_mulai'] = $request->tanggal_mulai;
            $updateData['tanggal_selesai'] = $request->tanggal_selesai;
        }

        if ($permohonan->jenis_permohonan === 'percepat') {
            $updateData['tanggal_selesai'] = $request->tanggal_selesai;
        }

        $permohonan->update($updateData);

        return redirect()->route('magang.data-diri')
            ->with('success', 'Permohonan berhasil diperbarui. Menunggu persetujuan admin.');
    }

    /**
     * Batalkan permohonan
     */
    public function batalkanPermohonan($id)
    {
        $user = Auth::user();
        $peserta = $user->peserta; // ✅ DIUBAH: pesertaMagang -> peserta

        if (!$peserta) {
            return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
        }

        // Cari permohonan yang akan dibatalkan
        $permohonan = PermohonanPeriode::where('id', $id)
            ->where('peserta_id', $peserta->id)
            ->where('status', 'pending')
            ->first();

        if (!$permohonan) {
            return redirect()->back()->with('error', 'Permohonan tidak ditemukan atau tidak dapat dibatalkan.');
        }

        // Hapus file surat jika ada
        if ($permohonan->surat && Storage::disk('public')->exists($permohonan->surat)) {
            Storage::disk('public')->delete($permohonan->surat);
        }

        // Hapus permohonan
        $permohonan->delete();

        return redirect()->route('magang.data-diri')
            ->with('success', 'Permohonan berhasil dibatalkan.');
    }
}