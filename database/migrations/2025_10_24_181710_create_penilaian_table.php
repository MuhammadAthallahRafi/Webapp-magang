<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_magang_id');

            // Disiplin
            $table->tinyInteger('disiplin_tepat_waktu');
            $table->tinyInteger('disiplin_kehadiran');
            $table->tinyInteger('disiplin_tata_tertib');

            // Kerja
            $table->tinyInteger('kerja_keterampilan');
            $table->tinyInteger('kerja_kualitas');
            $table->tinyInteger('kerja_tanggung_jawab');

            // Sosial
            $table->tinyInteger('sosial_komunikasi');
            $table->tinyInteger('sosial_kerjasama');
            $table->tinyInteger('sosial_inisiatif');

            // Lain-lain
            $table->tinyInteger('lain_etika');
            $table->tinyInteger('lain_penampilan');

            // Perhitungan otomatis
            $table->integer('jumlah_nilai')->nullable();
            $table->decimal('nilai_rata_rata', 5, 2)->nullable();

            $table->foreign('periode_magang_id')
                ->references('id')
                ->on('periode_magang')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penilaian');
    }
};
