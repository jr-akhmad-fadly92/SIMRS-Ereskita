<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Masterruangan;
use App\Masterjenisbarang;
use App\Masterlokasi;
use App\Masterprodusen;
use App\Inventarisglobal;
use App\Inventarisdetail;
use App\Historyinventaris;
use App\Depoinv;
use App\Depoinvdetail;
use App\Depo;
use App\Depopo;
use App\Depopodetail;
use App\Depomasterobat;
use Modules\Pegawai\Entities\Pegawai;
use Yajra\DataTables\DataTables;
use Flashy;
use DB;
use Auth;
use Validator;
use Activity;
class BackofficeController extends Controller
{
    public function index()
    {
        return view('/backoffice.index');
    }
     // master index
     public function indexmaster()
     {
         return view('/backoffice.indexmaster');
     }
     
    //master ruangan=========================================================================================
    public function masterruangan()
    {   
        $data['ruangan'] = Masterruangan::all();
        return view('/backoffice/masterruangan.index',$data)->with('no',1);
    }

    public function createmasterruangan()
    {
        return view('/backoffice/masterruangan.create');
    }

    public function storemasterruangan(Request $request)
    {
        $data = request()->validate(['ruangan'=>'required','role'=>'required']);
        Masterruangan::create($data);
        Flashy::success('Master Ruangan Telah Ditambahkan');
        
        return redirect('/backoffice/master_ruangan');
    }

    public function editmasterruangan($id)
    {
        $data['ruangan'] = Masterruangan::find($id);
        return view('/backoffice/masterruangan.edit',$data);
    }

    public function updatemasterruangan(Request $request, $id)
    {
        $data = request()->validate(['ruangan'=>'required','role'=>'required']);
        Masterruangan::find($id)->update($data);
        Flashy::info('Data Master Ruangan berhasil di update');
        return redirect('/backoffice/master_ruangan');
    }
    public function deletemasterruangan($id)
    {
        $ruangan = Masterruangan::find($id);
        $ruangan->delete();
        return redirect('/backoffice/master_ruangan');
    
    }

    ///master jenis barang=========================================================================
    public function masterjenisbarang()
    {   
        $data['jenis_barang'] = Masterjenisbarang::all();
        return view('/backoffice/masterjenisbarang.index',$data)->with('no',1);
    }

    public function createmasterjenisbarang()
    {
        return view('/backoffice/masterjenisbarang.create');
    }

    public function storemasterjenisbarang(Request $request)
    {
        $data = request()->validate(['jenis_barang'=>'required']);
        Masterjenisbarang::create($data);
        Flashy::success('Jenis Barang Telah Ditambahkan');
        
        return redirect('/backoffice/master_jenis_barang');
    }

    public function editmasterjenisbarang($id)
    {
        $data['jenis_barang'] = Masterjenisbarang::find($id);
        return view('/backoffice/masterjenisbarang.edit',$data);
    }

    public function updatemasterjenisbarang(Request $request, $id)
    {
        $data = request()->validate(['jenis_barang'=>'required']);
        Masterjenisbarang::find($id)->update($data);
        Flashy::info('Data Jenis Barang berhasil di update');
        return redirect('/backoffice/master_jenis_barang');
    }
    public function deletemasterjenisbarang($id)
    {
        $jenisbarang = Masterjenisbarang::find($id);
        $jenisbarang->delete();
        return redirect('/backoffice/master_jenis_barang');
    
    }
    
    //master lokasi ruangan=============================================================================
    public function masterlokasibarang()
    {   
        $data['lokasi_barang'] = Masterlokasi::join('master_ruangan','master_ruangan.id','=','master_lokasi_ruangan.ruangan_id')
                                                ->select('master_ruangan.ruangan','master_lokasi_ruangan.id as id_lokasi','master_lokasi_ruangan.ruangan_id','master_lokasi_ruangan.lokasi')->get();
        return view('/backoffice/masterlokasi.index',$data)->with('no',1);
    }

    public function createmasterlokasibarang()
    {   
        return view('/backoffice/masterlokasi.create');
    }

    public function storemasterlokasibarang(Request $request)
    {
        $data = request()->validate(['ruangan_id'=>'required','lokasi'=>'required']);
        Masterlokasi::create($data);
        Flashy::success('Lokasi barang Telah Ditambahkan');
        
        return redirect('/backoffice/master_lokasi_barang');
    }

