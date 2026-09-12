<?php

namespace Modules\Asuransi\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class Asuransi extends Model
{
    protected $fillable = ['nama','alamat','id_prk','diskon','plafon','kode'];

    public function registrasi()
    {
      return $this->hasMany(Registrasi::class);
    }
}
