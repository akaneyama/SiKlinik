<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Membership extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_keanggotaan';
    protected $guarded = ['id_keanggotaan'];
    protected $casts = ['keanggotaan_kadaluarsa' => 'date'];

    // Relasi ke Patient (Satu Keanggotaan dimiliki oleh satu Pasien)
    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class, 'id_keanggotaan');
    }
}