    public function editmasterlokasibarang($id)
    {
        $data['lokasi_barang'] = Masterlokasi::find($id);
        return view('/backoffice/masterlokasi.edit',$data);
    }

    public function updatemasterlokasibarang(Request $request, $id)
    {
        $data = request()->validate(['ruangan_id'=>'required','lokasi'=>'required']);
        Masterlokasi::find($id)->update($data);
        Flashy::info('Data Lokasi Barang berhasil di update');
        return redirect('/backoffice/master_lokasi_barang');
    }
    public function deletemasterlokasibarang($id)
    {
        $lokasi = Masterlokasi::find($id);
        $lokasi->delete();
        return redirect('/backoffice/master_lokasi_barang');
    
    }
    
    // master produsen / supplier ============================================================================
    public function masterprodusen()
    {   
        $data['produsen'] = Masterprodusen::all();
        return view('/backoffice/produsen.index',$data)->with('no',1);
    }

    public function createmasterprodusen()
    {   
        return view('/backoffice/produsen.create');
    }

    public function storemasterprodusen(Request $request)
    {
        $data = request()->validate(['id_produsen'=>'required','nama_produsen'=>'required','alamat_produsen'=>'required','telp'=>'required','email'=>'required','website'=>'required','kategori'=>'required']);
        Masterprodusen::create($data);
        Flashy::success('Produsen-Supplier Telah Ditambahkan');
        
        return redirect('/backoffice/produsen-supplier');
    }

    public function editmasterprodusen($id)
    {
        $data['produsen'] = Masterprodusen::where('id_produsen',$id)->first();
        return view('/backoffice/produsen.edit',$data);
    }

    public function updatemasterprodusen(Request $request, $id)
    {
        $data = request()->validate(['nama_produsen'=>'required','alamat_produsen'=>'required','telp'=>'required','email'=>'required','website'=>'required','kategori'=>'required']);
        Masterprodusen::where('id_produsen',$id)->update($data);
        Flashy::info('Data Lokasi Barang berhasil di update');
        return redirect('/backoffice/produsen-supplier');
    }
    public function deletemasterprodusen($id)
    {
        $produsen = Masterprodusen::where('id_produsen',$id)->select('id_produsen as id');
        
        $produsen->delete();
       
        return redirect('/backoffice/produsen-supplier');
        //return $produsen;
    }

    //inventaris Global================================================================================
    public function refresh_inv()
    {   
        $data_awal = Inventarisglobal::all();
            foreach($data_awal as $data){
                DB::table('inventaris_global')->where('kode_barang',$data->kode_barang)->update([
                    'total_harga'=>$data->jumlah_barang *$data->harga_unit,
                   ]);
            }
       return redirect('/backoffice/Inv-global'); 
    }
    public function inventarisglobal()
    {   $data['invetraisglobal'] = Inventarisglobal::join('master_jenis_barang','master_jenis_barang.id','=','inventaris_global.jenis_barang')
                                                    ->select('inventaris_global.harga_unit','inventaris_global.total_harga','inventaris_global.kode_barang','inventaris_global.nama_barang','inventaris_global.jumlah_barang','inventaris_global.produsen','inventaris_global.merk','inventaris_global.kategori_barang','inventaris_global.tahun_produksi','inventaris_global.jenis_barang as kode_jenis_barang','master_jenis_barang.jenis_barang as nama_jenis_barang')->get();
        $data['produsen'] = Masterprodusen::all();
        return view('/backoffice/inventaris.index',$data);
        //return $produsen;
    }
    
    public function createinventarisglobal()
    {   
        return view('/backoffice/inventaris.create');
    }

    public function storeinventarisglobal(Request $request)
    {
        $data = request()->validate(['kode_barang'=>'required','nama_barang'=>'required','produsen'=>'required','merk'=>'required','tahun_produksi'=>'required','harga_unit'=>'required','kategori_barang'=>'required','jenis_barang'=>'required']);
        Inventarisglobal::create([
            'kode_barang'=>$request->kode_barang,
            'nama_barang'=>$request->nama_barang,
            'jumlah_barang'=>0,
            'produsen'=>$request->produsen,
            'merk'=>$request->merk,
            'tahun_produksi'=>$request->tahun_produksi,
            'harga_unit'=>$request->harga_unit,
            'total_harga'=>$request->harga_unit*$request->jumlah_barang,
            'jumlah_barang'=>$request->jumlah_barang,
            'kategori_barang'=>$request->kategori_barang,
            'jenis_barang'=>$request->jenis_barang,
            
        ]);
        Flashy::success('Inventaris Global Telah Ditambahkan');
        
        return redirect('/backoffice/Inv-global');
    }

