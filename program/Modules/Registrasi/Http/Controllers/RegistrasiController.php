<?php

namespace Modules\Registrasi\Http\Controllers;

use App\Nomorrm;
use Auth;
use DB;
use Flashy;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Config\Entities\Config;
use Modules\Icd10\Entities\Icd10;
use App\Historipemeriksaanfisik;
use Modules\Pasien\Entities\Agama;
use Modules\Pasien\Entities\District;
use Modules\Pasien\Entities\Pasien;
use Modules\Pasien\Entities\Province;
use Modules\Pasien\Entities\Regency;
use Modules\Pasien\Entities\Village;
use Modules\Pekerjaan\Entities\Pekerjaan;
use Modules\Pendidikan\Entities\Pendidikan;
use Modules\Asuransi\Entities\Asuransi;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Biayaregistrasi;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\HistoriStatus;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Registrasi\Entities\Status;
use Modules\Registrasi\Entities\Tagihan;
use Modules\Registrasi\Entities\Tipelayanan;
use Modules\Registrasi\Http\Requests\SaveRegistrasiRequest;
use Modules\Rujukan\Entities\Rujukan;
use Modules\Sebabsakit\Entities\Sebabsakit;
use Modules\Tarif\Entities\Tarif;
use Modules\Pegawai\Entities\Pegawai;
use App\Historipengunjung;
use App\HistorikunjunganIGD;
use App\HistorikunjunganIRJ;
use App\Rawatinap;
use App\HistoriRawatInap;
use Illuminate\Support\Facades\Storage;

class RegistrasiController extends Controller {
	public function index(){
		return view('registrasi::index');
	}

	public function create($id = null, $bayi = null){
		session()->forget(['nama','nik','poli_tujuan','dokter','province_id','regency_id','district_id','village_id']);
		$data['provinsi'] 	= Province::pluck('name', 'id');
		$data['kabupaten'] 	= Regency::pluck('name', 'id');
		$data['kecamatan'] 	= District::pluck('name', 'id');
		$data['desa'] 			= Village::pluck('name', 'id');
		$data['pekerjaan'] 	= Pekerjaan::pluck('nama', 'id');
		$data['agama'] 			= Agama::pluck('agama', 'id');
		$data['asuransi'] 	= Asuransi::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
		$data['status'] 		= Status::pluck('status', 'id');
		$data['carabayar'] 	= Carabayar::pluck('carabayar', 'id');
		$data['rujukan'] 		= Rujukan::pluck('nama', 'id');
		$data['tipelayanan']= Tipelayanan::pluck('tipelayanan', 'id');
		$data['sebabsakit'] = Sebabsakit::pluck('nama', 'id');
		$data['poli'] 			= Poli::select('nama', 'id')->where('politype', 'J')->get();
		$data['id_pasien'] 	= $id;
		$data['pasien'] 		= Pasien::find($id);
		$reg = Registrasi::where('pasien_id',$id)->where('pulang',null)->first();
		if($bayi == "bayi"){
			$data['bayi'] = true;
			$data['header'] = "Bayi NY. ".$data['pasien']->nama;			
			$data['pasien']->ibu_kandung = $data['pasien']->nama;
			$data['pasien']->nama = "BAYI NY. ".$data['pasien']->nama;
			$data['pasien']->nik = 0;
			$data['pasien']->kelamin = "";
			$data['pasien']->pekerjaan_id = 16;
			$data['pasien']->pendidikan_id = 9;
			$data['pasien']->status_marital = "Blm Menikah";
			$data['pasien']->tgllahir = date('Y-m-d');
			if($reg==null){
				Flashy::error('Mohon maaf, pasien tidak ditemukan');
				return redirect('/frontoffice/daftar-bayi');
			}
			session(['dokter'=>$reg->dokter_id]);
		}else{
			if($reg!=null){
				$unit = 'Rawat Jalan';
				if(substr($reg->status_reg,0,1)=='I'){
					$unit = 'Rawat Inap';
				}
				Flashy::error('Mohon maaf, pasien masih tercatat sebagai pasien '.$unit);
				return redirect('/antrian/daftarantrian/'.session('no_loket'));
			}
			$data['bayi'] = false;
			$data['header'] = "Pasien";
			session()->forget(['urlx']);
		}
		
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();

		return view('registrasi::create', $data);
	}
	
