<?php

namespace Modules\Kategoritarif\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Kategoriheader\Entities\Kategoriheader;
use MercurySeries\Flashy\Flashy;
use App\User;
use App\Role;
use Auth;
use Modules\Kategoritarif\Entities\Tbpelaksanatarif;

class KategoritarifController extends Controller
{
    public function index()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $kategoritarif = Kategoritarif::all();
            return view('kategoritarif::index', compact('kategoritarif'))->with('no', 1);
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function indexpelaksana()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $kategoritarif = Tbpelaksanatarif::all();
            return view('kategoritarif::index_pelaksana', compact('kategoritarif'))->with('no', 1);
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function create()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $header = Kategoriheader::pluck('nama', 'id');
            return view('kategoritarif::create', compact('header'));
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function store(Request $request)
    {
      $data = request()->validate(['namatarif'=>'required|unique:kategoritarifs,namatarif', 'kategoriheader_id'=>'required']);
      Kategoritarif::create($data);
      Flashy::success('Kategori tarif baru berhasil di tambahkan');
      return redirect()->route('kategoritarif');
    }

    public function createpelaksana()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            return view('kategoritarif::create_pelaksana');
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function storepelaksana(Request $request)
    {
        
        
      tbpelaksanatarif::create([
          'pelaksana'=>$request->pelaksana
      ]);
      Flashy::success('Kategori tarif baru berhasil di tambahkan');
      return redirect()->route('kategoritarif.pelaksana');
    }
    
    public function editpelaksana($id)
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $kategoritarif = Tbpelaksanatarif::find($id);
            return view('kategoritarif::edit_pelaksana', compact('kategoritarif'));
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function updatepelaksana(Request $request,$id)
    { 
        
        $pelaksana = Tbpelaksanatarif::find($id);
        $pelaksana->pelaksana = $request->pelaksana;
        $pelaksana->update();
        Flashy::info('Kategori tarif berhasil di update');
        return redirect()->route('kategoritarif.pelaksana');
    }

    public function show()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            return view('kategoritarif::show');
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function edit($id)
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $kategoritarif = Kategoritarif::find($id);
            $header = Kategoriheader::pluck('nama', 'id');
            return view('kategoritarif::edit', compact('kategoritarif', 'header'));
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function update(Request $request,$id)
    {
      $data = request()->validate(['namatarif'=>'required|unique:kategoritarifs,namatarif,'.$id, 'kategoriheader_id'=>'required']);
      Kategoritarif::find($id)->update($data);
      Flashy::info('Kategori tarif berhasil di update');
      return redirect()->route('kategoritarif');
    }

    public function destroy()
    {
    }
}
