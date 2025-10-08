<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            $table->text('alasan')->nullable()->after('catatan_admin');
        });
    }

    public function down(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            $table->dropColumn('alasan');
        });
    }
};

