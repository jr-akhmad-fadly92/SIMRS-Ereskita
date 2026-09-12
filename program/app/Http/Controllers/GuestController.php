<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;
use Modules\Antrian\Entities\Antrian;
use Modules\Bed\Entities\Bed;
use Modules\Kelas\Entities\Kelas;
use Modules\Poli\Entities\Poli;
use App\AntrianApotek;
use App\AntrianPoli;
use App\Penjualan;
use App\Penjualandetail;

class GuestController extends Controller
{
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
  }

  public function layarlcd()
  {
    return view('antrian::layarlcd');
  }
	
  public function layarlcdPoli()
  {
    return view('antrian::layarlcd-poli');
  }
	
	public function layarantrianPolia()
  {
    return view('antrian::layarantrian-polia');
  }
	
	public function layarantrianPolib()
  {
    $data['antrian'] 	=	AntrianPoli::where('status_panggil', 0)
												->where('tanggal',date('Y-m-d'))
												->orderBy('id', 'asc')->get();
		//$data['poli'] = Poli::where('politype','J')->get();
    return view('antrian::layarantrian-polib', $data)->with(['start'=>0, 'no'=>0]);
  }
  public function layarantrianPolic()
  {
    $data['antrian'] 	=	AntrianPoli::where('status_panggil', 0)
												->where('tanggal',date('Y-m-d'))
												->orderBy('id', 'asc')->get();
		//$data['poli'] = Poli::where('politype','J')->get();
    return view('antrian::layarantrian-polic', $data)->with(['start'=>0, 'no'=>0]);
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
	
  public function suara()
  {
    $antrian 	=	Antrian::whereIn('status', [1, 2, 3])
								->where('panggil', 0)
								->where('tanggal',date('Y-m-d'))
								->orderBy('id', 'asc')->get();
    return view('antrian::playlist', compact('antrian'))->with(['start'=>0, 'no'=>0]);
  }

	// APOTEK
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
		$antrian	=	AntrianApotek::find(\DB::table('antrian_apoteks')->where('panggil',1)->max('id'));
		if($antrian!=null){
			if($antrian->registrasi->posisi_pasien!='konfirmasi farmasi' AND $antrian->registrasi->posisi_pasien!='selesai' AND $loket==1){
				
			}elseif($antrian->registrasi->posisi_pasien=='konfirmasi farmasi' AND $loket==2){
				
			}else{
				$antrian = null;
			}
		}
    return view('antrian::datalayarlcd', compact('antrian'));
  }

  public function savetouchApotek(Request $request)
  {
		if($request['value']=='bebas'){
			$id = Registrasi::where('reg_id', 'LIKE',date('Ymd').'%')->count();
			$registrasi = new Registrasi();
			$registrasi->pasien_id     = '0';
			$registrasi->status_reg    = 'A1'; //status registrasi apotik
			$registrasi->tracer        = '1';
			$registrasi->cetak_barcode = '1';
			$registrasi->cetak_sep     = '1';
			$registrasi->bayar     		 = '2';
			$registrasi->reg_id        = date('Ymd').sprintf("%04s", ($id + 1));
			$registrasi->posisi_pasien = 'selesai diperiksa';
			$registrasi->penjualan_bebas_apotek = 1;
			$registrasi->save();
			
			$count = Penjualan::where('no_resep', 'LIKE', 'FPB'.date('Ymd').'%')->count() + 1;
			$next_resep = 'FPB'.date('Ymd').'-'.sprintf('%04s', $count);
			$p = new Penjualan();
			$p->no_resep = $next_resep;
			$p->registrasi_id = $registrasi->id;
			if(!empty($registrasi->id)) {
				$p->save();
			}
		}else{
			$registrasi = Registrasi::where('reg_id', $request['value'])->first();
			if($registrasi==null){
				$pasien = Pasien::where('no_rm', $request['value'])->first();
				if($pasien!=null){
					$registrasi = Registrasi::where('pasien_id', $pasien->id)->first();
				}
			}
		}
		if($registrasi!=null){
			if($registrasi->posisi_pasien!='selesai diperiksa'){
				return response()->json(['status' => false, 'message' => 'Mohon maaf, status pasien: '.strtoupper($registrasi->posisi_pasien).', silahkan hubungi petugas!']);
				exit;
			}elseif(substr($registrasi->status_reg,0,1)=='I'){
				return response()->json(['status' => false, 'message' => 'Pasien rawat inap tidak perlu mengambil nomor antrian']);
				exit;
			}
			$get_resep_dtl = null;
			if($request['value']=='bebas'){
				$kelompok = 'F';
			}else{
				$kelompok = 'A';
				$get_resep = Penjualan::where('registrasi_id',$registrasi->id)->first();
				if($get_resep!=null){
					$cek_detail_resep = Penjualandetail::where('penjualan_id',$get_resep->id)->where('hapus',null)->get();
					if(count($cek_detail_resep)>0){
						$get_resep_dtl = Penjualandetail::where('penjualan_id',$get_resep->id)->where('hapus',null)->where('status_racikan',1)->get();
						if(count($get_resep_dtl)>0){
							$kelompok = 'B';
						}
					}else{
						$kelompok = 'E';
					}
				}else{
					$kelompok = 'E';
				}
			}
			
			$count = AntrianApotek::where('tanggal', '=', date('Y-m-d'))->where('kelompok',$kelompok)->count();
			$nomor = $count + 1;
			$suara = $nomor.'.mp3';

			$data['nomor'] = $nomor;
			$data['suara'] = $suara;
			$data['status'] = '0';
			$data['panggil'] = 0;
			$data['tanggal'] = date('Y-m-d');
			$data['kelompok'] = $kelompok;
			$juml_terpanggil = AntrianApotek::where('status', '!=', '0')->where('tanggal', date('Y-m-d'))->where('kelompok',$kelompok)->count();
			$data['sisa'] = $nomor - $juml_terpanggil;
			$data['time'] = date('d-m-Y H:i:s');
			
			$create_antrian = new AntrianApotek;
			$create_antrian->nomor	=	$data['nomor'];
			$create_antrian->suara	=	$data['suara'];
			$create_antrian->status	=	$data['status'];
			$create_antrian->panggil	=	$data['panggil'];
			$create_antrian->tanggal	=	$data['tanggal'];
			$create_antrian->kelompok	=	$data['kelompok'];
			$create_antrian->registrasi_id	=	$registrasi->id;
			if($create_antrian->save()){
				$registrasi->antrian_apotek_id = $create_antrian->id;
				if($kelompok == 'E'){
					$registrasi->posisi_pasien = 'konfirmasi farmasi';
				}else{
					$registrasi->posisi_pasien = 'antrian apotek';
				}
				$registrasi->update();
				return response()->json(['status' => true, 'message' => $data]);
			}else{
				return response()->json(['status' => false, 'message' => 'Terjadi kesalahan, silahkan coba lagi!']);
			}
		}else{
			return response()->json(['status' => false, 'message' => 'Mohon maaf, data tidak ditemukan!']);
		}
  }

	public function display_bed()
	{
			$data['totalbed'] = Bed::count();
			$data['kelas'] = Kelas::where('nama', '<>', '-')->get();
			return view('displaytempattidur.displaybed', $data)->with('no', 1);
	}

}
