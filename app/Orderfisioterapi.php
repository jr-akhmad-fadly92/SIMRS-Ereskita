<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class Orderfisioterapi extends Model {
	protected $table    = 'order_fisioterapi';
	
	public function registrasi(){
			return $this->belongsTo(Registrasi::class);
	}
}
