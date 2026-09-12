<?php

namespace Modules\Registrasi\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Pasien\Entities\Pasien;
use Modules\Poli\Entities\Poli;
use Modules\Tarif\Entities\Tarif;
use Modules\Registrasi\Entities\Dokter;
use App\User;
use App\Foliopelaksana;

class Folio extends Model
{
    protected $fillable = [];

    public function pelaksana()
    {
        return $this->belongsTo(Foliopelaksana::class);
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function poli()
    {
      return $this->belongsTo(Poli::class);
    }

    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
