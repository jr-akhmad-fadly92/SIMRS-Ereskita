<?php

namespace App\Http\Controllers;
use App\Foliopelaksana;
use App\Gizi;
use App\Mastergizi;
use App\Operasi;
use App\Orderlab;
use App\Orderradiologi;
use App\Rawatinap;
use App\Apoteker;
use App\MasterEtiket;
use App\TakaranobatEtiket;
use App\DataOrderOperasi;
use App\Aturanetiket;
use App\Penjualan;
use Auth;
use DB;
use Excel;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Modules\Bed\Entities\Bed;
use Modules\Icd10\Entities\Icd10;
use Modules\Kamar\Entities\Kamar;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Kelas\Entities\Kelas;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Folio;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\HistoriStatus;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Tarif\Entities\Tarif;
use App\HistoriRawatInap;
use App\Historipengunjung;
use PDF;
use Validator;
use Yajra\DataTables\DataTables;

class RawatinapController extends Controller {
	public function index() {
	}

	public function menuBilling(){
		return view('rawat-inap.menuBillingIrna');
	}

	public function antrian($id = '') {
		$data['antrian'] = Registrasi::where('status_reg', 'I1')->get();
		//$data['kelas'] = Kelas::select('nama', 'id')->where('nama', '<>', '-')->orderBy('nama', 'asc')->get();
		$data['kelas'] = Kelas::get();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		$data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
		return view('rawat-inap.antrian', $data)->with('no', 1);
	}

	public function saveRawatInap(Request $request) {
		$ri = Rawatinap::where('registrasi_id', $request['registrasi_id'])->get();
		if($ri->count()){
			return response()->json(['error' => true, 'pesan' => 'Pasien sudah di inapkan sebelumnya!!! ']);
		}
		$cek = Validator::make($request->all(),[
			//'kelompokkelas_id' => 'required',
			'kelas_id' => 'required',
			'kamarid' => 'required',
			'bed_id' => 'required',
			'dokter_id' => 'required',
		]);
		if($cek->passes()){
			$reg = Registrasi::find($request['registrasi_id']);
			DB::transaction(function () use ($request,$reg){
				$kamar = Kamar::find($request['kamarid']);
				if($reg->bayar==1 AND $request['kode_dpjp']!=""){
					$dokter = Pegawai::where('kode',$request['kode_dpjp'])->first();
					if($dokter!=null){
						$reg->dokter_id = $dokter->id;
					}
				}else{
					$reg->dokter_id = $request['dokter_id'];
				}
				$ri = new Rawatinap();
				$ri->registrasi_id = $request['registrasi_id'];
				$ri->carabayar_id = $request['carabayar_id'];
				$ri->kelompokkelas_id = $kamar->kelompokkelas_id;
				$ri->kelas_id = $request['kelas_id'];
				$ri->kamar_id = $request['kamarid'];
				$ri->bed_id = $request['bed_id'];
				$ri->dokter_id = $reg->dokter_id;
				if(!empty($request['tanggal'])){
					$ri->tgl_masuk = valid_date($request['tanggal']).' '.date('H:i:s');
				} else {
					$ri->tgl_masuk = date('Y-m-d H:i:s');
				}
				$ri->save();

				$hi = new HistoriRawatInap();
				$hi->rawatinap_id = $ri->id;
				$hi->registrasi_id = $request['registrasi_id'];
				$hi->pasien_id = $reg->pasien->id;
				$hi->no_rm = $reg->pasien->no_rm;
				$hi->carabayar_id = $request['carabayar_id'];
				$hi->kelompokkelas_id = $kamar->kelompokkelas_id;
				$hi->kelas_id = $request['kelas_id'];
				$hi->kamar_id = $request['kamarid'];
				$hi->bed_id = $request['bed_id'];
				$hi->dokter_id = $reg->dokter_id;
				$hi->tgl_masuk = date('Y-m-d H:i:s');
				$hi->tarif = Kamar::where('id', $request['kamarid'])->first()->tarif;
				$hi->save();

				//Insert Histori Pengunjung
				$hp = new Historipengunjung();
				$hp->registrasi_id = $reg->id;
				$hp->pasien_id = $reg->pasien->id;
				$hp->politipe = 'I';
				if ($reg['status'] == 1) {
					$hp->status_pasien = 'BARU';
				} else {
					$hp->status_pasien = 'LAMA';
				}
				$hp->user = Auth::user()->name;
				$hp->save();

				//Update registrasi
				$reg->status_reg = 'I2';
				$reg->no_rujukan = $request['no_rujukan'];
				$reg->tgl_rujukan = $request['tgl_rujukan'];
				$reg->ppk_rujukan = $request['ppk_rujukan'];
				$reg->tgl_sep = ($request['tgl_sep']) ? valid_date($request['tgl_sep']) : date('Y-m-d');
				$reg->diagnosa_inap = $request['diagnosa_awal'];
				$reg->catatan = $request['catatan_bpjs'];
				$reg->hak_kelas_inap = $request['hak_kelas'];
				if(($request['hak_kelas_default']-1)==$request['hak_kelas']){
					$reg->is_naik_kelas = 1;
				}
				$reg->kelas_id = ($request['hak_kelas']+1);
				$reg->no_sep = $request['no_sep'];
				
				/* $triage_bidan = Poli::where('id',$reg->poli_id)->first();
				if($triage_bidan!=null){
				} */
				$persalinan = false;
				if(in_array($reg->poli_id,[1,23])){
					$persalinan = true;
				}
				if($persalinan){
					$reg->posisi_pasien = 'menunggu persalinan';
				}else{
					$reg->posisi_pasien = 'rawat inap';
				}
				
				$reg->update();

				$bed = Bed::find($request['bed_id']);
				$bed->reserved = 'Y';
				$bed->update();

				$histori = new HistoriStatus();
				$histori->registrasi_id = $request['registrasi_id'];
				$histori->status = 'I2';
				$histori->bed_id = $request['bed_id'];
				$histori->user_id = Auth::user()->id;
				$histori->save();
			});
			Flashy::success('Berhasil menyimpan data rawat inap');
			return response()->json(['success' => '1', 'bayar' => $reg->bayar, 'sep' => $reg->no_sep]);
		} else {
			return response()->json(['errors' => $cek->errors()]);
		}
	}

