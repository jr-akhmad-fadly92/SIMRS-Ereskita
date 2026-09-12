<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterDietPasien extends Model
{
    protected $table ="masterdietpasien";
    protected $fillable =['id','kategori_menu','nama_menu','energi_kkal','protein_gr'];
}
