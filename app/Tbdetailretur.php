<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbdetailretur extends Model
{
    protected $table = "tb_detail_retur";
    protected $fillable = [
        'no_retur','kode','nama_obj','jumlah','harga','keterangan','satuan','total_harga'
    ];
}
