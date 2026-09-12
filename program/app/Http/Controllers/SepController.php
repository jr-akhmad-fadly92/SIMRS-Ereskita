<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Poli\Entities\Poli;
use Modules\Icd10\Entities\Icd10;
use Modules\Registrasi\Entities\Dokter;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Province;
use Modules\Pegawai\Entities\Pegawai;
use App\Rawatinap;
use App\Inacbg;
use Yajra\DataTables\DataTables;
use MercurySeries\Flashy\Flashy;
use PDF;
use Auth;
use DB;

class SepController extends Controller
{
	public function index(){
		$data['poli'] 		= Poli::select('nama', 'bpjs')->get();
		$data['dokter'] 	= Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		/* if(!session('reg_id') AND strtolower(Auth::user()->role()->first()->name)=='costing'){
			return redirect('/home');
		} */
		
		$data['reg'] = Registrasi::find(session('reg_id'));
		if($data['reg']==null){
			return redirect('/home');
		}
		$data['asal_rujukan']		= 0;
		$data['diagnosa_kode']	= null;
		$data['diagnosa_nama']	= null;
		$data['kode_poli']			= null;
		$data['no_rujukan']			= null;
		$data['provinsi']				= null;
		$data['dokter_dpjp']		= null;
		$data['cob']						= 0;
		return view('sep.form_create', $data);
	}

	function HashBPJS(){
		$ID = config('app.sep_id');
		$t=time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');

		// Computes the timestamp
		date_default_timezone_set('UTC');
		$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
		// Computes the signature by hashing the salt with the secret key as the key
		$signature = hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true);

