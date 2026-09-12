<?php

namespace Modules\User\Http\Controllers;

use App\Role;
use App\User;
use Auth;

use DB;
use Flashy;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pegawai\Entities\Pegawai;

class UserController extends Controller {
	public function index() {
		if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $user = User::whereNotIn('id',[1])->get();
			return view('user::index', compact('user'))->with('no', 1);
        }else{
            return redirect('/dashboard');
        }
		
	}

	public function create() {
		if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $role = Role::pluck('display_name', 'name');
			$pegawai = Pegawai::pluck('nama', 'id');
			return view('user::create', compact('role', 'pegawai'));
        }else{
            return redirect('/dashboard');
        }
		
	}

	public function store(Request $request) {
		request()->validate([
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|min:6|confirmed',
		]);

		User::insert([
			'pegawai_id' => Pegawai::find($request['name'])->id,
			'name' => Pegawai::find($request['name'])->nama,
			'email' => $request['email'],
			'kelompokkelas_id' => $request['kelompokkelas_id'],
			'password' => bcrypt($request['password']),
		]);
		$user = User::where('pegawai_id',Pegawai::find($request['name'])->id)->first();
		$role = Role::where('name', $request['role'])->first();
		$user->attachRole($role);
		Flashy::success('Data user berhasil ditambahkan');
		return redirect()->route('user.create');
	}

	public function show($id) {
		
		$user = User::find($id);
		return view('user::show', compact('user'));
	}

	public function updateUser(Request $request) {
		if (!$request['password']) {
			DB::table('users')->where('id', Auth::user()->id)->update(['name' => $request['name']]);
			Flashy::success('Nama lengkap berhasil di ubah jadi ' . Auth::user()->name);
		} else {
			DB::table('users')->where('id', Auth::user()->id)->update(['name' => $request['name'], 'password' => bcrypt($request['password'])]);
			Flashy::success('Nama lengkap berhasil di ubah jadi ' . Auth::user()->name . ' password jadi ' . $request['password']);
		}
		return redirect('user/' . Auth::user()->id . '/show');
	}

	public function edit($id) {
		if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
        {
            $user = User::find($id);
			$role = Role::select('display_name', 'id')->get();
			$pegawai = Pegawai::pluck('nama', 'nama');
			return view('user::edit', compact('user', 'role','pegawai'));
        }else{
            return redirect('/dashboard');
        }
		
	}

	public function update(Request $request, $id) {
		request()->validate([
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users,email,' . $id,
			// 'password' => 'sometimes|min:6|confirmed',
		]);

		if (!$request['password']) {
			$user = User::find($id);
			$user->update([
				'name' => $request['name'],
				'email' => $request['email'],
				'kelompokkelas_id' => $request['kelompokkelas_id'],
			]);
		} else {
			$user = User::find($id);
			$user->update([
				'name' => $request['name'],
				'email' => $request['email'],
				'kelompokkelas_id' => $request['kelompokkelas_id'],
				'password' => bcrypt($request['password']),
			]);
		}
		if ($request['role']) {
			DB::table('role_user')->where('user_id', $user->id)->update(['role_id' => $request['role']]);
		}
		return redirect()->route('user.create');
	}

	public function destroy() {
	}
}
