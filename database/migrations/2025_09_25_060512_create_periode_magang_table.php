<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode_magang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peserta_id');
            $table->integer('periode_ke')->default(1);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->date('tanggal_selesai_lama')->nullable();
            $table->timestamps();

            $table->foreign('peserta_id')
                  ->references('id')->on('pesertas')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_magang');
    }
};
