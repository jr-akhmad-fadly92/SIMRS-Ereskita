<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterJenisAlergi;
use App\MasterAlergi;
use App\HistoriAlergiPasien;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Dokter;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Role\Entities\Role;
use DB;
use Activity;
use Yajra\DataTables\DataTables;
use Auth;
use Flashy;
class AlergiController extends Controller
{
    public function get_data_histori_alergi($id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $reg = db::table('registrasis')->where('id',$id)->first();
        $detail = HistoriAlergiPasien::join('master_alergi','master_alergi.id','=','histori_alergi_pasien.jenis_alergi')->where('pasien_id',$reg->pasien_id)
        ->join('master_jenis_alergi','master_jenis_alergi.id','=','master_alergi.id_jenis_alergi')->select([
			DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'master_jenis_alergi.jenis_alergi as jenis_alergi','master_alergi.macam_alergi as alergi','histori_alergi_pasien.detail_alergi',
            'histori_alergi_pasien.created_at','histori_alergi_pasien.id'
			
        ])->get();
        return DataTables::of($detail)
                    ->addColumn('tanggal', function ($detail) {
                                return date('d F Y',strtotime($detail->created_at));
                    })
                    ->addColumn('kategori_alergi', function ($detail){
                        return $detail->jenis_alergi.' / '.$detail->alergi;
                    })
                    ->addColumn('aksi', function ($detail){
                        return '<button class="btn btn-danger btn-sm btn-flat hapushistorialergi" data-id="'.$detail->id.'" id="hapushistorialergi">Hapus</button>';
                    })
                    ->rawColumns(['tanggal','kategori_alergi','aksi'])
					->make(true);
    }

    public function input_histori_alergi(Request $request)
    {   
        $reg = db::table('registrasis')->where('id',$request['registrasi_id'])->first();
        db::table('histori_alergi_pasien')->insert([
            'registrasi_id'=>$request['registrasi_id'],
            'pasien_id'=>$reg->pasien_id,
            'dokter_id'=>$reg->dokter_id,
            'jenis_alergi'=>$request['jenis_alergi'],
            'detail_alergi'=>$request['detail_alergi'],
        ]);
        return response()->json(['sukses' => true]);
    }

    public function hapus_histori_alergi($id)
    {   
        //$reg = db::table('registrasis')->where('id',$request['registrasi_id'])->first();
        db::table('histori_alergi_pasien')->where('id',$id)->delete();
        return response()->json(['sukses' => true]);
    }
}
