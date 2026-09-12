<?php

namespace Modules\Antrian\Entities;
use Modules\Registrasi\Entities\Registrasi;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
	protected $fillable = ['nomor', 'suara', 'status', 'tanggal', 'panggil', 'loket', 'kelompok'];
	
	public function registrasi(){
		return $this->belongsTo(Registrasi::class, 'id','antrian_id');
	}
}
