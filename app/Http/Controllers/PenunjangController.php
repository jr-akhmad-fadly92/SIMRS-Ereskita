<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
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
use App\HistorikunjunganFIS;
use App\HistorikunjunganBER;
use App\Foliopelaksana;
use App\Orderfisioterapi;
use App\Orderkamarbersalin;
use App\Penjualan;
use Excel;
use Auth;
use PDF;
use Flashy;
use DB;

class PenunjangController extends Controller
{
	public function tindakan_pasien()
	{
		session()->forget('jenis');
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		$data['registrasi'] = null;
		if(strtolower(Auth::user()->role()->first()->name)=='fisioterapi'){
			//$data['registrasi'] = null; //Registrasi::where('poli_id',16)->where('status_reg', 'like', 'J%')->whereIn('posisi_pasien',['menunggu antrian','sedang diperiksa'])->where('pulang',null)->get();
			$data['registrasi'] = Registrasi::where('poli_id',16)->where('status_reg', 'like', 'J%')->whereIn('posisi_pasien',['menunggu antrian','sedang diperiksa'])->where('pulang',null)->get();
			
			$data['registrasi2']	= Registrasi::join('order_fisioterapi', 'registrasis.id', '=', 'order_fisioterapi.registrasi_id')
														->select('registrasis.*','order_fisioterapi.status_proses')
														->where('registrasis.pulang',null)
														->orderBy('order_fisioterapi.status_proses','ASC')
														->groupBy('registrasis.id')
														->get();
		}elseif(strtolower(Auth::user()->role()->first()->name)=='kamarbersalin'){
			$data['registrasi'] = Registrasi::whereIn('poli_id',[1,23])->where('status_reg', 'like', 'I%')->whereIn('posisi_pasien',['menunggu antrian','menunggu persalinan','sedang diperiksa'])->where('pulang',null)->get();
			$data['registrasi2']	= Registrasi::join('order_kamarbersalin', 'registrasis.id', '=', 'order_kamarbersalin.registrasi_id')
														->select('registrasis.*','order_kamarbersalin.status_proses')
														->where('registrasis.pulang',null)
														->orderBy('order_kamarbersalin.status_proses','ASC')
														->groupBy('registrasis.id')
														->get();			
		}
													
		return view('penunjang.tindakanPasien', $data)->with('no', 1);
	}
	
	//Insert ke Histori Kunjungan
	public function insertKunjungan($registrasi_id, $pasien_id)
	{
		$reg = Registrasi::find($registrasi_id);
		if(strtolower(Auth::user()->role()->first()->name)=='fisioterapi'){
			$kl = new HistorikunjunganFIS();
		}elseif(strtolower(Auth::user()->role()->first()->name)=='kamarbersalin'){
			$kl = new HistorikunjunganBER();
		}
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
		return redirect('penunjang/entry-tindakan/'. $registrasi_id.'/'.$pasien_id);
	}
	
