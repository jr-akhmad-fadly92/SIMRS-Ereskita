<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class Orderlab extends Model {
	protected $table    = 'order_lab';
	
	public function registrasi(){
			return $this->belongsTo(Registrasi::class);
	}
}
