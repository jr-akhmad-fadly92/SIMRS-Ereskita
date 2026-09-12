<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\TindakanOperasi;

class DataOrderOperasi extends Model {
	protected $table    = 'data_order_operasi';
	public $timestamps 	= false;
	
	public function tindakanOperasi(){
		return $this->belongsTo(TindakanOperasi::class, 'id_tindakan_operasi');
	}
}
