<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanPeriode extends Model
{
    use HasFactory;

    protected $table = 'permohonan_periode';

    protected $fillable = [
        'peserta_id',
    'periode_id',
    'jenis_permohonan',
    'tanggal_mulai',
    'tanggal_selesai',
    'tanggal_selesai_lama',
    'alasan',
    'tanggal_pengajuan',
    'status',
    'surat',
    'tanggal_disetujui',
    ];

    protected $dates = [
        'tanggal_pengajuan',
        'tanggal_disetujui',
    ];

    protected $casts = [
    'tanggal_pengajuan' => 'date',
    'tanggal_disetujui' => 'date',
];

    /**
     * Relasi ke Peserta
     */
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

    /**
     * Relasi ke PeriodeMagang
     */
    public function periode()
    {
        return $this->belongsTo(PeriodeMagang::class, 'periode_id');
    }
}
