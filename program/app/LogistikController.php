<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Role\Entities\Role;
use Modules\Config\Entities\Config;
use DB;
use Activity;
use Yajra\DataTables\DataTables;
use Auth;
use PDF;
use MercurySeries\Flashy\Flashy;
use Redirect;
use App\Depononmedis;
use App\Depodetailnonmedis;
use App\Depo;
use App\Tbstokobat;
use Modules\Pegawai\Entities\Pegawai;
use App\Masterruangan; 
use App\Tbdetaillplpo;
use App\Tbretur;
use App\Masterobat;
use App\Tbdetailretur;
use App\Tblplpo;
use App\Tbldetailplpo;
use App\Inventarisglobal;
use App\Tbdetailpenerimaan;
use App\Masternonmedis;
use App\Masterprodusen;
use App\Tbpenerimaan;
use App\Tbpurchase;
use App\Stokobat;
use App\Masterobatall;
use App\Tbdetailpurchase;
use App\Po;
use App\Podetail;
use App\Tbstokopnam;
use App\Tbdetailstokopnam;


class LogistikController extends Controller
{
        public function gudangobat()
        {   
            
            return view('/logistik/logistik/obat.index');
        }

        // PO Obat ================================================
      

        public function po_obat()
        {   
            $data['tbpurchase'] = Tbpurchase::all();
            return view('/logistik/logistik/po.index',$data)->with('no',1);
        }

        public function pdfpo_obat($id)
        {   $data['config'] = Config::find(1);
            $data['tbpurchase'] = Tbpurchase::join('master_produsen_inv','master_produsen_inv.id_produsen','=','tb_purchase.po_supplier')->where('tb_purchase.po_no_purchaseorder',$id)->first();
            $data['total'] = Tbdetailpurchase::where('dpo_no_purchaseorder',$id)
                                               ->sum('dpo_total_price');
            $data['ppn']= $data['total']*10/100;
            $data['materai']= 6000;
            
            $data['totalkeseluruhan']= $data['total']+$data['ppn']+$data['materai'];
            $data['Tbdetailpurchase'] = Tbdetailpurchase::where('dpo_no_purchaseorder',$id)
                                        ->get();
            $no=1;
		    $pdf = PDF::loadView('/logistik/logistik/po.pdfpo_obat', $data,compact('no'),[
                'format' => 'legal-P']);
    	    return $pdf->stream();
            //return view('/logistik/logistik/po.index',$data)->with('no',1);
        }

        public function depoOrder($id)
        {
            $data['supplier'] = Masterprodusen::where('kategori',$id)->get();
            $data['kategori'] = $id;
            
            return view('logistik/logistik/po.order', $data);
        }

        public function tampilDepo($id)
        {
            $po = Tbpurchase::where('po_no_purchaseorder',$id)->first();
            $po_id = $po->po_id;
            $no_po = $po->po_no_purchaseorder;
            $tanggal = $po->po_tanggal_pemesanan;
            $kategori = $po->po_kategori_order;
            $supplier = $po->po_supplier;
            $user_create = $po->po_nama_pemohon;
            $catatan = $po->po_catatan;
            $status = $po->po_status;
            return view('logistik/logistik/po.order',compact('po_id','no_po','tanggal','kategori','supplier','user_create','catatan','status') );
        }
        
        public function addItemDepo(Request $request)
        {
                request()->validate([
                        'po_tanggal_pemesanan' => 'required'
                ]);
                $cek = Tbpurchase::where('po_supplier',$request['po_supplier'])->where('po_tanggal_pemesanan', valid_date($request['po_tanggal_pemesanan']))->count();
                if($cek <= 0) {
                        $po = new Tbpurchase();
                        if($request['po_kategori_order']=='obat'){
                        $po->po_no_purchaseorder = 'POB'.date('YmdHis');
                        }elseif($request['po_kategori_order']=='inventaris'){
                        $po->po_no_purchaseorder = 'POI'.date('YmdHis');
                        }else{
                        $po->po_no_purchaseorder = 'PONM'.date('YmdHis');
                        }
                        $po->po_status = 'Draft';
                        $po->po_tanggal_pemesanan = valid_date($request['po_tanggal_pemesanan']);
                        $po->po_catatan = $request['po_catatan'];
                        $po->po_supplier = $request['po_supplier'];
                        $po->po_nama_pemohon = $request['po_nama_pemohon'];
                       // $po->po_bagian = $request['po_bagian'];
                        $po->po_kategori_order = $request['po_kategori_order'];
                        $po->save();
                        
                        
                } else {
                    $po = Tbpurchase::where('po_supplier',$request['po_supplier'])->where('po_tanggal_pemesanan', valid_date($request['po_tanggal_pemesanan']))->first();
                }
                /*$data = [
                        'po_id' => $po->po_id,
                        'no_po' => $po->po_no_purchaseorder,
                        'tanggal' => $po->po_tanggal_pemesanan,
                        'kategori' => $po->po_kategori_order,
                        'supplier' => $po->po_supplier,
                        'user_create' => $po->po_nama_pemohon,
                        'catatan' => $po->po_catatan,
                        'status' => $po->po_status
                ];*/
                $po_id = $po->po_no_purchaseorder;
                return redirect('/gudang/po-obat/detail-order/'.$po_id);
        }
        
