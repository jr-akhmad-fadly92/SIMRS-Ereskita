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
use App\Masterprodusen;
use App\Tbstokobat;
use App\Tblplpo;
use App\Tbstokobatretur;
use App\Returlogdetail;
use App\Returlog;
use App\Tbretur;
use App\Tbdetailretur;
use App\Tbdetaillplpo;
use Modules\Role\Entities\Role;
use Modules\Config\Entities\Config;
use Yajra\DataTables\DataTables;
use DB;
use Auth;
use PDF;
use Validator;

class ReturController extends Controller
{
    public function index()
	{
		return view('retur.index');
    }
    
    public function order()
	{
		return view('retur.order');
    }
    
    public function updateOrder($id)
	{
		$po = Returlog::where('id', $id)->where('status', 'Draft')->first();
		if($po!=null){
			$data = [
                'po_id' => $po->id,
				'no_retur' => $po->no_retur,
				'supplier' => $po->supplier,
				'tanggal' => $po->tanggal,
				'user_create' => $po->user_create,
				'catatan' => $po->catatan,
				'status' => $po->status
			];
			$cek = Masterobat::where('expired_date','<',date('y-m-d'))->pluck('kode')->toArray();
			
			return view('retur.order', $data);
		}else{
			return redirect('retur');
		}
    }
    
    public function addItem(Request $request)
	{
		request()->validate([
				'tanggal' => 'required'
		]);

		$cek = Returlog::where('status','Draft')->where('supplier', $request['supplier'])->where('tanggal', valid_date($request['tanggal']))->first();
		if($cek == null) {
			$po = new Returlog();
			$po->no_retur = 'RT'.date('YmdHis');
			$po->supplier = 'Logistik';
			$po->status = 'Draft';
			$po->tanggal = valid_date($request['tanggal']);
			$po->catatan = $request['catatan'];
			$po->tanggal_penerimaan = null;
			$po->user_create = Auth::user()->name;
			$po->save();
			$data = [
				'po_id' => $po->id,
				'no_retur' => $po->no_retur,
				'supplier' => $po->supplier,
				'tanggal' => $po->tanggal,
				'user_create' => $po->user_create,
				'catatan' => $request['catatan'],
				'status' => $po->status
			];
			return view('retur.order', $data);
		}else{
			$cek->tanggal = valid_date($request['tanggal']);
			$cek->catatan = $request['catatan'];
			$cek->user_create = Auth::user()->name;
			$cek->update();
			return redirect('retur-order/'.$cek->id);
		}
    }
    
    public function masterObat()
	{
		//var_dump($_GET['start']); exit;
		$stok_obat 	= Masterobat::join('ref_obat_all','ref_obat_all.id_obat','=','masterobats.kode')
									->select('ref_obat_all.tipe_sediaan','masterobats.nama','ref_obat_all.no_batch','masterobats.expired_date','masterobats.kode','masterobats.stok')
									->where('masterobats.expired_date','<',date('y-m-d'))
									->where('masterobats.stok','>','0')
                                    ->orderBy('masterobats.nama', 'asc')
									->get();
		return DataTables::of($stok_obat)
		->addColumn('satuan', function ($stok_obat) {
			return $stok_obat->tipe_sediaan;
		})
		->addColumn('expired', function ($stok_obat) {
			return valid_date($stok_obat->expired_date);
		})
		
		->addColumn('add', function ($stok_obat) {
			return ' <a href="#" data-satuan="'.$stok_obat->tipe_sediaan.'" data-jumlah="'.$stok_obat->stok.'" data-date="'.valid_date($stok_obat->expired_date).'" data-jumlah="'.$stok_obat->stok.'" data-kode="'.$stok_obat->kode.'" data-nama="'.$stok_obat->nama.'" class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-check"></i></a> ';
		})
		->rawColumns(['add'])
		->make(true);
	}

