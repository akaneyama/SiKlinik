<?php
// app/Models/JadwalPraktek.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalPraktek extends Model
{
    use HasFactory;

    // Tentukan nama tabel kustom jika berbeda dari standar Laravel
    protected $table = 'jadwal_praktek';

    protected $fillable = [
        'id_dokter',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    /**
     * Relasi: Satu Jadwal dimiliki oleh satu Dokter.
     */
public function doctor(): BelongsTo
{
    return $this->belongsTo(Doctor::class, 'id_dokter', 'id_dokter');
}
}
