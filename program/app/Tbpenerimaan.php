<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbpenerimaan extends Model
{
    protected $table = "tb_penerimaan";
    protected $fillable =[
        'no_faktur',
        'no_po',
        'no_batch',
        'tanggal',
        'nama_penerimaan',
        'supplier',
        'no_kontak',
        'tanggal_pembayaran'
    ];
}
