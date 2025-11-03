<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';

    protected $fillable = [
        'periode_magang_id',

        // Disiplin
        'disiplin_tepat_waktu',
        'disiplin_kehadiran',
        'disiplin_tata_tertib',

        // Pekerjaan
        'kerja_keterampilan',
        'kerja_kualitas',
        'kerja_tanggung_jawab',

        // Perilaku
        'sosial_komunikasi',
        'sosial_kerjasama',
        'sosial_inisiatif',

        // Lain-lain
        'lain_etika',
        'lain_penampilan',

        // Score
        'jumlah_nilai',
        'nilai_rata_rata',
    ];

    /**
     * Relationship ke tabel periode magang
     */
    public function periode()
    {
        return $this->belongsTo(PeriodeMagang::class, 'periode_magang_id');
    }

    /**
     * Hitung jumlah nilai otomatis (helper)
     */
    public function hitungJumlah()
    {
        $nilai = [
            $this->disiplin_tepat_waktu,
            $this->disiplin_kehadiran,
            $this->disiplin_tata_tertib,
            $this->kerja_keterampilan,
            $this->kerja_kualitas,
            $this->kerja_tanggung_jawab,
            $this->sosial_komunikasi,
            $this->sosial_kerjasama,
            $this->sosial_inisiatif,
            $this->lain_etika,
            $this->lain_penampilan,
        ];

        $total = array_sum($nilai);
        $avg = $total / count($nilai);

        $this->jumlah_nilai = $total;
        $this->nilai_rata_rata = $avg;
        return $this;
    }
    public function penilaian()
{
    return $this->hasOne(Penilaian::class, 'periode_magang_id');
}

}
