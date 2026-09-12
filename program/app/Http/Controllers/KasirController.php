<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Config\Entities\Config;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Tagihan;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Registrasi\Entities\Tipelayanan;
use Modules\Rujukan\Entities\Rujukan;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Tarif\Entities\Tarif;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\HistoriStatus;
use Modules\Bed\Entities\Bed;
use Modules\Poli\Entities\Poli;
use Flashy;
use App\Pembayaran;
use App\Foliopelaksana;
use App\Penjualanbebas;
use App\Rawatinap;
use App\Penjualan;
use App\User;
use App\Penjualandetail;
use App\Inacbg;
use App\AkunKeuangan;

use Validator;
use Activity;
use Excel;
use Auth;
use PDF;
use DB;
use App\Piutang;
use App\UangMuka;
use App\HistorikunjunganIRJ;
use App\HistorikunjunganIGD;
use App\HistoriRawatInap;
use App\Pasienlangsung;
use Yajra\DataTables\DataTables;

class KasirController extends Controller
{
  public function rawat_jalan(){
		$today 	= Registrasi::where('status_reg', 'like', 'J%')
							->whereIn('posisi_pasien', ['konfirmasi farmasi'])
							->where('pulang', null)
							->get();
		return view('kasir.index', compact('today'))->with('no', 1);
	}

  /* public function rawatjalanByTanggal(Request $request){
		request()->validate(['tanggal'=>'required']);
		$today 	=	Registrasi::where('status_reg', 'like', 'J%')
							->where('created_at', 'like', valid_date($request['tanggal']).'%')
							->where('pulang', null)
							->get();
		return view('kasir.index', compact('today'))->with('no', 1);
	} */

  /* public function ajax_rawat_jalan(){
		$today 	= Registrasi::leftJoin('penjualans', function($join) {
								$join->on('registrasis.id', '=', 'penjualans.registrasi_id');
								$join->whereIn('penjualans.status',['proses','selesai']);
							})
							->where('registrasis.status_reg', 'like', 'J%')
							->select('registrasis.*', 'penjualans.status as status_obat')
							->where('registrasis.pulang', null)
							->get();
		return view('kasir.rawat_jalan',compact('today'))->with('no', 1);
	} */

  public function rawat_inap(){
		$today 	= Registrasi::where('status_reg', 'like', 'I%')
							->whereIn('posisi_pasien', ['konfirmasi farmasi'])
							->where('pulang', null)
							->get();
		return view('kasir.irna', compact('today'))->with('no', 1);
	}

  /* public function rawat_inap_byTanggal(Request $request){
		request()->validate(['tga'=>'required', 'tgb'=>'required']);
		$today	=	Registrasi::join('penjualans','registrasis.id','=','penjualans.registrasi_id')
							->whereIn('penjualans.status',['proses','selesai'])
							->where('registrasis.status_reg', 'like', 'I%')
							->whereBetween('registrasis.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
							->where('registrasis.pulang', null)
							->select('registrasis.*', 'penjualans.status as status_obat')
							->get();
		return view('kasir.irna', compact('today'))->with('no', 1);
	}
 */
  public function igd(){
      $today 	= Registrasi::join('penjualans','registrasis.id','=','penjualans.registrasi_id')
								->whereIn('penjualans.status',['proses','selesai'])
								->where('registrasis.status_reg', 'like', 'G%')
								->where('registrasis.pulang', null)
								->select('registrasis.*', 'penjualans.status as status_obat')
                ->get();
      return view('kasir.index_igd', compact('today'))->with('no', 1);
    }

