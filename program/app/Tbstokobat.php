<?php

namespace App;
use App\Refobatall;
use Illuminate\Database\Eloquent\Model;

class Tbstokobat extends Model
{
	/*public $timestamps = false;
	protected $connection = 'mysql2';
	protected $table;
  protected $fillable = ['tb_stok_obat'];
	
	public function __construct()
  {
    $this->table = config('app.db_second').'.tb_stok_obat';
  }
	
	public function refobat()
	{
			return $this->belongsTo(Refobatall::class, 'kode_obat','id_obat');
	}
	*/
	
	protected $table = 'tb_stok_obat';
  	protected $fillable = [
		  'id_faktur','no_faktur','barcode','kode_obat','nama_obj','kategori','kode_generik','experied','stok','satuan',
		  'satuanjual_id','satuanbeli_id','harga','harga_jual','no_batch','flag'
		];
	
}
