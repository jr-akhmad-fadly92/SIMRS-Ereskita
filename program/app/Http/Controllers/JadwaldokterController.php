<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Jadwaldokter;
use Modules\Role\Entities\Role;
use Auth;
use App\User;
use MercurySeries\Flashy\Flashy;
use Yajra\DataTables\DataTables;
class JadwaldokterController extends Controller
{
    public function index()
    {
        $data['jadwal'] = Jadwaldokter::all();
        return view('jadwaldokter.index', $data)->with('no', 1);
    }

    public function getData()
    {
      $Jadwaldokter = Jadwaldokter::select([
        'id',
        'poli',
        'dokter',
        'hari',
        'jam_mulai',
        'jam_berakhir',
       ])->orderBy('id', 'asc');

      return DataTables::of($Jadwaldokter)
      
      ->addColumn('jam', function ($Jadwaldokter) {
        return '<td>'. $Jadwaldokter->jam_mulai. ' s/d ' .$Jadwaldokter->jam_berakhir. ' WIB</td>';
        })
      ->addColumn('edit', function ($Jadwaldokter) {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' OR strtolower(Auth::user()->role()->first()->name)=='admission')
        {
        return '<a href="'.url('hapus-jadwal/'. $Jadwaldokter->id).'" onclick="return confirm("Yakin jadwal ini akan di hapus?")" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>';
        }else{
          return '';
        }
        
      })
     ->rawColumns(['edit','jam'])
      ->make(true);
    }

    public function store(Request $request)
    {
        request()->validate(['poli'=>'required', 'dokter'=>'required']);
        $d = new Jadwaldokter();
        $d->poli = $request['poli'];
        $d->dokter = $request['dokter'];
        $d->hari = $request['hari'];
        $d->jam_mulai = $request['jam_mulai'];
        $d->jam_berakhir = $request['jam_berakhir'];
        $d->save();
        Flashy::success('Jadwal Dokter berhasil ditambahkan');
        return redirect('jadwal-dokter');
    }

    public function hapusJadwal($id)
    {
        Jadwaldokter::find($id)->delete();
        Flashy::info('Jadwal berhasil dihapus');
        return redirect('jadwal-dokter');
    }
}
