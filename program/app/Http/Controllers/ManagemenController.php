<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Pegawai\Entities\Pegawai;
use DB;
use Activity;
use Yajra\DataTables\DataTables;
use Auth;
use PDF;
use Flashy;
use Redirect;
use Modules\Pendidikan\Entities\Pendidikan;
use App\Historipendidikan;
use App\Historikesehatan;

class ManagemenController extends Controller
{
   // histori pegawai pendidikan dan kesehatan
   public function historipegawai()
   {
        return view('managemen/histori.index');
   }

   public function detail_historipegawai($id)
   {      
        $histori_pendidikan = Historipendidikan::join('pendidikans','pendidikans.id','=','histori_pendidikan.pendidikan_id')->where('pegawai_id',$id)->get();
        $histori_kesehatan = Historikesehatan::where('pegawai_id',$id)->get();
        $pegawai = Pegawai::join('kategoripegawais','kategoripegawais.id','=','pegawais.kategori_pegawai')
                        ->join('status_pegawai','status_pegawai.id','=','pegawais.status_pegawai')
                        ->select('pegawais.id','pegawais.kode','pegawais.nama','kategoripegawais.kategori','status_pegawai.keterangan')->where('pegawais.id',$id)->first();
        $pendidikan = Pendidikan::all();
        return view('managemen/histori.detail',compact('pegawai','pendidikan','histori_pendidikan','histori_kesehatan'))->with('no',1);
    }

   public function get_data_pegawai()
   {
        DB::statement(DB::raw('set @rownum=0'));   
        $list_pegawai = DB::select( DB::raw("SELECT @rownum  := @rownum  + 1 AS rownum,pegawais.id,pegawais.kode,pegawais.nama,kategoripegawais.kategori,status_pegawai.keterangan
        FROM pegawais
        JOIN kategoripegawais ON kategoripegawais.id = pegawais.kategori_pegawai
        JOIN status_pegawai ON status_pegawai.id = pegawais.status_pegawai
        WHERE pegawais.aktif = 'Y'") );
        return DataTables::of($list_pegawai)
        ->addColumn('kategori_pegawai', function ($list) {
            return $list->kategori.' / '.$list->keterangan;
        })
        ->addColumn('add', function ($list) {
            return ' <a href="'.url('managemen/histori-pegawai/'.$list->id).'" data-kode="'.$list->id.'"  data-nama="'.$list->nama.'" class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-search"></i></a> ';
        })
        ->rawColumns(['add','kategori_pegawai'])
        ->make(true);
   }
   public function get_data_pendidikan($id)
   {
        DB::statement(DB::raw('set @rownum=0'));   
        $list_pendidikan = DB::select( DB::raw("SELECT @rownum  := @rownum  + 1 AS rownum,histori_pendidikan.pegawai_id, pendidikans.pendidikan,histori_pendidikan.institut,histori_pendidikan.masuk_pendidikan,
        histori_pendidikan.keluar_pendidikan
        FROM histori_pendidikan
        JOIN pendidikans ON pendidikans.id = histori_pendidikan.pendidikan_id
        WHERE histori_pendidikan.pegawai_id=".$id."") );
        return DataTables::of($list_pendidikan)
        ->addColumn('masuk', function ($list) {
            return tanggalkuitansi($list->masuk_pendidikan);
        })
        ->addColumn('keluar', function ($list) {
            return tanggalkuitansi($list->keluar_pendidikan);
        })
        ->addColumn('aksi', function ($list) {
            return ' <button data-id="'.$list->id.'"  data-institut="'.$list->institut.'" data-masuk="'.$list->masuk_pendidikan.'" data-keluar="'.$list->keluar_pendidikan.'" data-pendidikan="'.$list->pendidikan_id.'" class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-search"></i></button> ';
        })
        ->rawColumns(['aksi','masuk','keluar'])
        ->make(true);
   }
   public function input_pendidikan_pegawai(Request $request)
   {
       $cek = Historipendidikan::where('pegawai_id',$request->pegawai_id)->where('pendidikan_id',$request->pendidikan_id)->count();
       if($cek<1)
       {
            Historipendidikan::insert([
               'pegawai_id'=>$request->pegawai_id,
               'pendidikan_id'=>$request->pendidikan_id,
               'institut'=>$request->institut,
               'masuk_pendidikan'=>$request->masuk_pendidikan,
               'keluar_pendidikan'=>$request->keluar_pendidikan,
               'keterangan'=>$request->keterangan,
               
           ]);
            Flashy::success('Data Berhasil di input');
           return redirect('managemen/histori-pegawai/'.$request->pegawai_id);
       }elseif($request->id!=null){
        Historipendidikan::where('id',$request->id)->update([
            'pendidikan_id'=>$request->pendidikan_id,
            'institut'=>$request->institut,
            'masuk_pendidikan'=>$request->masuk_pendidikan,
            'keluar_pendidikan'=>$request->keluar_pendidikan,
            'keterangan'=>$request->keterangan,
        ]);
        Flashy::info('data Berhasil di update ');
        return redirect('managemen/histori-pegawai/'.$request->pegawai_id);
       }else{
        Flashy::error('Maaf data udah ada ');
        return redirect('managemen/histori-pegawai/'.$request->pegawai_id);
           
       }
   }
   public function input_kesehatan_pegawai(Request $request)
   {
       if($request->id==null)
       {
            Historikesehatan::insert([
               'pegawai_id'=>$request->pegawai_id,
               'riwayat_penyakit'=>$request->riwayat_penyakit,
               'opnam'=>$request->opnam,
               'masuk_opnam'=>$request->masuk_opnam,
            ]);
            Flashy::success('Data Berhasil di input');
           return redirect('managemen/histori-pegawai/'.$request->pegawai_id);
        }else{
            Historikesehatan::where('id',$request->id)->update([
                'riwayat_penyakit'=>$request->riwayat_penyakit,
                'opnam'=>$request->opnam,
                'masuk_opnam'=>$request->masuk_opnam,
            ]);
            Flashy::info('data Berhasil di update ');
            return redirect('managemen/histori-pegawai/'.$request->pegawai_id);
        }
   }

}
