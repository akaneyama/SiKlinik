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
        Schema::create('doctor_poli', function (Blueprint $table) {
            // Foreign key ke tabel doctors
            $table->foreignId('id_dokter')->constrained('doctors', 'id_dokter')->onDelete('cascade');

            // Foreign key ke tabel polis
            $table->foreignId('id_poli')->constrained('polis', 'id_poli')->onDelete('cascade');

            // Menjadikan kedua kolom sebagai primary key komposit
            // untuk mencegah duplikasi (satu dokter tidak bisa didaftarkan ke poli yang sama dua kali)
            $table->primary(['id_dokter', 'id_poli']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_poli');
    }
};
