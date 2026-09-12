<?php

namespace Modules\Tarif\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Config\Entities\Tahuntarif;
use Modules\Tarif\Http\Requests\SavetarifRequest;
use Modules\Tarif\Http\Requests\UpdatetarifRequest;
use Modules\Tarif\Entities\Tarif;
use Modules\Kategoritarif\Entities\Tbpelaksanatarif;
use Modules\Kelas\Entities\Kelas;
use Modules\Kategoriheader\Entities\Kategoriheader;
use MercurySeries\Flashy\Flashy;
use App\Split;
use App\Mastersplit;
use DB;
use App\User;
use App\Role;
use Auth;

class TarifController extends Controller
{
	public function index(){
			if(strtolower(Auth::user()->role()->first()->name)=='administrator'){
				$data['thn_tarif'] 	= Tahuntarif::pluck('tahun', 'id');
				$data['tarif'] 			= Tarif::all();
				$data['kelas'] 			= Kelas::pluck('nama', 'id');
				$data['kh'] 				= Kategoritarif::pluck('namatarif', 'id');
				
			}else{
				$thn_tarif 	= Tahuntarif::find(1);
				$kategori = 1;
				$role = strtolower(Auth::user()->role()->first()->name);
				if($role=='laboratorium'){
					$kategori = 2;
				}elseif($role=='radiologi'){
					$kategori = 3;
				}elseif($role=='operasi'){
					$kategori = 4;
				}elseif($role=='kamarbersalin'){
					$kategori = 5;
				}elseif($role=='kamarbersalin'){
					$kategori = 6;
				}
				$data['tarif'] 	= Tarif::where('tahuntarif_id', $thn_tarif->id)
													->where('kategoritarif_id', $kategori)->get();
			}
			return view('tarif::index', $data)->with('no', 1);
	}

	public function filterByRequest(Request $request) //Rawat Inap
	{
			$data['thn_tarif'] = Tahuntarif::pluck('tahun', 'id');
			$data['kh'] = Kategoritarif::pluck('namatarif', 'id');
			$data['kelas'] 	= Kelas::pluck('nama', 'id');
			$data['tarif'] 	= Tarif::where('tahuntarif_id', $request['tahuntarif'])
												->where('kategoritarif_id', $request['kategoritarif_id'])->get();
			return view('tarif::index', $data)->with('no', 1);
	}

	public function create()
	{
		if(strtolower(Auth::user()->role()->first()->name)=='administrator'){
			$data['kategoriheader'] = Kategoriheader::pluck('nama', 'id');
			$data['kategoritarif'] = Kategoritarif::pluck('namatarif', 'id');
			$data['tahuntarif'] = Tahuntarif::pluck('tahun','id');
			$data['kelas'] = Kelas::pluck('nama','id');
			$data['pelaksana']	= Tbpelaksanatarif::pluck('pelaksana', 'id');
			//$data['split'] = Mastersplit::all();
			return view('tarif::create', $data);
		}else{
			return redirect('/home');
		}
	}

	public function cek_split($idheader='')
	{
		$split = Mastersplit::where('kategoriheader_id', '=', $idheader)->pluck('nama', 'id');
		return json_encode($split);
	}

	public function store(SavetarifRequest $request)
	{
		if(strtolower(Auth::user()->role()->first()->name)=='administrator'){
			DB::transaction(function() use ($request)
			{ if($request['kategoritarif_id']=='17'){
				$tarif = new Tarif();
				$tarif->nama = $request['nama'];
				$tarif->jenis_rj = 0;
				$tarif->jenis_rd = 0;
				$tarif->jenis_ri = 0;
				$tarif->tarif_kelas_vip = $request['tarif_kelas_vip'];
				$tarif->tarif_kelas_1 = $request['tarif_kelas_1'];
				$tarif->tarif_kelas_2 = $request['tarif_kelas_2'];
				$tarif->tarif_kelas_3 = $request['tarif_kelas_3'];
				
				$tarif->tarif_tindakanpr = $request['tarif_tindakanpr'];
				$tarif->tarif_tindakandr = $request['tarif_tindakandr'];
				$tarif->managemen = $request['managemen'];
				$tarif->tarif_kelas_rj = $request['managemen'] + $request['tarif_tindakandr'] + $request['tarif_tindakanpr'];
				$tarif->kategoriheader_id = $request['kategoriheader_id'];
				$tarif->kategoritarif_id = $request['kategoritarif_id'];
				$tarif->keterangan = $request['keterangan'];
				$tarif->tahuntarif_id = $request['tahuntarif_id'];
				$tarif->save();
			}else{
				$tarif = new Tarif();
				$tarif->nama = $request['nama'];
				$tarif->jenis_rj = 1;
				$tarif->jenis_rd = 1;
				$tarif->jenis_ri = 1;
				$tarif->tarif_kelas_vip = $request['tarif_kelas_vip'];
				$tarif->tarif_kelas_1 = $request['tarif_kelas_1'];
				$tarif->tarif_kelas_2 = $request['tarif_kelas_2'];
				$tarif->tarif_kelas_3 = $request['tarif_kelas_3'];
				
				$tarif->tarif_tindakanpr = $request['tarif_tindakanpr'];
				$tarif->tarif_tindakandr = $request['tarif_tindakandr'];
				$tarif->managemen = $request['managemen'];
				$tarif->tarif_kelas_rj = $request['managemen'] + $request['tarif_tindakandr'] + $request['tarif_tindakanpr'];
				$tarif->kategoriheader_id = $request['kategoriheader_id'];
				$tarif->kategoritarif_id = $request['kategoritarif_id'];
				$tarif->keterangan = $request['keterangan'];
				$tarif->tahuntarif_id = $request['tahuntarif_id'];
				$tarif->save();
			}
				$jml_split = $request['jmlsplit'];
				for($i=1; $i <= $jml_split; $i++){
					if(!empty($request['namasplit'.$i])) {
						$split = new Split();
						$split->tahuntarif_id = $request['tahuntarif_id'];
						$split->kategoriheader_id = $request['kategoriheader_id'];
						$split->tarif_id = $tarif->id;
						$split->nama = $request['namasplit'.$i];
						$split->nominal = !empty($request['split'.$i]) ? $request['split'.$i] : 0;
						$split->save();
					}
				}
			});

			Flashy::success('Tarif baru berhasil di tambahkan');
			return redirect()->route('tarif');
		}else{
			return redirect('/home');
		}
	}

