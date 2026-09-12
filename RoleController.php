<?php

namespace Modules\Role\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\User;
use App\Role;
use Auth;
use Flashy;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $role = Role::all();
            return view('role::index', compact('role'))->with('no', 1);
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
        return view('role::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $data = request()->validate([
        'name' => 'required|unique:roles,name',
        'display_name' => 'required|unique:roles,display_name',
        'description' => 'sometimes'
      ]);
      Role::create($data);
      Flashy::success('Role baru berhasil di tambahkan');
      return redirect()->route('role');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('role::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('role::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
