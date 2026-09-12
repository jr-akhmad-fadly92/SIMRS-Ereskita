<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Masterobatall extends Model
{
    protected $table = 'ref_obat_all';
    protected $fillable = [
        'id_obat','nama_obat','no_batch','nomor_registrasi','barcode','kode_binfar',
        'satuan','satuan_besar','satuan_besar_unit','satuanjual','satuan_jual_unit',
        'satuanbeli','tipe_sediaan','kemasan_unit','gol_obat','komposisi','indikasi',
        'dosis','supplier','stok','stokmax','stokmin','katagori_obat','jenis_obat',
        'kategori_objek','hargajual','hargajual_jkn','hargabeli','status','experied_date',
        'jenis','aktif'

    ];
    
}
