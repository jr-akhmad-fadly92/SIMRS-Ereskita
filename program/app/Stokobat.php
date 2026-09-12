<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stokobat extends Model
{
    protected $table ='tb_stok_obat';
    protected $fillable = [
        'no_faktur',
        'barcode',
        'kode_obat',
        'nama_obj',
        'kategori',
        'kode_generik',
        'experied_date',
        'stok',
        'harga',
        'harga_jual',
        'sumber_dana',
        'no_batch',
        'flag',
    ];
    
}