	public function create_umum($id = null, $bayi = null){
		session()->forget(['nama','nik','poli_tujuan','dokter','province_id','regency_id','district_id','village_id']);
		$data['provinsi'] 	= Province::pluck('name', 'id');
		$data['kabupaten'] 	= Regency::pluck('name', 'id');
		$data['kecamatan'] 	= District::pluck('name', 'id');
		$data['desa'] 			= Village::pluck('name', 'id');
		$data['pekerjaan'] 	= Pekerjaan::pluck('nama', 'id');
		$data['agama'] 			= Agama::pluck('agama', 'id');
		$data['asuransi'] 	= Asuransi::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
		$data['status'] 		= Status::pluck('status', 'id');
		$data['carabayar'] 	= Carabayar::whereIn('id', ['2', '3', '4', '6'])->get();
		$data['rujukan'] 		= Rujukan::pluck('nama', 'id');
		$data['tipelayanan']= Tipelayanan::pluck('tipelayanan', 'id');
		$data['sebabsakit'] = Sebabsakit::pluck('nama', 'id');
		$data['poli'] 			= Poli::select('nama', 'id')->where('politype', 'J')->get();
		$data['id_pasien'] 	= $id;
		$data['pasien'] 		= Pasien::find($id);
		if($bayi == "bayi"){
			$data['bayi'] 	= true;
			$data['header'] = "Bayi dari Ibu ".$data['pasien']->nama;			
			$data['pasien']->ibu_kandung = $data['pasien']->nama;
			$data['pasien']->nama = "BAYI NY. ".$data['pasien']->nama;
			$data['pasien']->nik = 0;
			$data['pasien']->kelamin = "";
			$data['pasien']->pekerjaan_id = 16;
			$data['pasien']->pendidikan_id = 9;
			$data['pasien']->status_marital = "Blm Menikah";
			$data['pasien']->tgllahir = date('Y-m-d');
			$reg = Registrasi::where('pasien_id',$id)->where('pulang',null)->first();
			
			
			if($reg==null){
				Flashy::error('Mohon maaf, pasien tidak ditemukan');
				return redirect('/frontoffice/daftar-bayi');
			}
			session(['dokter'=>$reg->dokter_id]);
		}else{
			$data['bayi'] = false;
			$data['header'] = "Pasien";
			session()->forget(['urlx']);
		}
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();

		return view('registrasi::create_umum', $data);
	}

	public function antrianPoli($poli_id = null, $dokter_id = null){
		$antrian_poli = Registrasi::where('poli_id', $poli_id)->where('dokter_id', $dokter_id)->where('created_at', 'like', date('Y-m-d') . '%')->count();
		$poli	=	Poli::where('id',$poli_id)->first();
		if($poli!=null){
			if($poli->kuota=='unlimited' OR (int)$poli->kuota >= $antrian_poli){
				return $antrian_poli + 1;
			}else{
				return 'full';
			}
		}
	}