    public function editinventarisglobal($id)
    {
        $data['Inventarisglobal'] = Inventarisglobal::where('kode_barang',$id)->first();
        return view('/backoffice/inventaris.edit',$data);
    }

    public function updateinventarisglobal(Request $request, $id)
    {
        $data = request()->validate(['nama_barang'=>'required','produsen'=>'required','merk'=>'required','tahun_produksi'=>'required','kategori_barang'=>'required','jenis_barang'=>'required']);
        Inventarisglobal::where('kode_barang',$id)->update($data);
        Flashy::info('Data Lokasi Barang berhasil di update');
        return redirect('/backoffice/Inv-global');
    }
    public function deleteinventarisglobal($id)
    {
        $inv = Inventarisglobal::where('kode_barang',$id)->select('kode_barang as id');
        
        $inv->delete();
       
        return redirect('/backoffice/Inv-global');
        //return $produsen;
    }

    // detail inventaris =============================================================================
    public function refresh_inv_detail($id)
    {   
        $data_awal = Inventarisdetail::all();
        $data_global = Inventarisglobal::where('kode_barang',$id)->first();
        foreach($data_awal as $data){
            $jml = Inventarisdetail::where('kode_barang',$id)->count();
            $no_urut = Inventarisdetail::count();
            if($jml < $data_global->jumlah_barang){
                DB::table('invetaris_detail')->insert([
                    'no_inv'=>'INV000'.($no_urut+1),
                    'kode_barang'=>$id,
                    'ruangan'=>8,
                    'lokasi'=>19,
                    'tanggal_pengadaan'=>date('Ymd'),
                    'kondisi_barang'=>'ada',
                    'asal_barang'=>'beli'
                    ]);
            }}
        
        //return $data_global->jumlah_barang;
        return redirect('/backoffice/Inv-detail/'.$id); 
    }
    public function inventarisdetail($id)
    {  
        $data['Inventarisdetail'] = Inventarisdetail::join('master_ruangan','master_ruangan.id','=','invetaris_detail.ruangan')
                                    ->join('master_lokasi_ruangan','master_lokasi_ruangan.id','=','invetaris_detail.lokasi')
                                    ->where('kode_barang',$id)->get();
        $data['id'] = $id;
        $data['jumlah_inventaris']= Inventarisglobal::where('kode_barang',$id)->get();
        $data['jumlah'] = Inventarisdetail::join('master_ruangan','master_ruangan.id','=','invetaris_detail.ruangan')
                                    ->join('master_lokasi_ruangan','master_lokasi_ruangan.id','=','invetaris_detail.lokasi')
                                    ->where('kode_barang',$id)->count();
        $data['total_harga'] = Inventarisglobal::where('kode_barang',$id)->sum('total_harga');
        return view('/backoffice/inventaris.indexdetail',$data);
        //return $produsen;
    }
    public function historyinventarisdetail($id)
    {   $data['Inventarisdetail'] = Inventarisdetail::join('inventaris_global','inventaris_global.kode_barang','=','invetaris_detail.kode_barang')
                                                      ->join('master_produsen_inv','master_produsen_inv.id_produsen','=','inventaris_global.produsen')
                                                      ->where('no_inv',$id)->get();
        $data['historiinventaris']= Historyinventaris::where('no_inv',$id)->get();
        return view('/backoffice/inventaris/listdetail.detail',$data);
        //return $produsen;
    }
    public function createinventarisdetail($id)
    {   
        $data['id'] = $id;
        $data['Inventarisglobal'] = Inventarisglobal::where('kode_barang',$id)->first();
        return view('/backoffice/inventaris/listdetail.create',$data);
    }

    public function storeinventarisdetail(Request $request)
    {   $id=$request->kode_barang;
        $data = request()->validate(['no_inv'=>'required','kode_barang'=>'required','ruangan'=>'required','lokasi'=>'required','tanggal_pengadaan'=>'date_format:d-m-Y','kondisi_barang'=>'required','asal_barang'=>'required']);
        Inventarisdetail::create([
            'no_inv'=>$request->no_inv,
            'kode_barang'=>$request->kode_barang,
            'ruangan'=>$request->ruangan,
            'lokasi'=>$request->lokasi,
            'tanggal_pengadaan'=>valid_date($request['tanggal_pengadaan']),
            'kondisi_barang'=>$request->kondisi_barang,
          
            'asal_barang'=>$request->asal_barang,

            ]);

        Flashy::success('Inventaris Detail Telah Ditambahkan');
        
        return redirect('/backoffice/Inv-detail/'.$id);
    }