	public function entryTindakan($idreg, $idpasien)
	{
		$data['depo']			= strtolower(Auth::user()->role()->first()->name);
		$poli_tipe = '';
		$data['penunjang'] = '';
		if(strtolower(Auth::user()->role()->first()->name)=='fisioterapi'){
			$data['penunjang'] = 'fis';
			$poli_tipe = 'F';
		}elseif(strtolower(Auth::user()->role()->first()->name)=='kamarbersalin'){
			$data['penunjang'] = 'vk';
			$poli_tipe = 'V';
		}
		$data['folio']		= Folio::leftJoin('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
													->where('folios.registrasi_id', $idreg)
													->where('folios.poli_tipe', $poli_tipe)
													->whereNotIn('folios.jenis', ['PEM'])
													->select('folios.*', 'foliopelaksanas.fisioterapi', 'foliopelaksanas.bidan1')
													->get();
		$data['pasien'] 	= Pasien::find($idpasien);
		$data['reg_id'] 	= $idreg;
		$data['jenis'] 		= Registrasi::where('id', '=', $idreg)->first();
		$data['poli'] 		= Folio::where('registrasi_id', '=', $idreg)->distinct();
		$data['tagihan'] 	= Folio::leftJoin('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
														->where('folios.registrasi_id', $idreg)
														->where('folios.poli_tipe', $poli_tipe)
														->whereNotIn('folios.jenis', ['PEM'])
														->where('lunas', 'N')->sum('total');
		$data['dokter'] 	= Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['perawat']	= Pegawai::whereNotIn('kategori_pegawai', [1])->pluck('nama', 'id');
		$data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();
		$kategori_tarif		= Kategoritarif::where('namatarif', Auth::user()->role()->first()->display_name)->first();
		$data['id_kategori_tarif']= 0;
		if($kategori_tarif!=null){
			$data['id_kategori_tarif'] = $kategori_tarif->id;
		}

		$jenis = $data['jenis']->status_reg;
		if (substr($jenis, 0, 1) == 'G') {
			$data['tindakan'] = Tarif::where('kategoritarif_id', $data['id_kategori_tarif'])->get();
		} elseif (substr($jenis, 0, 1) == 'J') {
			$data['tindakan'] = Tarif::where('kategoritarif_id', $data['id_kategori_tarif'])->get();
		} elseif (substr($jenis, 0, 1) == 'I') {
			$data['tindakan'] 		= Tarif::where('kategoritarif_id', $data['id_kategori_tarif'])->get();
		}
	
		// PEMAKAIAN OBAT
		$data['penjualan'] 	= Penjualan::where('registrasi_id' ,$idreg)->first();
		$data['opt_poli'] = Poli::where('politype', $poli_tipe)->get();
		return view  ('penunjang.entryTindakan', $data)->with('no', 1)->with('idreg', $idreg);
	}
	
	public function updatePelaksana(Request $request)
	{
		$poli_tipe = '';
		if(strtolower(Auth::user()->role()->first()->name)=='fisioterapi'){
			$poli_tipe = 'F';
		}elseif(strtolower(Auth::user()->role()->first()->name)=='kamarbersalin'){
			$poli_tipe = 'V';
		}
		$folio = Folio::where('registrasi_id',$request['registrasi_id'])->where('poli_tipe',$poli_tipe)->get();
		if($folio!=null){
			foreach($folio as $key => $data){
				$update = Foliopelaksana::where('folio_id',$data->id)->first();
				if(strtolower(Auth::user()->role()->first()->name)=='fisioterapi'){
					$update->fisioterapi = $request['pelaksana'];
				}elseif(strtolower(Auth::user()->role()->first()->name)=='kamarbersalin'){
					$update->bidan1 = $request['pelaksana'];
				}
				$update->update();
			}
		}
	}
	
	public function selesai($reg_id)
	{
		$poli_tipe = '';
		if(strtolower(Auth::user()->role()->first()->name)=='fisioterapi'){
			$order = Orderfisioterapi::where('registrasi_id',$reg_id)->where('status_proses',null)->first();
			$poli_tipe = 'F';
			$cek_folio = Folio::where('registrasi_id',$reg_id)->where('poli_tipe','F')->get();
			if($cek_folio!=null){
				foreach($cek_folio as $key => $dt){
					$cek_pelaksana = Foliopelaksana::where('folio_id',$dt->id)->where('fisioterapi',null)->first();
					if($cek_pelaksana!=null){
						Flashy::error('Silahkan lengkapi pelaksana yang masih kosong');
						return back();
					}
				}
			}
		}elseif(strtolower(Auth::user()->role()->first()->name)=='kamarbersalin'){
			$order = Orderkamarbersalin::where('registrasi_id',$reg_id)->where('status_proses',null)->first();
			$poli_tipe = 'V';
		}
		if($order!=null){
			$order->status_proses = 1;
			$order->update();
		}
		$folio = Folio::where('registrasi_id',$reg_id)->where('status_proses',null)->where('poli_tipe',$poli_tipe)->update(['status_proses'=>1]);
		
		$reg = Registrasi::find($reg_id);
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
		return redirect('/penunjang/tindakan-pasien');
	}
	
	public function saveTindakan(Request $request)
	{
		$poli_tipe = '';
		$penunjang = '';
		if(strtolower(Auth::user()->role()->first()->name)=='fisioterapi' OR $request['penunjang']=='Fisioterapi'){
			$poli_tipe = 'F';
			$penunjang = 'fis';
		}elseif(strtolower(Auth::user()->role()->first()->name)=='fisioterapi' OR $request['penunjang']=='Persalinan'){
			$poli_tipe = 'V';
			$penunjang = 'vk';
		}
		request()->validate(['tarif_id' => 'required']);
		session(['dokter'=>$request['dokter_id'], 'pelaksana'=>$request['pelaksana']]);
		$reg = Registrasi::find($request['registrasi_id']);
		$tarif = Tarif::find($request['tarif_id']);
		$fol = new Folio();
		$fol->registrasi_id = $request['registrasi_id'];
		$fol->poli_id       = $request['poli_id'];
		$fol->lunas         = 'N';
		$fol->namatarif     = $tarif->nama;
		$fol->tarif_id      = $request['tarif_id'];
		if(substr($reg->status_reg,0,1) == 'G'){
			$fol->jenis = 'TG';
		}elseif (substr($reg->status_reg,0,1) == 'I') {
			$fol->jenis = 'TI';
		}else{
			$fol->jenis = 'TA';
		}
		$fol->cara_bayar_id = $reg->bayar;
		$fol->poli_tipe     = $poli_tipe;
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
		if(strtolower(Auth::user()->role()->first()->name)=='fisioterapi'){
			$fp->fisioterapi = $request['pelaksana'];
		}elseif(strtolower(Auth::user()->role()->first()->name)=='kamarbersalin'){
			$fp->bidan1 = $request['pelaksana'];
		}
		if(substr($reg->status_reg,0,1) == 'G'){
			$fp->pelaksana_tipe = 'TG';
		}elseif (substr($reg->status_reg,0,1) == 'I') {
			$fp->pelaksana_tipe = 'TI';
		}else{
			$fp->pelaksana_tipe = 'TA';
		}
		$fp->user = Auth::user()->id;
		$fp->save();

		if(substr($reg->status_reg,0,1) == 'G'){
			$reg->status_reg = 'G2';
		}elseif (substr($reg->status_reg,0,1) == 'I') {
			$reg->status_reg = 'I2';
		}elseif (substr($reg->status_reg,0,1) == 'L') {
			$reg->status_reg = 'L1';
		}elseif (substr($reg->status_reg,0,1) == 'J') {
			$reg->status_reg = 'J2';
		}
		$reg->update();        

		// Insert Histori
		$history = new HistoriStatus();
		$history->registrasi_id = $request['registrasi_id'];
		$history->status 				= $fp->pelaksana_tipe;
		$history->poli_id       = $request['poli_id'];
		$history->bed_id        = null;
		$history->user_id       = Auth::user()->id;
		$history->save();
		session()->forget('jenis');
		if(isset($request['ranap_penunjang'])){
			return redirect('tindakan/order/penunjang/'.$penunjang.'/irna/'.$request['registrasi_id']);
		}elseif(isset($request['rajal_penunjang'])){
			return redirect('tindakan/order/penunjang/'.$penunjang.'/irj/'.$request['registrasi_id']);
		}elseif(isset($request['darurat_penunjang'])){
			return redirect('tindakan/order/penunjang/'.$penunjang.'/darurat/'.$request['registrasi_id']);
		}else{
			return redirect('penunjang/entry-tindakan/'.$request['registrasi_id'].'/'.$request['pasien_id']);
		}
	}

	public function hapusTindakan($penunjang, $id, $idreg, $pasien_id)
	{
		if (Auth::user()->hasRole(['supervisor','fisioterapi','kamarbersalin','administrator','rawatinap','rawatjalan','rawatdarurat'])) {
			if(Folio::where('id',$id)->where('lunas', 'N')->delete()){
				Foliopelaksana::where('folio_id',$id)->delete();
			}
		}
		$poli_tipe = '';
		if(strtolower(Auth::user()->role()->first()->name)=='fisioterapi' OR $penunjang=='fis'){
			$poli_tipe = 'F';
		}elseif(strtolower(Auth::user()->role()->first()->name)=='kamarbersalin' OR $penunjang=='vk'){
			$poli_tipe = 'V';
		}
		$reg = Registrasi::find($idreg);
		return redirect('penunjang/entry-tindakan/'.$idreg.'/'.$pasien_id);
	}

	public function lap_kunjungan()
	{
		$data['kunjungan'] = NULL;
		return view('penunjang.lap_kunjungan', $data);
	}

	public function lap_kunjungan_by_request(Request $request)
	{
		request()->validate(['tga'=>'required', 'tgb'=>'required']);
		$header = '';
		if(strtolower(Auth::user()->role()->first()->name)=='fisioterapi'){
			$header = 'Fisioterapi';
			$data['kunjungan'] = HistorikunjunganFIS::where('pasien_asal', $request['pasien_asal'])->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
		}elseif(strtolower(Auth::user()->role()->first()->name)=='kamarbersalin'){
			$header = 'Persalinan';
			$data['kunjungan'] = HistorikunjunganBER::where('pasien_asal', $request['pasien_asal'])->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
		}
		$data['pasien_asal'] = $request['pasien_asal'];
		if ($request['view']) {
			return view('penunjang.lap_kunjungan', $data)->with('no', 1);
		} elseif ($request['excel']) {
			$datareg = $data['kunjungan'];
				if ($request['pasien_asal'] == 'TI') {
					$judul = 'IRNA';
				} elseif ($request['pasien_asal'] == 'TA') {
					$judul = 'IRJ';
				} elseif ($request['pasien_asal'] == 'TG') {
					$judul = 'IGD';
				}
				Excel::create('Lap Kunjungan '.$header.' '.$judul, function ($excel) use ($datareg, $judul) {
				// Set the properties
				$excel->setTitle('Lap Kunjungan '.$header.' '.$judul)
					->setCreator('Escredia')
					->setCompany('Escredia')
					->setDescription('Lap Kunjungan '.$header.' '.$judul);
				$excel->sheet('Lap Kunjungan '.$header.' '.$judul, function ($sheet) use ($datareg) {
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
}