	public function pilihKelas(Request $req) {
		return redirect('rawat-inap/billing/' . $req['kelas_id'] . '/' . $req['kamar_id']);
	}

	public function billing($kelas_id = '', $kamar_id = '') {
		session()->forget('pj');
		session()->forget('lab_id');
		if (!empty($kelas_id) && !empty($kamar_id)) {
			$data['inap'] = Rawatinap::where('tgl_keluar',null)->where('kelas_id', $kelas_id)->where('kamar_id', $kamar_id)->get();
		} else {
			$data['inap'] = DB::table('rawatinaps')
				->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
				->where('registrasis.status_reg', 'I2')
				->where('registrasis.posisi_pasien', '!=', 'menunggu persalinan')
				->where('registrasis.pulang',null)
				->select('rawatinaps.*', 'registrasis.status_reg', 'registrasis.posisi_pasien')
				->get();
		}

		$data['kelas'] = Kelas::where('nama', '<>', '-')->pluck('nama', 'id');
		return view('rawat-inap.billing', $data)->with('no', 1);
	}
	
	/* 
	public function entry_tindakan($registrasi_id) {
		$data['folio'] = Folio::leftJoin('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
							->where('folios.registrasi_id', $registrasi_id)
							->whereNotIn('folios.jenis', ['PEM'])
							->orderBy('folios.created_at', 'desc')
							->select('folios.*', 'foliopelaksanas.dpjp', 'foliopelaksanas.dokter_pelaksana', 'foliopelaksanas.perawat')
							->get();
		$data['reg_id'] = $registrasi_id;
		$data['reg'] = Registrasi::where('id', '=', $registrasi_id)->first();
		$data['poli'] = Folio::where('registrasi_id', '=', $registrasi_id)->distinct();
		$data['tagihan'] = Folio::leftJoin('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
								->where('folios.registrasi_id', $registrasi_id)
								->where('folios.lunas', 'N')->sum('total');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['perawat'] = Pegawai::pluck('nama', 'id');
		$data['rawatinap'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		
		// PEMAKAIAN OBAT
		session(['jenis' => $data['reg']->bayar]);
		$data['penjualan'] = Penjualan::where('registrasi_id' ,$registrasi_id)->first();
		$data['status_upd']	= false;
		if($data['penjualan']!=null){
			if($data['penjualan']->status!='selesai'){
				$data['status_upd']	= true;	
			}
		}else{
			$data['status_upd']	= true;
		}
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['tiket'] = MasterEtiket::get();
		$data['takaran'] = TakaranobatEtiket::pluck('nama','nama');
		$data['aturan'] = Aturanetiket::pluck('aturan', 'aturan');
		$data['no'] = 1;
	  
		return view('rawat-inap.entry_tindakan', $data)->with('no', 1)->with('idreg', $registrasi_id);
	}

	public function save_tindakan(Request $request) {
		request()->validate(['tarif_id' => 'required']);
		DB::transaction(function () use ($request) {
			$ri = Rawatinap::where('registrasi_id', $request['registrasi_id'])->first();
			$reg = Registrasi::find($request['registrasi_id']);
			$tarif = Tarif::find($request['tarif_id']);
			$fol = new Folio();
			$fol->registrasi_id = $request['registrasi_id'];
			$fol->lunas = 'N';
			$fol->namatarif = $tarif->nama;
			$fol->tarif_id = $request['tarif_id'];
			$fol->cara_bayar_id = $reg->bayar;
			$fol->jenis = 'TI';
			$fol->total = ($tarif->total * $request['jumlah']);
			$fol->jenis_pasien = $request['jenis'];
			$fol->pasien_id = $request['pasien_id'];
			$fol->dokter_id = $request->dokter_id;

			if (!empty($request['tanggal'])) {
				$fol->created_at = valid_date($request['tanggal']);
			}
			$fol->kelompokkelas_id = $ri->kelompokkelas_id;
			$fol->kamar_id = $ri->kamar_id;
			$fol->user_id = Auth::user()->id;
			$fol->save();

			$fp = new Foliopelaksana();
			$fp->folio_id = $fol->id;
			$fp->dpjp = $request['dpjp'];
			$fp->dokter_pelaksana = $request['pelaksana'];
			$fp->perawat = $request['perawat'];
			$fp->pelaksana_tipe = 'TI';
			$fp->user = Auth::user()->id;
			$fp->save();

			// Insert Histori
			$bed = Rawatinap::where('registrasi_id', $request['registrasi_id'])->first();
			$bed->dokter_id = $request['dpjp'];
			$bed->update();

			$history = new HistoriStatus();
			$history->registrasi_id = $request['registrasi_id'];
			$history->status = 'I2';
			$history->bed_id = $bed->bed_id;
			$history->user_id = Auth::user()->id;
			$history->save();
		});
		return redirect('rawat-inap/entry-tindakan/' . $request['registrasi_id']);
	}

	public function editTindakan($folio_id)	{
		$folio = Folio::join('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
						->where('folios.id', $folio_id)
						->select('folios.*', 'foliopelaksanas.dpjp', 'foliopelaksanas.dokter_pelaksana', 'foliopelaksanas.perawat')
						->first();
		$dokter = Rawatinap::where('registrasi_id', $folio->registrasi_id)->first();
		return response()->json(['folio' => $folio, 'dokter'=>$dokter]);
	}

	public function saveEditTindakan(Request $request) {
		DB::transaction(function () use ($request) {
		    $tarif = Tarif::find($request['tarif_id']);
			$fol = Folio::find($request['folio_id']);
			$fol->registrasi_id = $request['registrasi_id'];
			$fol->namatarif = $tarif->nama;
			$fol->tarif_id = $request['tarif_id'];
			$fol->total = ($tarif->total * $request['jumlah']);
			if (!empty($request['tanggal'])) {
				$fol->created_at = valid_date($request['tanggal']);
			}
			$fol->user_id = Auth::user()->id;
			$fol->update();

			$fp = Foliopelaksana::where('folio_id', $fol->id)->first();
			$fp->dpjp = $request['dpjp'];
			$fp->dokter_pelaksana = $request['pelaksana'];
			$fp->perawat = $request['perawat'];
			$fp->pelaksana_tipe = 'TI';
			$fp->user = Auth::user()->id;
			$fp->update();
		});
		return response()->json(['sukses' => true]);
	}

	public function hapusTindakan($id, $registrasi_id) {
		if (Auth::user()->hasRole(['rawatinap', 'supervisor', 'administrator'])) {
			Folio::where('id', $id)->where('lunas', 'N')->delete();
		}
		return redirect('/rawat-inap/entry-tindakan/' . $registrasi_id);
	}
	 */
	
