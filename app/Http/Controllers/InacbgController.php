<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Registrasi;
use App\Inacbg;
use App\Mastermapping;
use App\Pembayaran;
use DB;
use Validator;
use Modules\Tarif\Entities\Tarif;
use Modules\Registrasi\Entities\Folio;
use MercurySeries\Flashy\Flashy;
use Auth;
use PDF;
use Exception;

class InacbgController extends Controller
{
  public function new_claim(Request $req){
    $cek = Validator::make($req->all(),[
			'no_kartu'=>'required',
			'no_sep'=>'required',
			'diagnosa' => 'required',
			'procedure' => 'nullable'
    ]);

    if ($cek->passes()) {
			$reg = Registrasi::where('id', $req['registrasi_id'])->first();
			$reg->no_sep = $req['no_sep'];
			$reg->no_jkn = $req['no_kartu'];
			$reg->update();

			$in = Inacbg::where('no_sep',$req['no_sep'])->first();
			if($in==null){
				$in = new Inacbg();
			}
			$in->pasien_nama = $reg->pasien->nama;
			$in->pasien_kelamin = $reg->pasien->kelamin;
			$in->pasien_tgllahir = $reg->pasien->tgllahir;
			$in->jenis_pembayaran = $reg->bayar;
			$in->no_kartu = $req['no_kartu'];
			$in->no_sep = $req['no_sep'];
			$in->jenis_pasien = $reg->jenis_pasien;
			$in->kelas_perawatan = $req['kelas_rawat'];
			$in->cara_keluar = $req['discharge_status'];
			$in->dokter = $req['nama_dokter'];
			$in->berat = $req['birth_weight'];
			$in->total_rs = $req['tarif_rs'];
			$in->no_rm = $req['no_rm'];
			$in->icd1 = $req['diagnosa'];
			$in->prosedur1 = $req['procedure'];
			$in->alamat = $reg->pasien->alamat;
			$in->no_hp = $reg->pasien->nohp;
			$in->poli_id = $reg->poli_id;
			$in->registrasi_id = $reg->id;
			$in->dijamin = null;
			$in->kode = null;
			$in->tgl_masuk = $reg->created_at;
			$in->tgl_keluar = $reg->tgl_pulang;
			$in->save();
			
			$this->HapusSemuaProsedur($req['no_sep'], $req['coder_nik']);
			$dataKlaim = $this->UpdateDataKlaim($req['registrasi_id'], $req['no_sep'], $req['no_kartu'], $req['tgl_masuk'],
																				$req['tgl_pulang'], $req['jenis_rawat'], $req['kelas_rawat'],
																				$req['adl_sub_acute'], $req['adl_chronic'], $req['icu_indikator'],
																				$req['icu_los'], $req['ventilator_hour'], $req['upgrade_class_ind'],
																				$req['upgrade_class_class'], $req['upgrade_class_los'], $req['add_payment_pct'],
																				$req['birth_weight'], $req['discharge_status'], $req['diagnosa'],
																				$req['procedure'], $req['tarif_rs'], $req['tarif_poli_eks'],
																				$req['nama_dokter'], $req['kode_tarif'], $req['payor_id'],
																				$req['payor_cd'], $req['cob_cd'], $req['coder_nik'],
																				$req['prosedur_non_bedah'], $req['prosedur_bedah'], $req['konsultasi'],
																				$req['tenaga_ahli'], $req['keperawatan'], $req['penunjang'],
																				$req['radiologi'], $req['laboratorium'], $req['pelayanan_darah'],
																				$req['rehabilitasi'], $req['kamar'], $req['rawat_intensif'],
																				$req['obat'], $req['alkes'], $req['bmhp'], $req['sewa_alat']);
			if($dataKlaim['sukses']==1){
				$grouper = $this->GroupingStage1($req['registrasi_id'], $req['no_sep'], $req['coder_nik']);
				if($grouper['sukses']==1){
					return response()->json(['sukses' => 1, 'data'=>$grouper['message'], 'message'=>'success', 'no_sep'=>$req['no_sep']]); exit;
				}else{
					return response()->json(['sukses' => 0, 'message'=>$grouper['message']]); exit;
				}
			}else{
				return response()->json(['sukses' => 0, 'message'=>$dataKlaim['message']]); exit;
			}
    } else {
      return response()->json(['errors' => $cek->errors()]); exit;
    }
  }

