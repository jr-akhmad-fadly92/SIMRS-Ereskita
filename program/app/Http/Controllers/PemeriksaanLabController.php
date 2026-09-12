<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Folio;
use App\Orderlab;
use App\Hasillab;
use App\Labsection;
use App\Labkategori;
use App\Laboratorium;
use Modules\Pegawai\Entities\Pegawai;
use Auth;
use App\RincianHasillab;
use PDF;
use MercurySeries\Flashy\Flashy;

class PemeriksaanLabController extends Controller
{
	public function index()
	{
		$today 	= Registrasi::join('order_lab', 'registrasis.id', '=', 'order_lab.registrasi_id')
							->where('registrasis.created_at', 'LIKE', date('Y-m-d'.'%'))
							->where('registrasis.pasien_id', '<>', '0')
							->where('registrasis.penjualan_bebas_apotek',null)
							->select('registrasis.*')
							->get();
		session()->forget('pj');
		session()->forget('lab_id');
		return view('lab.index', compact('today'))->with('no', 1);
	}

	public function index_byTanggal(Request $request)
	{
			request()->validate(['tga'=>'required']);
			$today 	= Registrasi::join('order_lab', 'registrasis.id', '=', 'order_lab.registrasi_id')
								->whereBetween('registrasis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
								->where('registrasis.pasien_id', '<>', '0')
								->where('registrasis.penjualan_bebas_apotek',null)
								->select('registrasis.*')
								->get();
			session()->forget('pj');
			session()->forget('lab_id');
			return view('lab.index', compact('today'))->with('no', 1);
	}

	public function create($id='', $labid='')
	{
		$data['reg'] 			= Registrasi::find($id);
		$data['umur']			= date('Y')-date('Y',strtotime($data['reg']->pasien->tgllahir));
		if($data['umur'] >= 17 )
		{
			if($data['reg']->kelamin=='L')
			{
				$data['status_umur']='laki_dewasa';
			}else{
				$data['status_umur']='wanita_dewasa';
			}
		}else{
			$data['status_umur']='anak';
		}
		
		$orderlab 				= Orderlab::where('registrasi_id',$id)->where('status_proses',1)->first();
		if($orderlab==null){
			Flashy::error('Pemeriksaan belum selesai');
			return redirect('laboratorium/tindakan-pasien');
		}
		$data['tagihan'] 	= Folio::where('registrasi_id', $id)->where('poli_tipe','L')->where('lunas', 'N')->sum('total');
		$data['tagihan'] 	= $data['tagihan'] + Folio::where('registrasi_id', $id)->where('jenis','PEM')->where('lunas', 'N')->sum('total');
		if(strtolower(Auth::user()->role()->first()->name)=='laboratorium'){
			$data['petugas'] 	= Pegawai::where('kategori_pegawai', 4)->pluck('nama', 'id');
		}else{
			$data['petugas'] 	= Pegawai::whereIn('kategori_pegawai', [1,2])->pluck('nama', 'id');
		}
		$data['rincian'] 	= null;
		$data['lab'] 			= Hasillab::where('registrasi_id', $id)->first();
		if($data['lab']!=null){
			$folio = Folio::where('registrasi_id',$id)->where('poli_tipe','L')->get();
			if($folio!=null){
				foreach($folio as $key => $dx){
					$rinc_hasillab = RincianHasillab::where('hasillab_id',$data['lab']->id)->where('tarif_id',$dx->tarif_id)->first();
					if($rinc_hasillab==null){
						$rinc_hasillab = new RincianHasillab;
					}
					$rinc_hasillab->hasillab_id = $data['lab']->id;
					$rinc_hasillab->tarif_id = $dx->tarif_id;
					$rinc_hasillab->user_id = Auth::user()->id;
					$rinc_hasillab->save();
				}
			}
			
			$data['rincian']= RincianHasillab::where('hasillab_id', $data['lab']->id)->get();
		}
		$data['no'] = 1;
		return view('lab.create', $data);
	}

	public function store(Request $request)
	{
		request()->validate(['penanggungjawab'=>'required', 'jenissample'=>'required']);
		$jenis = Registrasi::where('id', '=', $request['reg_id'])->first();
		if(substr($jenis->status_reg, 0, 1) == 'J') {
			$no = 'LABRJ';
		} elseif (substr($jenis->status_reg, 0, 1) == 'I') {
			$no = 'LABRI';
		} else {
			$no = 'LABRG';
		}
		$lab = Hasillab::where('registrasi_id',$request['reg_id'])->first();
		if($lab==null){
			$lab = new Hasillab();
		}
		$lab->no_lab = $no.'-'.date('Ymd').'-'.$request['reg_id'];
		$lab->registrasi_id = $request['reg_id'];
		$lab->pasien_id = $request['pasien_id'];
		$lab->dokter_id = $request['dokter_id'];
		$lab->penanggungjawab = $request['penanggungjawab'];
		$lab->tgl_pemeriksaan = valid_date($request['tgl_pemeriksaan']);
		$lab->tgl_bahanditerima = date('Y-m-d');
		$lab->jam = $request['jam'];
		$lab->sample = $request['jenissample'];
		$lab->tgl_hasilselesai = date('Y-m-d');
		$lab->tgl_cetak = date('Y-m-d');
		$lab->user_id = Auth::user()->id;
		$lab->save();
		
		$folio = Folio::where('registrasi_id', $request['reg_id'])->where('poli_tipe','L')->get();
		if($folio!=null){	
			foreach($folio as $key => $data){	
				$rinc_hasillab = RincianHasillab::where('hasillab_id',$lab->id)->where('tarif_id',$data->tarif_id)->first();
				if($rinc_hasillab==null){
					$rinc_hasillab = new RincianHasillab;
				}
				$rinc_hasillab->hasillab_id = $lab->id;
				$rinc_hasillab->tarif_id = $data->tarif_id;
				$rinc_hasillab->user_id = Auth::user()->id;
				$rinc_hasillab->save();
			}
		}
		
		$pj_name = Pegawai::find($lab->penanggungjawab);
		session( ['pj'=> $lab->penanggungjawab, 'pj_name'=> $pj_name->nama, 'lab_id'=>$lab->id]);
		return redirect('pemeriksaanlab/create/'.$request['reg_id'].'/'.$lab->id);
	}

	public function saveHasil(Request $request)
	{	
		$rincian = RincianHasillab::find($request['id']);
		//$hasillab = db::table('hasilabs')->join('pasiens','pasiens.id','=','')->where('id',)
		if($request['jenis']=='hasil'){
			$rincian->hasil = $request['val'];
			if((double)$request['nilaibawah'] > $request['val']){
				$rincian->lh = "L";
			}elseif((double)$request['nilaiatas'] < $request['val']){
				$rincian->lh = "H";
			}else{
				$rincian->lh = "";
			}
		}elseif($request['jenis']=='lh'){
			$rincian->lh = $request['val'];				
		}elseif($request['jenis']=='cat'){
			$hasillab = Hasillab::find($request['id']);
			if($hasillab!=null){
				$hasillab->catatan = $request['val'];
				$hasillab->save();
			}
		}else{
			$rincian->hasiltext = $request['val'];
		}
		if($rincian!=null){
			$rincian->user_id = Auth::user()->id;
			$rincian->save();
			return ['lh'=>$rincian->lh];
		}
	}
	
	public function updateCetak($id,$ischecked)
	{
		$rincian = RincianHasillab::find($id);
		$rincian->cetak = $ischecked;
		$rincian->update();
	}
	
	public function save_rincian(Request $request)
	{
		//echo count($request['laboratoria_id']); exit;
		$data = request()->validate([
			'hasillab_id' => 'required',
			'labsection_id' => 'nullable',
			'labkategori_id' => 'nullable',
			'laboratoria_id' => 'nullable',
			'hasil' => '',
			'hasiltext' => ''
		]);
		session(['labsection_id'=>$request['labsection_id'],'labkategori_id'=>$request['labkategori_id']]);
		if($request['labsection_id']==''){
			return ['status'=>false, 'message'=>'Kategori harap diisi']; exit;
		}elseif($request['labkategori_id']==''){
			return ['status'=>false, 'message'=>'Pemeriksaan harap diisi']; exit;
		}else{
			for($i=0; $i<count($request['hasil']); $i++){
				if($request['hasil'][$i]==""){
					return ['status'=>false, 'message'=>'Hasil --'.$request['laboratoria_text'][$i].'-- harap diisi hasilnya']; exit;
				}
			}
			for($i=0; $i<count($request['laboratoria_id']); $i++){
				$rincian = new RincianHasillab();
				$rincian->hasillab_id = $request['hasillab_id'];
				$rincian->labsection_id = $request['labsection_id'];
				$rincian->labkategori_id = $request['labkategori_id'];
				$rincian->laboratoria_id = $request['laboratoria_id'][$i];
				$rincian->hasiltext = $request['hasiltext'][$i];
				$rincian->hasil = $request['hasil'][$i];
				$rincian->user_id = Auth::user()->id;
				$rincian->save();
			}
		}
		return ['status'=>true, 'message'=>'Hasil Lab berhasil disimpan']; exit;
		//return redirect('pemeriksaanlab/create/'.$request['reg_id'].'/'.$request['hasillab_id']);
	}

	public function cetak_hasil_lab($registrasi_id, $hasillab_id)
	{
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['lab'] = Hasillab::where('id', '=', $hasillab_id)->first();
		$data['rincian'] = RincianHasillab::where('cetak',1)->where('hasillab_id', '=', $data['lab']->id)->get();
		//$data['section'] = RincianHasillab::where('hasillab_id', '=', $data['lab']->id)->distinct()->get(['labsection_id', 'hasillab_id']);
		//$data['kategori'] = RincianHasillab::where('hasillab_id', '=', $data['lab']->id)->distinct()->get(['labkategori_id']);
		return view('lab.pdf',$data);
	}
	public function cetak_hasil_lab1($registrasi_id)
	{
		$data['reg'] = Registrasi::find($registrasi_id);
		//$data['lab'] = Hasillab::where('registrasi_id', '=', $registrasi_id)->order_by('created_at', 'desc')->first();
		$data['lab'] = Hasillab::where('registrasi_id', '=', $registrasi_id)->orderBy('updated_at', 'desc')->take(1)->first();
		$data['rincian'] = RincianHasillab::where('cetak',1)->where('hasillab_id', '=', $data['lab']->id)->get();
		//$data['section'] = RincianHasillab::where('hasillab_id', '=', $data['lab']->id)->distinct()->get(['labsection_id', 'hasillab_id']);
		//$data['kategori'] = RincianHasillab::where('hasillab_id', '=', $data['lab']->id)->distinct()->get(['labkategori_id']);
		return view('lab.pdf_rawat',$data);
	}

	public function deleteDetail($registrasi_id, $lab_id, $id)
	{
		RincianHasillab::find($id)->delete();
		return redirect('pemeriksaanlab/create/'.$registrasi_id.'/'.$lab_id);
	}
	// ========================================================================
	public function get_kategori($id='')
	{
		$kategori = Labkategori::where('labsection_id', '=', $id)->pluck('nama','id');
		return json_encode($kategori);
	}

	public function get_laboratoria($id='')
	{
		$lab = Laboratorium::where('labkategori_id', $id)->pluck('nama', 'id');
		return json_encode($lab);
	}
}
