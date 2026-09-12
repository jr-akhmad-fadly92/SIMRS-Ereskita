<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Tarif\Entities\Tarif;
use Modules\Config\Entities\Tahuntarif;
use Yajra\DataTables\DataTables;
use DB;
use App\User;
use App\Role;
use Auth;

class MappingController extends Controller
{
    public function index()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            return view('mapping.index');
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function dataTarif($tahuntarif_id='', $jenis='', $kategoritarif_id='')
    {
        if ($kategoritarif_id) {
          $tarif = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('kategoritarif_id', $kategoritarif_id)->where('mastermapping_id', '=', NULL)->get();
          $kiri = ceil($tarif->count() / 2);
          $dataKiri = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('kategoritarif_id', $kategoritarif_id)->where('mastermapping_id', '=', NULL)->skip(0)->take($kiri)->get();
          $dataKanan = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('kategoritarif_id', $kategoritarif_id)->where('mastermapping_id', '=', NULL)->skip($kiri)->take($kiri)->get();
        } else {
          $tarif = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('mastermapping_id', '=', NULL)->get();
          $kiri = ceil($tarif->count() / 2);
          $dataKiri = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('mastermapping_id', '=', NULL)->skip(0)->take($kiri)->get();
          $dataKanan = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('mastermapping_id', '=', NULL)->skip($kiri)->take($kiri)->get();
        }
        return view('mapping.dataTarif', compact('tarif', 'dataKiri', 'dataKanan'))->with('no', 1);
    }

    public function simpanMapping(Request $request)
    {
        $total = $request['total'];
        $mastermapping_id = $request['mastermapping_id'];
        $id = [];
        for ($i=1; $i <= $total ; $i++)
        {
            if(!empty($request['tarif'.$i])) {
                $tarif = Tarif::find($request['tarif'.$i]);
                $tarif->mastermapping_id = $mastermapping_id;
                $tarif->update();
                array_push($id, $tarif->id);
            }
        }
        $trf = Tarif::whereIn('id', $id)->get();
        return response()->json(['sukses'=>true, 'message'=>$trf->count().' tarif berhasil di mapping']);
    }

    public function mappingDetail($mastermapping_id='')
    {
        $tarif = Tarif::all()
        ->where('mastermapping_id', $mastermapping_id);
        return DataTables::of($tarif)
            
            ->make(true);

    }

}
