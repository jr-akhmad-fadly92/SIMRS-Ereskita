<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Depomasterobat extends Model
{
    protected $table = 'depo_masterobats';
    
	public function kategoriobat(){
		return $this->belongsTo(Kategoriobat::class);
	}
}
