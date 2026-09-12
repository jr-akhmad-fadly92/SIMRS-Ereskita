<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AkunKeuangan extends Model
{
    protected $table    = 'akun_keuangan';
	protected $fillable = ['kode_keuangan', 'nama_akun', 'tipe', 'balance','aktiva'];
}
