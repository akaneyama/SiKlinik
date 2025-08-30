<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Insurance extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_asuransi';
    //guarded semua kolom bisa diisi kecuali id
    protected $guarded = ['id_asuransi'];
    protected $casts = ['masa_berlaku' => 'date'];

    // Relasi ke Patient (Satu Asuransi bisa dimiliki BANYAK Pasien)
    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class, 'patient_insurance', 'id_asuransi', 'id_pasien')
                    ->withPivot('status_hubungan', 'nomor_kartu_pasien')
                    ->withTimestamps();
    }
}
