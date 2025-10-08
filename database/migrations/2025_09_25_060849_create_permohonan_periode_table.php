<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan_periode', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peserta_id');
            $table->unsignedBigInteger('periode_id')->nullable();
            $table->enum('jenis_permohonan', ['percepat', 'tambah']);
            $table->text('alasan')->nullable();
            $table->date('tanggal_pengajuan')->default(now());
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->date('tanggal_disetujui')->nullable();
            $table->timestamps();

            $table->foreign('peserta_id')
                  ->references('id')->on('pesertas')
                  ->onDelete('cascade');

            $table->foreign('periode_id')
                  ->references('id')->on('periode_magang')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_periode');
    }
};
