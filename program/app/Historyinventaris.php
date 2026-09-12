<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historyinventaris extends Model
{
    protected $table = "history_inventaris";
    protected $fillable =['no_inv','asal_ruangan','update_ruangan','kondisi_barang','petugas','tanggal_pindah'];
}
