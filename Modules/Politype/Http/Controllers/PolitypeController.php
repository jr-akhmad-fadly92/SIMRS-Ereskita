<?php

namespace Modules\Politype\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Politype\Entities\Politype;
use MercurySeries\Flashy\Flashy;
use App\User;
use App\Role;
use Auth;

class PolitypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $politype = Politype::all();
            return view('politype::index', compact('politype'))->with('no', 1);
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
            return view('politype::create');
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
      $data = request()->validate(['kode'=>'required|max:1','nama'=>'required']);
      Politype::create($data);
      Flashy::success('Politype berhasil di tambahkan');
      return redirect()->route('politype');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            return view('politype::show');
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
            $politype = Politype::find($id);
            return view('politype::edit', compact('politype'));
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
      $data = request()->validate(['kode'=>'required|max:1','nama'=>'required']);
      Politype::find($id)->update($data);
      Flashy::info('Politype berhasil di update');
      return redirect()->route('politype');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
