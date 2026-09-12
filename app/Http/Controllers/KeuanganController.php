<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AkunKeuangan;
use App\Jurnal;
use Yajra\DataTables\DataTables;
use Flashy;
use DB;
use Auth;
use Validator;
use Activity;

class KeuanganController extends Controller
{
    //Jurnal --------------------------------------------------------------------------------------------------
    public function jurnal()
    {
        return view('/kasir/keuanganrs/jurnal.index');
    }
    //input jurnal --------------------------------------------------------------------------------------------
    public function inputjurnal()
    {   
        $bulan = date('F Y', strtotime(date('Ymd')));
        $no_jurnal=date('Y-m-d', strtotime(date('Ymd')));
        $debet = Jurnal::where('balance','D')->where(db::raw('tanggal_transaksi'),$no_jurnal)->sum('nilai');
        $kredit = Jurnal::where('balance','K')->where(db::raw('tanggal_transaksi'),$no_jurnal)->sum('nilai');
        return view('/kasir/keuanganrs/jurnal.index',compact('debet','kredit','bulan'));
    }
    public function storejurnal(Request $request)
    {       request()->validate(['tanggal_transaksi'=>'required', 'kode_keuangan'=>'required','nilai'=>'required']);
            $tanggal=valid_date($request->tanggal_transaksi) ;
                DB::table('jurnal')->insert([
                    'no_jurnal' =>  date('Y',strtotime($tanggal)).'.'.date('m',strtotime($tanggal)),
                    'tanggal_transaksi' => $tanggal ,
                    'kode_keuangan' => $request->kode_keuangan,
                    'nilai' => $request->nilai,
                    'no_bukti' => $request->no_bukti,
                    'keterangan' => $request->keterangan,
                    'balance'=> $request->balance,
                ]);

                return response()->json(['sukses'=>true]);
               
            
    }
    public function listjurnal()
	{
		DB::statement(DB::raw('set @rownum=0'));
        $detail = Jurnal::join('akun_keuangan','akun_keuangan.kode_keuangan','=','jurnal.kode_keuangan')
        ->where('jurnal.tanggal_transaksi',date('y-m-d'))
        ->where(db::raw('month(tanggal_transaksi)'),date('m'))
        ->where(db::raw('year(tanggal_transaksi)'),date('Y'))
        ->select([
		DB::raw('@rownum  := @rownum  + 1 AS rownum'),
        'jurnal.id',
        'jurnal.tanggal_transaksi',
        'jurnal.keterangan',
        'jurnal.kode_keuangan',
        'jurnal.nilai',
        'jurnal.balance',
        'akun_keuangan.nama_akun'
        ]);
        return DataTables::of($detail)
                ->addColumn('tanggal', function ($list) {
                    return tanggalkuitansi(valid_date($list->tanggal_transaksi));
                })
                ->addColumn('hapus', function ($list) {
                    return '<a href="'.url('/keuangan/hapus-list-jurnal-bulan-ini/'.$list->id).'" onclick="return confirm("'.("'").'apakah anda yakin menghapus data ini?'.("'").'");"  class="btn btn-sm btn-danger btn-flat hapus"><i class="fa fa-trash"></i></a>';
                })
                ->addColumn('debet', function ($list) {
                    if($list->balance=='D'){
                    return 'Rp. '.number_format($list->nilai);    
                    }else{
                    return '0';
                    }
                })
                ->addColumn('kredit', function ($list) {
                    if($list->balance=='K'){
                    return 'Rp. '.number_format($list->nilai);    
                    }else{
                    return '0';
                    }
                })
                ->rawColumns(['tanggal','debet','kredit','hapus'])
                ->make(true);    
    }
    public function hapuslistjurnal($id)
    {
        if(DB::table('jurnal')->where('id',$id)->delete()){
            return redirect('/keuangan/input-jurnal');
        }else{
            return redirect('/keuangan/input-jurnal');
        }
    }

    // Jurnal Umum ----------------------------------------------------------------------------------------------
    public function jurnal_umum()
    {
        $no_jurnal= Jurnal::groupBy('no_jurnal')->get();
        return view('kasir/keuanganrs/jurnalumum.index',compact('no_jurnal'))->with('no',1);
    }

    public function jurnal_umum_request(Request $request)
    {   
        //requet tanggal mm-yyyy
        request()->validate(['periode'=>'required']);
        $data =  $request->periode;
        $data1 = date('Y.m',strtotime($data));
        $no_jurnal= Jurnal::groupBy('no_jurnal')->where('no_jurnal',$data1)->get();
        return view('kasir/keuanganrs/jurnalumum.index',compact('no_jurnal'))->with('no',1);
    }
    
