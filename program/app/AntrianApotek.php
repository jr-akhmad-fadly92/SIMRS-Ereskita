<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class AntrianApotek extends Model {
	protected $table    = 'antrian_apoteks';
	protected $fillable = ['nomor', 'suara', 'status', 'tanggal', 'panggil', 'loket'];
	public function registrasi()
	{
		return $this->belongsTo(Registrasi::class);
	}
}
