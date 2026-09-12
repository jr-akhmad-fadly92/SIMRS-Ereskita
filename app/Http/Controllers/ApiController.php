<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Bed\Entities\Bed;
use Modules\Kelas\Entities\Kelas;
use Modules\Poli\Entities\Poli;
use App\Fasilitas;
use App\Jadwaldokter;
use DB;

class ApiController extends Controller
{
  public function pengunjung($tga='', $tgb='')
  {
    if (!empty($tga) && !empty($tgb)) {
      $data['jumlah'] = Registrasi::whereBetween('created_at', [valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59'])->where('status_reg', 'LIKE', 'J%')->count();
    }else {
      $data['jumlah'] = Registrasi::where('created_at', 'LIKE', date('Y-m-d').'%')->where('status_reg', 'LIKE', 'J%')->count();
    }
    return response()->json($data);
  }

  public function pengunjung_ird($tga='', $tgb='')
  {
    if (!empty($tga) && !empty($tgb)) {
      $data['jumlah'] = Registrasi::whereBetween('created_at', [valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59'])->where('status_reg', 'LIKE', 'G%')->count();
    }else {
      $data['jumlah'] = Registrasi::where('created_at', 'LIKE', date('Y-m-d').'%')->where('status_reg', 'LIKE', 'G%')->count();
    }
    return response()->json($data);
  }

  public function infoKamar()
  {
    $data['totalbed'] = Bed::count();

    foreach (Kelas::where('nama', '<>', '-')->get() as $key => $d) {
      $data['bed_total '.$d->nama] = DB::table('kamars')->where('kelas_id', $d->id)
                            ->join('beds', 'kamars.id', '=', 'beds.kamar_id')
                            ->count();
    }
    foreach (Kelas::where('nama', '<>', '-')->get() as $key => $d) {
      $data['bed_terpakai '.$d->nama] = DB::table('kamars')->where('kelas_id', $d->id)
                            ->join('beds', 'kamars.id', '=', 'beds.kamar_id')->where('reserved', 'Y')
                            ->count();
    }

    foreach (Kelas::where('nama', '<>', '-')->get() as $key => $d) {
      $data['bed_tersedia '.$d->nama] = DB::table('kamars')->where('kelas_id', $d->id)
                            ->join('beds', 'kamars.id', '=', 'beds.kamar_id')->where('reserved', 'N')
                            ->count();
    }

    return response()->json($data);
  }

  public function antrianPoli($tanggal='', $poli_id='')
  {
    if( !empty($tanggal) && !empty($poli_id) ) {
      $data['pasien'] = DB::table('registrasis')->where('registrasis.created_at', 'LIKE', valid_date($tanggal) .'%')->where('registrasis.poli_id', $poli_id)
                            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
                            ->select('pasiens.no_rm', 'pasiens.nama')
                            ->orderBy('registrasis.created_at', 'asc')
                            ->get();
      $data['poli'] = Poli::whereNotIn('id', ['6'])->select('id', 'nama')->get();
    }
    $data['poli'] = Poli::whereNotIn('id', ['6'])->select('id', 'nama')->get();
    return response()->json($data);
  }

  public function fasilitas()
  {
    $fasilitas = Fasilitas::find(1);
    return response()->json($fasilitas);
  }

  public function jadwalDokter()
  {
    $jadwal = Jadwaldokter::all();
    return response()->json($jadwal);
  }


}
