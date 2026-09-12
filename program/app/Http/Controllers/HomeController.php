<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;
use Modules\Poli\Entities\Poli;
use App\Historipengunjung;
use App\Orderlab;
use App\Orderradiologi;
use App\Orderfisioterapi;
use App\Orderkamarbersalin;
use App\Operasi;
use App\Depopo;
use App\AntrianApotek;
use App\Permintaanobat;
use DB;
use Auth;
use Flashy;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
			$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
			$data['total'] = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d').'%')->count();
			$data['l'] = Historipengunjung::join('pasiens', 'histori_pengunjung.pasien_id', '=', 'pasiens.id')
															->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d').'%')
															->where('pasiens.kelamin', '=', 'L')->count();
			$data['config'] = db::table('configs')->where('id',1)->first();
			$data['p'] = Historipengunjung::join('pasiens', 'histori_pengunjung.pasien_id', '=', 'pasiens.id')
															->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d').'%')
															->where('pasiens.kelamin', '=', 'P')->count();
			$data['rajal'] = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d').'%')->where('politipe', 'J')->count();
			$data['igd'] = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d').'%')->where('politipe', 'G')->count();
			$data['jkn'] = Historipengunjung::leftJoin('registrasis', 'histori_pengunjung.registrasi_id', '=', 'registrasis.id')->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d').'%')->where('bayar', '1')->count();
			$data['umum'] = Historipengunjung::leftJoin('registrasis', 'histori_pengunjung.registrasi_id', '=', 'registrasis.id')->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d').'%')->where('bayar', '<>', '1')->count();

			$data['irna'] = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d').'%')->where('politipe', 'I')->count();

			$data['poli'] = DB::table('histori_kunjungan_irj')->where('created_at', 'LIKE', date('Y-m-d').'%')->select('poli_id')->where('created_at', 'LIKE', date('Y-m-d').'%')->distinct()->get();
			if(strtolower(Auth::user()->role()->first()->name)=='dokter' OR strtolower(Auth::user()->role()->first()->name)=='adminpoli')
			{
			return view('dashboard_dokter', $data)->with('no', 1);
			}else{
			return view('dashboard', $data)->with('no', 1);
			}
	}
	
	public function notifikasi(){
		$notif	= null;
		$notif2	= null;
		$notif3	= null;
		$notif_lgsg	= null;
		$list_notif	= "";
		if(strtolower(Auth::user()->role()->first()->name)=='laboratorium'){
			$notif_lgsg = Registrasi::where('pulang',null)->where('poli_id',18)->orderBy('antrian_poli','ASC')->get();
			if($notif_lgsg!=null){
				foreach($notif_lgsg as $key => $lgsg){
					$cek = Orderlab::where('registrasi_id',$lgsg->id)->first();
					if($cek==null){
						$order = new Orderlab;
						$order->registrasi_id = $lgsg->id;
						$order->pemeriksaan = 'Pemeriksaan tindakan langsung';
						$order->user_id = $lgsg->user_create;
						$order->save();
					}
				}
			}
			
			$notif = Orderlab::where('status_proses',null)->get();
			if($notif!=null){
				$list_notif	.=	'<li id="no-notif" style="background:#f9f9f9;"><a href="#">
														<span style="font-size:12px;font-weight:bold;">#Notifikasi</span>
												</a></li>';
				foreach($notif as $key => $value){
					$url = '/laboratorium/insert-kunjungan/'.$value->registrasi_id.'/'.$value->registrasi->pasien_id;
					$list_notif	.=	'<li id="no-notif">
														<a href="'.$url.'" onclick="return confirm(\'Apakah yakin akan dilakukan tindakan Lab? Karena akan menambah kunjungan Lab.\')">
															<span style="font-size:10px;">Order pasien '.instalasi(substr($value->registrasi->status_reg,0,1)).' <b>'.$value->registrasi->pasien->no_rm.' - '.substr($value->registrasi->pasien->nama,0,15).'</b></span>
														</a>
													</li>';
				}
			}
		}elseif(strtolower(Auth::user()->role()->first()->name)=='radiologi'){
			$poli 			= Poli::where('nama', 'Klinik Radiologi')->where('politype', 'J')->first();
			$notif_lgsg = Registrasi::where('pulang',null)->where('poli_id',$poli->id)->orderBy('antrian_poli','ASC')->get();
			if($notif_lgsg!=null){
				foreach($notif_lgsg as $key => $lgsg){
					$cek = Orderradiologi::where('registrasi_id',$lgsg->id)->first();
					if($cek==null){
						$order = new Orderradiologi;
						$order->registrasi_id = $lgsg->id;
						$order->pemeriksaan = 'Pemeriksaan tindakan langsung';
						$order->user_id = $lgsg->user_create;
						$order->save();
					}
				}
			}
			
			$notif = Orderradiologi::where('status_proses',null)->get();
			if($notif!=null){
				$list_notif	.=	'<li id="no-notif" style="background:#f9f9f9;"><a href="#">
														<span style="font-size:12px;font-weight:bold;">#Notifikasi</span>
												</a></li>';
				foreach($notif as $key => $value){
					$url = '/radiologi/insert-kunjungan/'.$value->registrasi_id.'/'.$value->registrasi->pasien_id;
					$list_notif	.=	'<li id="no-notif">
														<a href="'.$url.'" onclick="return confirm(\'Apakah yakin akan dilakukan tindakan Radiologi? Karena akan menambah kunjungan Radiologi.\')">
															<span style="font-size:10px;">Order pasien '.instalasi(substr($value->registrasi->status_reg,0,1)).' <b>'.$value->registrasi->pasien->no_rm.' - '.substr($value->registrasi->pasien->nama,0,15).'</b></span>
														</a>
													</li>';
				}
			}
		}elseif(strtolower(Auth::user()->role()->first()->name)=='operasi'){
			//$notif = Operasi::where('status_proses',null)->get();
			$notif = db::select(db::raw("SELECT *
			FROM operasis
			WHERE status_proses IS NULL"));

			if($notif!=null){
				$list_notif	.=	'<li id="no-notif" style="background:#f9f9f9;"><a href="#">
														<span style="font-size:12px;font-weight:bold;">#Notifikasi</span>
												</a></li>';
				foreach($notif as $key => $value){
					$url = '/operasi/tindakan/'.$value->registrasi_id;
					$registrasi = Registrasi::where('id',$value->registrasi_id)->first();
					$list_notif	.=	'<li id="no-notif">
														<a href="'.$url.'">
															<span style="font-size:10px;">Order pasien '.instalasi(substr($registrasi->status_reg,0,1)).' <b>'.$registrasi->pasien->no_rm.' - '.substr($registrasi->pasien->nama,0,15).'</b></span>
														</a>
													</li>';
				}
			}
		}elseif(strtolower(Auth::user()->role()->first()->name)=='fisioterapi'){
			$poli 			= Poli::where('nama', 'Klinik Fisioterapi')->where('politype', 'J')->first();
			$notif_lgsg = Registrasi::where('pulang',null)->where('poli_id',$poli->id)->orderBy('antrian_poli','ASC')->get();
			if($notif_lgsg!=null){
				foreach($notif_lgsg as $key => $lgsg){
					$cek = Orderfisioterapi::where('registrasi_id',$lgsg->id)->first();
					if($cek==null){
						$order = new Orderfisioterapi;
						$order->registrasi_id = $lgsg->id;
						$order->pemeriksaan = 'Pemeriksaan tindakan langsung';
						$order->user_id = $lgsg->user_create;
						$order->save();
					}
				}
			}
			
			$notif = Orderfisioterapi::where('status_proses',null)->get();
			if($notif!=null){
				$list_notif	.=	'<li id="no-notif" style="background:#f9f9f9;"><a href="#">
														<span style="font-size:12px;font-weight:bold;">#Notifikasi</span>
												</a></li>';
				foreach($notif as $key => $value){
					$url = '/penunjang/insert-kunjungan/'.$value->registrasi_id.'/'.$value->registrasi->pasien_id;
					$list_notif	.=	'<li id="no-notif">
														<a href="'.$url.'" onclick="return confirm(\'Apakah yakin akan dilakukan tindakan Fisioterapi? Karena akan menambah kunjungan Fisioterapi.\')">
															<span style="font-size:10px;">Order pasien '.instalasi(substr($value->registrasi->status_reg,0,1)).' <b>'.$value->registrasi->pasien->no_rm.' - '.substr($value->registrasi->pasien->nama,0,15).'</b></span>
														</a>
													</li>';
				}
			}
		}elseif(strtolower(Auth::user()->role()->first()->name)=='kamarbersalin'){
			$notif = Orderkamarbersalin::where('status_proses',null)->get();
			if($notif!=null){
				$list_notif	.=	'<li id="no-notif" style="background:#f9f9f9;"><a href="#">
														<span style="font-size:12px;font-weight:bold;">#Notifikasi</span>
												</a></li>';
				foreach($notif as $key => $value){
					$url = '/penunjang/insert-kunjungan/'.$value->registrasi_id.'/'.$value->registrasi->pasien_id;
					$list_notif	.=	'<li id="no-notif">
														<a href="'.$url.'" onclick="return confirm(\'Apakah yakin akan dilakukan tindakan Kamar Bersalin? Karena akan menambah kunjungan Kamar Bersalin.\')">
															<span style="font-size:10px;">Order pasien '.instalasi(substr($value->registrasi->status_reg,0,1)).' <b>'.$value->registrasi->pasien->no_rm.' - '.substr($value->registrasi->pasien->nama,0,15).'</b></span>
														</a>
													</li>';
				}
			}
		}elseif(strtolower(Auth::user()->role()->first()->name)=='apotik'){
			$notif = Depopo::where('status','Pending')->where('supplier','Apotek')->get();
			if($notif!=null){
				$list_notif	.=	'<li id="no-notif" style="background:#f9f9f9;"><a href="#">
														<span style="font-size:12px;font-weight:bold;">#Notifikasi</span>
												</a></li>';
				foreach($notif as $key => $value){
					$url = '/dist';
					$list_notif	.=	'<li id="no-notif">
														<a href="'.$url.'">
															<span style="font-size:10px;">Order obat dari depo <b>'.$value->depo->nama_depo.'</b></span>
														</a>
													</li>';
				}
			}
			$notif2 = Permintaanobat::whereIn('status',['pending','proses'])->get();
			if($notif2!=null){
				if($list_notif==""){
					$list_notif	.=	'<li id="no-notif" style="background:#f9f9f9;"><a href="#">
															<span style="font-size:12px;font-weight:bold;">#Notifikasi</span>
													</a></li>';
				}
				foreach($notif2 as $key => $value){
					$url = '/penjualan/formpermintaan/'.$value->registrasi->pasien_id.'/'.$value->registrasi_id;
					$list_notif	.=	'<li id="no-notif">
														<a href="'.$url.'">
															<span style="font-size:10px;">Permintaan obat dari pasien <b>'.$value->registrasi->pasien->nama.'</b></span>
														</a>
													</li>';
				}
			}
			//$notif3 = Registrasi::whereIn('posisi_pasien',['selesai pembayaran'])->get();
			$notif3 = db::select(db::raw("SELECT *
			FROM registrasis
			WHERE posisi_pasien IN ('selesai pembayaran')"));
			
			if($notif3!=null){
				if($list_notif==""){
					$list_notif	.=	'<li id="no-notif" style="background:#f9f9f9;"><a href="#">
															<span style="font-size:12px;font-weight:bold;">#Notifikasi</span>
													</a></li>';
				}
				foreach($notif3 as $key => $value){					
					$url = '/penjualan/formpenjualan/'.$value->pasien_id.'/'.$value->id;
					$antrian = AntrianApotek::where('registrasi_id',$value->id)->first();
					$pasien = Pasien::find($value->pasien_id);
					$list_notif	.=	'<li id="no-notif">
														<a href="'.$url.'">
															<span style="font-size:10px;"><b>'.$antrian->kelompok.$antrian->nomor.' | '.$pasien->nama.'</b> sudah bayar</span>
														</a>
													</li>';
				}
			}
		}elseif(strtolower(Auth::user()->role()->first()->name)=='kasir'){
			$notif = Registrasi::whereIn('posisi_pasien',['konfirmasi farmasi','pengembalian uang retur'])->get();
			if($notif!=null){
				$list_notif	.=	'<li id="no-notif" style="background:#f9f9f9;"><a href="#">
														<span style="font-size:12px;font-weight:bold;">#Notifikasi Rawat Jalan / IGD</span>
												</a></li>';
				foreach($notif as $key => $value){
					if(substr($value->status_reg,0,1)!='I'){
						$url = '/kasir/bayar/'. $value->id.'/'.$value->pasien_id;
						if($value->posisi_pasien=='konfirmasi farmasi'){
							$list_notif	.=	'<li id="no-notif">
																<a href="'.$url.'">
																	<span style="font-size:10px;">Antrian <b>'.$value->antrianapotek->kelompok.$value->antrianapotek->nomor.'</b> | <b>'.$value->pasien->no_rm.'</b> '.substr($value->pasien->nama,0,20).'</span>
																</a>
															</li>';
						}else{
							$list_notif	.=	'<li id="no-notif">
																<a href="'.$url.'">
																	<span style="font-size:10px;">Pengembalian uang: <b>'.$value->pasien->no_rm.'</b> '.substr($value->pasien->nama,0,20).'</span>
																</a>
															</li>';
						}
					}
				}
				
				$list_notif	.=	'<li id="no-notif" style="background:#f9f9f9;"><a href="#">
														<span style="font-size:12px;font-weight:bold;">#Notifikasi Rawat Inap</span>
												</a></li>';
				foreach($notif as $key => $value){
					if(substr($value->status_reg,0,1)=='I'){
						$url = '/kasir/bayar/'. $value->id.'/'.$value->pasien_id;
						if($value->posisi_pasien=='konfirmasi farmasi'){
							$list_notif	.=	'<li id="no-notif">
																<a href="'.$url.'">
																	<span style="font-size:10px;">Antrian <b>'.$value->antrianapotek->kelompok.$value->antrianapotek->nomor.'</b> | <b>'.$value->pasien->no_rm.'</b> '.substr($value->pasien->nama,0,20).'</span>
																</a>
															</li>';
						}else{
							$list_notif	.=	'<li id="no-notif">
																<a href="'.$url.'">
																	<span style="font-size:10px;">Pengembalian uang: <b>'.$value->pasien->no_rm.'</b> '.substr($value->pasien->nama,0,20).'</span>
																</a>
															</li>';
						}
					}
				}
			}
		}
		
		if($list_notif==""){
			$list_notif	.=	'<li id="no-notif">
												<a href="#">
													<span class="text12">Belum ada notifikasi</span>
												</a>
											</li>';
		}
		
		$count = 0;
		if($notif!=null){
			$count = count($notif);
		}
		if($notif2!=null){
			$count = $count + count($notif2);
		}
		if($notif3!=null){
			$count = $count + count($notif3);
		}
		$json_data = array(
			"list_notif"  => $list_notif,
			"count" => $count,
		);
		echo json_encode($json_data);
	}
}
