<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class Orderkamarbersalin extends Model {
	protected $table    = 'order_kamarbersalin';
	
	public function registrasi(){
			return $this->belongsTo(Registrasi::class);
	}
}