	public function store(SaveRegistrasiRequest $request){
		session(['nama'=>$request['nama'], 'nik'=>$request['nik'], 'poli_tujuan'=>$request['poli_id'], 'dokter'=>$request['dokter_id'], 'province_id'=>$request['province_id'], 'regency_id'=>$request['regency_id'], 'district_id'=>$request['district_id'], 'village_id'=>$request['village_id']]);
		$no = Pasien::count() + config('app.no_rm')+1694;
		$no_rm = isset($request['no_rm']) ? $request['no_rm'] : $no;
		$cek = Pasien::where('no_rm', $no_rm)->count();
		if($cek > 0){
			Flashy::info('No RM baru (' . $no_rm . ') sudah ada, hubungi Admin!');
			return back();
		}
		/* if(hitung_umur($request['tgllahir']) > 17 AND strlen($request['nik'])!=16){
			Flashy::error('NIK harap diisi dengan benar');
			return back();
		} */
		DB::transaction(function () use ($request){
			$no = Pasien::count() + config('app.no_rm')+1694;
			$no_rm = isset($request['no_rm']) ? $request['no_rm'] : $no;

			// Save data pasien
			$pasien = new Pasien();
			$pasien->nama = strtoupper($request['nama']);
			$pasien->nik = $request['nik'];
			$pasien->tmplahir = strtoupper($request['tmplahir']);
			$pasien->tgllahir = valid_date($request['tgllahir']);
			$pasien->kelamin = $request['kelamin'];
			$pasien->no_rm = sprintf("%06s", $no_rm);
			$pasien->province_id = $request['province_id'];
			$pasien->regency_id = $request['regency_id'];
			$pasien->district_id = $request['district_id'];
			$pasien->village_id = $request['village_id'];
			$pasien->alamat = strtoupper($request['alamat']);
			$pasien->rt = $request['rt'];
			$pasien->rw = $request['rw'];
			$pasien->nohp = $request['nohp'];
			$pasien->negara = 'Indonesia';
			$pasien->pekerjaan_id = $request['pekerjaan_id'];
			$pasien->agama_id = $request['agama_id'];
			$pasien->pendidikan_id = $request['pendidikan_id'];
			$pasien->ibu_kandung = strtoupper($request['ibu_kandung']);
			if($request['asuransi_id']==null)
				{
				$pasien->asuransi = 'umum';
				}else{
				$pasien->asuransi = Asuransi::find($request['asuransi_id'])->nama ;
				}
			if($request['bayi']){
				$pasien->id_orangtua = $request['id_orangtua'];
			}
			$pasien->status_marital = $request['status_marital'];
			$pasien->user_create = Auth::user()->name;
			$pasien->user_update = '';
			$pasien->save();
			
			// cek kuota poli
			$antrian_poli = $this->antrianPoli($request['poli_id'],$request['dokter_id']);
			if($antrian_poli!='full'){
				// Save registrasi
				$max_srt_kontrol 				= Registrasi::max('no_surat_kontrol');
				if($max_srt_kontrol==null){
					$max_srt_kontrol = 100001;
				}else{
					$max_srt_kontrol++;
				}
				$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
				$reg = new Registrasi();
				$reg->pasien_id = $pasien->id;
				$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
				$reg->status = $request['status'];
				$reg->rujukan = $request['rujukan'];
				$reg->antrian_id = isset($request['antrian_id']) ? $request['antrian_id'] : NULL;
				$reg->rjtl = $request['rjtl'];
				$reg->kepesertaan = $request['kepesertaan'];
				$reg->tipe_layanan = $request['tipe_layanan'];
				$reg->dokter_id = $request['dokter_id'];
				$reg->poli_id = $request['poli_id'];
				$reg->icd = $request['icd'];
				$reg->kecelakaan = $request['kecelakaan'];
				$reg->tipe_jkn = $request['jkn'];
				$reg->no_sep = $request['no_sep'];
				$reg->sebabsakit_id = $request['sebabsakit_id'];
				$reg->bayar = $request['bayar'];
				$reg->no_jkn = $request['no_jkn'];
				$reg->user_create = Auth::user()->id;
				$reg->jenis_pasien = $request['bayar'];
				$reg->posisiberkas_id = '2';
				$reg->no_surat_kontrol = $max_srt_kontrol;				
				if($request['bayi']){
					$reg->posisi_pasien = 'rawat inap';
					$reg->status_reg = 'I2';
					$reg->bayi = 1;
					$ibu_bayi = Registrasi::where('pasien_id',$request['id_orangtua'])->where('pulang',null)->first();
					$reg->kelas_id = $ibu_bayi->kelas_id;
					$reg->hak_kelas_inap = $ibu_bayi->hak_kelas_inap;
					$reg->no_jkn = $ibu_bayi->no_jkn;
					$reg->poli_id = 11;
					$reg->poli_bpjs = 'ANA';
				}else{
					$poli = Poli::where('id',$request['poli_id'])->first();
					$reg->poli_bpjs = $poli->poli_bpjs;
					$reg->status_reg = $request['status_reg'];
				}
				if($request['status_reg'] == 'G1'){
					$reg->status_ugd = $request['status_ugd'];
				}
				$reg->asuransi_id = isset($request['asuransi_id']) ? $request['asuransi_id'] : NULL;
				$reg->no_loket = session('no_loket');
				$reg->antrian_poli = $antrian_poli;
				if(!empty($request['tanggal'])){
					$reg->created_at = valid_date($request['tanggal']);
				}
				$reg->save();
				session(['id_registrasi' => $reg->id]);
				
				// simpan kamar
				if($request['bayi']){
					$ibu_pasien = Registrasi::where('pasien_id',$request['id_orangtua'])->where('pulang',null)->first();
					$ibu_kamar  = Rawatinap::where('registrasi_id',$ibu_pasien->id)->first();
					$ri = new Rawatinap();
					$ri->registrasi_id = $reg->id;
					$ri->carabayar_id = $request['bayar'];
					$ri->kelompokkelas_id = $ibu_kamar->kelompokkelas_id;
					$ri->kelas_id = $ibu_kamar->kelas_id;
					$ri->kamar_id = $ibu_kamar->kamar_id;
					$ri->bed_id = $ibu_kamar->bed_id;
					$ri->dokter_id = $reg->dokter_id;
					$ri->tgl_masuk = date('Y-m-d H:i:s');
					$ri->save();
					$hi = new HistoriRawatInap();
					$hi->rawatinap_id = $ri->id;
					$hi->registrasi_id = $reg->id;
					$hi->pasien_id = $reg->pasien->id;
					$hi->no_rm = $reg->pasien->no_rm;
					$hi->carabayar_id = $request['bayar'];
					$hi->kelompokkelas_id = $ibu_kamar->kelompokkelas_id;
					$hi->kelas_id = $ibu_kamar->kelas_id;
					$hi->kamar_id = $ibu_kamar->kamar_id;
					$hi->bed_id = $ibu_kamar->bed_id;
					$hi->dokter_id = $reg->dokter_id;
					$hi->tgl_masuk = date('Y-m-d H:i:s');
					$hi->tarif = 0;
					$hi->save();
				}

				if($request['status_reg'] == 'G1'){
					$jenis = 'TG';
				}elseif($request['status_reg'] == 'J1'){
					$jenis = 'TA';
				}else{
					$jenis = 'TI';
				}

				// Insert Biaya Registrasi dan ke Folio
				if($request['bayi']){
					$biaya = Biayaregistrasi::where('tipe', 'I')->get();
				}elseif($request['tipe_layanan'] == 1 AND $jenis!="TG"){
					$biaya = Biayaregistrasi::where('tipe', 'E')->get();
				}else{
					$biaya = Biayaregistrasi::where('tipe', 'R')->get();
				}
			
				$harus_dibayar = 0;
				foreach ($biaya as $key => $d){
					$fol = new Folio();
					$fol->registrasi_id = $reg->id;
					$fol->namatarif = $d->tarif->nama; //koneksi ke Tarif
					if($request['bayi']){
						$fol->total = $d->tarif->tarif_kelas_3; //koneksi ke Tarif
					}else{
						$fol->total = $d->tarif->tarif_kelas_rj; //koneksi ke Tarif
					}
					$fol->tarif_id = $d->tarif->id; //koneksi ke Tarif
					$fol->lunas = 'N';
					$fol->cara_bayar_id = $request['bayar'];
					if($request['status_reg'] == 'G1'){
						$fol->poli_tipe = 'G';
					}elseif($request['status_reg'] == 'J1'){
						$fol->poli_tipe = 'J';
					}

					$fol->jenis = $jenis;
					$fol->pasien_id = $pasien->id;
					$fol->dokter_id = $reg->dokter_id;
					$fol->poli_id = $reg->poli_id;
					$fol->user_id = Auth::user()->id;
					$fol->save();
				}
				
				// Insert Histori
				$history = new HistoriStatus();
				$history->registrasi_id = $reg->id;
				$history->status = 'J1';
				$history->poli_id = $reg->poli_id;
				$history->bed_id = null;
				$history->user_id = Auth::user()->id;
				$history->save();

				//Insert Histori Pengunjung
				$hp = new Historipengunjung();
				$hp->registrasi_id = $reg->id;
				$hp->pasien_id = $pasien->id;
				if($request['status_reg'] == 'G1'){
					$hp->politipe = 'G';
				}elseif($request['status_reg'] == 'J1'){
					$hp->politipe = 'J';
				}
				if($request['status'] == 1){
					$hp->status_pasien = 'BARU';
				} else {
					$hp->status_pasien = 'LAMA';
				}
				$hp->user = Auth::user()->name;
				$hp->save();

				//Histori Kunjungan
				if($request['status_reg'] == 'G1'){ //IGD
					$igd = new HistorikunjunganIGD();
					$igd->registrasi_id = $reg->id;
					$igd->pasien_id = $pasien->id;
					$igd->triage_nama = baca_poli($request['poli_id']);
					$igd->doa = 'N';
					$igd->user = Auth::user()->name;
					$igd->save();
				}elseif($request['status_reg'] == 'J1'){ //IRJ
					$irj = new  HistorikunjunganIRJ();
					$irj->registrasi_id = $reg->id;
					$irj->pasien_id = $pasien->id;
					$irj->poli_id = $request['poli_id'];
					$irj->user = Auth::user()->name;
					$irj->save();
				}
				session(['pasienID' => $pasien->id, 'reg_id' => $reg->id]);
				
				Storage::disk('local')->put('rm/'.$reg->reg_id.'.txt', $hp->status_pasien.'|'.$reg->reg_id.'|'.$reg->pasien->nama.'|'.$reg->pasien->no_rm.'|'.$reg->pasien->tgllahir);
			}
		});
		if($this->antrianPoli($request['poli_id'],$request['dokter_id'])=='full'){
			Flashy::warning('Mohon maaf, kuota poli sudah penuh');
			return redirect('/antrian/daftarantrian/'.session('no_loket'));
		}else{
			session()->forget(['nama','nik','poli_tujuan','dokter','province_id','regency_id','district_id','village_id']);
			Flashy::success('Registrasi Sukses');			
			if($request['bayi']){
				return redirect('/frontoffice/daftar-bayi');
			}elseif($request['bayar'] == 1){
				return redirect('registrasi/v-claim/form-sep');
			}else{
				$regs = Registrasi::where('id',session('id_registrasi'))->first();
				return view('registrasi::bukti_pendaftaran', compact('regs'));
			}
		}
	}

