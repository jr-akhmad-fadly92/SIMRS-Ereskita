<?php

namespace Modules\Poli\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Poli\Entities\Poli;

use Modules\Poli\Http\Requests\SavepoliRequest;
use Modules\Politype\Entities\Politype;
use Modules\Instalasi\Entities\Instalasi;
use Modules\Kamar\Entities\Kamar;
use MercurySeries\Flashy\Flashy;

use App\User;
use App\Role;
use Auth;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
          $poli = Poli::all();
          return view('poli::index', compact('poli'))->with('no', 1);
        }else{
            return redirect('/dashboard');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
          $data['poli'] = Politype::pluck('nama','kode');
          $data['instalasi'] = Instalasi::pluck('nama','id');
          $data['kamar'] = Kamar::pluck('nama','id');
          
          $data['kamar']->prepend('-- pilih --');
          $data['instalasi']->prepend('-- pilih --');
          $data['poli']->prepend('-- pilih --');
          return view('poli::create',$data);
        }else{
            return redirect('/dashboard');
        }
			
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      Poli::create([
            'nama' => $request->nama,
            'politype' => $request->politype,
            'bpjs' => $request->bpjs,
            'instalasi_id' => $request->cetak_antrian,
            'kuota' => $request->kuota
      ]);
      Flashy::success('Poli baru berhasil di tambahkan');
      return redirect()->route('poli');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
          return view('poli::show');
        }else{
            return redirect('/dashboard');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
          $data['poli_u'] = Poli::find($id);
          $data['poli'] = Politype::pluck('nama','kode');
          $data['instalasi'] = Instalasi::pluck('nama','id');
          $data['kamar'] = Kamar::pluck('nama','id');
          
          $data['kamar']->prepend('-- pilih --');
          $data['instalasi']->prepend('-- pilih --');
          $data['poli']->prepend('-- pilih --');
          return view('poli::edit', $data);
        }else{
            return redirect('/dashboard');
        }
      
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
      Poli::find($id)->update(['nama' => $request->nama,
      'politype' => $request->politype,
      'bpjs' => $request->bpjs,
      'instalasi_id' => $request->cetak_antrian,
      'kuota' => $request->kuota
      ]);
      Flashy::info('Poli berhasil di update');
      return redirect()->route('poli');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