    public function editinventarisdetail($id)
    {
        $data['Inventarisdetail'] = Inventarisdetail::where('no_inv',$id)->first();
        return view('/backoffice/inventaris/listdetail.edit',$data);
    }

    public function updateinventarisdetail(Request $request, $id)
    {
        $data = request()->validate(['ruangan'=>'required','lokasi'=>'required','tanggal_pengadaan'=>'date_format:d-m-Y','kondisi_barang'=>'required','asal_barang'=>'required']);
        Inventarisdetail::where('no_inv',$id)->update([
            
            'ruangan'=>$request->ruangan,
            'lokasi'=>$request->lokasi,
            'tanggal_pengadaan'=>valid_date($request['tanggal_pengadaan']),
            'kondisi_barang'=>$request->kondisi_barang,
            
            'asal_barang'=>$request->asal_barang,
        ]);
        Flashy::info('Data Inv Barang berhasil di update');
        return redirect('/backoffice/Inv-detail/'.$id);
    }
    public function deleteinventarisdetail($id,$global)
    {
        $inv = Inventarisdetail::where('no_inv',$id)->select('kode_barang as id');
        
        $inv->delete();
       
        return redirect('/backoffice/Inv-detail/'.$global);
        //return $produsen;
    }

    public function getRuangan($ruangan)
    {
      $lokasi = Masterlokasi::where('ruangan_id',$ruangan)->pluck('lokasi','id');
      return json_encode($lokasi);
    }

    // mutasi inventaris ============================================================================
    public function inventarismutasi()
    {   
        $data['historiinventaris']= Historyinventaris::all();
        $data['Inventarisdetail'] = Inventarisdetail::join('master_ruangan','master_ruangan.id','=','invetaris_detail.ruangan')
        ->join('master_lokasi_ruangan','master_lokasi_ruangan.id','=','invetaris_detail.lokasi')
        ->join('inventaris_global','inventaris_global.kode_barang','=','invetaris_detail.kode_barang')
        ->get();
        
        return view('/backoffice/mutasi.index',$data);
        //return $produsen;
    }
    public function createinventarismutasi($id)
    {   $data['user'] = Auth::user();
        $data['id'] = $id;
        $data['Inventarisdetail'] = Inventarisdetail::join('master_ruangan','master_ruangan.id','=','invetaris_detail.ruangan')
        ->join('master_lokasi_ruangan','master_lokasi_ruangan.id','=','invetaris_detail.lokasi')
        ->join('inventaris_global','inventaris_global.kode_barang','=','invetaris_detail.kode_barang')
        ->where('no_inv',$id)
        ->select('invetaris_detail.*')
        ->first();
        //return $data;
        return view('/backoffice/mutasi.edit',$data);
    }

    public function storeinventarismutasi(Request $request)
    {   
        $data = request()->validate(['no_inv'=>'required','asal_ruangan'=>'required','update_ruangan'=>'required','tanggal_pindah'=>'date_format:d-m-Y','kondisi_barang'=>'required','petugas'=>'required']);
        Historyinventaris::create([
            'no_inv'=>$request->no_inv,
            'asal_ruangan'=>$request->asal_ruangan,
            'update_ruangan'=>$request->update_ruangan,
            'tanggal_pindah'=>valid_date($request['tanggal_pindah']),
            
            'kondisi_barang'=>$request->kondisi_barang,
            'petugas'=>$request->petugas,

            ]);
        Inventarisdetail::where('no_inv',$request->no_inv)->update([
            'ruangan'=>$request->update_ruangan,
            'kondisi_barang'=>$request->kondisi_barang,
        ]);

        Flashy::success('Mutasi Barang Telah berhasil');
        
        return redirect('/backoffice/Inv-mutasi');
    }

