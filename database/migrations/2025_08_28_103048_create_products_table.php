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
       Schema::dropIfExists('products');

        Schema::create('products', function (Blueprint $table) {
            $table->id('id_produk');

            // Jenis Produk (Diskriminator)
            $table->enum('jenis_produk', ['OBAT', 'SUPLAI']);

            // Data Umum
            $table->string('nama_produk');
            $table->string('pabrikan')->nullable();
            $table->string('sku_barcode')->unique();
            $table->string('kategori')->nullable();
            $table->string('digunakan_untuk')->nullable();

            // Stok
            $table->boolean('kontrol_stok')->default(true);
            $table->decimal('stok_awal', 15, 2)->default(0);
            $table->decimal('min_stok', 15, 2)->default(0);
            $table->decimal('max_stok', 15, 2)->default(0);

            $table->decimal('harga_modal', 15, 2);
            $table->decimal('harga_modal_diskon', 15, 2)->nullable();
            $table->decimal('markup', 5, 2)->nullable(); // Persentase, misal 25.50
            $table->enum('cakupan_harga', ['Global', 'Lokal'])->default('Lokal');
            $table->decimal('harga_jual', 15, 2);
            $table->decimal('harga_spesial', 15, 2)->nullable();

            $table->string('kemasan_besar')->nullable();
            $table->string('kemasan_kecil')->nullable();
            $table->decimal('pembagi_konversi', 15, 2)->default(1);

            // Kolom Khusus OBAT (semua bisa kosong/nullable)
            $table->string('nama_generik')->nullable();
            $table->string('dosis')->nullable();
            $table->string('bentuk_sediaan')->nullable();
            $table->string('batch')->nullable();
            $table->date('tgl_kadaluarsa')->nullable();

            // Kolom Khusus SUPLAI (semua bisa kosong/nullable)
            $table->string('no_seri')->nullable();
            $table->date('tgl_akhir_garansi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
