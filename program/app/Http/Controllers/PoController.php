<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Depo;
use App\Depopo;
use App\Depopodetail;
use App\Depomasterobat;
use App\Po;
use App\Podetail;
use App\Supliyer;
use App\Masterobat;
use App\Tbstokobat;
use App\Tblplpo;
use App\Tbdetaillplpo;
use Yajra\DataTables\DataTables;
use DB;
use Auth;
use PDF;
use Validator;

class PoController extends Controller
{
	public function index()
	{
		return view('po.index');
	}

	public function dataPO($value='')
	{
		DB::statement(DB::raw('set @rownum=0'));
		$po = Po::select([
			DB::raw('@rownum  := @rownum  + 1 AS rownum'),
			'id',
			'no_po',
			'tanggal',
			'tgl_penerimaan',
			'user_create',
			'status',
		])->orderBy('id','DESC')->get();
	
		return DataTables::of($po)
		->addColumn('tanggal', function ($po)
		{
			return tgl_indo($po->tanggal);
		})
		
		->addColumn('aksi', function ($po) {
			$btn_edit = "";
			if($po->status=="Draft"){
				$btn_edit = '<a href="po-order/'.$po->id.'" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-pencil"> </i></a>';
			}
			return '<a href="#" data-id="'.$po->id.'" class="btn btn-sm btn-primary btn-flat view"><i class="fa fa-table"> </i></a>'.$btn_edit;
		})
		->rawColumns(['aksi'])
		->make(true);
	}

	public function dataDetailPO($id)
	{
			$po = Po::where('id', $id)->first();
			$detail = Podetail::where('po_id', $po->id)->get();
			$data = [
					'po' => $po,
					'distributor' => 'Logistik',
					'tanggal' => tgl_indo($po->tanggal),
					'detail' => $detail,
			];
			return response()->json($data);
	}

	public function order()
	{
			return view('po.order');
	}

	public function updateOrder($id)
	{
		$po = Po::where('id', $id)->where('status', 'Draft')->first();
		if($po!=null){
			$data = [
				'po_id' => $po->id,
				'no_po' => $po->no_po,
				'supplier' => $po->supplier,
				'tanggal' => $po->tanggal,
				'user_create' => $po->user_create,
				'catatan' => $po->catatan,
				'status' => $po->status
			];
			$cek = Masterobat::where('stok','<','50')->pluck('kode')->toArray();
			
			return view('po.order', $data);
		}else{
			return redirect('po');
		}
	}

	public function kirimOrder($id)
	{
		$po = Po::where('id', $id)->where('status', 'Draft')->first();
		if($po!=null){
			$po->status = 'Pending';
			
			$lplpo = Tblplpo::where('no_po',$po->no_po)->first();
			if($lplpo!=null){
				$lplpo->status = 'Pending';
				$lplpo->save();
			}
			$po->save();
		}
		return redirect('po');
	}

	public function addItem(Request $request)
	{
		request()->validate([
				'tanggal' => 'required'
		]);

		$cek = Po::where('status','Draft')->where('supplier', $request['supplier'])->where('tanggal', valid_date($request['tanggal']))->first();
		if($cek == null) {
			$po = new Po();
			$po->no_po = 'PO'.date('YmdHis');
			$po->supplier = 'Logistik';
			$po->status = 'Draft';
			$po->tanggal = valid_date($request['tanggal']);
			$po->catatan = $request['catatan'];
			$po->tgl_penerimaan = null;
			$po->user_create = Auth::user()->name;
			$po->save();
		
			$lplpo = new Tblplpo();
			$lplpo->no_po = $po->no_po;
			$lplpo->periode = valid_date($request['tanggal']);
			$lplpo->status = "Draft";
			$lplpo->create_by = Auth::user()->name;
			$lplpo->save();
			
			$data = [
				'po_id' => $po->id,
				'no_po' => $po->no_po,
				'supplier' => $po->supplier,
				'tanggal' => $po->tanggal,
				'user_create' => $po->user_create,
				'catatan' => $request['catatan'],
				'status' => $po->status
			];
			return view('po.order', $data);
		}else{
			$cek->tanggal = valid_date($request['tanggal']);
			$cek->catatan = $request['catatan'];
			$cek->user_create = Auth::user()->name;
			$cek->update();
			return redirect('po-order/'.$cek->id);
		}
	}

