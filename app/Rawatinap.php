<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Kelas\Entities\Kelas;
use Modules\Kamar\Entities\Kamar;
use Modules\Bed\Entities\Bed;
use Modules\Registrasi\Entities\Registrasi;

class Rawatinap extends Model
{
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

    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class);
    }
}
