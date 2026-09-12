<?php

namespace Modules\Asuransi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Asuransi\Entities\Asuransi;
use Flashy;

class AsuransiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
      $data['asuransi'] = Asuransi::all();
        return view('asuransi::index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('asuransi::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $data = request()->validate(['nama'=>'required|unique:asuransis,nama','kode'=>'required', 'id_prk'=>'required','alamat'=>'required','diskon'=>'required','plafon'=>'required']);
      Asuransi::create($data);
      return redirect()->route('asuransi');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('asuransi::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
      $data['asuransi'] = Asuransi::find($id);
        return view('asuransi::edit',$data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request,$id)
    {
      $data = request()->validate(['nama'=>'required|unique:asuransis,nama,'.$id,'kode'=>'required', 'id_prk'=>'required','alamat'=>'required','diskon'=>'required','plafon'=>'required']);
      Asuransi::find($id)->update($data);
      Flashy::info('Data Asuransi Berhasil Ditambahkan');
      return redirect()->route('asuransi');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
