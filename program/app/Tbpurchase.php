<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbpurchase extends Model
{
    protected $table ='tb_purchase';
    protected $fillable =[
        'po_id',
        'po_no_purchaseorder',
        'po_nama_pemohon',
        'po_bagian',
        'po_tanggal_pemesanan',
        'po_hargatotal',
        'po_diskon_fak',
        'po_diskon_item',
        'po_supplier',
        'po_hargabayar',
        'po_catatan',
        'po_kategori_order',
        'po_status',
    ];
    
}
