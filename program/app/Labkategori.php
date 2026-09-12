<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Laboratorium;
use App\Labsection;
use App\RincianHasillab;

class Labkategori extends Model
{
    protected $fillable = ['nama', 'labsection_id'];

    public function laboratorium()
    {
      return $this->hasMany(Laboratorium::class);
    }
		
    public function labsection()
    {
      return $this->belongsTo(Labsection::class);
    }

    public function rincian()
    {
        return $this->hasMany(RincianHasillab::class);
    }

}