	public function show(){
		/* $biaya = Biayaregistrasi::find(1);
		$nama = $biaya->tarif->nama;
		$total = $biaya->tarif->total;

		return $nama . ' ' . $total; */
	}

	public function edit(){
		return view('registrasi::edit');
	}

	public function update(Request $request, $id){
		session(['nama'=>$request['nama'], 'nik'=>$request['nik'], 'poli_tujuan'=>$request['poli_id'], 'dokter'=>$request['dokter_id'], 'province_id'=>$request['province_id'], 'regency_id'=>$request['regency_id'], 'district_id'=>$request['district_id'], 'village_id'=>$request['village_id']]);
		request()->validate([
		  'no_rm'          => 'unique:pasiens,no_rm',
			'nama'           => 'required',
			//'nik'            => 'required',
			'tmplahir'       => 'required',
			'tgllahir'       => 'required|date_format:d-m-Y',
			'kelamin'        => 'required',
			/* 'province_id'    => 'required',
			'regency_id'     => 'required',
			'district_id'    => 'required',
			'village_id'     => 'required',
			'alamat'         => 'required',
			'rt'         	   => 'required',
			'rw'             => 'required', */
			//'nohp'           => 'required',
			'pekerjaan_id'   => 'required',
			'agama_id'       => 'required',
			'pendidikan_id'  => 'required',
			'ibu_kandung'    => 'required',
			'status_marital' => 'required',
			'poli_id'       => 'required',
    ]);
		/* if(hitung_umur($request['tgllahir']) > 17 AND strlen($request['nik'])!=16){
			Flashy::error('NIK harap diisi dengan benar');
			return back();
		} */
		
		if($this->cekToday($id, $request['poli_id']) <= 0){
			DB::transaction(function () use ($request, $id){
				$pasien = Pasien::find($id);
				if(empty($pasien->no_rm)){
					$no_rm = Pasien::count() + 1;
					$pasien->no_rm = sprintf("%06s", $no_rm);
				}
				$pasien->nama = strtoupper($request['nama']);
				$pasien->nik = $request['nik'];
				$pasien->tmplahir = strtoupper($request['tmplahir']);
				$pasien->tgllahir = valid_date($request['tgllahir']);
				$pasien->kelamin = $request['kelamin'];
				$pasien->province_id = $request['province_id'];
				$pasien->regency_id = $request['regency_id'];
				$pasien->district_id = $request['district_id'];
				$pasien->village_id = $request['village_id'];
				$pasien->alamat = $request['alamat'];
				$pasien->rt = $request['rt'];
				$pasien->rw = $request['rw'];
				$pasien->nohp = $request['nohp'];
				$pasien->negara = 'Indonesia';
				$pasien->pekerjaan_id = $request['pekerjaan_id'];
				$pasien->agama_id = $request['agama_id'];
				$pasien->pendidikan_id = $request['pendidikan_id'];
				$pasien->ibu_kandung = $request['ibu_kandung'];
				$pasien->status_marital = $request['status_marital'];
				$pasien->user_update = Auth::user()->name;
				
				if($request['asuransi_id']==null)
				{
				$pasien->asuransi = 'umum';
				}else{
				$pasien->asuransi = Asuransi::find($request['asuransi_id'])->nama ;
				}
				$pasien->update();
				
				// cek kuota poli
				$antrian_poli = $this->antrianPoli($request['poli_id'],$request['dokter_id']);
				if($antrian_poli!='full'){
					// Save registrasi					
					$max_srt_kontrol 				= Registrasi::max('no_surat_kontrol');
					if($max_srt_kontrol==null){
						$max_srt_kontrol = 100001;
					}else{
						$max_srt_kontrol++;
					}
					$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
					$reg = new Registrasi();
					$reg->pasien_id = $pasien->id;
					$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
					$reg->status = $request['status'];
					$reg->rujukan = $request['rujukan'];
					$reg->antrian_id = isset($request['antrian_id']) ? $request['antrian_id'] : NULL;
					$reg->rjtl = $request['rjtl'];
					$reg->kepesertaan = $request['kepesertaan']; 
					$reg->tipe_layanan = $request['tipe_layanan'];
					$reg->catatan = $request['catatan'];
					$reg->dokter_id = $request['dokter_id'];
					$reg->poli_id = $request['poli_id'];
					$poli = Poli::where('id',$request['poli_id'])->first();
					$reg->poli_bpjs = $poli->poli_bpjs;					
					$reg->icd = $request['icd'];
					$reg->kecelakaan = $request['kecelakaan'];
					$reg->tipe_jkn = $request['jkn'];
					$reg->no_sep = $request['no_sep'];
					$reg->sebabsakit_id = $request['sebabsakit_id'];
					$reg->bayar = $request['bayar'];
					$reg->no_jkn = $request['no_jkn'];
					$reg->user_create = Auth::user()->id;
					$reg->jenis_pasien = $request['bayar'];
					$reg->posisiberkas_id = '2';
					$reg->status_reg = $request['status_reg'];
					if($request['status_reg'] == 'G1'){
						$reg->status_ugd = $request['status_ugd'];
					}
					$reg->asuransi_id = isset($request['asuransi_id']) ? $request['asuransi_id'] : NULL;
					$reg->no_loket = session('no_loket');
					$reg->antrian_poli = $antrian_poli;
					if(!empty($request['tanggal'])){
						$reg->created_at = valid_date($request['tanggal']);
					}
					$reg->no_surat_kontrol = $max_srt_kontrol;
					$reg->save();
					session(['id_registrasi' => $reg->id]);

					if($request['status_reg'] == 'G1'){
						$jenis = 'TG';
					}elseif($request['status_reg'] == 'J1'){
						$jenis = 'TA';
					}

					// Insert Biaya Registrasi dan ke Folio
					if($request['tipe_layanan'] == 1 AND $jenis!="TG"){
						$biaya = Biayaregistrasi::where('tipe', 'E')->get();
					}else{
						$biaya = Biayaregistrasi::where('tipe', 'R')->get();
					}
					$harus_dibayar = 0;
					foreach ($biaya as $key => $d){
						$fol = new Folio();
						$fol->registrasi_id = $reg->id;
						$fol->namatarif = $d->tarif->nama; //koneksi ke Tarif
						$fol->total = $d->tarif->tarif_kelas_rj; //koneksi ke Tarif
						$fol->tarif_id = $d->tarif->id; //koneksi ke Tarif
						$fol->lunas = 'N';
						$fol->cara_bayar_id = $request['bayar'];
						if($request['status_reg'] == 'G1'){
							$fol->poli_tipe = 'G';
						}elseif($request['status_reg'] == 'J1'){
							$fol->poli_tipe = 'J';
						}
						$fol->jenis = $jenis;
						$fol->pasien_id = $pasien->id;
						$fol->dokter_id = $reg->dokter_id;
						$fol->poli_id = $reg->poli_id;
						$fol->user_id = Auth::user()->id;
						$fol->save();
					}

					// Insert Histori
					$history = new HistoriStatus();
					$history->registrasi_id = $reg->id;
					$history->status = 'J1';
					$history->poli_id = $reg->poli_id;
					$history->bed_id = null;
					$history->user_id = Auth::user()->id;
					$history->save();

					//Insert Histori Pengunjung
					$hp = new Historipengunjung();
					$hp->registrasi_id = $reg->id;
					$hp->pasien_id = $pasien->id;
					if($request['status_reg'] == 'G1'){
						$hp->politipe = 'G';
					}elseif($request['status_reg'] == 'J1'){
						$hp->politipe = 'J';
					}
					if($request['status'] == 1){
						$hp->status_pasien = 'BARU';
					} else {
						$hp->status_pasien = 'LAMA';
					}
					$hp->user = Auth::user()->name;
					$hp->save();

					//Histori Kunjungan
					if($request['status_reg'] == 'G1'){ //IGD
						$igd = new HistorikunjunganIGD();
						$igd->registrasi_id = $reg->id;
						$igd->pasien_id = $pasien->id;
						$igd->triage_nama = baca_poli($request['poli_id']);
						$igd->doa = 'N';
						$igd->user = Auth::user()->name;
						$igd->save();
					}elseif($request['status_reg'] == 'J1'){ //IRJ
						$irj = new  HistorikunjunganIRJ();
						$irj->registrasi_id = $reg->id;
						$irj->pasien_id = $pasien->id;
						$irj->poli_id = $request['poli_id'];
						$irj->user = Auth::user()->name;
						$irj->save();
					}
					session(['pasienID' => $pasien->id, 'no_rm' => $pasien->no_rm, 'noka' => $reg->no_jkn, 'reg_id' => $reg->id]);
					
					Storage::disk('local')->put('rm/'.$reg->reg_id.'.txt', $hp->status_pasien.'|'.$reg->reg_id.'|'.$reg->pasien->nama.'|'.$reg->pasien->no_rm.'|'.$reg->pasien->tgllahir);
				}
			});
			session()->forget(['poli_tujuan','dokter']);
			$antrian_poli = $this->antrianPoli($request['poli_id'],$request['dokter_id']);
			if($antrian_poli=='full'){
				Flashy::warning('Mohon maaf, kuota poli sudah penuh');
				return redirect('/antrian/daftarantrian/'.session('no_loket'));
			}else{
				session()->forget('igdlama');
				session()->forget(['nama','nik','poli_tujuan','dokter','province_id','regency_id','district_id','village_id']);
				Flashy::success('Registrasi sukses');
				if($request['bayar'] == 1){
					return redirect('registrasi/v-claim/form-sep');
				}else{				
					$regs = Registrasi::where('id',session('id_registrasi'))->first();
					return view('registrasi::bukti_pendaftaran', compact('regs'));
				}
			}
		}else{
			Flashy::error('Sudah terdaftar hari ini di poli yang sama');
			if($request['status_reg'] == 'G1'){
				return redirect('frontoffice/rawat-darurat');
			} else {
				return redirect('antrian/daftarantrian/'.session('no_loket'));
			}
		}

	}