		// base64 encode…
		$encodedSignature = base64_encode($signature);
		return array($ID, $t, $encodedSignature);
	}

	function xrequest($url, $signature, $ID, $t){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

		$headers = array();
		$headers[] = "Accept: application/json";
		$headers[] = "Content-Type: application/json";
		$headers[] = "X-Cons-Id:".$ID;
		$headers[] = "X-Timestamp:".$t;
		$headers[] = "X-Signature:".$signature;
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HTTPGET, 1);

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			$message = 'Error:' . curl_error($ch);
		}
		curl_close ($ch);
		return $response;
	}
	
	/* 
	public function cari_nojkn(Request $request){
		request()->validate(['no_kartu'=>'required']);
		list($ID, $t, $signature) = $this->HashBPJS();

		$completeurl = config('app.bpjs_url')."/peserta/nokartu/".$request['no_kartu']."/tglSEP/".date('Y-m-d');

		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		if(!$response){
			echo "<font size='3' color='red'>Server BPJS tidak memberikan respon</font>";
			
			$jenis = null;
			$hak_kelas = null;
			$keterangan = null;
			$nama = null;
			$nik = null;
			$tgl_cetak = null;
			$no_kartu = null;
			$no_rm = null;
			$nama_kelas = null;
			$kelamin = null;
			$kd_ppk = null;
			$nama_ppk = null;
		}else{
			$hasil = json_decode($response);
			if ($hasil->metaData->message == 'OK') {
			$jenis = $hasil->response->peserta->jenisPeserta->keterangan;
			$hak_kelas = $hasil->response->peserta->hakKelas->kode;
			$keterangan = $hasil->response->peserta->statusPeserta->keterangan;
			$nama = $hasil->response->peserta->nama;
			$nik = $hasil->response->peserta->nik;
			$tgl_cetak = $hasil->response->peserta->tglCetakKartu;
			$no_kartu = $hasil->response->peserta->noKartu;
			$no_rm = $hasil->response->peserta->mr->noMR;
			$nama_kelas = $hasil->response->peserta->hakKelas->keterangan;
			$kelamin = $hasil->response->peserta->sex;
			$kd_ppk = $hasil->response->peserta->provUmum->kdProvider;
			$nama_ppk = $hasil->response->peserta->provUmum->nmProvider;
			}
		}

		$poli = Poli::pluck('nama', 'bpjs');
		$dokter = Pegawai::where('kategori_pegawai',1)->pluck('nama', 'id');
		$reg = Registrasi::find(session('reg_id'));
		return view('sep.form_create', compact('nama', 'keterangan','poli', 'dokter', 'no_rm', 'nama_kelas', 'kelamin', 'kd_ppk', 'nama_ppk', 'jenis', 'hak_kelas', 'nik', 'tgl_cetak', 'no_kartu', 'reg'));
	}

	public function cari_nojknIRNA($no_kartu,$registrasi_id){
		list($ID, $t, $signature) = $this->HashBPJS();
		//$completeurl = config('app.bpjs_url')."/peserta/nokartu/".$no_kartu."/tglSEP/".date('Y-m-d');
		$completeurl = config('app.bpjs_url')."/rujukan/list/peserta/".$no_kartu;
		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		if(!$response){
			return response()->json(['error'=>'Server BPJS tidak memberikan respon']);
		}else{
			$hasil = json_decode($response);
			if($hasil==null){
				$completeurl = config('app.bpjs_url')."/rujukan/rs/list/peserta/".$no_kartu;
				$response = $this->xrequest($completeurl, $signature, $ID, $t);
				if(!$response){
					echo "<font size='3' color='red'>Server BPJS tidak memberikan respon</font>";
				}else{
					$hasil = json_decode($response);
				}
			}
			if($hasil!=null){
				if ($hasil->metaData->message == 'OK'){
					$data['jenis'] = $hasil->response->rujukan->peserta->jenisPeserta->keterangan;
					$data['hak_kelas'] = $hasil->response->rujukan->peserta->hakKelas->kode;
					$data['keterangan'] = $hasil->response->rujukan->peserta->statusPeserta->keterangan;
					$data['nama'] = $hasil->response->rujukan->peserta->nama;
					$data['nik'] = $hasil->response->rujukan->peserta->nik;
					$data['tgl_cetak'] = $hasil->response->rujukan->peserta->tglCetakKartu;
					$data['no_kartu'] = $hasil->response->rujukan->peserta->noKartu;
					$data['no_rm'] = $hasil->response->rujukan->peserta->mr->noMR;
					$data['nama_kelas'] = $hasil->response->rujukan->peserta->hakKelas->keterangan;
					$data['kelamin'] = $hasil->response->rujukan->peserta->sex;
					$data['kd_ppk'] = $hasil->response->rujukan->peserta->provUmum->kdProvider;
					$data['nama_ppk'] = $hasil->response->rujukan->peserta->provUmum->nmProvider;
					$data['tgl_rujukan'] = $hasil->response->rujukan->tglKunjungan;
					//var_dump($hasil->response); exit;
					
					$reg  = Registrasi::find($registrasi_id);
					$status_reg = 0;
					if(substr($reg->status_reg, 0, 1) == 'G'){
						$status_reg = 0;
					}elseif(substr($reg->status_reg, 0, 1) == 'J'){
						$status_reg = 2;
					}elseif(substr($reg->status_reg, 0, 1) == 'I'){
						$status_reg = 1;
					}
					$poli = Poli::where('id',$reg->poli_bpjs)->where('politype',substr($reg->status_reg, 0, 1))->first();
					$poli_spesialis = 0;
					if($poli!=null){
						$poli_spesialis = $poli->bpjs;
					}
					$completeurl_dpjp = config('app.bpjs_url')."/referensi/dokter/pelayanan/".$status_reg."/tglPelayanan/".$data['tgl_rujukan']."/Spesialis/".$poli_spesialis;
					$response_dpjp = $this->xrequest($completeurl_dpjp, $signature, $ID, $t);
					$encode_dpjp = json_decode($response_dpjp);
					$data['dokter_dpjp'] = null;
					if($encode_dpjp!=null){
						if($encode_dpjp->metaData->code!="201"){
							$data['dokter_dpjp'] = $encode_dpjp->response->list;
						}
					}
					
					$completeurl = config('app.bpjs_url')."/referensi/propinsi";
					$response_provinsi = $this->xrequest($completeurl, $signature, $ID, $t);
					$encode_provinsi = json_decode($response_provinsi);
					$data['provinsi'] = $encode_provinsi->response->list;
					return response()->json($data);
				}else{
					return response()->json(['sukses'=>false]);
				}
			}else{				
				return response()->json(['sukses'=>false]);
			}
		}
	}
	 */
	
	public function cariPeserta(Request $request){
		request()->validate(['nomor'=>'required']);
		list($ID, $t, $signature) = $this->HashBPJS();
		
		$dokter_dpjp 	= null;
		$kode_poli = 'NULL';
		$asal_rujukan = 2;
		$no_rujukan = 0;
		$tgl_rujukan = date('d-m-Y');
		$diagnosa_kode = null;
		$diagnosa_nama = null;
		$no_rm = null;
		$nama_kelas = null;
		$cob = 0;
		$kelamin = null;
		$kd_ppk = null;
		$nama_ppk = null;
		$jenis = null;
		$hak_kelas = null;
		$keterangan = null;
		$nama = null;
		$nik = null;
		$tgl_cetak = null;
		$no_kartu = null;
		$status_pelayanan = 0;
		if (substr($request['status_reg'], 0, 1) == 'G') {
			$status_pelayanan = 1;
		} elseif (substr($request['status_reg'], 0, 1) == 'J') {
			$status_pelayanan = 2;
		} elseif (substr($request['status_reg'], 0, 1) == 'I') {
			$status_pelayanan = 1;
		}
		$isNomor = "Rujukan";
		$completeurl = config('app.bpjs_url')."/rujukan/".$request['nomor'];
		if(isset($request['nomor'])){
			$response = $this->xrequest($completeurl, $signature, $ID, $t);
			if(!$response){
				echo "<font size='3' color='red'>Server BPJS tidak memberikan respon</font>";
			}else{
				$hasil = json_decode($response);
				if($hasil!=null){
					if($hasil->response==null){
						$completeurl = config('app.bpjs_url')."/rujukan/RS/".$request['nomor'];
						$response = $this->xrequest($completeurl, $signature, $ID, $t);
						if(!$response){
							echo "<font size='3' color='red'>Server BPJS tidak memberikan respon</font>";
						}else{
							$hasil = json_decode($response);
							if($hasil->response==null){
								$completeurl = config('app.bpjs_url')."/peserta/nokartu/".$request['nomor']."/tglSEP/".date('Y-m-d');
								$response = $this->xrequest($completeurl, $signature, $ID, $t);
								if(!$response){
									echo "<font size='3' color='red'>Server BPJS tidak memberikan respon</font>";
								}else{
									$isNomor = "Kartu BPJS";
									$hasil = json_decode($response);
								}
							}
						}
					}
				}
				//var_dump($hasil); exit;
				if($hasil!=null){
					if($hasil->response!=null){
						if($hasil->metaData->message == 'OK'){
							$poli = Poli::where('id',$request['poli_bpjs'])->where('politype',substr($request['status_reg'], 0, 1))->first();
							$poli_spesialis = 0;
							if($poli!=null){
								$poli_spesialis = $poli->bpjs;
							}
							
							if($isNomor=="Rujukan"){
								$jenis = $hasil->response->rujukan->peserta->jenisPeserta->keterangan;
								$hak_kelas = $hasil->response->rujukan->peserta->hakKelas->kode;
								if($hasil->response->rujukan->peserta->cob->noAsuransi==null){
									$cob = 0;
								}else{
									$cob = 1;
								}
								$keterangan = $hasil->response->rujukan->peserta->statusPeserta->keterangan;
								$nama = $hasil->response->rujukan->peserta->nama;
								$nik = $hasil->response->rujukan->peserta->nik;
								$tgl_cetak = $hasil->response->rujukan->peserta->tglCetakKartu;
								$no_kartu = $hasil->response->rujukan->peserta->noKartu;
								$no_rm = $hasil->response->rujukan->peserta->mr->noMR;
								$nama_kelas = $hasil->response->rujukan->peserta->hakKelas->keterangan;
								$kelamin = $hasil->response->rujukan->peserta->sex;
								$kd_ppk = $hasil->response->rujukan->peserta->provUmum->kdProvider;
								$nama_ppk = $hasil->response->rujukan->peserta->provUmum->nmProvider;
								$asal_rujukan = $hasil->response->asalFaskes;
								$tgl_rujukan = $hasil->response->rujukan->tglKunjungan;
								$diagnosa_kode = $hasil->response->rujukan->diagnosa->kode;
								$diagnosa_nama = $hasil->response->rujukan->diagnosa->nama;
								$kode_poli = $hasil->response->rujukan->poliRujukan->kode;
								$no_rujukan = $hasil->response->rujukan->noKunjungan;
							}else{
								$jenis = $hasil->response->peserta->jenisPeserta->keterangan;
								$hak_kelas = $hasil->response->peserta->hakKelas->kode;
								if($hasil->response->peserta->cob->noAsuransi==null){
									$cob = 0;
								}else{
									$cob = 1;
								}
								$keterangan = $hasil->response->peserta->statusPeserta->keterangan;
								$nama = $hasil->response->peserta->nama;
								$nik = $hasil->response->peserta->nik;
								$tgl_cetak = $hasil->response->peserta->tglCetakKartu;
								$no_kartu = $hasil->response->peserta->noKartu;
								$no_rm = $hasil->response->peserta->mr->noMR;
								$nama_kelas = $hasil->response->peserta->hakKelas->keterangan;
								$kelamin = $hasil->response->peserta->sex;
								$kd_ppk = ''; //$hasil->response->peserta->provUmum->kdProvider;
								$nama_ppk = ''; //$hasil->response->peserta->provUmum->nmProvider;
								//rujukan
								$asal_rujukan = '2';
								$tgl_rujukan = date('d-m-Y');
								$no_rujukan = config('app.sep_ppkLayanan'); //'NULL';
								//end rujukan
								$diagnosa_kode = null;
								$diagnosa_nama = null;
								$kode_poli = $poli_spesialis;
							}
							
							/* var_dump($no_rujukan);
							exit; */
							$completeurl_dpjp = config('app.bpjs_url')."/referensi/dokter/pelayanan/".$status_pelayanan."/tglPelayanan/".date('Y-m-d')."/Spesialis/".$kode_poli;
							$response_dpjp = $this->xrequest($completeurl_dpjp, $signature, $ID, $t);
							$encode_dpjp = json_decode($response_dpjp);
							$dokter_dpjp = null;
							if($encode_dpjp!=null){
								if($encode_dpjp->metaData->code!="201"){
									$dokter_dpjp = $encode_dpjp->response->list;
								}
							}
							//var_dump($dokter_dpjp); exit;
							Flashy::success('Berhasil mengambil data '.$isNomor);
						}else{
							Flashy::warning('No. '.$isNomor.' tidak ditemukan');
						}
					}else{
						Flashy::warning($hasil->metaData->message);
					}
				}else{				
					Flashy::warning('No. '.$isNomor.' tidak ditemukan');
				}
			}
		}else{
			if(isset($request['jsonx'])){
				return ['status'=>false,'message'=>'Nomor JKN harap diisi']; exit;
			}else{
				return redirect('registrasi/v-claim/form-sep');
			}
		}		
		
		$completeurl = config('app.bpjs_url')."/referensi/propinsi";
		$response_provinsi = $this->xrequest($completeurl, $signature, $ID, $t);
		$encode_provinsi = json_decode($response_provinsi);
		$provinsi = $encode_provinsi->response->list;

		$poli 		= Poli::select('nama', 'bpjs')->get();
		if(session('reg_id')){
			$reg 			= Registrasi::find(session('reg_id'));
		}else{
			if(isset($request['jsonx'])){
				return ['status'=>false,'message'=>'Data tidak ditemukan']; exit;
			}else{
				return redirect('/home');
			}
		}
		
		if(isset($request['jsonx'])){
			$data = [
				'poli'=>$poli,
				'no_rm'=>$no_rm,
				'nama_kelas'=>$nama_kelas,
				'cob'=>$cob,
				'kelamin'=>$kelamin,
				'kd_ppk'=>$kd_ppk,
				'nama_ppk'=>$nama_ppk,
				'jenis'=>$jenis,
				'hak_kelas'=>$hak_kelas,
				'keterangan'=>$keterangan,
				'nama'=>$nama,
				'nik'=>$nik,
				'tgl_cetak'=>$tgl_cetak,
				'no_kartu'=>$no_kartu,
				'reg'=>$reg,
				'tgl_rujukan'=>$tgl_rujukan,
				'provinsi'=>$provinsi,
				'dokter_dpjp'=>$dokter_dpjp,
				'asal_rujukan'=>$asal_rujukan,
				'diagnosa_kode'=>$diagnosa_kode,
				'diagnosa_nama'=>$diagnosa_nama,
				'kode_poli'=>$kode_poli,
				'no_rujukan'=>$no_rujukan
			];
			return ['status'=>true,'data'=>$data]; exit;
		}else{
			return view('sep.form_create', compact('poli', 'no_rm', 'nama_kelas', 'cob', 'kelamin', 'kd_ppk', 'nama_ppk', 'jenis', 'hak_kelas', 'keterangan', 'nama', 'nik', 'tgl_cetak', 'no_kartu', 'reg', 'tgl_rujukan', 'provinsi', 'dokter_dpjp', 'asal_rujukan', 'diagnosa_kode', 'diagnosa_nama', 'kode_poli', 'no_rujukan'));
		}
	}
	
	public function getKota($kode=''){
		list($ID, $t, $signature) = $this->HashBPJS();
		$completeurl = config('app.bpjs_url')."/referensi/kabupaten/propinsi/".$kode;
		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		$encode = json_decode($response);
		echo json_encode($encode->response->list);
	}
	
	public function getKecamatan($kode=''){
		list($ID, $t, $signature) = $this->HashBPJS();
		$completeurl = config('app.bpjs_url')."/referensi/kecamatan/kabupaten/".$kode;
		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		$encode = json_decode($response);
		echo json_encode($encode->response->list);
	}
	
	public function getFaskes(Request $request){
		if ($request->has('q')){
			list($ID, $t, $signature) = $this->HashBPJS();
			$cari = $request->q;
			$completeurl = config('app.bpjs_url')."/referensi/faskes/".$cari."/2";
			$response = $this->xrequest($completeurl, $signature, $ID, $t);
			$encode = json_decode($response);
			echo json_encode($encode->response->faskes);
		}
	}
	
	public function cetakRujukan($no_rujukan){
		if(!empty($no_rujukan)){
			$data['reg'] = Registrasi::where('pasien_no_dirujuk', $no_rujukan)->first();			
			$data['rujukan'] = json_decode($data['reg']->pasien_text_dirujuk);
			//var_dump($data['rujukan']); exit;
			$pdf = PDF::loadView('sep.cetak_rujukan', $data);
			// return $pdf->download('lab.pdf');
			return $pdf->stream();
		} else {
			$data['error'] = 'No. SEP Tidak ada';
		}
	}
	
	public function buatRujukan(Request $req){
		if(isset($req['noSep'])){
			list($ID, $t, $signature) = $this->HashBPJS();
			if($req['method']=="insert"){
				$request = '{
					"request":{
						"t_rujukan":{
							"noSep": "'.$req['noSep'].'",
							"tglRujukan": "'.$req['tglRujukan'].'", 
							"ppkDirujuk": "'.$req['ppkDirujuk'].'",
							"jnsPelayanan": "'.$req['jnsPelayanan'].'",
							"catatan": "'.$req['catatan'].'",
							"diagRujukan": "'.$req['diagRujukan'].'",
							"tipeRujukan": "'.$req['tipeRujukan'].'",
							"poliRujukan": "'.$req['poliRujukan'].'",
							"user": "'.Auth::user()->name.'"
						}
					}
				}';
			}elseif($req['method']=="update"){
				$request = '{
					"request":{
						"t_rujukan":{
							"noRujukan": "'.$req['noRujukan'].'",
							"ppkDirujuk": "'.$req['ppkDirujuk'].'",
							"jnsPelayanan": "'.$req['jnsPelayanan'].'",
							"catatan": "'.$req['catatan'].'",
							"diagRujukan": "'.$req['diagRujukan'].'",
							"tipeRujukan": "'.$req['tipeRujukan'].'",
							"poliRujukan": "'.$req['poliRujukan'].'",
							"user": "'.Auth::user()->name.'"
						}
					}
				}';
			}elseif($req['method']=="delete"){
				$request = '{
					"request":{
						"t_rujukan":{
							"noRujukan": "'.$req['noRujukan'].'",
							"user": "'.Auth::user()->name.'"
						}
					}
				}';
			}
			$completeurl = config('app.bpjs_url')."/rujukan/".$req['method'];
			
			$session = curl_init($completeurl);
			$arrheader =  array(
				'X-cons-id: '.$ID,
				'X-timestamp: '.$t,
				'X-signature: '.$signature,
				'Content-Type: application/x-www-form-urlencoded'
			);
			curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
			if($req['method']=="update"){
				curl_setopt($session, CURLOPT_CUSTOMREQUEST, "PUT");
			}elseif($req['method']=="delete"){
				curl_setopt($session, CURLOPT_CUSTOMREQUEST, "DELETE");
			}
			curl_setopt($session, CURLOPT_POSTFIELDS, $request);
			curl_setopt($session, CURLOPT_POST, TRUE);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($session);
			$datax = json_decode($response, true);
			//var_dump($datax); exit;
			$registrasi = Registrasi::where('no_sep',$req['noSep'])->first();
			if($datax['metaData']['code'] == '200'){
				if($req['method']=="insert"){
					if($registrasi!=null){
						$registrasi->pasien_text_dirujuk = json_encode($datax);
						$registrasi->pasien_no_dirujuk = $datax['response']['rujukan']['noRujukan'];
						$registrasi->pasien_tipe_dirujuk = $req['tipeRujukan'];
						$registrasi->kondisi_akhir_pasien = 2;
						$registrasi->update();
					}
					return response()->json(['status' => true, 'no_rujukan' => $datax['response']['rujukan']['noRujukan']]);
				}elseif($req['method']=="delete"){
					if($registrasi!=null){
						$registrasi->pasien_text_dirujuk = null;
						$registrasi->pasien_no_dirujuk = null;
						$registrasi->pasien_tipe_dirujuk = null;
						$registrasi->kondisi_akhir_pasien = null;
						$registrasi->update();
					}
					return response()->json(['status' => true, 'message' => 'Rujukan berhasil dihapus']);
				}else{
					return response()->json(['status' => true, 'message' => 'Rujukan berhasil diupdate']);
				}
			} else {
				return response()->json(['status' => false, 'message' => $datax['metaData']['message']]);
			}
		}else{
			$registrasi = Registrasi::where('reg_id',$req['regId'])->first();
			if($req['method']=="insert"){
				if($registrasi!=null){
					$request = '{
						"request":{
							"t_rujukan":{
								"noSep": "'.$req['noSep'].'",
								"tglRujukan": "'.$req['tglRujukan'].'", 
								"ppkDirujuk": "'.$req['ppkDirujuk'].'",
								"jnsPelayanan": "'.$req['jnsPelayanan'].'",
								"catatan": "'.$req['catatan'].'",
								"diagRujukan": "'.$req['diagRujukan'].'",
								"diagRujukanText": "'.$req['diagRujukanText'].'",
								"tipeRujukan": "'.$req['tipeRujukan'].'",
								"poliRujukan": "'.$req['poliRujukan'].'",
								"user": "'.Auth::user()->name.'"
							}
						}
					}';
					$registrasi->pasien_text_dirujuk = $request;
					$registrasi->pasien_no_dirujuk = $req['regId'];
					$registrasi->pasien_tipe_dirujuk = $req['tipeRujukan'];
					$registrasi->kondisi_akhir_pasien = 2;
					$registrasi->update();
				}
				return response()->json(['status' => true, 'no_rujukan' => $req['regId']]);
			}elseif($req['method']=="delete"){
				if($registrasi!=null){
					$registrasi->pasien_text_dirujuk = null;
					$registrasi->pasien_no_dirujuk = null;
					$registrasi->pasien_tipe_dirujuk = null;
					$registrasi->kondisi_akhir_pasien = null;
					$registrasi->update();
				}
				return response()->json(['status' => true, 'message' => 'Rujukan berhasil dihapus']);
			}
		}
	}

	public function cari_nik($nik=''){
		list($ID, $t, $signature) = $this->HashBPJS();
		$completeurl = "";
		if($nik){
			$completeurl = config('app.bpjs_url')."/Wslokalrest/Peserta/Peserta/nik/nomorindukkependudukan" .$nik;
		}
		// Peserta/Peserta/nik/nomerindukkependudukan

		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		if(!$response){
			echo "<font size='3' color='red'>Server BPJS tidak memberikan respon</font>";
		}else{
			$hasil = json_decode($response);
			$data = json_encode($hasil);
		}
	  echo $data;
	}

	public function buat_sep(Request $request){		
		list($ID, $t, $signature) = $this->HashBPJS();

		$noKartu          = $request['no_bpjs']; 
		$notelp           = $request["no_tlp"];
		$skr              = date("Y-m-d");
		$TglRujuk					= $request['tgl_rujukan'];
		$noRujuk          = $request['no_rujukan'];
		$asalRujukan      = $request["asalRujukan"]; //1: Puskesmas/FKTP   2: RS
		$ppkRujuk         = $request['ppk_rujukan']; // kode asal rujukan
		$ppkLayanan				= config('app.sep_ppkLayanan'); // kode RS penerima
		if($request["jenis_layanan"]==1){
			$TglRujuk       = $skr; //tgl rujukan
			$ppkRujuk       = config('app.sep_ppkLayanan'); //'11011203'; // kode asal rujukan
		}
		$jnsLayanan       = $request["jenis_layanan"];  //jenis layanan 1 RANAP 2 RAJAL
		$catatan          = $request["catatan_bpjs"]; // nama dokter pengirim
		$ArrayregdiagAwal = $request["diagnosa_awal"]; //"S728";//explode(".", "S72.8");
		$regdiagAwal      = $request["diagnosa_awal"];//implode($ArrayregdiagAwal); // Diagnosa Awal [ICD X]
		$ArrayPoliTujuan  = explode("-",$request["poli_bpjs"]);
		$poliTujuan       = $request['poli_bpjs'];//$ArrayPoliTujuan[1]; // poli tujuan
		$kodeKelas        = $request["hak_kelas"]; // kelas perawatan 01, 02, 03
		$noSurat        	= $request["no_surat_kontrol"];
		$kodeDpjp        	= $request["kode_dpjp"];
		$userBPJS         = Auth::user()->name; //"RS"; // nama user di BPJS
		$noMR             = $request["no_rm"]; //"28000000";
		
		// NEW VERSI 1.1
		$cob       		  = $request["cob"]; // kode cob 1 (ya); 2 (tidak)
		$katarak   		  = $request["katarak"]; // kode katarak 1 (ya); 2 (tidak)
		$lakaLantas     = $request["laka_lantas"]; // kode laka lantas 1 (laka lantas); 2 (tdk laka lantas)
		$penjamin 			= $request["penjamin"];
		$tglKejadian		= '';
		if($request["tgl_kejadian"]!=''){
			$tglKejadian 	= date_format(date_create($request["tgl_kejadian"]), 'Y-m-d');
		}
		$keterangan			= $request["keterangan_laka"];
		$suplesi				= $request["suplesi"];
		$noSepSuplesi		= $request["no_suplesi"];
		$kdPropinsi			= $request["bpjs_province_id"];
		$kdKabupaten		= $request["bpjs_regency_id"];
		$kdKecamatan		= $request["bpjs_district_id"];
		// END
				
		$tipe_layanan = 0;
		if($request["tipe_layanan"]==2){
			$tipe_layanan = 1;
		}
		$request = '{
			"request":{
				"t_sep":{
					"noKartu": "'.$noKartu.'",
					"tglSep": "'.$skr.'",
					"ppkPelayanan": "'.$ppkLayanan.'",
					"jnsPelayanan": "'.$jnsLayanan.'",
					"klsRawat": "'.$kodeKelas.'",
					"noMR": "'.$noMR.'",
					"rujukan":{
						"asalRujukan": "'.$asalRujukan.'",
						"tglRujukan": "'.$TglRujuk.'",
						"noRujukan": "'.$noRujuk.'",
						"ppkRujukan": "'.$ppkRujuk.'"
					},
					"catatan": "'.$noMR.'",
					"diagAwal": "'.$regdiagAwal.'",
					"poli":{
						"tujuan": "'.$poliTujuan.'",
						"eksekutif": "'.$tipe_layanan.'"
					},
					"cob":{
						"cob": "'.$cob.'"
					},
					"katarak":{
						"katarak": "'.$katarak.'"
					},
					"jaminan":{
						"lakaLantas": "'.$lakaLantas.'",
						"penjamin":{
							"penjamin": "'.$penjamin.'",
							"tglKejadian": "'.$tglKejadian.'",
							"keterangan": "'.$keterangan.'",
							"suplesi": {
								"suplesi": "'.$suplesi.'",
								"noSepSuplesi": "'.$noSepSuplesi.'",
								"lokasiLaka": {
									"kdPropinsi": "'.$kdPropinsi.'",
									"kdKabupaten": "'.$kdKabupaten.'",
									"kdKecamatan": "'.$kdKecamatan.'"
								}
							}
						}
					},
					"skdp": {
						"noSurat": "'.$noSurat.'",
						"kodeDPJP": "'.$kodeDpjp.'"
					},
					"noTelp": "'.$notelp.'",
					"user": "'.$userBPJS.'"
				}
			}
		}';
		//var_dump($request); exit;
		$completeurl = config('app.bpjs_url')."/SEP/1.1/insert";
		
		$session = curl_init($completeurl);
		$arrheader =  array(
			'X-cons-id: '.$ID,
			'X-timestamp: '.$t,
			'X-signature: '.$signature,
			'Content-Type: application/x-www-form-urlencoded'
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_POSTFIELDS, $request);
		curl_setopt($session, CURLOPT_POST, TRUE);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($session);
		$sml = json_decode($response, true);
		$json = json_encode($sml);

		if($sml['metaData']['message'] == 'Sukses'){
			return response()->json(['sukses' => $sml['response']['sep']['noSep']]);
		} else {
			return response()->json(['msg' => $sml['metaData']['message']]);
		}
	}
	
	public function dataLpk($regid){
		$reg 				= Registrasi::find($regid);
		$rawatinap	= Rawatinap::where('registrasi_id',$regid)->first();
		$data['polikontrol']	 = Poli::select('bpjs','nama')->whereNotIn('bpjs',['-'])->get();
		$data['poli'] = $reg->poli->bpjs;
		$data['kelas'] = $reg->kelas->nama;
		$data['kamar'] = $rawatinap->kamar->nama;
		$data['ruangrawat'] = null;
		$data['kelasrawat'] = null;
		$data['spesialistik'] = null;
		$data['pascapulang'] = null;
		
		list($ID, $t, $signature) = $this->HashBPJS();
		
		$completeurl = config('app.bpjs_url')."/referensi/ruangrawat";
		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		if(!$response){
			$data['error'] = 'Server BPJS tidak memberikan respon';
		}else{
			$ruangrawat = json_decode($response);
			if($ruangrawat->response!=null){
				$data['ruangrawat'] = $ruangrawat->response->list;
			}
		}
		
		$completeurl = config('app.bpjs_url')."/referensi/kelasrawat";
		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		if(!$response){
			$data['error'] = 'Server BPJS tidak memberikan respon';
		}else{
			$kelasrawat = json_decode($response);
			if($kelasrawat->response!=null){
				$data['kelasrawat'] = $kelasrawat->response->list;
			}
		}
		
		$completeurl = config('app.bpjs_url')."/referensi/spesialistik";
		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		if(!$response){
			$data['error'] = 'Server BPJS tidak memberikan respon';
		}else{
			$spesialistik = json_decode($response);
			if($spesialistik->response!=null){
				$data['spesialistik'] = $spesialistik->response->list;
			}
		}
		
		$completeurl = config('app.bpjs_url')."/referensi/pascapulang";
		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		if(!$response){
			$data['error'] = 'Server BPJS tidak memberikan respon';
		}else{
			$pascapulang = json_decode($response);
			if($pascapulang->response!=null){
				$data['pascapulang'] = $pascapulang->response->list;
			}
		}
		
		return response()->json(['status' => true, 'lpk' => $data]);
	}
	
	public function kirimLpk(Request $request, $no_sep){
		list($ID, $t, $signature) = $this->HashBPJS();
		$reg 		= Registrasi::where('no_sep',$no_sep)->first();
		$inacbg = Inacbg::where('no_sep',$no_sep)->first();
		if($reg==null){
			return response()->json(['status' => false, 'message' => 'Pasien tidak ditemukan']);
			exit;
		}
		$explode_diagnosa = explode("#",$inacbg->icd1);
		$explode_prosedur = explode("#",$inacbg->prosedur1);
		$diagnosa = null;
		$prosedur = null;
		for($i=0; $i<count($explode_diagnosa);$i++){
			$diagnosa[$i]['kode'] = $explode_diagnosa[$i];
			if($i==0){
				$diagnosa[$i]['level'] = 1;
			}else{
				$diagnosa[$i]['level'] = 2;
			}
		}
		for($i=0; $i<count($explode_prosedur);$i++){
			$prosedur[]['kode'] = $explode_prosedur[$i];
		}
		
		$tanggal_kontrol = '';
		if(isset($request['tanggalkontrol'])){
			$tanggal_kontrol = $request['tanggalkontrol'];
		}
		$poli_kontrol = '';
		if(isset($request['polikontrol'])){
			$poli_kontrol = $request['polikontrol'];
		}
		// date_format(date_create($reg->cretaed_at), 'Y-m-d') date_format(date_create($reg->tgl_pulang), 'Y-m-d')
		$request = '{
			"request": {
				"t_lpk": {
					 "noSep": "'.$no_sep.'",
					 "tglMasuk": "2019-07-11",
					 "tglKeluar": "2019-07-11",
					 "jaminan": "1",
					 "poli": {
							"poli": "'.$reg->poli->bpjs.'"
					 },
					 "perawatan": {
							"ruangRawat": "'.$request['ruangrawat'].'",
							"kelasRawat": "'.$request['kelasrawat'].'",
							"spesialistik": "'.$request['spesialistik'].'",
							"caraKeluar": "'.$reg->kondisi_akhir_pasien.'",
							"kondisiPulang": "'.$request['pascapulang'].'"
					 },
					 "diagnosa": '.json_encode($diagnosa,TRUE).',
					 "procedure": '.json_encode($prosedur,TRUE).',
					 "rencanaTL": {
							"tindakLanjut": "'.$request['tindaklanjut'].'",
							"dirujukKe": {
								 "kodePPK": "'.$reg->ppk_rujukan.'"
							},
							"kontrolKembali": {
								 "tglKontrol": "'.$tanggal_kontrol.'",
								 "poli": "'.$poli_kontrol.'"
							}
					 },
					 "DPJP": "'.$reg->pegawai->kode.'",
					 "user": "'.Auth::user()->name.'"
				}
		 }
		}';
		//var_dump($request); exit;
		$completeurl = config('app.bpjs_url')."/LPK/insert";
		
		$session = curl_init($completeurl);
		$arrheader =  array(
			'X-cons-id: '.$ID,
			'X-timestamp: '.$t,
			'X-signature: '.$signature,
			'Content-Type: application/x-www-form-urlencoded'
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_POSTFIELDS, $request);
		curl_setopt($session, CURLOPT_POST, TRUE);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($session);
		$sml = json_decode($response, true);
		$json = json_encode($sml);

		if($sml['metaData']['code'] == '200'){
			$r = Inacbg::where('no_sep', $no_sep)->first();
			$r->kirim_lpk = 'Y';	
			$r->update();
			
			return response()->json(['status' => true, 'message' => 'Berhasil mengirim lembar pengajuan klaim']);
		} else {
			return response()->json(['status' => false, 'message' => $sml['metaData']['message']]);
		}
	}

	public function updateTglPulang($noSep, $tglPulang){
		/* $ID = config('app.sep_id');
		date_default_timezone_set('UTC');
		$t=time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
		$request = '{
			"request": {    
				"t_sep": {
					"noSep":"'.$noSep.'",
					"tglPulang":"'.$tglPulang.'",
					"user":"'.Auth::user()->name.'"
				}
			}
		}';
				
		$completeurl = config('app.bpjs_url')."/Sep/updtglplg";

		$session = curl_init($completeurl);
		$arrheader =  array(
			'X-cons-id: '.$ID,
			'X-timestamp: '.$t,
			'X-signature: '.$signature,
			'Content-Type: application/x-www-form-urlencoded'
			);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($session, CURLOPT_POSTFIELDS, $request);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($session);
		$sml = json_decode($response, true);
		$json = json_encode($sml);
		return $json; */
	}

	public function simpan_sep(Request $request){
		if(Auth::user()->hasRole(['supervisor','supervisor-costing','costing','administrator'])){
			$reg = Registrasi::find($request['registrasi_id']);
		}else{
			$reg = Registrasi::find(session('reg_id'));
		}
		$reg->no_sep = $request['no_sep'];
		$reg->tipe_jkn = $request['jkn'];
		$reg->tgl_rujukan = $request['tgl_rujukan'];
		$reg->no_rujukan = $request['no_rujukan'];
		$reg->ppk_rujukan = $request['ppk_rujukan'];
		$reg->diagnosa_awal = $request['diagnosa_awal'];
		$reg->tgl_sep = date('Y-m-d H:i:s');
		$reg->hak_kelas_inap = $request['hak_kelas'];
		$reg->kelas_id = ($request['hak_kelas']+1);
		$reg->catatan = $request['catatan'];;
		$reg->kecelakaan = $request['laka_lantas'];;
		$reg->jkn = '';
		$reg->no_jkn = $request['no_bpjs'];
		$reg->poli_bpjs = $request['poli_bpjs'];
		if($request['kode_dpjp']!=""){
			$dokter = Pegawai::where('kode',$request['kode_dpjp'])->first();
			if($dokter!=null){
				$reg->dokter_id = $dokter->id;
			}
		}
		if($request['poli_bpjs']!=""){
			$poli = Poli::where('bpjs',$request['poli_bpjs'])->first();
			if($poli!=null){
				$reg->poli_id = $poli->id;
			}
		}
		$reg->update();
		session()->forget('reg_id');
		if(!empty($request['no_sep'])){
			Flashy::success('Integrasi SEP sukses, No SEP berhasil disimpan');
		}else{
			Flashy::error('Integrasi SEP gagal, No SEP gagal disimpan');
		}
		if(Auth::user()->hasRole(['supervisor','supervisor-costing','costing','administrator'])){
			return response()->json(['success' => true, 'bayar' => $reg->bayar, 'sep' => $reg->no_sep]);
		}else{
			$regs = Registrasi::where('id',session('id_registrasi'))->first();
			return view('registrasi::bukti_pendaftaran', compact('regs'));
		}
	}

	public function sep_sukses(){
		return view('sep.sukses');
	}

	public function cetak_sep($no_sep=''){
		$data['reg'] = null;
		$data['reg_sep'] = null;
		if(!empty($no_sep) AND $no_sep!='null'){
			$data['reg'] = Registrasi::where('no_sep', $no_sep)->first();
			list($ID, $t, $signature) = $this->HashBPJS();
			$completeurl = config('app.bpjs_url')."/SEP/".$no_sep;
			$response = $this->xrequest($completeurl, $signature, $ID, $t);
			if(!$response){
				$data['error'] = 'Server BPJS tidak memberikan respon';
			}else{
				$hasil = json_decode($response);
				$data['reg_sep'] = $hasil->response;
				//var_dump($data['reg_sep']); exit;
			}
		} else {
			$data['error'] = 'No. SEP Tidak ada';
		}

		$pdf = PDF::loadView('sep.cetak_sep', $data);
		return $pdf->stream();
		// return $pdf->download('lab.pdf');
	}

	public function getIcd10(){
	$data = Icd10::all();
	return DataTables::of($data)
		  ->addColumn('add', function ($data) {
			return ' <a href="#" data-nama="'.$data->nama.'" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat addICD"><i class="fa fa-check"></i></a> ';
		  })
		  ->rawColumns(['add'])
		  ->make(true);
	}
}
