<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Operasi;

use Modules\Config\Entities\Config;

use Image;

use App\Rawatinap;

use Modules\Registrasi\Entities\Folio;

use Modules\Registrasi\Entities\Registrasi;

use Modules\Pegawai\Entities\Pegawai;

use Modules\Kategoritarif\Entities\Kategoritarif;

use Modules\Tarif\Entities\Tarif;

use Modules\Pasien\Entities\Pasien;

use App\Foliopelaksana;

use App\Penjualan;

use App\DataOrderOperasi;

use App\TindakanOperasi;

use App\Mastermappingbiaya;

use Auth;

use PDF;



use MercurySeries\Flashy\Flashy;



class OperasiController extends Controller

{

	public function antrian($tgl=''){

		$data['antrian']	= Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')

												->join('operasis', 'registrasis.id', '=', 'operasis.registrasi_id')

												->where('registrasis.pulang',null)

												->where('registrasis.status_reg', 'I2')

												//->orderBy('operasis.rencana_operasi', 'asc')

												->orderBy('operasis.status_proses', 'asc')

												->get();

	

		return view('operasi.antrian', $data)->with('no', 1);

	}



	public function byTanggal(Request $request){

		request()->validate(['tanggal' => 'required']);

		return redirect('operasi/antrian/'.valid_date($request['tanggal']));

	}



