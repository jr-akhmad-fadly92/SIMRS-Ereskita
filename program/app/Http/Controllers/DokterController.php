<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Dokter;
use Modules\Config\Entities\Config;
use Modules\Poli\Entities\Poli;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Registrasi;
use App\Jasa_medis;
use Auth;
use Excel;
use PDF;
use DB;
use Hash;
use DateTime;
use Yajra\DataTables\DataTables;
use App\Role;
use App\User;
use Flashy;

class DokterController extends Controller
{
    public function index()
    {
        //$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();
		$data['dokter'] = Dokter::all();
        return view('dokter.index',$data)->with('no', 1);
    }

    public function create()
    {
        $data['user'] = User::pluck('name','id');
        $data['poli'] = Poli::pluck('nama','id');
        return view('dokter.create',$data);
    }

    public function store(Request $request)
    {
      $data = request()->validate(['nama'=>'required|unique:dokters,nama']);
      $data['poli_id']= $request['poli_id'];
      $data['user_id'] = Auth::user()->id;

      Dokter::create($data);
      Flashy::success('Dokter Telah Ditambahkan');
      return redirect('dokter');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['dokter'] = Dokter::find($id);
        $data['user'] = User::pluck('name','id');
        $data['poli'] = Poli::pluck('nama','id');
        return view('dokter.edit',$data);
    }

    public function update(Request $request, $id)
    {
      $data = request()->validate(['nama'=>'required|unique:dokters,nama,'.$id]);
      $data['poli_id']= $request['poli_id'];
      $data['user_id'] = Auth::user()->id;
      Dokter::find($id)->update($data);
      Flashy::info('Data Dokter berhasil di update');
      return redirect('dokter');
    }

    public function destroy($id)
    {
        //
    }

    public function pendapatan_dokter()
    {   
        if(strtolower(Auth::user()->role()->first()->name)=='dokter'){
          $user = Pegawai::where('kategori_pegawai','1')->where('id',Auth::user()->pegawai_id)->get();
        }else{
          $user = Pegawai::where('kategori_pegawai','1')->get();
        }
        
        return view('dokter/pendapatan.pendapatan_dokter',compact('user'));
    }

    public function pendapatan_dokter_byrequest(Request $request)
    {
      if(strtolower(Auth::user()->role()->first()->name)=='dokter'){
        $user = Pegawai::where('kategori_pegawai','1')->where('id',Auth::user()->pegawai_id)->get();
      }else{
        $user = Pegawai::where('kategori_pegawai','1')->get();
      }
        if($request->dokter_id=='null')
        {
        $list_dokter  = Pegawai::where('kategori_pegawai','1')->select('*')->get();
        }else{
        $petugas = Pegawai::where('kategori_pegawai','1')->where('id',$request->dokter_id)->first();
        $list_dokter  = Pegawai::where('kategori_pegawai','1')->select('*')->where('id',$request->dokter_id)->get();
        }

        $tga = $request->tga;
        $tgb = $request->tgb;
        $dokter_id = $request->dokter_id;
        if ($request['lanjut']) {

            return view('dokter/pendapatan.pendapatan_dokter',compact('user','tga','tgb','dokter_id'));
    
          }elseif ($request['pdf']) {
    
            $no = 1;
            $config = Config::find(1);
    
            $periode = $request['tga'].' s/d '.$request['tgb'];
            
            $pdf = PDF::loadView('dokter/pendapatan.pdf_laporan_pendapatan_dokter',compact('no','user','tga','tgb','list_dokter','config','periode'),[
            'orientation' => 'L']);
            return $pdf->stream();
    
          } 
    }

    public function cek_pendapatan_dokter()
    {
        $user = Pegawai::where('kategori_pegawai','1')->get();
        return view('dokter/pendapatan.pendapatan_dokter_request',compact('user'));
    }

