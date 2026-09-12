<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Registrasi;
use App\Hasilradiologi;
use Modules\Registrasi\Entities\Folio;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Tarif\Entities\Tarif;
use App\KondisiAkhirPasien;
use Modules\Registrasi\Entities\HistoriStatus;
use App\DataOrderRadiologi;
use App\Orderradiologi;
use App\Foliopelaksana;
use App\HistorikunjunganRAD;
use App\Pasienlangsung;
use App\Penjualan;
use App\TindakanRadiologi;
use App\Mastermappingbiaya;
use Flashy;
// use Activity;
use Auth;
use Excel;
use PDF;
use DB;

class RadiologiController extends Controller
{
	/* 
	public function tindakanIRJ()
	{
			session()->forget(['dokter', 'pelaksana', 'perawat']);
			$data['registrasi'] = Registrasi::join('order_radiologi', 'registrasis.id', '=', 'order_radiologi.registrasi_id')
														->select('registrasis.*')
														->where('registrasis.pulang',null)
														->where('registrasis.status_reg', 'like', 'J%')->get();
			return view('radiologi.tindakanIRJ', $data)->with('no', 1);
	}

	public function tindakanIRJByTanggal(Request $request)
	{
		request()->validate(['tga'=>'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['registrasi'] 	= 	Registrasi::join('order_radiologi', 'registrasis.id', '=', 'order_radiologi.registrasi_id')
														->select('registrasis.*')
														->where('registrasis.pulang',null)
														->where('registrasis.status_reg', 'like', 'J%')
														->whereBetween('registrasis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])->get();
		return view('radiologi.tindakanIRJ', $data)->with('no', 1);
	}

	public function tindakanIRD()
	{
			session()->forget(['dokter', 'pelaksana', 'perawat']);
			$data['registrasi'] = Registrasi::join('order_radiologi', 'registrasis.id', '=', 'order_radiologi.registrasi_id')
														->select('registrasis.*')
														->where('registrasis.pulang',null)
														->where('registrasis.status_reg', 'like', 'G%')->get();
			return view('radiologi.tindakanIRD', $data)->with('no', 1);
	}

	public function tindakanIRDByTanggal(Request $request)
	{
		request()->validate(['tga'=>'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['registrasi'] = Registrasi::join('order_radiologi', 'registrasis.id', '=', 'order_radiologi.registrasi_id')
													->select('registrasis.*')
													->where('registrasis.pulang',null)
													->where('registrasis.status_reg', 'like', 'G%')
													->whereBetween('registrasis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])->get();
		return view('radiologi.tindakanIRD', $data)->with('no', 1);
	}

	public function tindakanIRNA()
	{
			session()->forget(['dokter', 'pelaksana', 'perawat']);
			$data['registrasi'] =	Registrasi::join('order_radiologi', 'registrasis.id', '=', 'order_radiologi.registrasi_id')
														->select('registrasis.*')
														->where('registrasis.pulang',null)
														->whereIn('registrasis.status_reg', ['I1', 'I2'])->get();
			return view('radiologi.tindakanIRNA', $data)->with('no', 1);
	}

	public function tindakanIRNAByTanggal(Request $request)
	{
		request()->validate(['tga'=>'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['registrasi'] =	Registrasi::join('order_radiologi', 'registrasis.id', '=', 'order_radiologi.registrasi_id')
													->select('registrasis.*')
													->where('registrasis.pulang',null)
													->whereIn('registrasis.status_reg', ['I1', 'I2'])
													->whereBetween('registrasis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])->get();
	return view('radiologi.tindakanIRNA', $data)->with('no', 1);
	}
	 */

	public function tindakan_pasien()
	{
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$poli	= Poli::where('nama','Klinik Radiologi')->first();
		$data['registrasi'] = Registrasi::join('order_radiologi', 'registrasis.id', '=', 'order_radiologi.registrasi_id')
													->select('registrasis.*','order_radiologi.status_proses')
													->where('registrasis.pulang',null)
													->orderBy('order_radiologi.status_proses','ASC')
													->groupBy('registrasis.id')
													->get();
		return view('radiologi.tindakanPasien', $data)->with('no', 1);
	}
	
