<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterJenisAlergi extends Model
{
    protected $table ='master_jenis_alergi';
    public function MasterAlergi(){
    	return $this->hasMany('App\MasterAlergi');
    }
}