    public function cek_pendapatan_dokter_byrequest(Request $request)
    {
        request()->validate(['tga'=>'required', 'tgb'=>'required','username'=>'required','password'=>'required']);
        
        $user = Pegawai::where('kategori_pegawai','1')->get();
        if(Auth::user()->email==$request->username && Hash::check($request->password,Auth::user()->password) )
        {

          if($request->dokter_id=='null')
          {
          $list_dokter  = Pegawai::where('kategori_pegawai','1')->select('*')->get();
          }else{
          $petugas = Pegawai::where('kategori_pegawai','1')->where('id',$request->dokter_id)->first();
          $list_dokter  = Pegawai::where('kategori_pegawai','1')->select('*')->where('id',$request->dokter_id)->get();
          }
          $text='';
          $tga = $request->tga;
          $tgb = $request->tgb;
          $dokter_id = $request->dokter_id;
          if ($request['lanjut']) {

              return view('dokter/pendapatan.pendapatan_dokter_request',compact('user','tga','tgb','dokter_id','text'));
      
            }elseif ($request['pdf']) {
      
              $no = 1;
              $config = Config::find(1);
      
              $periode = $request['tga'].' s/d '.$request['tgb'];
              
              $pdf = PDF::loadView('dokter/pendapatan.pdf_laporan_pendapatan_dokter',compact('no','user','tga','tgb','list_dokter','config','periode'),[
              'orientation' => 'L']);
              return $pdf->stream();
      
            }

        }elseif($request->username==null || $request->password==null ){
          Flashy::info('ssUsername / Password anda tidak sesuai');
          return redirect('/pendapatan_dokter/cek');
        }else{
          Flashy::info('Username / Password anda tidak sesuai');
          return redirect('/pendapatan_dokter/cek');
        }

         
    }
    
