<?php

namespace Modules\Antrian\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Poli\Entities\Poli;
use Modules\Antrian\Entities\Antrian;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\Registrasi;
use App\AntrianApotek;
use App\AntrianPoli;
use DB;
use App\User;
use App\Role;
use Auth;

class AntrianController extends Controller
{

  function __construct()
  {
    $this->middleware(['auth']);
  }

  public function touch()
  {
    return view('antrian::touch');
  }

  public function savetouch(Request $request)
  {
    $count = Antrian::where('tanggal', '=', date('Y-m-d'))->count();
    $nomor = $count + 1;
    $suara = $nomor.'.mp3';

    $data['nomor'] = $nomor;
    $data['suara'] = $suara;
    $data['status'] = '0';
    $data['panggil'] = 0;
    $data['tanggal'] = date('Y-m-d');
    $data['kelompok'] = '';
    $juml_terpanggil = Antrian::where('status', '!=', '0')->where('tanggal', date('Y-m-d'))->count();
    $data['sisa'] = $nomor - $juml_terpanggil;
    $data['time'] = date('d-m-Y H:i:s');
    if(Antrian::create($data)){
			return response()->json(['status' => true, 'message' => $data]);
		}else{
			return response()->json(['status' => false, 'message' => 'Terjadi kesalahan, silahkan coba lagi!']);
		}
		//return view('antrian::cetak_antrian', $data)->with('kelompok',$request['kelompok']);
  }

  public function layarlcd()
  {
    return view('antrian::layarlcd');
  }
	
	public function layarantrian()
  {
    return view('antrian::layarantrian');
  }
	
  public function datalayarlcd($loket=0)
  {
    $antrian = Antrian::whereIn('status', [1, 2, 3])
                      ->where('loket', $loket)
                      ->where('tanggal',date('Y-m-d'))
                      ->orderBy('id', 'desc')->first();
    return view('antrian::datalayarlcd', compact('antrian'));
  }

  public function daftarpanggil($loket=0)
  {
    $antrian = Antrian::where('tanggal', '=', date('Y-m-d'))
                      //->where('kelompok', 'A')
                      ->where('status', '=', '0')
                      ->take(1)
                      ->get();
    return view('antrian::daftarpanggil', compact('antrian'))->with('loket',$loket);
  }

  public function daftarantrian($loket=0)
  {
    session()->forget('blm_terdata');
    session()->forget('jenis');
    session()->forget('igdlama');
    session()->forget('igdumum-lama');
    session()->forget('pasienID');
    $terpanggil = Antrian::where('tanggal', '=', date('Y-m-d'))
                          ->where('status', '<>', '0')
                          ->where('loket', $loket)
                          ->orderBy('id', 'desc')
                          ->get();
		session(['no_loket'=>$loket]);
    return view('antrian::daftarantrian', compact('terpanggil'))->with('loket',$loket);
  }
	
  public function panggil(Request $request)
  {
		session(['no_loket'=>$request['loket']]);
		session(['antrian_id'=>$request['id']]);
    $atr = Antrian::where('status',0)->where('id',$request['id'])->first();
		if($atr==null){
			return response()->json(['status' => false, 'message' => 'Silahkan pilih antrian lagi']);
		}else{
			$atr->status = 1;
			$atr->loket = $request['loket'];
			$atr->panggil = 0;
		  $atr->save();
		  return response()->json(['status' => true, 'message' => 'Sukses']);
		}
  }

  public function panggilkembali(Request $request)
  {
		session(['no_loket'=>$request['loket']]);
		session(['antrian_id'=>$request['id']]);
    $d = Antrian::find($request['id']);
    $d->status = $d->status + 1;
    $d->panggil = 0;
    $d->update();
    return response()->json(['status' => true, 'message' => 'Sukses']);
  }

  public function poli(Request $request)
  {
    $atr = AntrianPoli::where('registrasi_id',$request['regid'])->first();
		if($atr==null){
			$atr = new AntrianPoli;
			$atr->registrasi_id = $request['regid'];
			$atr->antrian = $request['antrian'];
			$atr->poli_id = $request['poli'];
			$atr->tanggal = date('Y-m-d');
		}
		$atr->ruang = session('ruang');
		$atr->created_at = date('Y-m-d H:i:s');
		$atr->status_panggil = 0;
		$atr->save();
		return response()->json(['status' => true, 'message' => 'Sukses']);
  }
	
  public function registrasi($id, $jenis)
  {
    $d = Antrian::find($id);
    $d->status = 3;
    $d->update();
    if($jenis == 'jkn') {
      return redirect('registrasi/create');
    }elseif($jenis == 'umum'){
      return redirect()->route('registrasi.create_umum');
    }
  }

  public function reg_pasienlama($id, $jenis)
  {
    $d = Antrian::find($id);
    $d->status = 3;
    $d->update();
    if($jenis == 'jkn'){
      return redirect('registrasi');
    }elseif ($jenis == 'umum') {
      session( ['jenis'=>'umum']);
      return redirect('registrasi');
    }
  }

  public function reg_blm_terdata($id, $jenis)
  {
    $d = Antrian::find($id);
    $d->status = 3;
    $d->update();
    session(['blm_terdata'=>true]);
    if($jenis == 'jkn'){
      return redirect('registrasi/create');
    }elseif ($jenis == 'umum') {
      return redirect('registrasi/create_umum');
    }
  }

