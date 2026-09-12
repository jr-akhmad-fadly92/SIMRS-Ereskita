<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Golonganobat extends Model
{
    protected $table ='ref_obat_gol';
    protected $fillable = ['nama_golongan','keterangan'];
    
}
