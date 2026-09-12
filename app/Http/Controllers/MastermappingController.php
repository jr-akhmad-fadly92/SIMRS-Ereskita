<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Mastermapping;
use Validator;
use Yajra\DataTables\DataTables;
use Modules\Tarif\Entities\Tarif;
use DB;
use App\User;
use App\Role;
use Auth;

class MastermappingController extends Controller
{
    public function index()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            return view('mastermapping.index');
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function dataList()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $mapping = Mastermapping::all();
        return view('mastermapping.datalist', compact('mapping'))->with('no', 1);
        }else{
            return redirect('/dashboard');
        }
        
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $cek = Validator::make($request->all(),[
            'mapping' => 'required|unique:mastermapping,mapping'
        ]);
        if ($cek->fails()) {
            return response()->json(['sukses'=>false, 'errors'=>$cek->errors()]);
        } else {
            $mapp = new Mastermapping();
            $mapp->mapping = $request['mapping'];
            $mapp->save();
            return response()->json(['sukses'=>true]);
        }
    }

    public function show($id)
    {
        $show = Mastermapping::find($id);
        return response()->json($show);
    }

    public function edit($id)
    {
        $mapping = Mastermapping::find($id);
        return response()->json($mapping);
    }

    public function update(Request $request, $id)
    {
        $cek = Validator::make($request->all(),[
            'mapping' => 'required|unique:mastermapping,mapping,'.$id
        ]);
        if ($cek->fails()) {
            return response()->json(['sukses'=>false, 'errors'=>$cek->errors()]);
        } else {
            $mapp = Mastermapping::find($id);
            $mapp->mapping = $request['mapping'];
            $mapp->update();
            return response()->json(['sukses'=>true]);
        }
    }

    public function destroy($id)
    {
        //
    }

    public function detailMapping($mastermapping_id='')
    {

    }
}
