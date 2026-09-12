<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Activity;
use Excel;
use Auth;
use PDF;
//use PDF1;

use DB;
use Yajra\DataTables\DataTables;
use Modules\Config\Entities\Config;
use App\User;
use App\Depononmedis;
use App\Depodetailnonmedis;
use App\Depo;
use App\Masterruangan; 
use App\Tbdetaillplpo;
use App\Tbretur;
use App\Masterobat;
use App\Tbdetailretur;
use App\Tblplpo;
use App\Tbldetailplpo;
use App\Inventarisglobal;
use App\Inventarisdetail;
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
use App\Tbstokobat;

class LaporanController extends Controller
{
    public function lap_pengunjung()
    {
      # code...
    }

    public function pemesanan()
    {
      $kategori=0;
      return view('logistik/logistik/laporan.laporan_pesanan',compact('kategori'));
      
    }

    public function pemesanan_Byrequest(Request $request)
    {
                request()->validate(['tga'=>'required', 'tgb'=>'required']);
                $kategori=$request->po_kategori_order;
                $config = Config::find(1);
                $Laporan_pemesanan = Tbdetailpenerimaan::whereBetween('tb_detail_purchase.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
                ->join('tb_penerimaan', 'tb_penerimaan.no_faktur', '=', 'tb_detail_faktur.no_faktur')
                ->join('tb_detail_purchase', 'tb_detail_purchase.dpo_item_id', '=', 'tb_detail_faktur.kode')
                ->join('tb_purchase', 'tb_purchase.po_no_purchaseorder', '=', 'tb_penerimaan.no_po')
                ->select('tb_penerimaan.no_po', 'tb_penerimaan.no_faktur', 'tb_detail_faktur.kode', 'tb_detail_faktur.nama_obj', 'tb_detail_purchase.dpo_item_unit', 'tb_detail_faktur.jumlah','tb_detail_faktur.jumlah_diterima',
                'tb_detail_purchase.dpo_price',DB::raw("(tb_detail_purchase.dpo_price*tb_detail_faktur.jumlah_diterima) AS total_biaya"),'tb_purchase.po_status')
                ->where('tb_purchase.po_kategori_order', $request->po_kategori_order)
                ->get();
                $item_pemesanan = Tbdetailpenerimaan::whereBetween('tb_detail_purchase.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
                ->join('tb_penerimaan', 'tb_penerimaan.no_faktur', '=', 'tb_detail_faktur.no_faktur')
                ->join('tb_detail_purchase', 'tb_detail_purchase.dpo_item_id', '=', 'tb_detail_faktur.kode')
                ->join('tb_purchase', 'tb_purchase.po_no_purchaseorder', '=', 'tb_penerimaan.no_po')
                ->select('tb_penerimaan.no_po', 'tb_penerimaan.no_faktur', 'tb_detail_faktur.kode', 'tb_detail_faktur.nama_obj', 'tb_detail_purchase.dpo_item_unit', 'tb_detail_faktur.jumlah','tb_detail_faktur.jumlah_diterima',
                'tb_detail_purchase.dpo_price',DB::raw("(tb_detail_purchase.dpo_price*tb_detail_faktur.jumlah_diterima) AS total_biaya"),'tb_purchase.po_status')
                ->where('tb_purchase.po_kategori_order', $request->po_kategori_order)
                ->count();
                $biaya_pemesanan = Tbdetailpenerimaan::whereBetween('tb_detail_purchase.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
                ->join('tb_penerimaan', 'tb_penerimaan.no_faktur', '=', 'tb_detail_faktur.no_faktur')
                ->join('tb_detail_purchase', 'tb_detail_purchase.dpo_item_id', '=', 'tb_detail_faktur.kode')
                ->join('tb_purchase', 'tb_purchase.po_no_purchaseorder', '=', 'tb_penerimaan.no_po')
                ->select('tb_penerimaan.no_po', 'tb_penerimaan.no_faktur', 'tb_detail_faktur.kode', 'tb_detail_faktur.nama_obj', 'tb_detail_purchase.dpo_item_unit', 'tb_detail_faktur.jumlah','tb_detail_faktur.jumlah_diterima',
                'tb_detail_purchase.dpo_price',DB::raw("sum(tb_detail_purchase.dpo_price*tb_detail_faktur.jumlah_diterima) AS total_biaya"),'tb_purchase.po_status')
                ->where('tb_purchase.po_kategori_order', $request->po_kategori_order)
                ->first();
                $jumlah_pemesanan = Tbdetailpenerimaan::whereBetween('tb_detail_purchase.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
                ->join('tb_penerimaan', 'tb_penerimaan.no_faktur', '=', 'tb_detail_faktur.no_faktur')
                ->join('tb_detail_purchase', 'tb_detail_purchase.dpo_item_id', '=', 'tb_detail_faktur.kode')
                ->join('tb_purchase', 'tb_purchase.po_no_purchaseorder', '=', 'tb_penerimaan.no_po')
                ->select('tb_penerimaan.no_po', 'tb_penerimaan.no_faktur', 'tb_detail_faktur.kode', 'tb_detail_faktur.nama_obj', 'tb_detail_purchase.dpo_item_unit', 'tb_detail_faktur.jumlah','tb_detail_faktur.jumlah_diterima',
                'tb_detail_purchase.dpo_price',DB::raw("(tb_detail_purchase.dpo_price*tb_detail_faktur.jumlah_diterima) AS total_biaya"),'tb_purchase.po_status')
                ->where('tb_purchase.po_kategori_order', $request->po_kategori_order)
                ->sum('jumlah_diterima');
                if ($request['lanjut']) {
                  $periode = tanggalkuitansi($request['tga']).' s/d '.tanggalkuitansi($request['tgb']);
                  //return $jumlah_pemesanan;
                  return view('logistik/logistik/laporan.laporan_pesanan', compact('kategori','periode','Laporan_pemesanan','jumlah_pemesanan','item_pemesanan','biaya_pemesanan'))->with('no', 1);
                } elseif ($request['pdf']) {
                  $no=1;
                  $periode = tanggalkuitansi($request['tga']).' s/d '.tanggalkuitansi($request['tgb']);
                  $pdf = PDF::loadView('/logistik/logistik/laporan.pdf_laporan_pesanan', compact('no','Laporan_pemesanan','jumlah_pemesanan','item_pemesanan','biaya_pemesanan','periode','config'));
                  return $pdf->stream();
                } 
    }

    // laporan stok gudang
    public function stok_gudang()
    {
      $kategori=0;
      return view('logistik/logistik/laporan.laporan_stok_gudang',compact('kategori'));
      
    }

    public function stok_gudang_Byrequest(Request $request)
    {
                request()->validate(['tga'=>'required', 'tgb'=>'required']);
                
                $config = Config::find(1);
                $kategori=$request->po_kategori_order;
                if($request->po_kategori_order=='obat')
                {
                $Laporan_stok = Tbstokobat::whereBetween('updated_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
                ->select('kode_obat','no_batch','nama_obj','stok','harga',DB::raw("(harga*stok)AS nilai_persediaan"))
                ->get();
                $item_stok = Tbstokobat::whereBetween('updated_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
                ->select('kode_obat','no_batch','nama_obj','stok','harga',DB::raw("(harga*stok)AS nilai_persediaan"))
                ->count();
                $biaya_stok = 
                Tbstokobat::whereBetween('updated_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
                ->select(DB::raw("kode_obat,no_batch,nama_obj,stok,harga,SUM(harga*stok)AS nilai_persediaan"))
                ->first();
                
                $jumlah_stok = 
                Tbstokobat::whereBetween('updated_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
                ->select('kode_obat','no_batch','nama_obj','stok','harga',DB::raw("(harga*stok)AS nilai_persediaan"))
                ->sum('stok');
                }elseif($request->po_kategori_order=='inventaris')
                {
                $Laporan_stok = 
                db::select(db::raw("select invetaris_detail.no_inv,inventaris_global.nama_barang,master_produsen_inv.nama_produsen,
                COUNT(IF(invetaris_detail.ruangan = 8 ,1,NULL)) AS stok, 
                inventaris_global.harga_unit,
                (inventaris_global.harga_unit*(COUNT(IF(invetaris_detail.ruangan = 8 ,1,NULL)))) AS total_harga
                                
                FROM invetaris_detail
                LEFT JOIN inventaris_global ON inventaris_global.kode_barang = invetaris_detail.kode_barang
                LEFT JOIN master_produsen_inv ON master_produsen_inv.id_produsen = inventaris_global.produsen
                WHERE invetaris_detail.updated_at BETWEEN '".valid_date($request['tga'])."' AND '".valid_date($request['tgb'])."'
                GROUP BY inventaris_global.nama_barang
                ORDER BY inventaris_global.nama_barang ASC"));
                $item_stok = 0;
                $biaya_stok =0;
                $jumlah_stok =0;
                }elseif($request->po_kategori_order=='nonmedis'){
                  $Laporan_stok = 
                db::select(db::raw("select master_nonmedis.kode_barang,master_nonmedis.nama_barang,master_nonmedis.satuan,
                master_jenis_barang.jenis_barang,master_nonmedis.stok,master_nonmedis.harga,
                (master_nonmedis.stok*master_nonmedis.harga) AS total_harga
                FROM master_nonmedis
                JOIN master_jenis_barang ON master_jenis_barang.id = master_nonmedis.jenis
                WHERE master_nonmedis.created_at BETWEEN '".valid_date($request['tga'])."' AND '".valid_date($request['tgb'])."'
                "));
                $item_stok =  Masternonmedis::whereBetween('updated_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
                ->select('kode_barang','nama_barang')
                ->count();
                $biaya_stok =
                Masternonmedis::whereBetween('updated_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
                ->select(DB::raw("SUM(harga*stok)AS nilai_persediaan"))
                ->first();
                $jumlah_stok =
                Masternonmedis::whereBetween('updated_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
                ->sum('stok');
                }
                if ($request['lanjut']) {
                  $periode = tanggalkuitansi($request['tga']).' s/d '.tanggalkuitansi($request['tgb']);
                  //return $Laporan_stok;
                  return view('logistik/logistik/laporan.laporan_stok_gudang', compact('kategori','periode','Laporan_stok','jumlah_stok','item_stok','biaya_stok'))->with('no', 1);
                } elseif ($request['pdf']) {
                  if($kategori=='obat')
                  {
                  $no=1;
                  $config=Config::find(1);
                  $periode = tanggalkuitansi($request['tga']).' s/d '.tanggalkuitansi($request['tgb']);
                  $pdf = PDF::loadView('/logistik/logistik/laporan.pdf_laporan_stok_gudang', compact('config','no','kategori','Laporan_stok','jumlah_stok','item_stok','biaya_stok','periode','config'));
           
                  return $pdf->stream();
                  //return $Laporan_stok;
                  }elseif($kategori=='inventaris')
                  {
                  $no=1;
                  $config=Config::find(1);
                  $periode = tanggalkuitansi($request['tga']).' s/d '.tanggalkuitansi($request['tgb']);
                  $pdf = PDF::loadView('/logistik/logistik/laporan.pdf_laporan_stok_gudang_inv', compact('config','no','kategori','Laporan_stok','jumlah_stok','item_stok','biaya_stok','periode','config'));
                                   
                  return $pdf->stream();
                  }else{
                  $no=1;
                  $config=Config::find(1);
                  $periode = tanggalkuitansi($request['tga']).' s/d '.tanggalkuitansi($request['tgb']);
                  $pdf = PDF::loadView('/logistik/logistik/laporan.pdf_laporan_stok_gudang_nm', compact('config','no','kategori','Laporan_stok','jumlah_stok','item_stok','biaya_stok','periode','config'));
                  return $pdf->stream();
                  }
                } 
    }
}
