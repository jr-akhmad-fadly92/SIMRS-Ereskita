<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    protected $table ='penggajian';
    protected $fillable = ['id','kode','nama','jabatan','status_pegawai','status_ktp_pegawai','gaji_pokok','total_gaji','gaji_kontrak'];
}
