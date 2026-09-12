<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class AntrianApotek extends Model {
	protected $table    = 'antrian_apoteks';
	protected $fillable = ['nomor', 'suara', 'status', 'tanggal', 'panggil', 'loket', 'kelompok'];
}
