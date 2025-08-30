<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polis extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_poli';
    protected $fillable = [
        'nama_poli'
    ];
}
