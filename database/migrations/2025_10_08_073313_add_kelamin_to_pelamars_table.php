<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: tambah kolom kelamin di tabel pelamars
     */
    public function up(): void
    {
        Schema::table('pelamars', function (Blueprint $table) {
            $table->enum('kelamin', ['L', 'P'])
                  ->after('nama')
                  ->nullable()
                  ->comment('L = Laki-laki, P = Perempuan');
        });
    }

    /**
     * Rollback migration: hapus kolom kelamin dari tabel pelamars
     */
    public function down(): void
    {
        Schema::table('pelamars', function (Blueprint $table) {
            $table->dropColumn('kelamin');
        });
    }
};
