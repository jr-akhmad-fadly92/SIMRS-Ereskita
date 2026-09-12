<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Labkategori;
use App\Laboratorium;
use Modules\Tarif\Entities\Tarif;

class RincianHasillab extends Model
{
    public function labkategori()
    {
        return $this->belongsTo(Labkategori::class);
    }

    public function laboratoria()
    {
        return $this->belongsTo(Laboratorium::class,'tarif_id','tarif_id');
    }

    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }
}
