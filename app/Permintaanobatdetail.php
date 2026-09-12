<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Masterobat;
use App\Obatracikan;

class Permintaanobatdetail extends Model
{
	protected $table    = 'permintaan_obat_details';
  public function masterobat()
  {
    return $this->belongsTo(Masterobat::class, 'masterobat_id');
  }
	public function obatRacikan()
  {
    return $this->belongsTo(Obatracikan::class, 'obat_racikan_id');
  }
}