	public function tindakan($registrasi_id=''){

		$data['reg'] 	= Registrasi::where('id', $registrasi_id)->first();

		$data['irna'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();

		$data['ibs'] 	= Operasi::where('registrasi_id', $registrasi_id)->get();

		$data['op'] 	= Operasi::where('registrasi_id', $registrasi_id)->first();

		$data['depo']					= 'operasi';

		$data['dokter'] 			= Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();

		$data['perawat']			= Pegawai::whereIn('kategori_pegawai', [2])->select('nama', 'id')->get();

		$data['perawatbidan']		= Pegawai::whereIn('kategori_pegawai', [2,3])->select('nama', 'id')->get();

		$data['detil_order']	= DataOrderOperasi::where('registrasi_id',$registrasi_id)->get();

		$data['folio'] 				= Folio::join('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')

														->join('tarifs', 'folios.tarif_id', '=', 'tarifs.id')

														->where('tarifs.kategoritarif_id', 4)

														->where('registrasi_id', $registrasi_id)

														->where('folios.poli_id', null)

														->whereNotIn('folios.jenis', ['PEM'])

														->select('folios.id as id_folio','folios.*', 'foliopelaksanas.*')->get();

		$data['pasien'] 			= Pasien::find($data['reg']->pasien_id);

		$data['tindakan'] 		= Tarif::where('kategoritarif_id', 4)->get();

		$data['nama_tindakan']= TindakanOperasi::all();

		$data['group'] 				= Mastermappingbiaya::where('kategoritarif_id',4)

														->groupBy('id')

														->select('id as id','kelompok')

														->get();

		if ($data['irna']) {

			session(['kelas' => $data['irna']->kelas_id]);

		}

		return view('operasi.tindakan', $data)->with('no', 1)->with('idreg', $registrasi_id);

	}



	public function simpanTindakan(Request $request){

		session([

			'dokter_anestesi' => $request['dokter_anestesi'],

			'dokter_anak' => $request['dokter_anak'],

			'operator1' => $request['operator1'],

			'operator2' => $request['operator2'],

			'perawat_ibs1' => $request['perawat_ibs1'],

			'perawat_ibs2' => $request['perawat_ibs2'],

			'perawat_ibs3' => $request['perawat_ibs3'],

			'perawat_ibs4' => $request['perawat_ibs4'],

		]);

		if($request['nama_tindakan']=="" AND $request['jenis_tindakan']==""){

			Flashy::error('Silahkan memilih nama dan jenis tindakan terlebih dahulu');

		}elseif($request['nama_tindakan']==""){

			Flashy::error('Silahkan memilih nama tindakan terlebih dahulu');

		}elseif($request['jenis_tindakan']==""){

			Flashy::error('Silahkan memilih jenis tindakan terlebih dahulu');

		}

		/* elseif($request['dokter_anestesi']==""){

			Flashy::error('Silahkan memilih Dokter Anestesi terlebih dahulu');

		}elseif($request['operator1']==""){

			Flashy::error('Silahkan memilih Operator 1 terlebih dahulu');

		}elseif($request['perawat_ibs1']==""){

			Flashy::error('Silahkan memilih Perawat 1 terlebih dahulu');

		} */

		else{

			$reg = Registrasi::find($request['registrasi_id']);			

			$idx = [];			

			if(substr($request['jenis_tindakan'],0,6)=='group-'){

				$cek_mapping = Tarif::where('mapping_biaya_id', '!=', null)->get();

				$id_group = str_replace('group-', '', $request['jenis_tindakan']);;

				if($cek_mapping!=null){

					foreach($cek_mapping as $key => $data){

						$var = json_decode($data->mapping_biaya_id);

						if(in_array($id_group, $var)){

							array_push($idx, $data->id);

						}

					}

				}

			}else{

				array_push($idx, $request['jenis_tindakan']);

			}

			foreach($idx as $id_tarif){

				$tarif = Tarif::find($id_tarif);

				$fol = new Folio();

				$fol->registrasi_id = $request['registrasi_id'];

				$fol->namatarif     = $request['nama_tindakan'].' - '.$tarif->nama;

				$fol->cara_bayar_id = $reg->bayar;

				$fol->total         = getTotalTarif($reg,$tarif);

				$fol->tarif_id      = $tarif->id; 

				$fol->lunas         = 'N';

				$fol->jenis         = 'TI';

				$fol->pasien_id     = $request['pasien_id'];

				$fol->dokter_id     = $request['dokter_dpjp'];

				$fol->user_id       = Auth::user()->id;

				if (!empty($request['tanggal'])) {

					$fol->created_at = valid_date($request['tanggal']);

				}

				$fol->save();

				

				$fp = new Foliopelaksana();

				$fp->folio_id = $fol->id;

				$fp->dpjp = $request['dokter_dpjp'];

				//$fp->dokter_bedah = $request['dokter_anestesi'];

				if(substr($tarif->nama,-8)=='Anestesi'){

					$fp->dokter_anestesi = $request['dokter_anestesi'];

				}

				if(substr($tarif->nama,-8)=='Operator'){

					$fp->dokter_operator1 = $request['operator1'];

				}

				if(substr($tarif->nama,-4)=='Anak'){

					$fp->dokter_anak = $request['dokter_anak'];

				}

				if(substr($tarif->nama,-9)=='Perawat 1'){

					$fp->perawat_ibs1 = $request['perawat_ibs1'];

				}

				if(substr($tarif->nama,-9)=='Perawat 2'){

					$fp->perawat_ibs2 = $request['perawat_ibs2'];

				}

				if(substr($tarif->nama,-9)=='Perawat 3'){

					$fp->perawat_ibs3 = $request['perawat_ibs3'];

				}

				

				if(substr($tarif->nama,-7)=='Perawat'){

					$fp->perawat_ibs4 = $request['perawat_ibs4'];

				}

				if(substr($tarif->nama,-14)=='Operator/Bedah'){

					$fp->dokter_operator2 = $request['operator2'];

				}

				$fp->user = Auth::user()->id;

				$fp->save();



				$op = Operasi::where('registrasi_id',$request['registrasi_id'])->first();

				if($request->nama_tindakan==null){



				}else{

					$op->nama_operasi 		= $request->nama_tindakan;

				}



				if(substr($tarif->nama,-8)=='Anestesi'){

					$op->dokter_anastesi = $request['dokter_anestesi'];

				}

				if(substr($tarif->nama,-8)=='Operator'){

					$op->operator = $request['operator1'];

				}

				if(substr($tarif->nama,-4)=='Anak'){

					$op->dokter_anak = $request['dokter_anak'];

				}

				if(substr($tarif->nama,-9)=='Perawat 1'){

					$op->perawat_1 = $request['perawat_ibs1'];

				}

				if(substr($tarif->nama,-9)=='Perawat 2'){

					$op->perawat_2 = $request['perawat_ibs2'];

				}

				if(substr($tarif->nama,-9)=='Perawat 3'){

					$op->perawat_3 = $request['perawat_ibs3'];

				}

				

				if(substr($tarif->nama,-7)=='Perawat'){

					$op->perawat_4 = $request['perawat_ibs4'];

				}

				if(substr($tarif->nama,-14)=='Operator/Bedah'){

					$op->operator2 = $request['operator2'];

				}

				if($request['jenis_anestesis']==null){



				}else{

					$op->tipe_anastesi	 		= $request['jenis_anestesis'];

				}

				if($request['jenis_operasi']==null){



				}else{

					$op->tipe_operasi	 		= $request['jenis_operasi'];

				}

				if($request['diagnosa_awal']==null){



				}else{

					$op->diagnosa_awal	 		= $request['diagnosa_awal'];

				}

				if($request['jaringan_eksisi-insisi']==null){



				}else{

					$op->jaringan_tubuh			= $request['jaringan_eksisi-insisi'];

				}

				if($request['diagnosa_pasca_op']==null){



				}else{

					$op->diagnosa_pasca_op		= $request['diagnosa_pasca_op'];

				}

				if($request['laporan_operasi']==null){



				}else{

					$op->laporan_operasi		= $request['laporan_operasi'];

				}

				

				

				$op->update();

				$reg = Registrasi::where('id',$request['registrasi_id'])->first();

				if($request['diagnosa_awal']==null){



				}else{

					$reg->diagnosa_awal	 		= $request['diagnosa_awal'];

				}

				if($request['diagnosa_pasca_op']==null){



				}else{

					$reg->diagnosa_akhir		= $request['diagnosa_pasca_op'];

				}

				$reg->update();

				

			}		



			Flashy::success('Tindakan berhasil di tambahkan');

		}

		return redirect('operasi/tindakan/'.$request['registrasi_id']);

	}

	

	public function simpanOrder(Request $request){

		if($request['tindakan_operasi']!=''){

			$order = new DataOrderOperasi();

			$order->registrasi_id = $request['registrasi_id'];

			$order->user_id = Auth::user()->id;

			$order->id_tindakan_operasi = $request['tindakan_operasi'];

			if($order->save()){

				Flashy::success('Tindakan berhasil ditambahkan');

			}else{

				Flashy::success('Tindakan gagal ditambahkan');

			}	

		}

		$update = Operasi::where('registrasi_id',$request['registrasi_id'])->update(['status_proses'=>null]);

		return redirect('operasi/tindakan/'.$request['registrasi_id']);

	}

	

	public function Ppi(Request $request){

		if($request['registrasi_id']!=''){

			$update = Operasi::where('registrasi_id',$request['registrasi_id'])->update(['ppi'=>$request['ppi']]);

		}

	}

	

	public function simpanOrderOperasi(Request $request){

		$request->validate(['rencana_operasi' => 'required', 'jam_operasi' => 'required', 'suspect' => 'required']);



		$ibs = new Operasi();

		$ibs->registrasi_id = $request['registrasi_id'];

		$ibs->rawatinap_id = $request['rawatinap_id'];

		$ibs->no_rm = $request['no_rm'];

		$ibs->rencana_operasi = valid_date($request['rencana_operasi']);

		$ibs->jam_operasi = $request['jam_operasi'];

		$ibs->suspect = $request['suspect'];

		$ibs->ppi = 'Bersih';

		$ibs->suhu_tubuh = $request->suhu_tubuh;

		$ibs->tensi = $request->tensi;

		$ibs->tinggi = $request->tinggi;

		$ibs->berat = $request->berat;

		$ibs->nadi = $request->nadi;

		$ibs->respirasi = $request->respirasi;

		$ibs->GCS = $request->gcs;

		$ibs->penilaian = $request->penilaian;

		$ibs->tindak_lanjut = $request->tindak_lanjut;

		$ibs->save();

		$reg = Registrasi::where('id',$request['registrasi_id'])->first();

				if($request->tensi==null){



				}else{

					$reg->tekanan_darah	 		= $request->tensi;

				}

				if($request->berat==null){



				}else{

					$reg->berat_badan		= $request->berat;

				}

				$reg->update();

		Flashy::success('IBS berhasil disimpan');

		return redirect('rawat-inap/billing');

	}

	

	public function hapusJenisOrder($id,$reg_id){

		$del = DataOrderOperasi::where('id',$id)->delete();

		if($del){

			Flashy::success('Tindakan berhasil dihapus');

		}else{

			Flashy::success('Tindakan gagal dihapus');

		}

		return redirect(url()->previous());

		//return redirect('rawat-inap/ibs/'.$reg_id);

	}

	

	public function selesai($reg_id){

		$order = Operasi::where('registrasi_id',$reg_id)->first();

		if($order!=null){

			$order->status_proses = 1;

			$order->update();

		}

		$all_folio = Folio::where('registrasi_id',$reg_id)->where('status_proses',null)->get();

		if($all_folio!=null){

			foreach($all_folio as $key => $data){

				$cek_tarif = Tarif::where('id',$data->tarif_id)->where('kategoritarif_id', 4)->first();

				if($cek_tarif!=null){

					Folio::where('id',$data->id)->update(['status_proses'=>1]);

				}

			}

		}

		$update = DataOrderOperasi::where('registrasi_id',$reg_id)->update(['status_proses'=>1]);

		Flashy::success('Data operasi berhasil disimpan');

		session()->forget(['dokter_anestesi', 'dokter_bedah', 'operator', 'perawat_ibs1', 'perawat_ibs2', 'perawat_ibs3', 'perawat_ibs4']);

		return redirect('/operasi/antrian');

	}

	

	public function gettarif($kat_id){

			$tarif = Tarif::where('kategoritarif_id', $kat_id)->pluck('nama', 'id');

			return json_encode($tarif);

	}



	public function laporankamaroperasi()

	{

		return view('operasi.laporankamaroperasi');

	}

	public function laporankamaroperasi_byrequest(Request $request)

	{	

		

		$data['config'] = Config::find(1);

		request()->validate(['tga'=>'required', 'tgb'=>'required']);

		

		$list_pasien = Operasi::whereBetween('operasis.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

		->join('registrasis', 'registrasis.id', '=', 'operasis.registrasi_id')

		->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')

		->select('pasiens.nama as nama_pasien','registrasis.*','operasis.*')

		//->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])

		->get();

		if ($request['lanjut']) {

			return view('operasi.laporankamaroperasi', compact('list_pasien'))->with('no', 1);

		}elseif ($request['pdf']) {

			$no=1;
			$periode = tanggalkuitansi($request['tga']).' s/d '.tanggalkuitansi($request['tgb']);

			$pdf = PDF::loadView('operasi.pdflaporan_operasi',compact('list_pasien','periode'), $data);

    		return $pdf->stream();

			}

	}

	public function detail_operasi_pasien()

	{	$data['config'] = Config::find(1);

		$data['reg'] 	= Registrasi::join('pasiens','pasiens.id','=','registrasis.pasien_id')

						  ->where('registrasis.id', '106')->select('pasiens.nama as nama_pasien','pasiens.tgllahir','pasiens.no_rm','pasiens.kelamin')->first();

		

		$data['op'] 	= Operasi::where('registrasi_id', '106')->first();

		$data['kamar'] 	= Rawatinap::join('kamars','kamars.id','=','rawatinaps.kamar_id')->where('registrasi_id', '106')->first();

		return view('operasi.pdfdetail_operasi_pasien',$data)->with('no', 1);

		if ($request['pdf']) {

			$no=1;

            $pdf = PDF::loadView('operasi.pdfdetail_operasi_pasien', $data);

			$pdf->setPaper('F5', 'portrait');

		

            return $pdf->download('laporan operasi '.$data['reg']->nama_pasien.' .pdf');

		}

	}

	public function detail_operasi_pasienpdf($id)

	{	$data['config'] = Config::find(1);

		$data['reg'] 	= Registrasi::join('pasiens','pasiens.id','=','registrasis.pasien_id')

						  ->where('registrasis.id', $id)->select('pasiens.nama as nama_pasien','pasiens.tgllahir','pasiens.no_rm','pasiens.kelamin')->first();

		

		$data['op'] 	= Operasi::where('registrasi_id', $id)->first();

		$data['kamar'] 	= Rawatinap::join('kamars','kamars.id','=','rawatinaps.kamar_id')->where('registrasi_id', $id)->first();

		$no=1;

		$pdf = PDF::loadView('operasi.pdfdetail_operasi_pasien', $data);

    	return $pdf->stream();

		//return $id;

	}

}

