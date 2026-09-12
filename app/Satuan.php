<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'satuan';
    protected $fillable = ['kode_satuan','nama_satuan'];
    
}