        public function Masterobat($id)
        {       if($id=='obat'){
                $nama_barang = DB::select( DB::raw("SELECT id_obat,nama_obat,supplier,satuan_besar,satuanjual FROM ref_obat_all") );
                return DataTables::of($nama_barang)
                
                ->addColumn('add', function ($nama_barang) {
                    return ' <a href="#" data-kode="'.$nama_barang->id_obat.'"  data-nama="'.$nama_barang->nama_obat.'" data-nama1="'.$nama_barang->supplier.'" class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-check"></i></a> ';
                })
                ->rawColumns(['add'])
                ->make(true);
                }elseif($id=='inventaris'){
                    $nama_barang = DB::select( DB::raw("SELECT inventaris_global.kode_barang,inventaris_global.nama_barang,inventaris_global.harga_unit,master_produsen_inv.nama_produsen  
                    FROM inventaris_global 
                    INNER JOIN master_produsen_inv ON master_produsen_inv.id_produsen = inventaris_global.produsen") );
                    return DataTables::of($nama_barang)
                    
                    ->addColumn('add', function ($nama_barang) {
                        return ' <a href="#" data-kode="'.$nama_barang->kode_barang.'"  data-nama="'.$nama_barang->nama_barang.'" data-nama1="'.$nama_barang->nama_produsen.'" data-nama2="'.$nama_barang->harga_unit.'"  class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-check"></i></a> ';
                    })
                    ->rawColumns(['add'])
                    ->make(true);
                }else{
                    $nama_barang = DB::select( DB::raw("SELECT kode_barang,nama_barang,harga FROM master_nonmedis") );
                    return DataTables::of($nama_barang)
                    
                    ->addColumn('add', function ($nama_barang) {
                        return ' <a href="#" data-kode="'.$nama_barang->kode_barang.'"  data-nama="'.$nama_barang->nama_barang.'" data-nama2="'.$nama_barang->harga.'" class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-check"></i></a> ';
                    })
                    ->rawColumns(['add'])
                    ->make(true);
                }
        }
        public function SimpanItemobat(Request $request)
        {
                    $cek_barang = Tbdetailpurchase::where('dpo_no_purchaseorder',$request['no_po'])->where('dpo_item_id',$request['kode_barang'])->first();
                    if($cek_barang==null){
                        $item = new Tbdetailpurchase();
                        $item->dpo_id = $request['po_id'];
                        $item->dpo_no_purchaseorder = $request['no_po'];
                        $item->dpo_item_id = $request['kode_barang'];
                        $item->dpo_item_name = $request['nama_barang'];
                        $item->dpo_pbf = $request['suplier'];
                        $item->dpo_price = $request['dpo_price'];
                        $item->dpo_qty = $request['dpo_qty'];
                        $item->dpo_item_unit = $request['dpo_item_unit'];
                        $item->dpo_qty_unit = $request['dpo_qty_unit'];
                        $item->dpo_conv_unit = $request['dpo_conv_unit'];
                        $item->dpo_total_price = $request['dpo_price']*$request['dpo_qty'];
                        
                        $item->save();
                        

                        return response()->json(['sukses'=>true]);
                    }else{
                        return response()->json(['sukses'=>false, 'message'=>'Obat sudah pernah ditambahkan, silahkan cek atau ganti obat lain']);
                    }
        }

        public function depoDetailobat($po_id)
        {
            DB::statement(DB::raw('set @rownum=0'));
                $detail = Tbdetailpurchase::select([
                DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'id',
                'dpo_no_purchaseorder',
                'dpo_item_id',
                'dpo_item_name',
                'dpo_pbf',
                'dpo_qty',
                'dpo_price',
                'dpo_total_price',
            ])->where('dpo_id', $po_id)->get();
            return DataTables::of($detail)
                    
                    ->addColumn('delete', function ($detail) {
                        return ' <a href="#" data-id="'.$detail->id.'" class="btn btn-sm btn-danger btn-flat hapus"><i class="fa fa-trash"></i></a> ';
                    })
                    
                    ->rawColumns(['delete'])
                    ->make(true);
        }
        public function depoKirimOrder($id)
        {
                DB::table('tb_purchase')->where('po_no_purchaseorder',$id)->update([
                    'po_status' => 'Pending',
                    
                ]);
                   
                return redirect('/gudang/po-obat');
                    
                
        }
        public function updateDepoOrderobat($id)
        {
                $po = Tbpurchase::where('po_id', $id)->where('po_status', 'Draft')->first();
                if($po!=null){
                    $data = [
                        'po_id' => $po->po_id,
                        'no_po' => $po->po_no_purchaseorder,
                        'tanggal' => $po->po_tanggal_pemesanan,
                        'kategori' => $po->po_kategori_order,
                        'user_create' => $po->po_nama_pemohon,
                        'catatan' => $po->po_catatan,
                        'status' => $po->po_status
                    ];
                    return view('logistik/logistik/po.order', $data);
                }else{
                    return redirect('/gudang-obat');
                }
        }
        public function DepoDelete($id)
        {   
                if(DB::table('tb_detail_purchase')->where('id',$id)->delete()){
                    return response()->json(['sukses' => true]);
                }else{
                    return response()->json(['sukses' => false]);
                }
            }
        // penerimaan =====================================================================

        public function list_po()
        {
                $nama_barang = DB::select( DB::raw("
                SELECT 
                tb_purchase.po_no_purchaseorder,tb_purchase.po_supplier,tb_purchase.po_tanggal_pemesanan,
                master_produsen_inv.nama_produsen,SUM(tb_detail_purchase.dpo_total_price) AS total
                FROM tb_purchase 
                JOIN master_produsen_inv ON master_produsen_inv.id_produsen = tb_purchase.po_supplier
                JOIN tb_detail_purchase ON tb_detail_purchase.dpo_no_purchaseorder = tb_purchase.po_no_purchaseorder
                WHERE tb_purchase.po_status = 'pending'
		        GROUP BY tb_purchase.po_no_purchaseorder
                ") );
                return DataTables::of($nama_barang)
                ->addColumn('total_harga', function ($nama_barang) {
                    return 'Rp. '.number_format($nama_barang->total);
                })
                ->addColumn('add', function ($nama_barang) {
                    return ' <a href="/gudang/penerimaan-obat/order/'.$nama_barang->po_no_purchaseorder.'"  class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-check"></i></a> ';
                })
                ->rawColumns(['add','total_harga'])
                ->make(true);
        }
        public function list_faktur()
        {
                $nama_barang = Tbpenerimaan::select(
                    'no_po','no_faktur','tanggal'
                )->get();
                return DataTables::of($nama_barang)
                
                
                ->make(true);
        }
        public function penerimaan_obat()
        {   
           // $data['list_faktur'] = Tbpurchase::join('tb_penerimaan','tb_penerimaan.no_po','=','tb_purchase.po_no_purchaseorder')
             //                    ->get();
            $data['list_faktur'] = DB::select( DB::raw("SELECT tb_penerimaan.no_po,tb_penerimaan.no_faktur,tb_purchase.po_tanggal_pemesanan,tb_penerimaan.tanggal AS tanggal_terima,
            SUM(tb_detail_faktur.harga*tb_detail_faktur.jumlah_diterima) AS total,tb_purchase.po_status
            FROM tb_penerimaan
            INNER JOIN tb_purchase ON  tb_purchase.po_no_purchaseorder = tb_penerimaan.no_po
            INNER JOIN tb_detail_faktur ON  tb_detail_faktur.no_faktur = tb_penerimaan.no_faktur
            WHERE tb_purchase.po_status = 'Selesai'
            GROUP BY tb_penerimaan.no_po  "));
            // return $data['list_faktur'];
            return view('/logistik/logistik/penerimaan.index',$data)->with('no',1);
        }

        public function depopenerimaan(Request $request,$id)
        {   $data['datapo'] = Tbpurchase::where('po_no_purchaseorder',$id)->first();
            $data['totalitem'] = Tbdetailpurchase::where('dpo_no_purchaseorder',$id)->count();
            $cek = Tbpenerimaan::where('no_po',$id)->count();
            if($cek>0){
            $penerimaan =  Tbpenerimaan::where('no_po',$id)->first();
            $penerimaan_po = Tbdetailpenerimaan::where('no_faktur',$penerimaan->no_faktur)->get();
            return view('/logistik/logistik/penerimaan.order',$data,compact('penerimaan','penerimaan_po','cek'));    
            }else{
            $penerimaan =  Tbpenerimaan::where('no_po',$id)->first();
            return view('/logistik/logistik/penerimaan.order',$data,compact('penerimaan','cek'));
            }
            
            
        }
        public function addItemDepopenerimaan(Request $request,$id)
        {   $cek = Tbpenerimaan::where('no_po',$id)->count();
            $data['datapo'] = Tbpurchase::where('po_no_purchaseorder',$id)->first();
            $data['totalitem'] = Tbdetailpurchase::where('dpo_no_purchaseorder',$id)->count();
            $purchase = Tbpurchase::where('po_no_purchaseorder',$id)->first();
            $cek_data = Tbpenerimaan::where('no_po',$id)->count();
            if($cek_data<=0){
            request()->validate([
                'no_faktur' => 'required',
                
            ]);
            Tbpenerimaan::create([
                'no_faktur' => $request->no_faktur,
                'no_po' => $id,
                'no_batch' => $request->no_batch,
                'tanggal' => $request->tanggal,
                'nama_penerima' => $purchase->po_nama_pemohon,
                'supplier' => $purchase->po_supplier,
                'tanggal_pembayaran'=>$request->tanggal_pembayaran
            ]);
            $penerimaan =  Tbpenerimaan::where('no_po',$id)->first();
            
            }else{
            $penerimaan =  Tbpenerimaan::where('no_po',$id)->first();
            }
            $detailpurchase = Tbdetailpurchase::where('dpo_no_purchaseorder',$id)->get();
            // input data pesanan ke detail faktur
            foreach($detailpurchase as $detail)
            {
                $cek=Tbdetailpenerimaan::where('no_faktur',$penerimaan->no_faktur)->where('kode',$detail->dpo_item_id)->count();
                if($cek<1){
                Tbdetailpenerimaan::create([
                    'no_faktur' => $penerimaan->no_faktur,
                    'kode'=>$detail->dpo_item_id,
                    'nama_obj'=>$detail->dpo_item_name,
                    'jumlah'=>$detail->dpo_qty,
                    'harga'=>$detail->dpo_price,
                    ]); 
            }}
            $penerimaan_po = Tbdetailpenerimaan::where('no_faktur',$penerimaan->no_faktur)->get();
            $penerimaan = Tbpenerimaan::where('no_faktur',$penerimaan->no_faktur)->first();
            
            if ($request['lanjut']) {
                return view('/logistik/logistik/penerimaan.order',$data,compact('cek','penerimaan','penerimaan_po'))->with('no', 1);
              }
            if ($request['update']) {
               
                Tbpenerimaan::where('no_po',$id)->update([
                    
                    
                    'no_batch' => $request->no_batch,
                    'tanggal' => $request->tanggal,
                    'tanggal_pembayaran'=>$request->tanggal_pembayaran
                ]);
                $penerimaan =  Tbpenerimaan::where('no_po',$id)->first();
                $penerimaan_po = Tbdetailpenerimaan::where('no_faktur',$penerimaan->no_faktur)->get();
                return view('/logistik/logistik/penerimaan.order',$data,compact('cek','penerimaan','penerimaan_po'))->with('no', 1);
              }
           
        }
        public function pdfpo_laporan_penerimaan($id)
        {   
            $config = Config::where('id','1')->first();
            $data['penerimaan'] = Tbpenerimaan::join('master_produsen_inv','master_produsen_inv.id_produsen','=','tb_penerimaan.supplier')->where('tb_penerimaan.no_po',$id)->first();
            $data['detail_faktur'] = Tbdetailpenerimaan::where('tb_detail_faktur.no_faktur',$data['penerimaan']->no_faktur)->get();
            $pemohon = Tbpurchase::where('po_no_purchaseorder',$data['penerimaan']->no_po)->first();
            
            $no=1;
            //$pdf = PDF::loadView('/logistik/logistik/penerimaan.pdfpo_obat', $data,compact('no'))->setPaper('a4', 'portrait');
            
            $pdf = PDF::loadView('/logistik/logistik/penerimaan.pdfpo_obat', $data,compact('no','config','pemohon'),[
                'format' => 'legal-P']);
            $pdf->showWatermarkImage = true;
            return $pdf->stream();
            //return view('/logistik/logistik/po.index',$data)->with('no',1);
        }
        public function pdfpo_retur_penerimaan($id)
        {   
            
            $config = Config::find(1);
            $data['penerimaan'] = Tbpenerimaan::join('master_produsen_inv','master_produsen_inv.id_produsen','=','tb_penerimaan.supplier')->where('tb_penerimaan.no_po',$id)->first();
            $data['detail_faktur'] = Tbdetailpenerimaan::where('no_faktur',$data['penerimaan']->no_faktur)->where('selisih','>',0)->get();
            $pemohon = Tbpurchase::where('po_no_purchaseorder',$data['penerimaan']->no_po)->first();
            $cekretur = Tbdetailpenerimaan::where('selisih','>',0)->count();
            $cek1 = Tbretur::where('no_faktur',$data['penerimaan']->no_faktur)->count();
            
            if($cekretur>0 && $cek1<1)
            {
                Tbretur::create([
                    'no_retur'=>'RTO'.date('YmdHis'),
                    'no_faktur'=>$data['penerimaan']->no_faktur,
                    'supplier'=>$data['penerimaan']->supplier,
                    'petugas'=>$data['penerimaan']->nama_penerima,
                    'tanggal'=>date('YmdHis'),
                ]);
            }
            $cek_awal = Tbretur::where('no_faktur',$data['penerimaan']->no_faktur)->first();
            $cekdetailretur = Tbdetailretur::where('no_retur',$cek_awal->no_retur)->count();
            $cekk = Tbretur::where('no_retur',$cek_awal->no_retur)->where('no_faktur',$data['penerimaan']->no_faktur)->first();
            if($cekdetailretur<=0)
            { 
                foreach($data['detail_faktur'] as $data)
                {
                    Tbdetailretur::create([
                        'no_retur'=>$cek_awal->no_retur,
                        'kode'=>$data->kode,
                        'nama_obj'=>$data->nama_obj,
                        'jumlah'=>$data->selisih,
                        'harga'=>$data->harga,
                        'total_harga'=>$data->harga*$data->selisih,
                        'keterangan'=>$data->keterangan,
                    ]); 
                }
                $sub_harga= Tbdetailretur::where('no_retur',$cek_awal->no_retur)->sum('total_harga');
                //$data_awal=Tbdetailretur::where('no_retur',$cekk->no_retur)->where('kode',$data->kode)->first();
                Tbretur::where('no_retur',$cek_awal->no_retur)->update([
                    'sub_harga'=>$sub_harga,
                    'materai'=>6000,
                    'ppn'=>$sub_harga*10/100,
                    'total_harga'=>$sub_harga+6000+$sub_harga*10/100
                ]); 
               // $data['detail_retur'] = Tbdetailretur::join('tb_detail_retur','tb_detail_retur.no_retur','=','tb_retur.no_retur')->where('tb_retur.no_retur','RTO'.date('YmdHis'))->select(,)->get();
               
            }
            $data['retur'] = Tbretur::where('no_retur',$cek_awal->no_retur)->first();
            $data['detail_retur'] = Tbdetailretur::where('no_retur',$cek_awal->no_retur)->where('harga','>',0)->get();  
            
            $no=1;
            //$pdf = PDF::loadView('/logistik/logistik/penerimaan.pdfpo_obat', $data,compact('no'))->setPaper('a4', 'portrait');
            $pdf = PDF::loadView('/logistik/logistik/retur.pdfretur_barang', $data,compact('no','config'));
            return $pdf->stream();
            //return view('/logistik/logistik/po.index',$data)->with('no',1);
        }
        public function get_po_obat()
        {
                $nama_barang = DB::select( DB::raw("
                SELECT id_obat,nama_obat,supplier,satuan_besar,satuanjual FROM ref_obat_all
                ") );
                return DataTables::of($nama_barang)
                
                ->addColumn('add', function ($nama_barang) {
                    return ' <a href="#" data-kode="'.$nama_barang->id_obat.'"  data-nama="'.$nama_barang->nama_obat.'" data-nama1="'.$nama_barang->supplier.'" class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-check"></i></a> ';
                })
                ->rawColumns(['add'])
                ->make(true);
        }
        public function simpanItemDepopenerimaan(Request $request)
        {   
            $cek = Tbdetailpenerimaan::where('id',$request->id)->first();
            
                DB::table('tb_detail_faktur')->where('id',$request->id)->update([
                
                    'jumlah_diterima'=>$request->jumlah,
                    'expired'=>$request->expired,
                    'keterangan'=>$request->keterangan,
                    'selisih'=>$cek->jumlah-$request->jumlah,
                ]);
            
            return response()->json(['success'=>1]);
         }
         public function get_detail_faktur($id)
        {       
                $detail_faktur = DB::select( DB::raw("
                SELECT id,kode,nama_obj,jumlah,jumlah_diterima,selisih,keterangan FROM tb_detail_faktur where no_faktur=".$id) );
                return DataTables::of($detail_faktur)
                
                ->addColumn('add', function ($detail_faktur1) {
                    return ' <a href="#" data-kode="'.$detail_faktur1->id.'"  data-nama="'.$detail_faktur1->jumlah_diterima.'"  data-toggle="modal" data-target="#modaljumlah" class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-check"></i></a> ';
                })
                ->rawColumns(['add'])
                ->make(true);
        }
        public function selesai_penerimaan($id)
        {   //update 1 tabel purchase / laporan po
            DB::table('tb_purchase')->where('po_no_purchaseorder',$id)->update([
                'po_status'=>'Selesai',
            ]);
            //input barang ke tabel stok gudang obat/inv/nonmedis 
            $cek_kategori_barang = Tbpurchase::where('po_no_purchaseorder',$id)->first();
            if($cek_kategori_barang->po_kategori_order=='inventaris'){
            $cek_faktur = Tbdetailpenerimaan::join('tb_penerimaan','tb_penerimaan.no_faktur','=','tb_detail_faktur.no_faktur')
            ->where('tb_penerimaan.no_po',$id)->get();
            foreach($cek_faktur as $data)
            {
                $data_awal = Inventarisglobal::where('kode_barang',$data->kode)->first();
                DB::table('inventaris_global')->where('kode_barang',$data->kode)->update([
                    'jumlah_barang'=>$data_awal->jumlah_barang+$data->jumlah_diterima,
                ]);        
            }
            
            }elseif($cek_kategori_barang->po_kategori_order=='obat'){
            $cek_faktur = Tbdetailpenerimaan::join('tb_penerimaan','tb_penerimaan.no_faktur','=','tb_detail_faktur.no_faktur')
            ->where('tb_penerimaan.no_po',$id)->select('tb_penerimaan.no_po','tb_detail_faktur.*')->get();
            foreach($cek_faktur as $data)
            {
                $data_awal = Stokobat::where('kode_obat',$data->kode)->first();
                if($data_awal==null)
                {   
                    foreach(Tbdetailpurchase::where('dpo_no_purchaseorder',$data->no_po)->where('dpo_item_id',$data->kode)->get() as $data2)
                    {
                    if($data2->dpo_no_purchaseorder==$data->no_po && $data2->dpo_item_id==$data->kode)
                    {
                        $harga = $data->harga/$data->jumlah_diterima/$data2->dpo_qty_unit;
                        DB::table('tb_stok_obat')->insert([
                        'no_faktur'=> $data->no_faktur,
                        'kode_obat'=>$data->kode,
                        'nama_obj'=>$data->nama_obj,
                        'expired'=>$data->expired,
                        'satuan'=>$data2->dpo_conv_unit,
                        'harga'=>$harga,
                        'stok'=>$data->jumlah_diterima*$data2->dpo_qty_unit,
                    ]);}else{}
                    
                    }        
                }else{
                    
                    foreach(Tbdetailpurchase::where('dpo_no_purchaseorder',$data->no_po)->where('dpo_item_id',$data->kode)->get() as $data2)
                    {
                    if($data2->dpo_no_purchaseorder==$data->no_po && $data2->dpo_item_id==$data->kode)
                    {
                        $harga = $data->harga/$data->jumlah_diterima/$data2->dpo_qty_unit;
                        DB::table('tb_stok_obat')->where('kode_obat',$data->kode)->update([
                        'harga'=>$harga,'expired'=>$data->expired,
                        'stok'=>$data_awal->stok+$data->jumlah_diterima*$data2->dpo_qty_unit,
                    ]);}else{}
                    
                    }    
                    
                }
            }
            }elseif($cek_kategori_barang->po_kategori_order=='nonmedis'){
                $cek_faktur = Tbdetailpenerimaan::join('tb_penerimaan','tb_penerimaan.no_faktur','=','tb_detail_faktur.no_faktur')
                ->where('tb_penerimaan.no_po',$id)->get();
                foreach($cek_faktur as $data)
                {
                    $data_awal = Masternonmedis::where('kode_barang',$data->kode)->first();
                    DB::table('master_nonmedis')->where('kode_barang',$data->kode)->update([
                        'stok'=>$data_awal->stok+$data->jumlah_diterima,
                    ]);        
                }
            }
            return redirect('/gudang/penerimaan-obat');
        }
        //laporan penerimaan
        public function pdf_laporan()
        {   
            $config = Config::where('id','1')->first();
            $data['kategori'] = Tbpurchase::select('po_kategori_order')->groupBy('po_kategori_order')->get();
            $data['total_harga'] = DB::select( DB::raw("SELECT 
            SUM(tb_detail_faktur.harga*tb_detail_faktur.jumlah_diterima) AS total
            FROM tb_purchase
            INNER JOIN tb_penerimaan ON tb_penerimaan.no_po = tb_purchase.po_no_purchaseorder
            INNER JOIN tb_detail_faktur ON tb_detail_faktur.no_faktur = tb_penerimaan.no_faktur
            "));
             
            $data['tampil'] = DB::select( DB::raw("SELECT tb_penerimaan.no_faktur, tb_penerimaan.tanggal,tb_detail_faktur.nama_obj,tb_detail_faktur.jumlah_diterima,
            (tb_detail_faktur.harga*tb_detail_faktur.jumlah_diterima) AS total,
            tb_purchase.po_kategori_order,tb_detail_faktur.harga
            FROM tb_purchase
            INNER JOIN tb_penerimaan ON tb_penerimaan.no_po = tb_purchase.po_no_purchaseorder
            INNER JOIN tb_detail_faktur ON tb_detail_faktur.no_faktur = tb_penerimaan.no_faktur
            "));

            $no=1;
            $pdf = PDF::loadView('/logistik/logistik/penerimaan.pdflaporan_penerimaan', $data,compact('no','config'),[
                'format' => 'legal-L']);
         
            return $pdf->stream();
            //$no=1;
            //$pdf = PDF::loadView('/logistik/logistik/penerimaan.pdfpo_obat', $data,compact('no'))->setPaper('a4', 'portrait');
            //return $data['tampil'];
            //$pdf = PDF::loadView('/logistik/logistik/penerimaan.pdflaporan_penerimaan', $data,compact('no','config'))->setPaper('a4', 'landscape');
            //return $pdf->stream();
            //return view('/logistik/logistik/po.index',$data)->with('no',1);
        }
        // dist obat dari gudang
        public function dist_obat()
        {
            return view('logistik/order_obat.index_gudang');
        }
        public function detail_dist_obat($id)
        {   
            $list_po= Podetail::where('no_po',$id)->get();
            $Po = Po::where('no_po',$id)->first();
            $list_po1= Podetail::where('no_po',$id)->select('kode_item')->get();
            
            return view('logistik/order_obat.detail',compact('Po','id','list_po','list_po1'))->with('no',1);
        }
        public function update()
        {
            $data_awal = Masterobat::all();
            foreach($data_awal as $data)
            {
                Masterobatall::where('id_obat',$data->kode)->update([
                    'object_name'=>$data->nama,
                    'nama_obat'=>$data->nama,
                ]);
                Stokobat::where('kode_obat',$data->kode)->update([
                    'nama_obj'=>$data->nama,
                    
                ]);
            }
            return view('logistik/order_obat.index_gudang');
        }  
        public function simpanItempoobat(Request $request)
        {   
            $data_master = Masterobatall::where('id_obat',$request->kode_item_pemberian)->first();
            $cek = Tbstokobat::where('kode_obat',$request->kode_item_pemberian)->count();
            $stok = Tbstokobat::where('kode_obat',$request->kode_item_pemberian)->first();
            if($cek<1)
            {
            $data_awal = Podetail::where('id',$request->id)->first();
            Flashy::info('Stok Di Gudang Habis');
            return redirect('/gudang/dist-obat/detail/'.$data_awal->no_po);
            }else
            {
            
            $data_awal = Podetail::where('id',$request->id)->first();
            if($request->jumlah_pemberian<=$stok->stok)
            {    
                DB::table('farmasi_po_detail')->where('id',$request->id)->update([
                    'kode_item_pemberian'=>$request->kode_item_pemberian,
                    'nama_item_pemberian'=>$data_master->nama_obat,
                    'jumlah_pemberian'=>$request->jumlah_pemberian,
                ]);
            Flashy::success('data berhasil di input');
            return redirect('/gudang/dist-obat/detail/'.$data_awal->no_po);
            }else
            {
            Flashy::info('Permintanan lebih dari stok gudang');
            return redirect('/gudang/dist-obat/detail/'.$data_awal->no_po);
            }
            }
         }
         public function resetItempoobat($id)
         {      
            $data_awal = Podetail::where('id',$id)->first();
            $po = $data_awal->no_po;
                DB::table('farmasi_po_detail')->where('id',$id)->update([
                    'kode_item_pemberian'=>null,
                    'nama_item_pemberian'=>null,
                    'jumlah_pemberian'=>null,
                ]);
            
            return redirect('/gudang/dist-obat/detail/'.$po);
         }
         public function deleteItempoobat($id)
         {      
            $data_awal = Podetail::where('id',$id)->first();
            $po = $data_awal->no_po;
                DB::table('farmasi_po_detail')->where('id',$id)->delete();
            
            return redirect('/gudang/dist-obat/detail/'.$po);
          }
          public function tambahItempoobat(Request $request,$id)
          {      
            $data_awal = Po::where('id',$id)->first();
            $data_master = Masterobatall::where('id_obat',$request->kode_item_pemberian)->first();
            
            $po = $data_awal->no_po;
                DB::table('farmasi_po_detail')->insert([
                    'po_id'=>$id,
                    'no_po'=>$data_awal->no_po,
                    'kode_item'=>$request->kode_item_pemberian,
                    'nama_item'=>$data_master->nama_obat,
                    'jumlah'=>0,
                    'kode_item_pemberian'=>$request->kode_item_pemberian,
                    'nama_item_pemberian'=>$data_master->nama_obat,
                    'jumlah_pemberian'=>$request->jumlah_pemberian,
                    'satuan'=>$data_master->tipe_sediaan
                ]);
            
            return redirect('/gudang/dist-obat/detail/'.$po);
          }
          public function selesaiItempoobat($id)
          {      
            $data_awal = Po::where('no_po',$id)->first();
            DB::table('farmasi_po')->where('no_po',$id)->update([
                'tgl_penerimaan'=>date('Ymd'),
                'status'=>'Selesai',
            ]);
            DB::table('tb_lplpo')->where('no_po',$id)->update([
                'status'=>'Selesai',
            ]);
            
            $data_list = Podetail::where('no_po',$id)->get();
            foreach($data_list as $data)
            {
                DB::table('tb_detail_lplpo')->where('kode_obat',$data->kode_item)->update([
                    'kode_obat_pemberian'=>$data->kode_item_pemberian,
                    'nama_obj_pemberian'=>$data->nama_item_pemberian,
                    'pemberian'=>$data->jumlah_pemberian,
                    'permintaan'=>$data->jumlah,
                ]);
                $data_obat_awal= Masterobat::where('kode',$data->kode_item)->first();    
                Masterobat::where('kode',$data->kode_item)->update([
                    'stok'=> $data_obat_awal['stok'] + $data->jumlah_pemberian,
                ]);

            }
            return redirect('/gudang/dist-obat');
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
                }elseif($po->status=="Pending"){
                    $btn_edit = '<a href="/gudang/dist-obat/detail/'.$po->no_po.'" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-pencil"> </i></a>';
                }elseif($po->status=="Selesai"){
                    $btn_edit = '<a href="#" data-id="'.$po->id.'" class="btn btn-sm btn-primary btn-flat view"><i class="fa fa-table"> </i></a>';
                }
                return $btn_edit;
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

          //////////////////////////////////////////////////////////////////////////////////////////

          // permintaan Non medis
        public function depononIndex()
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
                return view('depo/depononmedis.index', $data);
        }
        public function dataDepononmedis($value='')
        {
                $depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
                if(Auth::user()->role()->first()->name=="apotik"){
                    DB::statement(DB::raw('set @rownum=0'));
                    $po = Depononmedis::select([
                        DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                        'id',
                        'id_depo',
                        'no_po',
                        'tanggal',
                        'tgl_penerimaan',
                        'user_create',
                        'status',
                        ])->where('supplier','Logistik')->whereIn('status',['Pending','Selesai'])->orderBy('id','DESC')->get();
                }elseif(Auth::user()->role()->first()->name=="supervisor-apotik"){
                    DB::statement(DB::raw('set @rownum=0'));
                    $po = Depononmedis::select([
                        DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                        'id',
                        'id_depo',
                        'no_po',
                        'tanggal',
                        'tgl_penerimaan',
                        'user_create',
                        'status',
                        ])->where('supplier','Logistik')->whereIn('status',['Pending','Selesai'])->orderBy('id','DESC')->get();
                }elseif(Auth::user()->role()->first()->name=="administrator"){
                    DB::statement(DB::raw('set @rownum=0'));
                    $po = Depononmedis::select([
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
                    $po = Depononmedis::select([
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
                            $btn_edit = '<a href="depo-order-inv/'.$po->id.'" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-pencil"> </i></a>';
                        }
                        return '<a href="#" data-id="'.$po->id.'" class="btn btn-sm btn-primary btn-flat view"><i class="fa fa-table"> </i></a>'.$btn_edit;
                    })
                    ->rawColumns(['aksi','status'])
                    ->make(true);    
        }
        public function depoOrdernonmedis()
        {
            $data['supplier'] = 0;
           
            return view('depo/depononmedis.order', $data);
        }

        public function addItemDepononmedis(Request $request)
        {
                request()->validate([
                        'tanggal' => 'required'
                ]);
                $depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
                
                $cek = Depononmedis::where('id_depo',$depo->id)->where('supplier', $request['distributor'])->where('tanggal', valid_date($request['tanggal']))->count();
                if($cek <= 0) {
                        $po = new Depononmedis();
                        $po->id_depo = $depo->id;
                        $po->no_po = 'DEPONM'.date('YmdHis');
                        $po->supplier = $request['distributor'];
                        $po->status = 'Draft';
                        $po->tanggal = valid_date($request['tanggal']);
                        $po->catatan = $request['catatan'];
                        $po->tgl_penerimaan = null;
                        $po->user_create = Auth::user()->name;
                        $po->save();
                        
                } else {
                        $po = Depononmedis::where('supplier', $request['distributor'])->where('tanggal', valid_date($request['tanggal']))->first();
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
                $data['masterruangan'] = Masterruangan::all();
                return view('depo/depononmedis.order', $data);
        }

        public function depoMasterNonmedis()
        {
                $depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
                $nama_barang = DB::select( DB::raw("SELECT * 
                FROM master_nonmedis") );
                return DataTables::of($nama_barang)
                ->addColumn('jumlah', function ($nama_barang) {
                    return ''.$nama_barang->stok.'';
                })
                ->addColumn('add', function ($nama_barang) {
                    return ' <a href="#" data-kode="'.$nama_barang->kode_barang.'"  data-nama="'.$nama_barang->nama_barang.'" data-satuan="'.$nama_barang->satuan.'" class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-check"></i></a> ';
                })
                ->rawColumns(['add','jumlah'])
                ->make(true);
        }
        public function depoSimpanItemnonmedis(Request $request)
        {
           
                $cek_stok	= Masternonmedis::where('kode_barang',$request['kode_barang'])->first();
                if($cek_stok->stok < $request['jumlah_barang']){
                    return response()->json(['sukses'=>false, 'message'=>'Stok tidak cukup']);
                }else{
                    $cek_barang = Depodetailnonmedis::where('no_po',$request['no_po'])->where('kode_barang',$request['kode_barang'])->first();
                    if($cek_barang==null){
                        $item = new Depodetailnonmedis();
                        $item->po_id = $request['po_id'];
                        $item->no_po = $request['no_po'];
                        $item->kode_barang = $request['kode_barang'];
                        $item->nama_barang = $request['nama_barang'];
                        $item->jumlah = $request['jumlah_barang'];
                        $item->ruangan = $request['ruangan'];
                        $item->save();
                       
                        return response()->json(['sukses'=>true]);
                    }else{
                        return response()->json(['sukses'=>false, 'message'=>'Barang sudah pernah ditambahkan, silahkan cek atau ganti obat lain']);
                    }
                }
            
        }
        public function depoDetailnonmedis($po_id)
        {
            DB::statement(DB::raw('set @rownum=0'));
                $detail = Depodetailnonmedis::join('master_ruangan','master_ruangan.id','=','depo_po_nonmedis_detail.ruangan')->select([
                DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'depo_po_nonmedis_detail.id',
                'depo_po_nonmedis_detail.po_id',
                'depo_po_nonmedis_detail.no_po',
                'depo_po_nonmedis_detail.kode_barang',
                'depo_po_nonmedis_detail.nama_barang',
                'depo_po_nonmedis_detail.jumlah',
                'depo_po_nonmedis_detail.kode_barang_pemberian',
                'depo_po_nonmedis_detail.nama_barang_pemberian',
                'depo_po_nonmedis_detail.jumlah_pemberian',
                'master_ruangan.ruangan as nama_ruang'
            ])->where('po_id', $po_id)->get();
            return DataTables::of($detail)
                    ->addColumn('jumlah_pemberian', function ($detail) {
                        $depopo = Depononmedis::where('id', $detail->po_id)->first();
                        $depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
                        if($depo==null AND $depopo->status=='Pending'){
                            return '<input type="number" onkeyup="updatePemberian(this.value,\''.$detail->no_po.'\',\''.$detail->kode_barang.'\')" class="form-control" id="jumlah_pemberian" oname="jumlah_pemberian[]" value="'.$detail->jumlah_pemberian.'">';
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
        public function DepoDeletenonmedis($id)
        {
                $item = Depodetailnonmedis::where('id', $id)->first();
                    
                if($item->delete()){
                    return response()->json(['sukses' => true]);
                }else{
                    return response()->json(['sukses' => false]);
                }
        }
        public function dataDepoDetailnonmedis($id)
        {
                $po = Depononmedis::where('id', $id)->first();
                $detail = Depodetailnonmedis::where('po_id', $po->id)->get();
                $data = [
                    'po' => $po,
                    'distributor' => 'Logistik',
                    'tanggal' => tgl_indo($po->tanggal),
                    'detail' => $detail,
                ];
                return response()->json($data);
        }
        public function updateDepoOrdernonmedis($id)
        {
                $po = Depononmedis::where('id', $id)->where('status', 'Draft')->first();
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
                    return view('depo/depononmedis.order', $data);
                }else{
                    return redirect('depo-nonmedis');
                }
        }
        public function depoKirimOrdernonmedis($id)
        {
                $po = Depononmedis::where('id', $id)->where('status', 'Draft')->first();
                if($po!=null){
                    $po->status = 'Pending';
                    
                    if($po->save()){
                        return redirect('depo-order-nonmedis/'.$id);
                    }else{
                        return redirect('depo-nonmedis');
                    }
                }else{			
                    return redirect('depo-nonmedis');
                }
        }

         // dist Non Medis dari gudang
         public function dist_nonmedis()
         {
             return view('logistik/order_nonmedis.index_gudang');
         }
         public function detail_dist_nonmedis($id)
         {   
             $list_po= Depodetailnonmedis::where('no_po',$id)->get();
             $Po = Depononmedis::where('no_po',$id)->first();
             $list_po1= Depodetailnonmedis::where('no_po',$id)->select('kode_barang')->get();
             
             return view('logistik/order_nonmedis.detail',compact('Po','id','list_po','list_po1'))->with('no',1);
         }

         public function dataPOdetailnonmedis($id)
          {
            DB::statement(DB::raw('set @rownum=0'));
            $po = Depodetailnonmedis::join('master_nonmedis','master_nonmedis.kode_barang','=','depo_po_nonmedis_detail.kode_barang')
            ->select([
                DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'depo_po_nonmedis_detail.id',
                'depo_po_nonmedis_detail.kode_barang',
                'depo_po_nonmedis_detail.nama_barang',
                'depo_po_nonmedis_detail.jumlah',
                'depo_po_nonmedis_detail.kode_barang_pemberian',
                'depo_po_nonmedis_detail.nama_barang_pemberian',
                'depo_po_nonmedis_detail.jumlah_pemberian',
                'master_nonmedis.satuan'
            ])
            ->where('depo_po_nonmedis_detail.po_id',$id)->orderBy('id','DESC')->get();
        
            return DataTables::of($po)
           
            ->make(true);
          }

         public function dataPOnonmedis($value='')
          {
            DB::statement(DB::raw('set @rownum=0'));
            $po = Depononmedis::select([
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
                }elseif($po->status=="Pending"){
                    $btn_edit = '<a href="/gudang/dist-nonmedis/detail/'.$po->no_po.'" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-pencil"> </i></a>';
                }elseif($po->status=="Selesai"){
                    $btn_edit = '<a href="#" data-id="'.$po->id.'" class="btn btn-sm btn-primary btn-flat view"><i class="fa fa-table"> </i></a>';
                }
                return $btn_edit;
            })
            ->rawColumns(['aksi'])
            ->make(true);
          }
          public function dataDetailPOnonmedis($id)
          {
                $po = Depononmedis::where('id', $id)->first();
                $detail = Podetail::where('po_id', $po->id)->get();
                $data = [
                        'po' => $po,
                        'distributor' => 'Logistik',
                        'tanggal' => tgl_indo($po->tanggal),
                        'detail' => $detail,
                ];
                return response()->json($data);
          }
          public function simpanItempononmedis(Request $request)
          {   
            $data_master = Masternonmedis::where('kode_barang',$request->kode_item_pemberian)->first();
            $data_awal = Depodetailnonmedis::where('id',$request->id)->first();
                DB::table('depo_po_nonmedis_detail')->where('id',$request->id)->update([
                    'kode_barang_pemberian'=>$request->kode_item_pemberian,
                    'nama_barang_pemberian'=>$data_master->nama_barang,
                    'jumlah_pemberian'=>$request->jumlah_pemberian,
                ]);
            
            return redirect('/gudang/dist-nonmedis/detail/'.$data_awal->no_po);
          }
          public function tambahItempononmedis(Request $request,$id)
          {      
            $data_awal = Depononmedis::where('id',$id)->first();
            $data_master = Masternonmedis::where('kode_barang',$request->kode_item_pemberian)->first();
            
            $po = $data_awal->no_po;
            if($request->jumlah_pemberian>$data_master->stok){
                DB::table('depo_po_nonmedis_detail')->insert([
                    'po_id'=>$id,
                    'no_po'=>$data_awal->no_po,
                    'kode_barang'=>$request->kode_item_pemberian,
                    'nama_barang'=>$data_master->nama_barang,
                    'jumlah'=>0,
                    'kode_barang_pemberian'=>$request->kode_item_pemberian,
                    'nama_barang_pemberian'=>$data_master->nama_barang,
                    'jumlah_pemberian'=>$data_master->stok,
               
                ]);
            }else{
                DB::table('depo_po_nonmedis_detail')->insert([
                    'po_id'=>$id,
                    'no_po'=>$data_awal->no_po,
                    'kode_barang'=>$request->kode_item_pemberian,
                    'nama_barang'=>$data_master->nama_barang,
                    'jumlah'=>0,
                    'kode_barang_pemberian'=>$request->kode_item_pemberian,
                    'nama_barang_pemberian'=>$data_master->nama_barang,
                    'jumlah_pemberian'=>$request->jumlah_pemberian,
               
                ]);
            }
            return redirect('/gudang/dist-nonmedis/detail/'.$po);
          }
          public function resetItempononmedis($id)
         {      
            $data_awal = Depodetailnonmedis::where('id',$id)->first();
            $po = $data_awal->no_po;
                DB::table('depo_po_nonmedis_detail')->where('id',$id)->update([
                    'kode_barang_pemberian'=>null,
                    'nama_barang_pemberian'=>null,
                    'jumlah_pemberian'=>null,
                ]);
            
            return redirect('/gudang/dist-nonmedis/detail/'.$po);
         }
         public function deleteItempononmedis($id)
         {      
            $data_awal = Depodetailnonmedis::where('id',$id)->first();
            $po = $data_awal->no_po;
                DB::table('depo_po_nonmedis_detail')->where('id',$id)->delete();
            
            return redirect('/gudang/dist-nonmedis/detail/'.$po);
          }

          public function selesaiItempononmedis($id)
          {      
            $data_awal = Depononmedis::where('no_po',$id)->first();
            DB::table('depo_po_nonmedis')->where('no_po',$id)->update([
                'tgl_penerimaan'=>date('Ymd'),
                'status'=>'Selesai',
            ]);
            
            $data_list = Depodetailnonmedis::where('no_po',$id)->get();
            foreach($data_list as $data)
            {
                
                $data_obat_awal= Masternonmedis::where('kode_barang',$data->kode_barang)->first();    
                Masternonmedis::where('kode_barang',$data->kode_barang)->update([
                    'stok'=> $data_obat_awal['stok'] - $data->jumlah_pemberian,
                ]);

            }
            
            //return $data_obat_awal;
            return redirect('/gudang/dist-nonmedis');
          }

          ///// stok opnam
          public function stokopnam()
          {
              return view('logistik/stok_opnam.index');
          }
          public function opencreatestokopnam()
          {    $data['pegawai']=Pegawai::all();
              return view('logistik/stok_opnam.create',$data);
          }
          public function createstokopnam(Request $request)
          {   
            request()->validate([
                'tanggal_pelaksanaan' => 'required',
                'catatan' => 'required',
                'petugas' => 'required',
                'kategori' => 'required',
                'periode' => 'required',
            ]);
     
            Tbstokopnam::create([
                'no_stok_opnam' => 'SO'.date('YmdHis'),
                'petugas' => $request->petugas,
                'periode' => $request->periode,
                'tanggal_pelaksanaan' => valid_date($request->tanggal_pelaksanaan),
                'kategori' => $request->kategori,
                'catatan' => $request->catatan,
                'status' =>'proses',
            ]);
            $no_stok = 'SO'.date('YmdHis');
            if($request->kategori=='obat')
            {
                db::select(db::raw("INSERT INTO tb_detail_stok_opnam (kode, stok_sebelum)
                SELECT kode_obat, stok FROM tb_stok_obat"));
                db::select(db::raw("UPDATE tb_detail_stok_opnam 
                SET no_stok_opnam='".$no_stok."'
                WHERE no_stok_opnam IS NULL"));
            }elseif($request->kategori=='nonmedis')
            {
                
                $data_awal = Masternonmedis::select('kode_barang','stok')->get() ;
                foreach($data_awal as $data)
                {
                    db::select(db::raw("INSERT INTO tb_detail_stok_opnam (no_stok_opnam, kode, stok_sebelum)
                    VALUES ('".$no_stok."', '".$data->kode_barang."', '".$data->stok."')"));
                }
                
            }
            
            return redirect('/stok-opnam/detail/'.$no_stok);
          }
          public function detailstokopnam($id)
          {
              $detail_stok_opnam = Tbstokopnam::where('no_stok_opnam',$id)->first();
              return view('logistik/stok_opnam.create',compact('detail_stok_opnam'));
          }
          public function liststokopnam($id){
            $data_awal = Tbstokopnam::where('no_stok_opnam',$id)->first();
            DB::statement(DB::raw('set @rownum=0'));
            if($data_awal->kategori=='obat')
            {
            $list = Tbdetailstokopnam::join('tb_stok_obat','tb_stok_obat.kode_obat','=','tb_detail_stok_opnam.kode')
                ->select([
                DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'tb_detail_stok_opnam.kode',
                'tb_detail_stok_opnam.no_stok_opnam',
                'tb_stok_obat.nama_obj',
                'tb_detail_stok_opnam.keterangan',
                'tb_detail_stok_opnam.stok_sebelum',
                'tb_detail_stok_opnam.stok_sesudah',
                'tb_detail_stok_opnam.selisih',
                
                ])->orderBy('tb_detail_stok_opnam.kode','DESC')->get();
            
             return DataTables::of($list)
                                ->addColumn('input', function ($po) {
                                    $btn_edit = "";
                                   
                                        $btn_edit = '<input type="number" onkeyup="updatePemberian(this.value,\''.$po->no_stok_opnam.'\',\''.$po->kode.'\')" class="form-control" id="stok_sesudah" oname="stok_sesudah[]" value="'.$po->stok_sesudah.'">';
                                        return $btn_edit;
                                    
                                })
                                ->addColumn('inputket', function ($po) {
                                    $btn_edit = "";
                                    $btn_edit = '
                                    <input type="text" onkeyup="updateketerangan(this.value,\''.$po->no_stok_opnam.'\',\''.$po->kode.'\')" class="form-control" id="keterangan" oname="keterangan[]" value="'.$po->keterangan.'">';
                                    return $btn_edit;
                                })
                                ->rawColumns(['input','inputket'])
                                ->make(true);
            }elseif($data_awal->kategori=='nonmedis')
            {
                $list = db::select(db::raw("select  @rownum  := @rownum  + 1 AS rownum,tb_detail_stok_opnam.id,tb_detail_stok_opnam.kode,tb_detail_stok_opnam.no_stok_opnam,master_nonmedis.nama_barang,
                tb_detail_stok_opnam.stok_sebelum,tb_detail_stok_opnam.keterangan,tb_detail_stok_opnam.stok_sesudah,tb_detail_stok_opnam.selisih
                FROM tb_detail_stok_opnam
                JOIN master_nonmedis ON master_nonmedis.kode_barang = tb_detail_stok_opnam.kode
                WHERE tb_detail_stok_opnam.no_stok_opnam='".$id."' "));
            
             return DataTables::of($list)
                                ->addColumn('input', function ($po) {
                                    $btn_edit = "";
                                    $btn_edit = '
                                    <input type="number" onkeyup="updatePemberian(this.value,\''.$po->no_stok_opnam.'\',\''.$po->kode.'\')" class="form-control" id="stok_sesudah" oname="stok_sesudah[]" value="'.$po->stok_sesudah.'">';
                                    return $btn_edit;
                                })
                                ->addColumn('inputket', function ($po) {
                                    $btn_edit = "";
                                    $btn_edit = '
                                    <input type="text" onkeyup="updateketerangan(this.value,\''.$po->no_stok_opnam.'\',\''.$po->kode.'\')" class="form-control" id="keterangan" oname="keterangan[]" value="'.$po->keterangan.'">';                                    return $btn_edit;
                                    //$btn_edit = "";
                                    //$btn_edit = '
                                    //<input type="text" onkeyup="updateketerangan(this.value,\''.$po->no_stok_opnam.'\',\''.$po->kode.'\')" class="form-control" id="keterangan" oname="keterangan[]" value="'.$po->keterangan.'">';
                                    //return $btn_edit;
                                })
                                ->rawColumns(['input','inputket'])
                                ->make(true);
            }
       
         }
         public function update_stok_opnam($value,$no_po,$kode_item)
         {
                 $po_detail = Tbdetailstokopnam::where('no_stok_opnam', $no_po)->where('kode', $kode_item)->first();
                 //if($po_detail->stok_sebelum<$value)
                 //{
                 //$value = $po_detail->stok_sebelum;
                 //$po_detail->stok_sesudah = $value;
                 //$po_detail->selisih = $po_detail->stok_sebelum-$value;
                 //$po_detail->save();
                 //}else{
                 $po_detail->stok_sesudah = $value;
                 $po_detail->selisih = $po_detail->stok_sebelum-$value;
                 
                 $po_detail->save();
                 //}
                 return response()->json(['sukses' => true]);
         }	
         public function update_ketstok_opnam($value,$no_po,$kode_item)
         {
                 $po_detail = Tbdetailstokopnam::where('no_stok_opnam', $no_po)->where('kode', $kode_item)->first();
                 //if($po_detail->stok_sebelum<$value)
                 //{
                 //$value = $po_detail->stok_sebelum;
                 //$po_detail->stok_sesudah = $value;
                 //$po_detail->selisih = $po_detail->stok_sebelum-$value;
                 //$po_detail->save();
                 //}else{
                 $po_detail->keterangan = $value;
                 $po_detail->save();
                 //}
                 return response()->json(['sukses' => true]);
         }	
         public function selesaistokopnam($id)
         {
             $cek=Tbstokopnam::where('no_stok_opnam',$id)->first();
             db::select(db::raw("UPDATE tb_detail_stok_opnam 
             SET 
                 stok_sesudah = 0,
                 selisih = 0,
                 keterangan = 'belum_cek'
             WHERE
                 selisih IS NULL
             AND
                 stok_sesudah IS NULL
             AND 
                 no_stok_opnam = '".$id."'"));
                
             if($cek->kategori=='obat')
             {
                 $data_awal = Tbdetailstokopnam::where('no_stok_opnam', $id)->whereNotIn('keterangan',['belum_cek'])->get();
                 foreach($data_awal as $data)
                 {
                     Stokobat::where('kode_obat',$data->kode)->update([
                         'stok'=> $data->stok_sesudah
                     ]);
                 }
             }else{
                $data_awal = Tbdetailstokopnam::where('no_stok_opnam', $id)->get();
                foreach($data_awal as $data)
                {
                    Masternonmedis::where('kode_barang',$data->kode)->update([
                        'stok'=> $data->stok_sesudah
                    ]);
                }
             }
             Tbstokopnam::where('no_stok_opnam',$id)->update([
                'status'=>'Selesai'
             ]);
             return redirect('/stok-opnam/list');
         }
         public function get_data_stokopnam()
         {
            $list = db::select(db::raw("SELECT * FROM tb_stok_opnam "));
        
            return DataTables::of($list)
                            ->addColumn('aksi', function ($po) {
                                $btn_edit = "";
                                if($po->status=='Selesai')
                                {
                                $btn_edit = '
                                <a href="'.url('/stok-opnam/printlaporan/'.$po->no_stok_opnam).'" class="btn btn-success btn-flat fa fa-file" > Laporan</a>';
                                return $btn_edit;
                                }else{
                                $btn_edit = '
                                <a href="'.url('/stok-opnam/detail/'.$po->no_stok_opnam).'" class="btn btn-success btn-flat fa fa-search" >Pending</a>';
                                return $btn_edit;
                                }
                            })
                            ->addColumn('petugas_stok_opnam', function ($po) {
                                return baca_pegawai($po->petugas);
                              
                            })
                            ->addColumn('date', function ($po) {
                                return tgl_indo($po->tanggal_pelaksanaan);
                              
                            })
                            ->rawColumns(['aksi','petugas_stok_opnam','date'])
                            ->make(true);
         }
         public function pdflap_stok_opnam($id)
         {   
            $data['config'] = Config::find(1);
            $cek = Tbstokopnam::where('no_stok_opnam',$id)->first();
            if($cek->kategori=='nonmedis')
            {
            $data_stok_opnam = db::select(db::raw("SELECT tb_detail_stok_opnam.kode,master_nonmedis.nama_barang as nama,master_nonmedis.harga,tb_detail_stok_opnam.stok_sebelum,
            (tb_detail_stok_opnam.stok_sebelum*master_nonmedis.harga) AS nilai_awal,tb_detail_stok_opnam.stok_sesudah,
            (tb_detail_stok_opnam.stok_sesudah*master_nonmedis.harga) AS nilai_akhir,tb_detail_stok_opnam.selisih,
            (tb_detail_stok_opnam.selisih*master_nonmedis.harga) AS nilai_selisih
            FROM tb_detail_stok_opnam
            JOIN master_nonmedis ON master_nonmedis.kode_barang = tb_detail_stok_opnam.kode
            WHERE tb_detail_stok_opnam.no_stok_opnam='".$id."'"));
            $total_nilai = db::select(db::raw("SELECT tb_detail_stok_opnam.kode,master_nonmedis.nama_barang as nama,master_nonmedis.harga,tb_detail_stok_opnam.stok_sebelum,
            SUM(tb_detail_stok_opnam.stok_sebelum*master_nonmedis.harga) AS nilai_awal,tb_detail_stok_opnam.stok_sesudah,
            SUM(tb_detail_stok_opnam.stok_sesudah*master_nonmedis.harga) AS nilai_akhir,tb_detail_stok_opnam.selisih,
            SUM(tb_detail_stok_opnam.selisih*master_nonmedis.harga) AS nilai_selisih
            FROM tb_detail_stok_opnam
            JOIN master_nonmedis ON master_nonmedis.kode_barang = tb_detail_stok_opnam.kode
            WHERE tb_detail_stok_opnam.no_stok_opnam='".$id."'"));
            }elseif($cek->kategori=='obat')
            {
            $data_stok_opnam = db::select(db::raw("SELECT tb_detail_stok_opnam.kode,tb_stok_obat.nama_obj as nama,tb_stok_obat.harga,tb_detail_stok_opnam.stok_sebelum,
            (tb_detail_stok_opnam.stok_sebelum*tb_stok_obat.harga) AS nilai_awal,tb_detail_stok_opnam.stok_sesudah,
            (tb_detail_stok_opnam.stok_sesudah*tb_stok_obat.harga) AS nilai_akhir,tb_detail_stok_opnam.selisih,
            (tb_detail_stok_opnam.selisih*tb_stok_obat.harga) AS nilai_selisih
            FROM tb_detail_stok_opnam
            JOIN tb_stok_obat ON tb_stok_obat.kode_obat = tb_detail_stok_opnam.kode
            WHERE tb_detail_stok_opnam.no_stok_opnam='".$id."'"));
            $total_nilai =0;
            }
            $no=1;
            $config= Config::find(1);
            $pdf = PDF::loadView('/logistik/stok_opnam.pdf_laporan_stok_opnam', $data,compact('no','data_stok_opnam','total_nilai','config'));
            
            return $pdf->stream();
            //return View('/logistik/stok_opnam.pdf_laporan_stok_opnam', $data,compact('no','data_stok_opnam','total_nilai'));
         }

         //gudang obat
         public function gudang_obat()
         {
            $stok= Stokobat::all();
            return view('logistik/logistik/obat.index',compact('stok'))->with('no',1);
         }
         public function get_data_gudang_obat()
         {
            DB::statement(DB::raw('set @rownum=0'));
                $detail = Stokobat::select([
                DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'id_stok',
                'kode_obat',
                'nama_obj',
                'satuan',
                'stok',
                'harga',
               
            ])->get();
        
            return DataTables::of($detail)
                            ->make(true);
         }
       
         
}
