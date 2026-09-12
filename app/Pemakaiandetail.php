<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Depomasterobat;

class Pemakaiandetail extends Model
{
  public function masterobat()
  {
      return $this->belongsTo(Depomasterobat::class, 'masterobat_id');
  }
}