    public function jurnal_umum_bulan($id)
    {   
        $id=$id;
        $time = Jurnal::where('no_jurnal',$id)->first();
        $bulan = date('F Y', strtotime($time->tanggal_transaksi));
        $jurnal = Jurnal::where('tanggal_transaksi',$id)->get();
        $debet = Jurnal::where('no_jurnal',$id)->where('balance','D')->sum('nilai');
        $kredit = Jurnal::where('no_jurnal',$id)->where('balance','K')->sum('nilai');
        
        return view('kasir/keuanganrs/jurnalumum.detail',compact('jurnal','debet','kredit','bulan','id'))->with('no',1);
    }

    public function listjurnaldetail($id)
	{
		DB::statement(DB::raw('set @rownum=0'));
        $detail = Jurnal::join('akun_keuangan','akun_keuangan.kode_keuangan','=','jurnal.kode_keuangan')
        ->where('no_jurnal',$id)
        ->select([
		DB::raw('@rownum  := @rownum  + 1 AS rownum'),
        'jurnal.id',
        'jurnal.tanggal_transaksi',
        'jurnal.keterangan',
        'jurnal.kode_keuangan',
        'jurnal.nilai',
        'jurnal.balance',
        'akun_keuangan.nama_akun'
        ]);
        return DataTables::of($detail)
                ->addColumn('tanggal', function ($list) {
                    return tanggalkuitansi(valid_date($list->tanggal_transaksi));
                })
                ->addColumn('hapus', function ($list) {
                    return '<a href="'.url('/keuangan/hapus-list-detail-jurnal/'.$list->id).'" onclick="return confirm('.("'").'apakah anda yakin menghapus data ini?'.("'").');" class="btn btn-sm btn-danger btn-flat hapus"><i class="fa fa-trash"></i></a>';
                })
                ->addColumn('debet', function ($list) {
                    if($list->balance=='D'){
                    return 'Rp. '.number_format($list->nilai);    
                    }else{
                    return '0';
                    }
                })
                ->addColumn('kredit', function ($list) {
                    if($list->balance=='K'){
                    return 'Rp. '.number_format($list->nilai);    
                    }else{
                    return '0';
                    }
                })
                ->rawColumns(['tanggal','debet','kredit','hapus'])
                ->make(true);    
    }
    public function hapuslistjurnaldetail($id)
    {   
        $data= Jurnal::where('id',$id)->first();
        if(DB::table('jurnal')->where('id',$id)->delete()){
            return redirect('/keuangan/jurnal-umum/'.$data->no_jurnal);
        }else{
            return redirect('/keuangan/jurnal-umum/'.$data->no_jurnal);
        }
    }

    // Buku Besar
    public function bukubesar()
    {   
        $akun = AkunKeuangan::all();
        return view('kasir/keuanganrs/bukubesar.index',compact('akun'));
    }
    
    public function pilihakun($id)
    {
        $no_jurnal= Jurnal::where('kode_keuangan',$id)->groupBy('no_jurnal')->get();
        $id=$id;
        $akun= AkunKeuangan::where('kode_keuangan',$id)->select('nama_akun')->first();
       
        return view('kasir/keuanganrs/bukubesar.filter',compact('no_jurnal','id','akun'))->with('no',1);
    }

    public function pilihakun_request(Request $request,$id)
    {   
        //requet tanggal mm-yyyy
        request()->validate(['periode'=>'required']);
        $data =  $request->periode;
        $id=$id;
        $akun= AkunKeuangan::where('kode_keuangan',$id)->select('nama_akun')->first();
        $data1 = date('Y.m',strtotime($data));
        $no_jurnal= Jurnal::where('kode_keuangan',$id)->groupBy('no_jurnal')->where('no_jurnal',$data1)->get();
        return view('kasir/keuanganrs/bukubesar.filter',compact('no_jurnal','id','akun'))->with('no',1);
    }

    public function detailakun_bukubesar($id,$akun)
    {
        $id=$id;
        $akun=$akun;
        $namaakun= AkunKeuangan::where('kode_keuangan',$akun)->select('nama_akun')->first();
        $time = Jurnal::where('no_jurnal',$id)->where('kode_keuangan',$akun)->first();
        $bulan = date('F Y', strtotime($time->tanggal_transaksi));
        $jurnal = Jurnal::where('tanggal_transaksi',$id)->where('kode_keuangan',$akun)->get();
        $debet = Jurnal::where('no_jurnal',$id)->where('kode_keuangan',$akun)->where('balance','D')->sum('nilai');
        $kredit = Jurnal::where('no_jurnal',$id)->where('kode_keuangan',$akun)->where('balance','K')->sum('nilai');
      
        return view('kasir/keuanganrs/bukubesar.detail',compact('namaakun','bulan','jurnal','debet','kredit','id','akun'));
    }