	public function updatePasien(Request $request){
		$update = Registrasi::find($request['registrasi_id']);
		$update->berat_badan 	= $request['berat_badan'];
		$update->tinggi 	= $request['tinggi'];
		$update->suhu 	= $request['suhu'];
		$update->sistolik 	= $request['sistolik'];
		$update->diastolik 	= $request['diastolik'];
		$update->tekanan_darah 	= $request['sistolik'].'/'.$request['diastolik'];
		//$update->diagnosa_akhir = $request['diagnosa_akhir'];
		//$update->diagnosa_awal = $request['diagnosa_akhir'];
		$update->anamnesis		= $request['anamnesis'];
		$update->saran		 	= $request['saran'];
		$update->keluhan		= $request['keluhan_pasien'];
		$update->respirasi	 	= $request['respirasi'];
		$update->tingkat_keluhan_pasien		= $request['tingkat_keluhan_pasien'];
		$update->tanggal_kontrol= valid_date($request['tanggal_kontrol']);
		if($request['kategori_diagnosa']=='awal')
		{
		$update->diagnosa_awal	= $request['diagnosa_akhir'];
		$update->diagnosa_akhir	= '-';
		$diagnosa_awal=$request['diagnosa_akhir'];
		$diagnosa_akhir='-';
		}else{
		$update->diagnosa_akhir = $request['diagnosa_akhir'];
		$diagnosa_awal='-';
		$diagnosa_akhir=$request['diagnosa_akhir'];
		}
		$nilai_gizi =  $request['berat_badan']/($request['tinggi']*$request['tinggi'])*10000;
		if(number_format($nilai_gizi)<18)
		{
			$status_gizi = 'Underweight';
		}elseif(number_format($nilai_gizi)<25){
			$status_gizi = 'Ideal Weight';
		}elseif(number_format($nilai_gizi)<35){
			$status_gizi = 'Overweight';
		}else{
			$status_gizi = 'Obese Category';
		}
		$update->status_gizi	= $status_gizi;
		Historipemeriksaanfisik::insert([
			'registrasi_id'=>$request['registrasi_id'],
			'sistolik'=>$request['sistolik'],
			'diastolik'=>$request['diastolik'],
			'tensi'=>$request['sistolik'].'/'.$request['diastolik'],
			'suhu'=>$request->suhu,
			'berat'=>$request['berat_badan'],
			'respirasi'=>$request['respirasi'],
			'tinggi'=>$request['tinggi'],
			'anamnesis'=>$request['anamnesis'],
			'keluhan_pasien'=>$request->keluhan_pasien,
			'tingkat_keluhan_pasien'=>$request['tingkat_keluhan_pasien'],
			'status_gizi'=>$status_gizi,
			'diagnosa_akhir'=>$diagnosa_akhir,
			'diagnosa_awal'=>$diagnosa_awal,
		]);
		if($update->update()){
			return response()->json(['sukses'=>true, 'message'=>'Data pasien berhasil disimpan','input'=>$status_gizi,'input_tekanan_darah'=>$request['sistolik'].'/'.$request['diastolik'],'diagnosa_awal'=>$update->diagnosa_awal,'diagnosa_akhir'=>$update->diagnosa_akhir]);
		}else{
			return response()->json(['sukses'=>false, 'message'=>'Data pasien gagal disimpan']);
		}
	}
	
