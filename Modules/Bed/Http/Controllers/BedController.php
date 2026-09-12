<?php

namespace Modules\Bed\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Kamar\Entities\Kamar;
use Modules\Bed\Entities\Bed;
use App\HistoriRawatInap;
use Modules\Kelas\Entities\Kelas;
use Modules\Bed\Http\Requests\SavebedRequest;
use Modules\Bed\Http\Requests\UpdatebedRequest;
use MercurySeries\Flashy\Flashy;
use DB;

use App\User;
use App\Role;
use Auth;

class BedController extends Controller
{
    public function index()
    {
        $bed = Bed::all();
        return view('bed::index', compact('bed'))->with('no', 1);
    }

    public function indexbaru()
    {
        $kamar = Kamar::all();
        $kelas = Kelas::all();
        $bed = Bed::all();
        return view('bed::indexbaru', compact('bed','kamar','kelas'))->with('no', 1);
    }

    public function indexbaru_request(Request $request)
    {
      $kamar = Kamar::all();
      $kelas = Kelas::all();
      $kamar_id = [];

      foreach (Kamar::all() as $key => $d) {

        $kamar_id[] = ''.$d->id.'';

      }

      $kelas_id = [];

        foreach(Kelas::all() as $d){

          $kelas_id[] = '' . $d->id . '';

        }
        $bed = Bed::join('kamars','kamars.id','=','beds.kamar_id')
                    ->whereIn('beds.kamar_id',!empty($request['kamar']) ? [$request['kamar']] : $kamar_id)
                    ->whereIn('kamars.kelas_id',!empty($request['kelas']) ? [$request['kelas']] : $kelas_id)
                    ->whereIn('beds.reserved',!empty($request['status']) ? [$request['status']] : ['Y','AP','N'])
                    ->select('beds.nama as nama_bed','kamars.nama as nama_kamar','beds.reserved','beds.id as bed_id')
                    ->get();
        $rawat = db::table('rawatinaps')->join('registrasis','registrasis.id','=','rawatinaps.registrasi_id')
                  ->whereIn('registrasis.posisi_pasien',['sedang diperiksa','menunggu persalinan','rawat inap'])
                  ->get();
        return view('bed::indexbaru', compact('bed','kamar','kelas','rawat'))->with('no', 1);
    }

    public function create()
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
          return view('bed::create');
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function store(SavebedRequest $request)
    {
      $bed = new Bed();
      $bed->kamar_id = $request['kamarid'];
      $bed->nama = $request['nama'];
      $bed->kode = $request['kode'];
      $bed->reserved = 'N';
      $bed->keterangan = !empty($request['keterangan']) ? $request['keterangan'] : '-';
      $bed->save();
      Flashy::success('Bed baru berhasil di tambahkan');
	  
	  $bedall = Bed::All();
	  foreach($bedall as $a)
	  {
		  $b=$a;
	  }
      return $b;
    }

    public function show()
    {
        return view('bed::show');
    }

    public function edit($id)
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
          $kamar 	= Kamar::pluck('nama', 'id');
          $bed 	= Bed::find($id);
          return view('bed::edit', compact('kamar','bed'));
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function update(UpdatebedRequest $request, $id)
    {
      $bed = Bed::find($id);
      $bed->kamar_id = $request['kamarid'];
      $bed->nama = $request['nama'];
      $bed->kode = $request['kode'];
      $bed->keterangan = !empty($request['keterangan']) ? $request['keterangan'] : '-';
      $bed->update();
      Flashy::info('Bed berhasil di update');
      return redirect()->route('bed');
    }

    public function destroy()
    {
    }

    public function kosongkanBed($id)
    {
      $bed = Bed::find($id);
      $bed->reserved = 'N';
      $bed->update();
      Flashy::info('Bed '.strtoupper($bed->nama).' berhasil di kosongkan.');
      return redirect()->route('bed');
    }

    public function batalKosongkanBed($id)
    {
      $bed = Bed::find($id);
      $bed->reserved = 'Y';
      $bed->update();
      Flashy::info('Bed '.strtoupper($bed->nama).' berhasil di kembalikan ke status isi.');
      return redirect()->route('bed');
    }

    public function display_bed()
    {
        $data['totalbed'] = Bed::count();
        $data['kelas'] = Kelas::where('nama', '<>', '-')->get();
        return view('displaytempattidur.displaybed', $data)->with('no', 1);
    }


}
