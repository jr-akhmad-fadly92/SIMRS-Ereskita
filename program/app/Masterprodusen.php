<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Masterprodusen extends Model
{
    protected $table = "master_produsen_inv";
    //protected $primaryKey = 'id_produsen';
    protected $fillable = ['id_produsen','nama_produsen','alamat_produsen','telp','email','website','kategori'];
}
