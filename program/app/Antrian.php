<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model {
	protected $table    = 'antrians';
	protected $fillable = ['nomor', 'suara', 'status', 'tanggal', 'panggil', 'loket'];
}