    // permintaan inv
    public function depoinvIndex()
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
            return view('depo/depoinv.index', $data);
    }
    public function dataDepo($value='')
    {
            $depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
            if(Auth::user()->role()->first()->name=="apotik"){
                DB::statement(DB::raw('set @rownum=0'));
                $po = Depoinv::select([
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
                $po = Depoinv::select([
                    DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                    'id',
                    'id_depo',
                    'no_po',
                    'tanggal',
                    'tgl_penerimaan',
                    'user_create',
                    'status',
                    ])->where('supplier','Logistik')->whereIn('status',['Pending','Selesai'])->orderBy('id','DESC')->get();
            }elseif(Auth::user()->role()->first()->name=="administrator" || Auth::user()->role()->first()->name=="logistik"){
                DB::statement(DB::raw('set @rownum=0'));
                $po = Depoinv::select([
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
                $po = Depoinv::select([
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
    public function dataDepoDetail($id)
    {
            $po = Depoinv::where('id', $id)->first();
            $detail = Depoinvdetail::where('po_id', $po->id)->get();
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
                $detail = Depoinvdetail::join('master_ruangan','master_ruangan.id','=','depo_po_inv_detail.ruangan')->select([
                DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'depo_po_inv_detail.id',
                'depo_po_inv_detail.po_id',
                'depo_po_inv_detail.no_po',
                'depo_po_inv_detail.kode_barang',
                'depo_po_inv_detail.nama_barang',
                'depo_po_inv_detail.jumlah',
                'depo_po_inv_detail.kode_barang_pemberian',
                'depo_po_inv_detail.nama_barang_pemberian',
                'depo_po_inv_detail.jumlah_pemberian',
                'master_ruangan.ruangan as nama_ruang'
            ])->where('po_id', $po_id)->get();
            return DataTables::of($detail)
                    ->addColumn('jumlah_pemberian', function ($detail) {
                        $depopo = Depoinv::where('id', $detail->po_id)->first();
                        $depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
                        $stok = db::table('invetaris_detail')->where('kode_barang',$detail->kode_barang)->where('ruangan',8)->where('kondisi_barang','ada')->count();
                        if($depo==null AND $depopo->status=='Pending' AND $stok>0){
                            return '<input type="number" onkeyup="updatePemberian(this.value,\''.$detail->no_po.'\',\''.$detail->kode_barang.'\')" class="form-control" id="jumlah_pemberian" oname="jumlah_pemberian[]" value="'.$detail->jumlah_pemberian.'">  (stok barang '.$stok.')';
                        }elseif($depo==null AND $depopo->status=='Pending' AND $stok<1){
                            return 'Stok Barang Habis';
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
        public function depoOrder()
        {
            $data['supplier'] = 0;
           
            return view('depo/depoinv.order', $data);
        }

        public function addItemDepo(Request $request)
        {
                request()->validate([
                        'tanggal' => 'required'
                ]);
                $depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
                $cek = Depoinv::where('supplier', $request['distributor'])->where('tanggal', valid_date($request['tanggal']))->where('status','Draft')->count();
                if($cek <= 0) {
                        $po = new Depoinv();
                        $po->id_depo = $depo->id;
                        $po->no_po = 'DEPOINV'.date('YmdHis');
                        $po->supplier = $request['distributor'];
                        $po->status = 'Draft';
                        $po->tanggal = valid_date($request['tanggal']);
                        $po->catatan = $request['catatan'];
                        $po->tgl_penerimaan = null;
                        $po->user_create = Auth::user()->name;
                        $po->save();
                        
                } else {
                        $po = Depoinv::where('supplier', $request['distributor'])->where('tanggal', valid_date($request['tanggal']))->where('status','Draft')->first();
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
                return view('depo/depoinv.order', $data);
        }

        public function depoMasterInv()
        {
                $depo = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
                //$nama_barang = Inventarisglobal::join('invetaris_detail','invetaris_detail.kode_barang','=','inventaris_global')->select('inventaris_global.nama_barang','inventaris_global.kode_barang',DB::raw('COUNT(invetaris_detail.kode_barang) AS jumlah'))->where('inventaris_detail.ruangan','8')->get();
                $nama_barang = DB::select( DB::raw("SELECT inventaris_global.kode_barang,inventaris_global.nama_barang,invetaris_detail.kode_barang,COUNT(invetaris_detail.kode_barang) AS jumlah 
                FROM inventaris_global 
                INNER JOIN invetaris_detail ON invetaris_detail.kode_barang = inventaris_global.kode_barang 
                WHERE invetaris_detail.ruangan=8 AND invetaris_detail.kondisi_barang='ada'
                GROUP BY inventaris_global.nama_barang") );
                return DataTables::of($nama_barang)
                ->addColumn('jumlah', function ($nama_barang) {
                    return ''.$nama_barang->jumlah.'';
                })
                ->addColumn('add', function ($nama_barang) {
                    return ' <a href="#" data-kode="'.$nama_barang->kode_barang.'"  data-nama="'.$nama_barang->nama_barang.'" class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-check"></i></a> ';
                })
                ->rawColumns(['add','jumlah'])
                ->make(true);
        }
        public function depoSimpanItem(Request $request)
        {
           
                $cek_stok	= Inventarisdetail::where('kode_barang',$request['kode_barang'])->count();
                if($cek_stok < $request['jumlah_barang']){
                    return response()->json(['sukses'=>false, 'message'=>'Stok tidak cukup']);
                }else{
                    $cek_barang = Depoinvdetail::where('no_po',$request['no_po'])->where('kode_barang',$request['kode_barang'])->first();
                    if($cek_barang==null){
                        $item = new Depoinvdetail();
                        $item->po_id = $request['po_id'];
                        $item->no_po = $request['no_po'];
                        $item->kode_barang = $request['kode_barang'];
                        $item->nama_barang = $request['nama_barang'];
                        $item->jumlah = $request['jumlah_barang'];
                        $item->ruangan = $request['ruangan'];
                        $item->save();
                       
                        return response()->json(['sukses'=>true]);
                    }else{
                        return response()->json(['sukses'=>false, 'message'=>'Obat sudah pernah ditambahkan, silahkan cek atau ganti obat lain']);
                    }
                }
            
        }
        public function depoKirimOrder($id)
        {
                $po = Depoinv::where('id', $id)->where('status', 'Draft')->first();
                if($po!=null){
                    $po->status = 'Pending';
                    
                    if($po->save()){
                        return redirect('depo-order-inv/'.$id);
                    }else{
                        return redirect('depo-inv');
                    }
                }else{			
                    return redirect('depo-inv');
                }
        }
        public function updateDepoOrder($id)
        {
                $po = Depoinv::where('id', $id)->where('status', 'Draft')->first();
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
                    return view('depo/depoinv.order', $data);
                }else{
                    return redirect('depo-inv');
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
            return view('depo/depoinv.index', $data);
        }
        public function updatePemberian($value,$no_po,$kode_barang)
        {
            $po = Depoinv::where('no_po', $no_po)->first();

            if($po->status=="Selesai"){
                
            }else{
                $po_detail = Depoinvdetail::where('no_po', $no_po)->where('kode_barang', $kode_barang)->first();
                if($po_detail!=null){
                    $po_detail->kode_barang_pemberian = $kode_barang;
                    $po_detail->nama_barang_pemberian = $po_detail->nama_barang;
                    $po_detail->jumlah_pemberian = $value;
                    $po_detail->save();

                    
                }			
            }
        }
        public function setujuPemberian($no_po)
        {
                $po = Depoinv::where('no_po', $no_po)->first();
                //$user = db::table('users')->where('name',$po->user_create)->first();
                $role = db::table('users')->join('role_user','role_user.user_id','=','users.id')->join('roles','roles.id','=','role_user.role_id')
                ->where('users.name',$po->user_create)->select('roles.id as id_role')->first();
                
                $detail = Depoinvdetail::where('no_po', $no_po)->get();
                $cek_stok = false;
                if($detail!=null){
                    
                    foreach ($detail as $key => $d) {
                        $stok_awal = Inventarisdetail::where('kode_barang',$d->kode_barang)->where('ruangan','8')->count();
                        $nama_barang = "";
                        $sisa_stok = "";
                        if($stok_awal>0 AND !$cek_stok){
                            if($stok_awal < $d->jumlah_pemberian){
                                $cek_stok = true;
                                $nama_barang = $d->nama_barang.' / '.$d->nama_barang;
                                $sisa_stok = $stok_awal;
                            }
                        }
                    }
                    if($cek_stok){
                        return response()->json(['sukses'=>false, 'message'=>'Sisa stok '.$nama_barang.' tinggal '.$sisa_stok]);
                    }else{
                        $data['user'] = Auth::user();
                        foreach ($detail as $key => $d) {
                            $stok_awal = Inventarisdetail::where('kode_barang',$d->kode_barang)->where('ruangan',$d->ruangan)->count();
                            $gudang = 	Inventarisdetail::where('kode_barang',$d->kode_barang)->get();
                            foreach($gudang as $g){
                            $gudang_stok = 	Inventarisdetail::where('kode_barang',$d->kode_barang)->where('ruangan',$d->ruangan)->count();
                            if($gudang_stok<$d->jumlah_pemberian+$stok_awal)
                            {
                                
                            
                            
                            DB::table('invetaris_detail')->where('kode_barang',$d->kode_barang)->where('ruangan','8')->where('kondisi_barang','ada')->where('no_inv','=',$g->no_inv)->update([
                                'ruangan' => $d->ruangan,
                                'role' => $role->id_role,
                            ]);
                            $data['now'] = Inventarisdetail::where('no_inv','=',$g->no_inv)->first();
                            if($data['now']->ruangan==$d->ruangan){
                            DB::table('history_inventaris')->insert([
                                'no_inv'=>$g->no_inv,
                                'asal_ruangan'=>'8',
                                'update_ruangan'=>$d->ruangan,
                                'tanggal_pindah'=>date('Y-m-d'),
                                
                                'kondisi_barang'=>$g->kondisi_barang,
                                'petugas'=>Auth::user()->pegawai_id,

                                ]);
                            }}}

                        }
                        $po->tgl_penerimaan = date('Y-m-d');
                        $po->status = "Selesai";
                        $po->save();
                        return response()->json(['sukses'=>true, 'message'=>'Berhasil di simpan']);
                    }
                }
            }
            
            /// Pengajuan Inv
            public function pengajuanIndex()
            {
                return view('backoffice/pengajuan_inv.index');
            }
            public function pengajuaninvIndex()
            {
                    $pegawai = Depo::where('nama_depo', strtolower(Auth::user()->role()->first()->name))->first();
                    $data = [
                        'status_aksi' => true
                    ];
                    if($depo==null){
                        $data = [
                            'status_aksi' => false
                        ];
                    }
                    return view('depo/depoinv.index', $data);
            }
            public function DepoDelete($id)
            {
                    $item = Depoinvdetail::where('id', $id)->first();
                    
                    if($item->delete()){
                        return response()->json(['sukses' => true]);
                    }else{
                        return response()->json(['sukses' => false]);
                    }
            }

            //list inventaris per unit
            public function list_inventaris_unit($id)
            {
                    $list = Inventarisdetail::join('inventaris_global','inventaris_global.kode_barang','=','invetaris_detail.kode_barang')
                            ->join('roles','roles.id','=','invetaris_detail.role')->join('master_ruangan','master_ruangan.id','=','invetaris_detail.ruangan')->where('invetaris_detail.role', $id)
                            ->select(
                                'inventaris_global.nama_barang','master_ruangan.ruangan','invetaris_detail.kondisi_barang','invetaris_detail.updated_at','invetaris_detail.no_inv'
                            )->get();
                    $id=Auth::user()->role()->first()->id;
                    return view('/backoffice/inventaris/data_inventaris.list_inventaris_unit',compact('list','id'))->with('no',1);
            }

            public function get_list_inventaris_unit($id)
            {
                DB::statement(DB::raw('set @rownum=0'));
                    $list = Inventarisdetail::join('inventaris_global','inventaris_global.kode_barang','=','invetaris_detail.kode_barang')
                            ->join('roles','roles.id','=','invetaris_detail.role')->join('master_ruangan','master_ruangan.id','=','invetaris_detail.ruangan')->where('invetaris_detail.role', $id)
                            ->select([
                                DB::raw('@rownum  := @rownum  + 1 AS rownum'),'inventaris_global.nama_barang','master_ruangan.ruangan',
                                'invetaris_detail.kondisi_barang','invetaris_detail.updated_at','invetaris_detail.no_inv'
                            ])->get();
                    return DataTables::of($list)
                            ->addColumn('pengajuan', function ($detail) {
                                if($detail->kondisi_barang=='hilang')
                                {
                                    return '-';
                                }else{
                                return '<button type="button" class="btn btn-primary pengajuan" data-toggle="modal" data-kode="'.$detail->no_inv.'" data-nama="'.$detail->nama_barang.'">Pengajuan</button>';}
                            })
                            ->addColumn('tanggal', function ($detail) {
                                return date('d-m-Y',strtotime($detail->updated_at));
                            })
                            ->rawColumns(['pengajuan','tanggal'])
                            ->make(true);
            }

            public function pengajuan_inventaris_hilang(Request $request)
            {       $data_awal = db::table('invetaris_detail')->join('inventaris_global','inventaris_global.kode_barang','=','invetaris_detail.kode_barang')    
                                ->where('no_inv',$request['no_inv'])->select('inventaris_global.nama_barang','inventaris_global.kode_barang','invetaris_detail.*')->first();
                    $role = Auth::user()->role()->first()->name;
                    $depo = db::table('depos')->where('nama_depo',$role)->first();
                    $histori_pengajuan = db::table('histori_pengajuan_inv_rusak')->insert([
                        'no_inv'=> $request['no_inv'],
                        'asal_ruangan'=>$data_awal->ruangan,
                        'alasan'=>$request['alasan'],
                        'tanggal_pengajuan'=>date('Y-m-d',strtotime($request['tanggal'])),
                        'nama_peminta'=>$request['dokte_perawat'],
                        'petugas'=>$request['petugas'],
                    ]);
                    if($request['alasan']=='rusak')
                    {
                    $histori_inv = db::table('history_inventaris')->insert([
                        'no_inv'=> $request['no_inv'],
                        'asal_ruangan'=>$data_awal->ruangan,
                        'update_ruangan'=>8,
                        'tanggal_pindah'=>date('Y-m-d',strtotime($request['tanggal'])),
                        'kondisi_barang'=>$request['alasan'],
                        'petugas'=>$request['petugas'],
                    ]);
                    $inv = db::table('invetaris_detail')->where('no_inv',$request['no_inv'])->update([
                        'ruangan'=>8,
                        'role'=>33,
                        'kondisi_barang'=>$request['alasan'],
                    ]);
                    
                        db::table('depo_po_inv')->insert([
                            'id_depo'=>$depo->id,
                            'no_po'=>'DEPOINV'.date('YmdHis'),
                            'supplier'=>'Logistik',
                            'tanggal'=>date('Y-m-d',strtotime($request['tanggal'])),
                            'status'=>'Pending',
                            'catatan'=>$request['nama_barang'].' Rusak',
                            'user_create'=>$request['petugas']
                        ]);
                        $data_depo_inv =  db::table('depo_po_inv')->where('no_po','DEPOINV'.date('YmdHis'))->first();
                        db::table('depo_po_inv_detail')->insert([
                            'po_id'=>$data_depo_inv->id,
                            'no_po'=>'DEPOINV'.date('YmdHis'),
                            'kode_barang'=>$data_awal->kode_barang,
                            'nama_barang'=>$request['nama_barang'],
                            'jumlah'=>1,
                            'ruangan'=>$data_awal->ruangan,
                            
                        ]);
                        
                    }else{
                        $histori_inv = db::table('history_inventaris')->insert([
                            'no_inv'=> $request['no_inv'],
                            'asal_ruangan'=>$data_awal->ruangan,
                            'update_ruangan'=>$data_awal->ruangan,
                            'tanggal_pindah'=>date('Y-m-d',strtotime($request['tanggal'])),
                            'kondisi_barang'=>$request['alasan'],
                            'petugas'=>$request['petugas'],
                        ]);
                        $inv = db::table('invetaris_detail')->where('no_inv',$request['no_inv'])->update([
                            'ruangan'=>$data_awal->ruangan,
                            'role'=>Auth::user()->role()->first()->id,
                            'kondisi_barang'=>$request['alasan'],
                        ]);
                    }
                    $alasan=$request['alasan'];
                        return response()->json(['sukses' => true,'alasan'=> $alasan]);
                   
            }

          
            //pengajuan inventaris rusak / hilang
    /* public function createmasterjabatan()
    {
        return view('direksi/masterjabatan.create');
    }

    public function storemasterjabatan(Request $request)
    {
        $data = request()->validate(['kode_jabatan'=>'required','nama_jabatan'=>'required','tunjangan_jabatan'=>'required']);
        MasterJabatan::create($data);
        Flashy::success('Master Jabatan Telah Ditambahkan');
        
        return redirect()->route('masterjabatan');
    }
    public function editmasterjabatan($id)
    {
        $data['masterjabatan'] = MasterJabatan::find($id);
        return view('/direksi/masterjabatan.edit',$data);
    }

    public function updatemasterjabatan(Request $request, $id)
    {
        $data = request()->validate(['kode_jabatan'=>'required','nama_jabatan'=>'required','tunjangan_jabatan'=>'required']);
        MasterJabatan::find($id)->update($data);
        Flashy::info('Data Master Jabatan berhasil di update');
        return redirect()->route('masterjabatan');
    }

    public function deletemasterjabatan($id)
    {
        $jabatan = MasterJabatan::find($id);
        $jabatan->delete();
        return redirect()->route('masterjabatan');
    
    }*/
}
