<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Poli\Entities\Poli;
use Modules\Config\Entities\Config;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Icd10\Entities\Icd10;
use App\Hasilradiologi;
use Modules\Registrasi\Entities\Folio;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Tarif\Entities\Tarif;
use App\KondisiAkhirPasien;
use Modules\Registrasi\Entities\HistoriStatus;
use App\Orderradiologi;
use App\Foliopelaksana;
use App\PerawatanIcd10;
use App\HistorikunjunganRAD;
use App\Pasienlangsung;
use Auth;
use Excel;
use PDF;
use DB;
use DateTime;
use Yajra\DataTables\DataTables;

class RehabmedikController extends Controller
{
    public function tindakanIRJ()
    {
        session()->forget(['dokter', 'pelaksana', 'perawat']);
        $data['registrasi'] = Registrasi::where('status_reg', 'like', 'J%')->where('created_at', 'LIKE', date('Y-m-d').'%')->get();
        return view('rehabmedik.tindakanIRJ', $data)->with('no', 1);
    }

    public function tindakanIRJByTanggal(Request $request)
    {
      request()->validate(['tga'=>'required']);
      session()->forget(['dokter', 'pelaksana', 'perawat']);
      $data['registrasi'] = Registrasi::where('status_reg', 'like', 'J%')->whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])->get();
      return view('rehabmedik.tindakanIRJ', $data)->with('no', 1);
    }

    public function tindakanIRD()
    {
        session()->forget(['dokter', 'pelaksana', 'perawat']);
        $data['registrasi'] = Registrasi::where('status_reg', 'like', 'G%')->where('created_at', 'LIKE', date('Y-m-d').'%')->get();
        return view('rehabmedik.tindakanIRD', $data)->with('no', 1);
    }

    public function tindakanIRDByTanggal(Request $request)
    {
      request()->validate(['tga'=>'required']);
      session()->forget(['dokter', 'pelaksana', 'perawat']);
      $data['registrasi'] = Registrasi::where('status_reg', 'like', 'G%')->whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])->get();
      return view('rehabmedik.tindakanIRD', $data)->with('no', 1);
    }

    public function tindakanIRNA()
    {
        // $data['registrasi'] = Registrasi::join('order_radiologi', 'registrasis.id', '=', 'order_rehabmedik.registrasi_id')
        //                                   ->join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
        //                                   ->select('registrasis.id as id', 'registrasis.bayar', 'registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.pasien_id as pasien_id', 'rawatinaps.kamar_id')
        //                                   ->get();
        session()->forget(['dokter', 'pelaksana', 'perawat']);
        $data['registrasi'] = Registrasi::whereIn('status_reg', ['I1', 'I2'])->get();
        return view('rehabmedik.tindakanIRNA', $data)->with('no', 1);
    }

    public function tindakanIRNAByTanggal(Request $request)
    {
      request()->validate(['tga'=>'required']);
      // $data['registrasi'] = Registrasi::join('order_radiologi', 'registrasis.id', '=', 'order_rehabmedik.registrasi_id')
      //                                   ->join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
      //                                   ->whereBetween('order_rehabmedik.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
      //                                   ->select('registrasis.id as id', 'registrasis.bayar', 'registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.pasien_id as pasien_id', 'rawatinaps.kamar_id')
      //                                   ->get();
      session()->forget(['dokter', 'pelaksana', 'perawat']);
      $data['registrasi'] = Registrasi::whereIn('status_reg', ['I1', 'I2'])
                                      ->whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
                                      ->get();
      return view('rehabmedik.tindakanIRNA', $data)->with('no', 1);
    }

    public function insertKunjungan($registrasi_id, $pasien_id)
    {
      $reg = Registrasi::find($registrasi_id);
      // $cek = HistorikunjunganRAD::where('registrasi_id', $registrasi_id)->where('created_at', 'like', date('Y-m-d').'%')->count();
      // if($cek == 0){
        $hk = new HistorikunjunganRAD();
        $hk->registrasi_id = $registrasi_id;
        $hk->pasien_id = $pasien_id;
        $hk->poli_id = $reg->poli_id;
        if(substr($reg->status_reg, 0,1) == 'J') {
          $hk->pasien_asal = 'TA';
        } elseif (substr($reg->status_reg, 0,1) == 'G') {
          $hk->pasien_asal = 'TG';
        } elseif (substr($reg->status_reg, 0,1) == 'I') {
          $hk->pasien_asal = 'TI';
        }
        $hk->user = Auth::user()->name;
        $hk->save();
      // }
      return redirect('radiologi/entry-tindakan-irj/'. $registrasi_id.'/'.$pasien_id);
    }

    public function entryTindakanIRNA($idreg, $idpasien)
    {
        $data['folio'] = Folio::join('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
                                ->where('registrasi_id', $idreg)
                                ->select('folios.*', 'foliopelaksanas.radiografer')
                                ->where('poli_id', 27)->get();
        $data['pasien'] = Pasien::find($idpasien);
        $data['reg_id'] = $idreg;
        $data['jenis'] = Registrasi::where('id', '=', $idreg)->first();
        $data['poli'] = Folio::where('registrasi_id', '=', $idreg)->distinct();
        $data['tagihan'] = Folio::where('registrasi_id',$idreg)->where('poli_id', 27)->where('lunas', 'N')->sum('total');
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        $data['perawat'] = Pegawai::pluck('nama', 'id');
        $data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();

        $jenis = $data['jenis']->status_reg;
        if (substr($jenis, 0, 1) == 'G') {
            session(['jenis' => 'TG']);
            $data['tindakan'] = Tarif::where('jenis', '=', 'TG')->where('total', '<>', 0)->get();
        } elseif (substr($jenis, 0, 1) == 'J') {
            session(['jenis' => 'TA']);
            $data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
        } elseif (substr($jenis, 0, 1) == 'I') {
            session(['jenis' => 'TI']);
            $data['opt_poli'] = Poli::where('politype', 'R')->get();
        }

        $data['opt_poli'] = Poli::where('politype', 'R')->get();
        $data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
        return view  ('rehabmedik.entryTindakanRadiologiIRNA', $data)->with('no', 1);

    }

    public function entryTindakanIRJ($idreg, $idpasien)
    {
        $data['folio'] = Folio::join('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
                              ->where('folios.registrasi_id', $idreg)
                              ->select('folios.*', 'foliopelaksanas.radiografer')
                              ->where('poli_id', 27)->get();
        $data['pasien'] = Pasien::find($idpasien);
        $data['reg_id'] = $idreg;
        $data['jenis'] = Registrasi::where('id', '=', $idreg)->first();
        $data['poli'] = Folio::where('registrasi_id', '=', $idreg)->distinct();
        $data['tagihan'] = Folio::where('registrasi_id',$idreg)->where('poli_id', 27)->where('lunas', 'N')->sum('total');
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        $data['perawat'] = Pegawai::pluck('nama', 'id');
        $data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();

        $jenis = $data['jenis']->status_reg;
        if (substr($jenis, 0, 1) == 'G') {
            session(['jenis' => 'TG']);
            $data['tindakan'] = Tarif::where('jenis', '=', 'TG')->where('total', '<>', 0)->get();
        } elseif (substr($jenis, 0, 1) == 'J') {
            session(['jenis' => 'TA']);
            $data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
        } elseif (substr($jenis, 0, 1) == 'I') {
            session(['jenis' => 'TI']);
            $data['opt_poli'] = Poli::where('politype', 'R')->get();
        }

        $data['opt_poli'] = Poli::where('politype', 'R')->get();
        $data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
        return view  ('rehabmedik.entryTindakanRadiologi', $data)->with('no', 1);

    }

    public function saveTindakan(Request $request)
    {
        request()->validate(['tarif_id' => 'required']);
        session(['dokter'=>$request['dokter_id'], 'pelaksana'=>$request['pelaksana'], 'perawat'=>$request['perawat']]);
        
        $reg = Registrasi::find($request['registrasi_id']);
        $tarif = Tarif::find($request['tarif_id']);
        $fol = new Folio();
        $fol->registrasi_id = $request['registrasi_id'];
        $fol->poli_id       = $request['poli_id'];
        $fol->lunas         = 'N';
        $fol->namatarif     = $tarif->nama;
        $fol->tarif_id      = $request['tarif_id'];
        $fol->jenis         = $tarif->jenis;
        $fol->cara_bayar_id = $reg->bayar;
        $fol->poli_tipe     = 'R';
        $fol->total         = ($tarif->total * $request['jumlah']);
        $fol->jenis_pasien  = $request['jenis'];
        $fol->pasien_id     = $request['pasien_id'];
        $fol->dokter_id     = $request['dokter_id'];
        $fol->user_id       = Auth::user()->id;
        $fol->poli_id       = $request['poli_id'];
        $fol->save();

        //INSERT FOLIO PELAKSANA
        $fp = new Foliopelaksana();
        $fp->folio_id = $fol->id;
        $fp->dpjp = $reg->dokter_id;
        $fp->radiografer = $request['pelaksana'];
        if(substr($reg->status_reg,0,1) == 'G'){
          $fp->pelaksana_tipe = 'TG';
        }elseif (substr($reg->status_reg,0,1) == 'I') {
          $fp->pelaksana_tipe = 'TI';
        }else{
          $fp->pelaksana_tipe = 'TA';
        }
        $fp->user = Auth::user()->id;
        $fp->save();

        //Update status registrasi
        if(substr($reg->status_reg,0,1) == 'G'){
          $reg->status_reg = 'G2';
        }elseif (substr($reg->status_reg,0,1) == 'I') {
          $reg->status_reg = 'I2';
        }elseif (substr($reg->status_reg,0,1) == 'R') {
          $reg->status_reg = 'R1';
        }else{
          $reg->status_reg = 'J2';
        }
        $reg->update();

      // Insert Histori
      $history = new HistoriStatus();
      $history->registrasi_id = $request['registrasi_id'];
        if(substr($reg->status_reg,0,1) == 'G'){
          $history->status = 'G2';
        }elseif (substr($reg->status_reg,0,1) == 'J') {
          $history->status = 'J2';
      } else {
           $history->status = 'I2';
      }

      $history->poli_id       = $request['poli_id'];
      $history->bed_id        = null;
      $history->user_id       = Auth::user()->id;
      $history->save();
      session()->forget('jenis');
      if (substr($reg->status_reg,0,1) == 'I') {
        return redirect('radiologi/entry-tindakan-irna/'.$request['registrasi_id'].'/'.$request['pasien_id']);
      } elseif (substr($reg->status_reg,0,1) == 'R') {
        return redirect('radiologi/entry-transaksi-langsung/'.$request['registrasi_id']);
      } else {
        return redirect('radiologi/entry-tindakan-irj/'.$request['registrasi_id'].'/'.$request['pasien_id']);
      }
    }

    public function hapusTindakan($id, $idreg, $pasien_id)
    {
      if (Auth::user()->hasRole(['supervisor', 'radiologi','administrator'])) {
        Folio::where('id',$id)->where('lunas', 'N')->delete();
      }
      $reg = Registrasi::find($idreg);
      if(substr($reg->status_reg,0,1) == 'I'){
        return redirect('radiologi/entry-tindakan-irna/'.$idreg.'/'.$pasien_id);
      } elseif (substr($reg->status_reg,0,1) == 'R') {
        return redirect('radiologi/entry-transaksi-langsung/'.$idreg);
      } else {
        return redirect('radiologi/entry-tindakan-irj/'.$idreg.'/'.$pasien_id);

      }
    }

    public function lap_kunjungan()
    {
      $data['dokter'] = Pegawai::select('id','nama')->get();
      $data['petugas'] = Hasilradiologi::distinct()->get(['who_update']);
      return view('rehabmedik.lap_kunjungan', $data);
    }

    public function lap_kunjungan_by_request(Request $request)
    {
      request()->validate(['tga'=>'required', 'tgb'=>'required']);
      $dokter = Pegawai::select('id')->get();
      $di = [];
      foreach ($dokter as $key => $d) {
        $di[] = ''.$d->id.'';
      }

      $petugas = Hasilradiologi::distinct()->get(['who_update']);
      $ptg = [];
      foreach ($petugas as $key => $d) {
        $ptg[] = ''.$d->who_update.'';
      }

      if(!empty($request['tipe_jkn'])) {
        $data['reg'] = Registrasi::join('folios', 'registrasis.id', '=', 'folios.registrasi_id')
                          ->where('folios.poli_id', '=', 27)
                          ->whereBetween('registrasis.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
                          ->whereIn('folios.dokter_id', !empty($request['dokter']) ? [$request['dokter']] : $di)
                          ->whereIn('registrasis.bayar', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
                          ->whereIn('registrasis.tipe_jkn', [$request['tipe_jkn']])
                          ->select('registrasis.id','registrasis.pasien_id','registrasis.poli_id', 'registrasis.bayar', 'registrasis.jenis_pasien', 'registrasis.tipe_jkn', 'folios.*')
                          ->get();
      } else {
        $data['reg'] = Registrasi::join('folios', 'registrasis.id', '=', 'folios.registrasi_id')
                          ->where('folios.poli_id', '=', 27)
                          ->whereBetween('registrasis.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
                          ->whereIn('folios.dokter_id', !empty($request['dokter']) ? [$request['dokter']] : $di)
                          ->whereIn('registrasis.bayar', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
                          ->select('registrasis.id','registrasis.pasien_id','registrasis.poli_id', 'registrasis.bayar', 'registrasis.jenis_pasien', 'registrasis.tipe_jkn', 'folios.*')
                          ->get();
      }
      $datareg = $data['reg'];
      $data['dokter'] = Pegawai::select('id','nama')->get();
      $data['petugas'] = Hasilradiologi::distinct()->get(['who_update']);

      if($request['lanjut']){
        return view('rehabmedik.lap_kunjungan', $data)->with('no', 1);

      } elseif ($request['excel']) {
        Excel::create('Laporan Kunjungan Radiologi', function($excel) use ($datareg) {
        // Set the properties
        $excel->setTitle('Laporan Kunjungan Radiologi')
              ->setCreator('Digihealth')
              ->setCompany('Digihealth')
              ->setDescription('Laporan Kunjungan Radiologi');
        $excel->sheet('Laporan Kunjungan Radiologi', function($sheet) use ($datareg) {
          $row = 1;
          $no = 1;
          $sheet->row($row, [
                        'No',
                        'No. RM',
                        'Nama',
                        'Alamat',
                        'Umur',
                        'L/P',
                        'Cara Bayar',
                        'Poli',
                        'Dokter',
                        'Tanggal / Waktu',
                        'Diagnosa Utama',
                        'Petugas'
                    ]);
            foreach ($datareg as $key => $d) {
              $sheet->row(++$row, [
                          $no++,
                          $d->pasien->no_rm,
                          $d->pasien->nama,
                          $d->pasien->alamat,
                          hitung_umur($d->pasien->tgllahir, 'Y'),
                          $d->pasien->kelamin,
                          baca_carabayar($d->bayar).' '.$d->tipe_jkn,
                          baca_poli($d->poli_id),
                          $d->dokter,
                          tanggal($d->created_at),
                          strip_tags($d->pemeriksaan),
                          $d->who_update
                ]);
              };
            });
        })->export('xlsx');

      } elseif ($request['pdf']) {
        $reg = $data['reg'];
        $no = 1;
        $pdf = PDF::loadView('rehabmedik.pdf_lap_kunjungan', compact('reg', 'no'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('lap_kunjungan_rehabmedik.pdf');
      }
    }

    //TRANSAKSI LANGSUNG
    public function transaksiLangsung()
    {
      $data = Pasienlangsung::where('created_at', 'like', date('Y-m-d').'%')->where('politype', 'R')->get();
      return view('rehabmedik.transaksiLangsung', compact('data'))->with('no', 1);
    }

    public function simpanTransaksiLangsung(Request $request)
    {
      request()->validate(['nama'=>'required', 'alamat'=>'required']);
      DB::transaction(function () use ($request) {
        $id = Registrasi::where('reg_id', 'LIKE',date('Ymd').'%')->count();
        $reg = new Registrasi();
        $reg->pasien_id     = '0';
        $reg->status_reg    = 'R1';
        $reg->bayar         = '2';
        $reg->reg_id        = date('Ymd').sprintf("%04s", ($id + 1));
        $reg->user_create   = Auth::user()->id;
        $reg->save();

        $pasien = new Pasienlangsung();
        $pasien->registrasi_id = $reg->id;
        $pasien->nama = $request['nama'];
        $pasien->alamat = $request['alamat'];
        $pasien->politype = 'R';
        $pasien->pemeriksaan = $request['pemeriksaan'];
        $pasien->user_id = Auth::user()->id;
        $pasien->save();

        $hk = new HistorikunjunganRAD();
        $hk->registrasi_id = $reg->id;
        $hk->pasien_id = '0';
        $hk->poli_id = '27';
        $hk->pasien_asal = 'TA';
        $hk->user = Auth::user()->name;
        $hk->save();
        session(['registrasi_id' => $reg->id]);
      });
      return redirect('/radiologi/entry-transaksi-langsung/'.session('registrasi_id'));
    }

    public function entryTindakanLangsung($registrasi_id)
    {
        $data['folio'] = Folio::join('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
                              ->where('folios.registrasi_id', $registrasi_id)
                              ->select('folios.*', 'foliopelaksanas.radiografer')
                              ->where('poli_id', 27)->get();
        $data['pasien'] = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
        $data['reg_id'] = $registrasi_id;
        $data['poli'] = Folio::where('registrasi_id', '=', $registrasi_id)->distinct();
        $data['tagihan'] = Folio::where('registrasi_id',$registrasi_id)->where('poli_id', 27)->where('lunas', 'N')->sum('total');
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        $data['perawat'] = Pegawai::pluck('nama', 'id');
        $data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
        $data['jenis'] = Registrasi::find($registrasi_id);
        $data['opt_poli'] = Poli::where('politype', 'R')->get();
        $data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
        session(['jenis' => 'TA']);
        return view  ('rehabmedik.entryTindakanLangsung', $data)->with('no', 1); 
    }


    // Laporan RL
    public function rl2()
    {
      return view('rehabmedik/laporan.rl2'); 
    }

    public function rl2_byRequest(Request $request)
    {
      request()->validate(['tga'=>'required', 'tgb'=>'required']);
      $laporan = Icd10::join('perawatan_icd10s','perawatan_icd10s.icd10','=','icd10s.nomor')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')
                      ->whereBetween('registrasis.created_at', [ valid_date($request->tga).' 00:00:00', valid_date($request->tgb).' 23:59:59' ])
                      ->select('icd10s.nomor','icd10s.nama')->groupBy('icd10s.nomor')->get();
      $tga = $request->tga;
      $tgb = $request->tgb;
      $poli_id = $request->poli_id;
      $col28h = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
      ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
      ->where(db::raw("TIMESTAMPDIFF(month , tgllahir, NOW() )"),'<','1')
      ->where('registrasis.status_reg','regexp',$poli_id)->count('perawatan_icd10s.icd10');
      $col1th = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
      ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
      ->where(db::raw("TIMESTAMPDIFF( 
        MONTH , tgllahir, NOW() )"),'<','12')
      ->where(db::raw("TIMESTAMPDIFF( 
        MONTH , tgllahir, NOW() )"),'>=','1')
      ->where('registrasis.status_reg','regexp',$poli_id)->count('perawatan_icd10s.icd10');
      $col4th = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
      ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
      ->where(db::raw("TIMESTAMPDIFF( 
        MONTH , tgllahir, NOW() )"),'>','12')
      ->where(db::raw("TIMESTAMPDIFF( 
        YEAR , tgllahir, NOW() )"),'<=','4')
      ->where('registrasis.status_reg','regexp',$poli_id)->count('perawatan_icd10s.icd10');
      $col14th = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
      ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
      ->where(db::raw("TIMESTAMPDIFF( 
        YEAR , tgllahir, NOW() )"),'>','4')
      ->where(db::raw("TIMESTAMPDIFF( 
        YEAR , tgllahir, NOW() )"),'<=','14')
      ->where('registrasis.status_reg','regexp',$poli_id)->count('perawatan_icd10s.icd10');
      $col24th = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
      ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
      ->where(db::raw("TIMESTAMPDIFF( 
        YEAR , tgllahir, NOW() )"),'>','14')
      ->where(db::raw("TIMESTAMPDIFF( 
        YEAR , tgllahir, NOW() )"),'<=','24')
      ->where('registrasis.status_reg','regexp',$poli_id)->count('perawatan_icd10s.icd10');
      $col44th = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
      ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
      ->where(db::raw("TIMESTAMPDIFF( 
        YEAR , tgllahir, NOW() )"),'>','24')
      ->where(db::raw("TIMESTAMPDIFF( 
        YEAR , tgllahir, NOW() )"),'<=','44')
      ->where('registrasis.status_reg','regexp',$poli_id)->count('perawatan_icd10s.icd10');
      $col64th = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
      ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
      ->where(db::raw("TIMESTAMPDIFF( 
        YEAR , tgllahir, NOW() )"),'>','44')
      ->where(db::raw("TIMESTAMPDIFF( 
        YEAR , tgllahir, NOW() )"),'<=','64')
      ->where('registrasis.status_reg','regexp',$poli_id)->count('perawatan_icd10s.icd10');
      $coltua = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
      ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
      ->where(db::raw("TIMESTAMPDIFF( 
        YEAR , tgllahir, NOW() )"),'>','64')
      ->where('registrasis.status_reg','regexp',$poli_id)->count('perawatan_icd10s.icd10');
      $laki = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
      ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
      ->where('pasiens.kelamin','L')
      ->where('registrasis.status_reg','regexp',$poli_id)->count('perawatan_icd10s.icd10');
      $perempuan = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
      ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
      ->where('pasiens.kelamin','P')
      ->where('registrasis.status_reg','regexp',$poli_id)->count('perawatan_icd10s.icd10');
      $hidup = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
      ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
      ->whereIn('registrasis.keadaan_keluar_inap',['sembuh','membaik'])
      ->where('registrasis.status_reg','regexp',$poli_id)->count('perawatan_icd10s.icd10');
      $mati = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
      ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
      ->whereNotIn('registrasis.keadaan_keluar_inap',['sembuh','membaik'])
      ->where('registrasis.status_reg','regexp',$poli_id)->count('perawatan_icd10s.icd10');
      if ($request['lanjut']) {

        return view('rehabmedik/laporan.rl2',compact('tga','tgb','poli_id'));

      }elseif ($request['pdf']) {

        $config = Config::find(1);

        $periode = $request['tga'].' s/d '.$request['tgb'];

        $pdf = PDF::loadView('rehabmedik/laporan.pdf_rl2', compact('laki','perempuan','hidup','mati','config','tga','tgb','poli_id', 'laporan','periode','col28h','col1th','col4th','col14th','col24th','col44th','col64th','coltua'),[
        'orientation' => 'L']);
        return $pdf->stream();

      } 
       
    }

    public function rl2_data($rawat,$tga,$tgb)
    {
      $laporan = Icd10::join('perawatan_icd10s','perawatan_icd10s.icd10','=','icd10s.nomor')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')
                      ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                      ->select('icd10s.nomor','icd10s.nama')->groupBy('icd10s.nomor')->get();
      
      return DataTables::of($laporan)
      ->addColumn('28h', function ($data) use ($tga,$tgb,$rawat) {
        /*
        $lahir = new DateTime($pasien->tgllahir);
        $conv = date('Y-m-d',strtotime($reg->created_at)); 
        $today = new DateTime($conv);
        $umur = $today->diff($lahir);
        */
        $btn = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
              ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
              ->where(db::raw("TIMESTAMPDIFF(month , tgllahir, NOW() )"),'<','1')
              ->where('registrasis.status_reg','regexp',$rawat)->where('perawatan_icd10s.icd10',$data->nomor)->count('perawatan_icd10s.icd10');
        return $btn;
      })
      ->addColumn('<1th', function ($data) use ($tga,$tgb,$rawat) {
        /*
        $lahir = new DateTime($pasien->tgllahir);
        $conv = date('Y-m-d',strtotime($reg->created_at)); 
        $today = new DateTime($conv);
        $umur = $today->diff($lahir);
        */
        
        $btn = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
                ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->where(db::raw("TIMESTAMPDIFF( 
                  MONTH , tgllahir, NOW() )"),'<','12')
                ->where(db::raw("TIMESTAMPDIFF( 
                  MONTH , tgllahir, NOW() )"),'>=','1')
               ->where('registrasis.status_reg','regexp',$rawat)->where('perawatan_icd10s.icd10',$data->nomor)->count('perawatan_icd10s.icd10');
        return $btn;
      })
      ->addColumn('<4th', function ($data) use ($tga,$tgb,$rawat) {
        $btn = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
                ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->where(db::raw("TIMESTAMPDIFF( 
                  MONTH , tgllahir, NOW() )"),'>','12')
                ->where(db::raw("TIMESTAMPDIFF( 
                  YEAR , tgllahir, NOW() )"),'<=','4')
                ->where('registrasis.status_reg','like','J%')->where('perawatan_icd10s.icd10',$data->nomor)->count('perawatan_icd10s.icd10');
        return $btn;
      })
      ->addColumn('<14th', function ($data) use ($tga,$tgb,$rawat) {
        $btn = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
                ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->where(db::raw("TIMESTAMPDIFF( 
                  YEAR , tgllahir, NOW() )"),'>','4')
                ->where(db::raw("TIMESTAMPDIFF( 
                  YEAR , tgllahir, NOW() )"),'<=','14')
                ->where('registrasis.status_reg','regexp',$rawat)->where('perawatan_icd10s.icd10',$data->nomor)->count('perawatan_icd10s.icd10');
        return $btn;
      })
      ->addColumn('<24th', function ($data) use ($tga,$tgb,$rawat) {
        $btn = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
                ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])        
                ->where(db::raw("TIMESTAMPDIFF( 
                  YEAR , tgllahir, NOW() )"),'>','14')
                ->where(db::raw("TIMESTAMPDIFF( 
                  YEAR , tgllahir, NOW() )"),'<=','24')
                ->where('registrasis.status_reg','regexp',$rawat)->where('perawatan_icd10s.icd10',$data->nomor)->count('perawatan_icd10s.icd10');
        return $btn;
      })
      ->addColumn('<44th', function ($data) use ($tga,$tgb,$rawat) {
        $btn = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
                ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])        
                ->where(db::raw("TIMESTAMPDIFF( 
                  YEAR , tgllahir, NOW() )"),'>','24')
                ->where(db::raw("TIMESTAMPDIFF( 
                  YEAR , tgllahir, NOW() )"),'<=','44')
                ->where('registrasis.status_reg','regexp',$rawat)->where('perawatan_icd10s.icd10',$data->nomor)->count('perawatan_icd10s.icd10');
        return $btn;
      })
      ->addColumn('<64th', function ($data) use ($tga,$tgb,$rawat) {
        $btn = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
                ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->where(db::raw("TIMESTAMPDIFF( 
                  YEAR , tgllahir, NOW() )"),'>','44')
                ->where(db::raw("TIMESTAMPDIFF( 
                  YEAR , tgllahir, NOW() )"),'<=','64')
                ->where('registrasis.status_reg','regexp',$rawat)->where('perawatan_icd10s.icd10',$data->nomor)->count('perawatan_icd10s.icd10');
        return $btn;
      })
      ->addColumn('>64th', function ($data) use ($tga,$tgb,$rawat) {
        $btn = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
                ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->where(db::raw("TIMESTAMPDIFF( 
                  YEAR , tgllahir, NOW() )"),'>','64')
                ->where('registrasis.status_reg','regexp',$rawat)->where('perawatan_icd10s.icd10',$data->nomor)->count('perawatan_icd10s.icd10');
        return $btn;
      })
      ->addColumn('perempuan', function ($data) use ($tga,$tgb,$rawat) {
        $btn = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
                ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->where('pasiens.kelamin','L')
                ->where('registrasis.status_reg','regexp',$rawat)->where('perawatan_icd10s.icd10',$data->nomor)->count('perawatan_icd10s.icd10');
        return $btn;
      })
      ->addColumn('laki', function ($data) use ($tga,$tgb,$rawat) {
        $btn = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
                ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->where('pasiens.kelamin','P')
                ->where('registrasis.status_reg','regexp',$rawat)->where('perawatan_icd10s.icd10',$data->nomor)->count('perawatan_icd10s.icd10');
        return $btn;
      })
      ->addColumn('hidup', function ($data) use ($tga,$tgb,$rawat) {
        $btn = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
                ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->whereIn('registrasis.keadaan_keluar_inap',['sembuh','membaik'])
                ->where('registrasis.status_reg','regexp',$rawat)->where('perawatan_icd10s.icd10',$data->nomor)->count('perawatan_icd10s.icd10');
        return $btn;
      })
      ->addColumn('mati', function ($data) use ($tga,$tgb,$rawat) {
        $btn = db::table('perawatan_icd10s')->join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')
                ->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->whereNotIn('registrasis.keadaan_keluar_inap',['sembuh','membaik'])
                ->where('registrasis.status_reg','regexp',$rawat)->where('perawatan_icd10s.icd10',$data->nomor)->count('perawatan_icd10s.icd10');
        return $btn;
			})
			->rawColumns(['28h','<1th','<4th','<14th','<24th','<44th','<64th','>64th','perempuan','laki','hidup','mati'])
      ->make(true);
                
    }
    //rekammedis pasien 
    /*public function indexrekammedispasien()
    {
        return view('rehabmedik/rekampasien::datatable');
    }

    public function getData()
    {
      $pasien = Pasien::select([
        'id',
        'no_rm',
        'nama',
        'kelamin',
        'tgllahir',
        'alamat'
      ])->orderBy('id', 'asc');

      return DataTables::of($pasien)
      ->addColumn('edit', function ($pasien) {
          return '<a href="'.route('pasien.edit', $pasien->id).'" class="btn btn-primary btn-flat"><i class="fa fa-edit"></i></a>'.
                 '<button type="button" class="btn btn-primary btn-flat" data-idpasien="'.$pasien->id.'" id=pasienshow><i class="fa fa-search"></i></button>'.
                 '<a href="'.url('/frontoffice/histori-pasien/'. $pasien->id).'" class="btn btn-success  btn-flat"><i class="fa fa-file-pdf-o"></i></a>';
      })
      ->editColumn('tgllahir', function ($pasien) {
          return date_format(date_create($pasien->tgllahir), "d-M-Y");
      })
      ->rawColumns(['edit'])
      ->make(true);
    }

    public function search(Request $req)
    {
      request()->validate(['keyword'=>'required']);
      $keyword = $req['keyword'];
      $data['pasien'] = Pasien::where('nama', 'LIKE', '%'.$keyword.'%')
                      ->orWhere('no_rm', 'LIKE', '%'.$keyword.'%')
                      ->orWhere('alamat', 'LIKE', '%'.$keyword.'%')
                      ->get();
      $data['no'] = 1;
      return view('pasien::search', $data);
    }*/

}
