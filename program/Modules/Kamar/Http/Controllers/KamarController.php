<?php

namespace Modules\Kamar\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Kamar\Entities\Kamar;
use Modules\Kelas\Entities\Kelas;
use Modules\Bed\Entities\Bed;
use MercurySeries\Flashy\Flashy;
use App\HistoriRawatInap;
use App\Kelompokkelas;

use App\User;
use App\Role;
use Auth;

class KamarController extends Controller
{
    public function index()
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
      {
        $kamar = Kamar::orderBy('id', 'asc')->get();
        return view('kamar::index', compact('kamar'))->with('no', 1);
      }else{
          return redirect('/dashboard');
      }
       
    }

    public function create()
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
      {
        $kelas = Kelas::where('nama', '<>', '-')->pluck('nama', 'id');
        $kelompok = Kelompokkelas::pluck('kelompok', 'id');
        return view('kamar::create', compact('kelas', 'kelompok'));
      }else{
          return redirect('/dashboard');
      }
        
    }

    public function store(Request $request)
    {
      $data = request()->validate(['kelompokkelas_id'=>'required','nama'=>'required', 'kelas_id'=>'required', 'tarif'=>'required']);
      Kamar::create($data);
      Flashy::success('Kamar baru berhasil di tambahkan');
      return redirect()->route('kamar');
    }

    public function show()
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
      {
        return view('kamar::show');
      }else{
          return redirect('/dashboard');
      }
        
    }

    public function edit($id)
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
      {
        $kelas = Kelas::pluck('nama', 'id');
        $kamar = Kamar::find($id);
        $kelompok = Kelompokkelas::pluck('kelompok', 'id');
        return view('kamar::edit', compact('kelas', 'kamar', 'kelompok'));
      }else{
          return redirect('/dashboard');
      }
        
    }

    public function update(Request $request, $id)
    {
      $data = request()->validate(['kelompokkelas_id'=>'required','nama'=>'required', 'kelas_id'=>'required', 'tarif'=>'required']);
      Kamar::find($id)->update($data);
      Flashy::info('Kamar berhasil di update');
      return redirect()->route('kamar');
    }

    public function destroy()
    {
    }

    //Ajax
    public function getKelas($kelompokkelas_id='')
    {
      $kelompok = Kamar::where('kelompokkelas_id', $kelompokkelas_id)->distinct()->get(['kelas_id']);
      $kelas = [];
      foreach ($kelompok as $key => $d) {
        $kelas[] = ['id' => $d->kelas_id, 'kelas' => Kelas::find($d->kelas_id)->nama];
      }
      return response()->json($kelas);
    }

    public function getKamar($kelompokkelas_id, $kelas_id)
    {
      //$kamar = Kamar::where('kelompokkelas_id', $kelompokkelas_id)->where('kelas_id', $kelas_id)->get(['id', 'nama']);
      $kamar = Kamar::where('kelas_id', $kelas_id)->get(['id', 'nama']);
      return response()->json($kamar);
    }

    // histori kamar ====================================================================
    public function indexhistorikamar() 
    {
      return view('kamar::histori_kamar.indexhistori');
    }
    public function indexhistorikamar_byRequest(Request $request)
    {
      request()->validate(['tga'=>'required', 'tgb'=>'required']);
      $bed = [];
      foreach (Bed::select('id', 'nama')->get() as $key => $d) {
      $bed[] = '' . $d->id . '';
      }
      $kam = [];
      foreach (Kamar::select('id', 'nama')->get() as $key => $d) {
      $kam[] = '' . $d->id . '';
      }
      $kel = [];
      foreach (Kelas::select('id', 'nama')->get() as $key => $d) {
      $kel[] = '' . $d->id . '';
      }
      $tampil_data = HistoriRawatInap::
                join('beds', 'beds.id', '=', 'histori_rawatinap.bed_id')
                ->join('kamars', 'kamars.id', '=', 'histori_rawatinap.kamar_id')
                ->join('kelas', 'kelas.id', '=', 'histori_rawatinap.kelas_id')
                ->join('pasiens', 'pasiens.id', '=', 'histori_rawatinap.pasien_id')
                //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])
                ->whereBetween('histori_rawatinap.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
                ->whereIn('histori_rawatinap.bed_id', !empty($request['bed']) ? [$request['bed']] : $bed )
                ->whereIn('histori_rawatinap.kamar_id', !empty($request['nama_kamar']) ? [$request['nama_kamar']] : $kam )
                ->whereIn('histori_rawatinap.kelas_id', !empty($request['kelas']) ? [$request['kelas']] : $kel )
                ->select('pasiens.nama as nama_pasien', 'kamars.nama as nama_kamar', 'beds.nama as nama_bed', 'kelas.nama as nama_kelas', 'pasiens.nama', 'histori_rawatinap.created_at','histori_rawatinap.updated_at')
                ->get();
      if ($request['lanjut']) {
        return view('kamar::histori_kamar.indexhistori',compact('tampil_data'))->with('no', 1);
      }
    }
}
