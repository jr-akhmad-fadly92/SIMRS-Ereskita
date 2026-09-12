<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Penjualandetail;

class Masterobat extends Model
{
  protected $fillable = ['nama','kode','kategoriobat_id','satuanbeli_id','satuanjual_id','hargajual', 'hargajual_jkn','hargabeli','aktif','stok'];

  public function satuanbeli()
  {
    return $this->belongsTo(Satuanbeli::class);
  }

  public function satuanjual()
  {
    return $this->belongsTo(Satuanjual::class);
  }

  public function kategoriobat()
  {
    return $this->belongsTo(Kategoriobat::class);
  }

  public function detail()
  {
      return $this->hasMany(Penjualandetail::class);
  }


}
