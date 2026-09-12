<?php

namespace Modules\Registrasi\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Dokter;
use Modules\Poli\Entities\Poli;
use Modules\Sebabsakit\Entities\Sebabsakit;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Registrasi\Entities\Tagihan;
use Modules\Rujukan\Entities\Rujukan;
use Modules\Asuransi\Entities\Asuransi;
use Modules\Kelas\Entities\Kelas;
use App\User;
use App\AntrianApotek;
use App\Rawatinap;
use App\KondisiAkhirPasien;
use App\Inacbg;

class Registrasi extends Model
{
    protected $fillable = [];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
		
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function kondisi()
    {
        return $this->belongsTo(KondisiAkhirPasien::class, 'kondisi_akhir_pasien');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'dokter_id');
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sebabsakit()
    {
        return $this->belongsTo(Sebabsakit::class);
    }

    public function bayars()
    {
        return $this->belongsTo(Carabayar::class, 'bayar');
    }

    public function tagihan()
    {
      return $this->hasMany(Tagihan::class);
    }

    public function rujukans()
    {
      return $this->belongsTo(Rujukan::class);
    }

    public function asuransi()
    {
        return $this->belongsTo(Asuransi::class);
    }

    public function antrianapotek()
    {
        return $this->belongsTo(AntrianApotek::class, 'antrian_apotek_id');
    }

    public function rawatinap()
    {
        return $this->belongsTo(Rawatinap::class);
    }
		
    public function inacbg()
    {
        return $this->belongsTo(Inacbg::class);
    }
}
