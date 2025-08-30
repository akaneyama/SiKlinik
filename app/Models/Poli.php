<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Poli extends Model
{
    use HasFactory;

    protected $table = 'polis'; // Menyesuaikan nama tabel
    protected $primaryKey = 'id_poli';
    protected $fillable = ['nama_poli'];

    /**
     * Relasi Many-to-Many ke model Doctor.
     * Satu Poli bisa memiliki banyak Dokter.
     */
    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class, 'doctor_poli', 'id_poli', 'id_dokter');
    }
}