	/* public function ibs($registrasi_id = '') {
		$data['reg'] 	= Registrasi::where('id', $registrasi_id)->first();
		$data['irna'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		$data['ibs'] 	= Operasi::where('registrasi_id', $registrasi_id)->get();
		
		$data['depo']			= 'operasi';
		$data['jenis'] 		= Registrasi::where('id', '=', $registrasi_id)->first();
		$data['dokter'] 	= Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['perawat']	= Pegawai::whereNotIn('kategori_pegawai', [1])->pluck('nama', 'id');
		$data['detil_order']	= DataOrderOperasi::where('registrasi_id',$registrasi_id)->get();
		$data['folio'] 		= Folio::join('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
												->where('registrasi_id', $registrasi_id)
												->where('folios.poli_id', null)
												->whereNotIn('folios.jenis', ['PEM'])
												->select('folios.id as id_folio','folios.*', 'foliopelaksanas.*')->get();
		$data['pasien'] 	= Pasien::find($data['jenis']->pasien_id);
		if ($data['irna']) {
			session( ['kelas' => $data['irna']->kelas_id]);
		}
		return view('rawat-inap.ibs', $data)->with('no', 1)->with('idreg', $registrasi_id);
	} */

	/* public function saveibs(Request $req) {
		$req->validate(['rencana_operasi' => 'required', 'suspect' => 'required']);

		$ibs = new Operasi();
		$ibs->registrasi_id = $req['registrasi_id'];
		$ibs->rawatinap_id = $req['rawatinap_id'];
		$ibs->no_rm = $req['no_rm'];
		$ibs->rencana_operasi = valid_date($req['rencana_operasi']);
		$ibs->suspect = $req['suspect'];
		$ibs->save();
		Flashy::success('IBS berhasil disimpan');
		return redirect('rawat-inap/billing');
	} */