  public function ambilDataPerKlaim($sep=''){
     return  $this->MengambilDataDetailPerklaim($sep);
  }

  function getKey() {
    $keyRS = config('app.inacbg_enc_key');
    return $keyRS;
  }

  function getUrlWS() {
    $UrlWS = config('app.inacbg_url');
    return $UrlWS;
  }

  function getKelasRS() {
    $kelasRS = "BP";
    return $kelasRS;
  }

  function mc_encrypt($data, $strkey) {
    $key = hex2bin($strkey);
    if (mb_strlen($key, "8bit") !== 32) {
      throw new Exception("Needs a 256-bit key!");
    }

    $iv_size   = openssl_cipher_iv_length("aes-256-cbc");
    $iv        = openssl_random_pseudo_bytes($iv_size);
    $encrypted = openssl_encrypt($data, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv);
    $signature = mb_substr(hash_hmac("sha256", $encrypted, $key, true), 0, 10, "8bit");
    $encoded   = chunk_split(base64_encode($signature.$iv.$encrypted));
    return $encoded;
  }

  function mc_decrypt($str, $strkey) {
    $key = hex2bin($strkey);
    if (mb_strlen($key, "8bit") !== 32) {
      throw new Exception("Needs a 256-bit key!");
    }

    $iv_size        = openssl_cipher_iv_length("aes-256-cbc");
    $decoded        = base64_decode($str);
    $signature      = mb_substr($decoded, 0, 10, "8bit");
    $iv             = mb_substr($decoded, 10, $iv_size, "8bit");
    $encrypted      = mb_substr($decoded, $iv_size+10, NULL, "8bit");
    $calc_signature = mb_substr(hash_hmac("sha256", $encrypted, $key, true), 0, 10, "8bit");
    if (!$this->mc_compare($signature, $calc_signature)) {
      return "SIGNATURE_NOT_MATCH";
    }

    $decrypted = openssl_decrypt($encrypted, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv);
    return $decrypted;
  }

  function mc_compare($a, $b) {
    if (strlen($a) !== strlen($b)) {
      return false;
    }

    $result = 0;

    for ($i = 0; $i < strlen($a); $i++) {
      $result |= ord($a[$i])^ord($b[$i]);
    }

    return $result == 0;
  }

  function BuatKlaimBaru(Request $request) {
    $request_claim = '{
			"metadata":{
				"method":"new_claim"
			},
			"data":{
				"nomor_kartu":"'.$request['nomor_kartu'].'",
				"nomor_sep":"'.$request['nomor_sep'].'",
				"nomor_rm":"'.$request['nomor_rm'].'",
				"nama_pasien":"'.$request['nama_pasien'].'",
				"tgl_lahir":"'.$request['tgl_lahir'].'",
				"gender":"'.$request['gender'].'"
			}
		}';

