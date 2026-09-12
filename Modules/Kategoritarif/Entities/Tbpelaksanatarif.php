<?php

namespace Modules\Kategoritarif\Entities;

use Illuminate\Database\Eloquent\Model;

class Tbpelaksanatarif extends Model
{
    protected $table    = 'tb_pelaksana_tarif';
    protected $fillable = ['id', 'pelaksana'];
}
