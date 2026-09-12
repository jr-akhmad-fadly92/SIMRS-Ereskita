<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Penjualan;
use App\Penjualandetail;
use App\Permintaanobat;
use App\Permintaanobatdetail;
use App\Pemakaian;
use App\Pemakaiandetail;
use App\Resep;
use App\Resepdetail;
use App\Depo;
use App\Depomasterobat;
use App\Masterobat;
use App\User;
use App\ResepTelaah;
use App\Aturanetiket;
use App\MasterTelaah;
use App\Obatracikan;
use App\MarginHargaObat;
use App\Pembayaran;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Registrasi\Entities\Tagihan;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Role\Entities\Role;
use DB;
use Activity;
use Yajra\DataTables\DataTables;
use Auth;
use Flashy;

class FarmasiController extends Controller
{
  public function lap_farmasi(){
		$data['penjualan'] = Penjualan::where('created_at', 'LIKE', date('Y-m-d').'%')->get();
		return view('farmasi.laporan.penjualan', $data);
	}

  public function lap_farmasi_byTanggal(Request $request){
		request()->validate(['tga'=>'required']);
		$penjualan = Penjualan::whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])->get();
		if($penjualan->count() < 0) {
			return redirect('farmasi/laporan/penjualan');
		} else {
			foreach ($penjualan as $key => $d) {
				if (Folio::where('namatarif', $d->no_resep)->count() < 1 ) {
					Penjualandetail::where('no_resep', $d->no_resep)->delete();
					Penjualan::where('no_resep', $d->no_resep)->delete();
				}
			}
			$data['penjualan'] = Penjualan::whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])->get();
			return view('farmasi.laporan.penjualan', $data);
		}
	}

  public function cetak_etiket($jenis,$penjualan_id=''){
		$data['penjualan'] 	= Penjualan::find($penjualan_id);
		if($jenis=='epo'){
			$data['penjualan'] 	= Permintaanobat::find($penjualan_id);
		}
		$data['reg']	= Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		if(substr($data['reg']->status_reg,0,1)=='I'){
			$konversi_ap 		= Penjualandetail::where('penjualan_id', $data['penjualan']->id)->where('hapus',null)->get();
			if($jenis=='epo'){
				$konversi_ap 		= Permintaanobatdetail::where('permintaan_id', $data['penjualan']->id)->where('status','Diproses')->where('retur_by',null)->where('delete_by',null)->get();
			}
			$aturan_jam					= array();
			foreach($konversi_ap as $key => $datax){
				if($datax->konversi_aturan_pakai!=null){
					$explode_konversi = explode(', ',$datax->konversi_aturan_pakai);
					foreach($explode_konversi as $exp){
						$aturan_jam[] = $exp;
					}
				}
			}
			$data['aturan_jam'] = array_unique($aturan_jam);
			$data_obat_minum = null;
			$data_obat_injeksi = null;
			$data_obat_alkes = null;
			$data_obat_infus = null;
			foreach($data['aturan_jam'] as $aj){
				$get_data_racik 		= Penjualandetail::where('penjualan_id', $data['penjualan']->id)->where('hapus',null)->where('status_racikan',1)->groupBy('obat_racikan_id')->get();
				if($jenis=='epo'){
					$get_data_racik 		= Permintaanobatdetail::where('permintaan_id', $data['penjualan']->id)->where('status','Diproses')->where('retur_by',null)->where('delete_by',null)->where('status_racikan',1)->groupBy('obat_racikan_id')->get();
				}
				if($get_data_racik!=null){
					$no = 1;
					foreach($get_data_racik as $keys => $dataet){
						$exp_et = explode(', ',$dataet->konversi_aturan_pakai);
						foreach($exp_et as $et){
							if($aj==$et){
								$data_obat_minum[$aj][] = '(Racikan '.$no.') ('.$dataet->jumlah_aturanpakai.') ('.$dataet->informasi1.'); ';
								$no++;
							}
						}
					}
				}
				$get_data_nonracik 	= Penjualandetail::where('penjualan_id', $data['penjualan']->id)->where('hapus',null)->where('status_racikan',null)->get();
				if($jenis=='epo'){
					$get_data_nonracik 	= Permintaanobatdetail::where('permintaan_id', $data['penjualan']->id)->where('status','Diproses')->where('retur_by',null)->where('delete_by',null)->where('status_racikan',null)->get();
				}
				if($get_data_nonracik!=null){
					$no = 1;
					foreach($get_data_nonracik as $keys => $dataet){
						$exp_et = explode(', ',$dataet->konversi_aturan_pakai);
						foreach($exp_et as $et){
							if($aj==$et){
								if($dataet->jenis_obat=='OBAT MINUM'){
									$data_obat_minum[$aj][] = '('.$dataet->masterobat->nama.') ('.$dataet->jumlah_aturanpakai.') ('.$dataet->informasi1.'); ';
									$no++;
								}elseif($dataet->jenis_obat=='INJEKSI'){
									$data_obat_injeksi[$aj][] = '('.$dataet->masterobat->nama.') ('.$dataet->jumlah_aturanpakai.') ('.$dataet->informasi1.'); ';
								}elseif($dataet->jenis_obat=='ALKES'){
									$data_obat_alkes[$aj][] = '('.$dataet->masterobat->nama.') ('.$dataet->jumlah_aturanpakai.'); ';
								}elseif($dataet->jenis_obat=='INFUS'){
									$data_obat_infus[$aj][] = '('.$dataet->masterobat->nama.') ('.$dataet->dosis.'); ';
								}
							}
						}
					}
				}
			}
			$data['sort_data_obat_minum'] = $data_obat_minum;
			$data['sort_data_obat_injeksi'] = $data_obat_injeksi;
			$data['sort_data_obat_alkes'] = $data_obat_alkes;
			$data['sort_data_obat_infus'] = $data_obat_infus;
		}
		return view('farmasi.laporan.etiket', $data);
	}

  public function cetak_etiket_bebas($penjualan_id=''){
		$data['penjualan'] = Penjualan::find($penjualan_id);
		return view('farmasi.laporan.etiket_bebas', $data);
	}

  public function cetakDetail($penjualan_id=''){
		$data['penjualan'] = Penjualan::where('id',$penjualan_id)->first();
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['detail'] = Penjualandetail::where('penjualan_id', $data['penjualan']->id)->where('hapus',null)->get();
		$data['total'] = $data['detail']->sum('hargajual');
		return view('farmasi.laporan.detail', $data)->with('no', 1);
	}
	
	public function cetakResep($penjualan_id=''){
		$data['penjualan'] = Penjualan::where('id',$penjualan_id)->first();
		$data['reg'] = Registrasi::where('id', $data['penjualan']->registrasi_id)->first();
		$data['detail_nonracik'] = Penjualandetail::where('penjualan_id', $data['penjualan']->id)->where('status_racikan',null)->where('hapus',null)->get();
		$data['detail_racikan'] = Penjualandetail::join('obat_racikan','penjualandetails.obat_racikan_id','=','obat_racikan.id')
															->where('penjualan_id', $data['penjualan']->id)
															->where('status_racikan','!=',null)
															->where('hapus',null)
															->select('penjualandetails.*', 'penjualandetails.penjualan_id as penj_id', 'penjualandetails.obat_racikan_id as racikan_id', 'obat_racikan.jenis', 'obat_racikan.satuan', 'obat_racikan.jumlah as jumlah_racikan')
															->groupBy('obat_racikan_id')->get();
		//$data['total'] = $data['detail']->sum('hargajual');
		return view('farmasi.laporan.cetak-resep', $data)->with('no', 1);
	}

  public function hapusLaporan($no_faktur){
		Penjualandetail::where('no_resep', $no_faktur)->delete();
		Penjualan::where('no_resep', $no_faktur)->delete();
		return redirect('farmasi/laporan/penjualan');
	}
	
	public function getMasterobat($id){
		$data = Masterobat::find($id);
		return response()->json(['expired'=>$data->expired_date]); exit;
	}
	
	public function getRacikan($id){
		$data = Obatracikan::find($id);
		return response()->json([
			'jenis_racikan'=>$data->jenis,
			'jumlah_racikan'=>$data->jumlah,
			'satuan_racikan'=>$data->satuan
		]); exit;
	}
	
	// TELAAH
	public function telaahResep($jenis, $registrasi_id){
		if($jenis=='epo'){
			$data['no_resep'] = Permintaanobat::where('registrasi_id',$registrasi_id)->first();
		}else{
			$data['no_resep'] = Penjualan::where('registrasi_id',$registrasi_id)->first();
		}
		$penjualan_id = 0;
		if($data['no_resep']!=null){
			$penjualan_id = $data['no_resep']->id;
		}else{
			Flashy::success('Data tidak ditemukan');
			return redirect(url()->previous());
		}
		if(count(ResepTelaah::where('registrasi_id', $registrasi_id)->where('jenis',$jenis)->get())==0){
			foreach(MasterTelaah::get() as $key => $datax){
				$get_telaah = new ResepTelaah;
				$get_telaah->telaah_id 			= $datax->id;
				if($datax->uraian_interaksi==1){
					$get_telaah->jawaban 				= "";
				}else{
					$get_telaah->jawaban 				= 0;
				}
				$get_telaah->jenis 					= $jenis;
				$get_telaah->registrasi_id 	= $registrasi_id;
				$get_telaah->penjualan_id 	= $penjualan_id;
				$get_telaah->created_at 		= date('Y-m-d H:i:s');
				$get_telaah->save();
			}
		}
		$data['master_telaah'] 	= MasterTelaah::get();
		$data['resep_telaah'] 	= ResepTelaah::where('penjualan_id',$penjualan_id)->where('registrasi_id', $registrasi_id)->where('jenis',$jenis)->get();
		//var_dump($data['resep_telaah']); exit;
		$data['register'] 			= Registrasi::where('id',$registrasi_id)->first();
		$data['apoteker_perawat']	= Pegawai::whereIn('kategori_pegawai', [2,6])->get();
		$data['jenis']					= $jenis;
		return view('farmasi.resep_telaah', $data);
	}
	
	public function simpanTelaah(Request $request){
		$penjualan_id = 0;
		if($request['jenis']=='epo'){
			$get_penper = Permintaanobat::where('registrasi_id',$request['registrasi_id'])->first();
		}else{
			$get_penper = Penjualan::where('registrasi_id',$request['registrasi_id'])->first();
		}
		if($get_penper==null){
			Flashy::success('Data tidak ditemukan');
			return redirect(url()->previous());
		}else{
			$penjualan_id = $get_penper->id;
		}
		
		$get_telaah	= ResepTelaah::where('registrasi_id', $request['registrasi_id'])->where('jenis',$request['jenis'])->get();
		if(count($get_telaah)>0){
			$master_telaah 	= MasterTelaah::get();
			foreach($master_telaah as $key => $data){
				$update_telaah	= ResepTelaah::where('registrasi_id', $request['registrasi_id'])->where('jenis',$request['jenis'])->where('telaah_id', $data->id)->first();
				if($data->aspek_telaah==1){
					$update_telaah->jawaban = $request['aspektelaah'.$data->id];
				}
				if($data->telaah_obat==1){
					$update_telaah->jawaban = $request['telaahobat'.$data->id];
				}
				if($data->pelayanan_resep==1){
					if($data->id==16){
						$update_telaah->jawaban = $request['id_pelayananresep'.$data->id];
					}elseif($data->id==17){
						$update_telaah->jawaban = $request['id_pelayananresep'.$data->id];
					}else{
						$update_telaah->jawaban = json_encode($request['pelayananresep'.$data->id]);
					}
				}
				if($data->uraian_interaksi==1){
					$update_telaah->jawaban = $request['uraianinteraksi'.$data->id];
				}
				$update_telaah->penjualan_id = $penjualan_id;
				$update_telaah->update_at = date('Y-m-d H:i:s');
				$update_telaah->save();
			}
		}
		Flashy::success('Resep telaah berhasil disimpan');
		if($request['jenis']=='epo'){
			return redirect('penjualan/formpermintaan/'.$request['pasien_id'].'/'.$request['registrasi_id'].'/'.$request['penjualan_id']);
		}else{
			return redirect('penjualan/formpenjualan/'.$request['pasien_id'].'/'.$request['registrasi_id'].'/'.$request['penjualan_id']);
		}
	}
	
	// PEMAKAIAN
  public function detailPemakaian($no_registrasi){
		$get_pem = Pemakaian::where('registrasi_id',$no_registrasi)->first();
		$detail = null;
		$no_resep = null;
		if($get_pem!=null){
			$no_resep = $get_pem->no_resep;
		}
		DB::statement(DB::raw('set @rownum=0'));
		if(strtolower(Auth::user()->role()->first()->name)=='rawatinap' OR strtolower(Auth::user()->role()->first()->name)=='rawatjalan' OR strtolower(Auth::user()->role()->first()->name)=='rawatdarurat' or strtolower(Auth::user()->role()->first()->name)=='dokter'){
			$detail = Pemakaiandetail::select([
				DB::raw('@rownum  := @rownum  + 1 AS rownum'),
				'id',
				'masterobat_id',
				'jumlah',
				'created_at',
				'satuan',
				'hargajual',
				'user_id'
			])
			->where('no_resep', $no_resep)
			->get();
		}else{
			$userx = [];
			$unit = 0;
			if(strtolower(Auth::user()->role()->first()->name)=='laboratorium'){
				$unit=9;
			}elseif(strtolower(Auth::user()->role()->first()->name)=='radiologi'){
				$unit=15;
			}elseif(strtolower(Auth::user()->role()->first()->name)=='fisioterapi'){
				$unit=14;
			}elseif(strtolower(Auth::user()->role()->first()->name)=='operasi'){
				$unit=19;
			}elseif(strtolower(Auth::user()->role()->first()->name)=='kamarbersalin'){
				$unit=32;
			}
			$get_roleid = DB::table('role_user')->where('role_id',$unit)->select('user_id')->get();
			foreach($get_roleid as $data){
				$userx[] = $data->user_id;
			}
			$detail = Pemakaiandetail::select([
				DB::raw('@rownum  := @rownum  + 1 AS rownum'),
				'id',
				'masterobat_id',
				'jumlah',
				'created_at',
				'satuan',
				'hargajual',
				'user_id'
			])
			->where('no_resep', $no_resep)
			->whereIn('user_id', $userx)
			->get();
		}
		if($detail!=null){
			session(['total_obat'=>$detail->sum('hargajual')]);
		}
		return DataTables::of($detail)
		->addColumn('masterobat_id', function ($detail) {
			return $detail->masterobat->nama;
		})
		->addColumn('satuan', function ($detail) {
			return $detail->masterobat->satuan;
		})
		->addColumn('created_at', function ($detail) {
			$hari = array ( 1 => 
				'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
			return $hari[ date_format($detail->created_at, 'N') ].', '.date_format($detail->created_at, 'd-m-Y H:i:s');
		})
		->addColumn('delete', function ($detail) {
			if(Auth::user()->id==$detail->user_id){
				return ' <a href="#" data-id="'.$detail->id.'" class="btn btn-sm btn-danger btn-flat hapus"><i class="fa fa-trash"></i></a> ';
			}else{
				return '';
			}
		})
		->rawColumns(['masterobat_id','delete'])
		->make(true);
	}
	
  public function simpanPemakaian(Request $request){
		if(strtolower(Auth::user()->role()->first()->name)=='administrator'){
			return response()->json(['sukses'=>false,'message'=>'Administrator tidak dapat melakukan ini']); exit;
		}
		
		$masterobat = Depomasterobat::where('id', $request['masterobat_id'])->first();
		if($masterobat!=null){
			if((int)$masterobat->stok < (int)$request['jumlah']){
				return response()->json(['sukses'=>false,'message'=>'Sisa stok tinggal '.$masterobat->stok]); exit;
			}
		}else{
			return response()->json(['sukses'=>false,'message'=>'Obat tidak tersedia']); exit;
		}		
		
		$get_pem = Pemakaian::where('registrasi_id',$request['idreg'])->first();
		if($get_pem==null){
			$no_resep = 'PEM-OBAT'.date('YmdHis');
			$get_pem = new Pemakaian();
			$get_pem->no_resep = $no_resep;
			$get_pem->user_id = Auth::user()->id;
			$get_pem->registrasi_id = $request['idreg'];
			$get_pem->save();
		}else{
			$no_resep = $get_pem->no_resep;
			
		}
		
		$d = new Pemakaiandetail();
		$d->pemakaian_id 	= $get_pem->id;
		$d->no_resep 			= $no_resep;
		$d->masterobat_id = $request['masterobat_id'];
		$d->jumlah 				= $request['jumlah'];
		$d->satuan 				= $request['satuan'];
		$d->hargajual 		= mophp(substr($get_pem->registrasi->status_reg,0,1),$masterobat->hargajual) * $request['jumlah'];
		$d->informasi1 		= $request['informasi1'];
		$d->informasi2 		= $request['informasi2'];
		$d->user_id 			= Auth::user()->id;
		if($d->save()){
			$masterobat->stok = (int)$masterobat->stok - (int)$request['jumlah'];
			$masterobat->save();
		}
		
		$total = 0;
		$det = Pemakaiandetail::where('pemakaian_id', $get_pem->id)->get();
		foreach ($det as $key => $d) {
			$total += $d->hargajual;
		}
		session(['total_obat'=>$total]);
		$reg = Registrasi::find(Pemakaian::find($get_pem->id)->registrasi_id);
		$get_folio = Folio::where('registrasi_id',$request['idreg'])->where('namatarif',$no_resep)->where('jenis','PEM')->first();
		if($get_folio==null){
			$get_folio = new Folio();
			$get_folio->registrasi_id = $request['idreg'];
			$get_folio->namatarif     = $no_resep;
			$get_folio->total         = $total;
			$get_folio->tarif_id      = 20000;
			$get_folio->lunas         = 'N';
			$get_folio->jenis         = 'PEM';
			$get_folio->cara_bayar_id = $reg->bayar;
			$get_folio->poli_tipe     = 'A';
			$get_folio->pasien_id     = $reg->pasien_id;
			$get_folio->dokter_id     = $reg->dokter_id;
			$get_folio->poli_id       = $reg->poli_id;
			$get_folio->user_id       = Auth::user()->id;
		}else{
			$get_folio->total         = $total;
			$get_folio->cara_bayar_id = $reg->bayar;
			$get_folio->pasien_id     = $reg->pasien_id;
			$get_folio->dokter_id     = $reg->dokter_id;
			$get_folio->poli_id       = $reg->poli_id;
			$get_folio->user_id       = Auth::user()->id;
		}
		$get_folio->save();
		return response()->json(['sukses'=>true, 'total'=>$total]); exit;
	}	
	
	public function hapusPemakaian($id){
		if(strtolower(Auth::user()->role()->first()->name)=='administrator'){
			return response()->json(['sukses'=>false,'message'=>'Administrator tidak dapat melakukan ini']); exit;
		}
    $item 			= Pemakaiandetail::where('id', $id)->first();
		$jml_stok 			= $item->jumlah;
		$masterobat_id 	= $item->masterobat_id;
		$no_resep 			= $item->no_resep;
		$id_pem				= $item->pemakaian_id;
    if($item->delete()){
		if(strtolower(Auth::user()->role()->first()->name)=='dokter'){
			$depo = Depo::where('nama_depo', 'rawatjalan')->first();			
		}else{
			$depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();			
		}
			// cek stok
			$masterobat = Depomasterobat::where('id', $masterobat_id)->where('id_depo', $depo->id)->first();
			if($masterobat!=null){
				$masterobat->stok = (int)$masterobat->stok + (int)$jml_stok;
				$masterobat->save();
			}
			
			$total = 0;
			$det = Pemakaiandetail::where('pemakaian_id', $id_pem)->get();
			foreach ($det as $key => $d) {
			  $total += $d->hargajual;
			}
			session(['total_obat'=>$total]);
			$reg = Registrasi::find(Pemakaian::find($id_pem)->registrasi_id);
			$get_folio = Folio::where('registrasi_id',$reg->id)->where('namatarif',$no_resep)->where('jenis','PEM')->first();
			$get_folio->total         = $total;
			$get_folio->cara_bayar_id = $reg->bayar;
			$get_folio->pasien_id     = $reg->pasien_id;
			$get_folio->dokter_id     = $reg->dokter_id;
			$get_folio->poli_id       = $reg->poli_id;
			$get_folio->user_id       = Auth::user()->id;
			$get_folio->save();
			
			return response()->json(['sukses' => true, 'total'=>$total]);
		}else{
			return response()->json(['sukses' => false]);
		}
    }
	
	// PERMINTAAN
  public function detailPermintaan($no_registrasi){
		$get_pem = Permintaanobat::where('registrasi_id',$no_registrasi)->first();
		if($get_pem==null){
			$no_resep = null;			
		}else{
			$no_resep = $get_pem->no_resep;
		}
		DB::statement(DB::raw('set @rownum=0'));
		$detail = Permintaanobatdetail::join('permintaan_obats','permintaan_obat_details.permintaan_id','=','permintaan_obats.id')
		->select([
			DB::raw('@rownum  := @rownum  + 1 AS rownum'),
			'permintaan_obat_details.*',
			'permintaan_obats.status as status_perm'
		])->where('permintaan_obat_details.no_resep', $no_resep)->orderBy('id','desc')->get();
		if($get_pem!=null){
			return DataTables::of($detail)
			->addColumn('racikan', function ($detail) {
				if($detail->status_racikan==1){
					return $detail->obatRacikan->nama;
				}else{
					return "-";
				}
			})
			->addColumn('masterobat_id', function ($detail) {
				return $detail->masterobat->nama;
			})
			->addColumn('created_at', function ($detail) {
				$hari = array ( 1 => 
					'Senin',
					'Selasa',
					'Rabu',
					'Kamis',
					'Jumat',
					'Sabtu',
					'Minggu'
				);
				return $hari[ date_format($detail->created_at, 'N') ].', '.date_format($detail->created_at, 'd-m-Y H:i:s');
			})
			->addColumn('etiket', function ($detail) {
				return $detail->konversi_aturan_pakai;
			})
			->addColumn('status', function ($detail) {
				if($detail->delete_by!=null){
					return '<span class="text-red">Dihapus oleh '.User::where("id", $detail->delete_by)->first()->name.'</span>';
				}elseif($detail->status=='Pending' OR $detail->status=='Diproses'){
					return '<span class="text-green">'.$detail->status.'</span>';
				}elseif($detail->status=='Sudah Diminum Pasien'){
					return '<span class="text-aqua">'.$detail->status.'</span>';
				}elseif($detail->status=='Retur ke Apotek'){
					return '<span class="text-orange">Menunggu Konfirmasi Retur</span>';
				}elseif($detail->status=='Terima Retur'){
					return '<span class="text-orange">Diretur oleh '.User::where("id", $detail->retur_by)->first()->name.' & Diterima oleh '.User::where("id", $detail->terima_retur_by)->first()->name.'</span>';
				}else{
					//<option value="Retur ke Apotek">Retur ke Apotek</option>
					//<option value="Sudah Diminum Pasien">Sudah Diminum Pasien</option>
					//<option value="">-- status --</option>
					//onchange="updateStatus(this.value, '.$detail->id.')" 
					return '
						<select name="" class="form-control">
							<option value="Diserahkan" selected>Diserahkan</option>
						</select>
					';
				}
			})
			->addColumn('satuan', function ($detail) {
				return $detail->masterobat->satuan;
			})
			->addColumn('delete', function ($detail) {
					if($detail->status=='Pending' AND $detail->delete_by==null){
						return '<a href="#" data-permintaan-id="'.$detail->permintaan_id.'" data-id="'.$detail->id.'" class="btn btn-sm btn-danger btn-flat hapus-det-epo"><i class="fa fa-trash"></i></a> ';
					}elseif($detail->delete_by!=null){
						return $detail->alasan_hapus;
					}else{
						return '-';
					}
			})
			->addColumn('edit', function ($detail) {
					if($detail->status=='Pending' AND $detail->delete_by==null){
						return '<a href="#" data-permintaan-id="'.$detail->permintaan_id.'" data-id="'.$detail->id.'" class="btn btn-sm btn-info btn-flat edit-det-epo"><i class="fa fa-pencil"></i></a> ';
					}elseif($detail->status=='Diserahkan' AND $detail->delete_by==null){
						return '<a href="#" data-permintaan-id="'.$detail->permintaan_id.'" data-id="'.$detail->id.'" class="btn btn-sm btn-default btn-flat copy-det-epo"><i class="fa fa-copy"></i></a> ';
					}else{
						return '';
					}
			})
			->rawColumns(['masterobat_id','delete','status','edit'])
			->make(true);
		}else{
			return DataTables::of($detail)
					->make(true);
		}
	}
	
  public function simpanPermintaan(Request $request){
		if($request['epo_alergi']==""){
			return response()->json(['sukses'=>false,'message'=>'Harap memilih status alergi']); exit;
		}
		$get_pem = Permintaanobat::where('registrasi_id',$request['idreg'])->first();
		$masterobat = Masterobat::where('id', $request['epo_masterobat_id'])->first();
		if($request['isUpdateEpo']==1){
			$cek_obat = Permintaanobatdetail::where('id',$request['permintaan_id'])->first();
			if($cek_obat!=null){
				$stok_awal = $cek_obat->jumlah;
				if(strtolower(Auth::user()->role()->first()->name)=='apotik'){
					if($masterobat!=null){
						if(((int)$masterobat->stok+$cek_obat->jumlah) < (int)$request['epo_jumlah']){
							return response()->json(['sukses'=>false,'message'=>'Sisa stok tinggal '.($masterobat->stok+$cek_obat->jumlah)]); exit;
						}
					}else{
						return response()->json(['sukses'=>false,'message'=>'Obat tidak tersedia']); exit;
					}
				}
				$cek_obat->masterobat_id 			= $request['epo_masterobat_id'];
				$cek_obat->jumlah 						= $request['epo_jumlah'];
				$cek_obat->hargajual 					= mophp(substr($get_pem->registrasi->status_reg,0,1),$masterobat->hargajual) * $request['epo_jumlah'];
				$cek_obat->jenis_obat					= $masterobat->jenis;
				$cek_obat->expired						= $request['epo_expired'];
				$cek_obat->aturan_pakai				= $request['epo_aturan_pakai'];
				if($request['epo_aturan_pakai']!=''){
					$cek_obat->konversi_aturan_pakai = Aturanetiket::where('aturan',$request['epo_aturan_pakai'])->first()->konversi;
				}
				$cek_obat->satuan_aturanpakai = $request['epo_satuan_aturanpakai'];	
				$cek_obat->jumlah_aturanpakai = $request['epo_jumlah_aturanpakai'];	
				$cek_obat->informasi1					= $request['epo_informasi1'];
				$cek_obat->informasi2 				= $request['epo_informasi2'];
				if(strtolower(Auth::user()->role()->first()->name)=='apotik'){
					$cek_obat->status 						= 'Diproses';
				}else{
					$cek_obat->status 						= 'Pending';
				}
				if($cek_obat->save()){
					if(strtolower(Auth::user()->role()->first()->name)=='apotik'){
						$masterobat->stok = ($masterobat->stok + $stok_awal) - $request['epo_jumlah'];
						$masterobat->save();
					}
					return response()->json(['sukses'=>true,'message'=>'Data berhasil diubah']); exit;
				}else{
					return response()->json(['sukses'=>false,'message'=>'Data gagal diubah']); exit;
				}
			}
		}else{
			$no_resep = 'EPO'.date('YmdHis');		
			if($masterobat!=null){
				if((int)$masterobat->stok < (int)$request['epo_jumlah']){
					return response()->json(['sukses'=>false,'message'=>'Sisa stok tinggal '.$masterobat->stok]); exit;
				}
			}else{
				return response()->json(['sukses'=>false,'message'=>'Obat tidak tersedia']); exit;
			}		
			
			if($get_pem==null){
				$get_pem = new Permintaanobat();
				$get_pem->no_resep = $no_resep;
				$get_pem->user_id = Auth::user()->id;
				$get_pem->registrasi_id = $request['idreg'];
			}else{
				$no_resep = $get_pem->no_resep;			
			}
			$get_pem->status = 'pending';
			$get_pem->alergi = $request['epo_alergi'];
			$get_pem->keterangan_alergi = $request['epo_ket_alergi'];
			$get_pem->save();
			
			$d = new Permintaanobatdetail();
			$d->permintaan_id 	= $get_pem->id;
			$d->no_resep 				= $no_resep;
			$d->permintaan_masterobat_id 	= $request['epo_masterobat_id'];
			$d->permintaan_jumlah = $request['epo_jumlah'];
			$d->masterobat_id 	= $request['epo_masterobat_id'];
			$d->jumlah 					= $request['epo_jumlah'];
			$d->hargajual 			= mophp(substr($get_pem->registrasi->status_reg,0,1),$masterobat->hargajual) * $request['epo_jumlah'];
			$d->jenis_obat			= $masterobat->jenis;
			$d->expired					= $request['epo_expired'];
			$d->aturan_pakai		= $request['epo_aturan_pakai'];
			if($request['epo_aturan_pakai']!=''){
				$d->konversi_aturan_pakai = Aturanetiket::where('aturan',$request['epo_aturan_pakai'])->first()->konversi;
			}
			$d->satuan_aturanpakai = $request['epo_satuan_aturanpakai'];	
			$d->jumlah_aturanpakai = $request['epo_jumlah_aturanpakai'];			
			if($request['epo_racikan']==1){
				$d->status_racikan	= 1;
				$d->obat_racikan_id	= $request['text_epo_id_racikan'];
			}
			$d->informasi1			= $request['epo_informasi1'];
			$d->informasi2 			= $request['epo_informasi2'];
			$d->status 					= 'Pending';
			$d->created_by			= Auth::user()->id;
			$d->save();
			
			$total = 0;
			$det = Permintaanobatdetail::whereIn('status',['Diproses','Diserahkan'])->where('delete_by', null)->where('permintaan_id', $get_pem->id)->get();
			foreach ($det as $key => $dx) {
				$total += $dx->hargajual;
			}
			
			$reg = Registrasi::find(Permintaanobat::find($get_pem->id)->registrasi_id);
			$get_folio = Folio::where('registrasi_id',$request['idreg'])->where('namatarif',$no_resep)->where('jenis','EPO')->first();
			if($get_folio==null){
				$get_folio = new Folio();
				$get_folio->registrasi_id = $request['idreg'];
				$get_folio->namatarif     = $no_resep;
				$get_folio->total         = $total;
				$get_folio->tarif_id      = 30000;
				$get_folio->lunas         = 'N';
				$get_folio->jenis         = 'EPO';
				$get_folio->cara_bayar_id = $reg->bayar;
				$get_folio->poli_tipe     = 'A';
				$get_folio->pasien_id     = $reg->pasien_id;
				$get_folio->dokter_id     = $reg->dokter_id;
				$get_folio->poli_id       = $reg->poli_id;
				$get_folio->user_id       = Auth::user()->id;
			}else{
				$get_folio->total         = $total;
				$get_folio->cara_bayar_id = $reg->bayar;
				$get_folio->pasien_id     = $reg->pasien_id;
				$get_folio->dokter_id     = $reg->dokter_id;
				$get_folio->poli_id       = $reg->poli_id;
				$get_folio->user_id       = Auth::user()->id;
			}
			$get_folio->save();
			
			return response()->json(['sukses'=>true,'message'=>'Data berhasil ditambah']); exit;
		}
	}	
	
	public function copyPermintaan($id){
		$obat = Permintaanobatdetail::find($id);
		$permintaan = Permintaanobat::where('no_resep',$obat->no_resep)->first();
		if($obat->status_racikan==1){
			$copy_racikan = Obatracikan::find($obat->obat_racikan_id);
			if($copy_racikan!=null){
				$racikan = new Obatracikan();
				$racikan->registrasi_id = $permintaan->registrasi_id;
				$racikan->nama = 'Racikan '.(count(Obatracikan::where('registrasi_id',$permintaan->registrasi_id)->get())+1);
				$racikan->jenis = $copy_racikan->jenis;
				$racikan->jumlah = $copy_racikan->jumlah;
				$racikan->satuan = $copy_racikan->satuan;
				$racikan->created_at = date('Y-m-d H:i:s');
				if($racikan->save()){
					$obat_racikan = Permintaanobatdetail::where('obat_racikan_id',$obat->obat_racikan_id)->get();
					foreach($obat_racikan as $key => $dt){
						$d = new Permintaanobatdetail();
						$d->permintaan_id 	= $dt->permintaan_id;
						$d->no_resep 				= $dt->no_resep;
						$d->permintaan_masterobat_id 	= $dt->permintaan_masterobat_id;
						$d->permintaan_jumlah = $dt->permintaan_jumlah;
						$d->masterobat_id 	= $dt->masterobat_id;
						$d->jumlah 					= $dt->jumlah;
						$d->hargajual 			= $dt->hargajual;
						$d->jenis_obat			= $dt->jenis_obat;
						$d->expired					= $dt->expired;
						$d->aturan_pakai		= $dt->aturan_pakai;
						if($dt->aturan_pakai!=''){
							$d->konversi_aturan_pakai = Aturanetiket::where('aturan',$dt->aturan_pakai)->first()->konversi;
						}
						$d->satuan_aturanpakai = $dt->satuan_aturanpakai;	
						$d->jumlah_aturanpakai = $dt->jumlah_aturanpakai;			
						$d->status_racikan	= $dt->status_racikan;
						$d->obat_racikan_id	= $racikan->id;
						$d->informasi1			= $dt->informasi1;
						$d->informasi2 			= $dt->informasi2;
						$d->status 					= 'Pending';
						$d->created_by			= Auth::user()->id;
						$d->save();
					}
				}
			}
		}else{
			$d = new Permintaanobatdetail();
			$d->permintaan_id 	= $obat->permintaan_id;
			$d->no_resep 				= $obat->no_resep;
			$d->permintaan_masterobat_id 	= $obat->permintaan_masterobat_id;
			$d->permintaan_jumlah = $obat->permintaan_jumlah;
			$d->masterobat_id 	= $obat->masterobat_id;
			$d->jumlah 					= $obat->jumlah;
			$d->hargajual 			= $obat->hargajual;
			$d->jenis_obat			= $obat->jenis_obat;
			$d->expired					= $obat->expired;
			$d->aturan_pakai		= $obat->aturan_pakai;
			if($obat->aturan_pakai!=''){
				$d->konversi_aturan_pakai = Aturanetiket::where('aturan',$obat->aturan_pakai)->first()->konversi;
			}
			$d->satuan_aturanpakai = $obat->satuan_aturanpakai;	
			$d->jumlah_aturanpakai = $obat->jumlah_aturanpakai;			
			$d->status_racikan	= $obat->status_racikan;
			$d->obat_racikan_id	= $obat->obat_racikan_id;
			$d->informasi1			= $obat->informasi1;
			$d->informasi2 			= $obat->informasi2;
			$d->status 					= 'Pending';
			$d->created_by			= Auth::user()->id;
			$d->save();
		}
		
		$total = 0;
		$det = Permintaanobatdetail::whereIn('status',['Diproses','Diserahkan'])->where('delete_by', null)->where('permintaan_id', $permintaan->id)->get();
		foreach ($det as $key => $dx) {
			$total += $dx->hargajual;
		}
		$get_folio = Folio::where('registrasi_id',$permintaan->registrasi_id)->where('namatarif',$permintaan->no_resep)->where('jenis','EPO')->first();
		$get_folio->total = $total;
		if($get_folio->save()){
			return response()->json(['sukses'=>true]);
		}else{
			return response()->json(['sukses'=>false]);
		}
	}
	
	public function hapusPermintaan($id){		
		$obat = Permintaanobatdetail::find($id);
		$reg = Registrasi::find( Permintaanobat::find($obat->permintaan_id)->registrasi_id);
		$obat->hargajual = 0;
		$obat->status = null;
		$obat->delete_by = Auth::user()->id;
		
		if($obat->save()){
			Activity::log('permintaan_'.Auth::user()->name.' menghapus obat '.Masterobat::find($obat->masterobat_id)->nama.'  dari no struk '.$obat->no_resep);
			$total = 0;
			$det = Permintaanobatdetail::whereIn('status',['Diproses','Diserahkan'])->where('delete_by', null)->where('permintaan_id', $obat->permintaan_id)->get();
			foreach ($det as $key => $d) {
				$total += $d->hargajual;
			}
			$get_folio = Folio::where('registrasi_id',$reg->id)->where('namatarif',$obat->no_resep)->where('jenis','EPO')->first();
			$get_folio->total = $total;
			$get_folio->cara_bayar_id = $reg->bayar;
			$get_folio->pasien_id     = $reg->pasien_id;
			$get_folio->dokter_id     = $reg->dokter_id;
			$get_folio->poli_id       = $reg->poli_id;
			$get_folio->save();
			
			return response()->json(['sukses' => true]);
		}else{
			return response()->json(['sukses' => false]);
		}
  }
		
	public function cetakEpo($registrasi_id=''){
		$data['reg'] 								= Registrasi::where('id', $registrasi_id)->first();
		$data['permintaan'] 				= Permintaanobat::where('registrasi_id', $registrasi_id)->first();
		
		$data['aturanetiket'] 			= Aturanetiket::get();
		$aturan_jam					= array();
		foreach($data['aturanetiket'] as $key => $datax){
			$explode_konversi = explode(', ',$datax->konversi);
			foreach($explode_konversi as $exp){
				$aturan_jam[] = $exp;
			}
		}
		$data['aturan_jam'] 			= array_unique($aturan_jam);
		
		$data_obat_minum = null;
		$data_obat_injeksi = null;
		$data_obat_alkes = null;
		$data_obat_infus = null;
		$key_array1 = 0;
		$key_array2 = 0;
		$key_array3 = 0;
		$key_array4 = 0;
		$loop = 0;
		$data['obat_racikan'] 	= Permintaanobatdetail::where('permintaan_id', $data['permintaan']->id)->where('delete_by',null)->where('status_racikan',1)->whereIn('status',['Pending','Diproses'])->groupBy('obat_racikan_id')->get();
		if($data['obat_racikan']!=null){
			foreach($data['obat_racikan'] as $keys => $pd){
				$get_jam = Aturanetiket::where('aturan',$pd->aturan_pakai)->first();
				if($get_jam!=null){
					$jam = explode(', ',$get_jam->konversi);
					$loop++;
					foreach($jam as $jm){
						$data_obat_minum[$key_array1][$jm]['obat'] = 'Racikan '.$loop;
						$data_obat_minum[$key_array1][$jm]['jumlah'] = $pd->jumlah_aturanpakai;
						$data_obat_minum[$key_array1][$jm]['informasi1'] = $pd->informasi1;
						$key_array1++;
					}
				}
			}
		}
		$data['obat_non_racikan'] 	= Permintaanobatdetail::where('permintaan_id', $data['permintaan']->id)->where('delete_by',null)->where('status_racikan',null)->whereIn('status',['Pending','Diproses'])->get();
		if($data['obat_non_racikan']!=null){
			foreach($data['obat_non_racikan'] as $keys => $pd){
				$get_jam = Aturanetiket::where('aturan',$pd->aturan_pakai)->first();
				if($get_jam!=null){
					$jam = explode(', ',$get_jam->konversi);
					foreach($jam as $jm){
						if($pd->jenis_obat=='OBAT MINUM'){
							$data_obat_minum[$key_array1][$jm]['obat'] = $pd->masterobat->nama;
							$data_obat_minum[$key_array1][$jm]['jumlah'] = $pd->jumlah_aturanpakai;
							$data_obat_minum[$key_array1][$jm]['informasi1'] = $pd->informasi1;
							$key_array1++;
						}elseif($pd->jenis_obat=='INJEKSI'){
							$data_obat_injeksi[$key_array2][$jm]['obat'] = $pd->masterobat->nama;
							$data_obat_injeksi[$key_array2][$jm]['jumlah'] = $pd->jumlah_aturanpakai;
							$data_obat_injeksi[$key_array2][$jm]['informasi1'] = $pd->informasi1;
							$key_array2++;
						}elseif($pd->jenis_obat=='ALKES'){
							$data_obat_alkes[$key_array3][$jm]['obat'] = $pd->masterobat->nama;
							$data_obat_alkes[$key_array3][$jm]['jumlah'] = $pd->jumlah_aturanpakai;
							$data_obat_alkes[$key_array3][$jm]['informasi1'] = $pd->informasi1;
							$key_array3++;
						}elseif($pd->jenis_obat=='INFUS'){
							$data_obat_infus[$key_array4][$jm]['obat'] = $pd->masterobat->nama;
							$data_obat_infus[$key_array4][$jm]['jumlah'] = $pd->jumlah_aturanpakai;
							$data_obat_infus[$key_array4][$jm]['informasi1'] = $pd->informasi1;
							$key_array4++;
						}
					}
				}
			}
		}
		
		$data['sort_data_obat_minum'] = null;
		$data['sort_data_obat_injeksi'] = null;
		$data['sort_data_obat_alkes'] = null;
		$data['sort_data_obat_infus'] = null;
		foreach($data['aturan_jam'] as $aj){
			if($data_obat_minum!=null){
				foreach($data_obat_minum as $keyq => $data_a){
					foreach($data_a as $keyw => $data_b){
						if($aj==$keyw){
							$data['sort_data_obat_minum'][][$keyw] = $data_b['obat'].' ('.$data_b['jumlah'].') '.$data_b['informasi1'];
						}
					}
				}
			}
			if($data_obat_injeksi!=null){
				foreach($data_obat_injeksi as $keyq => $data_a){
					foreach($data_a as $keyw => $data_b){
						if($aj==$keyw){
							$data['sort_data_obat_injeksi'][][$keyw] = $data_b['obat'].' ('.$data_b['jumlah'].') '.$data_b['informasi1'];
						}
					}
				}
			}
			if($data_obat_alkes!=null){
				foreach($data_obat_alkes as $keyq => $data_a){
					foreach($data_a as $keyw => $data_b){
						if($aj==$keyw){
							$data['sort_data_obat_alkes'][][$keyw] = $data_b['obat'].' ('.$data_b['jumlah'].') '.$data_b['informasi1'];
						}
					}
				}
			}
			if($data_obat_infus!=null){
				foreach($data_obat_infus as $keyq => $data_a){
					foreach($data_a as $keyw => $data_b){
						if($aj==$keyw){
							$data['sort_data_obat_infus'][][$keyw] = $data_b['obat'].' ('.$data_b['jumlah'].') '.$data_b['informasi1'];
						}
					}
				}
			}
		}
		
		return view('farmasi.laporan.cetak-epo', $data)->with('no', 1);
	}
	
	public function addRacikanEpo(Request $request){
		if($request['epo_jenis_racikan']=="" OR $request['epo_jenis_racikan']=="-- pilih --"){
			return response()->json(['sukses'=>false,'message'=>'Harap memilih jenis racikan']); exit;
		}elseif($request['epo_jumlah_racikan']==""){
			return response()->json(['sukses'=>false,'message'=>'Harap mengisi jumlah racikan']); exit;
		}elseif($request['epo_satuan_racikan']=="" OR $request['epo_satuan_racikan']=="-- pilih --"){
			return response()->json(['sukses'=>false,'message'=>'Harap memilih satuan racikan']); exit;
		}
		$racikan = new Obatracikan();
		$racikan->registrasi_id = $request['registrasi_id'];
		$racikan->nama = 'Racikan '.(count(Obatracikan::where('registrasi_id',$request['registrasi_id'])->get())+1);
		$racikan->jenis = $request['epo_jenis_racikan'];
		$racikan->jumlah = $request['epo_jumlah_racikan'];
		$racikan->satuan = $request['epo_satuan_racikan'];
		$racikan->created_at = date('Y-m-d H:i:s');
		if($racikan->save()){		
			return response()->json(['sukses'=>true, 'id_racikan'=>$racikan->id]); exit;
		}else{
			return response()->json(['sukses'=>false]); exit;
		}
	}
	
	// RESEP
  public function detailResep($no_registrasi){
		$get_pem = Penjualan::where('registrasi_id',$no_registrasi)->first();
		if($get_pem==null){
			$no_resep = null;			
		}else{
			$no_resep = $get_pem->no_resep;
		}
		DB::statement(DB::raw('set @rownum=0'));
		$detail = Penjualandetail::join('penjualans','penjualandetails.penjualan_id','=','penjualans.id')
			->select([
			DB::raw('@rownum  := @rownum  + 1 AS rownum'),
			'penjualandetails.*',
			'penjualans.status'
		])->where('penjualandetails.no_resep', $no_resep)->get();
		if($get_pem!=null){
			return DataTables::of($detail)
			->addColumn('racikan', function ($detail) {
				if($detail->status_racikan==1){
					$racikan = $detail->obatRacikan->nama;
				}else{
					$racikan = '-';
				}
				return $racikan;
			})
			->addColumn('masterobat_id', function ($detail) {
				return $detail->masterobat->nama;
			})
			->addColumn('hargajual', function ($detail) {
				return number_format($detail->hargajual);
			})
			->addColumn('etiket', function ($detail) {
				return $detail->konversi_aturan_pakai;
			})
			->addColumn('satuan', function ($detail) {
				return $detail->masterobat->satuan;
			})
			->addColumn('status', function ($detail) {
					if($detail->status=='proses' AND strtolower(Auth::user()->role()->first()->name)=='apotik'){
						return 'Sedang Diproses';
					}elseif($detail->hapus==1){
						return $detail->alasan_hapus;
					}elseif($detail->status=='selesai'){
						return 'Siap Diambil';
					}elseif($detail->status=='pending' AND strtolower(Auth::user()->role()->first()->name)!='apotik'){
						return 'Peresepan';
					}else{
						return 'Menunggu Diproses';
					}
			})
			->addColumn('hapus', function ($detail) {
					if(session()->get('retur')=='retur'){
						return '<a href="#" data-id="'.$detail->id.'" class="btn btn-sm btn-warning btn-flat retur-det-res"><i class="fa fa-refresh"></i> Retur</a> ';
					}elseif($detail->status=='proses' AND strtolower(Auth::user()->role()->first()->name)=='apotik'){
					}elseif($detail->status=='selesai'){
					}elseif($detail->hapus==1){
						return 'Sudah dihapus';
					}else{
						return '<a href="#" data-penjualan-id="'.$detail->penjualan_id.'" data-id="'.$detail->id.'" class="btn btn-sm btn-danger btn-flat hapus-det-res"><i class="fa fa-trash"></i></a> ';
					}
			})
			->addColumn('edit', function ($detail) {
					if(session()->get('retur')=='retur'){
					}elseif($detail->status=='proses' AND strtolower(Auth::user()->role()->first()->name)=='apotik'){
					}elseif($detail->status=='selesai'){
					}elseif($detail->hapus==1){
					}else{
						return '<a href="#" data-penjualan-id="'.$detail->penjualan_id.'" data-id="'.$detail->id.'" class="btn btn-sm btn-info btn-flat edit-det-res"><i class="fa fa-pencil"></i></a> ';
					}
			})
			->rawColumns(['masterobat_id','status','hapus','edit'])
			->make(true);
		}else{
			return DataTables::of($detail)
					->make(true);
		}
	}
	
	public function addRacikanResep(Request $request){
		if($request['resep_jenis_racikan']=="" OR $request['resep_jenis_racikan']=="-- pilih --"){
			return response()->json(['sukses'=>false,'message'=>'Harap memilih jenis racikan']); exit;
		}elseif($request['resep_jumlah_racikan']==""){
			return response()->json(['sukses'=>false,'message'=>'Harap mengisi jumlah racikan']); exit;
		}elseif($request['resep_satuan_racikan']=="" OR $request['resep_satuan_racikan']=="-- pilih --"){
			return response()->json(['sukses'=>false,'message'=>'Harap memilih satuan racikan']); exit;
		}
		$racikan = new Obatracikan();
		$racikan->registrasi_id = $request['registrasi_id'];
		$racikan->nama = 'Racikan '.(count(Obatracikan::where('registrasi_id',$request['registrasi_id'])->get())+1);
		$racikan->jenis = $request['resep_jenis_racikan'];
		$racikan->jumlah = $request['resep_jumlah_racikan'];
		$racikan->satuan = $request['resep_satuan_racikan'];
		$racikan->created_at = date('Y-m-d H:i:s');
		if($racikan->save()){		
			return response()->json(['sukses'=>true, 'id_racikan'=>$racikan->id]); exit;
		}else{
			return response()->json(['sukses'=>false]); exit;
		}
	}
	
  public function simpanResep(Request $request){
		if($request['resep_alergi']==""){
			return response()->json(['sukses'=>false,'message'=>'Harap memilih status alergi']); exit;
		}		
		$get_pem = Penjualan::where('registrasi_id',$request['idreg'])->first();
		$masterobat = Masterobat::where('id', $request['resep_masterobat_id'])->first();
		if($request['isUpdateResep']==1){
			$cek_obat = Penjualandetail::where('id',$request['penjualan_id'])->first();
			if($cek_obat!=null){
				$cek_obat->masterobat_id 			= $request['resep_masterobat_id'];
				$cek_obat->jumlah 						= $request['resep_jumlah'];
				$cek_obat->hargasatuan				= mophp(substr($get_pem->registrasi->status_reg,0,1),$masterobat->hargajual);
				$cek_obat->hargajual 					= mophp(substr($get_pem->registrasi->status_reg,0,1),$masterobat->hargajual) * $request['resep_jumlah'];
				$cek_obat->jenis_obat					= $masterobat->jenis;
				$cek_obat->expired						= $request['resep_expired'];
				$cek_obat->aturan_pakai				= $request['resep_aturan_pakai'];
				$cek_obat->konversi_aturan_pakai = Aturanetiket::where('aturan',$request['resep_aturan_pakai'])->first()->konversi;
				$cek_obat->satuan_aturanpakai = $request['resep_satuan_aturanpakai'];	
				$cek_obat->jumlah_aturanpakai = $request['resep_jumlah_aturanpakai'];	
				$cek_obat->informasi1					= $request['resep_informasi1'];
				$cek_obat->informasi2 				= $request['resep_informasi2'];
				if(isset($request['is_did'])){
					$cek_obat->is_did 					= $request['is_did'];
				}
				if($cek_obat->save()){
					return response()->json(['sukses'=>true,'message'=>'Data berhasil diubah']); exit;
				}else{
					return response()->json(['sukses'=>false,'message'=>'Data gagal diubah']); exit;
				}
			}
		}else{
			if($masterobat!=null){
				if((int)$masterobat->stok < (int)$request['resep_jumlah']){
					return response()->json(['sukses'=>false,'message'=>'Sisa stok tinggal '.$masterobat->stok]); exit;
				}
			}else{
				return response()->json(['sukses'=>false,'message'=>'Obat tidak tersedia']); exit;
			}		
			
			$jenisreg = Registrasi::find($request['idreg'])->status_reg;
			if (substr($jenisreg,0,1) == 'J') {
				$jenis = 'ORJ';
				$no_resep = 'FRJ'.date('YmdHis');
			} elseif (substr($jenisreg,0,1) == 'I') {
				$jenis = 'ORI';
				$no_resep = 'FRI'.date('YmdHis');
			} elseif (substr($jenisreg,0,1) == 'G') {
				$jenis = 'ORD';
				$no_resep = 'FRD'.date('YmdHis');
			} elseif (substr($jenisreg,0,1) == 'A') {
				$jenis = 'ORA';
			}
			
			if($get_pem==null){
				$get_pem = new Penjualan();
				$get_pem->no_resep = $no_resep;
				$get_pem->status = 'pending';
				$get_pem->user_id = Auth::user()->id;
				$get_pem->registrasi_id = $request['idreg'];
				
				$get_pem_klinik = db::table('resep_klinik')->insert([
					'no_resep' 	=> $no_resep,
					'user_id'	=> Auth::user()->id,
					'registrasi_id' => $request['idreg'],
					'alergi'	=> $request['resep_alergi'],
					'keterangan_alergi' =>$request['resep_ket_alergi']
				]);
				
			}else{
				$no_resep = $get_pem->no_resep;		
				$get_pem_klinik = db::table('resep_klinik')->where('no_resep',$no_resep)->update([
					'no_resep' 	=> $no_resep,
				]);	
			}
			$get_pem->alergi = $request['resep_alergi'];
			$get_pem->keterangan_alergi = $request['resep_ket_alergi'];
			$get_pem->save();
			
			$d = new Penjualandetail();
			$d->penjualan_id 	= $get_pem->id;
			$d->no_resep 			= $no_resep;
			$d->permintaan_masterobat_id 	= $request['resep_masterobat_id'];
			$d->permintaan_jumlah = $request['resep_jumlah'];
			$d->masterobat_id	= $request['resep_masterobat_id'];
			$d->jumlah 				= $request['resep_jumlah'];
			$d->hargasatuan		= mophp(substr($get_pem->registrasi->status_reg,0,1),$masterobat->hargajual);
			$d->hargajual 		= mophp(substr($get_pem->registrasi->status_reg,0,1),$masterobat->hargajual) * $request['resep_jumlah'];
			$d->jenis_obat		= $masterobat->jenis;
			$d->expired				= $request['resep_expired'];
			$d->aturan_pakai	= $request['resep_aturan_pakai'];
			if($request['resep_aturan_pakai']!=''){
				$d->konversi_aturan_pakai = Aturanetiket::where('aturan',$request['resep_aturan_pakai'])->first()->konversi;
			}
			$d->satuan_aturanpakai = $request['resep_satuan_aturanpakai'];		
			$d->jumlah_aturanpakai = $request['resep_jumlah_aturanpakai'];		
			if($request['resep_racikan']==1){
				$d->status_racikan	= 1;
				$d->obat_racikan_id	= $request['text_resep_id_racikan'];
			}
			$d->informasi1		= $request['resep_informasi1'];
			$d->informasi2 		= $request['resep_informasi2'];
			$d->is_did 				= 0;
			$d->save();
			
			$get_pem_id_klinik = db::table('resep_klinik')->where('no_resep',$no_resep)->first();
			$d_klinik = db::table('resep_klinik_detail')->insert([
				'resep_klinik_id' 	=> $get_pem_id_klinik->id,
				'no_resep' 			=> $no_resep,
				'permintaan_masterobat_id'	=> $request['resep_masterobat_id'],
				'permintaan_jumlah'	=>$request['resep_jumlah'],
				'masterobat_id'		=> $request['resep_masterobat_id'],
				'jumlah'			=> $request['resep_jumlah'],
				'aturan_pakai'		=>$request['resep_aturan_pakai'],
				'konversi_aturan_pakai' => Aturanetiket::where('aturan',$request['resep_aturan_pakai'])->first()->konversi,
				'satuan_aturanpakai'	=> $request['resep_satuan_aturanpakai'],
				'jumlah_aturanpakai'	=> $request['resep_jumlah_aturanpakai'],
				'informasi1'			=> $request['resep_informasi1'],
				'informasi2'			=> $request['resep_informasi2']
			]);
			if(session()->get('retur')=='retur'){
				$masterobat->stok = (int)$masterobat->stok - (int)$request['resep_jumlah'];
				$masterobat->save();
			}
			
			$total = 0;
			$det = Penjualandetail::where('penjualan_id', $get_pem->id)->get();
			foreach ($det as $key => $d) {
				$total += $d->hargajual;
			}
			$total;
			$reg = Registrasi::find(Penjualan::find($get_pem->id)->registrasi_id);
			$get_folio = Folio::where('registrasi_id',$request['idreg'])->where('namatarif',$no_resep)->where('jenis',$jenis)->first();
			if($get_folio==null){
				$get_folio = new Folio();
				$get_folio->registrasi_id = $request['idreg'];
				$get_folio->namatarif     = $no_resep;
				if(strtolower(Auth::user()->role()->first()->name)=='dokter')
				{
					$get_folio->total         = 0;
				}else{
					$get_folio->total         = $total;
				}
				$get_folio->tarif_id      = 10000;
				if($reg->supervisor_edit==1){
					$get_folio->lunas         = 'Y';
					$get_folio->dibayar       = 0;
				}else{
					$get_folio->lunas         = 'N';
				}
				$get_folio->jenis         = $jenis;
				$get_folio->cara_bayar_id = $reg->bayar;
				$get_folio->poli_tipe     = 'A';
				$get_folio->pasien_id     = $reg->pasien_id;
				$get_folio->dokter_id     = $reg->dokter_id;
				$get_folio->poli_id       = $reg->poli_id;
				$get_folio->user_id       = Auth::user()->id;
			}else{
				if(strtolower(Auth::user()->role()->first()->name)=='dokter')
				{
					$get_folio->total         = 0;
				}else{
					$get_folio->total         = $total;
				}
				$get_folio->cara_bayar_id = $reg->bayar;
				$get_folio->pasien_id     = $reg->pasien_id;
				$get_folio->dokter_id     = $reg->dokter_id;
				$get_folio->poli_id       = $reg->poli_id;
				$get_folio->user_id       = Auth::user()->id;
			}
			$get_folio->save();
			
			return response()->json(['sukses'=>true,'message'=>'Data berhasil ditambah']); exit;
		}
	}	
		
	public function returResep($pasien_id,$registrasi_id){
		if(strtolower(Auth::user()->role()->first()->name)=='supervisor-apotik'){
			session(['retur' 	=> 'retur']);
			return redirect('penjualan/formpenjualan/'.$pasien_id.'/'.$registrasi_id);
		}else{
			return redirect(url()->previous());
		}
	}
	
	public function cetakUangKembali($id){
		if(strtolower(Auth::user()->role()->first()->name)=='supervisor-apotik'){
			session(['retur' 	=> '']);
			$data['reg'] 				= Registrasi::find($id);
			$data['reg']->posisi_pasien = 'pengembalian uang retur';
			$data['reg']->update();
			$data['penjualan'] 	= Penjualan::where('registrasi_id',$id)->first();
			$data['detail'] 		= Penjualandetail::where('retur',1)->where('retur_bayar',null)->where('penjualan_id',$data['penjualan']->id)->get();
			$data['uang_kembali'] = 0;
			if($data['detail']!=null){
				foreach($data['detail'] as $key => $dt){
					$data['uang_kembali'] = $data['uang_kembali'] + ($dt->retur_jumlah * $dt->hargasatuan);
				}
			}
			return view('farmasi.laporan.cetak-uang-kembali', $data);
		}else{
			return redirect(url()->previous());
		}
	}
	
	public function ubahEtiket($jenis,$id,$etiket){
		if($jenis=='resep'){
			$item = Penjualandetail::where('id', $id)->first();
		}else{
			$item = Permintaanobatdetail::where('id', $id)->first();
		}
		if($item!=null){
			$item->konversi_aturan_pakai = $etiket;
			if($item->update()){
				//echo $etiket; exit;
				return response()->json(['sukses' => true]);
			}else{
				return response()->json(['sukses' => false]);
			}
		}else{
			return response()->json(['sukses' => false]);
		}
	}
	
	public function hapusResep($id,$jumlah=null,$alasan=null){
    $item 					= Penjualandetail::where('id', $id)->first();
		if($item!=null){
			$jml_stok 			= $item->jumlah;
			$masterobat_id 	= $item->masterobat_id;
			$no_resep 			= $item->no_resep;
			$id_pem					= $item->penjualan_id;
			$harga_dasar		= $item->hargasatuan;
			$reg 						= Registrasi::find(Penjualan::find($id_pem)->registrasi_id);
			
			$item->hargajual = 0;
			$item->hapus = 1;
			$item->alasan_hapus = $alasan;
			if(session()->get('retur')=='retur'){
				if($jml_stok>$jumlah){
					$item->jumlah = $item->jumlah-$jumlah;
					$item->hargajual = ($item->jumlah*$harga_dasar);
					$item->hapus = null;
				}
				$jml_stok = $jumlah;
				$item->retur = 1;
				$item->retur_jumlah = $jumlah;
				$item->retur_bayar = null;
			}
			if($item->update()){
				if(session()->get('retur')=='retur'){
					$update_masterobat = Masterobat::where('id',$masterobat_id)->first();
					$update_masterobat->stok = (int)$update_masterobat->stok + (int)$jml_stok;
					if($update_masterobat->update()){
						$update_pembayaran = Pembayaran::where('registrasi_id',$reg->id)->first();
						if($update_pembayaran!=null){
							$update_pembayaran->total = $update_pembayaran->total - ((int)$jml_stok*$harga_dasar);
							if(((int)$jml_stok*$harga_dasar)<$update_pembayaran->dibayar){
								$update_pembayaran->dibayar = $update_pembayaran->dibayar - ((int)$jml_stok*$harga_dasar);
							}
							$update_pembayaran->update();
						}
					}
				}
				$total = Penjualandetail::where('penjualan_id', $id_pem)->sum('hargajual');
				if (substr($reg->status_reg,0,1) == 'J') {
					$jenis = 'ORJ';
				} elseif (substr($reg->status_reg,0,1) == 'I') {
					$jenis = 'ORI';
				} elseif (substr($reg->status_reg,0,1) == 'G') {
					$jenis = 'ORD';
				} elseif (substr($reg->status_reg,0,1) == 'A') {
					$jenis = 'ORA';
				}
				$get_folio = Folio::where('registrasi_id',$reg->id)->where('namatarif',$no_resep)->where('jenis',$jenis)->first();
				$get_folio->total         = $total;
				if(session()->get('retur')=='retur'){
					$get_folio->dibayar     = $total;
				}
				$get_folio->cara_bayar_id = $reg->bayar;
				$get_folio->pasien_id     = $reg->pasien_id;
				$get_folio->dokter_id     = $reg->dokter_id;
				$get_folio->poli_id       = $reg->poli_id;
				$get_folio->user_id       = Auth::user()->id;
				$get_folio->save();
				
				return response()->json(['sukses' => true]);
			}else{
				return response()->json(['sukses' => false]);
			}
		}else{
			return response()->json(['sukses' => false]);
		}
  }
}
