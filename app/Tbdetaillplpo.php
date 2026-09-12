<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Tbdetaillplpo extends Model
{
	
  protected $table ='tb_detail_lplpo';
  protected $fillable = [
    'id_lplpo','no_batch','kode_obat','nama_obj','id_stok_pemberian','kode_obat_pemberian','nama_obj_pemberian',
    'permintaan','pemberian','stok_awal'
  ];
	
}
