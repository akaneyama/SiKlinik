<?php
// app/Models/Doctor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    // Tentukan primary key kustom
    protected $primaryKey = 'id_dokter';

    protected $fillable = [
        'id_user',
        'nama_dokter',
        'no_str',
        'spesialisasi',
    ];

    /**
     * Relasi: Satu Dokter dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relasi: Satu Dokter memiliki banyak JadwalPraktek.
     */
public function jadwalPraktek(): HasMany
{
    return $this->hasMany(JadwalPraktek::class, 'id_dokter', 'id_dokter');
}
}