	public function SimpanItem(Request $request)
	{
		$cek = Validator::make($request->all(), [
				'nama_item' => 'required',
				'jumlah_item' => 'required',
				'keterangan' => 'required',
				'expired' => 'required',
				
		]);
		if($cek->passes()) {
			$cek_stok = Tbstokobatretur::where('kode',$request['kode_item'])->first();
			$cek_stok_jumlah = Tbstokobatretur::where('kode',$request['kode_item'])->count();
			if($cek_stok_jumlah>0 && $cek_stok->stok < $request['jumlah_item']){
				return response()->json(['sukses'=>false, 'message'=>'Stok tidak cukup']);
			}elseif($cek_stok_jumlah<1 || $cek_stok->stok >= $request['jumlah_item']){
				$cek_item = Returlogdetail::where('no_retur',$request['no_retur'])->where('kode',$request['kode_item'])->first();
				if($cek_item==null){
					$data_awal = Masterobat::where('kode',$request['kode_item'])->first();
					$item = new Returlogdetail();
					$item->no_retur = $request['no_retur'];
					$item->kode = $request['kode_item'];
					$item->nama = $request['nama_item'];
					$item->jumlah = $request['jumlah_item'];
					$item->expired = valid_date($request['expired']);
					$item->satuan = $data_awal['satuan'];
					$item->keterangan = $request['keterangan'];
					if(!empty($request['satuan']))
					{
					$item->satuan = $request['satuan']  ;
					}else{
					$item->satuan = '-'  ;
					}
					$item->save();
					
					
					return response()->json(['sukses'=>true]);
				}else{
					return response()->json(['sukses'=>false, 'message'=>'Obat sudah pernah ditambahkan, silahkan cek atau ganti obat lain']);
				}
			}
		} else {
			return response()->json(['sukses'=>false, 'message'=>'', 'errors'=>$cek->errors()]);
		}
	}

	public function detailRetur($po_id)
	{
		DB::statement(DB::raw('set @rownum=0'));
		$detail = Returlogdetail::select([
		DB::raw('@rownum  := @rownum  + 1 AS rownum'),
		'id',
		'no_retur',
		'kode',
		'nama',
		'jumlah',
		'kode_pemberian',
		'nama_pemberian',
		'jumlah_pemberian',
		'satuan'])->where('no_retur', $po_id)->get();
		return DataTables::of($detail)
		->addColumn('delete', function ($detail) {
			return ' <a href="#" data-id="'.$detail->id.'" class="btn btn-sm btn-danger btn-flat hapus"><i class="fa fa-trash"></i></a> ';
		})
		->rawColumns(['delete'])
		->make(true);
	}

	public function kirimRetur($id)
	{
		$po = Returlog::where('id', $id)->where('status', 'Draft')->first();
		$data_retur = Returlogdetail::where('no_retur',$po->no_retur)->get();
		foreach($data_retur as $data)
		{
			$cek = Tbstokobatretur::where('no_retur',$data['no_retur'])->where('kode',$data['kode'])->count();
			if($cek<1)
			{
					$data_awal = Masterobat::where('kode',$data['kode'])->first();
					$retur = new Tbstokobatretur();
					$retur->no_retur = $data['no_retur'];
					$retur->kode = $data['kode'];
					$retur->stok = $data['jumlah'];
					$retur->nama = $data['nama'];
					$retur->expired = $data['expired'];
					$retur->keterangan = $data['keterangan'];
					$retur->satuan = $data_awal['satuan'];
					$retur->harga = $data_awal->hargabeli;
					$retur->harga_jual = $data_awal->hargajual;
					$retur->save();

					Masterobat::where('kode',$data['kode'])->update([
						'stok'=>$data_awal->stok-$data['jumlah']
					]);}
		}
		if($po!=null){
			$po->status = 'Pending';
			$po->save();
		}
		return redirect('retur');
	}

	public function delete($id)
	{
			$item = Returlogdetail::where('id', $id)->first();
			$item->delete();
			
			return response()->json(['sukses' => true]);
	}