	public function search(Request $request){
		$keyword = $request['keyword'];
		$data = Pasien::where('nama', 'LIKE', '%' . $keyword . '%')
			->orWhere('no_rm', 'LIKE', '%' . $keyword . '%')
			->orWhere('no_rm_lama', 'LIKE', '%' . $keyword . '%')
			->orWhere('alamat', 'LIKE', '%' . $keyword . '%')
			->get();

		return view('registrasi::index', compact('data', 'keyword'))->with('no', 1);
	}

	public function search_ajax(Request $request){
		$keyword = $request['keyword'];
		$data = Pasien::where('nama', 'LIKE', '%' . $keyword . '%')
			->orWhere('no_rm', 'LIKE', '%' . $keyword . '%')
			->orWhere('alamat', 'LIKE', '%' . $keyword . '%')
			->get();
		if(count($data) == 0){
			$searchResult[] = 'No item found';
		} else {
			foreach ($items as $key => $value){
				$searchResult[] = $value->item;
			}
		}
		return $searchResult;

	}

	//REG IGD JKN
	public function reg_igd_jkn($id = null){
		session()->forget(['nama','nik','poli_tujuan','dokter','province_id','regency_id','district_id','village_id']);
		$data['provinsi'] = Province::pluck('name', 'id');
		$data['kabupaten'] = Regency::pluck('name', 'id');
		$data['kecamatan'] = District::pluck('name', 'id');
		$data['desa'] = Village::pluck('name', 'id');
		$data['pekerjaan'] = Pekerjaan::pluck('nama', 'id');
		$data['agama'] = Agama::pluck('agama', 'id');
		$data['asuransi'] = Asuransi::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
		$data['status'] = Status::pluck('status', 'id');
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
		$data['rujukan'] = Rujukan::pluck('nama', 'id');
		$data['tipelayanan'] = Tipelayanan::pluck('tipelayanan', 'id');
		$data['sebabsakit'] = Sebabsakit::pluck('nama', 'id');
		$data['poli'] = Poli::select('nama', 'id')->where('politype', 'G')->get();
		$data['pasien'] = Pasien::find($id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10'] = Icd10::all();
		return view('igd.reg.create', $data);
	}

	public function reg_igd_jkn_lama(){
		session()->forget('igdumum-lama');
		session(['igdlama' => true]);
		return view('registrasi::index');
	}

	public function reg_igd_jkn_blmterdata($id = null){
		$data['provinsi'] = Province::pluck('name', 'id');
		$data['kabupaten'] = Regency::pluck('name', 'id');
		$data['kecamatan'] = District::pluck('name', 'id');
		$data['desa'] = Village::pluck('name', 'id');
		$data['pekerjaan'] = Pekerjaan::pluck('nama', 'id');
		$data['agama'] = Agama::pluck('agama', 'id');
		$data['asuransi'] = Asuransi::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
		$data['status'] = Status::pluck('status', 'id');
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
		$data['rujukan'] = Rujukan::pluck('nama', 'id');
		$data['tipelayanan'] = Tipelayanan::pluck('tipelayanan', 'id');
		$data['sebabsakit'] = Sebabsakit::pluck('nama', 'id');
		$data['poli'] = Poli::select('nama', 'id')->where('politype', 'G')->get();
		$data['pasien'] = Pasien::find($id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10'] = Icd10::all();
		return view('igd.reg.create_blmterdata', $data);
	}

	//REG IGD UMUM
	public function reg_igd_umum($id = null){
		session()->forget(['nama','nik','poli_tujuan','dokter','province_id','regency_id','district_id','village_id']);
		$data['provinsi'] = Province::pluck('name', 'id');
		$data['kabupaten'] = Regency::pluck('name', 'id');
		$data['kecamatan'] = District::pluck('name', 'id');
		$data['desa'] = Village::pluck('name', 'id');
		$data['pekerjaan'] = Pekerjaan::pluck('nama', 'id');
		$data['agama'] = Agama::pluck('agama', 'id');
		$data['asuransi'] = Asuransi::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
		$data['status'] = Status::pluck('status', 'id');
		$data['carabayar'] = Carabayar::select('carabayar', 'id')->get();
		$data['rujukan'] = Rujukan::pluck('nama', 'id');
		$data['tipelayanan'] = Tipelayanan::pluck('tipelayanan', 'id');
		$data['sebabsakit'] = Sebabsakit::pluck('nama', 'id');
		$data['poli'] = Poli::select('nama', 'id')->where('politype', 'G')->get();
		$data['pasien'] = Pasien::find($id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10'] = Icd10::all();
		return view('igd.reg.umum.create_umum', $data);
	}

	public function reg_igd_umum_lama(){
		session()->forget('igdlama');
		session(['igdumum-lama' => true]);
		return view('registrasi::index');
	}

	public function reg_igd_umum_blmterdata($id = null){
		$data['provinsi'] = Province::pluck('name', 'id');
		$data['kabupaten'] = Regency::pluck('name', 'id');
		$data['kecamatan'] = District::pluck('name', 'id');
		$data['desa'] = Village::pluck('name', 'id');
		$data['pekerjaan'] = Pekerjaan::pluck('nama', 'id');
		$data['agama'] = Agama::pluck('agama', 'id');
		$data['asuransi'] = Asuransi::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
		$data['status'] = Status::pluck('status', 'id');
		$data['carabayar'] = Carabayar::select('carabayar', 'id')->get();
		$data['rujukan'] = Rujukan::pluck('nama', 'id');
		$data['tipelayanan'] = Tipelayanan::pluck('tipelayanan', 'id');
		$data['sebabsakit'] = Sebabsakit::pluck('nama', 'id');
		$data['poli'] = Poli::select('nama', 'id')->where('politype', 'G')->get();
		$data['pasien'] = Pasien::find($id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10'] = Icd10::all();
		return view('igd.reg.umum.create_umum_blmterdata', $data);
	}

	public function cekToday($pasien_id, $poli_id){
		$reg = Registrasi::where('pasien_id', $pasien_id)->where('poli_id', $poli_id)->where('created_at', 'LIKE', date('Y-m-d') . '%')->count();
		return $reg;
	}

}
