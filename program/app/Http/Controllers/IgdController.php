<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Poli\Entities\Poli;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Rujukan\Entities\Rujukan;
use Modules\Pasien\Entities\Regency;
use Modules\Registrasi\Entities\Registrasi;
use PDF;
use App\User;
use App\Role;
use Auth;
use App\Exports\LapPengIGDExport;
use Maatwebsite\Excel\Facades\Excel;

class IgdController extends Controller
{
    public function lap_pengunjung()
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' || strtolower(Auth::user()->role()->first()->name)=='rawatdarurat')
        {
          $data['dokter'] = Pegawai::select('nama', 'id')->get();
          $data['kota'] = Regency::where('province_id', 33)->select('id', 'name')->get();
          $data['user_create'] = Registrasi::distinct()->where('status','lama')->where('status','baru')->get(['user_create']);
          return view('igd.laporan_pengunjung', $data);
        }else{
            return redirect('/dashboard');
        }
      
    }

    public function lap_pengunjung_byRequest(Request $request)
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' || strtolower(Auth::user()->role()->first()->name)=='rawatdarurat')
        {
          request()->validate(['tga' => 'required', 'tgb' => 'required']);
          $dokter = Pegawai::select('id')->get();
          $di = [];
          foreach ($dokter as $key => $d) {
            $di[] = ''.$d->id.'';
          }

          $rujukan = Rujukan::select('id')->get();
          $rj = [];
          foreach ($rujukan as $key => $d) {
            $rj[] = ''.$d->id.'';
          }

          //$register = Registrasi::distinct()->get(['user_create']);
          $register1 = Registrasi::select('user_create')->groupBy('user_create')->get();
          $rgt = [];
          foreach ($register1 as $key => $d) {
            $rgt[] = ''.$d->user_create.'';
          }

          $data['dokter'] = Pegawai::select('nama', 'id')->get();
          $data['kota'] = Regency::where('province_id', 33)->select('id', 'name')->get();
          $data['user_create'] = Registrasi::distinct()->get(['user_create']);

          if(!empty($request['tipe_jkn'])) {
            $data['reg'] = Registrasi::whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
                                      ->where('status_reg', 'LIKE', 'G%')
                                      ->whereIn('jenis_pasien', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
                                      ->whereIn('tipe_jkn', !empty($request['tipe_jkn']) ? [$request['tipe_jkn']] : ['PBI', 'NON PBI'])
                                      ->whereIn('dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
                                      ->whereIn('user_create', !empty($request['user_create']) ? [$request['user_create']] : $rgt)
                                      ->get();
              $data['total_pasien'] = Registrasi::whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
                                      ->where('status_reg', 'LIKE', 'G%')
                                      ->whereIn('jenis_pasien', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
                                      ->whereIn('tipe_jkn', !empty($request['tipe_jkn']) ? [$request['tipe_jkn']] : ['PBI', 'NON PBI'])
                                      ->whereIn('dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
                                      ->whereIn('user_create', !empty($request['user_create']) ? [$request['user_create']] : $rgt)
                                      ->count();
              $data['total_pasien_laki'] = Registrasi::join('pasiens','pasiens.id','=','registrasis.pasien_id')
                                      ->whereBetween('registrasis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
                                      ->where('registrasis.status_reg', 'LIKE', 'G%')
                                      
                                      ->whereIn('registrasis.jenis_pasien', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
                                      ->whereIn('registrasis.tipe_jkn', !empty($request['tipe_jkn']) ? [$request['tipe_jkn']] : ['PBI', 'NON PBI'])
                                      ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
                                      ->whereIn('registrasis.user_create', !empty($request['user_create']) ? [$request['user_create']] : $rgt)
                                      ->count();
              $data['total_pasien_wanita'] = Registrasi::join('pasiens','pasiens.id','=','registrasis.pasien_id')
                                      ->whereBetween('registrasis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
                                      ->where('registrasis.status_reg', 'LIKE', 'G%')
                                      ->where('pasiens.kelamin',  'P')
                                      ->whereIn('registrasis.tipe_jkn', !empty($request['tipe_jkn']) ? [$request['tipe_jkn']] : ['PBI', 'NON PBI'])
                                      
                                      ->whereIn('registrasis.jenis_pasien', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
                                      ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
                                      ->whereIn('registrasis.user_create', !empty($request['user_create']) ? [$request['user_create']] : $rgt)
                                      ->count();
            /* $data['total_pasien_meninggal'] = Registrasi::whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
                                      ->where('status_reg', 'LIKE', 'G%')
                                      ->whereIn('jenis_pasien', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
                                      ->whereIn('tipe_jkn', !empty($request['tipe_jkn']) ? [$request['tipe_jkn']] : ['PBI', 'NON PBI'])
                                      ->whereIn('dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
                                      ->whereIn('user_create', !empty($request['user_create']) ? [$request['user_create']] : $rgt)
                                      ->where('kondisi_akhir_pasien', '4')
                                      ->count();
              $data['total_pasien_rujuk'] = Registrasi::whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
                                      ->where('status_reg', 'LIKE', 'G%')
                                      ->whereIn('jenis_pasien', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
                                      ->whereIn('tipe_jkn', !empty($request['tipe_jkn']) ? [$request['tipe_jkn']] : ['PBI', 'NON PBI'])
                                      ->whereIn('dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
                                      ->whereIn('user_create', !empty($request['user_create']) ? [$request['user_create']] : $rgt)
                                      ->whereIn('kondisi_akhir_pasien', '2')
                                      ->count();*/
              //$data['total_pasien_pulang'] = $data['total_pasien_rujuk'] - $data['total_pasien_meninggal'] - $data['total_pasien'];
          } else {
            $data['reg'] = Registrasi::whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
                                      ->where('status_reg', 'LIKE', 'G%')
                                      ->whereIn('jenis_pasien', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
                                      ->whereIn('dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
                                      ->whereIn('user_create', !empty($request['user_create']) ? [$request['user_create']] : $rgt)
                                      ->get();
              $data['total_pasien'] = Registrasi::whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
                                      ->where('status_reg', 'LIKE', 'G%')
                                      ->whereIn('jenis_pasien', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
                                      ->whereIn('dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
                                      ->whereIn('user_create', !empty($request['user_create']) ? [$request['user_create']] : $rgt)
                                      ->count();
              $data['total_pasien_laki'] = Registrasi::join('pasiens','pasiens.id','=','registrasis.pasien_id')
                                      ->whereBetween('registrasis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
                                      ->where('registrasis.status_reg', 'LIKE', 'G%')
                                      ->where('pasiens.kelamin',  'L')
                                      ->whereIn('registrasis.jenis_pasien', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
                                      ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
                                      ->whereIn('registrasis.user_create', !empty($request['user_create']) ? [$request['user_create']] : $rgt)
                                      ->count();
              $data['total_pasien_wanita'] = Registrasi::join('pasiens','pasiens.id','=','registrasis.pasien_id')
                                      ->whereBetween('registrasis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
                                      ->where('registrasis.status_reg', 'LIKE', 'G%')
                                      ->where('pasiens.kelamin',  'P')
                                      ->whereIn('registrasis.jenis_pasien', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
                                      ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
                                      ->whereIn('registrasis.user_create', !empty($request['user_create']) ? [$request['user_create']] : $rgt)
                                      ->count();
              /*$data['total_pasien_meninggal'] = Registrasi::whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
                                      ->where('status_reg', 'LIKE', 'G%')
                                      ->where('kondisi_akhir_pasien', '4')
                                      ->whereIn('jenis_pasien', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
                                      ->whereIn('tipe_jkn', !empty($request['tipe_jkn']) ? [$request['tipe_jkn']] : ['PBI', 'NON PBI'])
                                      ->whereIn('dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
                                      ->whereIn('user_create', !empty($request['user_create']) ? [$request['user_create']] : $rgt)
                                      ->count();
              $data['total_pasien_rujuk'] = Registrasi::whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
                                      ->where('status_reg', 'LIKE', 'G%')
                                      ->whereIn('jenis_pasien', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
                                      ->whereIn('tipe_jkn', !empty($request['tipe_jkn']) ? [$request['tipe_jkn']] : ['PBI', 'NON PBI'])
                                      ->whereIn('dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
                                      ->whereIn('user_create', !empty($request['user_create']) ? [$request['user_create']] : $rgt)
                                      ->whereIn('kondisi_akhir_pasien', '2')
                                      ->count();*/
              //$data['total_pasien_pulang'] = $data['total_pasien_rujuk'] - $data['total_pasien_meninggal'] - $data['total_pasien'];
          }

          $datareg = $data['reg'];
          if($request['lanjut']) {
          return view('igd.laporan_pengunjung', $data)->with('no', 1);
          } 
          
          elseif ($request['excel']) {
            //return Excel::download(new LapPengIGDExport($data['total_pasien'],$data['total_pasien_laki'],$data['total_pasien_wanita'],$data['reg']), 'Laporan Pengunjung IGD.xlsx')->with('no', 1);
          // return Excel::download(new LapPengIGDExport($request['tga'],$request['tga']), 'Laporan Pengunjung IGD.xlsx');
          // return Excel::download(new LapPengIGDExport, 'invoices.xlsx');
            
            Excel::create('Laporan Kunjungan IGD', function($excel) use ($datareg) {
            // Set the properties
            $excel->setTitle('Laporan Kunjungan IGD')
                  ->setCreator('Digihealth')
                  ->setCompany('Digihealth')
                  ->setDescription('Laporan Kunjungan IGD');
            $excel->sheet('Laporan Kunjungan IGD', function($sheet) use ($datareg) {
              $row = 1;
              $no = 1;
              $sheet->row($row, [
                            'No',
                            'Nama',
                            'No. RM',
                            'Umur',
                            'L/P',
                            'Poli Tujuan',
                            'Dokter',
                            'Cara Bayar',
                            'Tanggal',
                            'Petugas'
                        ]);
                foreach ($datareg as $key => $d) {
                  $sheet->row(++$row, [
                              $no++,
                              $d->pasien->nama,
                              $d->pasien->no_rm,
                              hitung_umur($d->pasien->tgllahir, 'Y'),
                              $d->pasien->kelamin,
                              !empty($d->poli_id) ? $d->poli->nama : '',
                              !empty($d->dokter_id) ? baca_dokter($d->dokter_id) : '',
                              baca_carabayar($d->bayar).' '.$d->tipe_jkn,
                              tanggal($d->created_at),
                              User::find($d->user_create)->name
                  ]);
                }
                });
            })->export('xlsx');

          } elseif ($request['pdf']) {
            $reg = $data['reg'];
            $no = 1;
            $pdf = PDF::loadView('igd.pdf_laporan_pengunjung', compact('reg', 'no'),$data);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('lap_kunjungan_ird.pdf');

          }
        }else{
            return redirect('/dashboard');
        }
      

    }
}