	public function show()
	{
			return view('tarif::show');
	}

	public function edit($id)
	{
		if(strtolower(Auth::user()->role()->first()->name)=='administrator'){
			$data['kategoriheader'] = Kategoriheader::pluck('nama', 'id');
			$data['kategoritarif'] = Kategoritarif::pluck('namatarif', 'id');
			$data['tahuntarif'] = Tahuntarif::pluck('tahun','id');
			$data['tarif'] = Tarif::find($id);
			$data['split'] = Split::where('tarif_id', '=', $id)->get();
			$data['kelas'] = Kelas::pluck('nama','id');
			$data['jenis'] = request()->segment(4);
			return view('tarif::edit', $data);
		}else{
			return redirect('/home');
		}
	}

	public function delete($id)
	{
		if(strtolower(Auth::user()->role()->first()->name)=='administrator'){
			$tarif = Tarif::find($id);
			$tarif->delete();
			Flashy::info('Tarif berhasil di update');
			return back();
		}else{
			return redirect('/home');
		}
	}

	public function update(UpdatetarifRequest $request)
	{
		$id = $_POST['tarif_id'];
		if(strtolower(Auth::user()->role()->first()->name)=='administrator'){
			$tarif = Tarif::find($id);
			$tarif->nama = $request['nama'];
			$tarif->jenis_rj = 1;
			$tarif->jenis_rd = 1;
			$tarif->jenis_ri = 1;
			$tarif->tarif_kelas_vip = $request['tarif_kelas_vip'];
			$tarif->tarif_kelas_1 = $request['tarif_kelas_1'];
			$tarif->tarif_kelas_2 = $request['tarif_kelas_2'];
			$tarif->tarif_kelas_3 = $request['tarif_kelas_3'];
			$tarif->tarif_tindakanpr = $request['tarif_tindakanpr'];
			$tarif->tarif_tindakandr = $request['tarif_tindakandr'];
			$tarif->managemen = $request['managemen'];
			$tarif->tarif_kelas_rj = $request['managemen'] + $request['tarif_tindakandr'] + $request['tarif_tindakanpr'];
			$tarif->kategoritarif_id = $request['kategoritarif_id'];
			$tarif->keterangan = $request['keterangan'];
			$tarif->tahuntarif_id = $request['tahuntarif_id'];
			$tarif->update();

			$jml_split = $request['jmlsplit'];
			for($i=1; $i <= ($jml_split); $i++){
					$split = Split::find($request['idsplit'.$i]);
					$split->tahuntarif_id = $request['tahuntarif_id'];
					$split->kategoriheader_id = $request['kategoriheader_id'];
					$split->tarif_id = $tarif->id;
					$split->nominal = !empty($request['master-split'.$i]) ? $request['master-split'.$i] : 0;
					$split->update();
			}

			Flashy::info('Tarif berhasil di update');
			return back();
		}else{
			return redirect('/home');
		}
	}

	public function byKategoriHeader(Request $request)
	{
		return redirect('tarif/rawatjalan/'.$request['tahuntarif'].'/'.$request['kategoriheader_id']);
	}

	public function tarif_rawatjalan($thntarif_id='2', $kategoritarif_id='1')
	{
		$data['thn_tarif'] = Tahuntarif::pluck('tahun', 'id');
		$data['kh'] = Kategoritarif::pluck('namatarif', 'id');

		if (!empty($thntarif_id) && !empty($kategoritarif_id)) {
			// $kat_tarif = Kategoritarif::where('kategoriheader_id', $kategoriheader_id)->first();
			$data['tarif'] = Tarif::where('jenis','=','TA')->where('tahuntarif_id', $thntarif_id)->where('kategoritarif_id', $kategoritarif_id)->get();
			$data['tahuntarif_id'] = $thntarif_id;
			$data['kategoritarif_id'] = $kategoritarif_id;
		}
		return view('tarif::rawat_jalan', $data)->with('no', 1);
	}

	public function igdByKategoriHeader(Request $request)
	{
		return redirect('tarif/rawatdarurat/'.$request['tahuntarif'].'/'.$request['kategoriheader_id']);
	}

	public function tarif_darurat($thntarif_id='', $kategoritarif_id='')
	{
			$data['thn_tarif'] = Tahuntarif::pluck('tahun', 'id');
			$data['kh'] = Kategoritarif::pluck('namatarif', 'id');
			if (empty($thntarif_id) && empty($kategoriheader_id)) {
				$data['tarif'] = Tarif::where('jenis','=','TG')->get();
			} else {
				$data['tarif'] = Tarif::where('jenis','=','TG')->where('tahuntarif_id', $thntarif_id)->where('kategoritarif_id', $kategoritarif_id)->get();
			}
			//return $data; die;
			return view('tarif::rawat_darurat', $data)->with('no', 1);
	}

	public function hapusTarif($jenis, $thntarif_id, $kategoriheader_id)
	{
		//Cek tarif
		//Hapus split
		//Hapus tarif
	}

	public function destroy()
	{
	}
}
