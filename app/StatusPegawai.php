<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusPegawai extends Model
{
    protected $table ='status_pegawai';
    protected $fillable = ['status','keterangan'];
}
