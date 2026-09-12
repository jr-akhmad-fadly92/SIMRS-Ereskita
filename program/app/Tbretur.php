<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbretur extends Model
{
    protected $table = "tb_retur";
    protected $fillable = [
        'no_retur','no_faktur','supplier','petugas','ket_retur','materai','diskon','sub_harga','ppn','total_harga','status'
    ];
}
