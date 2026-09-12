<?php

namespace Modules\Kelas\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Kamar\Entities\Kamar;
use App\Rawatinap;

class Kelas extends Model
{
    protected $fillable = ['nama'];

    public function kamar()
    {
      return $this->hasMany(Kamar::class);
    }

    public function rawatInap()
    {
        return $this->hasMany(Rawatinap::class);
    }
}