    $msg = $this->Request($request_claim);
    //var_dump($msg); exit;
		if($msg['metadata']['code']==200){			
			$reg = Registrasi::where('no_sep', $request['nomor_sep'])->first();
			$reg->no_sep = $request['nomor_sep'];
			$reg->no_jkn = $request['nomor_kartu'];
			$reg->update();
			$in = Inacbg::where('no_sep',$request['nomor_sep'])->first();
			if($in==null){
				$in = new Inacbg();
			}
			$in->pasien_nama = $reg->pasien->nama;
			$in->pasien_kelamin = $reg->pasien->kelamin;
			$in->pasien_tgllahir = $reg->pasien->tgllahir;
			$in->jenis_pembayaran = $reg->bayar;
			$in->no_kartu = $request['nomor_kartu'];
			$in->no_sep = $request['nomor_sep'];
			$in->jenis_pasien = $reg->jenis_pasien;
			$in->no_rm = $request['nomor_rm'];
			$in->alamat = $reg->pasien->alamat;
			$in->no_hp = $reg->pasien->nohp;
			$in->poli_id = $reg->poli_id;
			$in->registrasi_id = $reg->id;
			$in->dijamin = null;
			$in->kode = null;
			$in->tgl_masuk = $reg->created_at;
			$in->tgl_keluar = $reg->tgl_pulang;
			$in->final_klaim 		= 'N';
      $in->kirim_dc 			= 'N';
			$in->kirim_lpk 			= 'N';
			$in->save();
			return ['status'=>true,'text'=>'Berhasil membuat klaim baru'];
		}elseif($msg['metadata']['code']==400 AND $msg['metadata']['error_no']=="E2007"){
			return ['status'=>false,'message'=>'duplicate','text'=>$msg['metadata']['message']];
		}else{
			return ['status'=>false,'message'=>'error','text'=>'Sedang terjadi kesalahan'];
		}
  }

  function UpdateDataPasien(Request $request) {
    $request_claim 	= '{
				"metadata": {
						"method": "update_patient",
						"nomor_rm": "'.$nomor_rmlama.'"
				},
				"data": {
						"nomor_kartu": "'.$nomor_kartu.'",
						"nomor_rm": "'.$nomor_rm.'",
						"nama_pasien": "'.$nama_pasien.'",
						"tgl_lahir": "'.$tgl_lahir.'",
						"gender": "'.$gender.'"
				}
		}';
    $msg = $this->Request($request_claim);
    if($msg['metadata']['code']==200){
			return ['status'=>true,'text'=>'Berhasil update data pasien'];
		}elseif($msg['metadata']['code']==400 AND $msg['metadata']['error_no']=="E2007"){
			return ['status'=>false,'message'=>'duplicate','text'=>$msg['metadata']['message']];
		}else{
			return ['status'=>false,'message'=>'error','text'=>'Sedang terjadi kesalahan'];
		}
  }

  function HapusDataPasien($regid, $nomor_rm, $coder_nik) {
    $request 	= '{
									"metadata": {
										"method": "delete_patient"
									},
									"data": {
										"nomor_rm": "'.$nomor_rm.'",
										"coder_nik": "'.$coder_nik.'"
									}
								}';
    $msg = $this->Request($request);
		if($msg['metadata']['code']==200){
			Inacbg::where('registrasi_id',$regid)->delete();
			$data_reg = Registrasi::where('id',$regid)->first();
			Flashy::success('Data pasien berhasil dihapus');
			if(substr($data_reg->status_reg,0,1)=='I'){
				return redirect('/frontoffice/e-claim/rawat-inap');
			}else{
				return redirect('/frontoffice/e-claim/rawat-jalan');
			}
		}else{
			Flashy::error($msg['metadata']['message'].'. Data pasien gagal dihapus');
			return back();
		}
  }

  function UpdateDataKlaim($registrasi_id, $nomor_sep, $nomor_kartu, $tgl_masuk, $tgl_pulang, $jenis_rawat, $kelas_rawat, $adl_sub_acute,$adl_chronic, $icu_indikator, $icu_los, $ventilator_hour, $upgrade_class_ind, $upgrade_class_class,        $upgrade_class_los, $add_payment_pct, $birth_weight, $discharge_status, $diagnosa, $procedure,$tarif_rs, $tarif_poli_eks, $nama_dokter, $kode_tarif, $payor_id, $payor_cd, $cob_cd, $coder_nik, $prosedur_non_bedah, $prosedur_bedah, $konsultasi, $tenaga_ahli, $keperawatan, $penunjang, $radiologi, $laboratorium, $pelayanan_darah, $rehabilitasi, $kamar, $rawat_intensif, $obat, $alkes, $bmhp, $sewa_alat){
    $request 	= '{
									"metadata": {
											"method": "set_claim_data",
											"nomor_sep": "'.$nomor_sep.'"
									},
									"data": {
										"nomor_sep": "'.$nomor_sep.'",
										"nomor_kartu": "'.$nomor_kartu.'",
										"tgl_masuk": "'.$tgl_masuk.'",
										"tgl_pulang": "'.$tgl_pulang.'",
										"jenis_rawat": "'.$jenis_rawat.'",
										"kelas_rawat": "'.$kelas_rawat.'",
										"adl_sub_acute": "'.$adl_sub_acute.'",
										"adl_chronic": "'.$adl_chronic.'",
										"icu_indikator": "'.$icu_indikator.'",
										"icu_los": "'.$icu_los.'",
										"ventilator_hour": "'.$ventilator_hour.'",
										"upgrade_class_ind": "'.$upgrade_class_ind.'",
										"upgrade_class_class": "'.$upgrade_class_class.'",
										"upgrade_class_los": "'.$upgrade_class_los.'",
										"add_payment_pct": "'.$add_payment_pct.'",
										"birth_weight": "'.$birth_weight.'",
										"discharge_status": "'.$discharge_status.'",
										"diagnosa": "'.$diagnosa.'",
										"procedure": "'.$procedure.'",
										"tarif_rs": {
												"prosedur_non_bedah": "'.$prosedur_non_bedah.'",
												"prosedur_bedah": "'.$prosedur_bedah.'",
												"konsultasi": "'.$konsultasi.'",
												"tenaga_ahli": "'.$tenaga_ahli.'",
												"keperawatan": "'.$keperawatan.'",
												"penunjang": "'.$penunjang.'",
												"radiologi": "'.$radiologi.'",
												"laboratorium": "'.$laboratorium.'",
												"pelayanan_darah": "'.$pelayanan_darah.'",
												"rehabilitasi": "'.$rehabilitasi.'",
												"kamar": "'.$kamar.'",
												"rawat_intensif": "'.$rawat_intensif.'",
												"obat": "'.$obat.'",
												"alkes": "'.$alkes.'",
												"bmhp": "'.$bmhp.'",
												"sewa_alat": "'.$sewa_alat.'"
										 },
										"tarif_poli_eks": "'.$tarif_poli_eks.'",
										"nama_dokter": "'.$nama_dokter.'",
										"kode_tarif": "'.$kode_tarif.'",
										"payor_id": "'.$payor_id.'",
										"payor_cd": "'.$payor_cd.'",
										"cob_cd": "'.$cob_cd.'",
										"coder_nik": "'.$coder_nik.'"
									}
								}';
								
		$msg = $this->Request($request);
    if($msg['metadata']['code'] == 400){
    	return ['sukses' => 0, 'message'=>$msg['metadata']['message']];
    }else{
    	return ['sukses' => 1, 'message'=>'success'];
		}
  }

  function UpdateDataProsedur($nomor_sep, $procedure, $coder_nik) {
    $request 	= '{
										"metadata": {
												"method": "set_claim_data",
												"nomor_sep": "'.$nomor_sep.'",
										},
										"data": {
												"procedure": "'.$procedure.'",
												"coder_nik": "'.$coder_nik.'"
										}
								}';
    $msg = $this->Request($request);
    echo $msg['metadata']['message']."";
  }

  function HapusSemuaProsedur($nomor_sep, $coder_nik) {
    $request 	= '{
									"metadata": {
											"method": "set_claim_data",
											"nomor_sep": "'.$nomor_sep.'",
									},
											"data": {
											"procedure": "#",
											"coder_nik": "'.$coder_nik.'"
									}
							}';
    $msg = $this->Request($request);
  }

  function GroupingStage1($registrasi_id, $nomor_sep, $coder_nik) {
    $request 	= '{
									"metadata": {
										"method":"grouper",
										"stage":"1"
									},
									"data": {
										"nomor_sep":"'.$nomor_sep.'"
									}
								}';
    $msg = $this->Request($request);
		//var_dump($msg); exit;
		
    if($msg['metadata']['code'] == 400){
    	return ['sukses' => 0, 'message'=>$msg['metadata']['message']];
		}elseif($msg['metadata']['message'] == "Ok"){
      $r = Inacbg::where('no_sep', $nomor_sep)->first();
			$tariff = 0;
			if(isset($msg['response']['cbg']['tariff'])){ 
				$tariff = $msg['response']['cbg']['tariff'];
			}
      $r->dijamin 					= $tariff;
			$r->special_cmg 			= null;
      $r->kode 							= $msg['response']['cbg']['code'];
      $r->deskripsi_grouper = $msg['response']['cbg']['description'];
      $r->versi_eklaim 			= $msg['response']['inacbg_version'];
      $r->who_update 				= Auth::user()->name;
      $r->los 							= 1;
			$r->final_klaim 			= 'N';
      $r->kirim_dc 					= 'N';
			$r->kirim_lpk 				= 'N';			
							
			$pemb = Pembayaran::where('registrasi_id',$registrasi_id)->first();
			if($pemb!=null){
				$r->pembayaran_id = $pemb->id;
			}			
			if($r->update()){
				return ['sukses' => 1, 'message'=>$msg];
			}else{
				return ['sukses' => 0, 'message'=>'gagal grouping'];
			}
    }
  }

  function GroupingStage2($nomor_sep) {
    $request = '{
									"metadata": {
										"method":"grouper",
										"stage":"2"
									},
									"data": {
										"nomor_sep":"'.$nomor_sep.'",
										"special_cmg": "'.$_GET['special_cmg'].'"
									}
								}';
    $msg = $this->Request($request);
		//var_dump($msg); exit;
		if($msg['metadata']['code'] == 400){
    	return ['sukses' => 0, 'message'=>$msg['metadata']['message']];
		}elseif($msg['metadata']['code'] == 200){
			$r = Inacbg::where('no_sep', $nomor_sep)->first();
			$r->special_cmg = $_GET['special_cmg'];
			$r->save();
			return response()->json(['sukses' => 1, 'data'=>$msg['response']]);
		}else{
			return ['sukses' => 0, 'message'=>'Sedang terjadi kesalahan'];
		}
  }

  function FinalisasiKlaim($nomor_sep) {
    $request 	= '{
									"metadata": {
										"method":"claim_final"
									},
									"data": {
										"nomor_sep":"'.$nomor_sep.'",
										"coder_nik": "'.config('app.coder_nik').'"
									}
								}';
    $msg = $this->Request($request);
		//var_dump($msg); exit;
    if($msg['metadata']['code'] == 400){
    	return ['sukses' => 0, 'message'=>$msg['metadata']['message']];
		}elseif($msg['metadata']['code'] == 200){
			$r = Inacbg::where('no_sep', $nomor_sep)->first();
			$r->final_klaim = 'Y';
			$r->save();
			return response()->json(['sukses' => 1, 'data'=>'Berhasil final klaim']);
		}else{
			return ['sukses' => 0, 'message'=>'Sedang terjadi kesalahan'];
		}
  }

  function EditUlangKlaim($nomor_sep) {
    $request 	= '{
									"metadata": {
										"method":"reedit_claim"
									},
									"data": {
										"nomor_sep":"'.$nomor_sep.'"
									}
								}';
    $msg = $this->Request($request);
    //echo $msg['metadata']['message']."";
  }

  function KirimKlaimPeriodeKeDC($start_dt, $stop_dt, $jenis_rawat) {
    $request = '{
										"metadata": {
												"method":"send_claim"
										},
										"data": {
												"start_dt":"'.$start_dt.'",
												"stop_dt":"'.$stop_dt.'",
												"jenis_rawat":"'.$jenis_rawat.'"
										}
								}';
    $msg = $this->Request($request);
    echo $msg['metadata']['message']."";
  }

  function KirimKlaimIndividualKeDC($nomor_sep) {
    $request 	= '{
									"metadata": {
										"method":"send_claim_individual"
									},
									"data": {
										"nomor_sep":"'.$nomor_sep.'"
									}
								}';
    $msg = $this->Request($request);
		//var_dump($msg); exit;
		if($msg['metadata']['message'] == "Ok"){
			$r = Inacbg::where('no_sep', $nomor_sep)->first();
			$r->kirim_dc = 'Y';
			$r->update();
      return ['status' => true, 'message'=>'Sukses mengirim klaim individual ke data center'];
    }else{
			return ['status' => false, 'message'=>$msg['metadata']['message']]; exit;
		}
  }

  function MenarikDataKlaimPeriode($start_dt, $stop_dt, $jenis_rawat) {
    $request = '{
                          "metadata": {
                              "method":"pull_claim"
                          },
                          "data": {
                              "start_dt":"'.$start_dt.'",
                              "stop_dt":"'.$stop_dt.'",
                              "jenis_rawat":"'.$jenis_rawat.'"
                          }
                     }';
    $msg = $this->Request($request);
    echo $msg['metadata']['message']."";
  }

  function MengambilDataDetailPerklaim($nomor_sep) {
    $request 	=	'{
									"metadata": {
										"method":"get_claim_data"
									},
									"data": {
										"nomor_sep":"'.$nomor_sep.'"
									}
								}';
    $msg = $this->Request($request);
    //var_dump($msg); exit;
		return $msg;
  }

  function MengambilSetatusPerklaim($nomor_sep) {
    $request 	= '{
										"metadata": {
												"method":"get_claim_status"
										},
										"data": {
												"nomor_sep":"'.$nomor_sep.'"
										}
								}';
    $msg = $this->Request($request);
    echo $msg['metadata']['message']."";
  }

  function MenghapusKlaim($regid, $nomor_sep, $coder_nik) {
    $request = '{
									"metadata": {
											"method":"delete_claim"
									},
									"data": {
											"nomor_sep":"'.$nomor_sep.'",
											"coder_nik":"'.$coder_nik.'"
									}
                }';
    $msg = $this->Request($request);
		if($msg['metadata']['code']==200){
			Inacbg::where('registrasi_id',$regid)->delete();
			Flashy::success('Data klaim berhasil dihapus');		
		}else{
			Flashy::error($msg['metadata']['message'].'. Data klaim gagal dihapus');
		}
		return redirect('/frontoffice/e-claim/bridging/'.$regid);
  }

  function CetakKlaim($nomor_sep) {
    $request = 	'{
									"metadata": {
										"method": "claim_print"
									},
									"data": {
										"nomor_sep": "'.$nomor_sep.'"
									}
								}';
    $msg = $this->Request($request);
    echo $msg['metadata']['message']."";
  }

  function Request($request) {
    $json   = $this->mc_encrypt($request,$this->getKey());
    $header = array("Content-Type: application/x-www-form-urlencoded");
    $ch     = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->getUrlWS());
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    $response      = curl_exec($ch);
    $first         = strpos($response, "\n")+1;
    $last          = strrpos($response, "\n")-1;
    $hasilresponse = substr($response, $first, strlen($response)-$first-$last);
    $hasildecrypt  = $this->mc_decrypt($hasilresponse, $this->getKey());
    $msg = json_decode($hasildecrypt, true);
		//var_dump($msg); exit;
    return $msg;
  }

  //============ RESPONSE BRIDGING =======================================
  public static function getResponse($no_sep){
    $resp = Inacbg::where('no_sep', $no_sep)
						->select('no_sep', 'total_rs', 'dijamin', 'kode', 'final_klaim', 'kirim_dc', 'deskripsi_grouper', 'who_update', 'registrasi_id')
						->first();
    return response()->json($resp);
  }

  public static function detailBridging($registrasi_id){
    $inacbg = Inacbg::where('registrasi_id', $registrasi_id)->first();
    $registrasi = Registrasi::find($registrasi_id);
    return view('bridging.detailBridging', compact('inacbg', 'registrasi'));
  }

  public static function cetakBiayaPerawatan($registrasi_id){
    $reg = Registrasi::find($registrasi_id);
    $folio = Folio::where('registrasi_id', $registrasi_id)->get();
    $jml = Folio::where('registrasi_id', $registrasi_id)->sum('total');
    $no = 1;
    $pdf = PDF::loadView('bridging.rincianBiayaJKN', compact('reg', 'folio', 'jml', 'no'));
    return $pdf->stream();
  }

  public static function cetakDetailEklaim($registrasi_id){
    $reg = Registrasi::find($registrasi_id);
    $folio = Folio::where('registrasi_id', $registrasi_id)->get();
    $mapping = Mastermapping::all();
    $jml = Folio::where('registrasi_id', $registrasi_id)->sum('total');
    $no = 1;
    $pdf = PDF::loadView('bridging.detailRincianBiayaEklaim', compact('reg', 'folio', 'jml', 'no', 'mapping'));
    return $pdf->stream();
  }


}
