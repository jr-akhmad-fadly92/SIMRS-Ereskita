<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Labkategori;
use App\RincianHasillab;
use App\Mastermappingbiaya;
use Modules\Tarif\Entities\Tarif;

class Laboratorium extends Model
{
    protected $fillable = ['mastermapping_biaya_id', 'tarif_id', 'nilairujukanbawah', 'nilairujukanatas','nilairujukanbawahwanita', 'nilairujukanataswanita','nilairujukanbawahanak', 'nilairujukanatasanak', 'satuan', 'keterangan'];

    public function labkategori()
    {
        return $this->belongsTo(Labkategori::class);
    }

    public function rincian()
    {
        return $this->hasMany(RincianHasillab::class);
    }

    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }

    public function group()
    {
        return $this->belongsTo(Mastermappingbiaya::class,'mastermapping_biaya_id');
    }
}