	public function dataRetur($value='')
	{
		DB::statement(DB::raw('set @rownum=0'));
		$po = Returlog::select([
			DB::raw('@rownum  := @rownum  + 1 AS rownum'),
			'id',
			'no_retur',
			'tanggal',
			'tanggal_penerimaan',
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
				$btn_edit = '<a href="retur-order/'.$po->id.'" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-pencil"> </i></a>';
			}
			return '<a href="#" data-id="'.$po->id.'" data-retur="'.$po->no_retur.'" class="btn btn-sm btn-primary btn-flat view"><i class="fa fa-table"> </i></a>'.$btn_edit;
		})
		->rawColumns(['aksi'])
		->make(true);
	}

	public function dataDetailRetur($id)
	{
			$po = Returlog::where('id', $id)->first();
			$detail = Returlogdetail::where('no_retur', $po->no_retur)->get();
			$data = [
					'po' => $po,
					'distributor' => 'Logistik',
					'tanggal' => tgl_indo($po->tanggal),
					'detail' => $detail,
			];
			return response()->json($data);
	}

	// RETUR SUPPLIER
	public function retur_supplier()
	{
		return view('logistik/logistik/retur.index');
	}
	
	public function order_supplier()
	{
		return view('logistik/logistik/retur.order');
    }
    
    public function updateOrder_supplier($id)
	{
		$po = Tbretur::where('id', $id)->where('status', 'Draft')->first();
		if($po!=null){
			$data = [
                'po_id' => $po->id,
				'no_retur' => $po->no_retur,
				'supplier' => $po->supplier,
				'tanggal' => $po->tanggal,
				'user_create' => $po->petugas,
				'catatan' => $po->ket_retur,
				'status' => $po->status
			];
			$cek = Masterobat::where('expired_date','<',date('y-m-d'))->pluck('kode')->toArray();
			
			return view('logistik/logistik/retur.order', $data);
		}else{
			return redirect('/gudang/retur');
		}
    }
    
    public function addItem_supplier(Request $request)
	{
		request()->validate([
				'tanggal' => 'required'
		]);

		$cek = Tbretur::where('status','Draft')->where('supplier', $request['supplier'])->where('tanggal', valid_date($request['tanggal']))->first();
		if($cek == null) {
			$po = new Tbretur();
			$po->no_retur = 'RTO'.date('YmdHis');
			$po->supplier = $request['supplier'];
			$po->status = 'Draft';
			$po->tanggal = valid_date($request['tanggal']);
			$po->ket_retur = $request['catatan'];
			$po->petugas = Auth::user()->name;
			$po->save();
			$data = [
				'po_id' => $po->id,
				'no_retur' => $po->no_retur,
				'supplier' => $po->supplier,
				'tanggal' => $po->tanggal,
				'user_create' => $po->petugas,
				'catatan' => $po->ket_retur,
				'status' => $po->status
			];
			return view('logistik/logistik/retur.order', $data);
		}else{
			$cek->tanggal = valid_date($request['tanggal']);
			$cek->ket_retur = $request['catatan'];
			$cek->petugas = Auth::user()->name;
			$cek->update();
			return redirect('/gudang/retur/order/'.$cek->id);
		}
    }
    
    public function masterObat_supplier()
	{
	
		$stok_obat 	= Tbstokobatretur::join('ref_obat_all','ref_obat_all.id_obat','=','tb_stok_obat_retur.kode')
									->select('tb_stok_obat_retur.satuan','tb_stok_obat_retur.nama','ref_obat_all.no_batch','tb_stok_obat_retur.expired','tb_stok_obat_retur.kode','tb_stok_obat_retur.stok')
								
                                    ->orderBy('tb_stok_obat_retur.nama', 'asc')
									->get();
		return DataTables::of($stok_obat)
		->addColumn('add', function ($stok_obat) {
			return ' <a href="#" data-satuan="'.$stok_obat->satuan.'" data-jumlah="'.$stok_obat->stok.'" data-date="'.valid_date($stok_obat->expired).'" data-jumlah="'.$stok_obat->stok.'" data-kode="'.$stok_obat->kode.'" data-nama="'.$stok_obat->nama.'" class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-check"></i></a> ';
		})
		->rawColumns(['add'])
		->make(true);
	}

	public function SimpanItem_supplier(Request $request)
	{
		$cek = Validator::make($request->all(), [
				'nama_item' => 'required',
				'jumlah_item' => 'required',
				'keterangan' => 'required',
				'expired' => 'required',
				
		]);
		if($cek->passes()) {
			$cek = Tbdetailretur::where('no_retur',$request['no_retur'])->where('kode',$request['kode_item'])->count();
			if($cek<1){
				$data_awal = Tbstokobatretur::where('kode',$request['kode_item'])->first();
				$item = new Tbdetailretur();
				$item->no_retur = $request['no_retur'];
				$item->kode = $request['kode_item'];
				$item->nama_obj = $request['nama_item'];
				$item->jumlah = $request['jumlah_item'];
				$item->harga = $data_awal['harga'];
				$item->total_harga = $data_awal['harga']*$request['jumlah_item'];
				$item->expired = valid_date($request['expired']);
				$item->satuan = $data_awal['satuan'];
				$item->keterangan = $request['keterangan'];
				$item->save();
				return response()->json(['sukses'=>true, 'message'=>'Data berhasil di input']);
			}else{
				return response()->json(['sukses'=>false, 'message'=>'data sudah ada, silahkan hapus dulu data yang telah di input']);
			}
		} else {
			return response()->json(['sukses'=>false, 'message'=>'', 'errors'=>$cek->errors()]);
		}
	}

	public function detailRetur_supplier($po_id)
	{
		DB::statement(DB::raw('set @rownum=0'));
		$detail = Tbdetailretur::select([
		DB::raw('@rownum  := @rownum  + 1 AS rownum'),
		'id',
		'no_retur',
		'kode',
		'nama_obj',
		'jumlah',
		'keterangan',
		'harga',
		'total_harga',
		'expired'])->where('no_retur', $po_id)->get();
		return DataTables::of($detail)
		->addColumn('harga_jual', function ($detail) {
			return number_format($detail->harga);
		})
		->addColumn('total_harga_jual', function ($detail) {
			return number_format($detail->total_harga);
		})
		->addColumn('delete', function ($detail) {
			return ' <a href="#" data-id="'.$detail->id.'" class="btn btn-sm btn-danger btn-flat hapus"><i class="fa fa-trash"></i></a> ';
		})
		->rawColumns(['delete'])
		->make(true);
	}

	public function kirimRetur_supplier($id)
	{
		$po = Tbretur::where('id', $id)->where('status', 'Draft')->first();
	
		$sub_harga = Tbdetailretur::where('no_retur',$po->no_retur)->sum('harga');
		$sub_total_harga = Tbdetailretur::where('no_retur',$po->no_retur)->sum('total_harga');

		$po->sub_harga = $sub_total_harga;
		$po->materai = '6000';
		$po->diskon = '0';
		$po->ppn = $sub_total_harga/10;
		$po->total_harga = ($sub_total_harga+$sub_total_harga/10+6000);
		$po->update();

		if($po!=null){
			$po->status = 'Selesai';
			$po->save();
		}
		
		return redirect('/gudang/retur');
	}

	public function delete_supplier($id)
	{
			$item = Tbdetailretur::where('id', $id)->first();
			$item->delete();
			
			return response()->json(['sukses' => true]);
	}

	public function dataRetur_supplier($value='')
	{
		DB::statement(DB::raw('set @rownum=0'));
		$po = Tbretur::join('master_produsen_inv','master_produsen_inv.id_produsen','=','tb_retur.supplier')->select([
			DB::raw('@rownum  := @rownum  + 1 AS rownum'),
			'tb_retur.id',
			'tb_retur.no_retur',
			'tb_retur.no_faktur',
			'tb_retur.tanggal',
			'tb_retur.supplier',
			'tb_retur.petugas',
			'master_produsen_inv.nama_produsen',
		
		])->orderBy('tb_retur.id','DESC')->get();
	
		return DataTables::of($po)
		->addColumn('tanggal_retur', function ($po)
		{
			return tgl_indo($po->tanggal);
		})
		
		->addColumn('aksi', function ($po) {
			$btn_edit = "";
			if($po->status=="Draft"){
				$btn_edit = '<a href="retur-order/'.$po->id.'" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-pencil"> </i></a>';
			}
			return '<a href="'.url('/gudang/retur-pdf/'.$po->no_retur).'" name="laporan" class="btn btn-primary btn-flat"><i class="fa fa-file"></i> Retur</a>
			'.$btn_edit;
		})
		->rawColumns(['aksi','tanggal_retur'])
		->make(true);
	}

	public function dataDetailRetur_supplier($id)
	{
			$po = Returlog::where('id', $id)->first();
			$detail = Returlogdetail::where('no_retur', $po->no_retur)->get();
			$data = [
					'po' => $po,
					'distributor' => 'Logistik',
					'tanggal' => tgl_indo($po->tanggal),
					'detail' => $detail,
			];
			return response()->json($data);
	}

	public function pdf_retur($id)
	{		$config = Config::find(1);
			$data['retur'] = Tbretur::where('no_retur',$id)->first();
            $data['detail_retur'] = Tbdetailretur::where('no_retur',$id)->where('harga','>',0)->get();  
            
            $no=1;
			$pdf = PDF::loadView('/logistik/logistik/retur.pdfretur_barang', $data,compact('no','config'));
			return $pdf->stream();
	}
}