	/* 
	public function laboratorium($registrasi_id = '') {
		$data['reg']	 		= Registrasi::where('id', $registrasi_id)->first();
		$data['irna'] 		= Rawatinap::where('registrasi_id', $registrasi_id)->first();
		$data['order'] 		= Orderlab::where('registrasi_id', $registrasi_id)->get();
		
		$data['depo']			= 'laboratorium';
    $data['jenis'] 		= Registrasi::where('id', '=', $registrasi_id)->first();
    $data['pasien'] 	= Pasien::find($data['jenis']->pasien_id);
		$data['dokter'] 	= Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['perawat'] 	= Pegawai::whereNotIn('kategori_pegawai', [1])->pluck('nama', 'id');
    $data['opt_poli'] = Poli::where('politype', 'L')->get();
		$data['folio']		= Folio::leftJoin('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
												->where('folios.registrasi_id', $registrasi_id)
												->whereIn('folios.poli_id', [26,30])
												->select('folios.*', 'foliopelaksanas.dokter_lab','foliopelaksanas.analis_lab')
												->get();
		return view('rawat-inap.laboratorium', $data)->with('no', 1)->with('idreg', $registrasi_id);
	}

	public function simpanLaboratorium(Request $request) {
		request()->validate(['pemeriksaan' => 'required']);
		$lab = new Orderlab();
		$lab->registrasi_id = $request['registrasi_id'];
		$lab->pemeriksaan = $request['pemeriksaan'];
		$lab->user_id = Auth::user()->id;
		$lab->save();
		Flashy::success('Pendaftaran Laboratorium Sukses');
		return redirect('rawat-inap/billing');
	}

	public function radiologi($registrasi_id = '') {
		$data['reg'] 		= Registrasi::where('id', $registrasi_id)->first();
		$data['irna'] 	= Rawatinap::where('registrasi_id', $registrasi_id)->first();
		$data['order'] 	= Orderradiologi::where('registrasi_id', $registrasi_id)->get();
		
		$data['jenis'] 	= Registrasi::where('id', '=', $registrasi_id)->first();
		$data['pasien'] = Pasien::find($data['jenis']->pasien_id);
		$data['depo']		= 'radiologi';
		$data['dokter'] 	= Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['perawat'] 	= Pegawai::whereNotIn('kategori_pegawai', [1])->pluck('nama', 'id');
		$data['opt_poli'] = Poli::where('politype', 'R')->get();
		$data['folio'] 	= Folio::join('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
											->where('registrasi_id', $registrasi_id)
											->whereNotIn('folios.jenis', ['PEM'])
											->select('folios.*', 'foliopelaksanas.dokter_radiologi','foliopelaksanas.radiografer')
											->where('poli_id', 27)->get();
		return view('rawat-inap.radiologi', $data)->with('no', 1)->with('idreg', $registrasi_id);
	}

	public function simpanRadiologi(Request $request) {
		request()->validate(['pemeriksaan' => 'required']);
		$lab = new Orderradiologi();
		$lab->registrasi_id = $request['registrasi_id'];
		$lab->pemeriksaan = $request['pemeriksaan'];
		$lab->user_id = Auth::user()->id;
		$lab->save();
		Flashy::success('Pendaftaran Radiologi Sukses');
		return redirect('rawat-inap/billing');
	}

	public function fisioterapi($registrasi_id = '') {
		$data['reg'] = Registrasi::where('id', $registrasi_id)->first();
		$data['irna'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		return view('rawat-inap.fisioterapi', $data);
	}
	 */
	
