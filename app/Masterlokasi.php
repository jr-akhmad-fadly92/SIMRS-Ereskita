<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Masterlokasi extends Model
{
    protected $table ="master_lokasi_ruangan";
    protected $fillable = ['ruangan_id','lokasi'];
}