    public function listakundetail($id,$akun)
	{
		DB::statement(DB::raw('set @rownum=0'));
        $detail = Jurnal::join('akun_keuangan','akun_keuangan.kode_keuangan','=','jurnal.kode_keuangan')
        ->where('jurnal.no_jurnal',$id)->where('jurnal.kode_keuangan',$akun)
        ->select([
		DB::raw('@rownum  := @rownum  + 1 AS rownum'),
        'jurnal.id',
        'jurnal.tanggal_transaksi',
        'jurnal.keterangan',
        'jurnal.kode_keuangan',
        'jurnal.nilai',
        'jurnal.balance',
        'akun_keuangan.nama_akun'
        ]);
        return DataTables::of($detail)
                ->addColumn('tanggal', function ($list) {
                    return tanggalkuitansi(valid_date($list->tanggal_transaksi));
                })
                ->addColumn('debet', function ($list) {
                    if($list->balance=='D'){
                    return 'Rp. '.number_format($list->nilai);    
                    }else{
                    return '0';
                    }
                })
                ->addColumn('kredit', function ($list) {
                    if($list->balance=='K'){
                    return 'Rp. '.number_format($list->nilai);    
                    }else{
                    return '0';
                    }
                })
                ->rawColumns(['tanggal','debet','kredit'])
                ->make(true);    
    }

    //neraca

    public function neraca()
    {
        $no_jurnal= Jurnal::groupBy('no_jurnal')->get();
        return view('kasir/keuanganrs/neraca.index',compact('no_jurnal'))->with('no',1);
    }

    public function neraca_request(Request $request)
    {   
        //requet tanggal mm-yyyy
        request()->validate(['periode'=>'required']);
        $data =  $request->periode;
        $data1 = date('Y.m',strtotime($data));
        $no_jurnal= Jurnal::groupBy('no_jurnal')->where('no_jurnal',$data1)->get();
        return view('kasir/keuanganrs/neraca.index',compact('no_jurnal'))->with('no',1);
    }

    public function neraca_bulan($id)
    {   
        $id=$id;
        $time = Jurnal::where('no_jurnal',$id)->first();
        $bulan = date('F Y', strtotime($time->tanggal_transaksi));
        $jurnal= Jurnal::join('akun_keuangan','akun_keuangan.kode_keuangan','=','jurnal.kode_keuangan')->where('akun_keuangan.kode_keuangan','<','40')->
        where('jurnal.no_jurnal',$id)->groupBy('jurnal.kode_keuangan')->select([
		DB::raw('@rownum  := @rownum  + 1 AS rownum'),
        'jurnal.id',
        'jurnal.no_jurnal',
        'jurnal.kode_keuangan',
        'akun_keuangan.nama_akun',
        db::raw('akun_keuangan.balance as balance_akun'),
        db::raw('jurnal.balance as balance_jurnal')
        ])->get();
        $debet=0;
        $kredit=0;
        foreach($jurnal as $list)
        {
            if($list->balance_akun=='D'){
                $kre = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','K')->sum('nilai');
                $deb = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','D')->sum('nilai');
                $nilai = $deb-$kre;
                $debet +=$nilai;    
            }
        }
        foreach($jurnal as $list)
        {
            if($list->balance_akun=='K'){
                $kre = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','K')->sum('nilai');
                $deb = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','D')->sum('nilai');
                $nilai = $kre-$deb;
                $kredit +=$nilai;    
            }
        }
        $jurnal_lancar= Jurnal::join('akun_keuangan','akun_keuangan.kode_keuangan','=','jurnal.kode_keuangan')->where('akun_keuangan.kode_keuangan','<','40')->
        where('aktiva','lancar')->where('jurnal.no_jurnal',$id)->groupBy('jurnal.kode_keuangan')->select([
		DB::raw('@rownum  := @rownum  + 1 AS rownum'),
        'jurnal.id',
        'jurnal.no_jurnal',
        'jurnal.kode_keuangan',
        'akun_keuangan.nama_akun',
        db::raw('akun_keuangan.balance as balance_akun'),
        db::raw('jurnal.balance as balance_jurnal')
        ])->get();
        $debet_lancar=0;
        $kredit_lancar=0;
        foreach($jurnal_lancar as $list)
        {
            if($list->balance_akun=='D'){
                $kre = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','K')->sum('nilai');
                $deb = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','D')->sum('nilai');
                $nilai = $deb-$kre;
                $debet_lancar +=$nilai;    
            }
        }
        foreach($jurnal_lancar as $list)
        {
            if($list->balance_akun=='K'){
                $kre = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','K')->sum('nilai');
                $deb = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','D')->sum('nilai');
                $nilai = $kre-$deb;
                $kredit_lancar +=$nilai;    
            }
        }
        $jurnal_tetap= Jurnal::join('akun_keuangan','akun_keuangan.kode_keuangan','=','jurnal.kode_keuangan')->where('akun_keuangan.kode_keuangan','<','40')->
        where('aktiva','tetap')->where('jurnal.no_jurnal',$id)->groupBy('jurnal.kode_keuangan')->select([
		DB::raw('@rownum  := @rownum  + 1 AS rownum'),
        'jurnal.id',
        'jurnal.no_jurnal',
        'jurnal.kode_keuangan',
        'akun_keuangan.nama_akun',
        db::raw('akun_keuangan.balance as balance_akun'),
        db::raw('jurnal.balance as balance_jurnal')
        ])->get();
        $debet_tetap=0;
        $kredit_tetap=0;
        foreach($jurnal_tetap as $list)
        {
            if($list->balance_akun=='D'){
                $kre = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','K')->sum('nilai');
                $deb = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','D')->sum('nilai');
                $nilai = $deb-$kre;
                $debet_tetap +=$nilai;    
            }
        }
        foreach($jurnal_lancar as $list)
        {
            if($list->balance_akun=='K'){
                $kre = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','K')->sum('nilai');
                $deb = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','D')->sum('nilai');
                $nilai = $kre-$deb;
                $kredit_tetap +=$nilai;    
            }
        }
        //return $debet;
        return view('kasir/keuanganrs/neraca.detail',compact('debet','kredit','bulan','id','jurnal','kredit_lancar','kredit_tetap','debet_lancar','debet_tetap'))->with('no',1);
    }

