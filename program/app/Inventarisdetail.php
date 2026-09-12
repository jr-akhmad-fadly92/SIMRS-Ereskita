<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventarisdetail extends Model
{
    protected $table = "invetaris_detail";
    protected $fillable= ['no_inv','kode_barang','ruangan','lokasi','tanggal_pengadaan','kondisi_barang','harga_barang','asal_barang'];
}
