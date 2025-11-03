<?php
// app/Console/Commands/ActivateTodayPeriods.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PeriodeMagang;
use App\Models\Peserta;
use Illuminate\Support\Facades\DB;

class ActivateTodayPeriods extends Command
{
    protected $signature = 'periode:activate-today';
    protected $description = 'Aktifkan periode yang tanggal mulainya hari ini';

    public function handle()
    {
        $today = now()->toDateString();
        $this->info("🎯 MENCARI PERIODE YANG MULAI HARI INI: {$today}");

        // Cari periode dengan status 'rencana' yang mulai hari ini
        $periodesToActivate = PeriodeMagang::with('peserta')
            ->where('status', 'rencana')
            ->where('tanggal_mulai', $today)
            ->get();

        if ($periodesToActivate->isEmpty()) {
            $this->info("✅ Tidak ada periode yang mulai hari ini.");
            return;
        }

        $this->info("📦 Ditemukan {$periodesToActivate->count()} periode yang akan diaktifkan:");

        foreach ($periodesToActivate as $periode) {
            DB::transaction(function () use ($periode) {
                $this->info("");
                $this->info("🔄 Memproses Periode #{$periode->id} untuk {$periode->peserta->nama}");

                // 1. NONAKTIFKAN PERIODE LAMA (jika ada)
                $periodeLama = PeriodeMagang::where('peserta_id', $periode->peserta_id)
                    ->where('id', '!=', $periode->id)
                    ->where('status', 'aktif')
                    ->first();

                if ($periodeLama) {
                    $periodeLama->update([
                        'status' => 'selesai',
                        'tanggal_selesai_lama' => $periodeLama->tanggal_selesai
                    ]);
                    $this->info("   📤 Nonaktifkan periode lama #{$periodeLama->id}");
                }

                // 2. AKTIFKAN PERIODE BARU
                $periode->update(['status' => 'aktif']);
                $this->info("   📥 Aktifkan periode baru #{$periode->id}");

                // 3. UPDATE DATA PESERTA
                $periode->peserta->update([
                    'tanggal_mulai' => $periode->tanggal_mulai,
                    'tanggal_selesai' => $periode->tanggal_selesai,
                    'periode_aktif_id' => $periode->id,
                    'status' => 'aktif'
                ]);
                $this->info("   ✅ Update data peserta: {$periode->peserta->nama}");
            });
        }

        $this->info("");
        $this->info("🎉 SUKSES! {$periodesToActivate->count()} periode diaktifkan.");
    }
}