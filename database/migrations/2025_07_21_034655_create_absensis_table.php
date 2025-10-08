<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('absensis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');
        $table->date('tanggal');
        $table->time('jam_masuk')->nullable();
        $table->time('jam_keluar')->nullable();
        $table->string('keterangan')->nullable(); // opsional: sakit, izin, alfa, dll
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
