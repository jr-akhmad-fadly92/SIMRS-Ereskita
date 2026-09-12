<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Modules\Registrasi\Entities\Registrasi;

class Pemakaian extends Model
{
	public function apoteker()
	{
			return $this->belongsTo(Apoteker::class);
	}
	public function registrasi()
	{
			return $this->belongsTo(Registrasi::class);
	}
}
