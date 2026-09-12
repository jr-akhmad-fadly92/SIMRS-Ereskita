<?php

namespace Modules\Kategoriheader\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Kategoriheader\Entities\Kategoriheader;
use MercurySeries\Flashy\Flashy;
use App\User;
use App\Role;
use Auth;

class KategoriheaderController extends Controller
{
    public function index()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $kategoriheader = Kategoriheader::all();
            return view('kategoriheader::index', compact('kategoriheader'))->with('no', 1);
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function create()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            return view('kategoriheader::create');
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function store(Request $request)
    {
      $data = request()->validate(['nama'=>'required|unique:kategoriheaders,nama']);
      Kategoriheader::create($data);
      Flashy::success('Kategori header baru berhasil di tambahkan');
      return redirect()->route('kategoriheader');
    }

    public function show()
    {
        return view('kategoriheader::show');
    }

    public function edit($id)
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $header = Kategoriheader::find($id);
            return view('kategoriheader::edit', compact('header'));
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function update(Request $request, $id)
    {
      $data = request()->validate(['nama'=>'required|unique:kategoriheaders,nama,'.$id]);
      Kategoriheader::find($id)->update($data);
      Flashy::info('Kategori header berhasil di update');
      return redirect()->route('kategoriheader');
    }

    public function destroy()
    {
    }
}
