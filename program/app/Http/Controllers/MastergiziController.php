<?php

namespace App\Http\Controllers;
use App\Gizi;
use App\MasterDietPasien;
use App\Mastergizi;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Validator;
use DataTables;

class MastergiziController extends Controller {

	public function index()
	{	
		$data['gizi'] = Mastergizi::all();
		$data['nasi'] = MasterDietPasien::where('kategori_menu','Nasi')->get();
		$data['laukhewani'] = MasterDietPasien::where('kategori_menu','lauk_hewani')->get();
		$data['lauknabati'] = MasterDietPasien::where('kategori_menu','lauk_nabati')->get();
		$data['sayur'] = MasterDietPasien::where('kategori_menu','sayur')->get();
		$data['buah'] = MasterDietPasien::where('kategori_menu','buah')->get();
		$data['snack'] = MasterDietPasien::where('kategori_menu','snack')->get();
		
		return view('mastergizi.index', $data)->with('no', 1);
	}
	public function getDatadietpasien()
    {	
	
      $MasterDiet = MasterDietPasien::select([
	
        'id',
        'kategori_menu',
        'nama_menu',
        'energi_kkal',
        'protein_gr',
        
      ])->orderBy('id', 'asc');

      return DataTables::of($MasterDiet)
      ->addColumn('edit', function ($row) {
		$btn = '
		<a href="'. url('/masterdietpasien/edit/'.$row->id) .'" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>';
		return $btn;
      })
      
      ->rawColumns(['edit'])
      ->make(true);
	}
	
	public function indexdietpasien()
	{	
		
		return view('/mastergizi/masterdietpasien.indexdietpasien');
	//	return view('mastergizi\masterdietpasien.indexdietpasien', $data)->with('no', 1);
	}

	public function create()
	{
		
			
	}

	public function storegizi(Request $request)
	{
		$namanasi = MasterDietPasien::find($request->nasi)->nama_menu;
		$energinasi = MasterDietPasien::find($request->nasi)->energi_kkal;
		$proteinnasi = MasterDietPasien::find($request->nasi)->protein_gr;
		$namahewani = MasterDietPasien::find($request->lauk_hewani)->nama_menu;
		$energihewani = MasterDietPasien::find($request->lauk_hewani)->energi_kkal;
		$proteinhewani = MasterDietPasien::find($request->lauk_hewani)->protein_gr;
		$namanabati = MasterDietPasien::find($request->lauk_nabati)->nama_menu;
		$energinabati = MasterDietPasien::find($request->lauk_nabati)->energi_kkal;
		$proteinabati = MasterDietPasien::find($request->lauk_nabati)->protein_gr;
		$namasayur = MasterDietPasien::find($request->sayur)->nama_menu;
		$energisayur = MasterDietPasien::find($request->sayur)->energi_kkal;
		$proteisayur = MasterDietPasien::find($request->sayur)->protein_gr;
		$namabuah = MasterDietPasien::find($request->buah)->nama_menu;
		$energibuah = MasterDietPasien::find($request->buah)->energi_kkal;
		$proteibuah = MasterDietPasien::find($request->buah)->protein_gr;
		$namasnack = MasterDietPasien::find($request->snack)->nama_menu;
		$energisnack = MasterDietPasien::find($request->snack)->energi_kkal;
		$proteisnack = MasterDietPasien::find($request->snack)->protein_gr;
			
		Mastergizi::insert([
			'gizi' => ','.$namanasi.','.$namahewani.','.$namanabati.','.$namasayur.','.$namabuah.','.$namasnack,
			'energi_kkal' => $energinasi+$energihewani+$energinabati+$energisayur+$energibuah+$energisnack,
			'protein_gr' => $proteinnasi+$proteinhewani+$proteinabati+$proteisayur+$proteibuah+$proteisnack,
			
			]);
			Flashy::success('Menu Gizi Pasien berhasil ditambahkan');
			return redirect('mastergizi');

	}

	public function storediet(Request $request)
	{	
		
			MasterDietPasien::create([
				'kategori_menu' => $request->kategori_menu,
				'nama_menu' => $request->nama_menu,
				'energi_kkal' => $request->energi_kkal,
				'protein_gr' => $request->protein_gr
				
				]);
			Flashy::success('Master Diet Pasien berhasil ditambahkan');
			return redirect('master-diet-pasien');
	}