    public function listneracadetail_lancar($id)
	{
		DB::statement(DB::raw('set @rownum=0'));
        $detail = Jurnal::join('akun_keuangan','akun_keuangan.kode_keuangan','=','jurnal.kode_keuangan')->wherebetween('akun_keuangan.kode_keuangan',[11,39])->groupBy('jurnal.kode_keuangan')->
       where('aktiva','lancar')->where('jurnal.no_jurnal',$id)->select([
		DB::raw('@rownum  := @rownum  + 1 AS rownum'),
        'jurnal.id',
        'jurnal.no_jurnal',
        'jurnal.kode_keuangan',
        'akun_keuangan.nama_akun',
        db::raw('akun_keuangan.balance as balance_akun'),
        db::raw('jurnal.balance as balance_jurnal')
        ]);
        return DataTables::of($detail)
                ->addColumn('debet', function ($list) {
                    
                    if($list->balance_akun=='D'){
                        $kre = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','K')->sum('nilai');
                        $deb = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','D')->sum('nilai');
                        $nilai = $deb-$kre;
                        return 'Rp. '.number_format($nilai);    
                    }else{
                    return '0';
                    }
                })
                ->addColumn('kredit', function ($list) {
                    
                    if($list->balance_akun=='K'){
                        $kre = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','K')->sum('nilai');
                        $deb = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','D')->sum('nilai');
                        $nilai = $kre-$deb;
                        return 'Rp. '.number_format($nilai);    
                    }else{
                    return '0';
                    }
                })
               
                ->rawColumns(['tanggal','debet','kredit'])
                ->make(true);    
    }
    public function listneracadetail_tetap($id)
	{
		DB::statement(DB::raw('set @rownum=0'));
        $detail = Jurnal::join('akun_keuangan','akun_keuangan.kode_keuangan','=','jurnal.kode_keuangan')->wherebetween('akun_keuangan.kode_keuangan',[11,39])->groupBy('jurnal.kode_keuangan')->
       where('aktiva','tetap')->where('jurnal.no_jurnal',$id)->select([
		DB::raw('@rownum  := @rownum  + 1 AS rownum'),
        'jurnal.id',
        'jurnal.no_jurnal',
        'jurnal.kode_keuangan',
        'akun_keuangan.nama_akun',
        db::raw('akun_keuangan.balance as balance_akun'),
        db::raw('jurnal.balance as balance_jurnal')
        ]);
        return DataTables::of($detail)
                ->addColumn('debet', function ($list) {
                    
                    if($list->balance_akun=='D'){
                        $kre = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','K')->sum('nilai');
                        $deb = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','D')->sum('nilai');
                        $nilai = $deb-$kre;
                        return 'Rp. '.number_format($nilai);    
                    }else{
                    return '0';
                    }
                })
                ->addColumn('kredit', function ($list) {
                    
                    if($list->balance_akun=='K'){
                        $kre = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','K')->sum('nilai');
                        $deb = Jurnal::where('no_jurnal',$list->no_jurnal)->where('kode_keuangan',$list->kode_keuangan)->where('balance','D')->sum('nilai');
                        $nilai = $kre-$deb;
                        return 'Rp. '.number_format($nilai);    
                    }else{
                    return '0';
                    }
                })
               
                ->rawColumns(['tanggal','debet','kredit'])
                ->make(true);    
    }
}
