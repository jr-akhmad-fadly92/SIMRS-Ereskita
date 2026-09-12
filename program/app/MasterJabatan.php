<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterJabatan extends Model
{
    protected $table ='masterjabatan';
    protected $fillable = ['kode_jabatan','nama_jabatan','tunjangan_jabatan'];
}
