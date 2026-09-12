<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class UangMuka extends Model {
	protected $table    = 'uang_muka';
	
	public function registrasi(){
			return $this->belongsTo(Registrasi::class);
	}
}
