<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'pesertas';
    protected $fillable = [
    'user_id',
        'id_magang',
            'nama',
                 'nik',
                    'kampus',
                         'jurusan',
    'batch',
            'no_telp',
                'alamat',
                'tanggal_mulai',
       'tanggal_selesai',
            'catatan_admin',
            'alasan',
    'divisi',
     'nilai', 
     'status',
      'cv', 
      'transkrip',
    'surat',
    'periode_aktif_id'// tambahkan ini
    ];

    public function periodeAktif()
    {
        return $this->belongsTo(PeriodeMagang::class, 'periode_aktif_id');
    }
    public function periodeMagang()
    {
        return $this->hasMany(PeriodeMagang::class, 'peserta_id');
    }
    public function permohonanPeriode()
{
    return $this->hasMany(\App\Models\PermohonanPeriode::class, 'peserta_id');
}

    public function absensi()
    {
        return $this->hasMany(\App\Models\Absensi::class, 'peserta_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
