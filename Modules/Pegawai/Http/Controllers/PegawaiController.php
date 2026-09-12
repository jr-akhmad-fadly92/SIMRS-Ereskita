<?php

namespace Modules\Pegawai\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Pegawai\Http\Requests\SavepegawaiRequest;
use Modules\Pegawai\Http\Requests\UpdatepegawaiRequest;
use Modules\Pegawai\Entities\Pegawai;
use App\User;
use Modules\Role\Entities\Role;
use Auth;
use App\Kategoripegawai;
use App\Departemen;
use App\MasterJabatan;
use App\StatusKtpPegawai;
use App\StatusPegawai;
use App\Apoteker;
use App\MasterBidang;
use Flashy;

class PegawaiController extends Controller
{
	public function index()
	{
		if(strtolower(Auth::user()->role()->first()->name)=='administrator'||strtolower(Auth::user()->role()->first()->name)=='kepegawaian' )
        {
			$pegawai = Pegawai::all();
			return view('pegawai::index', compact('pegawai'))->with('no',1);
        }else{
            return redirect('/dashboard');
        }
		
	}

	public function create()
	{
			$kat = Kategoripegawai::pluck('kategori', 'id');
			$departemen = Departemen::pluck('departemen', 'id');
			$jabatan = MasterJabatan::pluck('nama_jabatan', 'id');
			$status_ktp_pegawai = StatusKtpPegawai::pluck('keterangan', 'id');
			$status_pegawai = StatusPegawai::pluck('keterangan', 'id');
			$bidang = MasterBidang::pluck('nama_bidang', 'id');
			return view('pegawai::create', compact('kat','bidang','departemen','jabatan','status_ktp_pegawai','status_pegawai'));
	}

	public function store(Request $request)
	{
		
		/*Pegawai::create([
    	'nama' => strtoupper($request['nama']),
		'kode' => $request->kode,
		'kategori_pegawai' => $request->kategori_pegawai,
		'departemen' => $request->departemen,
		'jabatan' => $request->jabatan,
		'status_pegawai' => $request->status_pegawai,
		'tgllahir' => valid_date($request['tgllahir']),
		'tmplahir' => $request->tmplahir,
		'kelamin' => $request->kelamin,
		'status_ktp_pegawai' => $request->status_ktp_pegawai,
		'agama' => $request->agama,
		'alamat' => $request->alamat,
		'sip' => $request->sip,
		'str' => $request->str,
		'kompetensi' => $request->kompetensi,
		'tupoksi' => $request->tupoksi
		]);*/
		$data = $request->all();
		$data['nama'] = strtoupper($request['nama']);
		$data['tgllahir'] = valid_date($request['tgllahir']);
		$data['departemen']	= $request->departemen;
		$data['jabatan']	= $request->jabatan;
		$data['status_ktp_pegawai']	= $request->status_ktp_pegawai;
		$data['status_pegawai']	= $request->status_pegawai;
		
		$pegawai = Pegawai::create($data);
		if($request['kategori_pegawai']==6){
			Apoteker::create([
				'pegawai_id' => $pegawai->id,
				'nama' => $request['nama'],
			]);
		}
		Flashy::success('Pegawai '.$request['nama'].' berhasil ditambahkan');
		return redirect()->route('pegawai');
	}

	public function show()
	{
			return view('pegawai::show');
	}

	public function edit($id)
	{
		$pegawai = Pegawai::find($id);
		$departemen = Departemen::pluck('departemen', 'id');
		$kat = Kategoripegawai::pluck('kategori', 'id');
		$jabatan = MasterJabatan::pluck('nama_jabatan', 'id');
		$status_ktp_pegawai = StatusKtpPegawai::pluck('keterangan', 'id');
		$status_pegawai = StatusPegawai::pluck('keterangan', 'id');
		$bidang = MasterBidang::pluck('nama_bidang', 'id');
		return view('pegawai::edit', compact('pegawai', 'kat','bidang','departemen','jabatan','status_ktp_pegawai','status_pegawai'));
	}
	
	public function delete($id)
	{
		if(Pegawai::find($id)->delete()){
			$user = User::where('pegawai_id',$id)->first();
			if($user!=null){
				if($user->delete()){
				}
			}
			Flashy::success('Pegawai berhasil dihapus');
		}else{
			Flashy::error('Pegawai gagal dihapus');
		}
		return back();
	}

	public function update(UpdatepegawaiRequest $request, $id)
	{
		$pegawai = Pegawai::find($id);
		//$data = $request->all();
		//$data['nama'] = strtoupper($request['nama']);
		//$data['tgllahir'] = valid_date($request['tgllahir']);
		$pegawai->nama = strtoupper($request['nama']);
		$pegawai->kode = $request->kode;
		$pegawai->kategori_pegawai = $request->kategori_pegawai;
		$pegawai->departemen = $request->departemen;
		$pegawai->jabatan = $request->jabatan;
		$pegawai->status_pegawai = $request->status_pegawai;
		$pegawai->tgllahir = valid_date($request['tgllahir']);
		$pegawai->tmplahir = $request->tmplahir;
		$pegawai->kelamin = $request->kelamin;
		$pegawai->status_ktp_pegawai = $request->status_ktp_pegawai;
		$pegawai->agama = $request->agama;
		$pegawai->alamat = $request->alamat;
		$pegawai->sip = $request->sip;
		$pegawai->str = $request->str;
		$pegawai->kompetensi = $request->kompetensi;
		$pegawai->tupoksi = $request->tupoksi;
		$pegawai->update();
		if($request['kategori_pegawai']==6){
			Apoteker::create([
				'pegawai_id' => $pegawai->id,
				'nama' => $request['nama'],
			]);
		}else{
			$check_apoteker = Apoteker::where('pegawai_id', $id);
			if($check_apoteker!=null){
				$check_apoteker->delete();
			}
		}
		Flashy::info('Pegawai '.$request['nama'].' berhasil diupdate');
		return redirect()->route('pegawai');
	}

	public function destroy()
	{
	}
}
