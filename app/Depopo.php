<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Depopo extends Model
{
	protected $table = 'depo_pos';
	public function depo()
	{
			return $this->belongsTo(Depo::class, 'id_depo');
	}
}
