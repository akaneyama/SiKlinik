<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('patient_insurance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pasien')->constrained('patients', 'id_pasien')->onDelete('cascade');
            $table->foreignId('id_asuransi')->constrained('insurances', 'id_asuransi')->onDelete('cascade');

            // Kolom tambahan untuk mendeskripsikan hubungan
            $table->enum('status_hubungan', ['Pemegang Polis', 'Suami/Istri', 'Anak', 'Lainnya']);
            $table->string('nomor_kartu_pasien')->nullable(); // No kartu pasien di bawah polis tsb

            $table->timestamps();

            // Mencegah duplikasi data: satu pasien tidak bisa didaftarkan ke asuransi yang sama dua kali
            $table->unique(['id_pasien', 'id_asuransi']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('patient_insurance');
    }
};