	public function SimpanItem(Request $request)
	{
		$cek = Validator::make($request->all(), [
				'nama_item' => 'required',
				'jumlah_item' => 'required',
				
		]);
		if($cek->passes()) {
			$cek_stok = Tbstokobat::where('kode_obat',$request['kode_item'])->first();
			$cek_stok_jumlah = Tbstokobat::where('kode_obat',$request['kode_item'])->count();
			if($cek_stok_jumlah>0 && $cek_stok->stok < $request['jumlah_item']){
				return response()->json(['sukses'=>false, 'message'=>'Stok tidak cukup']);
			}elseif($cek_stok_jumlah<1 || $cek_stok->stok >= $request['jumlah_item']){
				$cek_item = Podetail::where('no_po',$request['no_po'])->where('kode_item',$request['kode_item'])->first();
				if($cek_item==null){
					$item = new Podetail();
					$item->po_id = $request['po_id'];
					$item->no_po = $request['no_po'];
					$item->kode_item = $request['kode_item'];
					$item->nama_item = $request['nama_item'];
					$item->jumlah = $request['jumlah_item'];
					if(!empty($request['satuan']))
					{
					$item->satuan = $request['satuan']  ;
					}else{
					$item->satuan = '-'  ;
					}
					$item->save();
					
					$lplpo = Tblplpo::where('no_po',$request['no_po'])->first();
					$master_obat = Masterobat::where('kode',$request['kode_item'])->first();
					$detail_lplpo = new Tbdetaillplpo();
					$detail_lplpo->id_lplpo = $lplpo->id;
					$detail_lplpo->kode_obat = $request['kode_item'];
					$detail_lplpo->nama_obj = $request['nama_item'];
					if($master_obat==null){
						$detail_lplpo->stok_awal = 0;
					}else{
						$detail_lplpo->stok_awal = $master_obat->stok;
					}
					$detail_lplpo->permintaan = $request['jumlah_item'];
					$detail_lplpo->save();				
					return response()->json(['sukses'=>true]);
				}else{
					return response()->json(['sukses'=>false, 'message'=>'Obat sudah pernah ditambahkan, silahkan cek atau ganti obat lain']);
				}
			}
		} else {
			return response()->json(['sukses'=>false, 'message'=>'', 'errors'=>$cek->errors()]);
		}
	}

	public function delete($id)
	{
			$item = Podetail::where('id', $id)->first();
			
			$lplpo = Tblplpo::where('no_po', $item->no_po)->first();
			$detail_lplpo = Tbdetaillplpo::where('id_lplpo', $lplpo->id)->where('kode_obat', $item->kode_item)->first();$detail_lplpo->delete();
			$item->delete();
			
			return response()->json(['sukses' => true]);
	}

	public function cetak($id='')
	{
			$po = Po::where('id', $id)->first();
			$detail = Podetail::where('po_id', $po->id)->get();
			$pdf = PDF::loadView('po.kuitansi', compact('po', 'detail'));
			$pdf->setPaper('A4', 'landscape');
			return $pdf->stream('kuitansi_po.pdf');
	}

