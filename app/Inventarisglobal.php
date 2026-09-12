<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventarisglobal extends Model
{
    protected $table ="inventaris_global";
    protected $fillable =['kode_barang','nama_barang','jumlah_barang','produsen','merk','tahun_produksi','kategori_barang','jenis_barang','harga_unit','total_harga'];
}