    public function data_pendapatan_dokter($dokter,$tga,$tgb)
    {
        if($dokter=='null')
        {
        $list_dokter  = Pegawai::where('kategori_pegawai','1')->select('*')->get();
        }else{
        $list_dokter  = Pegawai::where('kategori_pegawai','1')->select('*')->where('id',$dokter)->get();
        }
        return DataTables::of($list_dokter)
        ->addColumn('tindakan', function ($data) use ($tga,$tgb) {
            
            $btn = db::table('folios')->join('tarifs','tarifs.id','=','folios.tarif_id')->join('foliopelaksanas','foliopelaksanas.folio_id','=','folios.id')
                ->whereBetween('folios.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->whereNotIn('folios.tarif_id',[1, 2, 3])
               // ->where('folios.jenis','TA')
                ->where('tarifs.mapping_pemeriksaan','TN')
                ->Where('foliopelaksanas.dokter_pelaksana',$data->id)->orWhere('foliopelaksanas.dokter_anestesi',$data->id)->orWhere('foliopelaksanas.dokter_anak',$data->id)
                ->orWhere('foliopelaksanas.dokter_bedah',$data->id)->orWhere('foliopelaksanas.dokter_operator1',$data->id)->orWhere('foliopelaksanas.dokter_lab',$data->id)
                ->orWhere('foliopelaksanas.dokter_operator2',$data->id)->orWhere('foliopelaksanas.dokter_radiologi',$data->id)->orWhere('foliopelaksanas.dokter_visit',$data->id)
                ->count();
            return $btn;
          })
          ->addColumn('pemeriksaan', function ($data) use ($tga,$tgb) {
            
            $btn = db::table('folios')->join('tarifs','tarifs.id','=','folios.tarif_id')->join('foliopelaksanas','foliopelaksanas.folio_id','=','folios.id')
                ->whereBetween('folios.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->whereNotIn('folios.tarif_id',[1, 2, 3])
                //->where('folios.jenis','TA')
                ->where('tarifs.mapping_pemeriksaan','PM')
                ->Where('foliopelaksanas.dokter_pelaksana',$data->id)->orWhere('foliopelaksanas.dokter_anestesi',$data->id)->orWhere('foliopelaksanas.dokter_anak',$data->id)
                ->orWhere('foliopelaksanas.dokter_bedah',$data->id)->orWhere('foliopelaksanas.dokter_operator1',$data->id)->orWhere('foliopelaksanas.dokter_lab',$data->id)
                ->orWhere('foliopelaksanas.dokter_operator2',$data->id)->orWhere('foliopelaksanas.dokter_radiologi',$data->id)->orWhere('foliopelaksanas.dokter_visit',$data->id)
                
                ->count();
            return $btn;
          })
          ->addColumn('konsultasi', function ($data) use ($tga,$tgb) {
            
            $btn = db::table('folios')->join('tarifs','tarifs.id','=','folios.tarif_id')->join('foliopelaksanas','foliopelaksanas.folio_id','=','folios.id')
                ->whereBetween('folios.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->whereNotIn('folios.tarif_id',[1, 2, 3])
               // ->where('folios.jenis','TA')
                ->where('tarifs.mapping_pemeriksaan','KS')
                ->Where('foliopelaksanas.dokter_pelaksana',$data->id)->orWhere('foliopelaksanas.dokter_anestesi',$data->id)->orWhere('foliopelaksanas.dokter_anak',$data->id)
                ->orWhere('foliopelaksanas.dokter_bedah',$data->id)->orWhere('foliopelaksanas.dokter_operator1',$data->id)->orWhere('foliopelaksanas.dokter_lab',$data->id)
                ->orWhere('foliopelaksanas.dokter_operator2',$data->id)->orWhere('foliopelaksanas.dokter_radiologi',$data->id)->orWhere('foliopelaksanas.dokter_visit',$data->id)
                
                ->count();
            return $btn;
          })
          ->addColumn('pendapatan_sementara', function ($data) use ($tga,$tgb) {
            
            $btn = db::table('folios')->join('foliopelaksanas','foliopelaksanas.folio_id','=','folios.id')->join('tarifs','tarifs.id','=','folios.tarif_id')
                ->whereBetween('folios.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->whereNotIn('folios.tarif_id',[1, 2, 3])
                //->where('folios.jenis','TA')
                ->Where('foliopelaksanas.dokter_pelaksana',$data->id)->orWhere('foliopelaksanas.dokter_anestesi',$data->id)->orWhere('foliopelaksanas.dokter_anak',$data->id)
                ->orWhere('foliopelaksanas.dokter_bedah',$data->id)->orWhere('foliopelaksanas.dokter_operator1',$data->id)->orWhere('foliopelaksanas.dokter_lab',$data->id)
                ->orWhere('foliopelaksanas.dokter_operator2',$data->id)->orWhere('foliopelaksanas.dokter_radiologi',$data->id)->orWhere('foliopelaksanas.dokter_visit',$data->id)
                ->sum('total');
            $dokter= Jasa_medis::find(1);
            $btn_fix = $btn;
            return number_format($btn_fix);
          })
          ->addColumn('pendapatan_rs', function ($data) use ($tga,$tgb) {
            
            $btn = db::table('folios')->join('foliopelaksanas','foliopelaksanas.folio_id','=','folios.id')->join('tarifs','tarifs.id','=','folios.tarif_id')
                ->whereBetween('folios.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->whereNotIn('folios.tarif_id',[1, 2, 3])
                //->where('folios.jenis','TA')
                ->Where('foliopelaksanas.dokter_pelaksana',$data->id)->orWhere('foliopelaksanas.dokter_anestesi',$data->id)->orWhere('foliopelaksanas.dokter_anak',$data->id)
                ->orWhere('foliopelaksanas.dokter_bedah',$data->id)->orWhere('foliopelaksanas.dokter_operator1',$data->id)->orWhere('foliopelaksanas.dokter_lab',$data->id)
                ->orWhere('foliopelaksanas.dokter_operator2',$data->id)->orWhere('foliopelaksanas.dokter_radiologi',$data->id)->orWhere('foliopelaksanas.dokter_visit',$data->id)
                ->sum('total');
            $dokter= Jasa_medis::find(1);
            $btn_fix = ($btn*(100-$dokter->dokter))/100;
            return number_format($btn_fix);
          })
          ->addColumn('pendapatan', function ($data) use ($tga,$tgb) {
            
            $btn = db::table('folios')->join('foliopelaksanas','foliopelaksanas.folio_id','=','folios.id')->join('tarifs','tarifs.id','=','folios.tarif_id')
                ->whereBetween('folios.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->whereNotIn('folios.tarif_id',[1, 2, 3])
                //->where('folios.jenis','TA')
                ->Where('foliopelaksanas.dokter_pelaksana',$data->id)->orWhere('foliopelaksanas.dokter_anestesi',$data->id)->orWhere('foliopelaksanas.dokter_anak',$data->id)
                ->orWhere('foliopelaksanas.dokter_bedah',$data->id)->orWhere('foliopelaksanas.dokter_operator1',$data->id)->orWhere('foliopelaksanas.dokter_lab',$data->id)
                ->orWhere('foliopelaksanas.dokter_operator2',$data->id)->orWhere('foliopelaksanas.dokter_radiologi',$data->id)->orWhere('foliopelaksanas.dokter_visit',$data->id)
                ->sum('total');
            $dokter= Jasa_medis::find(1);
            $btn_fix = ($btn*$dokter->dokter)/100;
            return number_format($btn_fix);
          })
          ->addColumn('nomor', function ($data) use ($tga,$tgb) {
            
            $btn =1;
            return $btn;
          })
          ->addColumn('detail', function ($data) use ($tga,$tgb) {
            
            $btn ='<button type="button" class="btn btn-primary btn-flat btn-sm detail" data-id='.$data->id.' data-toggle="modal" data-target="#detailpendapatan">
            Detail
            </button>';
            return $btn;
          })
          ->addColumn('pdf', function ($data) use ($tga,$tgb) {
            
            $btn = '<a href="'.url("detail_pendapatan_dokter/$tga".'sampai'."$tgb/$data->id").'" class="btn btn-info btn-sm btn-flat">pdf</a>';
            return $btn;
          })
          ->rawColumns(['tindakan','pemeriksaan','konsultasi','nomor','pendapatan','detail','pdf','pendapatan_sementara','pendapatan_rs'])
        ->make(true);
    }

    public function detail_pendapatan_dokter($tga,$tgb,$detail)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $list_pendapatan  = db::table('folios')->join('tarifs','tarifs.id','=','folios.tarif_id')->join('foliopelaksanas','foliopelaksanas.folio_id','=','folios.id')
        ->whereBetween('folios.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
        ->whereNotIn('folios.tarif_id',[1, 2, 3])
        //->where('folios.jenis','TA')
        ->Where('foliopelaksanas.dokter_pelaksana',$detail)->orWhere('foliopelaksanas.dokter_anestesi',$detail)->orWhere('foliopelaksanas.dokter_anak',$detail)
                ->orWhere('foliopelaksanas.dokter_bedah',$detail)->orWhere('foliopelaksanas.dokter_operator1',$detail)->orWhere('foliopelaksanas.dokter_lab',$detail)
                ->orWhere('foliopelaksanas.dokter_operator2',$detail)->orWhere('foliopelaksanas.dokter_radiologi',$detail)->orWhere('foliopelaksanas.dokter_visit',$detail)
                
        ->select(DB::raw('@rownum  := @rownum  + 1 AS rownum'),'folios.namatarif','tarifs.tarif_tindakandr','folios.total','folios.created_at','folios.registrasi_id')->get();
       
        return DataTables::of($list_pendapatan)
        ->addColumn('nama_pasien', function ($data) {
          $reg = Registrasi::where('registrasis.id',$data->registrasi_id)->first();
          return $reg->pasien->nama;
        })
        ->addColumn('tanggal', function ($data) {
            
          $btn = date('d-m-y',strtotime($data->created_at));
          return $btn;
        })
        ->addColumn('biaya', function ($data) {
          $dokter = Jasa_medis::find(1);
          $btn = $data->total;
          return number_format($btn);
        })
        ->addColumn('pendapatan_rs', function ($data) {
          $dokter = Jasa_medis::find(1);
          $btn = $data->total*(100-$dokter->dokter)/100;;
          return number_format($btn);
        })
        ->addColumn('pendapatan_dokter', function ($data) {
          $dokter = Jasa_medis::find(1);
          $btn = $data->total*$dokter->dokter/100;
          return number_format($btn);
        })
       
        ->rawColumns(['biaya','tanggal','nama_pasien','pendapatan_dokter','pendapatan_rs'])
        ->make(true);
    }

    public function pdf_detail_pendapatan_dokter($tga,$tgb,$detail)
    {
       
        $list_pendapatan  = db::table('folios')->join('tarifs','tarifs.id','=','folios.tarif_id')->join('foliopelaksanas','foliopelaksanas.folio_id','=','folios.id')
        ->whereBetween('folios.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
        ->whereNotIn('folios.tarif_id',[1, 2, 3])
        //->where('folios.jenis','TA')
        ->where('folios.dokter_id',$detail)
        ->where('foliopelaksanas.dokter_pelaksana',$detail)
        ->select('folios.registrasi_id','folios.namatarif','tarifs.tarif_tindakandr','folios.created_at','folios.total')->get();
        $total_sementara = db::table('folios')->join('tarifs','tarifs.id','=','folios.tarif_id')->join('foliopelaksanas','foliopelaksanas.folio_id','=','folios.id')
        ->whereBetween('folios.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
        ->whereNotIn('folios.tarif_id',[1, 2, 3])
        ->where('foliopelaksanas.dokter_pelaksana',$detail)
        //->where('folios.jenis','TA')
        ->whereIn('folios.jenis',['TA','TI','TG'])
        ->where('folios.dokter_id',$detail)
        ->sum('folios.total');
        $jasa = db::table('jasa_medis')->where('id',1)->first();
        $total_dokter = ($total_sementara*$jasa->dokter)/100;
        $total_rs = ($total_sementara*(100-$jasa->dokter))/100;
        $tga = $tga;
        $tgb = $tgb;
        $dokter_id = $detail;
        $no = 1;
        $config = Config::find(1);
        $periode = $tga.' s/d '.$tgb;
        $pdf = PDF::loadView('dokter/pendapatan.pdf_detail_pendapatan_dokter',compact('total_sementara','jasa','no','tga','tgb','list_pendapatan','config','periode','total_dokter','total_rs','dokter_id'),[
         'orientation' => 'L']);
        return $pdf->stream();
    }

}