	public function insertKunjungan($registrasi_id, $pasien_id)
	{
		$reg = Registrasi::find($registrasi_id);
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
		return redirect('radiologi/entry-tindakan/'. $registrasi_id.'/'.$pasien_id);
	}
	
	public function entryTindakan($idreg, $idpasien)
	{
		$data['depo']			= strtolower(Auth::user()->role()->first()->name);
		$data['folio'] 		= Folio::join('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
														->where('registrasi_id', $idreg)
														->whereNotIn('folios.jenis', ['PEM'])
														->select('folios.*', 'foliopelaksanas.dokter_radiologi','foliopelaksanas.radiografer')
														->where('poli_tipe', 'R')->get();
		$data['pasien'] 	= Pasien::find($idpasien);
		$data['reg_id'] 	= $idreg;
		$data['jenis'] 		= Registrasi::where('id', '=', $idreg)->first();
		if(strtolower(Auth::user()->role()->first()->name)=='radiologi'){			
			$data['tindakanradiologi'] 	= TindakanRadiologi::join('mastermapping_biaya', 'mastermapping_biaya.tindakan_radiologi_id', '=', 'tindakan_radiologi.id')
															->select('mastermapping_biaya.id','mastermapping_biaya.kelompok','mastermapping_biaya.tindakan_radiologi_id')
															->get();
		}
		$data['poli'] 		= Folio::where('registrasi_id', '=', $idreg)->distinct();
		$data['tagihan'] 	= Folio::where('registrasi_id',$idreg)->where('poli_tipe', 'R')->where('lunas', 'N')->sum('total');
		$data['dokter'] 	= Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['radiografer']	= Pegawai::whereIn('kategori_pegawai', [5])->pluck('nama', 'id');
		$data['detil_order']= DataOrderRadiologi::where('registrasi_id',$idreg)->get();
		$data['order'] 		= Orderradiologi::where('registrasi_id', $idreg)->get();

		$jenis = $data['jenis']->status_reg;
		$data['tindakan'] = Tarif::where('kategoritarif_id', 3)->get();
		return view  ('radiologi.entryTindakanRadiologi', $data)->with('no', 1)->with('idreg', $idreg);
	}
	
	public function updatePelaksana(Request $request)
	{
		$folio = Folio::where('registrasi_id',$request['registrasi_id'])->where('poli_tipe','R')->get();
		if($folio!=null){
			foreach($folio as $key => $data){
				$update = Foliopelaksana::where('folio_id',$data->id)->first();
				if($update->radiografer==null){
					$update->radiografer = $request['radiografer'];
					$update->update();
				}
			}
		}
	}
	
	public function selesai($reg_id)
	{
		$reg = Registrasi::find($reg_id);
		$cek_folio = Folio::where('registrasi_id',$reg_id)->where('poli_tipe','R')->get();
		if($cek_folio!=null){
			foreach($cek_folio as $key => $dt){
				$cek_pelaksana = Foliopelaksana::where('folio_id',$dt->id)->where('radiografer',null)->first();
				if($cek_pelaksana!=null){
					Flashy::error('Silahkan lengkapi pelaksana yang masih kosong');
					return back();
				}
			}
		}
		
		$order = Orderradiologi::where('registrasi_id',$reg_id)->first();
		if($order!=null){
			Orderradiologi::where('registrasi_id',$reg_id)->update(['status_proses'=>1]);
		}
		$folio = Folio::where('registrasi_id',$reg_id)->where('status_proses',null)->where('poli_tipe','R')->update(['status_proses'=>1]);
		DataOrderRadiologi::where('registrasi_id',$reg_id)->update(['status_proses'=>1]);
		
		if($reg->dokter_id==0){
			$reg->status_reg = 'J2';
			$reg->posisi_pasien = 'selesai diperiksa';
			if($reg->update()){
				Flashy::success('Pasien selesai diperiksa, perintahkan pasien untuk mengambil antrian di depan apotek untuk melakukan pembayaran di kasir');
			}else{
				Flashy::warning('Data gagal disimpan');
				return back();
			}
		}else{
			Flashy::success('Pasien selesai diperiksa');
		}
		return redirect('/radiologi/tindakan-pasien');
	}
	
	public function simpanOrder(Request $request)
	{
		if($request['tindakan_radiologi']!=''){
			$order = new DataOrderRadiologi();
			$order->registrasi_id = $request['registrasi_id'];
			$order->user_id = Auth::user()->id;
			$order->mastermapping_biaya_id = $request['tindakan_radiologi'];
			$order->id_tindakan_radiologi = Mastermappingbiaya::find($request['tindakan_radiologi'])->tindakan_radiologi_id;
			if($order->save()){
				Flashy::success('Tindakan berhasil ditambahkan');
			}else{
				Flashy::success('Tindakan gagal ditambahkan');
			}
		}
		$update = Orderradiologi::where('registrasi_id',$request['registrasi_id'])->update(['status_proses'=>null]);
		$registrasi = Registrasi::find($request['registrasi_id']);
		if($registrasi->dokter_id==0 OR strtolower(Auth::user()->role()->first()->name)=='radiologi'){
			return redirect('radiologi/entry-tindakan/'.$registrasi->id.'/'.$registrasi->pasien_id);
		}elseif(isset($request['ranap_rad'])){				
			return redirect('tindakan/order/radiologi/irna/'.$request['registrasi_id']);
		}elseif(isset($request['rajal_rad'])){				
			return redirect('tindakan/order/radiologi/irj/'.$request['registrasi_id']);
		}elseif(isset($request['darurat_rad'])){				
			return redirect('tindakan/order/radiologi/darurat/'.$request['registrasi_id']);
		}
	}
	
	/* 
	public function entryTindakanIRNA($idreg, $idpasien)
	{
		$data['depo']		= strtolower(Auth::user()->role()->first()->name);
		$data['folio'] 		= Folio::join('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
														->where('registrasi_id', $idreg)
														->whereNotIn('folios.jenis', ['PEM'])
														->select('folios.*', 'foliopelaksanas.dokter_radiologi','foliopelaksanas.radiografer')
														->where('poli_id', 27)->get();
		$data['pasien'] 	= Pasien::find($idpasien);
		$data['reg_id'] 	= $idreg;
		$data['jenis'] 		= Registrasi::where('id', '=', $idreg)->first();
		$data['poli'] 		= Folio::where('registrasi_id', '=', $idreg)->distinct();
		$data['tagihan'] 	= Folio::where('registrasi_id',$idreg)->where('poli_id', 27)->where('lunas', 'N')->sum('total');
		$data['dokter'] 	= Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['perawat']	= Pegawai::whereNotIn('kategori_pegawai', [1])->pluck('nama', 'id');
		$data['kat_tarif'] 	= Kategoritarif::select('namatarif', 'id')->get();

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
	
		// PEMAKAIAN OBAT
		$data['penjualan'] 	= Penjualan::where('registrasi_id' ,$idreg)->first();

		$data['opt_poli'] = Poli::where('politype', 'R')->get();
		//$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		return view  ('radiologi.entryTindakanRadiologiIRNA', $data)->with('no', 1)->with('idreg', $idreg);
	}

	public function entryTindakanIRJ($idreg, $idpasien)
	{
		$data['depo']		= strtolower(Auth::user()->role()->first()->name);
		$data['folio'] 		= Folio::join('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
						->where('folios.registrasi_id', $idreg)
						->whereNotIn('folios.jenis', ['PEM'])
						->select('folios.*', 'foliopelaksanas.dokter_radiologi', 'foliopelaksanas.radiografer')
						->where('poli_id', 27)->get();
		$data['pasien'] 	= Pasien::find($idpasien);
		$data['reg_id'] 	= $idreg;
		$data['jenis'] 		= Registrasi::where('id', '=', $idreg)->first();
		$data['poli'] 		= Folio::where('registrasi_id', '=', $idreg)->distinct();
		$data['tagihan'] 	= Folio::where('registrasi_id',$idreg)->where('poli_id', 27)->where('lunas', 'N')->sum('total');
		$data['dokter'] 	= Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['perawat']	= Pegawai::whereNotIn('kategori_pegawai', [1])->pluck('nama', 'id');
		$data['kat_tarif'] 	= Kategoritarif::select('namatarif', 'id')->get();

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
		// PEMAKAIAN OBAT
		$data['penjualan'] 	= Penjualan::where('registrasi_id' ,$idreg)->first();

		$data['opt_poli'] = Poli::where('politype', 'R')->get();
		//$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		return view  ('radiologi.entryTindakanRadiologi', $data)->with('no', 1)->with('idreg', $idreg);
	}
	 */

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
		//Update status registrasi
		if(substr($reg->status_reg,0,1) == 'G'){
			$fol->jenis      = "TG";
			$reg->status_reg = 'G2';
		}elseif (substr($reg->status_reg,0,1) == 'I') {
			$fol->jenis      = "TI";
			$reg->status_reg = 'I2';
		}elseif (substr($reg->status_reg,0,1) == 'R') {
			$fol->jenis      = "TA";
			$reg->status_reg = 'R1';
		}else{
			$fol->jenis      = "TA";
			$reg->status_reg = 'J2';
		}
		$fol->cara_bayar_id = $reg->bayar;
		$fol->poli_tipe     = 'R';
		$fol->total         = (getTotalTarif($reg,$tarif) * $request['jumlah']);
		$fol->jenis_pasien  = $request['jenis'];
		$fol->pasien_id     = $request['pasien_id'];
		$fol->dokter_id     = $request['dokter_id'];
		$fol->user_id       = Auth::user()->id;
		$fol->poli_id       = $request['poli_id'];
		if (!empty($request['tanggal'])) {
			$fol->created_at = valid_date($request['tanggal']);
		}
		$fol->save();

		//INSERT FOLIO PELAKSANA
		$fp = new Foliopelaksana();
		$fp->folio_id = $fol->id;
		$fp->dpjp = $reg->dokter_id;
		$fp->dokter_radiologi = $request['dokter_radiologi'];
		$fp->radiografer = $request['radiografer'];
		if(substr($reg->status_reg,0,1) == 'G'){
			$fp->pelaksana_tipe = 'TG';
		}elseif (substr($reg->status_reg,0,1) == 'I') {
			$fp->pelaksana_tipe = 'TI';
		}else{
			$fp->pelaksana_tipe = 'TA';
		}
		$fp->user = Auth::user()->id;
		$fp->save();		
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
		if(isset($request['ranap_rad'])){				
			return redirect('tindakan/order/radiologi/irna/'.$request['registrasi_id']);
		}elseif(isset($request['rajal_rad'])){				
			return redirect('tindakan/order/radiologi/irj/'.$request['registrasi_id']);
		}elseif(isset($request['darurat_rad'])){				
			return redirect('tindakan/order/radiologi/darurat/'.$request['registrasi_id']);
		}else {
			return redirect('radiologi/entry-tindakan/'.$request['registrasi_id'].'/'.$request['pasien_id']);
		}
	}

