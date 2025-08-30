<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id('id_keanggotaan');
            $table->string('jenis_keanggotaan');
            $table->date('keanggotaan_kadaluarsa')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('memberships');
    }
};
