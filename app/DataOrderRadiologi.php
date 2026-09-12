<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\TindakanRadiologi;
use App\Mastermappingbiaya;

class DataOrderRadiologi extends Model {
	protected $table    = 'data_order_radiologi';
	public $timestamps 	= false;
	
	public function tindakanRadiologi(){
		return $this->belongsTo(TindakanRadiologi::class, 'id_tindakan_radiologi');
	}
	public function tindakanRadiologiSub(){
		return $this->belongsTo(Mastermappingbiaya::class, 'mastermapping_biaya_id');
	}
}
