<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusKtpPegawai extends Model
{
    protected $table ='status_ktp_pegawai';
    protected $fillable = ['status','keterangan','tunjangan'];
}
