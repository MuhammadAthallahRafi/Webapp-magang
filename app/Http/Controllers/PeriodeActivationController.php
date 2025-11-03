<?php
// app/Http/Controllers/PeriodeActivationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PeriodeActivationController extends Controller
{
    public function activateToday()
    {
        try {
            // Jalankan command
            Artisan::call('periode:activate-today');
            $output = Artisan::output();
            
            return back()->with([
                'success' => 'Update periode untuk hari ini berhasil!',
                'output' => $output
            ]);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }
}