<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Icd9\Entities\Icd9;

class PerawatanIcd9 extends Model
{
  public function icd9()
  {
      return $this->belongsTo(Icd9::class);
  }
}
