<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbdetailstokopnam extends Model
{
    protected $table = 'tb_detail_stok_opnam';
    protected $fillable = [
        'no_stok_opnam','kode','stok_sebelum','stok_sesudah','selisih','keterangan'
    ];
}
