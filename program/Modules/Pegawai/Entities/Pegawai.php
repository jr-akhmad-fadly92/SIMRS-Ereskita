<?php

namespace Modules\Pegawai\Entities;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = ['nama', 'kategori_pegawai', 'tgllahir', 'tmplahir', 'kelamin', 'agama', 'alamat', 'sip', 'str', 'kompetensi', 'tupoksi', 'user_id','status_ktp_pegawai','status_pegawai','mulai_bekerja','status_gaji'];
}
