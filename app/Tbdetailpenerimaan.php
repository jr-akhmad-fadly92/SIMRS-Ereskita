<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbdetailpenerimaan extends Model
{
    protected $table = "tb_detail_faktur";
    protected $fillable = [
        'no_faktur',
        'kode',
        'nama_obj',
        'kategori',
        'jumlah',
        'jumlah_diterima',
        'selisih',
        'no_batch',
        'experied',
        'keterangan',
        'harga',
        'harga_jual',
        'diskon_item_persen',
        'diskon_item_rupiah',
        'diskon_faktur_persen',
        'diskon_faktur_rupiah'
        
    ];
}
