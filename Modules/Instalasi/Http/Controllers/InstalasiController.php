<?php

namespace Modules\Instalasi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Instalasi\Http\Requests\SaveinstalasiRequest;
use Modules\Instalasi\Http\Requests\UpdateinstalasiRequest;
use Modules\Instalasi\Entities\Instalasi;

use App\User;
use App\Role;
use Auth;

class InstalasiController extends Controller
{
    public function index()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $instalasi = Instalasi::all();
            return view('instalasi::index', compact('instalasi'))->with('no', 1);
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function create()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            return view('instalasi::create');
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function store(SaveinstalasiRequest $request)
    {
      Instalasi::create($request->all());
      return redirect()->route('instalasi');
    }

    public function show()
    {
        return view('instalasi::show');
    }

    public function edit($id)
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $instalasi = Instalasi::find($id);
            return view('instalasi::edit', compact('instalasi'));
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function update(UpdateinstalasiRequest $request, $id)
    {
      Instalasi::find($id)->update($request->all());
      return redirect()->route('instalasi');
    }

    public function destroy()
    {
    }
}
