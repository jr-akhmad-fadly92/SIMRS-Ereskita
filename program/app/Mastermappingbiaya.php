<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Labsection;
use App\TindakanRadiologi;

class Mastermappingbiaya extends Model
{
    protected $table = 'mastermapping_biaya';
		
    public function labsection()
    {
        return $this->belongsTo(Labsection::class);
    }
    public function radiologi()
    {
        return $this->belongsTo(TindakanRadiologi::class,'tindakan_radiologi_id');
    }
}