  public function suara()
  {
    $antrian 	=	Antrian::whereIn('status', [1, 2, 3])
								->where('panggil', 0)
								->where('tanggal',date('Y-m-d'))
								->orderBy('id', 'asc')->get();
    return view('antrian::playlist', compact('antrian'))->with(['start'=>0, 'no'=>0]);
  }


	// APOTEK - FARMASI
	public function antrianFarmasi()
  {
    if(strtolower(Auth::user()->role()->first()->name)=='administrator' || strtolower(Auth::user()->role()->first()->name)=='apotik' )
        {
          $antrian = Registrasi::join('antrian_apoteks','registrasis.antrian_apotek_id','=','antrian_apoteks.id')
                      // ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
                        ->whereNotIn('registrasis.posisi_pasien',['selesai'])
                        
                        ->orderBy('registrasis.posisi_pasien', 'asc')
                        ->select('registrasis.*','registrasis.id as registrasi_id','antrian_apoteks.*','antrian_apoteks.kelompok')
                        ->get();
                        $antrian1 = Registrasi::join('antrian_apoteks','registrasis.antrian_apotek_id','=','antrian_apoteks.id')
                        ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
                        ->whereNotIn('registrasis.posisi_pasien',['selesai'])
                        ->orderBy('registrasis.posisi_pasien', 'asc')
                        ->select('registrasis.*','registrasis.id as registrasi_id','antrian_apoteks.*','antrian_apoteks.kelompok')
                        
                        ->get();              
          return view('antrian::antrian-farmasi', compact('antrian','antrian1'))->with('no',1);
        
        }else{
            return redirect('/dashboard');
        }
    }
	
	public function touchApotek()
  {
    return view('antrian::touch-apotek');
  }
	
	public function layarlcdApotek()
  {
    return view('antrian::layarlcd-apotek');
  }

	public function suaraApotek()
  {
    $antrian 	=	AntrianApotek::whereIn('status', [1, 2, 3])
								->where('panggil', 0)
								->where('tanggal',date('Y-m-d'))
								->orderBy('id', 'asc')->get();
    return view('antrian::playlist-apotek', compact('antrian'))->with(['start'=>1, 'no'=>3]);
  }
	
	public function layarantrianApotek()
  {
    return view('antrian::layarantrian-apotek');
  }
	
	public function datalayarlcdApotek($loket=0)
  {
    $antrian = AntrianApotek::whereIn('status', [1, 2, 3])
                      ->where('loket', $loket)
                      ->where('tanggal',date('Y-m-d'))
                      ->orderBy('id', 'desc')->first();
    return view('antrian::datalayarlcd', compact('antrian'));
  }

	public function savetouchApotek(Request $request)
  {
    $count = AntrianApotek::where('tanggal', '=', date('Y-m-d'))->count();
    $nomor = $count + 1;
    $suara = $nomor.'.mp3';

    $data['nomor'] = $nomor;
    $data['suara'] = $suara;
    $data['status'] = '0';
    $data['panggil'] = 0;
    $data['tanggal'] = date('Y-m-d');
    $data['kelompok'] = '';
    $juml_terpanggil = AntrianApotek::where('status', '!=', '0')->where('tanggal', date('Y-m-d'))->count();
    $data['sisa'] = $nomor - $juml_terpanggil;
    $data['time'] = date('d-m-Y H:i:s');
    if(AntrianApotek::create($data)){
			return response()->json(['status' => true, 'message' => $data]);
		}else{
			return response()->json(['status' => false, 'message' => 'Terjadi kesalahan, silahkan coba lagi!']);
		}
  }
	
	public function daftarpanggilApotek($loket=0)
  {
		$antrian 	=	AntrianApotek::where('tanggal', '=', date('Y-m-d'))
								->where('status', '=', '0')
								->take(1)
								->get();
    return view('antrian::daftarpanggil-apotek', compact('antrian'))->with('loket',$loket);
  }

  public function daftarantrianApotek($loket=0)
  {
		session(['antrian_apotek'=>$loket]);
    $terpanggil = AntrianApotek::where('tanggal', '=', date('Y-m-d'))
                          ->where('status', '<>', '0')
                          ->where('loket', $loket)
                          ->orderBy('id', 'desc')
                          ->get();
    return view('antrian::daftarantrian-apotek', compact('terpanggil'))->with('loket',$loket);
  }

  public function panggilApotek(Request $request)
  {
    $atr = AntrianApotek::where('registrasi_id',$request['id'])->first();
		if($atr==null){
			return response()->json(['status' => false, 'message' => 'Silahkan muat ulang']);
		}else{
			$atr->panggil = 1;
			$atr->save();
			$datax['nomor'] = $atr->nomor;
			$datax['suara'] = $atr->suara;
			$datax['kelompok'] = $atr->kelompok;
			return response()->json(['status' => true, 'data' => $datax]);
		}
  }

  public function panggilkembaliApotek(Request $request)
  {
    $d = AntrianApotek::find($request['id']);
    $d->status = $d->status + 1;
    $d->panggil = 0;
    $d->update();
    return response()->json(['status' => true, 'message' => 'Sukses']);
  }

}
