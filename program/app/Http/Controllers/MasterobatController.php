<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Masterobat;
use App\Satuanbeli;
use App\Satuanjual;
use App\Kategoriobat;
use App\Depo;
use App\MarginHargaObat;
use App\Depomasterobat;
use Yajra\DataTables\DataTables;
use Flashy;
use Auth;
use DB;

class MasterobatController extends Controller
{
	public function index()
	{	$margin = MarginHargaObat::where('id','1')->first();
		$depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
		$stok_limit = Masterobat::where('stok','<','50')->count();
		$detail_stok_limit = Masterobat::where('stok','<','50')->select('stok','nama')->get();
		$stok_kadaluarsa = Masterobat::where('expired_date','<',date('y-m-d'))->where('masterobats.stok','>','0')->count();
		$detail_stok_kadaluarsa = Masterobat::where('expired_date','<',date('y-m-d'))->where('masterobats.stok','>','0')->get();
		$stok_kadaluarsa_null = Masterobat::whereNull('expired_date')->count();
		$detail_stok_kadaluarsa_null = Masterobat::whereNull('expired_date')->get();
		if(strtolower(Auth::user()->role()->first()->name) == "apotik" OR $depo!=null){
			return view('masterobat.datatable',compact('margin','stok_limit','detail_stok_limit','stok_kadaluarsa','detail_stok_kadaluarsa','stok_kadaluarsa_null','detail_stok_kadaluarsa_null'))->with('no',1);
		}else{
			return redirect('home');
		}
  }

	public function ajax_masterobat()
	{
	return DataTables::of();
	}

	public function create()
	{
	return redirect('masterobat');
			/* $data['satuanbeli'] = Satuanbeli::pluck('nama','id');
			$data['satuanjual'] = Satuanjual::pluck('nama','id');
			$data['kategoriobat'] = Kategoriobat::pluck('nama','id');
			return view('masterobat.create',$data); */
	}

	public function store(Request $request)
	{
	return redirect('masterobat');
	/* $data = request()->validate(['nama'=>'required|unique:masterobats,nama']);

	$obat = new Masterobat();
	$obat->nama = $request['nama'];
	$obat->kode = $request['kode'];
	$obat->kategoriobat_id = $request['kategoriobat_id'];
	$obat->satuanbeli_id = $request['satuanbeli_id'];
	$obat->satuanjual_id = $request['satuanjual_id'];
	$obat->hargajual = $this->rupiah($request['hargajual']);
	$obat->hargajual_jkn = $this->rupiah($request['hargajual_jkn']);
	$obat->hargabeli = $this->rupiah($request['hargabeli']);
	$obat->aktif = 'Y';
	$obat->save();

	Flashy::success('Master Obat Telah Ditambahkan');
	return redirect('masterobat'); */
	}

	public function show($id)
	{
			//
	}

	public function edit($id)
	{
	return redirect('masterobat');
	/* $data['masterobat'] = Masterobat::find($id);
	$data['satuanbeli'] = Satuanbeli::pluck('nama','id');
	$data['satuanjual'] = Satuanjual::pluck('nama','id');
	$data['kategoriobat'] = Kategoriobat::pluck('nama','id');
	return view('masterobat.edit',$data); */
	}

	public function update(Request $request, $id)
	{
	return redirect('masterobat');
	/* $data = request()->validate(['nama'=>'required|unique:masterobats,nama,'.$id]);

	$obat = Masterobat::find($id);
	$obat->nama = $request['nama'];
	$obat->kode = $request['kode'];
	$obat->kategoriobat_id = $request['kategoriobat_id'];
	$obat->satuanbeli_id = $request['satuanbeli_id'];
	$obat->satuanjual_id = $request['satuanjual_id'];
	$obat->hargajual = $this->rupiah($request['hargajual']);
	$obat->hargajual_jkn = $this->rupiah($request['hargajual_jkn']);
	$obat->hargabeli = $this->rupiah($request['hargabeli']);
	$obat->aktif = 'Y';
	$obat->update();

	Flashy::info('Data Master Obat berhasil di update');
	return redirect('masterobat'); */
	}

	public function destroy($id)
	{
			//
	}

	public function rupiah($angka)
	{
		$d = str_replace('.', '', $angka);
		$r = str_replace(',', '', $d);
		return $r;
	}

