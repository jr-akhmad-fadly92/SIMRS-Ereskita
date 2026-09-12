<?php

namespace Modules\Icd10\Entities;
use Illuminate\Database\Eloquent\Model;
use App\PerawatanIcd10;

class Icd10 extends Model
{
    protected $fillable = ['nomor', 'nama'];

    function perawatanicd10()
    {
        return $this->hasMany(PerawatanIcd10::class, 'icd10');
    }
}
