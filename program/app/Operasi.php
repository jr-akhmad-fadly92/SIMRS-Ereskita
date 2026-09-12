<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class Operasi extends Model
{
	protected $table = 'operasis';
	protected $fillable = [];
  public function registrasi(){
			return $this->belongsTo(Registrasi::class);
	}
}
