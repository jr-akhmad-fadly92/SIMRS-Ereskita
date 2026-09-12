<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Tblplpo extends Model
{
	//public $timestamps = false;
	//protected $connection = 'mysql2';
	//protected $table;
  //protected $fillable = ['tb_lplpo'];
	
	//public function __construct()
  //{
   // $this->table = config('app.db_second').'.tb_lplpo';
  //}
  protected $table = 'tb_lplpo';
  protected $fillable = [
    'no_po','periode','status','create_by'
  ];
	
}
