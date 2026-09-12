<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class Orderradiologi extends Model {
	protected $table    = 'order_radiologi';
	
	public function registrasi(){
			return $this->belongsTo(Registrasi::class);
	}
}
