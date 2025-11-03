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
        'status',
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

    // Relationship ke Penilaian dengan foreign key yang benar
    public function penilaian()
    {
        return $this->hasOne(Penilaian::class, 'periode_magang_id'); // ⬅️ GUNAKAN periose_magang_id
    }
    
    // Alias untuk konsistensi (optional)
    public function sikap()
    {
        return $this->penilaian();
    }

    /**
     * Relasi ke permohonan periode
     */
    public function permohonans()
    {
        return $this->hasMany(PermohonanPeriode::class, 'periode_id');
    }
}
