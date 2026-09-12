<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Masternonmedis extends Model
{
    protected $table ='master_nonmedis';
    protected $fillable =[
        'kode_barang',
        'nama_barang',
        'satuan',
        'jenis',
        'stok',
        'harga'
    ];
}
