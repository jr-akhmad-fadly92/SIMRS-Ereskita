<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depoinvdetail extends Model
{
    protected $table = "depo_po_inv_detail";
    protected $fillable =['po_id','no_po','kode_barang','nama_barang','jumlah','ruangan','kode_barang_pemberian','nama_barang_pemberian','jumlah_pemberian'];
    
}
