<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;
use App\Apoteker;


class Penjualan extends Model
{
	public function apoteker()
	{
		return $this->belongsTo(Apoteker::class);
	}
	public function registrasi(){
			return $this->belongsTo(Registrasi::class);
	}
}
