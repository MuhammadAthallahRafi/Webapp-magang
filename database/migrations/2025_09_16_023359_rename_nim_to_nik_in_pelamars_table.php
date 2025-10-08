<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('pelamars', function (Blueprint $table) {
            $table->renameColumn('nim', 'nik');
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::table('pelamars', function (Blueprint $table) {
            $table->renameColumn('nik', 'nim');
        });
    }
};
