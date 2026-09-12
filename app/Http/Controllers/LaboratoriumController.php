<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Laboratorium;
use Modules\Config\Entities\Config;
use App\Labkategori;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Dokter;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Registrasi\Entities\Folio;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Tarif\Entities\Tarif;
use App\KondisiAkhirPasien;
use Modules\Registrasi\Entities\HistoriStatus;
use App\HistorikunjunganLAB;
use App\Foliopelaksana;
use App\Orderlab;
use App\Pasienlangsung;
use App\Penjualan;
use App\Mastermappingbiaya;
use Excel;
use Auth;
use PDF;
use Flashy;
use DB;
use App\RincianHasillab;
class LaboratoriumController extends Controller
{
	public function index()
	{
		$data = Laboratorium::all();
		return view('laboratorium.lab.index',compact('data'))->with('no', 1);
	}

	public function create()
	{
		$data['group'] = Mastermappingbiaya::where('kategoritarif_id',2)->pluck('kelompok', 'id');
		return view('laboratorium.lab.create', $data);
	}

	public function store(Request $request)
	{
		$data = request()->validate([
			'tarif_id' => 'required',
			'nilairujukanbawah' => ' sometimes',
			'nilairujukanatas' => 'sometimes',
			'nilairujukanbawahwanita' => ' sometimes',
			'nilairujukanataswanita' => 'sometimes',
			'nilairujukanbawahanak' => ' sometimes',
			'nilairujukanatasanak' => 'sometimes',
			'satuan' => 'sometimes',
			'labkategori_id' => 'sometimes',
			'keterangan' => 'sometimes'
		]);
		if(Laboratorium::create($data)){
			Flashy::success('Data berhasil disimpan');
		}else{
			Flashy::error('Data gagal disimpan');
		}
		return redirect('lab');
	}

	public function show($id)
	{
			//
	}

	public function edit($id)
	{
		$data['lab'] = Laboratorium::find($id);			
		$data['group'] = Mastermappingbiaya::where('kategoritarif_id',2)->pluck('kelompok', 'id');
		return view('laboratorium.lab.edit',$data);
	}

	public function update(Request $request, $id)
	{
		$data = request()->validate([
			'tarif_id' => 'required',
			'nilairujukanbawah' => ' sometimes',
			'nilairujukanatas' => 'sometimes',
			'nilairujukanbawahwanita' => ' sometimes',
			'nilairujukanataswanita' => 'sometimes',
			'nilairujukanbawahanak' => ' sometimes',
			'nilairujukanatasanak' => 'sometimes',
			'satuan' => 'sometimes',
			'labkategori_id' => 'sometimes',
			'keterangan' => 'sometimes'
		]);
		if(Laboratorium::find($id)->update($data)){
			Flashy::success('Data berhasil disimpan');
			return redirect('lab');
		}else{
			Flashy::error('Data gagal disimpan');
			return redirect('lab/edit/'.$id);
		}
	}

	public function destroy($id)
	{
			//
	}

	public function tindakan_pasien()
	{
		session()->forget('jenis');
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['registrasi']	= Registrasi::join('order_lab', 'registrasis.id', '=', 'order_lab.registrasi_id')
														->select('registrasis.*','order_lab.status_proses')
														->orderBy('order_lab.status_proses','ASC')
														->groupBy('registrasis.id')
														->get();
													
		return view('laboratorium.tindakanPasien', $data)->with('no', 1);
	}
	
