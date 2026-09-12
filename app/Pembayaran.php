<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Pasien\Entities\Pasien;

class Pembayaran extends Model
{
  public function pasien()
  {
      return $this->belongsTo(Pasien::class);
  }
}
