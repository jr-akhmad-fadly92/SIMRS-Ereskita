<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterAlergi extends Model
{
    protected $table= 'master_alergi' ;
    public function MasterJenisAlergi(){
    	return $this->belongsTo('App\MasterJenisAlergi');
    }
}
