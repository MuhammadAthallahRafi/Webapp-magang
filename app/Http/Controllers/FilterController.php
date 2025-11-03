<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilterController extends Controller
{
    /**
     * Apply status filter untuk peserta
     */
    public static function applyStatusFilter($query, $status)
    {
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Apply divisi filter
     */
    public static function applyDivisiFilter($query, $divisi)
    {
        if ($divisi && $divisi !== 'all') {
            $query->where('divisi', $divisi);
        }
        return $query;
    }

    /**
     * Apply kelamin filter (radio button)
     */
    public static function applyKelaminFilter($query, $kelamin)
    {
        if ($kelamin && $kelamin !== 'all') {
            $query->where('kelamin', $kelamin);
        }
        return $query;
    }

    /**
     * Apply tahun filter untuk tanggal_mulai
     */
    public static function applyTahunMulaiFilter($query, $tahun)
    {
        if ($tahun) {
            $query->whereYear('tanggal_mulai', $tahun);
        }
        return $query;
    }

    /**
     * Apply tahun filter untuk tanggal_selesai
     */
    public static function applyTahunSelesaiFilter($query, $tahun)
    {
        if ($tahun) {
            $query->whereYear('tanggal_selesai', $tahun);
        }
        return $query;
    }

    /**
     * Apply nilai range filter
     */
    public static function applyNilaiFilter($query, $nilaiMin, $nilaiMax)
    {
        if ($nilaiMin) {
            $query->where('nilai', '>=', $nilaiMin);
        }
        if ($nilaiMax) {
            $query->where('nilai', '<=', $nilaiMax);
        }
        return $query;
    }

    /**
     * Get all available divisi options
     */
    public static function getDivisiOptions()
    {
        return [
            'IT',
            'HRD', 
            'Finance',
            'Marketing',
            'Operations',
            'Sales',
            'Design',
            'Engineering'
        ];
    }

    /**
     * Get tahun options (5 tahun terakhir + all)
     */
    public static function getTahunOptions()
    {
        $currentYear = date('Y');
        $years = [];
        
        for ($i = 0; $i < 5; $i++) {
            $years[] = $currentYear - $i;
        }
        
        return $years;
    }


    // Tambahkan method ini di FilterController
/**
 * Apply jenis permohonan filter
 */
public static function applyJenisPermohonanFilter($query, $jenisPermohonan)
{
    if ($jenisPermohonan && $jenisPermohonan !== 'all') {
        $query->where('jenis_permohonan', $jenisPermohonan);
    }
    return $query;
}

/**
 * Get jenis permohonan options
 */
public static function getJenisPermohonanOptions()
{
    return [
        'percepat',
        'tambah', 
        'mundur',
        'permohonanmagangkembali'
    ];
}
}