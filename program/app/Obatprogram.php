<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obatprogram extends Model
{
    protected $table = 'ref_obatprogram';
    protected $fillable = ['nama_program','keterangan'];
    
}
