<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Pasien\Entities\Pasien;
use Modules\Config\Entities\Config;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Tagihan;
use App\Penjualan;
use App\Penjualanbebas;
use App\Masterobat;
use App\MarginHargaObat;
use App\Penjualandetail;
use App\Permintaanobat;
use App\Permintaanobatdetail;
use App\Apoteker;
use App\AntrianApotek;
use App\MasterEtiket;
use App\TakaranobatEtiket;
use App\Aturanetiket;
use App\Depo;
use App\Depomasterobat;
use App\Satuanjual;
use App\Jenisracikan;
use App\Rawatinap;
use Yajra\DataTables\DataTables;
use Activity;
use App\User;
use App\Role;
use Auth;
use DB;
use PDF;
use Flashy;

class PenjualanController extends Controller
{
	public function index()
	{
		if(strtolower(Auth::user()->role()->first()->name)=='administrator' || strtolower(Auth::user()->role()->first()->name)=='apotik' )
        {
			session()->forget('idpenjualan');
			session(['retur' 	=> '']);
			$data = Registrasi::join('antrian_apoteks','registrasis.antrian_apotek_id','=','antrian_apoteks.id')
										->whereIn('registrasis.posisi_pasien',['selesai'])
										->whereBetween('registrasis.created_at', [date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59'])
										->orderBy('registrasis.posisi_pasien', 'asc')
										->select('registrasis.*','registrasis.id as registrasi_id','antrian_apoteks.*')
										->get();
			return view('penjualan.index', compact('data'))->with('no', 1);
        }else{
            return redirect('/dashboard');
        }
		
	}

	public function indexByRequest(Request $request)
	{
		if(strtolower(Auth::user()->role()->first()->name)=='administrator'|| strtolower(Auth::user()->role()->first()->name)=='apotik' )
        {
			request()->validate(['tga'=>'required']);
			session(['retur' 	=> '']);
			$data = Registrasi::join('antrian_apoteks','registrasis.antrian_apotek_id','=','antrian_apoteks.id')
										->whereIn('registrasis.posisi_pasien',['selesai'])
										->whereBetween('registrasis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
										->orderBy('registrasis.posisi_pasien', 'asc')
										->select('registrasis.*','registrasis.created_at as tgl_regis','registrasis.id as registrasi_id','antrian_apoteks.*')
										->get();
			return view('penjualan.index', compact('data'))->with('no', 1);
        }else{
            return redirect('/dashboard');
        }
		
	}

	public function epo()
	{
		if(strtolower(Auth::user()->role()->first()->name)=='administrator' || strtolower(Auth::user()->role()->first()->name)=='apotik')
        {
			session()->forget('idpenjualan');
			session(['retur' 	=> '']);
			$data = Registrasi::join('permintaan_obats', 'registrasis.id', '=', 'permintaan_obats.registrasi_id')
							->whereIn('registrasis.status_reg', ['I2'])
							->where('registrasis.pulang',null)
							->select('registrasis.*', 'permintaan_obats.status')
							->orderBy('registrasis.created_at', 'desc')
							->get();
			return view('penjualan.index', compact('data'))->with('no', 1)->with('epo', true);
        }else{
            return redirect('/dashboard');
        }
		
	}

	public function epo_byTanggal(Request $request)
	{
		if(strtolower(Auth::user()->role()->first()->name)=='administrator' || strtolower(Auth::user()->role()->first()->name)=='apotik')
        {
			session()->forget('idpenjualan');
			session(['retur' 	=> '']);
			request()->validate(['tga'=>'required']);
			$data = Registrasi::join('permintaan_obats', 'registrasis.id', '=', 'permintaan_obats.registrasi_id')
							->whereBetween('registrasis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
							->whereIn('registrasis.status_reg', ['I1', 'I2', 'I3'])
							->where('registrasis.pulang',null)
							->select('registrasis.*', 'permintaan_obats.status')
							->orderBy('registrasis.created_at', 'desc')
							->get();
			return view('penjualan.index', compact('data'))->with('no', 1)->with('epo', true);
        }else{
            return redirect('/dashboard');
        }
		
	}
	
	/* public function retur()
	{
		session()->forget('idpenjualan');
		session(['retur' 	=> 'retur']);
		//return redirect(url()->previous());
		$data = Registrasi::join('penjualans', 'registrasis.id', '=', 'penjualans.registrasi_id')
						->whereNotNull('registrasis.pulang')
						->select('registrasis.*')
						->orderBy('registrasis.created_at', 'desc')
						->get();
		return view('penjualan.irna', compact('data'))->with('no', 1)->with('retur', true);
	} */

	/* public function retur_byTanggal(Request $request)
	{
		session()->forget('idpenjualan');
		session(['retur' 	=> 'retur']);
		request()->validate(['tga'=>'required']);
		$data = Registrasi::join('penjualans', 'registrasis.id', '=', 'penjualans.registrasi_id')
						->whereBetween('registrasis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
						->whereNotNull('registrasis.pulang')
						->get();
		return view('penjualan.irna', compact('data'))->with('no', 1)->with('retur', true);
	} */

	/* public function rawat_inap()
	{
		session()->forget('idpenjualan');
		session(['retur' 	=> '']);
		$data = Registrasi::join('antrian_apoteks','registrasis.antrian_apotek_id','=','antrian_apoteks.id')
									->whereIn('registrasis.posisi_pasien',['selesai'])
									->whereBetween('registrasis.created_at', [date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59'])
									->orderBy('registrasis.posisi_pasien', 'asc')
									->select('registrasis.*','registrasis.id as registrasi_id','antrian_apoteks.*')
									->get();
		return view('penjualan.irna', compact('data'))->with('no', 1);
	}

	public function rawat_inap_byTanggal(Request $request)
	{
		request()->validate(['tga'=>'required']);
		session(['retur' 	=> '']);
		$data = Registrasi::join('antrian_apoteks','registrasis.antrian_apotek_id','=','antrian_apoteks.id')
									->whereIn('registrasis.posisi_pasien',['selesai'])
									->whereBetween('registrasis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
									->orderBy('registrasis.posisi_pasien', 'asc')
									->select('registrasis.*','registrasis.created_at as tgl_regis','registrasis.id as registrasi_id','antrian_apoteks.*')
									->get();
		return view('penjualan.irna', compact('data'))->with('no', 1);
	} */

	public function history($registrasi_id)
	{
		$penjualan = Penjualan::where('registrasi_id', $registrasi_id)->get();
		return view('penjualan.history', compact('penjualan'));
	}

	public function search(Request $request)
	{
		$keyword = $request['keyword'];
		$data = Pasien::where('nama', 'LIKE', '%'.$keyword.'%')
										->orWhere('no_rm', 'LIKE', '%'.$keyword.'%')
										->orWhere('alamat', 'LIKE', '%'.$keyword.'%')
										->get();
		return view('penjualan.index', compact('data','keyword'))->with('no', 1);
	}

	public function form_penjualan($idpasien, $idreg, $penjualan_id='', $bebas='')
	{
		$data['reg'] 			= Registrasi::find($idreg);
		if($data['reg']==null){
			return redirect('antrian/farmasi');
		}
		session(['jenis' 	=> $data['reg']->bayar]);
		$data['bebas'] = '';
		if($bebas=='bebas'){
			$data['bebas'] = 'bebas';
		}
		$data['pasien'] 	= Pasien::find($idpasien);
		$data['folio'] 		= Folio::where('registrasi_id', '=', $idreg);
		$data['apoteker'] = Apoteker::pluck('nama', 'id');
		$data['penjualan'] = null;
		$data['data_racikan_resep'] = null;
		$data['penjualan'] = Penjualan::where('registrasi_id',$idreg)->first();			
		if($data['penjualan']!=null){
			if($data['penjualan']->apoteker!=null){
				$data['data_racikan_resep'] = Penjualandetail::join('obat_racikan', 'penjualandetails.obat_racikan_id', '=', 'obat_racikan.id')->where('penjualan_id', '=', $data['penjualan']->id)->groupBy('penjualandetails.obat_racikan_id')->get();
				$data['detail'] 	= Penjualandetail::where('penjualan_id', '=', $data['penjualan']->id)->orderBy('obat_racikan_id','ASC')->get();
				$data['tiket'] 		= MasterEtiket::get();
				$data['takaran'] 	= TakaranobatEtiket::pluck('nama','nama');
				$data['aturan'] 	= Aturanetiket::pluck('aturan', 'aturan');
				$data['satuan'] 	= Satuanjual::pluck('nama', 'nama');
				$data['jenis_racikan'] 	= Jenisracikan::pluck('jenis_racikan', 'jenis_racikan');
				$data['no'] = 1;
			}else{
				$data['penjualan'] = null;
			}
		}
		return view('penjualan.form_penjualan', $data)->with('idreg', $idreg);
	}
	
	public function getPenjualan($id)
	{
		$data = Penjualandetail::where('id', $id)->first();
		if($data!=null){
			$datax['masterobat_id'] 	= $data->masterobat_id;
			$datax['nama'] 						= $data->masterobat->nama;
			$datax['satuan'] 					= $data->masterobat->satuan;
			$datax['stok'] 						= $data->masterobat->stok;
			$datax['expired'] 				= $data->expired_date;
			$datax['jumlah'] 					= $data->jumlah;
			$datax['aturan_pakai'] 		= $data->aturan_pakai;
			$datax['jumlah_aturanpakai'] = $data->jumlah_aturanpakai;
			$datax['satuan_aturanpakai'] = $data->satuan_aturanpakai;
			$datax['informasi1'] 			= $data->informasi1;
			$datax['is_did'] 					= $data->is_did;
			return response()->json(['status'=>true, 'data'=>$datax]);
		}else{
			return response()->json(['status'=>false]);
		}
	}
	
	public function konfirmasiResep($registrasi_id='',$penjualan_id='')
	{
		$registrasi	= Registrasi::find($registrasi_id);
		$registrasi->posisi_pasien = 'konfirmasi farmasi';
		if($registrasi->update()){
			Flashy::success('Resep berhasil dikonfirmasi');
		}else{
			Flashy::error('Resep gagal dikonfirmasi');
		}
		return redirect('penjualan/formpenjualan/'.$registrasi->pasien_id.'/'.$registrasi_id.'/'.$penjualan_id);
	}

	public function getMasterObat($depo=null)
	{
		$term = '';
		if(isset($_GET['term'])){
			$term = $_GET['term'];
		}
		if($depo==null){
			$obat = Masterobat::select('id',DB::raw('CONCAT(nama," | ",satuan," | ",stok) AS text'))
							->where('nama', 'like', '%'.$term.'%')
							->where('stok', '>', 0)
							->get();
		}else{
			if($depo=='dokter')
			{
				$depo_fix	='rawatjalan';
			}else{
				$depo_fix 	= $depo;
			}
			$get_depo = Depo::where('nama_depo', $depo_fix)->first();
			if($get_depo==null){
				$obat = null;
			}else{
				$obat = Depomasterobat::select('id',DB::raw('CONCAT(nama," | ",satuan," | ",stok) AS text'))
								->where('nama', 'like', '%'.$term.'%')
								->where('stok', '>', 0)
								->where('id_depo',$get_depo->id)
								->get();
			}
		}		
		return response()->json($obat);
	}

	public function save_penjualan(Request $request)
	{
		if($request['apoteker']==""){
			Flashy::error('Harap pilih pelaksana farmasi');
			return redirect('penjualan/formpenjualan/'.$request['pasien_id'].'/'.$request['idreg']);
		}else{
			$get_resep = Penjualan::where('registrasi_id', $request['idreg'])->first();
			if($get_resep!=null){
				
			}else{
				$get_resep = new Penjualan;
				$jenis = Registrasi::find($request['idreg'])->status_reg;
				if (substr($jenis,0,1) == 'J') {
					$next_resep = 'FRJ'.date('YmdHis');
				} elseif (substr($jenis,0,1) == 'I') {
					$next_resep = 'FRI'.date('YmdHis');
				} elseif (substr($jenis,0,1) == 'G') {
					$next_resep = 'FRD'.date('YmdHis');
				}
				$get_resep->no_resep = $next_resep;
			}
			if($get_resep->status=='pending'){
				$get_resep->status = 'proses';
			}
			$get_resep->registrasi_id = $request['idreg'];
			$get_resep->apoteker = $request['apoteker'];
			$get_resep->proses_time = date('Y-m-d H:i:s');
			$get_resep->user_id = Auth::user()->id;
			$get_resep->save();
			Activity::log('penjualan_'.Auth::user()->name.' create no struk '.$get_resep->no_resep);
			session(['idpenjualan'=>$get_resep->id]);
			return redirect('penjualan/formpenjualan/'.$request['pasien_id'].'/'.$request['idreg'].'/'.session('idpenjualan'));
		}
	}

	public function save_detail(Request $request)
	{
		request()->validate(['masterobat_id'=>'required']);
		$cek = Penjualandetail::where('masterobat_id', $request['masterobat_id'])->where('penjualan_id', $request['penjualan_id'])->count();
		if ($cek >= 1) {
			$pj = Penjualandetail::where('masterobat_id', $request['masterobat_id'])->where('penjualan_id', $request['penjualan_id'])->first();
			$pj->jumlah = $pj->jumlah + $request['jumlah'];
			
			$harga = Masterobat::select('hargajual')->where('id', $request['masterobat_id'])->first()->hargajual;
			
			$pj->hargajual = $pj->hargajual + ($harga * $request['jumlah']);
			$pj->informasi1 = $request['informasi1'];
			$pj->informasi2 = $request['informasi2'];
			$pj->expired = $request['expired'];
			$pj->update();
			Activity::log('penjualan_'.Auth::user()->name.' menambahkan obat '.Masterobat::find($request['masterobat_id'])->nama.' sebanyak '.$request['jumlah'].' ke no struk '.$request['no_resep']);
		} else {
			$d = new Penjualandetail();
			$d->penjualan_id = $request['penjualan_id'];
			$d->no_resep =  $request['no_resep'];
			$d->masterobat_id = $request['masterobat_id'];
			$d->jumlah = $request['jumlah'];
			
			$harga = Masterobat::select('hargajual')->where('id', $request['masterobat_id'])->first()->hargajual;

			if($request['masterobat_id'] == config('app.obatRacikan_id')){
				$harga = rupiah($request['racikan']);
			}

			if (substr($request['tipe_rawat'],0,1) == 'J') {
				$d->tipe_rawat = 'TA';
			} elseif (substr($request['tipe_rawat'],0,1) == 'G') {
				$d->tipe_rawat = 'TG';
			} elseif (substr($request['tipe_rawat'],0,1) == 'I') {
				$d->tipe_rawat = 'TI';
			}

			$d->hargajual = $harga * $request['jumlah'];
			$d->informasi1 = $request['informasi1'];
			$d->informasi2 = $request['informasi2'];
			$d->expired = $request['expired'];
			$d->etiket = $request['tiket'].' '.$request['takaran'];
			$d->cetak = $request['cetak'];
			$d->save();
			Activity::log('penjualan_'.Auth::user()->name.' menambahkan obat '.Masterobat::find($request['masterobat_id'])->nama.' sebanyak '.$request['jumlah'].' ke no struk '.$request['no_resep']);
		}
		return redirect('penjualan/formpenjualan/'.$request['pasien_id'].'/'.$request['idreg'].'/'.$request['penjualan_id']);
	}

	public function deleteDetail($id, $idpasien, $idreg, $penjualan_id)
	{
		$obat = Penjualandetail::find($id);
		Activity::log('penjualan_'.Auth::user()->name.' menghapus obat '.Masterobat::find($obat->masterobat_id)->nama.'  dari no struk '.$obat->no_resep);
		$obat->delete();
		return redirect('penjualan/formpenjualan/'.$idpasien.'/'.$idreg.'/'.$penjualan_id);
	}

	public function save_totalpenjualan($penjualan_id='')
	{
		$total = 0;
		$det = Penjualandetail::where('penjualan_id', $penjualan_id)->get();
		if($det!=null){
			foreach ($det as $key => $d) {
				$total += $d->hargajual;
			}
		}
		$total;
		$bebas="";
		$pj = Penjualan::find($penjualan_id);
		if($pj->status=='selesai' AND (session()->get('antrian_apotek')=='' OR session()->get('retur')=='')){
			return redirect('antrian/farmasi');
		}
		$reg = Registrasi::find(Penjualan::find($penjualan_id)->registrasi_id);
		if (substr($reg->status_reg,0,1) == 'J') {
			$jenis = 'ORJ';
		} elseif (substr($reg->status_reg,0,1) == 'I') {
			$jenis = 'ORI';
		} elseif (substr($reg->status_reg,0,1) == 'G') {
			$jenis = 'ORD';
		} elseif (substr($reg->status_reg,0,1) == 'A') {
			$jenis = 'ORA';
			$bebas = 'bebas';
		}
		$reg->posisi_pasien = 'selesai';
		$reg->update();
		
		$get_folio = Folio::where('registrasi_id',$reg->id)->where('namatarif',$pj->no_resep)->where('jenis',$jenis)->first();
		if($get_folio==null){
			$fol = new Folio();
			$fol->registrasi_id = $reg->id;
			$fol->namatarif     = $pj->no_resep;
			$fol->total         = $total;
			$fol->tarif_id      = 10000;
			$fol->lunas         = 'N';
			$fol->jenis         = $jenis;
			$fol->cara_bayar_id = $reg->bayar;
			$fol->poli_tipe     = 'A';
			$fol->pasien_id     = $reg->pasien_id;
			$fol->dokter_id     = $reg->dokter_id;
			$fol->poli_id       = $reg->poli_id;
			$fol->user_id       = Auth::user()->id;
			$fol->save();
			
			Activity::log('penjualan_'.Auth::user()->name.' membuat tagihan obat sebesar '.number_format($total).' dengan no struk '.$pj->no_resep);
		}
		
		if(session()->get('retur')==''){
			if($det!=null){
				foreach ($det as $key => $d) {
					$get_master = Masterobat::where('id',$d->masterobat_id)->first();
					if($get_master!=null){
						$get_master->stok = (int)$get_master->stok - (int)$d->jumlah;
						$get_master->save();
					}
				}
				$pj->status = 'selesai';
				$pj->selesai_time = date('Y-m-d H:i:s');
				$pj->save();
			}
		}
		session(['antrian_apotek' => 0]);
		if($det==null){
			return redirect('antrian/farmasi');
		}else{
			return redirect('penjualan/formpenjualan/'.$reg->pasien_id.'/'.$reg->id.'/'.$penjualan_id.'/'.$bebas);
		}
	}

	//PERMINTAAN
	public function formPermintaan($idpasien, $idreg, $permintaan_id='')
	{
		$data['reg'] = Registrasi::find($idreg);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['irna'] = Rawatinap::where('registrasi_id', $idreg)->first();
		session(['jenis' => $data['reg']->bayar]);
		$data['folio'] = Folio::where('registrasi_id', '=', $idreg);
		$data['apoteker'] = Apoteker::pluck('nama', 'id');
		$data['permintaan_id'] = 0;
		$data['data_racikan_epo'] = Permintaanobatdetail::join('obat_racikan', 'permintaan_obat_details.obat_racikan_id', '=', 'obat_racikan.id')
														->where('permintaan_id', '=', $permintaan_id)->groupBy('permintaan_obat_details.obat_racikan_id')->get();
		$data['permintaan'] = Permintaanobat::where('registrasi_id',$idreg)->first();
		if($data['permintaan']!=null){
			if($data['permintaan']->apoteker!=null){
				$data['permintaan_id'] = $data['permintaan']->id;			
				$data['detail'] = Permintaanobatdetail::where('permintaan_id', '=', $data['permintaan_id'])->orderBy('id','desc')->get();
				$data['tiket'] 	= MasterEtiket::get();
				$data['takaran'] 	= TakaranobatEtiket::pluck('nama','nama');
				$data['aturan'] 	= Aturanetiket::pluck('aturan', 'aturan');
				$data['satuan'] 	= Satuanjual::pluck('nama', 'nama');
				$data['jenis_racikan'] 	= Jenisracikan::pluck('jenis_racikan', 'jenis_racikan');
				$data['no'] = 1;
			}else{
				$data['permintaan'] = null;
			}
		}
		return view('penjualan.form_permintaan', $data)->with('idreg', $idreg)->with('epo', true);
	}
	
	public function getPermintaan($id)
	{
		$data = Permintaanobatdetail::where('id', $id)->first();
		if($data!=null){
			$obat = Masterobat::find($data->masterobat_id);
			$datax['masterobat_id'] 	= $data->masterobat_id;
			$datax['nama'] 						= $obat->nama;
			$datax['satuan'] 					= $obat->satuan;
			$datax['stok']	 					= $obat->stok;
			$datax['expired'] 				= $data->expired_date;
			$datax['jumlah'] 					= $data->jumlah;
			$datax['aturan_pakai'] 		= $data->aturan_pakai;
			$datax['jumlah_aturanpakai'] = $data->jumlah_aturanpakai;
			$datax['satuan_aturanpakai'] = $data->satuan_aturanpakai;
			$datax['informasi1'] 			= $data->informasi1;
			return response()->json(['status'=>true, 'data'=>$datax]);
		}else{
			return response()->json(['status'=>false]);
		}
	}
	
	public function savePermintaan(Request $request)
	{
		if($request['apoteker']==""){
			Flashy::error('Harap pilih pelaksana farmasi');
			return redirect('penjualan/formpermintaan/'.$request['pasien_id'].'/'.$request['idreg']);
		}else{
			$get_resep = Permintaanobat::where('registrasi_id', $request['idreg'])->first();
			if($get_resep!=null){
				if($get_resep->status=='selesai'){
					return redirect('penjualan/irna');
				}
			}else{
				$get_resep = new Permintaanobat;
				$jenis = Registrasi::find($request['idreg'])->status_reg;
				$next_resep = 'EPO'.date('YmdHis');
				$get_resep->no_resep = $next_resep;
			}
			$get_resep->user_id = Auth::user()->id;
			$get_resep->status = 'proses';
			$get_resep->registrasi_id = $request['idreg'];
			$get_resep->apoteker = $request['apoteker'];
			$get_resep->proses_time = date('Y-m-d H:i:s');
			$get_resep->save();
			Activity::log('permintaan_'.Auth::user()->name.' create no struk '.$get_resep->no_resep);
			session(['idpenjualan'=>$get_resep->id]);
			return redirect('penjualan/formpermintaan/'.$request['pasien_id'].'/'.$request['idreg'].'/'.session('idpenjualan'));
		}
	}
	
	public function updateStatusPermintaan(Request $request)
	{
		$get_resep = Permintaanobatdetail::where('id', $request['id'])->first();
		if($request['value']==''){
			return response()->json(['sukses'=>true]); exit;
		}elseif($get_resep->status==$request['value']){
			return response()->json(['sukses'=>true]); exit;
		}
		if($get_resep!=null){
			$get_idreg = Permintaanobat::where('id', $get_resep->permintaan_id)->first();
			$get_resep->update_by = Auth::user()->id;
			if($request['value']=='Retur ke Apotek'){
				$get_resep->retur_by = Auth::user()->id;
			}elseif($request['value']=='Terima Retur'){
				$get_resep->terima_retur_by = Auth::user()->id;
			}
			$get_resep->status = $request['value'];
			if($get_resep->save()){
				$update_masterobat = Masterobat::where('id',$get_resep->masterobat_id)->first();
				if($request['value']=='Diproses' OR $request['value']=='Terima Retur'){
					$total = 0;
					$det = Permintaanobatdetail::whereIn('status',['Diproses','Diserahkan'])->where('delete_by', null)->where('permintaan_id', $get_resep->permintaan_id)->get();
					foreach ($det as $key => $d) {
						$total += $d->hargajual;
					}
					$get_folio = Folio::where('registrasi_id',$get_idreg->registrasi_id)->where('namatarif',$get_idreg->no_resep)->where('jenis','EPO')->first();
					$get_folio->total = $total;
					$get_folio->save();
					
					// CEK STOK LAGI
					if($request['value']=='Terima Retur'){
						$update_masterobat->stok = $update_masterobat->stok + $get_resep->jumlah;
					}else{
						if($update_masterobat->stok < $get_resep->jumlah){
							return response()->json(['sukses'=>false, 'message'=>'Stok tidak mencukupi']);
						}else{
							$update_masterobat->stok = $update_masterobat->stok - $get_resep->jumlah;
						}
					}
					$update_masterobat->save();					
				}
				
				$update_status = Permintaanobatdetail::where('permintaan_id',$get_resep->permintaan_id)->whereIn('status', ['Pending','Diproses','Retur ke Apotek'])->get();
				
				if(count($update_status)==0){
					$get_idreg->status = 'selesai';
				}else{
					$get_idreg->status = 'proses';
				}
				$get_idreg->update();
				
				Activity::log('permintaan_'.Auth::user()->name.' update status menjadi '.$request['value']);
				return response()->json(['sukses'=>true]);
			}else{
				return response()->json(['sukses'=>false, 'message'=>'Gagal update stok']);
			}
		}else{
			return response()->json(['sukses'=>false, 'message'=>'Data tidak ditemukan']);
		}
	}
	
	public function deleteDetailPermintaan($id, $idpasien, $idreg, $permintaan_id, $alasan)
	{
		$obat = Permintaanobatdetail::find($id);
		$status_sebelumnya = $obat->status;
		$obat->hargajual = 0;
		$obat->status = null;
		$obat->alasan_hapus = $alasan;
		$obat->delete_by = Auth::user()->id;
		if($obat->save()){
			Activity::log('permintaan_'.Auth::user()->name.' menghapus obat '.Masterobat::find($obat->masterobat_id)->nama.'  dari no struk '.$obat->no_resep);
			$total = 0;
			$det = Permintaanobatdetail::whereIn('status',['Diproses','Diserahkan'])->where('delete_by', null)->where('permintaan_id', $permintaan_id)->get();
			foreach ($det as $key => $d) {
				$total += $d->hargajual;
			}
			$get_folio = Folio::where('registrasi_id',$idreg)->where('namatarif',$obat->no_resep)->where('jenis','EPO')->first();
			$get_folio->total = $total;
			$get_folio->save();
			
			if($status_sebelumnya=='Diproses' OR $status_sebelumnya=='Diserahkan' OR $status_sebelumnya=='Retur ke Apotek'){
				$update_masterobat = Masterobat::where('id',$obat->masterobat_id)->first();
				$update_masterobat->stok = $update_masterobat->stok + $obat->jumlah;
				$update_masterobat->save();
			}
			return response()->json(['sukses'=>true]);
		}else{
			return response()->json(['sukses'=>false]);
		}
		//return redirect('penjualan/formpermintaan/'.$idpasien.'/'.$idreg.'/'.$permintaan_id);
	}
	
	public function returPermintaan($id, $jumlah)
	{
		$obat = Permintaanobatdetail::find($id);
		$permintaan = Permintaanobat::where('no_resep',$obat->no_resep)->first();
		if($obat->jumlah == (int)$jumlah){
			$obat->status = 'Terima Retur';
			$obat->alasan_hapus = null;
			$obat->retur_by = Auth::user()->id;
		}
		$harga_jual = $obat->hargajual/$obat->jumlah;
		$obat->jumlah = $obat->jumlah - (int)$jumlah;
		$obat->hargajual = $obat->jumlah * $harga_jual;
		if($obat->save()){
			Activity::log('permintaan_'.Auth::user()->name.' retur obat '.Masterobat::find($obat->masterobat_id)->nama.'  dari no struk '.$obat->no_resep);
			$total = 0;
			$det = Permintaanobatdetail::whereIn('status',['Diproses','Diserahkan'])->where('delete_by', null)->where('no_resep', $obat->no_resep)->get();
			foreach ($det as $key => $d) {
				$total += $d->hargajual;
			}
			$get_folio = Folio::where('registrasi_id',$permintaan->registrasi_id)->where('namatarif',$obat->no_resep)->where('jenis','EPO')->first();
			$get_folio->total = $total;
			$get_folio->save();
			
			$update_masterobat = Masterobat::where('id',$obat->masterobat_id)->first();
			$update_masterobat->stok = $update_masterobat->stok + $jumlah;
			$update_masterobat->save();
			
			return response()->json(['sukses'=>true]);
		}else{
			return response()->json(['sukses'=>false]);
		}
	}
		
	//PENJUALAN BEBAS
	public function penjualanBebas($registrasi_id='')
	{
			session()->forget('idpenjualan');
			$data['apoteker'] = Apoteker::pluck('nama', 'id');
			$data['user_id'] 	= DB::table('users')->where('id', Auth::user()->id)->first()->pegawai_id;
			$data['pegawai_id'] 	= Apoteker::where('pegawai_id',$data['user_id'])->first();
			$data['registrasi_id'] = $registrasi_id;
			$data['reg'] 			= Registrasi::find($registrasi_id);
			return view('penjualan.penjualanBebas', $data);
	}

	public function save_penjualan_bebas(Request $request)
	{
		request()->validate(['nama'=>'required', 'tgl_lahir'=>'required', 'alamat'=>'required']);

		$pb = new Pasien();
		$pb->pasien_luar = 1;
		$pb->nama = strtoupper($request['nama']);
		$pb->tgllahir = valid_date($request['tgl_lahir']);
		$pb->alamat = strtoupper($request['alamat']);
		$pb->save();
		
		$p = Penjualan::where('registrasi_id',$request['registrasi_id'])->first();
		$p->apoteker = $request['pembuat_resep'];
		$p->status = 'pending';
		$p->dokter_pasien_luar = !empty($request['dokter']) ? $request['dokter'] : '';
		$p->user_id = Auth::user()->id;
		$p->save();
		
		$reg = Registrasi::where('id',$request['registrasi_id'])->first();
		$reg->pasien_id = $pb->id;
		$reg->save();
		
		session(['idpenjualan'=>$p->id, 'reg_id'=>$request['registrasi_id']]);
		return redirect('penjualan/formpenjualan/'.$pb->id.'/'.session('reg_id').'/'.session('idpenjualan').'/bebas');
	}

	/* public function form_penjualan_bebas($idpasien, $idreg, $penjualan_id='')
	{
		$data['barang'] 	= Masterobat::select('id','nama', 'hargajual', 'hargajual_jkn')->get();
		$data['reg'] 		= Registrasi::find($idreg);
		$data['pasien'] 	= Pasien::find($idpasien);
		$data['folio'] 	= Folio::where('registrasi_id', '=', $idreg);
		$data['apoteker'] = Apoteker::pluck('nama', 'id');
		if($penjualan_id){
			$data['penjualan'] 	= Penjualan::find($penjualan_id);
			$data['detail'] 	= Penjualandetail::where('penjualan_id', '=', $penjualan_id)->get();
			$data['tiket'] 		= MasterEtiket::pluck('nama', 'nama');
			$data['takaran'] 	= TakaranobatEtiket::pluck('nama','nama');
			$data['aturan'] 	= Aturanetiket::pluck('aturan', 'aturan');
			$data['penj_bebas'] = PenjualanBebas::where('registrasi_id', $idreg)->first();
			$data['no'] 		= 1;
		}
		return view('penjualan.form_penjualan_bebas', $data)->with('idreg', $idreg);
	} */

	/* public function save_detail_bebas(Request $request)
	{
		request()->validate(['masterobat_id'=>'required']);
		$d = new Penjualandetail();
		$d->penjualan_id = $request['penjualan_id'];
		$d->no_resep =  $request['no_resep'];
		$d->masterobat_id = $request['masterobat_id'];
		$d->jumlah = $request['jumlah'];
		$harga = Masterobat::select('hargajual')->where('id', $request['masterobat_id'])->first()->hargajual;

			if($request['masterobat_id'] == config('app.obatRacikan_id')){
				$harga = rupiah($request['racikan']);
			}

		$d->hargajual = $harga * $request['jumlah'];
		$d->etiket = $request['tiket'].' '.$request['komposisi'].' '.$request['takaran'].' '.$request['waktu'];
		$d->cetak = $request['cetak'];
		$d->save();
		return redirect('penjualan/formpenjualanbebas/'.$request['pasien_id'].'/'.$request['idreg'].'/'.$request['penjualan_id']);
	}

	public function deleteDetailBebas($id, $idpasien, $idreg, $penjualan_id)
	{
		Penjualandetail::find($id)->delete();
		return redirect('penjualan/formpenjualanbebas/'.$idpasien.'/'.$idreg.'/'.$penjualan_id);
	}

	public function save_totalpenjualan_bebas($penjualan_id='')
	{
		DB::transaction(function () use($penjualan_id) {
			$total = 0;
			$det = Penjualandetail::where('penjualan_id', $penjualan_id)->get();
			foreach ($det as $key => $d) {
				$total += $d->hargajual;
			}
			$total;

			$pj = Penjualan::find($penjualan_id);
			$reg = Registrasi::find(Penjualan::find($penjualan_id)->registrasi_id);

			$fol = new Folio();
			$fol->registrasi_id = $reg->id;
			$fol->namatarif     = $pj->no_resep;
			$fol->total         = $total;
			$fol->tarif_id      = 0;
			$fol->lunas         = 'N';
			$fol->jenis         = 'ORJ';
			$fol->pasien_id     = $reg->pasien_id;
			$fol->dokter_id     = $reg->dokter_id;
			$fol->poli_id       = $reg->poli_id;
			$fol->user_id       = Auth::user()->id;
			$fol->save();

			// Insert ke Tagihan
			$tag = new Tagihan();
			$tag->user_id          = Auth::user()->id;
			$tag->registrasi_id    = $reg->id;
			$tag->dokter_id        = 1; //$reg->dokter_id;
			$tag->diskon           = 0;
			$tag->pasien_id        = 0;
			$tag->harus_dibayar    = $total;
			$tag->subsidi          = 0;
			$tag->dijamin          = 0;
			$tag->selisih_positif  = 0;
			$tag->selisih_negatif  = 0;
			$tag->approval_tanggal = date('Y-m-d');
			$tag->user_approval    = '';
			$tag->pembulatan       = 0;
			$tag->save();
		});
		return redirect('farmasi/laporan/etiketbebas/'.$penjualan_id);
	}
 */
	
	//UPDATE PENJUALAN OBAT
	public function detailPenjualan($penjualan_id)
	{
		$p = Penjualan::find($penjualan_id);
		$data = Penjualandetail::where('penjualan_id', $penjualan_id)->get();
		$reg = Registrasi::find($p->registrasi_id);
		return view('penjualan.detailPenjualan', compact('data', 'reg'))->with('no',1);
	}

	public function hapusObat($id)
	{
		$detail = Penjualandetail::find($id);
		$penjualan = Penjualan::find($detail->penjualan_id);
		$folio = Folio::where('registrasi_id', $penjualan->registrasi_id)->where('namatarif', $detail->no_resep)->where('tarif_id', 10000)->first();
		if ($folio) {
			$folio->total = $folio->total - $detail->hargajual;
			$folio->update();
		}
		Activity::log('penjualan_edit_'.Auth::user()->name.' menghapus obat '.Masterobat::find($detail->masterobat_id)->nama.' senilai '.number_format($detail->hargajual).' no struk '.$detail->no_resep);
		$detail->delete();
		return response()->json(['sukses'=>true, 'penjualan_id'=>$penjualan->id]);
	}

	public function tambahPenjualan($penjualan_id)
	{
		$data['penjualan'] = Penjualan::find($penjualan_id);
		$data['barang'] = Masterobat::select('id','nama', 'hargajual', 'hargajual_jkn')->get();
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['tiket'] = MasterEtiket::pluck('nama', 'nama');
		$data['takaran'] = TakaranobatEtiket::pluck('nama','nama');
		return view('penjualan.tambahPenjualan', $data);
	}

	public function saveTambahPenjualan(Request $request)
	{
		if(!empty($request['masterobat_id']) && !empty($request['expired']))
		{
			$cek = Penjualandetail::where('masterobat_id', $request['masterobat_id'])->where('penjualan_id', $request['penjualan_id'])->count();
			if ($cek > 0) {
				$pj = Penjualandetail::where('masterobat_id', $request['masterobat_id'])->where('penjualan_id', $request['penjualan_id'])->first();
				$pj->jumlah = $pj->jumlah + $request['jumlah'];
				
				$harga = Masterobat::select('hargajual')->where('id', $request['masterobat_id'])->first()->hargajual;
				if($request['masterobat_id'] == config('app.obatRacikan_id')){
					$harga = rupiah($request['racikan']);
				}
				$pj->hargajual = $pj->hargajual + ($harga * $request['jumlah']);
				$pj->informasi1 = $request['informasi1'];
				$pj->informasi2 = $request['informasi2'];
				$pj->expired = $request['expired'];
				$pj->update();
				Activity::log('penjualan_edit_'.Auth::user()->name.' menambahkan obat '.Masterobat::find($request['masterobat_id'])->nama.' senilai '.number_format($harga * $request['jumlah']).' no struk '.$pj->no_resep);
				$folio = Folio::where('registrasi_id', $request['registrasi_id'])->where('namatarif', $pj->no_resep)->where('tarif_id', 10000)->first();
				$folio->total = $folio->total + ($harga * $request['jumlah']);
				$folio->update();
			} else {
				$d = new Penjualandetail();
				$d->penjualan_id = $request['penjualan_id'];
				$d->no_resep =  $request['no_resep'];
				$d->masterobat_id = $request['masterobat_id'];
				$d->jumlah = $request['jumlah'];
				
				$harga = Masterobat::select('hargajual')->where('id', $request['masterobat_id'])->first()->hargajual;
					if (substr($request['tipe_rawat'],0,1) == 'J') {
						$d->tipe_rawat = 'TA';
					} elseif (substr($request['tipe_rawat'],0,1) == 'G') {
						$d->tipe_rawat = 'TG';
					} elseif (substr($request['tipe_rawat'],0,1) == 'I') {
						$d->tipe_rawat = 'TI';
					}

				$d->hargajual = $harga * $request['jumlah'];
				$d->informasi1 = $request['informasi1'];
				$d->informasi2 = $request['informasi2'];
				$d->expired = $request['expired'];
				$d->etiket = $request['tiket'].' '.$request['takaran'];
				$d->cetak = $request['cetak'];
				$d->save();
				Activity::log('penjualan_edit_'.Auth::user()->name.' menambahkan obat '.Masterobat::find($request['masterobat_id'])->nama.' senilai '.number_format($d->hargajual).' no struk '.$d->no_resep);
				$folio = Folio::where('registrasi_id', $request['registrasi_id'])->where('namatarif', $d->no_resep)->where('tarif_id', 10000)->first();
				$folio->total = $folio->total + $d->hargajual;
				$folio->update();
			}
			return response()->json(['sukses' => true, 'penjualan_id' => $request['penjualan_id']]);
		} else {
			return response()->json(['sukses' => false, 'penjualan_id' => $request['penjualan_id']]);
		}

	}

	public function laporan()
	{
		if(strtolower(Auth::user()->role()->first()->name)=='administrator' || strtolower(Auth::user()->role()->first()->name)=='apotik' )
        {
			return view('penjualan.laporan.index');
        }else{
            return redirect('/dashboard');
        }
		
	}

	public function laporanPenjualan(Request $request)
	{
		if(strtolower(Auth::user()->role()->first()->name)=='administrator' || strtolower(Auth::user()->role()->first()->name)=='apotik' )
        {
			request()->validate(['tga'=>'required', 'tgb'=>'required']);
			$tga = $request['tga']; 
			$tgb = $request['tgb'];
			$penjualan = Folio::whereIn('jenis', ['ORJ','ORD','ORI','ORA'])->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
			$jkn = Folio::whereIn('jenis', ['ORJ','ORD','ORI','ORA'])->where('cara_bayar_id', 1)->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
			if ($request['check']) {
			return view('penjualan.laporan.index', compact('penjualan', 'jkn', 'tga', 'tgb'))->with('no', 1);
			}elseif ($request['pdf']) {
				$no=1;
				$config = Config::find(1);
				$pdf = PDF::loadView('penjualan.laporan.pdf_laporan_penjualan', compact('config','penjualan', 'jkn', 'tga', 'tgb','no'),[
				'orientation' => 'L']);
				return $pdf->stream();

			  } 
        }else{
            return redirect('/dashboard');
        }
		
	}

	public function laporanPenjualanDetail($no_faktur)
	{
		$detail = Penjualandetail::where('no_resep', $no_faktur)->get();
		$total = Penjualandetail::where('no_resep', $no_faktur)->sum('hargajual');
		return view('penjualan.laporan.detailPenjualan', compact('detail', 'total'))->with('no', 1);
	}

	//LAPORAN PENUUALAN OBAT 
	public function laporanPenjualanobat()
	{
		if(strtolower(Auth::user()->role()->first()->name)=='administrator' || strtolower(Auth::user()->role()->first()->name)=='apotik' )
        {
			return view('penjualan.obat.index');
        }else{
            return redirect('/dashboard');
        }
		
	}

	public function laporanPenjualanobat_request(Request $request)
	{
		if(strtolower(Auth::user()->role()->first()->name)=='administrator' || strtolower(Auth::user()->role()->first()->name)=='apotik' )
        {
			request()->validate(['tga'=>'required', 'tgb'=>'required']);
			$tga = $request['tga']; 
			$tgb = $request['tgb'];
			$penjualan = Penjualandetail::join('masterobats','masterobats.id','=','penjualandetails.masterobat_id')->whereBetween('penjualandetails.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->select('masterobats.nama','penjualandetails.hargasatuan',db::raw("SUM(penjualandetails.jumlah) AS total_jumlah"),db::raw("SUM(penjualandetails.hargajual) AS total"))->groupBy('penjualandetails.masterobat_id')->get();
			$total_penjualan = Penjualandetail::join('masterobats','masterobats.id','=','penjualandetails.masterobat_id')->whereBetween('penjualandetails.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->select('masterobats.nama','penjualandetails.hargasatuan',db::raw("SUM(penjualandetails.jumlah) AS total_jumlah"),db::raw("SUM(penjualandetails.hargajual) AS total"))->first();
			if ($request['check']) {
			return view('penjualan.obat.index', compact('penjualan','tga', 'tgb','total_penjualan'))->with('no', 1);
			}elseif ($request['pdf']) {
				$no=1;
				$config = Config::find(1);
				$pdf = PDF::loadView('penjualan.obat.pdf_laporan_penjualan', compact('config','penjualan', 'tga', 'tgb','no','total_penjualan'),[
				'orientation' => 'L']);
				return $pdf->stream();

			  } 
        }else{
            return redirect('/dashboard');
        }
		
	}



}
