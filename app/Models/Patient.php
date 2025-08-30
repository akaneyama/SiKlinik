<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Patient extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pasien';
    protected $guarded = ['id_pasien']; // Alternatif dari $fillable

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi ke Membership (Satu Pasien punya satu Keanggotaan)
    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class, 'id_keanggotaan');
    }

    // Relasi ke Insurance (Satu Pasien bisa punya BANYAK Asuransi)
    public function insurances(): BelongsToMany
    {
        return $this->belongsToMany(Insurance::class, 'patient_insurance', 'id_pasien', 'id_asuransi')
                    ->withPivot('status_hubungan', 'nomor_kartu_pasien') // Ambil data tambahan dari pivot
                    ->withTimestamps();
    }
}
