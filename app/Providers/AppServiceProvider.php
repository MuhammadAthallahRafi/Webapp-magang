<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Models\PeriodeMagang; // ← IMPORT INI
use Carbon\Carbon; // ← IMPORT INI
use Illuminate\Support\Facades\DB; // ← IMPORT INI
use Illuminate\Support\Facades\Cache; // ← IMPORT INI
use Illuminate\Support\Facades\Log; // ← IMPORT INI

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ===== 1. FORCE HTTPS DI LOCAL =====
        
        
          if (config('app.env') === 'local') {
          URL::forceScheme('https');
         }
       

        // ===== 2. AUTO-ACTIVATE PERIODE DI LOCAL =====
        if (app()->environment('local')) {
            $this->checkAndActivateDuePeriodes();
        }
    }

   private function checkAndActivateDuePeriodes()
{
    // Cek cache: cukup 1x sehari
    $cacheKey = 'periode_auto_activate_' . date('Y-m-d');
    if (Cache::has($cacheKey)) {
        return;
    }
    
    $today = now()->toDateString();
    
    // Cari periode 'rencana' yang sudah lewat tanggal mulai
    $periodesBaru = PeriodeMagang::with('peserta')
        ->where('status', 'rencana')
        ->whereDate('tanggal_mulai', '<=', $today)
        ->get();
    
    $activatedCount = 0;
    
    foreach ($periodesBaru as $periodeBaru) {
        try {
            DB::transaction(function () use ($periodeBaru, &$activatedCount) {
                // 1. Nonaktifkan SEMUA periode aktif peserta ini
                // (hanya boleh ada 0 atau 1 yang aktif)
                $updated = PeriodeMagang::where('peserta_id', $periodeBaru->peserta_id)
                    ->where('status', 'aktif')
                    ->update(['status' => 'selesai']);
                
                // 2. Aktifkan periode baru
                $periodeBaru->update(['status' => 'aktif']);
                
                // 3. Update status peserta
                $periodeBaru->peserta()->update(['status' => 'aktif']);
                
                $activatedCount++;
                
                // Log detail
                Log::info("Auto-activated: Peserta #{$periodeBaru->peserta_id}, " .
                         "Periode ke-{$periodeBaru->periode_ke} " .
                         "({$periodeBaru->tanggal_mulai} - {$periodeBaru->tanggal_selesai})");
            });
        } catch (\Exception $e) {
            Log::error("Gagal auto-activate periode #{$periodeBaru->id}: " . $e->getMessage());
        }
    }
    
    // Set cache agar tidak cek berulang hari ini
    Cache::put($cacheKey, true, now()->addDay());
    
    if ($activatedCount > 0) {
        Log::info("✅ Berhasil auto-activate {$activatedCount} periode");
    }
}
}