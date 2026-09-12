<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwaldokter extends Model
{
    protected $table = "jadwaldokters";
    protected $fillable = ['poli','dokter','hari','jam_mulai','jam_berakhir'];
}