	/* 
	public function tindakanIRJ()
	{
		session()->forget('jenis');
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['registrasi'] = Registrasi::join('order_lab', 'registrasis.id', '=', 'order_lab.registrasi_id')
													->select('registrasis.*')
													->where('registrasis.pulang',null)
													->where('registrasis.status_reg', 'like', 'J%')->get();
		return view('laboratorium.tindakanIRJ', $data)->with('no', 1);
	}

	public function tindakanIRJByTanggal(Request $request)
	{
		request()->validate(['tga'=>'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['registrasi'] 	= 	Registrasi::join('order_lab', 'registrasis.id', '=', 'order_lab.registrasi_id')
														->select('registrasis.*')
														->where('registrasis.pulang',null)
														->where('registrasis.status_reg', 'like', 'J%')->whereBetween('registrasis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])->get();
		return view('laboratorium.tindakanIRJ', $data)->with('no', 1);
	}

	public function tindakanIRD()
	{
			session()->forget(['dokter', 'pelaksana', 'perawat']);
			$data['registrasi'] = Registrasi::join('order_lab', 'registrasis.id', '=', 'order_lab.registrasi_id')
														->select('registrasis.*')
														->where('registrasis.pulang',null)
														->where('registrasis.status_reg', 'like', 'G%')->get();
			return view('laboratorium.tindakanIRD', $data)->with('no', 1);
	}

	public function tindakanIRDByTanggal(Request $request)
	{
		request()->validate(['tga'=>'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['registrasi'] 	= 	Registrasi::join('order_lab', 'registrasis.id', '=', 'order_lab.registrasi_id')
														->select('registrasis.*')
														->where('registrasis.pulang',null)
														->where('registrasis.status_reg', 'like', 'G%')->whereBetween('registrasis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])->get();
		return view('laboratorium.tindakanIRD', $data)->with('no', 1);
	}

	public function tindakanIRNA()
	{
	session()->forget(['dokter', 'pelaksana', 'perawat']);
	$data['registrasi'] 	= 	Registrasi::join('order_lab', 'registrasis.id', '=', 'order_lab.registrasi_id')
														->select('registrasis.*')
														->where('registrasis.pulang',null)
														->where('registrasis.status_reg', 'I2')->get();
	return view('laboratorium.tindakanIRNA', $data)->with('no', 1);
	}

	public function tindakanIRNAByTanggal(Request $request)
	{
		request()->validate(['tga'=>'required']);
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['registrasi'] 	= 	Registrasi::join('order_lab', 'registrasis.id', '=', 'order_lab.registrasi_id')
														->select('registrasis.*')
														->where('registrasis.pulang',null)
														->where('registrasis.status_reg', 'like', 'I2')->whereBetween('registrasis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])->get();
		return view('laboratorium.tindakanIRNA', $data)->with('no', 1);
	}
	 */
	
	//Insert ke Histori Kunjungan
	public function insertKunjungan($registrasi_id, $pasien_id)
	{
		$reg = Registrasi::find($registrasi_id);
		$kl = new HistorikunjunganLAB();
		$kl->registrasi_id = $registrasi_id;
		$kl->pasien_id = $pasien_id;
		$kl->poli_id = $reg->poli_id;
		if(substr($reg->status_reg,0,1) == 'J') {
			$kl->pasien_asal = 'TA';
		} elseif (substr($reg->status_reg,0,1) == 'G') {
			$kl->pasien_asal = 'TG';
		} elseif (substr($reg->status_reg,0,1) == 'I') {
			$kl->pasien_asal = 'TI';
		}
		$kl->user = Auth::user()->name;
		$kl->save();
		return redirect('laboratorium/entry-tindakan/'. $registrasi_id.'/'.$pasien_id);
	}
	
