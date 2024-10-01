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
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->date('tanggal');
            $table->datetime('waktu_datang')->nullable();
            $table->datetime('waktu_pulang')->nullable();
            $table->enum('keterangan', ['hadir', 'izin', 'telat', 'alpha', 'sakit']);

            $table->foreign('siswa_id')->references('id')->on('siswa')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
