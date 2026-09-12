<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Tarif\Entities\Tarif;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Config\Entities\Tahuntarif;
use Yajra\DataTables\DataTables;
use App\Mastermappingbiaya;
use Flashy;
use DB;
use App\User;
use App\Role;
use Auth;

class MappingbiayaController extends Controller{
	public function index(){
		if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $data['kategori_tarif'] = Kategoritarif::get();
			return view('mappingbiaya.index', $data);
        }else{
            return redirect('/dashboard');
        }
		
	}

	public function dataMappingBiaya(){
		$tarif = Mastermappingbiaya::select([
			'id',
			'kategoritarif_id',
			'kelompok',
			'labsection_id',
			'tindakan_radiologi_id',
		])->orderBy('kategoritarif_id')->orderBy('labsection_id')->orderBy('tindakan_radiologi_id');
		return DataTables::of($tarif)
		->addColumn('kelompok', function($tarif){
			$addtext = "";
			if($tarif->labsection_id!=null){
				$addtext = '['.$tarif->labsection->nama.'] ';
			}elseif($tarif->tindakan_radiologi_id!=null){
				$addtext = '['.$tarif->radiologi->tindakan_radiologi.'] ';
			}
			return $addtext.$tarif->kelompok;
		})
		->addColumn('kategoritarif_id', function($tarif){
			return Kategoritarif::find($tarif->kategoritarif_id)->namatarif;
		})
		->addColumn('jumlah', function($tarif){
			$maptar = Tarif::where('kategoritarif_id',$tarif->kategoritarif_id)->where('mapping_biaya_id','!=',null)->get();
			$jumlah=0;
			if($maptar!=null){
				foreach($maptar as $keyx => $dt){
					$pushtarif = json_decode($dt->mapping_biaya_id);
					if(in_array($tarif->id, $pushtarif)){
						$jumlah++;
					}
				}
			}
			return '<b>'.$jumlah.'</b>';
		})
		->addColumn('mapping', function($tarif){
			return '
				<a href="'.url('mapping-biaya/'.$tarif->id).'" class="btn btn-info btn-flat btn-sm"><i class="fa fa-folder-open"></i> Lihat</a>
				<a onclick=\'javascript: return confirm("Anda yakin menghapus group ini ?");\' href="'.url('hapus-mapping-group/'.$tarif->id).'" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-trash"></i> Hapus</a>
			';
		})
		->rawColumns(['mapping','jumlah'])
		->make(true);
	}

	public function mappingBiaya($kategori=1){
		if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
			$master_biaya_id = Mastermappingbiaya::all();
		
			$query = '';
			if($kategori!=''){
				if($kategori!='NULL'){
					$query .= ' where kategoritarif_id = '.$kategori;
				}
			}
			// GROUP BY nama
			$tarif 		= DB::select('select * from tarifs '.$query.'');
			$kiri 		= ceil(count($tarif) / 2);
			$dataKiri = DB::select('select * from tarifs '.$query.' limit 0,'.$kiri);
			$dataKanan = DB::select('select * from tarifs '.$query.' limit '.$kiri.','.$kiri);
			
			return view('mappingbiaya.mappingBiaya', compact('tarif' ,'dataKiri', 'dataKanan', 'master_biaya_id', 'kategori'))->with('no', 1);
		}else{
            return redirect('/dashboard');
        }
		
	}

	public function viewMappingBiaya($id){
		if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $master_biaya_id = Mastermappingbiaya::all();
			$kelompok = Mastermappingbiaya::find($id)->kelompok;
			$cek_mapping = Tarif::where('mapping_biaya_id', '!=', null)->get();
			$idx = [];
			if($cek_mapping!=null){
				foreach($cek_mapping as $key => $data){
					$var = json_decode($data->mapping_biaya_id);
					if(in_array($id, $var)){
						array_push($idx, $data->id);
					}
				}
			}
			//var_dump($idx); exit;
			$tarif = Tarif::whereIn('id', $idx)->get();
			$kiri = ceil($tarif->count() / 2);
			$dataKiri = Tarif::whereIn('id', $idx)->skip(0)->take($kiri)->get();
			$dataKanan = Tarif::whereIn('id', $idx)->skip($kiri)->take($kiri)->get();
			return view('mappingbiaya.viewMappingBiaya', compact('id','tarif' ,'dataKiri', 'dataKanan', 'master_biaya_id', 'kelompok'))->with('no', 1);
        }else{
            return redirect('/dashboard');
        }
		
	}

	public function simpanMapping(Request $request){
		request()->validate(['mapping_biaya_id' => 'required']);
		$total = $request['total'];
		$mapping_biaya_id = $request['mapping_biaya_id'];
		$master_biaya = Mastermappingbiaya::find($mapping_biaya_id)->kelompok;
		$id = [];
		for ($i=1; $i <= $total ; $i++){
			if(!empty($request['tarif'.$i])) {
				$tarif = Tarif::find($request['tarif'.$i]);
				if($tarif->mapping_biaya_id==null){
					$pushtarif = array();				
				}else{
					$pushtarif = json_decode($tarif->mapping_biaya_id);
				}
				if(!in_array($mapping_biaya_id, $pushtarif)){
					array_push($pushtarif, $mapping_biaya_id);
				}
				$tarif->mapping_biaya_id = json_encode($pushtarif);
				$tarif->update();
				array_push($id, $tarif->id);
			}
		}
		$trf = Tarif::whereIn('id', $id)->get();
		session(['group'=>$mapping_biaya_id]);
		Flashy::success($trf->count().' Tarif berhasil di mapping di kelompok biaya '.$master_biaya);
		return redirect(url()->previous());
	}
	
	public function hapusMapping(Request $request){
		$total = $request['total'];
		for ($i=1; $i <= $total ; $i++){
			if(!empty($request['tarif'.$i])) {
				$tarif = Tarif::find($request['tarif'.$i]);
				if($tarif->mapping_biaya_id==null){
					$pushtarif = array();				
				}else{
					$pushtarif = json_decode($tarif->mapping_biaya_id);
				}
				
				if (false !== $key = array_search($request['id'], $pushtarif)) {
					array_splice($pushtarif, $key, 1);
				}
				$tarif->mapping_biaya_id = json_encode($pushtarif);
				$tarif->update();
			}
		}
		return redirect(url()->previous());
	}
	
	public function simpanMappingGroup(Request $request){
		request()->validate(['mapping_group' => 'required']);
		$mg = new Mastermappingbiaya;
		$mg->kategoritarif_id = $request['kategoritarif'];
		$mg->kelompok = $request['mapping_group'];
		$mg->labsection_id = $request['jenislab'];
		$mg->tindakan_radiologi_id = $request['jenisradiologi'];
		$mg->created_at = date('Y-m-d H:i:s');
		session(['jenislab'=>$request['jenislab'], 'jenisradiologi'=>$request['jenisradiologi'], 'kategoritarif'=>$request['kategoritarif']]);
		if($mg->save()){
			Flashy::success('Group berhasil disimpan');
		}else{
			Flashy::error('Group gagal disimpan');
		}
		return redirect(url()->previous());
	}
	
	public function hapusMappingGroup($id){
		$master = Mastermappingbiaya::find($id);
		if($master!=null){
			if($master->delete()){
				$tarif = Tarif::where('mapping_biaya_id','!=',null)->get();
				
				foreach($tarif as $key => $data){					
					$tarif_detail = Tarif::find($data->id);
					$pushtarif = json_decode($tarif_detail->mapping_biaya_id);					
					if (false !== $key = array_search($id, $pushtarif)) {
						array_splice($pushtarif, $key, 1);
						$tarif_detail->mapping_biaya_id = json_encode($pushtarif);
						$tarif_detail->update();
					}
				}
				Flashy::success('Group berhasil dihapus');
			}else{
				Flashy::error('Group gagal dihapus');
			}
		}
		return redirect(url()->previous());
	}

	public function mappingDetail($mastermapping_id=''){
		DB::statement(DB::raw('set @nomorbaris=0'));
		$tarif = Tarif::select([
			DB::raw('@nomorbaris  := @nomorbaris  + 1 AS nomorbaris'),
			'id',
			'nama',
			'total'
		])->where('mastermapping_id', $mastermapping_id);
		return DataTables::of($tarif)
		->addColumn('total', function ($tarif)
		{
				return number_format($tarif->total);
		})
		->make(true);
	}
}
