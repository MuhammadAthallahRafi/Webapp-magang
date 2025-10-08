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
    Schema::create('pelamars', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('nama');
        $table->string('nim');
        $table->string('kampus');
        $table->string('jurusan');
        $table->string('no_telp');
        $table->string('email');
        $table->text('alamat');
        $table->string('batch');
        $table->string('cv'); // path file
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelamars');
    }
};
