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
    Schema::table('pesertas', function (Blueprint $table) {
        $table->unsignedBigInteger('periode_aktif_id')->nullable()->after('status');
        $table->foreign('periode_aktif_id')->references('id')->on('periode_magang')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('pesertas', function (Blueprint $table) {
        $table->dropForeign(['periode_aktif_id']);
        $table->dropColumn('periode_aktif_id');
    });
}

};
