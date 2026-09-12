<?php

namespace App\Http\Controllers;
use App\Nomorrm;
use Auth;
use DB;
use Flashy;
use Illuminate\Http\Request;
use Modules\Config\Entities\Config;
use Modules\Icd10\Entities\Icd10;
use Modules\Pasien\Entities\Agama;
use Modules\Pasien\Entities\District;
use Modules\Pasien\Entities\Pasien;
use Modules\Pasien\Entities\Province;
use Modules\Pasien\Entities\Regency;
use Modules\Pasien\Entities\Village;
use Modules\Pekerjaan\Entities\Pekerjaan;
use Modules\Pendidikan\Entities\Pendidikan;
use Modules\Asuransi\Entities\Asuransi;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Biayaregistrasi;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Registrasi\Entities\HistoriStatus;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Registrasi\Entities\Status;
use Modules\Registrasi\Entities\Tagihan;
use Modules\Registrasi\Entities\Tipelayanan;
use Modules\Registrasi\Http\Requests\SaveRegistrasiRequest;
use Modules\Rujukan\Entities\Rujukan;
use Modules\Sebabsakit\Entities\Sebabsakit;
use Modules\Pegawai\Entities\Pegawai;
use App\Historipengunjung;
use App\HistorikunjunganIRJ;

class RegperjanjianController extends Controller
{
	public function index($id = '') {
		$data['provinsi'] = Province::pluck('name', 'id');
		$data['kabupaten'] = Regency::pluck('name', 'id');
		$data['kecamatan'] = District::pluck('name', 'id');
		$data['desa'] = Village::pluck('name', 'id');
		$data['pekerjaan'] = Pekerjaan::pluck('nama', 'id');
		$data['agama'] = Agama::pluck('agama', 'id');
		$data['asuransi'] = Asuransi::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
		$data['status'] = Status::pluck('status', 'id');
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
		$data['rujukan'] = Rujukan::pluck('nama', 'id');
		$data['tipelayanan'] = Tipelayanan::pluck('tipelayanan', 'id');
		$data['sebabsakit'] = Sebabsakit::pluck('nama', 'id');
		if (Auth::user()->hasRole(['supervisor-rekammedis', 'administrator'])) {
			$data['poli'] = Poli::select('nama', 'id')->where('politype', 'J')->get();
		} else {
			$data['poli'] = Poli::select('nama', 'id')->whereIn('id', [11,19,20])->get();
		}
		
		$data['pasien'] = Pasien::find($id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['icd10'] = Icd10::all();
		session()->forget('pasienID');
		session()->forget('blm_terdata');
		return view('reg-perjanjian.index', $data);
	}

	public function antrianPoli($poli_id = NULL, $tgl = NULL)
	{
		$poli = Registrasi::where('poli_id', $poli_id)->where('created_at', 'like', $tgl . '%')->count();
		return $poli + 1;
	}

	public function searchPasien(Request $request)
	{
		request()->validate(['keyword' => 'required']);
		$keyword = $request['keyword'];
		$data = Pasien::where('nama', 'LIKE', '%' . $keyword . '%')
			->orWhere('no_rm', 'LIKE', '%' . $keyword . '%')
			->orWhere('no_rm_lama', 'LIKE', '%' . $keyword . '%')
			->orWhere('alamat', 'LIKE', '%' . $keyword . '%')
			->get();
		return view('reg-perjanjian.pasien', compact('data', 'keyword'))->with('no', 1);
	}

	public function savePerjanjian(SaveRegistrasiRequest $request)
	{
		request()->validate([
			'created_at' => 'required',
			// 'no_rm' => 'unique:pasiens,no_rm',
		]);
		DB::transaction(function () use ($request) {
			$no = Nomorrm::count() + 1;
			$no_rm = isset($request['no_rm']) ? $request['no_rm'] : $no;

			// Save data pasien
			$pasien = new Pasien();
			$pasien->nama = $request['nama'];
			$pasien->nik = $request['nik'];
			$pasien->tmplahir = $request['tmplahir'];
			$pasien->tgllahir = valid_date($request['tgllahir']);
			$pasien->kelamin = $request['kelamin'];
			$pasien->no_rm = sprintf("%08s", $no_rm);
			$pasien->province_id = $request['province_id'];
			$pasien->regency_id = $request['regency_id'];
			$pasien->district_id = $request['district_id'];
			$pasien->village_id = $request['village_id'];
			$pasien->alamat = $request['alamat'];
			$pasien->rt = $request['rt'];
			$pasien->rw = $request['rw'];
			$pasien->ibu_kandung = $request['ibu_kandung'];
			$pasien->status_marital = $request['status_marital'];
			$pasien->nohp = $request['nohp'];
			$pasien->negara = 'Indonesia';
			$pasien->pekerjaan_id = $request['pekerjaan_id'];
			$pasien->agama_id = $request['agama_id'];
			$pasien->pendidikan_id = $request['pendidikan_id'];
			$pasien->user_create = Auth::user()->name;
			$pasien->user_update = '';
			$pasien->save();

			//Save No RM
			if (!isset($request['no_rm']) || empty($request['no_rm']))
			{
				Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $no]);
			}

			// Save registrasi
			$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
			$reg = new Registrasi();
			$reg->pasien_id = $pasien->id;
			$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			$reg->status = $request['status'];
			$reg->keterangan = $request['keterangan'];
			$reg->rujukan = $request['rujukan'];
			$reg->antrian_id = NULL;
			$reg->kepesertaan = $request['kepesertaan']; //kepesertaan JKN
			$reg->hak_kelas_inap = $request['hakkelas'];
			$reg->no_rujukan = $request['nomorrujukan'];
			$reg->tgl_rujukan = $request['tglrujukan'];
			$reg->ppk_rujukan = $request['kodeasal'];
			$reg->tipe_layanan = $request['tipe_layanan'];
			$reg->catatan = $request['catatan'];
			$reg->dokter_id = $request['dokter_id'];
			$reg->poli_id = $request['poli_id'];
			$reg->icd = $request['icd'];
			$reg->kecelakaan = $request['kecelakaan'];
			$reg->tipe_jkn = $request['jkn'];
			$reg->no_sep = $request['no_sep'];
			$reg->sebabsakit_id = $request['sebabsakit_id'];
			$reg->bayar = $request['bayar'];
			$reg->no_jkn = $request['no_jkn'];
			$reg->user_create = Auth::user()->id;
			$reg->jenis_pasien = $request['bayar'];
			$reg->posisiberkas_id = '2';
			$reg->status_reg = $request['status_reg'];
			if ($request['status_reg'] == 'G1') {
				$reg->status_ugd = $request['status_ugd'];
			}
			if (($request['poli_id'] == 19) || ($request['poli_id'] == 20)) {
				$reg->tracer = 1;
			}
			$reg->asuransi_id = isset($request['perusahaan_id']) ? $request['perusahaan_id'] : NULL;
			$reg->antrian_poli = $this->antrianPoli($request['poli_id'], valid_date($request['created_at']));
			$reg->created_at = valid_date($request['created_at']);
			$reg->updated_at = valid_date($request['created_at']);
			$reg->save();

			//Insert Histori Pengunjung
			$hp = new Historipengunjung();
			$hp->registrasi_id = $reg->id;
			$hp->pasien_id = $pasien->id;
			$hp->politipe = 'J';
			if ($request['status'] == 1) {
				$hp->status_pasien = 'BARU';
			} else {
				$hp->status_pasien = 'LAMA';
			}
			$hp->created_at = date(valid_date($request['created_at']).' H:i:s');
			$hp->user = Auth::user()->name;
			$hp->save();

			//Histori Kunjungan
			$irj = new  HistorikunjunganIRJ();
			$irj->registrasi_id = $reg->id;
			$irj->pasien_id = $pasien->id;
			$irj->poli_id = $request['poli_id'];
			$irj->user = Auth::user()->name;
			$irj->created_at = date(valid_date($request['created_at']).' H:i:s');
			$irj->save();
		
			// Insert Biaya Registrasi dan ke Folio
			$biaya = Biayaregistrasi::all();
			$harus_dibayar = 0;
			$harus_dibayar;

			// Insert ke Tagihan
			$tag = new Tagihan();
			$tag->user_id = Auth::user()->id;
			$tag->registrasi_id = $reg->id;
			$tag->dokter_id = $reg->dokter_id;
			$tag->diskon = 0;
			$tag->pasien_id = $pasien->id;
			$tag->harus_dibayar = $harus_dibayar;
			$tag->subsidi = 0;
			$tag->dijamin = 0;
			$tag->selisih_positif = 0;
			$tag->selisih_negatif = 0;
			$tag->approval_tanggal = date('Y-m-d');
			$tag->user_approval = '';
			$tag->pembulatan = 0;
			$tag->save();

			// Insert Histori
			$history = new HistoriStatus();
			$history->registrasi_id = $reg->id;
			$history->status = 'J1';
			$history->poli_id = $reg->poli_id;
			$history->bed_id = NULL;
			$history->user_id = Auth::user()->id;
			$history->save();
			session(['pasienID' => $pasien->id]);
		});
		Flashy::success('Registrasi Sukses');
		return redirect('regperjanjian');
	}

	public function savePerjanjianPasienLama(Request $request, $id)
	{
		request()->validate([
			'created_at' => 'required',
			'poli_id' => 'required',
			'dokter_id' => 'required'
		]);
		DB::transaction(function () use ($request, $id) {
			// Update Pasien
			$pasien = Pasien::find($id);
			if(empty($pasien->no_rm)){
				$no_rm = Nomorrm::count() + 1;
				Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $no_rm]);
				$pasien->no_rm = sprintf("%08s", $no_rm);
			}
			$pasien->nama = $request['nama'];
			$pasien->nik = $request['nik'];
			$pasien->tmplahir = $request['tmplahir'];
			$pasien->tgllahir = valid_date($request['tgllahir']);
			$pasien->kelamin = $request['kelamin'];
			$pasien->province_id = $request['province_id'];
			$pasien->regency_id = $request['regency_id'];
			$pasien->district_id = $request['district_id'];
			$pasien->village_id = $request['village_id'];
			$pasien->alamat = $request['alamat'];
			$pasien->rt = $request['rt'];
			$pasien->rw = $request['rw'];
			$pasien->ibu_kandung = $request['ibu_kandung'];
			$pasien->status_marital = $request['status_marital'];
			$pasien->nohp = $request['nohp'];
			$pasien->negara = 'Indonesia';
			$pasien->pekerjaan_id = $request['pekerjaan_id'];
			$pasien->agama_id = $request['agama_id'];
			$pasien->pendidikan_id = $request['pendidikan_id'];
			$pasien->user_update = Auth::user()->name;
			$pasien->update();

			// Save registrasi
			$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();
			$reg = new Registrasi();
			$reg->pasien_id = $pasien->id;
			$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			$reg->status = $request['status'];
			$reg->keterangan = $request['keterangan'];
			$reg->rujukan = $request['rujukan'];
			$reg->antrian_id = NULL;
			$reg->rjtl = $request['rjtl'];
			$reg->kepesertaan = $request['kepesertaan']; //kepesertaan JKN
			$reg->hak_kelas_inap = $request['hakkelas'];
			$reg->no_rujukan = $request['nomorrujukan'];
			$reg->tgl_rujukan = $request['tglrujukan'];
			$reg->ppk_rujukan = $request['kodeasal'];
			$reg->tipe_layanan = $request['tipe_layanan'];
			$reg->catatan = $request['catatan'];
			$reg->dokter_id = $request['dokter_id'];
			$reg->poli_id = $request['poli_id'];
			$reg->icd = $request['icd'];
			$reg->kecelakaan = $request['kecelakaan'];
			$reg->tipe_jkn = $request['jkn'];
			$reg->no_sep = $request['no_sep'];
			$reg->sebabsakit_id = $request['sebabsakit_id'];
			$reg->bayar = $request['bayar'];
			$reg->no_jkn = $request['no_jkn'];
			$reg->user_create = Auth::user()->id;
			$reg->jenis_pasien = $request['bayar'];
			$reg->posisiberkas_id = '2';
			$reg->status_reg = $request['status_reg'];
			if ($request['status_reg'] == 'G1') {
				$reg->status_ugd = $request['status_ugd'];
			}
			$reg->asuransi_id = isset($request['perusahaan_id']) ? $request['perusahaan_id'] : NULL;
			$reg->antrian_poli = $this->antrianPoli($request['poli_id'], valid_date($request['created_at']));
			$reg->created_at = valid_date($request['created_at']);
			$reg->updated_at = valid_date($request['created_at']);
			$reg->save();

			//Insert Histori Pengunjung
			$hp = new Historipengunjung();
			$hp->registrasi_id = $reg->id;
			$hp->pasien_id = $pasien->id;
			$hp->politipe = 'J';
			if ($request['status'] == 1) {
				$hp->status_pasien = 'BARU';
			} else {
				$hp->status_pasien = 'LAMA';
			}
			$hp->created_at = date(valid_date($request['created_at']).' H:i:s');
			$hp->user = Auth::user()->name;
			$hp->save();

			//Histori Kunjungan
			$irj = new  HistorikunjunganIRJ();
			$irj->registrasi_id = $reg->id;
			$irj->pasien_id = $pasien->id;
			$irj->poli_id = $request['poli_id'];
			$irj->user = Auth::user()->name;
			$irj->created_at = date(valid_date($request['created_at']).' H:i:s');
			$irj->save();

			// Insert Biaya Registrasi dan ke Folio
			$biaya = Biayaregistrasi::all();
			$harus_dibayar = 0;
			$harus_dibayar;

			// Insert ke Tagihan
			$tag = new Tagihan();
			$tag->user_id = Auth::user()->id;
			$tag->registrasi_id = $reg->id;
			$tag->dokter_id = $reg->dokter_id;
			$tag->diskon = 0;
			$tag->pasien_id = $pasien->id;
			$tag->harus_dibayar = $harus_dibayar;
			$tag->subsidi = 0;
			$tag->dijamin = 0;
			$tag->selisih_positif = 0;
			$tag->selisih_negatif = 0;
			$tag->approval_tanggal = date('Y-m-d');
			$tag->user_approval = '';
			$tag->pembulatan = 0;
			$tag->save();

			// Insert Histori
			$history = new HistoriStatus();
			$history->registrasi_id = $reg->id;
			$history->status = 'J1';
			$history->poli_id = $reg->poli_id;
			$history->bed_id = 1;
			$history->user_id = Auth::user()->id;
			$history->save();
			session(['pasienID' => $pasien->id]);
		});
		session()->forget('igdlama');
		Flashy::success('Registrasi Sukses');
		return redirect('regperjanjian');

	}

	// ============= VIEW ============================================================
	public function antrianPerjanjian($tgl = '', $poli_id = '')
	{
		$data['pasien'] = Registrasi::where('created_at', 'LIKE', date($tgl) . '%')->where('poli_id', $poli_id)->get();
		$data['poli'] = Poli::select('nama', 'id')->get();
		$data['no'] = 1;
		return view('reg-perjanjian.daftarperjanjian', $data);
	}

	public function cariAntrian(Request $req)
	{
		request()->validate(['tgl' => 'required', 'poli_id' => 'required']);
		return redirect('daftar-perjanjian/' . valid_date($req['tgl']) . '/' . $req['poli_id']);
	}

	public function hapusAntrian($id, $tgl, $poli_id) {
		Registrasi::find($id)->delete();
		Flashy::success('Daftar Antrian Sukses Dihapus');
		return redirect('daftar-perjanjian/' . $tgl . '/' . $poli_id);
	}

}
