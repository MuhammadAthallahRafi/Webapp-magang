<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeMagang extends Model
{
    use HasFactory;

    protected $table = 'periode_magang';

    protected $fillable = [
        'peserta_id',
        'periode_ke',
        'tanggal_mulai',
        'tanggal_selesai',
        'tanggal_selesai_lama',
    ];

    /**
     * Relasi ke Peserta
     */
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    /**
     * Relasi ke permohonan periode
     */
    public function permohonans()
    {
        return $this->hasMany(PermohonanPeriode::class, 'periode_id');
    }
}
