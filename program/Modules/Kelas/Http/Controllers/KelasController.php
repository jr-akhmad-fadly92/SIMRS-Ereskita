<?php

namespace Modules\Kelas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Kelas\Entities\Kelas;
use MercurySeries\Flashy\Flashy;

use App\User;
use App\Role;
use Auth;

class KelasController extends Controller
{
    public function index()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $kelas = Kelas::all();
            return view('kelas::index', compact('kelas'))->with('no', 1);
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function create()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            return view('kelas::create');
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function store(Request $request)
    {
      $data = request()->validate(['nama'=>'required|unique:kelas,nama']);
      Kelas::create($data);
      Flashy::success('Kelas baru berhasil di tambahkan');
      return redirect()->route('kelas');
    }

    public function show()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            return view('kelas::show');
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function edit($id)
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $kelas = Kelas::find($id);
            return view('kelas::edit', compact('kelas'));
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function update(Request $request, $id)
    {
      $data = request()->validate(['nama'=>'required|unique:kelas,nama,'.$id]);
      Kelas::find($id)->update($data);
      Flashy::info('Kelas berhasil di update');
      return redirect()->route('kelas');
    }

    public function destroy()
    {
    }
}
