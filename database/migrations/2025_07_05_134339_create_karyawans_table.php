<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('divisi')->nullable();
            $table->integer('nilai')->nullable();
            $table->enum('status', ['aktif', 'lulus', 'gagal'])->default('aktif');
            
            // Tambahan field dari pelamar dan admin
            $table->string('id_magang')->unique()->nullable();
            $table->string('nama')->nullable(); // Nama lengkap pelamar
            $table->string('nim')->nullable();
            $table->string('kampus')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('batch')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('alamat')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->text('catatan_admin')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};

