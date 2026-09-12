<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sifuser;
use App\Historiloguser;
use DB;
use Activity;
use Yajra\DataTables\DataTables;
use Auth;
use PDF;
use Modules\Tarif\Entities\Tarif;

class KontrolpanelController extends Controller
{
    public function updatesif(Request $request)
    {
        //$cek = Sifuser::where('id',$request->id)->first();
            
                DB::table('sif_user')->where('id',$request->id)->update([
                    'jam_masuk'=>$request->masuk,
                    'jam_pulang'=>$request->pulang,
                ]);
            
            return response()->json(['sukses'=>true]);
    }
    public function update ()
    {
        $tarif = Tarif::all();
        foreach($tarif as $data)
        {

            $awal = Tarif::where('id',$data->id)->first();
            if($data->tarif_kelas_rj==null)
            {
            Tarif::where('id',$data->id)->update([
                'tarif_tindakanpr'=>$data->tarif_kelas_3*30/100,
                'tarif_tindakandr'=>$data->tarif_kelas_3*40/100,
                'managemen'=>$data->tarif_kelas_3*30/100,
                
            ]);
            }else{
            Tarif::where('id',$data->id)->update([
                'tarif_tindakanpr'=>$data->tarif_kelas_rj*30/100,
                'tarif_tindakandr'=>$data->tarif_kelas_rj*40/100,
                'managemen'=>$data->tarif_kelas_rj*30/100,
                
            ]);
            }
        }
        return $tarif;
    }
    public function getsifonline()
    {
        $online = DB::select( DB::raw("
        SELECT users.name as user, roles.name as role ,histori_log_user.status,histori_log_user.sif
        FROM histori_log_user
        JOIN role_user ON role_user.user_id = histori_log_user.user_id
        JOIN roles ON roles.id = role_user.role_id
        JOIN users ON users.id = histori_log_user.user_id
        WHERE STATUS = 'on'") );
        return DataTables::of($online)
        ->make(true);
    }
}