	public function hapusTindakan($id, $idreg, $pasien_id, $order='')
	{
		if(Auth::user()->hasRole(['supervisor', 'radiologi','administrator','rawatinap','rawatjalan','rawatdarurat'])){
			if(Folio::where('id',$id)->where('lunas', 'N')->delete()){
				Foliopelaksana::where('folio_id',$id)->delete();
			}
		}
		$reg = Registrasi::find($idreg);
		if($order=='rawat-inap'){
			return redirect('tindakan/order/radiologi/irna/'.$idreg);
		}elseif($order=='rawat-jalan'){
			return redirect('tindakan/order/radiologi/irj/'.$idreg);
		}elseif($order=='darurat'){
			return redirect('tindakan/order/radiologi/darurat/'.$idreg);
		}else{
			return redirect('radiologi/entry-tindakan/'.$idreg.'/'.$pasien_id);
		}
	}
	
	public function hapusJenisOrder($id,$reg_id)
	{
		$del = DataOrderRadiologi::where('id',$id)->delete();
		if($del){
			Flashy::success('Tindakan berhasil dihapus');
		}else{
			Flashy::error('Tindakan gagal dihapus');
		}
		$registrasi = Registrasi::find($reg_id);
		if($registrasi->dokter_id==0 OR strtolower(Auth::user()->role()->first()->name)=='radiologi'){
			return redirect('radiologi/entry-tindakan/'.$registrasi->id.'/'.$registrasi->pasien_id);
		}elseif(strtolower(Auth::user()->role()->first()->name)=='rawatinap'){
			return redirect('tindakan/order/radiologi/irna/'.$reg_id);
		}elseif(strtolower(Auth::user()->role()->first()->name)=='rawatjalan'){
			return redirect('tindakan/order/radiologi/irj/'.$reg_id);
		}elseif(strtolower(Auth::user()->role()->first()->name)=='rawatdarurat'){
			return redirect('tindakan/order/radiologi/darurat/'.$reg_id);
		}
	}

