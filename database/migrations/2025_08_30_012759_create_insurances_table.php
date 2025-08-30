<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('insurances', function (Blueprint $table) {
            $table->id('id_asuransi');
            $table->string('nama_asuransi'); // Misal: BPJS Kesehatan, Prudential, dll.
            $table->enum('jenis_asuransi', ['BPJS', 'Non-BPJS']);
            $table->string('no_polis')->unique();
            $table->string('nama_pemegang_polis');
            $table->string('golongan_departemen')->nullable();
            $table->date('masa_berlaku')->nullable();
            $table->string('hak_kelas_rawat_inap')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('insurances');
    }
};
