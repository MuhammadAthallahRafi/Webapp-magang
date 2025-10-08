<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan 'mundur' tanpa menghapus enum lama
        DB::statement("
            ALTER TABLE pesertas 
            MODIFY COLUMN status 
            ENUM('aktif', 'lulus', 'gagal', 'mundur') 
            NOT NULL DEFAULT 'aktif'
        ");
    }

    public function down(): void
    {
        // Rollback ke versi lama tanpa 'mundur'
        DB::statement("
            ALTER TABLE pesertas 
            MODIFY COLUMN status 
            ENUM('aktif', 'lulus', 'gagal') 
            NOT NULL DEFAULT 'aktif'
        ");
    }
};