	public function hasilRadiologi($id){
		$data['reg'] 			= Registrasi::find($id);
		//var_dump($data['reg']); exit;
		$data['dokter']		= Pegawai::where('kategori_pegawai', 1)->where('nama', 'LIKE', '%SP.RAD')->pluck('nama', 'id');
		$data['order_radiologi_data'] 	= DataOrderRadiologi::where('registrasi_id',$id)->get();
		if($data['order_radiologi_data']->count()==0){
			return redirect(url()->previous());
		}else{
			foreach($data['order_radiologi_data'] as $key => $datax){
				$gtdr = DataOrderRadiologi::find($datax->id);
				if($gtdr->no_foto==null){
					$max_no_foto 	= DataOrderRadiologi::max('no_foto');
					if($max_no_foto==null){
						$max_no_foto = 1000;
					}else{
						$max_no_foto++;
					}
					$gtdr->no_foto = $max_no_foto;
					$gtdr->save();
				}
			}
			return view('radiologi.hasil_radiologi', $data);
		}
	}
	
	public function simpanHasilRadiologi(Request $request){
		$dataorder 	= DataOrderRadiologi::where('registrasi_id',$request['registrasi_id'])->get();
		if($dataorder!=null){
			foreach($dataorder as $key => $data){
				//echo $request['data_order_id'.$data->id];
				$hasil = Hasilradiologi::where('data_order_radiologi_id',$request['data_order_id'.$data->id])->first();
				if($hasil==null){
					$hasil = new Hasilradiologi;
				}
				$hasil->registrasi_id 					= $request['registrasi_id'];
				$hasil->data_order_radiologi_id = $request['data_order_id'.$data->id];
				if($request['dokter_radiologi'.$data->id]==""){
					$hasil->dokter_id 							= 0;
				}else{
					$hasil->dokter_id 							= $request['dokter_radiologi'.$data->id];
				}
				$hasil->hasil_pemeriksaan				= $request['hasil_radiologi'.$data->id];
				$hasil->kesan 									= $request['kesan_radiologi'.$data->id];
				$hasil->updated_by 							= Auth::user()->name;
				$hasil->created_at 							= date('Y-m-d H:i:s');
				$hasil->save();
			}
		}
		//exit;
		Flashy::success('Hasil radiologi berhasil disimpan');
		return redirect(url()->previous());
	}
	
