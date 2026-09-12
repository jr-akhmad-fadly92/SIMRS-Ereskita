<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Kelas\Entities\Kelas;
use Modules\Kamar\Entities\Kamar;
use Modules\Bed\Entities\Bed;

class HistoriRawatInap extends Model
{
    protected $table = 'histori_rawatinap';
	public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class);
    }
}
