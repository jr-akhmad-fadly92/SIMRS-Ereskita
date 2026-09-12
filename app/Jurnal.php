<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $table = 'jurnal';
    protected $fillable=[
        'no_jurnal','no_bukti','tanggal_transaksi','keterangan','kode_keuangan','nilai'];
}
