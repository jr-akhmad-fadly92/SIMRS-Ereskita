<?php

namespace Modules\Tarif\Entities;
use Illuminate\Database\Eloquent\Model;

use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Config\Entities\Tahuntarif;
use Modules\Registrasi\Entities\Biayaregistrasi;
use Modules\Registrasi\Entities\Folio;
use Modules\Kelas\Entities\Kelas;

class Tarif extends Model
{
    protected $fillable = ['nama', 'jenis_rj', 'jenis_rd', 'jenis_ri', 'tarif_kelas_vip', 'tarif_kelas_1', 'tarif_kelas_2', 'tarif_kelas_3', 'tarif_kelas_rj', 'kategoriheader_id', 'kategoritarif_id','keterangan','tahuntarif_id'];

    public function kategoritarif()
    {
        return $this->belongsTo(Kategoritarif::class);
    }

    public function tahuntarif()
    {
        return $this->belongsTo(Tahuntarif::class);
    }

    public function biayaregistrasi()
    {
        return $this->hasMany(Biayaregistrasi::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function folio()
    {
        return $this->hasMany(Folio::class);
    }
}