	public function getData()
	{
	$depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
	if($depo!=null){
		DB::statement(DB::raw('set @rownum=0'));
		$masterobat = Depomasterobat::select([
			DB::raw('@rownum  := @rownum  + 1 AS rownum'),
			'id',
			'kode',
			'nama',
			'satuan',
			'jenis',
			'stok',
			'hargajual as harga_rj',
			'hargajual as harga_ri',
			'hargajual'
		])->where('id_depo', $depo->id);
		return DataTables::of($masterobat)
		->addColumn('harga_dasar', function ($data) {
			return number_format($data->hargajual);
		})
		->addColumn('harga_rj', function ($data) {
			return number_format(mophp("J",$data->hargajual));
		})
		->addColumn('harga_ri', function ($data) {
			return number_format(mophp("I",$data->hargajual));
		})
		->addColumn('aksi', function ($data) {
			if(strtolower(Auth::user()->role()->first()->name) == "apotik"){
			return '<button class="btn btn-sm btn-primary insert" data-id="'.$data->kode.'" data-nama="'.$data->nama.'" data-harga="'.$data->hargajual.'" data-toggle="modal" data-target="#update_harga_dasar" >update</button>';
			}else{
				return '';
			}
		})
		->rawColumns(['aksi'])
		->make(true);
	}else{
		if(strtolower(Auth::user()->role()->first()->name) == "apotik"){
			DB::statement(DB::raw('set @rownum=0'));
			$masterobat = Masterobat::select([
				DB::raw('@rownum  := @rownum  + 1 AS rownum'),
				'id',
				'kode',
				'nama',
				'satuan',
				'jenis',
				'stok',
				'hargajual as harga_rj',
				'hargajual as harga_ri',
				'hargajual'
			]);
			return DataTables::of($masterobat)
			->addColumn('harga_dasar', function ($data) {
				return number_format($data->hargajual);
			})
			->addColumn('harga_rj', function ($data) {
				return number_format(mophp("J",$data->hargajual));
			})
			->addColumn('harga_ri', function ($data) {
				return number_format(mophp("I",$data->hargajual));
			})
			->addColumn('aksi', function ($data) {
				return '<button class="btn btn-sm btn-primary insert" data-id="'.$data->kode.'" data-nama="'.$data->nama.'" data-harga="'.$data->hargajual.'" data-toggle="modal" data-target="#update_harga_dasar" >update</button>';
			})
			->rawColumns(['aksi'])
			->make(true);
		}else{
			return redirect('home');
		}
	}
	}

	public function update_margin(Request $request)
	{
		request()->validate(['rawatinap'=>'required', 'rawatjalan'=>'required']);
		MarginHargaObat::where('id','1')->update([
			'rawatinap'=>$request->rawatinap,
			'rawatjalan'=>$request->rawatjalan,
			
		]);
		return redirect('masterobat');
	}

	public function update_harga_apotik(Request $request)
	{
		request()->validate(['hargajual'=>'required']);
		Masterobat::where('kode',$request->kode)->update([
			'hargajual'=>$request->hargajual,
			
		]);
		return response()->json(['sukses'=>true]);
	}

	public function update_expired_null(Request $request)
	{
		request()->validate(['expired_date'=>'required']);
		Masterobat::where('kode',$request->kode)->update([
			'expired_date'=>$request->expired_date,
			
		]);
		return redirect('masterobat');
	}

	//get data stok
	public function get_stok_limit()
	{
		DB::statement(DB::raw('set @rownum=0'));
			$masterobat = Masterobat::where('stok','<','50')->select([
				DB::raw('@rownum  := @rownum  + 1 AS rownum'),
				'nama',
				'stok',
				
			]);
			return DataTables::of($masterobat)
			->make(true);
	}
	public function get_stok_kadaluarsa()
	{
		DB::statement(DB::raw('set @rownum=0'));
			$masterobat = Masterobat::where('expired_date','<',date('y-m-d'))->where('masterobats.stok','>','0')->select([
				DB::raw('@rownum  := @rownum  + 1 AS rownum'),
				'nama',
				'stok',
				
			]);
			return DataTables::of($masterobat)
			->make(true);
	}
	public function get_stok_date_null()
	{
		DB::statement(DB::raw('set @rownum=0'));
			$masterobat = Masterobat::whereNull('expired_date')->select([
				DB::raw('@rownum  := @rownum  + 1 AS rownum'),
				'nama',
				'kode',
				'stok',
				'expired_date',
				
			]);
			return DataTables::of($masterobat)
			->addColumn('expired', function ($data) {
				$btn='<form id="update_expired" name="update_expired">
				<input type="hidden" name="kode" id="kode" value="'.$data->kode.'">
				<input type="date" name="expired_date" id="expired_date" >';
				return $btn;
			})
			->addColumn('aksi', function ($data) {
				return '<button class="btn btn-sm btn-primary update_null" id="update_null" name="update_null">update</button></form>';
			})
			->rawColumns(['aksi','expired'])
			->make(true);
	}
}
