<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('periode_magang', function (Blueprint $table) {
            $table->enum('status', ['aktif', 'selesai', 'rencana', 'dibatalkan'])
                  ->default('aktif')
                  ->after('tanggal_selesai_lama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('periode_magang', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
