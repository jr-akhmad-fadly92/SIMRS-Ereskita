<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historipemeriksaanfisik extends Model
{
    protected $table = 'histori_pemeriksaan_fisik';
    protected $fillable = [
        'registrasi_id','tensi','sistolik','diastolik','suhu','berat','tinggi','status_gizi','anamnesis','keluhan','diagnosa_awal','diagnosa_akhir'
    ];
    
}
