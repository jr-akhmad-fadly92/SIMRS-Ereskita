<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Registrasi;

class AntrianPoli extends Model {
	protected $table    = 'antrian_poli';
	
	public function poli()
	{
		return $this->belongsTo(Poli::class);
	}
	public function registrasi()
	{
		return $this->belongsTo(Registrasi::class);
	}
}
