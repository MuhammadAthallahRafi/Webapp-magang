<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelamar extends Model
{
      use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'kelamin',
        'nik',
        'kampus',
        'jurusan',
        'no_telp',
        'email',
        'alamat',
        'batch',
        'cv',
        'transkrip',
        'surat',
        'alasan_penolakan',
        'alasan_perbaikan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];
    public function user()
        {
            return $this->belongsTo(\App\Models\User::class, 'user_id','id');
        }
    public function permohonanPeriode()
        {
            return $this->hasMany(PermohonanPeriode::class, 'peserta_id');
        }


}
