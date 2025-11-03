<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonan_periode', function (Blueprint $table) {
            $table->string('surat')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('permohonan_periode', function (Blueprint $table) {
            $table->dropColumn('surat');
        });
    }
};
