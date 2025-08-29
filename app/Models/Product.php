<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'jenis_produk',
        'nama_produk',
        'gambar_produk',
        'pabrikan',
        'sku_barcode',
        'kategori',
        'digunakan_untuk',
        'kontrol_stok',
        'stok_awal',
        'min_stok',
        'max_stok',
        'harga_modal',
        'harga_modal_diskon',
        'markup',
        'cakupan_harga',
        'harga_jual',
        'harga_spesial',
        'kemasan_besar',
        'kemasan_kecil',
        'pembagi_konversi',
        'nama_generik',
        'dosis',
        'bentuk_sediaan',
        'batch',
        'tgl_kadaluarsa',
        'no_seri',
        'tgl_akhir_garansi',
    ];

    protected $casts = [
        'kategori' => 'array',
        'kontrol_stok' => 'boolean',
        'stok_awal' => 'float',
        'min_stok' => 'float',
        'max_stok' => 'float',
        'harga_modal' => 'float',
        'harga_modal_diskon' => 'float',
        'markup' => 'float',
        'harga_jual' => 'float',
        'harga_spesial' => 'float',
        'pembagi_konversi' => 'float',
        'tgl_kadaluarsa' => 'date',
        'tgl_akhir_garansi' => 'date',
    ];
}