	//=========================================================================
	public function masterObat()
	{
		//var_dump($_GET['start']); exit;
		$stok_obat 	= Tbstokobat::join('ref_obat_all','ref_obat_all.id_obat','=','tb_stok_obat.kode_obat')
									->select('ref_obat_all.tipe_sediaan','tb_stok_obat.nama_obj','tb_stok_obat.no_batch','tb_stok_obat.expired','tb_stok_obat.kode_obat','tb_stok_obat.stok')
									->orderBy('tb_stok_obat.nama_obj', 'asc')
									->get();
		return DataTables::of($stok_obat)
		->addColumn('satuan', function ($stok_obat) {
			return $stok_obat->tipe_sediaan;
		})
		->addColumn('add', function ($stok_obat) {
			return ' <a href="#" data-satuan="'.$stok_obat->tipe_sediaan.'" data-kode="'.$stok_obat->kode_obat.'" data-nama="'.$stok_obat->nama_obj.'" class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-check"></i></a> ';
		})
		->rawColumns(['add'])
		->make(true);
	}
	public function masterObatPilihan()
	{	/*$cek = Masterobat::where('stok','<','50')->pluck('kode')->toArray();
		$stok_obat = db::table('ref_obat_all')->whereIn('id_obat',$cek)
											  ->select('tipe_sediaan','nama_obat','no_batch','expired_date','id_obat')
											  ->orderBy('nama_obat', 'asc')
											  ->get();
		*/
		$stok_obat = db::select(db::raw("SELECT masterobats.kode,masterobats.nama,masterobats.stok,ref_obat_all.tipe_sediaan
		FROM masterobats
		JOIN ref_obat_all ON ref_obat_all.id_obat = masterobats.kode
		WHERE masterobats.stok < 50")); 
		return DataTables::of($stok_obat)
		->addColumn('satuan', function ($stok_obat) {
			return $stok_obat->tipe_sediaan;
		})
		->addColumn('add', function ($stok_obat) {
			return ' <a href="#" data-satuan="'.$stok_obat->tipe_sediaan.'" data-kode="'.$stok_obat->kode.'" data-nama="'.$stok_obat->nama.'" class="btn btn-sm btn-success btn-flat insert-pilihan"><i class="fa fa-check"></i></a> ';
		})
		->rawColumns(['add'])
		->make(true);
	}

	public function detailPO($po_id)
	{
		DB::statement(DB::raw('set @rownum=0'));
		$detail = Podetail::select([
		DB::raw('@rownum  := @rownum  + 1 AS rownum'),
						'id',
		'po_id',
		'no_po',
		'kode_item',
		'nama_item',
		'jumlah',
		'kode_item_pemberian',
		'nama_item_pemberian',
		'jumlah_pemberian',
		'satuan'])->where('po_id', $po_id)->get();
		return DataTables::of($detail)
												->addColumn('delete', function ($detail) {
													return ' <a href="#" data-id="'.$detail->id.'" class="btn btn-sm btn-danger btn-flat hapus"><i class="fa fa-trash"></i></a> ';
												})
												->rawColumns(['delete'])
												->make(true);
	}

	// DEPO
	public function depoIndex()
  {
		$depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
		$data = [
            'status_aksi' => true
        ];
		if($depo==null){
			$data = [
				'status_aksi' => false
			];
		}
        return view('depo.index', $data);
  }
	
	public function dataDepo($value='')
  {
		$depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
		if(Auth::user()->role()->first()->name=="apotik"){
			DB::statement(DB::raw('set @rownum=0'));
			$po = Depopo::select([
				DB::raw('@rownum  := @rownum  + 1 AS rownum'),
				'id',
				'id_depo',
				'no_po',
				'tanggal',
				'tgl_penerimaan',
				'user_create',
				'status',
				])->where('supplier','Apotek')->whereIn('status',['Pending','Selesai'])->orderBy('id','DESC')->get();
		}elseif(Auth::user()->role()->first()->name=="supervisor-apotik"){
			DB::statement(DB::raw('set @rownum=0'));
			$po = Depopo::select([
				DB::raw('@rownum  := @rownum  + 1 AS rownum'),
				'id',
				'id_depo',
				'no_po',
				'tanggal',
				'tgl_penerimaan',
				'user_create',
				'status',
				])->where('supplier','Apotek')->whereIn('status',['Pending','Selesai'])->orderBy('id','DESC')->get();
		}elseif(Auth::user()->role()->first()->name=="administrator"){
			DB::statement(DB::raw('set @rownum=0'));
			$po = Depopo::select([
				DB::raw('@rownum  := @rownum  + 1 AS rownum'),
				'id',
				'id_depo',
				'no_po',
				'tanggal',
				'tgl_penerimaan',
				'user_create',
				'status',
				])->orderBy('id','DESC')->get();
		}else{
			DB::statement(DB::raw('set @rownum=0'));
			$po = Depopo::select([
				DB::raw('@rownum  := @rownum  + 1 AS rownum'),
				'id',
				'id_depo',
				'no_po',
				'tanggal',
				'tgl_penerimaan',
				'user_create',
				'status',
				])->where('id_depo',$depo->id)->orderBy('id','DESC')->get();
		}    
				
		return DataTables::of($po)
			->addColumn('id_depo', function ($po)
			{
				$depox = Depo::where('id', $po->id_depo)->first();
				return ucfirst(strtolower($depox->nama_depo));
			})
			->addColumn('tanggal', function ($po)
			{
				return tgl_indo($po->tanggal);
			})
			->addColumn('status', function ($detail) {
				if($detail->status=="Pending"){
					return '<span class="text-warning"><i>'.$detail->status.'</i></span>';
				}else{
					return '<span class="text-success">'.$detail->status.'</span>';
				}
			})
			->addColumn('aksi', function ($po) {
				$depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
				$btn_edit = "";
				if($po->status=="Draft" AND $depo!=null){
					$btn_edit = '<a href="depo-order/'.$po->id.'" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-pencil"> </i></a>';
				}
				return '<a href="#" data-id="'.$po->id.'" class="btn btn-sm btn-primary btn-flat view"><i class="fa fa-table"> </i></a>'.$btn_edit;
			})
			->rawColumns(['aksi','status'])
			->make(true);    
  }

	public function depoOrder()
	{
		$data['supplier'] = 0;
		return view('depo.order', $data);
	}
	
	public function addItemDepo(Request $request)
  {
		request()->validate([
				'tanggal' => 'required'
		]);
		$depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
		$cek = Depopo::where('supplier', $request['distributor'])->where('tanggal', valid_date($request['tanggal']))->count();
		if($cek <= 0) {
				$po = new Depopo();
				$po->id_depo = $depo->id;
				$po->no_po = 'DEPO'.date('YmdHis');
				$po->supplier = $request['distributor'];
				$po->status = 'Draft';
				$po->tanggal = valid_date($request['tanggal']);
				$po->catatan = $request['catatan'];
				$po->tgl_penerimaan = null;
				$po->user_create = Auth::user()->name;
				$po->save();
				
				if($request['distributor']=='Logistik'){
					$lplpo = new Tblplpo();
					
					$lplpo->no_po = $po->no_po;
					$lplpo->periode = valid_date($request['tanggal']);
					$lplpo->status = "Draft";
					$lplpo->create_time = date('Y-m-d H:i:s');
					$lplpo->create_by = Auth::user()->name;
					$lplpo->save();
				}
		} else {
				$po = Depopo::where('supplier', $request['distributor'])->where('tanggal', valid_date($request['tanggal']))->first();
		}
		$data = [
				'po_id' => $po->id,
				'no_po' => $po->no_po,
				'supplier' => $po->supplier,
				'tanggal' => $po->tanggal,
				'user_create' => $po->user_create,
				'catatan' => $po->catatan,
				'status' => $po->status
		];
		return view('depo.order', $data);
  }

	public function depoMasterObat($val)
  {
		$depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
		$stok_obat = null;
		if($val=='Apotek'){
			$stok_obat = Masterobat::select('nama','satuan','stok','kode')->orderBy('nama', 'asc')->get();
		}elseif($val=='Logistik'){
			$stok_obat 	= Tbstokobat::join(config('app.db_second').'.ref_obat_all', 'tb_stok_obat.kode_obat', '=', 'ref_obat_all.id_obat')
										->select('tb_stok_obat.nama_obj as nama','ref_obat_all.satuan_jual as satuan','tb_stok_obat.kode_obat as kode','tb_stok_obat.stok')
										->groupBy('tb_stok_obat.kode_obat')
										->orderBy('tb_stok_obat.nama_obj', 'asc')
										->get();
		}
		return DataTables::of($stok_obat)
		->addColumn('add', function ($stok_obat) {
			return ' <a href="#" data-kode="'.$stok_obat->kode.'" data-satuan="'.$stok_obat->satuan.'" data-nama="'.$stok_obat->nama.'" class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-check"></i></a> ';
		})
		->rawColumns(['add'])
		->make(true);
  }

	public function detailDepopo($po_id)
	{
		DB::statement(DB::raw('set @rownum=0'));
		$detail = Depopodetail::select([
		DB::raw('@rownum  := @rownum  + 1 AS rownum'),
			'id',
			'po_id',
			'no_po',
			'kode_item',
			'nama_item',
			'jumlah',
			'kode_item_pemberian',
			'nama_item_pemberian',
			'jumlah_pemberian',
			'satuan'])->where('po_id', $po_id)->get();
		return DataTables::of($detail)
												->addColumn('delete', function ($detail) {
													return ' <a href="#" data-id="'.$detail->id.'" class="btn btn-sm btn-danger btn-flat hapus"><i class="fa fa-trash"></i></a> ';
												})
												->rawColumns(['delete'])
												->make(true);
	}
	
	public function dataDepoDetail($id)
  {
		$po = Depopo::where('id', $id)->first();
		$detail = Depopodetail::where('po_id', $po->id)->get();
		$data = [
			'po' => $po,
			'distributor' => 'Logistik',
			'tanggal' => tgl_indo($po->tanggal),
			'detail' => $detail,
		];
		return response()->json($data);
  }
	
	public function depoDetail($po_id)
	{
		DB::statement(DB::raw('set @rownum=0'));
			$detail = Depopodetail::select([
			DB::raw('@rownum  := @rownum  + 1 AS rownum'),
			'id',
			'po_id',
			'no_po',
			'kode_item',
			'nama_item',
			'jumlah',
			'kode_item_pemberian',
			'nama_item_pemberian',
			'jumlah_pemberian',
			'satuan'
		])->where('po_id', $po_id)->get();
        return DataTables::of($detail)
				->addColumn('jumlah_pemberian', function ($detail) {
					$depopo = Depopo::where('id', $detail->po_id)->first();
					$depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
					if($depo==null AND $depopo->status=='Pending'){
						return '<input type="number" onkeyup="updatePemberian(this.value,\''.$detail->no_po.'\',\''.$detail->kode_item.'\')" class="form-control" id="jumlah_pemberian" oname="jumlah_pemberian[]" value="'.$detail->jumlah_pemberian.'">';
					}else{
						return $detail->jumlah_pemberian;
					}
				})
				->addColumn('delete', function ($detail) {
					return ' <a href="#" data-id="'.$detail->id.'" class="btn btn-sm btn-danger btn-flat hapus"><i class="fa fa-trash"></i></a> ';
				})
				->rawColumns(['delete','jumlah_pemberian'])
				->make(true);
    }
	
	public function updateDepoOrder($id)
  {
		$po = Depopo::where('id', $id)->where('status', 'Draft')->first();
		if($po!=null){
			$data = [
				'po_id' => $po->id,
				'no_po' => $po->no_po,
				'supplier' => $po->supplier,
				'tanggal' => $po->tanggal,
				'user_create' => $po->user_create,
				'catatan' => $po->catatan,
				'status' => $po->status
			];
			return view('depo.order', $data);
		}else{
			return redirect('depo-obat');
		}
  }
	
	public function depoSimpanItem(Request $request, $val)
  {
		$cek = Validator::make($request->all(), [
			'nama_item' => 'required',
			'jumlah_item' => 'required',
			'satuan' => 'required'
		]);
		if($cek->passes()){
			if($val=='Apotek'){
				$cek_stok = Masterobat::where('kode',$request['kode_item'])->first();
			}else{
				$cek_stok	= Tbstokobat::where('kode_obat',$request['kode_item'])->first();
			}
			if($cek_stok->stok < $request['jumlah_item']){
				return response()->json(['sukses'=>false, 'message'=>'Stok tidak cukup']);
			}else{
				$cek_item = Depopodetail::where('no_po',$request['no_po'])->where('kode_item',$request['kode_item'])->first();
				if($cek_item==null){
					$item = new Depopodetail();
					$item->po_id = $request['po_id'];
					$item->no_po = $request['no_po'];
					$item->kode_item = $request['kode_item'];
					$item->nama_item = $request['nama_item'];
					$item->jumlah = $request['jumlah_item'];
					$item->satuan = $request['satuan'];
					$item->save();	
					
					if($val=='Logistik'){
						$lplpo = Tblplpo::where('no_po',$request['no_po'])->first();
						$detail_lplpo = new Tbdetaillplpo();
						
						$detail_lplpo->id_lplpo = $lplpo->id;
						$detail_lplpo->kode_obat = $request['kode_item'];
						$detail_lplpo->nama_obj = $request['nama_item'];
						if($cek_stok==null){
							$detail_lplpo->stok_awal = 0;
						}else{
							$detail_lplpo->stok_awal = $cek_stok->stok;
						}
						$detail_lplpo->permintaan = $request['jumlah_item'];
						$detail_lplpo->save();
					}
					
					return response()->json(['sukses'=>true]);
				}else{
					return response()->json(['sukses'=>false, 'message'=>'Obat sudah pernah ditambahkan, silahkan cek atau ganti obat lain']);
				}
			}
		}else{
			return response()->json(['sukses'=>false, 'message'=>'', 'errors'=>$cek->errors()]);
		}
  }
	
	public function DepoDelete($id)
  {
		$item = Depopodetail::where('id', $id)->first();
		
		$lplpo = Tblplpo::where('no_po', $item->no_po)->first();
		$detail_lplpo = Tbdetaillplpo::where('id_lplpo', $lplpo->id)->where('kode_obat', $item->kode_item)->first();
		$detail_lplpo->delete();
		if($item->delete()){
			return response()->json(['sukses' => true]);
		}else{
			return response()->json(['sukses' => false]);
		}
    }
	
	public function depoKirimOrder($id)
   {
		$po = Depopo::where('id', $id)->where('status', 'Draft')->first();
		if($po!=null){
			$po->status = 'Pending';
			if($po->supplier=='Logistik'){
				$lplpo = Tblplpo::where('no_po', $po->no_po)->first();
				
				$lplpo->status = "Pending";
				$lplpo->create_time = date('Y-m-d H:i:s');
				$lplpo->create_by = Auth::user()->name;
				$lplpo->save();
			}
			if($po->save()){
				return redirect('depo-order/'.$id);
			}else{
				return redirect('depo-obat');
			}
		}else{			
			return redirect('depo-obat');
		}
    }

	// DISTRIBUSI
	public function distIndex()
  {
    $depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
		if($depo==null){
			$data = [
				'status_aksi' => false
			];
		}else{
			$data = [
				'status_aksi' => true
			];
		}
		return view('depo.index', $data);
	}
	
	public function updatePemberian($value,$no_po,$kode_item)
    {
        $po = Depopo::where('no_po', $no_po)->first();
		if($po->status=="Selesai"){
			
		}else{
			$po_detail = Depopodetail::where('no_po', $no_po)->where('kode_item', $kode_item)->first();
			if($po_detail!=null){
				$po_detail->jumlah_pemberian = $value;
				$po_detail->save();
			}			
		}
    }	
	
	public function setujuPemberian($no_po)
  {
		$po = Depopo::where('no_po', $no_po)->first();
		$detail = Depopodetail::where('no_po', $no_po)->get();
		$cek_stok = false;
		if($detail!=null){
			foreach ($detail as $key => $d) {
				$obat = Masterobat::where('kode', $d->kode_item)->first();
				$nama_obat = "";
				$sisa_stok = "";
				if($obat!=null AND !$cek_stok){
					if($obat->stok < $d->jumlah_pemberian){
						$cek_stok = true;
						$nama_obat = $d->nama_item.' / '.$d->nama_item;
						$sisa_stok = $obat->stok;
					}
				}
			}
			if($cek_stok){
				return response()->json(['sukses'=>false, 'message'=>'Sisa stok '.$nama_obat.' tinggal '.$sisa_stok]);
			}else{
				// update or add depo_masterobat
				// update stok
				// update status
				foreach ($detail as $key => $d) {
					$cek_obat = Depomasterobat::where('id_depo', $po->id_depo)->where('kode', $d->kode_item)->first();
					$master_obat = Masterobat::where('kode', $d->kode_item)->first();
					if($cek_obat==null){
						$inp_obat = new Depomasterobat();
						$inp_obat->id_depo = $po->id_depo;
						$inp_obat->nama = $d->nama_item;
						$inp_obat->kode = $d->kode_item;
						$inp_obat->satuan = $master_obat->satuan;
						$inp_obat->kategoriobat_id = $master_obat->kategoriobat_id;
						$inp_obat->hargajual = $master_obat->hargajual;
						$inp_obat->stok = $d->jumlah_pemberian;
						$inp_obat->aktif = "Y";
						$inp_obat->save();
					}else{
						$cek_obat->hargajual = $master_obat->hargajual;
						$cek_obat->stok = (int)$cek_obat->stok + (int)$d->jumlah_pemberian;
						$cek_obat->save();
					}
					$master_obat->stok = (int)$master_obat->stok - (int)$d->jumlah_pemberian;
					$master_obat->save();
				}
				$po->tgl_penerimaan = date('Y-m-d');
				$po->status = "Selesai";
				$po->save();
				return response()->json(['sukses'=>true, 'message'=>'Berhasil di simpan']);
			}
		}
    }	
}
