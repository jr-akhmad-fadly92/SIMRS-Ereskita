<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbstokopnam extends Model
{
    protected $table = 'tb_stok_opnam';
    protected $fillable = [
        'no_stok_opnam','petugas','periode','tanggal_pelaksanaan','kategori','status','catatan'
    ];
    
}
