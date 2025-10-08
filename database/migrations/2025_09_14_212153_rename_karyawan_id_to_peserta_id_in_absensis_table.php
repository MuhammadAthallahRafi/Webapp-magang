<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            // Drop foreign key lama dulu
            $table->dropForeign(['karyawan_id']);

            // Rename kolom
            $table->renameColumn('karyawan_id', 'peserta_id');

            // Tambahkan foreign key baru
            $table->foreign('peserta_id')->references('id')->on('peserta')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['peserta_id']);
            $table->renameColumn('peserta_id', 'karyawan_id');
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
        });
    }
};
