<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('patients', function (Blueprint $table) {
            $table->id('id_pasien');
            $table->string('nama_pasien');
            $table->string('no_identitas')->unique()->nullable();
            $table->enum('jenis_identitas', ['KTP', 'SIM', 'Paspor', 'Lainnya'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->enum('gol_darah', ['A', 'B', 'AB', 'O', 'Tidak Tahu'])->nullable();
            $table->string('etnis')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('tingkat_pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('agama')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('nomor_telp')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('id_lama')->nullable(); // No Rekam Medis Lama

            // Relasi One-to-One dengan Membership
            $table->foreignId('id_keanggotaan')->nullable()->constrained('memberships', 'id_keanggotaan')->onDelete('set null');

            // Kontak Kerabat
            $table->string('kerabat_pasien')->nullable();
            $table->string('hubungan_kerabat')->nullable();
            $table->string('no_telp_kerabat')->nullable();

            // Alamat
            $table->text('alamat_domisili')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('telepon_domisili')->nullable();

            // Info Perusahaan
            $table->string('perusahaan')->nullable();
            $table->text('alamat_perusahaan')->nullable();
            $table->string('telepon_perusahaan')->nullable();

            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('patients');
    }
};