  public function igdByTanggal(Request $request){
      request()->validate(['tga'=>'required', 'tgb'=>'required']);
      $today 	= Registrasi::join('penjualans','registrasis.id','=','penjualans.registrasi_id')
								->whereIn('penjualans.status',['proses','selesai'])
								->where('registrasis.status_reg', 'like', 'G%')
								->where('registrasis.verif_rj', 'Y')
								->where('registrasis.verif_kasa', 'Y')
								->where('registrasis.pulang', null)
								->whereBetween('registrasis.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tga']).' 23:59:59' ])
								->whereIn('registrasis.lunas', !empty($request['ket_lunas']) ? [$request['ket_lunas']] : ['Y', 'N'])
								->whereIn('registrasis.bayar', !empty($request['carabayar']) ? [$request['carabayar']] : ['1', '2', '3', '4'])
								->whereIn('registrasis.tipe_jkn', !empty($request['tipe_jkn']) ? [$request['tipe_jkn']] : ['PBI', 'NON PBI'])
								->select('registrasis.*', 'penjualans.status as status_obat')
								->get();

      return view('kasir.index_igd', compact('today'))->with('no', 1);
    }

  public function ajax_igd(){
      $today = 	Registrasi::join('penjualans','registrasis.id','=','penjualans.registrasi_id')
								->whereIn('penjualans.status',['proses','selesai'])
								->where('registrasis.status_reg', 'like', 'G%')
								->where('registrasis.created_at', 'LIKE', date('Y-m-d'.'%'))
								->select('registrasis.*', 'penjualans.status as status_obat')
								->get();
      return view('kasir.rawat_jalan',compact('today'))->with('no', 1);
    }

  /* public function byRM(Request $request){
      request()->validate(['keyword'=>'required']);
      $keyword = $request['keyword'];
      $byRM = DB::table('registrasis')
            ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')->where('pasiens.no_rm', '=', $keyword)->orWhere('pasiens.nama', 'like', '%'.$keyword.'%')
            ->select('pasiens.id as pasienid','pasiens.nama', 'pasiens.no_rm', 'registrasis.id as regid', 'registrasis.reg_id', 'registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.bayar')
            ->get();
      // return $byRM;
      return view('kasir.rawat_jalan',compact('byRM'))->with('no', 1);
    }

    public function byTanggal(Request $request)
    {
      request()->validate(['tga'=>'required', 'tgb'=>'required']);
      $tga = $request['tga'];
      $tgb = $request['tgb'];
      $today = Registrasi::whereBetween('created_at', [$tga, $tgb])->get();
      return view('kasir.rawat_jalan',compact('today'))->with('no', 1);
    } */
	
	public function kasirBayar($reg_id, $pasien_id){
		$data['reg'] 		= Registrasi::where('id',$reg_id)->whereIn('posisi_pasien',['konfirmasi farmasi','pengembalian uang retur'])->first();
		if($data['reg']==null){
			return redirect('/dashboard');
		}
		$data['status_reg'] = substr($data['reg']->status_reg,0,1);
		$data['uang_muka'] 	= UangMuka::where('registrasi_id',$reg_id)->where('deleted_by',null)->get();
		$data['pembayaran']	= null;
		$lunas = 'N';
		if($data['reg']->posisi_pasien=='pengembalian uang retur'){
			$data['pembayaran'] = Pembayaran::where('registrasi_id',$reg_id)->first();
			$lunas = 'Y';
		}
		$data['fol'] 				= Folio::where('registrasi_id', '=', $reg_id)->where('lunas', $lunas)->get();
		$data['tagihan'] 		= Folio::where('registrasi_id', $reg_id)->where('lunas', $lunas)->sum('total');
		
		$data['pasien'] 		= Pasien::find($pasien_id);
		$data['eklaim'] 		= Inacbg::where('registrasi_id', $reg_id)->first();
		$data['hist_kamar'] = HistoriRawatInap::where('registrasi_id', $reg_id)->orderBy('id', 'ASC')->get();
		return view('kasir.form_bayar', $data)->with('no', 1);
	}
	
	public function saveBayar(Request $request){
		$layanan = "";
		if($request['status_reg'] == 'G'){
			$cek_kuitansi = Pembayaran::where('no_kwitansi', 'LIKE', 'RD-'.date('Ymd').'-%')->count() + 1;
			$no_kuitansi = 'RD-'.date('Ymd').'-'.sprintf("%05s", $cek_kuitansi);
			$layanan = "rawat darurat";
		}elseif($request['status_reg']=='J'){
			$cek_kuitansi = Pembayaran::where('no_kwitansi', 'LIKE', 'RJ-'.date('Ymd').'-%')->count() + 1;
			$no_kuitansi = 'RJ-'.date('Ymd').'-'.sprintf("%05s", $cek_kuitansi);
			$layanan = "rawat jalan";
		}elseif($request['status_reg']=='I'){
			$cek_kuitansi = Pembayaran::where('no_kwitansi', 'LIKE', 'IRNA-'.date('Ymd').'-%')->count() + 1;
			$no_kuitansi = 'IRNA-'.date('Ymd').'-'.sprintf("%05s", $cek_kuitansi);
			$layanan = "rawat inap";
		}elseif($request['status_reg']=='A'){
			$cek_kuitansi = Pembayaran::where('no_kwitansi', 'LIKE', 'RB-'.date('Ymd').'-%')->count() + 1;
			$no_kuitansi = 'RB-'.date('Ymd').'-'.sprintf("%05s", $cek_kuitansi);
			$layanan = "penjualan bebas";
		}
		$reg = Registrasi::find($request['registrasi_id']);
		if($reg->pulang==1){
			Flashy::info('Pasien '.$reg->pasien->nama.' sudah melakukan pembayaran');
			return redirect('/kasir/cetak');
		}
		$status_reg = $request['status_reg'];
		$tanggal_pulang_keluar = date('Y-m-d H:i:s');

		if($request['total'] <> 0){
			DB::transaction(function () use ($request, $no_kuitansi, $reg, $status_reg, $layanan,$tanggal_pulang_keluar) {
				$pem = Pembayaran::where('registrasi_id',$reg->id)->first();
				if($pem==null){
					$pem = new Pembayaran();
				}
				$pem->jenis = $request['jenis'];
				$pem->user_id = Auth::user()->id;
				$pem->total = $request['total'];
				$pem->dibayar = !empty($request['totalBayar']) ? rupiah($request['totalBayar']) : 0;
				$pem->iur = !empty($request['iur']) ? rupiah($request['iur']) : 0;
				$pem->flag = 'Y';
				$pem->registrasi_id = $reg->id;
				if($reg->penjualan_bebas_apotek==1){
					$pem->dokter_id = 0;
				}else{
					$pem->dokter_id = $reg->dokter_id;
				}
				$pem->diskon_persen = !empty($request['diskon_persen']) ? $request['diskon_persen'] : 0;
				$pem->diskon_rupiah = !empty($request['diskon_rupiah']) ? rupiah($request['diskon_rupiah']) : 0;
				if($reg->bayar==3){
					$pem->diskon_asuransi = !empty($request['diskon_asuransi']) ? $request['diskon_asuransi'] : 0;
				}
				$pem->metode_bayar = !empty($request['metode_bayar']) ? $request['metode_bayar'] : null;
				$pem->keterangan = !empty($request['keterangan']) ? $request['keterangan'] : '';
				$pem->no_kwitansi = $no_kuitansi;
				$pem->pasien_id = $reg->pasien_id;
				$pem->save();
				Activity::log('kasir_'.Auth::user()->name.' menerima pembayaran '.$layanan.' senilai '.number_format($pem->total).' no kuitansi '.$pem->no_kwitansi);
				
				$fol = Folio::where('registrasi_id', $request['registrasi_id'])->get();
				foreach ($fol as $key => $d) {
					$d->lunas = 'Y';
					$d->dibayar = $d->total;
					$d->waktu_dibayar = date('Y-m-d');
					$d->no_kuitansi = $pem->no_kwitansi;
					$d->update();
				}
				session(['idk'=>$pem->id]);
				$reg->lunas = 'Y';
				$reg->pulang = 1;
				$reg->tgl_pulang = $tanggal_pulang_keluar;
				$reg->status_reg = $status_reg.'3';
				$reg->posisi_pasien = 'selesai pembayaran';
				$penjualan = Penjualan::where('registrasi_id',$reg->id)->first();
				if($penjualan!=null){
					$detail_penjualan = Penjualandetail::where('penjualan_id',$penjualan->id)->get();
					if($detail_penjualan->count()==0){
						$reg->posisi_pasien = 'selesai';
					}
				}else{
					$reg->posisi_pasien = 'selesai';
				}
				$reg->update();

				if($status_reg=='I'){
					$ranap = Rawatinap::where('registrasi_id', $request['registrasi_id'])->first();
					$history = new HistoriStatus();
					$history->registrasi_id = $request['registrasi_id'];
					$history->status        = 'I3';
					$history->bed_id        = !empty($ranap->bed_id) ? $ranap->bed_id : 0;
					$history->user_id       = Auth::user()->id;
					$history->save();
					
					$ranap->tgl_keluar = $tanggal_pulang_keluar;
					$ranap->update();
					
					$hist_ranap = HistoriRawatInap::where('registrasi_id', $request['registrasi_id'])->orderBy('id', 'DESC')->limit(1)->first();
					$hist_ranap->tgl_keluar = $tanggal_pulang_keluar;
					$hist_ranap->update();

					$bed = Bed::find($ranap->bed_id);
					$bed->reserved = 'N';
					$bed->update();
				}
				
				// Update Pulang SEP
				if($reg->bayar==1){
					if($reg->no_jkn!=null AND $reg->no_jkn!=""){
						updateTglPulangSEP($reg->no_jkn,$tanggal_pulang_keluar);
					}
				}
			});
			return redirect('/kasir/cetak/cetakkuitansi/'.session('idk'));
		}
  }
	
	/* 
  public function bayar_rawat_jalan($reg_id, $pasien_id){
		$data['reg'] = Registrasi::find($reg_id);
		if($data['reg']==null){
			return redirect('/kasir/rawatjalan');
		}
		$data['tag'] = Tagihan::where('registrasi_id', '=', $reg_id)->get();
		$data['fol'] = Folio::where('registrasi_id', '=', $reg_id)->where('lunas', 'N')->get();
		$data['pasien'] = Pasien::find($pasien_id);
		$data['tagihan'] = Folio::where('registrasi_id', $reg_id)->where('lunas', 'N')->sum('total');
		$data['eklaim'] = Inacbg::where('registrasi_id', $reg_id)->first();
		$data['get_bayar'] = Pembayaran::where('registrasi_id', $reg_id)->first();
		$data['status_bayar'] = false;
		if($data['get_bayar']!=null){
			if($data['get_bayar']->flag=='Y'){
				$data['status_bayar'] = true;
			}
		}
		return view('kasir.bayar_rawat_jalan', $data)->with('no', 1);
	}

  public function save_bayar_rawat_jalan(Request $request){
		$r = Registrasi::find($request['registrasi_id']);
		if(substr($r->status_reg,0,1) == 'G'){
			$cek_kuitansi = Pembayaran::where('no_kwitansi', 'LIKE', 'RD-'.date('Ymd').'-%')->count() + 1;
			$no_kuitansi = 'RD-'.date('Ymd').'-'.sprintf("%05s", $cek_kuitansi);
		}else {
			$cek_kuitansi = Pembayaran::where('no_kwitansi', 'LIKE', 'RJ-'.date('Ymd').'-%')->count() + 1;
			$no_kuitansi = 'RJ-'.date('Ymd').'-'.sprintf("%05s", $cek_kuitansi);
		}

		if($request['total'] <> 0){
			DB::transaction(function () use ($request, $no_kuitansi, $r) {
				$reg = Registrasi::find($request['registrasi_id']);
				// Insert pembayaran
				$pem = new Pembayaran();
				$pem->jenis = $request['jenis'];
				$pem->user_id = Auth::user()->id;
				$pem->total = $request['total'];
				$pem->dibayar = !empty($request['totalBayar']) ? rupiah($request['totalBayar']) : $request['total'];
				$pem->iur = !empty($request['iur']) ? rupiah($request['iur']) : 0;
				$pem->flag = 'Y';
				$pem->registrasi_id = $reg->id;
				$pem->dokter_id = $reg->dokter_id;
				$pem->diskon_persen = !empty($request['diskon_persen']) ? $request['diskon_persen'] : 0;
				$pem->diskon_rupiah = !empty($request['diskon_rupiah']) ? $request['diskon_rupiah'] : 0;
				$pem->no_kwitansi = $no_kuitansi;
				$pem->pasien_id = $reg->pasien_id;
				$pem->save();
				Activity::log('kasir_'.Auth::user()->name.' menerima pembayaran senilai '.number_format($pem->total).' no kuitansi '.$pem->no_kwitansi);
				//Update Folio
				$fol = Folio::where('registrasi_id', $request['registrasi_id'])->where('lunas', 'N')->get();
				foreach ($fol as $key => $d) {
					$d->lunas = 'Y';
					$d->dibayar = $d->total;
					$d->waktu_dibayar = date('Y-m-d');
					$d->no_kuitansi = $pem->no_kwitansi;
					$d->update();
				}
				session(['idk'=>$pem->id]);
				//Update registrasi
				$reg->lunas = 'Y';
				if(substr($reg->status_reg,0,1) == 'G'){
					$reg->status_reg = 'G3';
				}else{
					$reg->status_reg = 'J3';
				}
				$reg->pulang = 1;
				$reg->tgl_pulang = date('Y-m-d H:i:s');
				$reg->update();

				$piutang = Piutang::where('registrasi_id', $request['registrasi_id'])->first();
				if($piutang){
						$piutang->tglbayar = date('Y-m-d');
						$piutang->update();
				}
			});
			return redirect('/kasir/rawatjalan/cetakkuitansi/'.session('idk'));
		}
	}

  public function bayar_rawat_inap($reg_id, $pasien_id){
		$data['reg'] 		= Registrasi::find($reg_id);
		if($data['reg']==null){
			return redirect('/kasir/rawatinap');
		}
		$data['fol'] 		= Folio::where('registrasi_id', '=', $reg_id)->where('lunas', 'N')->get();
		$data['pasien'] 	= Pasien::find($pasien_id);
		$data['tagihan'] 	= Folio::where('registrasi_id', $reg_id)->where('lunas', 'N')->sum('total');
		$data['eklaim'] 	= Inacbg::where('registrasi_id', $reg_id)->first();
		$data['hist_kamar'] 	= HistoriRawatInap::where('registrasi_id', $reg_id)->orderBy('id', 'ASC')->get();
		return view('kasir.bayar_rawat_inap', $data)->with('no', 1);
	}

  public function save_bayar_rawat_inap(Request $request){
		$cek_kuitansi = Pembayaran::where('no_kwitansi', 'LIKE', 'IRNA-'.date('Ymd').'-%')->count() + 1;
		$no_kuitansi = 'IRNA-'.date('Ymd').'-'.sprintf("%05s", $cek_kuitansi);

		if($request['total'] <> 0){
			DB::transaction(function () use ($request, $no_kuitansi) {
				$reg = Registrasi::find($request['registrasi_id']);
				// Insert pembayaran
				$pem = new Pembayaran();
				$pem->jenis = $request['jenis'];
				$pem->user_id = Auth::user()->id;
				$pem->total = $request['total'];
				$pem->dibayar = !empty($request['totalBayar']) ? rupiah($request['totalBayar']) : $request['total'];
				$pem->iur = !empty($request['iur']) ? rupiah($request['iur']) : 0;
				$pem->flag = 'Y';
				$pem->registrasi_id = $reg->id;
				$pem->dokter_id = $reg->dokter_id;
				$pem->diskon_persen = !empty($request['diskon_persen']) ? $request['diskon_persen'] : 0;
				$pem->diskon_rupiah = !empty($request['diskon_rupiah']) ? $request['diskon_rupiah'] : 0;
				$pem->no_kwitansi = $no_kuitansi;
				$pem->pasien_id = $reg->pasien_id;
				$pem->save();
				Activity::log('kasir_'.Auth::user()->name.' menerima pembayaran rawatinap senilai '.number_format($pem->total).' no kuitansi '.$pem->no_kwitansi);
				//Update Folio
				$fol = Folio::where('registrasi_id', $request['registrasi_id'])->get();
				foreach ($fol as $key => $d) {
					$d->lunas = 'Y';
					$d->dibayar = $d->total;
					$d->waktu_dibayar = date('Y-m-d');
					$d->no_kuitansi = $pem->no_kwitansi;
					$d->update();
				}
				session(['idk'=>$pem->id]);
				//Update registrasi
				$reg->lunas = 'Y';
				$reg->pulang = 1;
				$reg->tgl_pulang = date('Y-m-d H:i:s');
				$reg->status_reg = 'I3';
				$reg->update();

				// Insert Histori
				$ranap = Rawatinap::where('registrasi_id', $request['registrasi_id'])->first();
				$history = new HistoriStatus();
				$history->registrasi_id = $request['registrasi_id'];
				$history->status        = 'I3';
				$history->bed_id        = !empty($ranap->bed_id) ? $ranap->bed_id : 0;
				$history->user_id       = Auth::user()->id;
				$history->save();
				
				$ranap->tgl_keluar = date('Y-m-d H:i:s');
				$ranap->update();
				
				$hist_ranap = HistoriRawatInap::where('registrasi_id', $request['registrasi_id'])->orderBy('id', 'DESC')->limit(1)->first();
				$hist_ranap->tgl_keluar = date('Y-m-d H:i:s');
				$hist_ranap->update();

				$bed = Bed::find($ranap->bed_id);
				$bed->reserved = 'N';
				$bed->update();

			});
			return redirect('/kasir/rawatjalan/cetakkuitansi/'.session('idk'));
		}
    }
	 */
	
	public function cetak_kuitansi_langsung_irna($id='')
	{
		$kuitansi = Pembayaran::find($id);
		$folio = Folio::where('registrasi_id','=', $kuitansi->registrasi_id)->where('lunas', 'Y')->get();
		$jml = Folio::where('registrasi_id','=', $kuitansi->registrasi_id)->where('lunas', 'Y')->sum('total');
		return view('kasir.kuitansi_irna', compact('kuitansi', 'folio', 'jml'));
		// $pdf = PDF::loadView('kasir.kuitansi', compact('kuitansi', 'folio', 'jml'));
		// return $pdf->stream();
	}

	public function cetak_kuitansi_langsung($id='')
	{
		$kuitansi = Pembayaran::find($id);
		$folio = Folio::where('registrasi_id','=', $kuitansi->registrasi_id)->where('lunas', 'Y')->get();
		$jml = Folio::where('registrasi_id','=', $kuitansi->registrasi_id)->where('lunas', 'Y')->sum('total');
		return view('kasir.kuitansi', compact('kuitansi', 'folio', 'jml'));
		// $pdf = PDF::loadView('kasir.kuitansi', compact('kuitansi', 'folio', 'jml'));
		// return $pdf->stream();
	}

	public function cetak()
	{
		if((session('tga')) AND (session('tgb'))){			
			$pemb = Pembayaran::whereBetween('created_at', [ valid_date(session('tga')).' 00:00:00', valid_date(session('tgb')).' 23:59:59' ])->where('flag', 'Y')->get();
		}else{
			$pemb = Pembayaran::where('created_at', 'LIKE', date('Y-m-d').'%')->where('flag', 'Y')->orderBy('id', 'desc')->get();
		}
		return view('kasir.cetak', compact('pemb'))->with('no', 1);
	}

	public function cetakByTanggal(Request $request)
	{
		request()->validate(['tga'=>'required', 'tgb'=>'required']);
		session(['tga'=>$request['tga'],'tgb'=>$request['tgb']]);
		$pemb = Pembayaran::whereBetween('created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])->where('flag', 'Y')->get();
		return view('kasir.cetak', compact('pemb'))->with('no', 1);
	}

	public function cetakkuitansi($id='')
	{
		$kuitansi 	= Pembayaran::find($id);
		$reg 				= Registrasi::find($kuitansi->registrasi_id);
		$uang_muka	= UangMuka::where('registrasi_id',$reg->id)->where('deleted_by',null)->sum('total');		
		$folio 			= Folio::where('registrasi_id','=', $kuitansi->registrasi_id)
								->where('lunas', 'Y')
								->get();
		$penjualan 	= Penjualan::where('registrasi_id', $reg->id)->select('id','dokter_pasien_luar')->first();
		if($reg->posisi_pasien=='pengembalian uang retur'){
			$dtl_jual 	= Penjualandetail::where('penjualan_id',$penjualan->id)->where('retur',1)->where('retur_bayar',null)->update(['retur_bayar'=>1]);
			$reg->posisi_pasien = 'selesai';
			$reg->update();
		}
		return view('kasir.cetakKuitansi', compact('kuitansi', 'reg', 'folio', 'penjualan', 'uang_muka'));
	}
	
	public function cetak_RincianBiaya($id='')
	{
		$kuitansi 	= Pembayaran::find($id);
		if($kuitansi==null){
			return redirect('kasir/cetak');
		}
		$ruanginap	= HistoriRawatInap::where('registrasi_id',$kuitansi->registrasi_id)->get();
		$reg 				= Registrasi::find($kuitansi->registrasi_id);
		$folio_rj		= Folio::leftJoin('tarifs', 'folios.tarif_id', '=', 'tarifs.id')
									->where('folios.registrasi_id','=', $kuitansi->registrasi_id)
									->where('folios.lunas', 'Y')
									->whereIn('folios.jenis', ['TA','TG','ORA','ORD','ORJ'])
									->groupBy('folios.tarif_id')
									->selectRaw('count(folios.tarif_id) as jumlah, sum(folios.total) as total_all, folios.*, tarifs.kategoritarif_id as kategoritarif')
									->get();									
		$folio_ri		= Folio::leftJoin('tarifs', 'folios.tarif_id', '=', 'tarifs.id')
									->where('folios.registrasi_id','=', $kuitansi->registrasi_id)
									->where('folios.lunas', 'Y')
									->whereIn('folios.jenis', ['TI','ORI','EPO','PEM'])
									->groupBy('folios.tarif_id')
									->selectRaw('count(folios.tarif_id) as jumlah, sum(folios.total) as total_all, folios.*, tarifs.kategoritarif_id as kategoritarif')
									->get();									
		$total_titipan 	= UangMuka::where('registrasi_id',$kuitansi->registrasi_id)->where('deleted_by',null)->sum('total');
		$jml 				= Folio::where('registrasi_id','=', $kuitansi->registrasi_id)->where('lunas', 'Y')->sum('total');
		$no 				= 1;
		return view('kasir.cetakRincianBiaya', compact('reg','kuitansi', 'folio_rj', 'folio_ri', 'jml', 'no', 'ruanginap', 'total_titipan'));
	}

	//======== RAWAT INAP =================================
	public function verifikasi()
	{
		return view('kasir.verifikasiDataTable');
	}

	public function getDataVerifInap(Request $request)
	{
		$pasien = Pasien::where('no_rm', $request['no_rm'])->first();
		if($pasien){
			$verif 	= Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
								->where('registrasis.status_reg', 'I3')
								->where('registrasis.pasien_id', $pasien->id)
								->select('registrasis.id', 'registrasis.pasien_id', 'registrasis.bayar', 'registrasis.tipe_jkn','rawatinaps.kamar_id', 'rawatinaps.bed_id', 'rawatinaps.kelas_id', 'rawatinaps.kelompokkelas_id', 'rawatinaps.tgl_masuk', 'rawatinaps.tgl_keluar')
								->orderBy('registrasis.updated_at', 'asc')->get();
		}else{
			Flashy::info('Data tidak ditemukan');
			$verif = [];
		}
		return view('kasir.verifikasiDataTable', compact('verif'))->with('no', 1);
	}

	public function getDataVerifikasi()
	{
		$verif = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
												->where('registrasis.status_reg', 'I3')
												->where('rawatinaps.tgl_keluar', '!=', '')
												->select('registrasis.id', 'registrasis.pasien_id', 'registrasis.bayar', 'registrasis.tipe_jkn','rawatinaps.kamar_id', 'rawatinaps.bed_id', 'rawatinaps.kelas_id', 'rawatinaps.kelompokkelas_id', 'rawatinaps.tgl_masuk', 'rawatinaps.tgl_keluar')
												->orderBy('registrasis.updated_at', 'asc')->get();
		return DataTables::of($verif)
		->addColumn('no_rm', function($verif){
			return $verif->pasien->no_rm;
		})
		->addColumn('nama', function($verif){
			return strtoupper($verif->pasien->nama);
		})
		->addColumn('carabayar', function($verif){
			$b = strtoupper(baca_carabayar($verif->bayar));
			$c= !empty($verif->tipe_jkn) ? ' - '.$verif->tipe_jkn : '';
			return $b.''.$c;
		})
		->addColumn('kelompok', function($verif){
			return strtoupper(baca_kelompok($verif->kelompokkelas_id));
		})
		->addColumn('kelas', function($verif){
			return strtoupper(baca_kelas($verif->kelas_id));
		})
		->addColumn('kamar', function($verif){
			return strtoupper(baca_kamar($verif->kamar_id));
		})
		->addColumn('bed', function($verif){
			return strtoupper(baca_bed($verif->bed_id));
		})
		->addColumn('verifikasi', function($verif){
			$vrf = '<a href="'.url('kasir/detail-verifikasi/'.$verif->id).'" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-check"></i></a>';
			if (Folio::where('registrasi_id', $verif->id)->where('verif_kasa', 'Y')->sum('total') > 0) {
				$cetak = '<a href="'.url('kasir/cetak-verifikasi/'.$verif->id).'" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>';
			} else {
				$cetak = NULL;
			}
			return $vrf.' '.$cetak;
		})
		->rawColumns(['verifikasi'])
		->make(true);
	}

	public function detailVerifikasi($registrasi_id='')
	{
		$data['folio'] 	= Folio::leftJoin('tarifs','folios.tarif_id','=','tarifs.id')
											->where('folios.registrasi_id', $registrasi_id)->groupBy('folios.tarif_id')
											->selectRaw('folios.id as id_folio,folios.tarif_id, sum(folios.total) as total, count(folios.verif_kasa) as verif_kasa, folios.namatarif, tarifs.*')
											->get();
		$data['reg_id'] = $registrasi_id;
		$data['reg']		= Registrasi::find($registrasi_id);
		$data['jmlbaris'] = Folio::where('registrasi_id', $registrasi_id)->groupBy('tarif_id')
													->selectRaw('tarif_id, sum(total) as total')
													->count();
		$data['i_verif'] = 1;
		$data['i_hapus'] = 1;
		return view('kasir.detailVerifikasi', $data)->with('no', 1);
	}

	public function detailTindakanVerifikasi($registrasi_id='', $tarif_id)
	{
		// $data['folio'] = Folio::where('registrasi_id', $registrasi_id)->where('tarif_id', $tarif_id)->get();
		$data['folio'] = Folio::leftJoin('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
		->where('folios.registrasi_id', $registrasi_id)->where('folios.tarif_id', $tarif_id)
		->select('folios.*', 'foliopelaksanas.dokter_pelaksana')
		->get();
		$data['reg_id'] = $registrasi_id;
		$data['reg'] = Registrasi::where('id', '=', $registrasi_id)->first();
		$data['poli'] = Folio::where('registrasi_id', '=', $registrasi_id)->distinct();
		$data['tagihan'] = Folio::where('registrasi_id',$registrasi_id)->where('lunas', 'N')->sum('total');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['perawat'] = Pegawai::pluck('nama', 'id');
		$data['kat_tarif'] = Kategoritarif::pluck('namatarif', 'id');
		$data['tarif'] = Tarif::pluck('nama', 'id');
		$data['jmlbaris'] = Folio::where('registrasi_id', $registrasi_id)->where('tarif_id', $tarif_id)->count();
		$data['i_verif'] = 1;
		$data['i_hapus'] = 1;
		return view('kasir.detailTindakanVerifikasi', $data)->with('no', 1);
	}

	public function save_tindakan(Request $request)
	{
		request()->validate(['tarif_id' => 'required']);
		DB::transaction(function() use ($request){

			$tarif = Tarif::find($request['tarif_id']);
			$fol = new Folio();
			$fol->registrasi_id = $request['registrasi_id'];
			$fol->lunas         = 'N';
			$fol->namatarif     = $tarif->nama;
			$fol->tarif_id      = $request['tarif_id'];
			$fol->jenis         = 'TI';
			$fol->total         = ($tarif->total * $request['jumlah']);
			$fol->jenis_pasien  = $request['jenis'];
			$fol->pasien_id     = $request['pasien_id'];
			$fol->dokter_id     = $request->dokter_id;
			if (!empty($request['tanggal'])) {
				$fol->created_at = valid_date($request['tanggal']);
			}
			$fol->user_id       = Auth::user()->id;
			$fol->save();

			$fp = new Foliopelaksana();
			$fp->folio_id = $fol->id;
			$fp->dpjp = $request['dokter_id'];
			$fp->dokter_pelaksana = $request['pelaksana'];
			$fp->perawat = $request['perawat'];
			$fp->pelaksana_tipe = 'TI';
			$fp->user = Auth::user()->id;
			$fp->save();

			// Insert Histori
			$bed = Rawatinap::where('registrasi_id', $request['registrasi_id'])->first();
			$history = new HistoriStatus();
			$history->registrasi_id = $request['registrasi_id'];
			$history->status        = 'I3';
			$history->bed_id        = $bed->bed_id;
			$history->user_id       = Auth::user()->id;
			$history->save();

			$bed = Bed::find($bed->bed_id);
			$bed->reserved = 'N';
			$bed->update();
		});
		Flashy::info('Tindakan berhasil ditambahkan');
		return redirect('kasir/detail-verifikasi/'.$request['registrasi_id']);
	}

	public function ubahTipeJKN(Request $request)
	{
		$reg = Registrasi::find($request['registrasi_id']);
		$reg->tipe_jkn = $request['tipe_jkn'];
		$reg->update();
		Flashy::info('Tipe JKN Pasien berhasil diubah menjadi '.$request['tipe_jkn']);
		return redirect('kasir/detail-verifikasi/'.$request['registrasi_id']);
	}

	public function batalPulang($registrasi_id)
	{
		$reg = Registrasi::find($registrasi_id);
		$reg->status_reg = 'I2';
		$reg->update();
		Flashy::info('Pasien berhasil kembali ke rawat inap');
		return redirect('kasir/verifikasi');
	}

	//Uang Muka Rawat Inap
	public function dataPasien(){
		$pasien = Registrasi::where('pulang',null)->orderBy('id', 'desc')->get();

		return DataTables::of($pasien)
			->addColumn('input', function ($pasien) {
				return '<button type="button" class="btn btn-primary btn-sm btn-flat inputPasien" data-pasien_id="' . $pasien->id . '" data-nama="' . $pasien->pasien->nama . '" data-no_rm="' . $pasien->pasien->no_rm . '"><i class="fa fa-check"></i></button>';
			})
			->addColumn('no_rm', function ($pasien) {
				return $pasien->pasien->no_rm;
			})
			->addColumn('nama', function ($pasien) {
				return $pasien->pasien->nama;
			})
			/* ->addColumn('kelamin', function ($pasien) {
				return $pasien->pasien->kelamin;
			})
			->addColumn('tgllahir', function ($pasien) {
				return $pasien->pasien->tgllahir;
			}) */
			->addColumn('alamat', function ($pasien) {
				return $pasien->pasien->alamat;
			})
			->rawColumns(['input'])
			->make(true);
	}
	
	public function uangtitipan()
	{
		return view('kasir.uang-titipan');
	}

	public function uangtitipan_byPasien(Request $request)
	{
		$data['reg'] = Registrasi::where('pasien_id', $request['pasien_id'])->where('pulang',null)->get();
		if($data['reg']->count()==0){
			Flashy::warning('Pasien tersebut tidak ditemukan');
		}
		return view('kasir.uang-titipan', $data);
	}

	public function save_uangtitipan(Request $request)
	{
		$cek = Validator::make($request->all(), [
			'nominal' => 'required',
			'nama' => 'required',
			'nohp' => 'required'
		]);

		if($cek->passes()){
			$um = new UangMuka;
			$um->registrasi_id 	= $request['registrasi_id'];
			$um->nama 					= strtoupper($request['nama']);
			$um->no_hp 					= $request['nohp'];
			$um->total 					= $request['nominal'];
			$um->keterangan 		= $request['keterangan'];
			$um->jumlah_cetak 	= 1;
			$um->created_at 		= date('Y-m-d H:i:s');
			$um->updated_by 		= Auth::user()->id;
			$um->save();
			$no_rm			= Registrasi::find($request['registrasi_id']);
			$um->total 	= number_format($request['nominal']);
			$no = date_format($um->created_at,'YmdHis');
			$terbilang = terbilang($request['nominal']);
			return response()->json(['success' => true, 'cetak' => $um, 'no_rm'=>$no_rm->pasien->no_rm, 'nama_pasien'=>$no_rm->pasien->nama, 'terbilang'=>$terbilang, 'no'=>$no]);
		} else {
			return response()->json(['errors' => $cek->errors()]);
		}
	}
	
	public function cetak_uangtitipan($id_um)
	{
		$um = UangMuka::find($id_um);
		$um->jumlah_cetak 	= ($um->jumlah_cetak+1);
		$um->save();
		$no = date_format($um->created_at,'YmdHis');
		$terbilang = terbilang($um->total);
		$no_rm			= Registrasi::find($um->registrasi_id);
		return response()->json(['success' => true, 'cetak' => $um, 'no_rm'=>$no_rm->pasien->no_rm, 'nama_pasien'=>$no_rm->pasien->nama, 'terbilang'=>$terbilang, 'no'=>$no]);
	}
	
	public function hapus_uangtitipan($id_um)
	{
		$update = UangMuka::find($id_um);
		$update->deleted_by = Auth::user()->id;
		
		if($update->update()){
			return response()->json(['success' => true]);
		}else{
			return response()->json(['success' => false]);
		}
	}


	public function tutup_transaksi()
	{
		return view('kasir.tutup_transaksi');
	}

	//TRANSAKSI LAIN LAIN
	public function transaksi_lain_lain()
	{
		$reg = Registrasi::whereIn('status_reg', ['R1', 'L1', 'A1'])->where('lunas', 'N')->where('created_at', 'LIKE', date('Y-m-d'.'%'))->get(['id', 'pasien_id', 'status_reg', 'bayar', 'user_create']);
		// return $reg; die;
		$no = 1;
		$row = [];
		foreach ($reg as $key => $d) {
			$row[] = [
				'no' => $no++,
				'registrasi_id' => $d->id,
				'nama' => ($d->status_reg == 'A1') ? Penjualanbebas::where('registrasi_id', $d->id)->first()->nama : Pasienlangsung::where('registrasi_id', $d->id)->first()->nama,
				'alamat' => ($d->status_reg == 'A1') ? Penjualanbebas::where('registrasi_id', $d->id)->first()->alamat : Pasienlangsung::where('registrasi_id', $d->id)->first()->alamat ,
				'jenis_transaksi' => $d->status_reg,
				// 'total' => Folio::where('registrasi_id', $d->id)->where('lunas', 'N')->first()->total
			];
		}
		$data = $row;
		return view('kasir.lain_lain',compact('data'));
	}

	public function form_bayar_lain_lain($registrasi_id='')
	{
		$reg = Registrasi::find($registrasi_id);
		$data['pasien'] = ($reg->status_reg <> 'A1') ? Pasienlangsung::where('registrasi_id', $reg->id)->first() : Penjualanbebas::where('registrasi_id', $registrasi_id)->first();

		if ($reg->status_reg == 'A1') {
			$data['total'] = Folio::where('registrasi_id', $registrasi_id)->where('lunas', 'N')->first()->total;
			$no_resep = Penjualan::where('registrasi_id', $registrasi_id)->first()->no_resep;
			$data['rincian'] = Penjualandetail::where('no_resep', $no_resep)->get();
			return view('kasir.form_bayar_lain_lain', $data)->with('no', 1);
		} else {
			$data['total'] = Folio::where('registrasi_id', $registrasi_id)->where('lunas', 'N')->sum('total');
			$data['rincian'] = Folio::where('registrasi_id', $registrasi_id)->where('lunas', 'N')->get();
			return view('kasir.form_bayar_PasienLangsung', $data)->with('no', 1);
		}


	}

	public function save_bayar_lain_lain(Request $request)
	{
		$r = Registrasi::find($request['registrasi_id']);
		$cek_kuitansi = Pembayaran::where('no_kwitansi', 'LIKE', 'PB-'.date('Ymd').'-%')->count() + 1;
		$no_kuitansi = 'PB-'.date('Ymd').'-'.sprintf("%05s", $cek_kuitansi);

		if($request['total'] <> 0){
			DB::transaction(function () use ($request, $no_kuitansi, $r) {
				$reg = Registrasi::find($request['registrasi_id']);
				// Insert pembayaran
				$pem = new Pembayaran();
				$pem->user_id = Auth::user()->id;
				$pem->jenis = 0;
				$pem->total = $request['total'];
				$pem->dibayar = rupiah($request['dibayar']);
				$pem->flag = 'Y';
				$pem->registrasi_id = $reg->id;
				$pem->dokter_id = 1;
				$pem->diskon_persen = 0;
				$pem->diskon_rupiah = 0;
				$pem->no_kwitansi = $no_kuitansi;
				$pem->pasien_id = 0;
				$pem->save();
				Activity::log('kasir_'.Auth::user()->name.' menerima pembayaran pasien no medrek '.number_format($pem->total).' no kuitansi '.$pem->no_kwitansi);
				//Update Folio
				$fol = Folio::where('registrasi_id', $request['registrasi_id'])->get();
				foreach ($fol as $key => $d) {
					$d->lunas = 'Y';
					$d->dibayar = $d->total;
					$d->waktu_dibayar = date('Y-m-d');
					$d->no_kuitansi = $pem->no_kwitansi;
					$d->update();
				}
				session(['idk'=>$pem->id]);
				//Update registrasi
				$reg->lunas = 'Y';
				$reg->update();
			});
			return redirect('kasir/cetakkuitansibebas/'.session('idk'));
		}
	}

	public function cetak_kuitansi_bebas($id='')
	{
		$kuitansi = Pembayaran::find($id);
		$reg = Registrasi::find($kuitansi->registrasi_id);
		if ($reg->status_reg == 'A1') {
			$pasien = Penjualanbebas::where('registrasi_id', $kuitansi->registrasi_id)->first();
		} else {
			$pasien = Pasienlangsung::where('registrasi_id', $kuitansi->registrasi_id)->first();
		}
		$folio = Folio::where('registrasi_id','=', $kuitansi->registrasi_id)->where('lunas', 'Y')->get();
		$jml = Folio::where('registrasi_id','=', $kuitansi->registrasi_id)->where('lunas', 'Y')->sum('total');
		return view('kasir.kuitansi_bebas', compact('kuitansi', 'folio', 'jml', 'pasien'));
	}

	//SUPERVISOR
	public function edit_transaksi()
	{
		return view('kasir.edit_transaksi');
	}

	public function batal_bayar()
	{
		$data['reg'] = Registrasi::where('created_at', 'LIKE', date('Y-m-d').'%')->where('lunas', 'Y')->where('bayar', '<>', '1')->get();
		Pembayaran::where('flag', 'N')->where('created_at', '<', date('Y-m-d 00:00:00'))->delete();
		return view('kasir.batal_bayar', $data)->with('no', 1);
	}

	public function batal_bayar_byTanggal(Request $request)
	{
		request()->validate(['tga'=>'required', 'tgb'=>'required']);
		$data['reg'] = Registrasi::whereBetween('created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])->where('lunas', 'Y')->where('bayar', '<>', '1')->get();
		return view('kasir.batal_bayar', $data)->with('no', 1);
	}

	public function rincian_pembayaran($registrasi_id)
	{
		$data['reg'] = Registrasi::where('id', $registrasi_id)->first();
		$data['rincian'] = Folio::where('registrasi_id', $registrasi_id)->get();
		$data['total'] = Folio::where('registrasi_id', $registrasi_id)->sum('total');
		$data['pembayaran'] = Pembayaran::where('registrasi_id', $registrasi_id)->where('flag', 'Y')->first();
		return view('kasir.view_rincian_pembayaran', $data)->with('no', 1);
	}

	public function save_pembatalan($registrasi_id)
	{
		DB::transaction(function () use ($registrasi_id)
		{
			$reg = Registrasi::where('id', $registrasi_id)->first();
			$reg->lunas = 'N';
			$reg->update();

			$folio = Folio::where('registrasi_id', $registrasi_id)->get();
			foreach ($folio as $d) {
				$fol = Folio::find($d->id);
				$fol->lunas = 'N';
				$fol->waktu_dibayar = NULL;
				$fol->update();
			}

			$pembayaran = Pembayaran::where('registrasi_id', $registrasi_id)->get();
			foreach ($pembayaran as $r) {
				$p = Pembayaran::find($r->id);
				$p->total = 0;
				$p->dibayar = 0;
				$p->flag = 'N';
				$p->update();
				Activity::log('kasir_'.Auth::user()->name.' batalkan pembayaran no kuitansi '.$p->no_kwitansi);
			}

		});
		Flashy::success('Pembayaran berhasil di batalkan');
		return redirect('kasir/batal-bayar');
	}

	public function batal_piutang()
	{
		return view('kasir.batal_piutang');
	}

	//LAPORAN
	public function lap_detail_tindakan()
	{
		return view('kasir.lap_detail_tindakan');
	}

	public function lap_detail_tindakanByFilter(Request $request)
	{
			request()->validate(['tga'=>'required', 'tgb'=>'required']);
			$dokter = Pegawai::select('id')->get();
			$di = [];
			foreach ($dokter as $key => $d) {
				$di[] = ''.$d->id.'';
			}

			//return $request->all(); die;
			$data['reg'] = Registrasi::join('pasiens','pasiens.id','=','registrasis.pasien_id')
									   ->whereBetween('registrasis.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
											->where('lunas', 'Y')
											->when(request('jenis_pasien', false), function ($q, $role) { 
												return $q->where('registrasis.jenis_pasien', $role);
											})
											->when(request('tipe_layanan', false), function ($q, $role) { 
												return $q->where('registrasis.tipe_layanan', $role);
											})
											->when(request('dokter', false), function ($q, $role) { 
												return $q->where('registrasis.dokter_id', $role);
											})
											->when(request('petugas', false), function ($q, $role) { 
												return $q->where('registrasis.user_create', $role);
											})
											->when(request('no_rm', false), function ($q, $role) { 
												return $q->where('pasiens.no_rm','like','%'.$role.'%' );
											})
											->when(request('nama_pasien', false), function ($q, $role) { 
												return $q->where('pasiens.nama','like','%'.$role.'%' );
											})
											->select('registrasis.*','pasiens.no_rm','pasiens.nama')
											->get();
			return view('kasir.lap_detail_tindakan', $data)->with('no', 1);
	}


	public function lap_penerimaan_tunai()
	{
		return view('kasir.lap_penerimaan_tunai');
	}

	public function lap_penerimaan_tunai_byTanggal(Request $request)
	{
		request()->validate(['tga'=>'required', 'tgb'=>'required']);
		$data['tunai'] = Pembayaran::whereBetween('created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
																->where('jenis', 'tunai')
																->sum('dibayar');
		$data['piutang'] = Pembayaran::whereBetween('created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
																->where('jenis', 'piutang')
																->sum('dibayar');
		return view('kasir.lap_penerimaan_tunai', $data);
	}

	public function tutup_kasir()
	{
		$user = User::join('role_user', 'users.id', '=', 'role_user.user_id')
								->join('roles', 'roles.id', '=', 'role_user.role_id')
								->select('users.id as user_id', 'users.name as nama', 'users.email', 'roles.name as Role')
								->where('roles.name', '=', 'kasir')
								->get();
		return view('kasir.tutup_kasir', compact('user'));
	}

	public function tutup_kasir_byRequest(Request $request)
	{
		request()->validate(['tga'=>'required', 'tgb'=>'required']);
		$user = User::join('role_user', 'users.id', '=', 'role_user.user_id')
								->join('roles', 'roles.id', '=', 'role_user.role_id')
								->select('users.id as user_id', 'users.name as nama', 'users.email', 'roles.name as Role')
								->where('roles.name', '=', 'kasir')
								->get();
		$iduser = [];
		foreach ($user as $key => $d) {
			$iduser[] = ''.$d->user_id.'';
		}

		$pembayaran = Pembayaran::whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
														->join('registrasis', 'registrasis.id', '=', 'pembayarans.registrasi_id')
														->join('pasiens', 'pasiens.id', '=', 'pembayarans.pasien_id')
														->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)
														->select('registrasis.bayar', 'registrasis.tipe_jkn', 'registrasis.poli_id', 'pasiens.no_rm', 'pasiens.nama', 'pembayarans.*')
														->get();
		$tunai = Pembayaran::whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
														->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)
														->where('jenis', 'tunai')->sum('total');
		$piutang = Pembayaran::whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
														->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)
														->where('jenis', 'piutang')->sum('total');

		if ($request['lanjut']) {
			return view('kasir.tutup_kasir', compact('user', 'pembayaran', 'tunai', 'piutang'))->with('no', 1);
		} elseif ($request['excel']) {
			Excel::create('Laporan Keuangan', function($excel) use ($pembayaran, $tunai, $piutang) {
			// Set the properties
			$excel->setTitle('Tutup Kasir')
						->setCreator('Lukstron')
						->setCompany('Lukstron')
						->setDescription('Tutup Kasir');
			$excel->sheet('Tutup Kasir', function($sheet) use ($pembayaran, $tunai, $piutang) {
				$row = 1;
				$no=1;
				$sheet->row($row, [
										'No',
										'No Kuitansi',
										'Tgl / Waktu',
										'No. RM',
										'Nama',
										'Cara bayar',
										'Tunai',
										'Piutang',
										'Subsidi',
										'Kasir',
										'Poli',
										'Dokter'
									]);
					foreach ($pembayaran as $key => $d)  {
						$sheet->row(++$row, [
											$no++,
											$d->no_kwitansi,
											$d->created_at,
											$d->no_rm,
											$d->nama,
											baca_carabayar($d->bayar).' '.$d->tipe_jkn,
											($d->jenis == 'tunai') ? $d->total : '',
											($d->jenis == 'piutang') ? $d->total : '',
											$d->subsidi,
											User::find($d->user_id)->name,
											baca_poli($d->poli_id),
											baca_dokter($d->dokter_id)
										]);
						};
						$sheet->row(++$row, ['', '', '', '', '', 'TOTAL', $tunai, $piutang, '', '', '', '' ]);
				});

			})->export('xlsx');

		} elseif ($request['pdf']) {
			$config = Config::find(1);
			$no=1;
			$petugas = !empty($request['petugas']) ? User::find($request['petugas'])->name : '';
			$periode = $request['tga'].' s/d '.$request['tgb'];
			$pdf = PDF::loadView('kasir.pdf_tutup_kasir', compact('user', 'pembayaran', 'tunai', 'piutang', 'no', 'petugas', 'periode','config'),[
				'orientation' => 'L']);
			return $pdf->stream();
			//return $pdf->download('laporan keuangan.pdf');
		}
	}

	public function getTarif($kat_id)
	{
			$tarif = Tarif::where('kategoritarif_id', $kat_id)->pluck('nama', 'id');
			return json_encode($tarif);
	}

	public function piutang($registrasi_id)
	{
			DB::transaction(function () use ($registrasi_id)
			{
					$reg = Registrasi::where('id', $registrasi_id)->first();
					$total = Folio::where('registrasi_id', $registrasi_id)->sum('total');
					$piutang = new Piutang();
					$piutang->registrasi_id = $reg->id;
					$piutang->nama = $reg->pasien->nama;
					$piutang->total = $total;
					$piutang->dibayar = 0;
					$piutang->tglbayar = null;
					$piutang->carabayar = $reg->bayar;
					$piutang->save();

					$reg->lunas = 'P';
					$reg->update();
			});
			return redirect('/kasir/rawatjalan');
	}

	public function piutangIgd($registrasi_id)
	{
			DB::transaction(function () use ($registrasi_id)
			{
					$reg = Registrasi::where('id', $registrasi_id)->first();
					$total = Folio::where('registrasi_id', $registrasi_id)->sum('total');
					$piutang = new Piutang();
					$piutang->registrasi_id = $reg->id;
					$piutang->nama = $reg->pasien->nama;
					$piutang->total = $total;
					$piutang->dibayar = 0;
					$piutang->tglbayar = null;
					$piutang->carabayar = $reg->bayar;
					$piutang->save();

					$reg->lunas = 'P';
					$reg->update();
			});
			return redirect('/kasir/igd');
	}

	//VERIFIKASI KASA =========================================================================
	public function verifikasiKasa()
	{
		$data['registrasi'] = Registrasi::whereIn('status_reg', ['J1', 'J2', 'G1', 'G2'])
													->where('created_at', 'like', date('Y-m-d').'%')
													->get();
		return view('kasir.verifikasiKasa.verifikasiKasa', $data)->with('no', 1);
	}

	public function verifikasiKasaByRequest(Request $request)
	{
		$data['registrasi'] = Registrasi::whereIn('status_reg', ['J1', 'J2', 'G1', 'G2'])
													->where('created_at', 'like', valid_date($request['tga']).'%')
													->get();
		return view('kasir.verifikasiKasa.verifikasiKasa', $data)->with('no', 1);
	}

	public function detailVerifikasiKasa($registrasi_id)
	{
		$data['registrasi'] = Registrasi::select('id', 'pasien_id', 'status_reg', 'dokter_id', 'poli_id', 'bayar')->where('id', $registrasi_id)->first();
		$data['pasien'] = Pasien::find($data['registrasi']->pasien_id);
		$data['folio'] = Folio::where('registrasi_id', $registrasi_id)->get();
		return view('kasir.verifikasiKasa.detailVerifikasiKasa', $data)->with(['no'=>1, 'baris'=>1]);
	}

	public function saveVerifikasiKasa(Request $request)
	{
		$jumlah = $request['jmlbaris'];
		$jml = 0;
		for ($i=1; $i < $jumlah; $i++) {
			if (!empty($request['verif_kasa'.$i])) {
				$fol = Folio::where('id', $request['verif_kasa'.$i])->first();
				$fol->verif_kasa = 'Y';
				$fol->verif_kasa_user = Auth::user()->name;
				$fol->update();
				$jml++;
			}
			if (!empty($request['hapus'.$i])) {
				$fol = Folio::where('id', $request['hapus'.$i])->first();
				$fol->delete();
			}
		}
		$pesan = $jml.' tindakan berhasil di verifikasi';
		Flashy::success($pesan);
		return response()->json(['sukses' => true, 'registrasi_id'=>$request['registrasi_id']]);
	}

	public static function cetakVerifikasi($registrasi_id)
	{
			$folio 	= Folio::leftJoin('tarifs','folios.tarif_id','=','tarifs.id')
								->where('folios.registrasi_id', $registrasi_id)->where('folios.verif_kasa', 'Y')->groupBy('folios.tarif_id')
								->selectRaw('folios.tarif_id, sum(folios.total) as total, folios.namatarif, tarifs.*')
								->get();
			$jml = Folio::where('registrasi_id', $registrasi_id)->where('verif_kasa', 'Y')->sum('total');
			$reg = Registrasi::find($registrasi_id);
			$irna = Rawatinap::where('registrasi_id', $registrasi_id)->first();
			$no = 1;
			$pdf = PDF::loadView('kasir.verifikasiKasa.cetakVerifikasi', compact('folio', 'reg', 'jml', 'no', 'irna'));
			$pdf->setPaper('legal');
			return $pdf->stream();
	}

	//VERIFIKASI TAMBAH TINDAKAN
	function tambahTindakan($registrasi_id)
	{
		$idreg = $registrasi_id;
		$data['reg_id'] = $idreg;
		$data['jenis'] = Registrasi::where('id', '=', $idreg)->first();
		$data['pasien'] = Pasien::find($data['jenis']->pasien_id);
		$data['poli'] = Folio::where('registrasi_id', '=', $idreg)->distinct();
		$data['tagihan'] = Folio::where('registrasi_id',$idreg)->sum('total');
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['perawat'] = Pegawai::pluck('nama', 'id');
		$data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();
		$jenis = $data['jenis']->status_reg;

		$data['tindakan'] = Tarif::get();
		$data['opt_poli'] = Poli::get();
			
		return view('kasir.verifikasiKasa.tambahTindakan', $data);
	}

	//SAVE TAMBAH TINDAKAN
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
			$fol->jenis         = $tarif->jenis;
			$fol->cara_bayar_id = $reg->bayar;
			if(substr($reg->status_reg,0,1) == 'G'){
				$fol->poli_tipe = 'G';
			}else{
				$fol->poli_tipe = 'J';
			}
			$fol->total         = ($tarif->total * $request['jumlah']);
			$fol->jenis_pasien  = $request['jenis'];
			$fol->pasien_id     = $request['pasien_id'];
			$fol->dokter_id     = $request['dokter_id'];
			$fol->user_id       = Auth::user()->id;
			$fol->poli_id       = $request['poli_id'];
			if (!empty($request['tanggal'])) {
				$fol->created_at = valid_date($request['tanggal']);
			}
			$fol->save();

			// Insert Kunjungan IRJ
			if ($fol->poli_tipe == 'J') {
				$cek = HistorikunjunganIRJ::where('registrasi_id', $request['registrasi_id'])->where('poli_id', $request['poli_id'])->count();
				if($cek < 1) {
					$rj = new HistorikunjunganIRJ();
					$rj->registrasi_id = $request['registrasi_id'];
					$rj->pasien_id = $request['pasien_id'];
					$rj->poli_id = $request['poli_id'];
					$rj->user = Auth::user()->id;
					$rj->save();
				}
			}

			// Insert Kunjungan IRD
			if ($fol->poli_tipe == 'G') {
				$cek = HistorikunjunganIGD::where('registrasi_id', $request['registrasi_id'])->where('triage_nama', baca_poli($request['poli_id']))->count();
				if($cek < 1) {
					$rj = new HistorikunjunganIGD();
					$rj->registrasi_id = $request['registrasi_id'];
					$rj->pasien_id = $request['pasien_id'];
					$rj->triage_nama = baca_poli($request['poli_id']);
					$rj->user = Auth::user()->id;
					$rj->save();
				}
			}


			//input folio pelaksana
			$fp = new Foliopelaksana();
			$fp->folio_id = $fol->id;
			$fp->dpjp = $request['dokter_id'];
			$fp->dokter_pelaksana = $request['pelaksana'];
			$fp->perawat = $request['perawat'];
			if(substr($reg->status_reg,0,1) == 'G'){
				$fp->pelaksana_tipe = 'TG';
			}else{
				$fp->pelaksana_tipe = 'TA';
			}
			$fp->user = Auth::user()->id;
			$fp->save();

			// Insert Histori
			$history = new HistoriStatus();
			$history->registrasi_id = $request['registrasi_id'];
				if(substr($reg->status_reg,0,1) == 'G'){
					$history->status = 'G2';
				}elseif (substr($reg->status_reg,0,1) == 'J') {
					$history->status = 'J2';
				}

			$history->poli_id       = $request['poli_id'];
			$history->bed_id        = null;
			$history->user_id       = Auth::user()->id;
			$history->save();
			session()->forget('jenis');
			return response()->json(['sukses'=>true, 'registrasi_id'=>$reg->id]);
	}

	//VERIFIKASI KASIR IRNA
	public static function verifikasirKasirIrna(Request $request)
	{
		// return $request->all(); die;
		$jumlah = $request['jmlbaris'];
		$jml = [];
		$hps = 0;
		for ($i=1; $i < $jumlah; $i++) {
			if (!empty($request['verif_kasa'.$i])) {
				$fol = Folio::where('tarif_id', $request['verif_kasa'.$i])->where('registrasi_id', $request['registrasi_id'])->get();
				foreach ($fol as $d) {
					$d->verif_kasa = 'Y';
					$d->verif_kasa_user = Auth::user()->name;
					$d->update();
					array_push($jml, $d->id);
				}
				$jml;
			}

			if (!empty($request['hapus'.$i])) {
				$hps++;
				$fol = Folio::where('id', $request['hapus'.$i])->first();
				$fol->delete();
			}
		}
		$hps;
		$data = Folio::whereIn('id', $jml)->get();
		$pesan = $data->count().' tindakan berhasil di verifikasi. '.$hps.' tindakan berhasil di hapus.';
		Flashy::success($pesan);
		return redirect('kasir/detail-verifikasi/'.$request['registrasi_id']);
	}

	public static function verifikasirDetailKasirIrna(Request $request)
	{
		$jumlah = $request['jmlbaris'];
		$jml = 0;
		$hps = 0;
		for($i=1; $i < $jumlah; $i++){
			if(!empty($request['verif_kasa'.$i])){
				$fol = Folio::find($request['verif_kasa'.$i]);
				$fol->verif_kasa = 'Y';
				$fol->verif_kasa_user = Auth::user()->name;
				$fol->update();
				$jml++;
			}
			if(!empty($request['hapus'.$i])){
				$hps++;
				$fol = Folio::find($request['hapus'.$i]);
				$fol->delete();
			}
		}
		$pesan = $jml.' tindakan berhasil di verifikasi. '.$hps.' tindakan berhasil di hapus.';
		Flashy::success($pesan);
		return redirect('kasir/detail-verifikasi/'.$request['registrasi_id']);
	}

	public static function unverifikasiKasirIrna($folio_id, $registrasi_id)
	{
		$fol = Folio::find($folio_id);
		$fol->verif_kasa = 'N';
		$fol->verif_kasa_user = Auth::user()->name;
		$fol->update();
		return redirect('kasir/detail-verifikasi/'.$registrasi_id);
	}

	public static function hapusTindakanIrna($folio_id, $registrasi_id)
	{
		$fol = Folio::find($folio_id);
		$fol->delete();

		$fp = Foliopelaksana::where('folio_id', $folio_id)->first();
		if ($fp) {
			$fp->delete();
		}
		return redirect('kasir/detail-verifikasi/'.$registrasi_id);
	}

	public static function kosongkanBed($reg_id, $pasien_id)
	{
		$ranap = Rawatinap::where('registrasi_id', $reg_id)->first();
		$ranap->tgl_keluar = date('Y-m-d H:i:s');
		$ranap->update();

		$bed = Bed::find($ranap->bed_id);
		$bed->reserved = 'N';
		$bed->update();
		return redirect('kasir/rawatinap/bayar/'.$reg_id.'/'.$pasien_id);
	}

	public function tutup_kasir1()
	{
		$user = User::join('role_user', 'users.id', '=', 'role_user.user_id')
								->join('roles', 'roles.id', '=', 'role_user.role_id')
								->select('users.id as user_id', 'users.name as nama', 'users.email', 'roles.name as Role')
								->where('roles.name', '=', 'kasir')
								->get();
		return view('kasir.tutup_kasir1', compact('user'));
	}

	public function tutup_kasir_byRequest1(Request $request)
	{
		request()->validate(['tga'=>'required', 'tgb'=>'required']);
		$user = User::join('role_user', 'users.id', '=', 'role_user.user_id')
								->join('roles', 'roles.id', '=', 'role_user.role_id')
								->select('users.id as user_id', 'users.name as nama', 'users.email', 'roles.name as Role')
								->where('roles.name', '=', 'kasir')
								->get();
		//$layanan = [];
		//foreach (tipelayanan::select('id', 'tipelayanan')->get() as $key => $d) {
		//	$di[] = '' . $d->id . '';
		//}
		foreach ($user as $key => $d) {
			$iduser[] = ''.$d->user_id.'';
		}
		$di = [];
		foreach (Pegawai::select('id', 'nama')->where('kategori_pegawai', 1)->get() as $key => $d) {
			$di[] = '' . $d->id . '';
		}
		$pi = [];
		foreach (Poli::select('id', 'nama')->get() as $key => $d) {
			$pi[] = '' . $d->id . '';
		}

		$pembayaran = Pembayaran::whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
														->join('registrasis', 'registrasis.id', '=', 'pembayarans.registrasi_id')
														->join('pasiens', 'pasiens.id', '=', 'pembayarans.pasien_id')
														//->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])
														->whereIn('registrasis.jenis_pasien', !empty($request['bayar']) ? [$request['bayar']] : ['1', '2','3'])
														->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)
														->whereIn('registrasis.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)
														->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
														->select('registrasis.bayar', 'registrasis.tipe_jkn', 'registrasis.poli_id', 'pasiens.no_rm', 'pasiens.nama', 'pembayarans.*')
														->whereIn('jenis', !empty($request['tipe_penerimaan']) ? [$request['tipe_penerimaan']] : ['piutang','tunai'])
														->get();
		$tunai = Pembayaran::whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
														->join('registrasis', 'registrasis.id', '=', 'pembayarans.registrasi_id')
														->join('pasiens', 'pasiens.id', '=', 'pembayarans.pasien_id')
														->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)
														->whereIn('registrasis.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)
														->whereIn('jenis', !empty($request['tipe_penerimaan']) ? [$request['tipe_penerimaan']] : ['piutang','tunai'])
														//->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : $layanan)
														->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
														->where('jenis', 'tunai')->sum('dibayar');
		$piutang = Pembayaran::whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
														->join('registrasis', 'registrasis.id', '=', 'pembayarans.registrasi_id')
														->join('pasiens', 'pasiens.id', '=', 'pembayarans.pasien_id')
														->whereIn('jenis', !empty($request['tipe_penerimaan']) ? [$request['tipe_penerimaan']] : ['piutang','tunai'])
														->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)
														->where('jenis', 'piutang')->sum('dibayar');

		if ($request['lanjut']) {
			return view('kasir.tutup_kasir1', compact('user', 'pembayaran', 'tunai', 'piutang'))->with('no', 1);
		} elseif ($request['excel']) {
			Excel::create('Laporan Keuangan', function($excel) use ($pembayaran, $tunai, $piutang) {
			// Set the properties
			$excel->setTitle('Tutup Kasir')
						->setCreator('Lukstron')
						->setCompany('Lukstron')
						->setDescription('Tutup Kasir');
			$excel->sheet('Tutup Kasir', function($sheet) use ($pembayaran, $tunai, $piutang) {
				$row = 1;
				$no=1;
				$sheet->row($row, [
										'No',
										'No Kuitansi',
										'Tgl / Waktu',
										'No. RM',
										'Nama',
										'Cara bayar',
										'Tunai',
										'Piutang',
										'Subsidi',
										'Kasir',
										'Poli',
										'Dokter'
									]);
					foreach ($pembayaran as $key => $d)  {
						$sheet->row(++$row, [
											$no++,
											$d->no_kwitansi,
											$d->created_at,
											$d->no_rm,
											$d->nama,
											baca_carabayar($d->bayar).' '.$d->tipe_jkn,
											($d->jenis == 'tunai') ? $d->dibayar : '',
											($d->jenis == 'piutang') ? $d->dibayar : '',
											$d->subsidi,
											User::find($d->user_id)->name,
											baca_poli($d->poli_id),
											baca_dokter($d->dokter_id)
										]);
						};
						$sheet->row(++$row, ['', '', '', '', '', 'TOTAL', $tunai, $piutang, '', '', '', '' ]);
				});

			})->export('xlsx');

		} elseif ($request['pdf']) {
			$config = Config::find(1);
			$no=1;
			$petugas = !empty($request['petugas']) ? User::find($request['petugas'])->name : '';
			$periode = $request['tga'].' s/d '.$request['tgb'];
			$pdf = PDF::loadView('kasir.pdf_tutup_kasir', compact('user', 'pembayaran', 'tunai', 'piutang', 'no', 'petugas', 'periode','config'),[
				'orientation' => 'L']);
			return $pdf->stream();
			return $pdf->download('laporan keuangan.pdf');
		}
	}

	//Keuangan

	public function keuangan()
	{
		
		return view('kasir/keuanganrs.index');
	}

	//Keuangan
	//akun keuangan

	public function akunkeuangan()
	{
		$data['akunkeuangan'] = AkunKeuangan::all();
     
		return view('kasir/keuanganrs/akunkeuangan.index', $data)->with('no',1);
	}

	
	public function createakunkeuangan()
   {
       return view('kasir/keuanganrs/akunkeuangan.create');
   }

   public function storeakunkeuangan(Request $request)
   {
     $data = request()->validate(['kode_keuangan'=>'required','nama_akun'=>'required','tipe'=>'required','balance'=>'required','aktiva'=>'required']);
     AkunKeuangan::create($data);
     Flashy::success('Master Jabatan Telah Ditambahkan');
     
     return redirect()->route('akunkeuangan');
   }

   public function editakunkeuangan($id)
   {
     $data['akunkeuangan'] = AkunKeuangan::find($id);
     return view('kasir/keuanganrs/akunkeuangan.edit',$data);
   }

   public function updateakunkeuangan(Request $request, $id)
   {
	 $data = request()->validate(['kode_keuangan'=>'required','nama_akun'=>'required','tipe'=>'required','balance'=>'required','aktiva'=>'required']);
     AkunKeuangan::find($id)->update($data);
     Flashy::info('Data Master Jabatan berhasil di update');
     return redirect()->route('akunkeuangan');
   }

   public function deleteakunkeuangan($id)
   {
       $AkunKeuangan1 = AkunKeuangan::find($id);
       $AkunKeuangan1->delete();
       return redirect()->route('akunkeuangan');
   
   }
}
