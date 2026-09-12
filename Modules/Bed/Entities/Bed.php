<?php

namespace Modules\Bed\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Kamar\Entities\Kamar;
use App\Rawatinap;


class Bed extends Model
{
    protected $fillable = ['kamar_id', 'nama', 'kode', 'reserved', 'keterangan'];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function rawatInap()
    {
        return $this->hasMany(Rawatinap::class);
    }
}