	public function gizi($registrasi_id = '') {
		$data['reg'] = Registrasi::where('id', $registrasi_id)->first();
		$data['irna'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		$data['gizi'] = Mastergizi::pluck('gizi', 'gizi');
		$data['gizipasien'] = Gizi::join('registrasis', 'gizis.registrasi_id', '=', 'registrasis.id')
													->where('registrasis.pulang', null)
													->where('registrasis.id', $registrasi_id)
													->get();
		return view('rawat-inap.gizi', $data)->with('no', 1);
	}

	public function simpanGizi(Request $request) {
		request()->validate(['catatan' => 'required']);
		$gz = new Gizi();
		$gz->registrasi_id = $request['registrasi_id'];
		$gz->dokter = baca_dokter($request['dokter']);
		$gz->kelas_id = $request['kelas_id'];
		$gz->kamar_id = $request['kamar_id'];
		$gz->bed_id = $request['bed_id'];
		$gz->pagi = $request['pagi'];
		$gz->siang = $request['siang'];
		$gz->malam = $request['pagi'];
		$gz->catatan = $request['catatan'];
		$gz->who_update = Auth::user()->name;
		$gz->save();
		Flashy::success('Pendaftaran Gizi Sukses');
		return redirect('rawat-inap/billing');
	}

	public function mutasi($registrasi_id) {
		$data['reg'] = Registrasi::where('id', $registrasi_id)->first();
		$data['irna'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		//$data['kelas'] = Kelas::select('nama', 'id')->where('nama', '<>', '-')->orderBy('nama', 'asc')->get();
		$data['kelas'] = Kelas::get();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
		return view('rawat-inap.mutasi', $data);
	}

	public function simpanMutasi(Request $request) {
		if($request['kelas_id']=='' OR $request['kamarid']=='' OR $request['bed_id']==''){
			Flashy::error('Harap melengkapi data');
			return back();
		}
		$reg = Registrasi::find($request['registrasi_id']);			
		DB::transaction(function () use ($request,$reg) {
			$kamar = Kamar::find($request['kamarid']);
			$irna = Rawatinap::where('id', $request['rawatinap_id'])->first();
			$irna->kelompokkelas_id = $kamar->kelompokkelas_id;
			$irna->kelas_id = $request['kelas_id'];
			$irna->kamar_id = $request['kamarid'];
			$irna->bed_id = $request['bed_id'];
			$irna->dokter_id = $reg->dokter_id;;
			$irna->update();

			//insert histori irna
			$hi = new HistoriRawatInap();
			$hi->rawatinap_id = $irna->id;
			$hi->registrasi_id = $reg->id;
			$hi->pasien_id = $reg->pasien->id;
			$hi->no_rm = $reg->pasien->no_rm;
			$hi->carabayar_id = $irna->carabayar_id;
			$hi->kelompokkelas_id = $kamar->kelompokkelas_id;
			$hi->kelas_id = $request['kelas_id'];
			$hi->kamar_id = $request['kamarid'];
			$hi->bed_id = $request['bed_id'];
			$hi->dokter_id = $reg->dokter_id;;
			$hi->tgl_masuk = !empty($request['tgl_masuk']) ? date(valid_date($request['tgl_masuk']).' '.$request['jam']) : date('Y-m-d '.$request['jam']);
			$hi->tarif = Kamar::where('id', $request['kamarid'])->first()->tarif;
			$hi->save();		

			if($reg->poli_bpjs=='GOBG' OR $reg->poli_bpjs=='OBG' OR $reg->poli_id==1 OR $reg->poli_id==23){
				$pasien_bayi = Pasien::where('id_orangtua',$reg->pasien_id)->get();
				if($pasien_bayi->count() > 0){
					foreach($pasien_bayi as $keyb => $by){
						$reg_bayi = Registrasi::where('pasien_id',$by->id)->where('pulang',null)->first();
						if($reg_bayi!=null){
							$ranap_bayi = Rawatinap::where('registrasi_id',$reg_bayi->id)->first();
							if($ranap_bayi!=null AND $reg_bayi->bayi_sakit==null){
								$ranap_bayi->kelompokkelas_id = $kamar->kelompokkelas_id;
								$ranap_bayi->kelas_id = $request['kelas_id'];
								$ranap_bayi->kamar_id = $request['kamarid'];
								$ranap_bayi->bed_id = $request['bed_id'];
								$ranap_bayi->dokter_id = $reg->dokter_id;;
								$ranap_bayi->update();
								
								$hi = new HistoriRawatInap();
								$hi->rawatinap_id = $ranap_bayi->id;
								$hi->registrasi_id = $reg_bayi->id;
								$hi->pasien_id = $reg_bayi->pasien->id;
								$hi->no_rm = $reg_bayi->pasien->no_rm;
								$hi->carabayar_id = $ranap_bayi->carabayar_id;
								$hi->kelompokkelas_id = $kamar->kelompokkelas_id;
								$hi->kelas_id = $request['kelas_id'];
								$hi->kamar_id = $request['kamarid'];
								$hi->bed_id = $request['bed_id'];
								$hi->dokter_id = $reg->dokter_id;;
								$hi->tgl_masuk = !empty($request['tgl_masuk']) ? date(valid_date($request['tgl_masuk']).' '.$request['jam']) : date('Y-m-d '.$request['jam']);
								$hi->tarif = 0;
								$hi->save();
								
								if($reg_bayi->hak_kelas_inap!=null){
									if($reg_bayi->hak_kelas_inap > ($request['kelas_id']-1)){
										$reg_bayi->is_naik_kelas = 1;
									}else{
										$reg_bayi->is_naik_kelas = null;
									}
								}
								$reg_bayi->kelas_id = $request['kelas_id'];
								$reg_bayi->update();
							}
						}
					}
				}
			}

			//Update bed baru
			$bb = Bed::where('id', $request['bed_id'])->first();
			$bb->reserved = 'Y';
			$bb->update();

			//Update bed lama
			$bed = Bed::where('id', $request['bed_lama'])->first();
			if($bed!=null){
				$bed->reserved = 'N';
				$bed->update();
			}
			
			//Update registrasi
			if($reg->hak_kelas_inap!=null){
				if($reg->hak_kelas_inap > ($request['kelas_id']-1)){
					$reg->is_naik_kelas = 1;
				}else{
					$reg->is_naik_kelas = null;
				}
			}
			if(isset($request['bayi_sakit'])){
				$reg->bayi_sakit = 1;
			}
			$reg->kelas_id = $request['kelas_id'];
			$reg->update();

			$history = new HistoriStatus();
			$history->registrasi_id = $request['registrasi_id'];
			$history->status = 'I2';
			$history->bed_id = $request['bed_id'];
			$history->user_id = Auth::user()->id;
			$history->save();
		});
		
		$cek_mutasi = HistoriRawatInap::where('registrasi_id', $request['registrasi_id'])->orderBy('id', 'ASC')->get();
		if($cek_mutasi!=null){
			$loop=1;
			foreach($cek_mutasi as $key => $dm){
				if(($cek_mutasi->count()-1)==$loop){
					$upd_mutasi = HistoriRawatInap::find($dm->id);
					if($upd_mutasi->tgl_keluar==""){
						$upd_mutasi->tgl_keluar = !empty($request['tgl_masuk']) ? date(valid_date($request['tgl_masuk']).' '.$request['jam']) : date('Y-m-d '.$request['jam']);
						$upd_mutasi->save();
					}
				}
				$loop++;
			}
		}
		$cek_mutasi = HistoriRawatInap::where('registrasi_id', $request['registrasi_id'])->orderBy('id', 'ASC')->get();
		if($cek_mutasi->count() > 1){
			$loop=1;
			$id_prev = 0;
			foreach($cek_mutasi as $key => $dm){
				$data_now 	= HistoriRawatInap::find($dm->id);
				$data_prev 	= HistoriRawatInap::find($id_prev);
				if($data_prev!=null){
					$date1	= strtotime($data_prev->tgl_masuk);
					$date2	= strtotime($data_prev->tgl_keluar);
					$diff		= $date2-$date1;
					$hari=floor($diff / (60 * 60 * 24));
					$jam= floor($diff / (60 * 60));
					if($loop > 1 AND 24 > $jam){
						// jika tarif sekarang lebih besar
						if($data_now->tarif > $data_prev->tarif){
							$data_now->tarif = $data_now->tarif;
							$data_prev->tarif = 0;
						}else{
							$data_now->tarif = $data_prev->tarif;
							$data_prev->tarif = 0;
						}
					}
					$data_prev->save();
				}
				$data_now->save();
				$loop++;
				$id_prev = $data_now->id;
			}
		}
		Flashy::success('Pendaftaran Mutasi Sukses');
		return redirect('tindakan/entry/'.$reg->id.'/'.$reg->pasien_id);		
		//return redirect('rawat-inap/billing');
	}

	public function pulang(Request $request) {
		$registrasi_id = $request['registrasi_id'];
		$bed_id = $request['bed_id'];
		$tanggal = valid_date($request['tanggal']);
		
		DB::transaction(function () use ($registrasi_id, $bed_id, $tanggal) {
			$reg = Registrasi::where('id', $registrasi_id)->first();
			$reg->status_reg = 'I3';
			$reg->update();

			$history = new HistoriStatus();
			$history->registrasi_id = $registrasi_id;
			$history->status = 'I3';
			$history->bed_id = null;
			$history->user_id = Auth::user()->id;
			$history->save();

			$bed = Bed::find($bed_id);
			$bed->reserved = 'N';
			$bed->update();

			$ri = Rawatinap::where('registrasi_id', $registrasi_id)->first();
			$ri->tgl_keluar = date($tanggal. ' H:i:s');
			$ri->update();
		});

		$reg = Registrasi::find($registrasi_id);
		Flashy::success('Pasien '. $reg->pasien->nama .' berhasil dipulangkan tanggal '.tgl_indo($tanggal));
		return response()->json(['sukses' => true]);		
	}

	//============ EMR =============================

	public function emr() {
		return view('rawat-inap.view_emr');
	}

	//========= LAPORAN ==========================================================
	public function lap_pengunjung() {
		$data['kelas'] = Kelas::select('id', 'nama')->where('nama', '<>', '-')->get();
		$data['kamar'] = Kamar::select('id', 'nama')->get();
		$data['irna'] = DB::table('registrasis')->where('registrasis.status_reg', 'I2')
			->join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
			->select('registrasis.id', 'registrasis.pasien_id', 'registrasis.tipe_jkn', 'rawatinaps.*')
			->get();
		return view('rawat-inap.lap_pengunjung', $data)->with('no', 1);
	}

	public function lap_pengunjung_byTanggal(Request $request) {
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$kamar = Kamar::select('id')->get();
		$km = [];
		foreach ($kamar as $key => $d) {
			$km[] = '' . $d->id . '';
		}

		$data['kelas'] = Kelas::select('id', 'nama')->where('nama', '<>', '-')->get();
		$data['kamar'] = Kamar::select('id', 'nama')->get();
		if (!empty($request['pasien_id'])) {
			$data['irna'] = DB::table('registrasis')->where('registrasis.status_reg', 'I2')->whereBetween('registrasis.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
				->whereIn('kamar_id', !empty($request['kamar']) ? [$request['kamar']] : $km)
				->whereIn('pasien_id', [$request['pasien_id']])
				->join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
				->select('registrasis.id', 'registrasis.pasien_id', 'registrasis.tipe_jkn', 'rawatinaps.*')
				->get();
		} else {
			$data['irna'] = DB::table('registrasis')->where('registrasis.status_reg', 'I2')->whereBetween('registrasis.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
				->whereIn('kamar_id', !empty($request['kamar']) ? [$request['kamar']] : $km)
				->join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
				->select('registrasis.id', 'registrasis.pasien_id', 'registrasis.tipe_jkn', 'rawatinaps.*')
				->get();
		}
		$irna = $data['irna'];
		if ($request['lanjut']) {
			return view('rawat-inap.lap_pengunjung', $data)->with('no', 1);

		} elseif ($request['excel']) {
			Excel::create('Laporan Pengunjung Rawat Inap', function ($excel) use ($irna) {
				// Set the properties
				$excel->setTitle('Laporan Pengunjung Rawat Inap')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Pengunjung Rawat Inap');
				$excel->sheet('Laporan Pengunjung Rawat Inap', function ($sheet) use ($irna) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No',
						'No. RM',
						'Nama',
						'Alamat',
						'Tgl Masuk',
						'Cara Bayar',
						'Kelas',
						'Kamar',
						'Bed',
					]);
					foreach ($irna as $key => $d) {
						$sheet->row(++$row, [
							$no++,
							Pasien::find($d->pasien_id)->no_rm,
							Pasien::find($d->pasien_id)->nama,
							Pasien::find($d->pasien_id)->alamat,
							tanggal($d->created_at),
							baca_carabayar($d->carabayar_id) . ' ' . $d->tipe_jkn,
							baca_kelas($d->kelas_id),
							baca_kamar($d->kamar_id),
							baca_bed($d->bed_id),
						]);
					}

				});
			})->export('xlsx');

		} elseif ($request['pdf']) {
			$no = 1;
			$pdf = PDF::loadView('rawat-inap.pdf_lap_pengunjung', compact('irna', 'no'));
			$pdf->setPaper('A4', 'landscape');
			return $pdf->download('lap_kunjungan_irna.pdf');
		}
	}

	public function sensus_harian() {
		return view('rawat-inap.sensus_harian');
	}

	public function informasi_rawat() {
		return view('rawat-inap.informasi-rawat');
	}

	public function dataRawatInap(){
		DB::statement(DB::raw('set @nomorbaris=0'));
		$irna = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
						->select(['registrasis.id as reg_id', 'registrasis.pasien_id', 'registrasis.jenis_pasien', 'registrasis.status', 'registrasis.rujukan', 'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.tipe_layanan', 'registrasis.bayar', 'registrasis.tipe_jkn', 'rawatinaps.created_at', 'rawatinaps.*'])
						->where('registrasis.status_reg', 'I2')->get();
		return DataTables::of($irna)
			->addColumn('nomor', function ($irna) {
				return '';
			})
			->addColumn('no_rm', function ($irna) {
				return (isset($irna->pasien)) ? $irna->pasien->no_rm : '';
			})
			->addColumn('nama', function ($irna) {
				return (isset($irna->pasien)) ? $irna->pasien->nama : '';
			})
			->addColumn('alamat', function ($irna) {
				return (isset($irna->pasien)) ? substr($irna->pasien->alamat,0,30) : '';
			})
			->addColumn('waktu', function ($irna) {
				return $irna->created_at->format('d-m-Y H:i:s');
			})
			->addColumn('durasi', function ($irna) {
				$date1=strtotime($irna->tgl_masuk);
				if($irna->tgl_keluar==""){
					$date2=time();
				}else{
					$date2=strtotime($irna->tgl_keluar);
				}
				$diff	= $date2-$date1;
				$hari	= floor($diff / (60 * 60 * 24));
				$jam	= floor($diff / (60 * 60)) - ($hari * 24);
				$menit= floor($diff / (60)) - (((($hari * 24) + $jam) * 60));
				
				return $hari.' hari '.$jam.' jam '.$menit.' menit';
			})
			->addColumn('kelas', function ($irna) {
				return baca_kelas($irna->kelas_id);
			})
			->addColumn('bangsal', function ($irna) {
				return baca_kamar($irna->kamar_id);
			})
			->addColumn('bed', function ($irna) {
				return baca_bed($irna->bed_id);
			})
			->addColumn('dpjp', function ($irna) {
				return baca_dokter($irna->dokter_id);
			})
			->addColumn('carabayar', function ($irna) {
				$jkn = !empty($irna->tipe_jkn) ? '- ' . $irna->tipe_jkn : '';
				return baca_carabayar($irna->bayar) . " " . $jkn;
			})
			->addColumn('view', function ($irna) {
				return '<button type="button" onclick="viewDetail(' . $irna->reg_id . ')" class="btn btn-info btn-flat btn-sm">
										<i class="fa fa-folder-open"></i>
								</button>';
			})
			->rawColumns(['view'])
			->make(true);
	}

	public function detailDataRawatInap($registrasi_id) {
		$detail = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
			->where('registrasis.id', $registrasi_id)
			->select('registrasis.pasien_id', 'registrasis.jenis_pasien', 'registrasis.status', 'registrasis.rujukan',
				'registrasis.status_reg', 'registrasis.dokter_id', 'registrasis.poli_id',
				'registrasis.tipe_layanan', 'registrasis.bayar', 'registrasis.tipe_jkn', 'rawatinaps.created_at as waktu', 'rawatinaps.*')
			->first();
		$jkn = !empty($detail->tipe_jkn) ? ' - ' . $detail->tipe_jkn : '';
		$data['no_rm'] = $detail->pasien->no_rm;
		$data['nama'] = $detail->pasien->nama;
		$data['alamat'] = $detail->pasien->alamat;
		$data['waktu'] = tanggal($detail->waktu);
		$data['carabayar'] = baca_carabayar($detail->bayar) . $jkn;
		$data['dokter'] = baca_dokter($detail->dokter_id);
		$data['kelas'] = baca_kelas($detail->kelas_id);
		$data['kamar'] = baca_kamar($detail->kamar_id);
		$data['bed'] = baca_bed($detail->bed_id);
		$data['tgl_masuk'] = $detail->created_at->format('d-m-Y H:i:s');
		return response()->json($data);
	}

	// ===========================================================================
	public function getTarif($kategoritarif_id = '', $reg_id = '') {
		$tarif = Tarif::where('jenis', 'TI')->where('kategoritarif_id', $kategoritarif_id)->get(['id', 'nama', 'total']);
		return response()->json($tarif);
	}
	
	public function getKamar($kelas_id) {
		$kamar = Kamar::where('kelas_id', $kelas_id)->get(['nama', 'id']); // pluck
		return json_encode($kamar);
	}

	public function getBed($kelompokkelas_id, $kelas_id, $kamar_id) {
		$bed = Bed::where('kamar_id', $kamar_id)->where('reserved', 'N')->pluck('nama', 'id');
		return response()->json($bed);
	}

	public function getdatareg($registrasi_id = '') {
		$data = Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
						->join('carabayars', 'registrasis.bayar', '=', 'carabayars.id')
						->join('pegawais', 'registrasis.dokter_id', '=', 'pegawais.id')
						->join('polis', 'registrasis.poli_id', '=', 'polis.id')
						->select('registrasis.id', 'registrasis.status_reg', 'registrasis.dokter_id', 'carabayars.carabayar as pembayaran', 'registrasis.bayar', 'registrasis.no_jkn', 'registrasis.tipe_jkn', 'pasiens.no_rm', 'pasiens.nama', 'pasiens.nohp', 'registrasis.no_surat_kontrol', 'pegawais.kode', 'polis.bpjs as poli_bpjs')
						->where('registrasis.id', $registrasi_id)
						->first();
		session(['reg_id'=>$data->id]);
		$data['no_rujukan'] = config('app.sep_ppkLayanan').date('YmdHis');
		return response()->json($data);
	}

	public function lapirnagetkamar($kelas_id = '') {

		if (!empty($kelas_id)) {
			$kamar = Kamar::where('kelas_id', $kelas_id)->pluck('nama', 'id');
		} else {
			$kamar = Kamar::pluck('nama', 'id');
		}
		return json_encode($kamar);
	}

	public function rincianBiaya($registrasi_id) {
		$tagihan 	= Folio::where('registrasi_id', $registrasi_id)->where('lunas', 'N')
								->select('registrasi_id', 'namatarif', 'total', 'jenis', 'created_at')
								->get();
		return response()->json($tagihan);
	}

	public function sisaTotalTagihan($registrasi_id) {
		$tagihan = Folio::where('registrasi_id', $registrasi_id)->where('lunas', 'N')->sum('total');
		$kamar = total_tagihan($registrasi_id) - $tagihan;
		return response()->json(['tagihan'=>total_tagihan($registrasi_id), 'kamar'=>$kamar]);
	}

	public function askep() {
		session()->forget('pj');
		session()->forget('lab_id');
		if (!empty($kelas_id) && !empty($kamar_id)) {
			$data['inap'] = Rawatinap::where('kelas_id', $kelas_id)->where('kamar_id', $kamar_id)->get();
		} else {
			$data['inap'] = DB::table('rawatinaps')
				->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')->where('registrasis.status_reg', '=', 'I2')
				->select('rawatinaps.*', 'registrasis.status_reg')
				->get();
		}

		$data['kelas'] = Kelas::where('nama', '<>', '-')->pluck('nama', 'id');
		return view('rawat-inap.askep', $data)->with('no', 1);
	}

	public function kosongkanBed($bed_id, $registrasi_id) {
		$bed = Bed::find($bed_id);
		$bed->reserved = 'N';
		$bed->update();

		$irna = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		$irna->tgl_keluar = date('Y-m-d H:i:s');
		$irna->update();
		Flashy::success('Bed berhasil dikosongkan');
		return redirect('rawat-inap/billing');
	}


}