	public function cetakHasilRadiologi($tipe='',$id=''){
		$data['reg'] = Registrasi::find($id);
		$data['order_radiologi_data'] 	= DataOrderRadiologi::where('registrasi_id',$id)->get();
		if($data['order_radiologi_data']!=null){
			return view('radiologi.cetak_radiologi', $data);
			/* $pdf = PDF::loadView('radiologi.cetak_radiologi', $data);
			return $pdf->stream(); */
		}
	}

	public function cetakHasilRadiologipasien($id=''){
		$data['reg'] = Registrasi::find($id);
		$data['order_radiologi_data'] 	= DataOrderRadiologi::where('registrasi_id',$id)->get();
		if($data['order_radiologi_data']!=null){
			return view('radiologi.cetak_radiologi', $data);
			/* $pdf = PDF::loadView('radiologi.cetak_radiologi', $data);
			return $pdf->stream(); */
		}
	}
	
	public function lap_kunjungan()
	{
		$data['kunjungan'] = NULL;
		return view('radiologi.lap_kunjungan', $data);
	}

	public function lap_kunjungan_by_request(Request $request)
	{
		request()->validate(['tga'=>'required', 'tgb'=>'required']);
		$data['kunjungan'] = HistorikunjunganRAD::where('pasien_asal', $request['pasien_asal'])->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
		$data['pasien_asal'] = $request['pasien_asal'];
		if ($request['view']) {
			return view('radiologi.lap_kunjungan', $data)->with('no', 1);
		} elseif ($request['excel']) {
				$datareg = $data['kunjungan'];
				if ($request['pasien_asal'] == 'TI') {
					$judul = 'IRNA';
				} elseif ($request['pasien_asal'] == 'TA') {
					$judul = 'IRJ';
				} elseif ($request['pasien_asal'] == 'TG') {
					$judul = 'IGD';
				}
				Excel::create('Lap Kunjungan Radiologi '.$judul, function ($excel) use ($datareg, $judul) {
				// Set the properties
				$excel->setTitle('Lap Kunjungan Radiologi '.$judul)
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Lap Kunjungan Radiologi '.$judul);
				$excel->sheet('Lap Kunjungan Radiologi '.$judul, function ($sheet) use ($datareg) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No',
						'Nama',
						'No. RM',
						'Umur',
						'L/P',
						'KLinik Asal',
						'Dokter',
						'Tanggal Kunjungan',
					]);
					foreach ($datareg as $key => $d) {
						$reg = Registrasi::find($d->registrasi_id);
						$pasien = Pasien::find($d->pasien_id);
						$sheet->row(++$row, [
							$no++,
							$pasien ? $pasien->nama : 'Pasien dari luar',
							$pasien ? $pasien->no_rm : NULL,
							$pasien ? hitung_umur($pasien->tgllahir, 'Y') : NULL,
							$pasien ? $pasien->kelamin : NULL,
							!empty($d->poli_id) ? baca_poli($d->poli_id) : NULL,
							!empty($reg->dokter_id) ? baca_dokter($reg->dokter_id) : NULL,
							tanggal($d->created_at),
						]);
					}
				});
			})->export('xlsx');
		}
		
	}

	/* 
	//TRANSAKSI LANGSUNG
	public function transaksiLangsung()
	{
		$data = Pasienlangsung::where('created_at', 'like', date('Y-m-d').'%')->where('politype', 'R')->get();
		return view('radiologi.transaksiLangsung', compact('data'))->with('no', 1);
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
														->select('folios.*', 'foliopelaksanas.dokter_radiologi', 'foliopelaksanas.radiografer')
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
			return view  ('radiologi.entryTindakanLangsung', $data)->with('no', 1); 
	}
	 */
}