	public function editgizi($id)
	{	
		$data['idgizi'] = Mastergizi::where('id',$id)->get();
		$data['gizi'] = Mastergizi::where('id',$id)->select('gizi')->get();
		$data['arraygizi'] = explode("," , $data['gizi']);
		Flashy::success('Menu Gizi Pasien berhasil diupdated');
		return view('/mastergizi.editgizi',$data);
		
		//return $data['arraygizi']['1'];
	}

	public function editdiet($id)
	{
		$data['gizi'] = MasterDietPasien::where('id',$id)->get();
		//return $id;
		return view('/mastergizi/masterdietpasien.edit',$data);
	}

	public function updategizi(Request $request)
	{
		$namanasi = MasterDietPasien::find($request->nasi)->nama_menu;
		$energinasi = MasterDietPasien::find($request->nasi)->energi_kkal;
		$proteinnasi = MasterDietPasien::find($request->nasi)->protein_gr;
		$namahewani = MasterDietPasien::find($request->lauk_hewani)->nama_menu;
		$energihewani = MasterDietPasien::find($request->lauk_hewani)->energi_kkal;
		$proteinhewani = MasterDietPasien::find($request->lauk_hewani)->protein_gr;
		$namanabati = MasterDietPasien::find($request->lauk_nabati)->nama_menu;
		$energinabati = MasterDietPasien::find($request->lauk_nabati)->energi_kkal;
		$proteinabati = MasterDietPasien::find($request->lauk_nabati)->protein_gr;
		$namasayur = MasterDietPasien::find($request->sayur)->nama_menu;
		$energisayur = MasterDietPasien::find($request->sayur)->energi_kkal;
		$proteisayur = MasterDietPasien::find($request->sayur)->protein_gr;
		$namabuah = MasterDietPasien::find($request->buah)->nama_menu;
		$energibuah = MasterDietPasien::find($request->buah)->energi_kkal;
		$proteibuah = MasterDietPasien::find($request->buah)->protein_gr;
		$namasnack = MasterDietPasien::find($request->snack)->nama_menu;
		$energisnack = MasterDietPasien::find($request->snack)->energi_kkal;
		$proteisnack = MasterDietPasien::find($request->snack)->protein_gr;
			
		Mastergizi::where('id',$request->id)->update([
			'gizi' => ','.$namanasi.','.$namahewani.','.$namanabati.','.$namasayur.','.$namabuah.','.$namasnack,
			'energi_kkal' => $energinasi+$energihewani+$energinabati+$energisayur+$energibuah+$energisnack,
			'protein_gr' => $proteinnasi+$proteinhewani+$proteinabati+$proteisayur+$proteibuah+$proteisnack,
			
			]);
			Flashy::success('Master Menu Gizi Pasien berhasil ditambahkan');
			return redirect('mastergizi');
	}

	public function updatediet(Request $request)
	{
			$gizi = MasterDietPasien::find($request->id)->update([
				'kategori_menu' => $request->kategori_menu,
				'nama_menu' => $request->nama_menu,
				'energi_kkal' => $request->energi_kkal,
				'protein_gr' => $request->protein_gr
			]);
			
			Flashy::info('Master Diet Pasien berhasil diubah');
			return redirect('master-diet-pasien');
		
	}

	public function gizi_pasien() {
		$data['gizipasien'] = Gizi::join('registrasis', 'gizis.registrasi_id', '=', 'registrasis.id')
													->where('registrasis.pulang', null)
													->get();
		return view('mastergizi.gizi_pasien', $data)->with('no', 1);
	}

	public function gizi_pasien_byTanggal(Request $request) {
		$data['gizipasien'] = Gizi::join('registrasis', 'gizis.registrasi_id', '=', 'registrasis.id')
													->where('registrasis.pulang', null)
													->whereBetween('gizis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
													->get();
		return view('mastergizi.gizi_pasien', $data)->with('no', 1);
	}
	
	public function histori_gizi_pasien() {
		$data['gizipasien'] = Gizi::join('registrasis', 'gizis.registrasi_id', '=', 'registrasis.id')
													->where('registrasis.pulang', 1)
													->get();
		return view('mastergizi.histori_gizi_pasien', $data)->with('no', 1);
	}

	public function histori_gizi_pasien_byTanggal(Request $request) {
		$data['gizipasien'] = Gizi::join('registrasis', 'gizis.registrasi_id', '=', 'registrasis.id')
													->where('registrasis.pulang', 1)
													->whereBetween('gizis.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
													->get();
		return view('mastergizi.histori_gizi_pasien', $data)->with('no', 1);
	}

	public function show($id)
	{
			//
	}

	public function destroy($id)
	{
			//
	}
}
