<?php

namespace Modules\Pasien\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Registrasi\Entities\Folio;
use Modules\Pekerjaan\Entities\Pekerjaan;
use Modules\Pasien\Entities\Agama;
use Modules\Pendidikan\Entities\Pendidikan;
use App\Pembayaran;
use App\Hasillab;

class Pasien extends Model
{
    protected $fillable = [];

    public function orangtua()
    {
      return $this->belongsTo(Registrasi::class, 'id_orangtua', 'pasien_id');
    }
		
    public function registrasi()
    {
      return $this->hasMany(Registrasi::class);
    }

    public function folio()
    {
        return $this->hasMany(Folio::class);
    }

    public function pembayaran()
    {
      return $this->hasMany(Pembayaran::class);
    }

    public function hasillab()
    {
        return $this->hasMany(Hasillab::class);
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }

    public function agama()
    {
        return $this->belongsTo(Agama::class);
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class);
    }
}
