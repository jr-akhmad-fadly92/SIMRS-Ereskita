<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Fasilitas;
use MercurySeries\Flashy\Flashy;
use App\User;
use Modules\Role\Entities\Role;
use Auth;


class FasilitasController extends Controller
{
    public function index()
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
      {
        $data['fasilitas'] = Fasilitas::find(1);
        return view('fasilitas.index', $data);  
      }else{
        return redirect('/dashboard');
      }

      
    }

    public function update(Request $request, $id)
    {
      $fas = Fasilitas::find($id);
      $fas->fasilitas = $request['fasilitas'];
      $fas->update();
      Flashy::success('Fasilitas berhasil disimpan');
      return redirect('fasilitas');
    }
}