	public function entryTindakan($idreg, $idpasien)
	{
		$data['depo']			= strtolower(Auth::user()->role()->first()->name);
		$data['folio']		= Folio::leftJoin('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
													->where('folios.registrasi_id', $idreg)
													->where('folios.poli_tipe', 'L')
													->whereNotIn('folios.jenis', ['PEM'])
													->select('folios.*', 'foliopelaksanas.dokter_lab','foliopelaksanas.analis_lab')
													->get();
		$data['pasien'] 	= Pasien::find($idpasien);
		$data['reg_id'] 	= $idreg;
		$data['jenis'] 		= Registrasi::where('id', '=', $idreg)->first();
		$data['tagihan'] 	= Folio::leftJoin('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
														->where('folios.registrasi_id', $idreg)
														->where('folios.poli_tipe', 'L')
														->whereNotIn('folios.jenis', ['PEM'])
														->where('lunas', 'N')->sum('total');
		if(strtolower(Auth::user()->role()->first()->name)=='laboratorium'){
			$data['analis_lab']	= Pegawai::whereIn('kategori_pegawai', [4])->pluck('nama', 'id');
		}else{
			$data['analis_lab']	= Pegawai::whereIn('kategori_pegawai', [2,4])->pluck('nama', 'id');
		}
		$pemakaian					= Folio::where('registrasi_id', $idreg)->where('jenis','PEM')->first();
		$data['orderlab']		= Orderlab::where('registrasi_id', $idreg)->first();
		session(['total_obat'=>0]);
		if($pemakaian!=null){
			session(['total_obat'=>$pemakaian->total]);
		}
		$jenis = $data['jenis']->status_reg;
		$data['tindakan'] = Tarif::where('kategoritarif_id', 2)->get();	
		return view  ('laboratorium.entryTindakanLaboratorium', $data)->with('no', 1)->with('idreg', $idreg);
	}
	
	public function updatePelaksana(Request $request)
	{
		$folio = Folio::where('registrasi_id',$request['registrasi_id'])->where('poli_tipe','L')->get();
		if($folio!=null){
			foreach($folio as $key => $data){
				$update = Foliopelaksana::where('folio_id',$data->id)->first();
				if($update->analis_lab==null){
					$update->analis_lab = $request['analis_lab'];
					$update->update();
				}
			}
		}
	}
	
	public function selesai($reg_id)
	{
		$reg = Registrasi::find($reg_id);
		$cek_folio = Folio::where('registrasi_id',$reg_id)->where('poli_tipe','L')->get();
		if($cek_folio!=null){
			foreach($cek_folio as $key => $dt){
				$cek_pelaksana = Foliopelaksana::where('folio_id',$dt->id)->where('analis_lab',null)->first();
				if($cek_pelaksana!=null){
					Flashy::error('Silahkan lengkapi pelaksana yang masih kosong');
					return back();
				}
			}
		}
		
		$order = Orderlab::where('registrasi_id',$reg_id)->get();
		if($order!=null){
			Orderlab::where('registrasi_id',$reg_id)->update(['status_proses'=>1]);
		}
		Folio::where('registrasi_id',$reg_id)->where('status_proses',null)->where('poli_tipe','L')->update(['status_proses'=>1]);
		
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
		return redirect('/laboratorium/tindakan-pasien');
	}
	
	/* 
	public function entryTindakanIRNA($idreg, $idpasien)
	{
		$data['depo']		= strtolower(Auth::user()->role()->first()->name);
		$data['folio']		= Folio::leftJoin('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
													->where('folios.registrasi_id', $idreg)
													->where('folios.jenis', 'TI')
													->whereIn('folios.poli_id', [26,30])
													->whereNotIn('folios.jenis', ['PEM'])
													->select('folios.*', 'foliopelaksanas.dokter_lab','foliopelaksanas.analis_lab')
													->get();
		$data['pasien'] 	= Pasien::find($idpasien);
		$data['reg_id'] 	= $idreg;
		$data['jenis'] 		= Registrasi::where('id', '=', $idreg)->first();
		$data['poli'] 		= Folio::where('registrasi_id', '=', $idreg)->distinct();
		$data['tagihan'] 	= Folio::leftJoin('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
														->where('folios.registrasi_id', $idreg)
														->where('folios.jenis', 'TI')
														->whereIn('folios.poli_id', [26,30])
														->where('lunas', 'N')->sum('total');
		$data['dokter'] 	= Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['perawat']	= Pegawai::whereNotIn('kategori_pegawai', [1])->pluck('nama', 'id');
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
				$data['opt_poli'] = Poli::where('politype', 'L')->get();
		}
	
		// PEMAKAIAN OBAT
		$data['penjualan'] 	= Penjualan::where('registrasi_id' ,$idreg)->first();

		$data['opt_poli'] = Poli::where('politype', 'L')->get();
		//$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		return view  ('laboratorium.entryTindakanLaboratoriumIRNA', $data)->with('no', 1)->with('idreg', $idreg);
	}

	public function entryTindakanIRJ($idreg, $idpasien)
	{
		$data['depo']		= strtolower(Auth::user()->role()->first()->name);
		$data['folio'] 		= Folio::leftJoin('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
						->where('registrasi_id', $idreg)
						->whereIn('poli_id', [26,30])
						->whereNotIn('folios.jenis', ['PEM'])
						->select('folios.*', 'foliopelaksanas.dokter_lab','foliopelaksanas.analis_lab')
						->get();
		$data['pasien'] 	= Pasien::find($idpasien);
		$data['reg_id'] 	= $idreg;
		$data['jenis'] 		= Registrasi::where('id', '=', $idreg)->first();
		$data['poli'] 		= Folio::where('registrasi_id', '=', $idreg)->distinct();
		$data['tagihan'] 	= Folio::where('registrasi_id',$idreg)->whereIn('poli_id', [26,30])->where('lunas', 'N')->sum('total');
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
		}
	
		// PEMAKAIAN OBAT
		$data['penjualan'] 	= Penjualan::where('registrasi_id' ,$idreg)->first();

		$data['opt_poli'] = Poli::where('politype', 'L')->get();
		return view  ('laboratorium.entryTindakanLaboratorium', $data)->with('no', 1)->with('idreg', $idreg);
	}
	 */
	
	public function saveTindakan(Request $request)
	{
		//request()->validate(['tarif_id' => 'required']);
		session(['dokter'=>$request['dokter_id'], 'pelaksana'=>$request['pelaksana'], 'analis_lab'=>$request['analis_lab']]);
		$reg = Registrasi::find($request['registrasi_id']);
		if($request['tarif_id']=="" AND $request['group_id']==""){
			Flashy::error('Harap memilih group / tindakan');			
		}else{
			$idx = [];
			if($request['tarif_id']!=""){
				array_push($idx, $request['tarif_id']);
			}
			if($request['group_id']!=""){
				$cek_mapping = Tarif::where('mapping_biaya_id', '!=', null)->get();
				if($cek_mapping!=null){
					foreach($cek_mapping as $key => $data){
						$var = json_decode($data->mapping_biaya_id);
						if(in_array($request['group_id'], $var)){
							array_push($idx, $data->id);
						}
					}
				}
			}
			foreach($idx as $id_tarif){
				$tarif = Tarif::find($id_tarif);
				$fol = new Folio();
				$fol->registrasi_id = $request['registrasi_id'];
				$fol->poli_id       = $request['poli_id'];
				$fol->lunas         = 'N';
				$fol->namatarif     = $tarif->nama;
				$fol->tarif_id      = $id_tarif;
				if(substr($reg->status_reg,0,1) == 'G'){
					$fol->jenis      = 'TG';
					$reg->status_reg = 'G2';
				}elseif (substr($reg->status_reg,0,1) == 'I') {
					$fol->jenis      = 'TI';
					$reg->status_reg = 'I2';
				}elseif (substr($reg->status_reg,0,1) == 'L') {
					$reg->status_reg = 'L1';
					$fol->jenis      = 'TA';
				}else{
					$fol->jenis      = 'TA';
					$reg->status_reg = 'J2';
				}
				$fol->cara_bayar_id = $reg->bayar;
				$fol->poli_tipe     = 'L';
				$fol->total         = (getTotalTarif($reg,$tarif) * $request['jumlah']);
				$fol->jenis_pasien  = $request['jenis'];
				$fol->pasien_id     = $request['pasien_id'];
				$fol->dokter_id     = $request->dokter_id;
				if (!empty($request['tanggal'])) {
					$fol->created_at = valid_date($request['tanggal']);
				}
				$fol->user_id       = Auth::user()->id;
				$fol->save();

				//INSERT FOLIO PELAKSANA
				$fp = new  Foliopelaksana();
				$fp->folio_id = $fol->id;
				$fp->dpjp = $reg->dokter_id;
				$fp->dokter_lab = $request['dokter_lab'];
				$fp->analis_lab = $request['analis_lab'];
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
			}
			// Insert Histori
			$history = new HistoriStatus();
			$history->registrasi_id = $request['registrasi_id'];
			$history->status 				= $reg->status_reg;
			$history->poli_id       = $request['poli_id'];
			$history->bed_id        = null;
			$history->user_id       = Auth::user()->id;
			$history->save();
			session()->forget('jenis');
			Flashy::success('Berhasil menambahkan data');	
		}
			
		if(isset($request['ranap_lab'])){
			return redirect('tindakan/order/laboratorium/irna/'.$request['registrasi_id']);
		}elseif(isset($request['rajal_lab'])){
			return redirect('tindakan/order/laboratorium/irj/'.$request['registrasi_id']);
		}elseif(isset($request['darurat_lab'])){
			return redirect('tindakan/order/laboratorium/darurat/'.$request['registrasi_id']);
		}else{
			return redirect('laboratorium/entry-tindakan/'.$request['registrasi_id'].'/'.$request['pasien_id']);
		}
	}

	public function hapusTindakan($id, $idreg, $pasien_id, $order='')
	{
		if (Auth::user()->hasRole(['supervisor', 'laboratorium','administrator','rawatinap','rawatjalan','rawatdarurat'])) {
			if(Folio::where('id',$id)->where('lunas', 'N')->delete()){
				Foliopelaksana::where('folio_id',$id)->delete();
			}
		}
		$reg = Registrasi::find($idreg);
		if($order=='rawat-inap'){
			return redirect('tindakan/order/laboratorium/irna/'.$idreg);
		}elseif($order=='rawat-jalan'){
			return redirect('tindakan/order/laboratorium/irj/'.$idreg);
		}elseif($order=='darurat'){
			return redirect('tindakan/order/laboratorium/darurat/'.$idreg);
		}else{
			return redirect('laboratorium/entry-tindakan/'.$idreg.'/'.$pasien_id);
		}
	}

	public static function cetakRincianLab($registrasi_id)
	{
		$folio = Folio::where('registrasi_id', $registrasi_id)->where('poli_tipe', 'L')->get();
		$reg = Registrasi::find($registrasi_id);
		$jml = Folio::where('registrasi_id', $registrasi_id)->where('poli_tipe', 'L')->sum('total');
		$no = 1;
		$pdf = PDF::loadView('bridging.rincianBiayaJKN', compact('reg', 'folio', 'jml', 'no'));
		return $pdf->stream();
	}

	public function lap_kunjungan()
	{
		$data['kunjungan'] = NULL;
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();
		//$data['hasillab'] = NULL;
		return view('laboratorium.lap_kunjungan', $data);
	}

	public function lap_kunjungan_by_request(Request $request)
	{
		$dokter = Pegawai::select('id')->get();
      	$di = [];
      	foreach ($dokter as $key => $d) {
        $di[] = ''.$d->id.'';
      	}
		request()->validate(['tga'=>'required', 'tgb'=>'required']);
		$data['kunjungan'] = HistorikunjunganLAB::join('hasillabs','hasillabs.registrasi_id','=','histori_kunjungan_lab.registrasi_id')
							->where('histori_kunjungan_lab.pasien_asal', $request['pasien_asal'])
							->whereIn('hasillabs.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
							->whereBetween('histori_kunjungan_lab.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
							->get();
		// return $data['kunjungan']; die;
		//$data['hasillab'] = RincianHasillab::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
		
		$data['pasien_asal'] = $request['pasien_asal'];
		if ($request['view']) {
			//return $data['hasillab'];
			return view('laboratorium.lap_kunjungan', $data)->with('no', 1);
		} elseif ($request['excel']) {
			$datareg = $data['kunjungan'];
				if ($request['pasien_asal'] == 'TI') {
					$judul = 'IRNA';
				} elseif ($request['pasien_asal'] == 'TA') {
					$judul = 'IRJ';
				} elseif ($request['pasien_asal'] == 'TG') {
					$judul = 'IGD';
				}
				Excel::create('Lap Kunjungan Laboratorium '.$judul, function ($excel) use ($datareg, $judul) {
				// Set the properties
				$excel->setTitle('Lap Kunjungan Laboratorium '.$judul)
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Lap Kunjungan Laboratorium '.$judul);
				$excel->sheet('Lap Kunjungan Laboratorium '.$judul, function ($sheet) use ($datareg) {
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
		}elseif ($request['pdf']) {
			$no=1;
			$config = Config::find(1);
			$kunjungan = $data['kunjungan'];
			$periode = $request['tga'].' s/d '.$request['tgb'];
			$pasien_asal = $data['pasien_asal'];
			//$pdf = PDF::loadView('laboratorium.pdf_lap_kunjungan',compact('no','kunjungan','pasien_asal'));
			//$pdf->setPaper('A4', 'landscape');
			$pdf = PDF::loadView('/laboratorium.pdf_lap_kunjungan', compact('config','no','kunjungan','pasien_asal','periode'),[
				'orientation' => 'L']);
			return $pdf->stream();
			//return $pdf->download('laporan Kunjungan IGD.pdf');
		  } 
		
	}

	/* 
	//TINDAKAN LANGSUNG
	public function tindakanLangsung()
	{
		$poli = Poli::where('nama', 'Laboratorium')->where('politype', 'J')->first();			
		$data = Registrasi::where('pulang',null)
												->where('poli_id', $poli->id)->get();
		return view('laboratorium.transaksiLangsung', compact('data'))->with('no', 1);
	}

	public function simpanTransaksiLangsung(Request $request)
	{
		request()->validate(['nama'=>'required', 'alamat'=>'required']);
		DB::transaction(function () use ($request) {
			$id = Registrasi::where('reg_id', 'LIKE',date('Ymd').'%')->count();
			$reg = new Registrasi();
			$reg->pasien_id     = '0';
			$reg->status_reg    = 'L1';
			$reg->bayar         = '2';
			$reg->reg_id        = date('Ymd').sprintf("%04s", ($id + 1));
			$reg->user_create   = Auth::user()->id;
			$reg->save();

			$pasien = new Pasienlangsung();
			$pasien->registrasi_id = $reg->id;
			$pasien->nama = $request['nama'];
			$pasien->alamat = $request['alamat'];
			$pasien->politype = 'L';
			$pasien->pemeriksaan = $request['pemeriksaan'];
			$pasien->user_id = Auth::user()->id;
			$pasien->save();

			$hk = new HistorikunjunganLAB();
			$hk->registrasi_id = $reg->id;
			$hk->pasien_id = '0';
			$hk->poli_id = '26';
			$hk->pasien_asal = 'TA';
			$hk->user = Auth::user()->name;
			$hk->save();
			session(['registrasi_id' => $reg->id]);
		});
		return redirect('/laboratorium/entry-transaksi-langsung/'.session('registrasi_id'));
	}

	public function entryTindakanLangsung($registrasi_id)
	{
			$data['folio'] = Folio::join('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
														->where('folios.registrasi_id', $registrasi_id)
														->select('folios.*', 'foliopelaksanas.dokter_lab', 'foliopelaksanas.analis_lab')
														->where('poli_id', 26)->get();
			$data['pasien'] = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
			$data['reg_id'] = $registrasi_id;
			$data['poli'] = Folio::where('registrasi_id', '=', $registrasi_id)->distinct();
			$data['tagihan'] = Folio::where('registrasi_id',$registrasi_id)->where('poli_id', 26)->where('lunas', 'N')->sum('total');
			$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
			$data['perawat'] = Pegawai::pluck('nama', 'id');
			$data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
			$data['jenis'] = Registrasi::find($registrasi_id);
			$data['opt_poli'] = Poli::where('politype', 'L')->get();
			$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
			session(['jenis' => 'TA']);
			return view  ('laboratorium.entryTindakanLaboratorium', $data)->with('no', 1); 
	}
	*/
}
