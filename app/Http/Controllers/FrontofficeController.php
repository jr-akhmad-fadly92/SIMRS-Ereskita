<?php

namespace App\Http\Controllers;
use App\KondisiAkhirPasien;
use App\PerawatanIcd9;
use App\PerawatanIcd10;
use App\Posisiberkas;
use App\Inacbg;
use App\Rawatinap;
use App\Permintaanobatdetail;
use App\Penjualandetail;
use DB;
use Excel;
use Flashy;
use App\Penjualan;
use App\Penjualanbebas;
use App\Masterobat;
use Illuminate\Http\Request;
use Modules\Icd9\Entities\Icd9;
use Modules\Icd10\Entities\Icd10;
use Modules\Pasien\Entities\Pasien;
use Modules\Pasien\Entities\Regency;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Rujukan\Entities\Rujukan;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Folio;
use Modules\Kelas\Entities\Kelas;
use App\Foliopelaksana;
use App\Historipengunjung;
use App\HistorikunjunganIRJ;
use App\HistorikunjunganIGD;
use App\HistoriRawatInap;
use PDF;
use Validator;
use App\User;
use App\Role;
use Auth;
use Yajra\DataTables\DataTables;

class FrontofficeController extends Controller {
	public function cetak(){
		$today = Registrasi::where('created_at', 'like', date('Y-m-d') . '%')->orderBy('id', 'Desc')->get();
		return view('frontoffice.cetak', compact('today'))->with('no', 1);
	}

	public function cetak_byTanggal(Request $request) {
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$today = Registrasi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->orderBy('id', 'Desc')->get();
		return view('frontoffice.cetak', compact('today'))->with('no', 1);
	}

	public function cetakPerjanjian(){
		$today = Registrasi::where('created_at', '>', date('Y-m-d') . ' 23:59:59')->orderBy('id', 'Desc')->get();
		return view('frontoffice.cetak', compact('today'))->with('no', 1);
	}

	public function ajax_cetak(){
		$today = Registrasi::where('created_at', 'like', date('Y-m-d') . '%')->orderBy('id', 'Desc')->get();
		return view('frontoffice.ajax_cetak', compact('today'))->with('no', 1);
	}

	public function dataCetakBarcode(){
		$data['reg'] = Registrasi::where('status_reg', 'like', 'J%')
															->where('created_at', 'like', date('Y-m-d').'%')
															->where('cetak_barcode', '0')
															->orderBy('id', 'asc')->first();
		return view('frontoffice.dataCetakBarcode', $data);
	}

	public function cetak_barcode($id, $reg_id) {
		$data['pasien'] = Pasien::find($id);
		$data['reg_id'] = $reg_id;
		return view ('frontoffice.cetak_barcode', $data);
	}

	public function cetak_antrian($id, $reg_id) {
		$regs = Registrasi::find($reg_id);
		return view('frontoffice.cetak_buktipendaftaran', compact('regs'));
	}
	
	public function cetak_gelang($id) {
		$pasien = Pasien::find($id);
		return view('frontoffice.cetak_gelang', compact('pasien'));
	}

	public function cetak_kib($status='baru',$id) {
		$reg = Registrasi::find($id);
		$pasien = Pasien::find($reg->pasien_id);
		return view('frontoffice.cetakKIB', compact('reg', 'pasien', 'status'));
	}

	public function cetakKIUP($registrasi_id=''){
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		return view('frontoffice.cetakKIUP', $data);
	}

	//=========================== LAPORAN ============================================
	public function lap_dokter(){
		$data['histreg'] 	= Registrasi::where('created_at', 'LIKE', date('Y-m-d') . '%')
												->select('id','poli_id','dokter_id',DB::raw('count(*) as total'))
												->where('status_reg', 'like', 'J%')
												->groupBy('dokter_id')
												->get();
		return view('frontoffice.lap_dokter', $data)->with('no', 1);
	}
	
	public function lap_pengunjung(){
		$data['histreg'] = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('politipe', 'I')->where('politipe', 'j')->get();
		$data['klinik'] = Poli::pluck('nama', 'id');
		return view('frontoffice.lap_pengunjung', $data)->with('no', 1);
	}

	public function lap_pengunjung_bytanggal(Request $request) {
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		if ($request['politipe'] == 'I') {
			$data['histreg'] = Historipengunjung::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
										->whereBetween('histori_pengunjung.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
										->where('histori_pengunjung.politipe', $request['politipe'])
										->select('histori_pengunjung.*', 'registrasis.bayar')
										->get();
		} else {
			$data['histreg'] = Historipengunjung::join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
										->whereBetween('histori_pengunjung.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
										->where('histori_pengunjung.politipe', $request['politipe'])
										->where('registrasis.poli_id', $request['poli_id'])
										->select('histori_pengunjung.*', 'registrasis.bayar')
										->get();
		}

		$data['klinik'] = Poli::pluck('nama', 'id');
		return view('frontoffice.lap_pengunjung', $data)->with('no', 1);
	}

	public function lap_kunjungan(){
		$data['reg'] 	=	HistorikunjunganIRJ::join('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
										->join('pasiens','pasiens.id','=','registrasis.pasien_id')
										->where('registrasis.jenis_pasien', 'jenis_pasien', '2')
										->where('registrasis.jenis_pasien', 'jenis_pasien', '1')
										->where('histori_kunjungan_irj.created_at', 'LIKE', date('Y-m-d') . '%')
										->select('histori_kunjungan_irj.registrasi_id', 'histori_kunjungan_irj.pasien_id', 'histori_kunjungan_irj.poli_id', 'histori_kunjungan_irj.created_at','registrasis.*')
										->get();
		$data['poli'] = Poli::select('nama', 'id')->get();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);
		return view('frontoffice.lap_kunjungan', $data)->with('no', 1);
	}

	public function lap_kunjungan_bytanggal(Request $request) {
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$poli = Poli::select('id')->get();
		$pi = [];
		foreach ($poli as $key => $d) {
			$pi[] = '' . $d->id . '';
		}

		$dokter = Pegawai::select('id')->get();
		$di = [];
		foreach ($dokter as $key => $d) {
			$di[] = '' . $d->id . '';
		}

		$data['poli'] = Poli::select('nama', 'id')->get();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);

		if (!empty($request['tipe_jkn'])) {
			$data['reg'] = HistorikunjunganIRJ::join('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
				->whereBetween('histori_kunjungan_irj.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
				->whereIn('registrasis.jenis_pasien', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1', '2'])
				->whereIn('registrasis.tipe_jkn', !empty($request['tipe_jkn']) ? [$request['tipe_jkn']] : ['PBI', 'NON PBI'])
				->whereIn('histori_kunjungan_irj.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)
				->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
				->select('histori_kunjungan_irj.registrasi_id', 'histori_kunjungan_irj.pasien_id', 'histori_kunjungan_irj.poli_id', 'histori_kunjungan_irj.created_at')
				->get();
			$datareg = $data['reg'];
		} else {
			$data['reg'] = HistorikunjunganIRJ::join('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
				->whereBetween('histori_kunjungan_irj.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
				->whereIn('registrasis.jenis_pasien', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1', '2'])
				->whereIn('histori_kunjungan_irj.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)
				->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
				->select('histori_kunjungan_irj.registrasi_id', 'histori_kunjungan_irj.pasien_id', 'histori_kunjungan_irj.poli_id', 'histori_kunjungan_irj.created_at')
				->get();
			$datareg = $data['reg'];
		}

		if ($request['lanjut']) {
			return view('frontoffice.lap_kunjungan', $data)->with('no', 1);
		} elseif ($request['excel']) {
			Excel::create('Laporan Kunjungan ', function ($excel) use ($datareg) {
				// Set the properties
				$excel->setTitle('Laporan Kunjungan')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Kunjungan');
				$excel->sheet('Laporan Kunjungan', function ($sheet) use ($datareg) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No',
						'Nama',
						'No. RM',
						'Umur',
						'L/P',
						'Klinik Tujuan',
						'Dokter',
						'Cara Bayar',
						'Tanggal',
					]);
					foreach ($datareg as $key => $d) {
						$reg = Registrasi::find($d->registrasi_id);
              			$pasien = Pasien::find($d->pasien_id);
						$sheet->row(++$row, [
							$no++,
							$pasien ? $pasien->nama : NULL,
							$pasien ? $pasien->no_rm : NULL,
							$pasien ? hitung_umur($pasien->tgllahir, 'Y') : NULL,
							$pasien ? $pasien->kelamin : NULL,
							!empty($reg->poli_id) ? baca_poli($reg->poli_id) : NULL,
							!empty($reg->dokter_id) ? baca_dokter($reg->dokter_id) : NULL,
							baca_carabayar($reg->bayar) . ' ' . $reg->tipe_jkn,
							tanggal($d->created_at),
						]);
					}
				});
			})->export('xlsx');

		} elseif ($request['pdf']) {
			$reg = $data['reg'];
			$no = 1;
			$pdf = PDF::loadView('frontoffice.pdf_lap_kunjungan', compact('reg', 'no'));
			$pdf->setPaper('A4', 'landscape');
			return $pdf->download('lap_kunjungan.pdf');
		}
	}

	public function lap_diagnosa_irj(){
		return view('frontoffice.lap_diagnosa_irj');
	}

	public function lap_diagnosa_irj_byTanggal(Request $request) {
		request()->validate(['batas' => 'required', 'tga' => 'required', 'tgb' => 'required']);
		$tga = valid_date($request['tga']); $tgb = valid_date($request['tgb']);
		if ($request['batas'] == 0) {
			$irj = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah FROM perawatan_icd10s WHERE created_at BETWEEN "'.$tga.'" AND "'.$tgb.'"
							GROUP BY icd10 ORDER BY jumlah DESC');
		} else {
			$irj = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah FROM perawatan_icd10s WHERE created_at BETWEEN "'.$tga.'" AND "'.$tgb.'"
							GROUP BY icd10 ORDER BY jumlah DESC limit '.$request['batas'].'');
		}
		return view('frontoffice.lap_diagnosa_irj', compact('irj'))->with('no', 1);
	}

	public function lap_diagnosa_irna(){
		return view('frontoffice.lap_diagnosa_irna');
	}

	public function lap_diagnosa_irna_byTanggal(Request $request) {
		request()->validate(['batas' => 'required', 'tga' => 'required', 'tgb' => 'required']);
		$tga = valid_date($request['tga']); $tgb = valid_date($request['tgb']);
		if ($request['batas'] == 0) {
			$data = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah FROM perawatan_icd10s WHERE created_at BETWEEN "'.$tga.'" AND "'.$tgb.'"
							GROUP BY icd10 ORDER BY jumlah DESC');
		} else {
			$data = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah FROM perawatan_icd10s WHERE created_at BETWEEN "'.$tga.'" AND "'.$tgb.'"
							GROUP BY icd10 ORDER BY jumlah DESC limit '.$request['batas'].'');
		}

		return view('frontoffice.lap_diagnosa_irna', compact('data'))->with('no',1);
	}

	public function ajax_lap_pengunjung(){
		$data['reg'] = Registrasi::where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
		return view('frontoffice.ajax_lap_pengunjung', $data)->with('no', 1);
	}

	//REKAM MEDIS
	public function rekammedis_pasien(){
		if(strtolower(Auth::user()->role()->first()->name)=='administrator'||strtolower(Auth::user()->role()->first()->name)=='rawatdarurat'||strtolower(Auth::user()->role()->first()->name)=='rawatinap'||strtolower(Auth::user()->role()->first()->name)=='rawatjalan' )
        {
            $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);
			return view('frontoffice.lap_rekammedis_pasien', $data);
        }else{
            return redirect('/dashboard');
        }
		
	}

	public function view_rekammedis_pasien(Request $request) {
		request()->validate(['tga' => 'required', 'tgb' => 'required']);

		$dokter = Pegawai::select('id')->get();
		$di = [];
		foreach ($dokter as $key => $d) {
			$di[] = '' . $d->id . '';
		}

		if (!empty($request['pasien_id'])) {
			$data['rekammedis'] = Registrasi::where('pasien_id', $request['pasien_id'])->get();
		} elseif (!empty($request['tipe_jkn'])) {
			$data['rekammedis'] = Registrasi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
				->whereIn('bayar', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2','3'])
				->whereIn('dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
				->whereIn('tipe_jkn', !empty($request['tipe_jkn']) ? [$request['tipe_jkn']] : ['PBI', 'NON PBI'])
				->get();
		} else {
			$data['rekammedis'] = Registrasi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
				->whereIn('bayar', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2','3'])
				->whereIn('dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
				->get();
		}

		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get(['nama', 'id']);
		
		return view('frontoffice.lap_rekammedis_pasien', $data)->with('no', 1);
	}

	//=========================== SUPERVISOR ==========================================
	public function registrasiByTanggal(Request $request) {
		return redirect('frontoffice/supervisor/hapusregistrasi/' . $request['tanggal']);
	}

	public function hapusRegistrasi($tanggal = '') {
		if (!empty($tanggal)) {
			$data['registrasi'] = Registrasi::where('created_at', 'LIKE', valid_date($tanggal) . '%')->get();
		} else {
			$data['registrasi'] = Registrasi::where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
		}
		return view('frontoffice.hapus_registrasi', $data)->with('no', 1);
	}

	public function saveHapusRegistrasi($id) {
		$cek_folio = Folio::where('registrasi_id', $id)->where('lunas', 'Y')->count();
		if($cek_folio > 0){
			Flashy::danger('Daftar Registrasi Tidak bisa Dihapus, sudah di lakukan transaksi Pembayaran.');
		} else {
			Registrasi::find($id)->delete();
			Flashy::success('Daftar Registrasi berhasil di hapus.');
		}
		return redirect('/frontoffice/supervisor/hapusregistrasi');
	}

	public function ubah_dpjp(){
		return view('frontoffice.ubah_dpjp');
	}

	public function dataUbahDpjp($tga = '', $tgb = '') {
		if (!empty($tga) && !empty($tgb)) {
			$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->select(['registrasis.id', 'registrasis.pasien_id', 'registrasis.jenis_pasien', 'registrasis.status', 'registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.tipe_jkn'])
				->whereBetween('registrasis.created_at', [valid_date($tga) . ' 00:00:00', valid_date($tgb) . ' 23:59:59'])
				->where('registrasis.pasien_id', '<>', '0')
				->where('registrasis.pulang', null)
				// ->where('poli_id', '<>', '0')
				->get();
		} elseif(empty($tga) && empty($tgb)) {
			$data = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
				->select(['registrasis.id', 'registrasis.pasien_id', 'registrasis.jenis_pasien', 'registrasis.status', 'registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.bayar', 'registrasis.tipe_jkn'])
				->where('registrasis.created_at', 'LIKE', date('Y-m-d') . '%')
				->where('registrasis.pasien_id', '<>', '0')
				->where('registrasis.pulang', null)
				// ->where('poli_id', '<>', '0')
				->get();
		}
		return DataTables::of($data)
			->addColumn('no_rm', function ($data) {
				return $data->pasien->no_rm;
			})
			->addColumn('nama', function ($data) {
				return $data->pasien->nama;
			})
			->addColumn('alamat', function ($data) {
				return $data->pasien->alamat;
			})
			->addColumn('poli', function ($data) {
				return baca_poli($data->poli_id);
			})
			->addColumn('bayar', function ($data) {
				$jkn = !empty($data->tipe_jkn) ? ' - ' . $data->tipe_jkn : '';
				return baca_carabayar($data->bayar) . $jkn;
			})
			->addColumn('dokter', function ($data) {
				return baca_dokter($data->dokter_id);
			})
			->addColumn('ubah', function ($data) {
				return '<button type="button" onclick="ubahDpjp(' . $data->id . ')" class="btn btn-primary btn-sm btn-flat">
                                    <i class="fa fa-edit"></i>
                                    </button>';
			})
			->rawColumns(['ubah'])
			->make(true);
	}

	public function dataReg($id) {
		$reg = Registrasi::find($id);
		$pasien = [
			'id' => $reg->id,
			'bayar' => $reg->bayar,
			'dokter_id' => $reg->dokter_id,
			'no_rm' => $reg->pasien->no_rm,
			'nama' => $reg->pasien->nama,
			'alamat' => $reg->pasien->alamat,
			'poli' => (isset($reg->poli)) ? $reg->poli->nama : '',
			'poli_id' => $reg->poli_id,
			'asuransi_id' => $reg->asuransi_id,
			'tipe_jkn' => $reg->tipe_jkn,
		];
		return response()->json($pasien);
	}

	public function save_ubahdpjp(Request $request) {
		if ($request['carabayar'] == 1) {
			$cek = Validator::make($request->all(), [
				'tipe_jkn' => 'required',
			]);
			if ($cek->fails()) {
				return response()->json(['sukses' => false, 'full'=>false, 'errors' => $cek->errors()]);
			}
		}
		$reg = Registrasi::find($request['id']);
		$reg->dokter_id = $request['dokter_id'];
		$reg->poli_id = $request['poli_id'];
		$poli = Poli::where('id',$request['poli_id'])->first();
		$reg->poli_bpjs = $poli->bpjs;
		$reg->bayar = $request['carabayar'];
		$reg->tipe_jkn = !empty($request['tipe_jkn']) ? $request['tipe_jkn'] : NULL;
		$admission = false;
		if(strtolower(Auth::user()->role()->first()->name)=='admission' AND substr($reg->status_reg,0,1)!='I'){
			$admission = true;
			$antrian_poli = Registrasi::where('poli_id',$request['poli_id'])->where('dokter_id', $request['dokter_id'])->where('created_at', 'like', date('Y-m-d') . '%')->count();
			if($poli!=null){
				if($poli->kuota=='unlimited' OR (int)$poli->kuota >= $antrian_poli){
					$reg->antrian_poli = $antrian_poli + 1;
				}else{
					return response()->json(['sukses' => false, 'full'=>true, 'message' => 'Mohon maaf, kuota poli sudah penuh']); exit;
				}
			}
		}
		$reg->update();
		
		$ranap = Rawatinap::where('registrasi_id', $request['id'])->first();
		if($ranap!=null){
			$ranap->dokter_id = $request['dokter_id'];
			$ranap->save();
		}

		$folio = Folio::where('registrasi_id', $request['id'])->get();
		if($folio!=null) {
			foreach($folio as $d ) {
				$fol = Folio::find($d->id);
				$fol->dokter_id = $request['dokter_id'];
				$fol->update();
			}
		}
		
		Flashy::success('DPJP berhasil di Ubah');
		return response()->json(['sukses' => true, 'full'=>false, 'data' => $reg, 'admission'=>$admission]);
	}

	//=========================== REKAM MEDIS ============================================
	public function input_diagnosa_rawatjalan(){
		$data['reg'] = Registrasi::where('created_at', 'LIKE', date('Y-m-d') . '%')->whereNotIn('status_reg', ['I1', 'I2', 'I3', 'I4'])->where('posisi_pasien','selesai')->get();
		return view('frontoffice.input_diagnosa_rawatjalan', $data)->with('no', 1);
	}

	public function input_diagnosa_rawatjalan_byTanggal(Request $request) {
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$data['reg'] = Registrasi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->whereNotIn('status_reg', ['I1', 'I2', 'I3', 'I4'])->where('posisi_pasien','selesai')->get();
		return view('frontoffice.input_diagnosa_rawatjalan', $data)->with('no', 1);
	}

	/* public function form_input_diagnosa_rawatjalan($id) {
		$data['reg'] = Registrasi::find($id);
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		$data['posisi'] = Posisiberkas::pluck('keterangan', 'id');
		$data['icd9'] = Icd9::select('id', 'nomor', 'nama')->get();
		$data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
		$data['perawatanicd9'] = PerawatanIcd9::where('registrasi_id', $id)->get();
		$data['perawatanicd10'] = PerawatanIcd10::where('registrasi_id', $id)->get();
		return view('frontoffice.form_input_diagnosa_rawatjalan', $data)->with('no', 1);
	} */

	/* public function simpan_diagnosa_rawatjalan(Request $request) {
		DB::transaction(function () use ($request) {
			//Simpan ke Perawatan icd9
			for ($i = 1; $i <= 5; $i++) {
				if (!empty($request['icd9' . $i])) {
					$icd9 = new PerawatanIcd9();
					$icd9->icd9 = $request['icd9' . $i];
					$icd9->registrasi_id = $request['registrasi_id'];
					$icd9->carabayar_id = $request['cara_bayar'];
					$icd9->jenis = 'TA';
					$icd9->save();
				}
			}

			//Simpan ke Perawatan icd10
			for ($i = 1; $i <= 5; $i++) {
				if (!empty($request['icd10' . $i])) {
					$icd10 = new PerawatanIcd10();
					$icd10->icd10 = $request['icd10' . $i];
					$icd10->registrasi_id = $request['registrasi_id'];
					$icd10->carabayar_id = $request['cara_bayar'];
					$icd10->jenis = 'TA';
					$icd10->save();
				}
			}

			$reg = Registrasi::find($request['registrasi_id']);
			$reg->posisiberkas_id = $request['posisi_berkas_rm'];
			$reg->kondisi_akhir_pasien = $request['status_kondisi'];
			$reg->update();
		});
		return redirect('frontoffice/form_input_diagnosa_rawatjalan/'.$request['registrasi_id']);
	} */

	public function input_diagnosa_rawatinap(){
		$data['reg'] = Registrasi::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('status_reg', 'LIKE', 'I%')->where('posisi_pasien','selesai')->get();
		return view('frontoffice.input_diagnosa_rawatinap', $data)->with('no', 1);
	}

	public function input_diagnosa_rawatinap_byTanggal(Request $request) {
		request()->validate(['tga' => 'required']);
		$data['reg'] = Registrasi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->where('status_reg', 'LIKE', 'I%')->where('posisi_pasien','selesai')->get();
		return view('frontoffice.input_diagnosa_rawatinap', $data)->with('no', 1);
	}

	/* public function form_input_diagnosa_rawatinap($id) {
		$data['reg'] = Registrasi::find($id);
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		$data['posisi'] = Posisiberkas::pluck('keterangan', 'id');
		$data['icd9'] = Icd9::select('id', 'nomor', 'nama')->get();
		$data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
		$data['perawatanicd9'] = PerawatanIcd9::where('registrasi_id', $id)->get();
		$data['perawatanicd10'] = PerawatanIcd10::where('registrasi_id', $id)->get();
		return view('frontoffice.form_input_diagnosa_rawatinap', $data)->with('no', 1);
	} */

	/* public function simpan_diagnosa_rawatinap(Request $request) {
		DB::transaction(function () use ($request) {
			//Simpan ke Perawatan icd9
			for ($i = 1; $i <= 20; $i++) {
				if (!empty($request['icd9' . $i])) {
					$icd9 = new PerawatanIcd9();
					$icd9->icd9 = $request['icd9' . $i];
					$icd9->registrasi_id = $request['registrasi_id'];
					$icd9->carabayar_id = $request['cara_bayar'];
					$icd9->jenis = 'TI';
					$icd9->save();
				}
			}

			//Simpan ke Perawatan icd10
			for ($i = 1; $i <= 20; $i++) {
				if (!empty($request['icd10' . $i])) {
					$icd10 = new PerawatanIcd10();
					$icd10->icd10 = $request['icd10' . $i];
					$icd10->registrasi_id = $request['registrasi_id'];
					$icd10->carabayar_id = $request['cara_bayar'];
					$icd10->jenis = 'TI';
					$icd10->save();
				}
			}

			$reg = Registrasi::find($request['registrasi_id']);
			$reg->posisiberkas_id = $request['posisi_berkas_rm'];
			$reg->kondisi_akhir_pasien = $request['status_kondisi'];
			$reg->update();
		});
		return redirect('frontoffice/form_input_diagnosa_rawatinap/'.$request['registrasi_id']);
	} */

	public function form_input_diagnosa($id) {
		$data['reg'] = Registrasi::find($id);
		if($data['reg']->posisi_pasien!='selesai'){
			Flashy::info('Pasien belum selesai / pulang');
			return back();
		}
		$cek = Registrasi::where('id',$id)->where('status_reg','like','I%')->count();
		if($cek>0)
		{
			$data['nilai']='1';
		}else{
			$data['nilai']='0';
		}
		$data['hist_kamar'] = HistoriRawatInap::where('registrasi_id', $id)->orderBy('id', 'ASC')->get();
		$data['operasi'] = Folio::where('registrasi_id', $id)->whereIn('namatarif',['Operasi Kecil - Operator','Operasi Sedang - Operator','Operasi Besar - Operator','Operasi Khusus - Operator','Operasi Kecil - Anestesi','Operasi Sedang - Anestesi','Operasi Besar - Anestesi','Operasi Khusus - Anestesi'])->get();
		$data['hist_igd'] = HistorikunjunganIGD::where('registrasi_id', $id)->get();
		$data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
		$data['posisi'] = Posisiberkas::pluck('keterangan', 'id');
		$data['icd9'] = Icd9::select('id', 'nomor', 'nama')->get();
		$data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
		$data['perawatanicd9'] = PerawatanIcd9::where('registrasi_id', $id)->get();
		$data['perawatanicd10'] = PerawatanIcd10::where('registrasi_id', $id)->get();
		return view('frontoffice.form_input_diagnosa', $data)->with('no', 1);
	}
	
	public function simpan_diagnosa(Request $request) {
		DB::transaction(function () use ($request) {
			//Simpan ke Perawatan icd9
			for ($i = 1; $i <= 20; $i++) {
				if (!empty($request['icd9' . $i])) {
					$icd9 = new PerawatanIcd9();
					$icd9->icd9 = $request['icd9' . $i];
					$icd9->registrasi_id = $request['registrasi_id'];
					$icd9->carabayar_id = $request['cara_bayar'];
					$icd9->jenis = 'TI';
					$icd9->save();
				}
			}

			//Simpan ke Perawatan icd10
			for ($i = 1; $i <= 20; $i++) {
				if (!empty($request['icd10' . $i])) {
					$icd10 = new PerawatanIcd10();
					$icd10->icd10 = $request['icd10' . $i];
					$icd10->registrasi_id = $request['registrasi_id'];
					$icd10->carabayar_id = $request['cara_bayar'];
					$icd10->jenis = 'TI';
					$icd10->save();
				}
			}

			$reg = Registrasi::find($request['registrasi_id']);
			$reg->posisiberkas_id = $request['posisi_berkas_rm'];
			$reg->update();
		});
		return redirect('frontoffice/form-input-diagnosa/'.$request['registrasi_id']);
	}
	
	public function updateKondisi(Request $request) {
		$reg = Registrasi::find($request['id']);
		$reg->keadaan_keluar_inap = $request['kondisi'];
		if($reg->update()){
			return response()->json(['status'=>true]);
		}else{
			return response()->json(['status'=>false]);
		}
	}
	
	public function updateKasus(Request $request) {
		$reg = Registrasi::find($request['id']);
		$reg->kasus = $request['kasus'];
		if($reg->update()){
			return response()->json(['status'=>true]);
		}else{
			return response()->json(['status'=>false]);
		}
	}	
	
	public function updateGpa(Request $request) {
		$reg = Registrasi::find($request['id']);
		$reg->kehamilan_gpa = $request['gpa'];
		if($reg->update()){
			return response()->json(['status'=>true]);
		}else{
			return response()->json(['status'=>false]);
		}
	}	
	
	public function updateKeterangan(Request $request) {
		$reg = Registrasi::find($request['id']);
		$reg->keterangan = $request['keterangan'];
		if($reg->update()){
			return response()->json(['status'=>true]);
		}else{
			return response()->json(['status'=>false]);
		}
	}
	
	public function updateKematian(Request $request) {
		$reg = Registrasi::find($request['id']);
		$reg->sebab_kematian = $request['kematian'];
		if($reg->update()){
			return response()->json(['status'=>true]);
		}else{
			return response()->json(['status'=>false]);
		}
	}
	
	public function hapusDiagnosa($id, $registrasi_id){
		$diagnosa = PerawatanIcd10::find($id);
		$diagnosa->delete();
		$reg = Registrasi::find($registrasi_id);
		if(substr($reg->status_reg,0,1) == 'I'){
			return redirect('frontoffice/form_input_diagnosa_rawatinap/'.$registrasi_id);
		} else {
			return redirect('frontoffice/form_input_diagnosa_rawatjalan/'.$registrasi_id);
		}
	}

	public function hapusProsedur($id, $registrasi_id){
		$prosedur = PerawatanIcd9::find($id);
		$prosedur->delete();
		$reg = Registrasi::find($registrasi_id);
		if(substr($reg->status_reg,0,1) == 'I'){
			return redirect('frontoffice/form_input_diagnosa_rawatinap/'.$registrasi_id);
		} else {
			return redirect('frontoffice/form_input_diagnosa_rawatjalan/'.$registrasi_id);
		}
	}

	//BRIDGING INACBG ==========================================================
	public function data_rawatJalan(){
		$data['reg'] 	= Registrasi::leftJoin('inacbgs','registrasis.id','=','inacbgs.registrasi_id')
										->whereIn('registrasis.status_reg', ['J1','J2','J3','G1','G2','G3'])
										->where('registrasis.bayar',1)
										->where('registrasis.pulang',1)
										->orderBy('registrasis.id', 'desc')
										->select('registrasis.*','inacbgs.final_klaim','inacbgs.kirim_dc','inacbgs.kirim_lpk')
										->get();
		return view('frontoffice.e-claim.data_rawatJalan', $data);
	}

	public function data_rawatJalan_byTanggal(Request $request) {
		request()->validate(['tga' => 'required']);
		$data['reg'] = Registrasi::leftJoin('inacbgs','registrasis.id','=','inacbgs.registrasi_id')
									->where('registrasis.created_at', 'like', valid_date($request['tga']).' %')
									->whereIn('registrasis.status_reg', ['J1','J2','J3','G1','G2','G3'])
									->where('registrasis.bayar', 1)
									->where('registrasis.pulang',1)
									->orderBy('registrasis.id', 'desc')
									->select('registrasis.*','inacbgs.final_klaim','inacbgs.kirim_dc','inacbgs.kirim_lpk')
									->get();
		return view('frontoffice.e-claim.data_rawatJalan', $data);
	}

	/* public function get_data_rawatJalan(){
		$data = Registrasi::where('status_reg', 'like', 'J%')->where('bayar', 1)->orderBy('id', 'desc')->get();
		return DataTables::of($data)
			->addColumn('no_rm', function ($data) {
				return $data->pasien->no_rm;
			})
			->addColumn('pasien', function ($data) {
				return $data->pasien->nama;
			})
			->addColumn('poli', function ($data) {
				return $data->poli->nama;
			})
			->addColumn('dokter', function ($data) {
				return baca_dokter($data->dokter_id);
			})
			->addColumn('cara_bayar', function ($data) {
				return baca_carabayar($data->bayar) . ' - ' . $data->tipe_jkn;
			})
			->addColumn('tgl_registrasi', function ($data) {
				return $data->created_at->format('d-m-Y H:i:s');
			})
			->addColumn('proses', function ($data) {
				return '<a href="' . url('frontoffice/e-claim/bridging/' . $data->id) . '" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-database"></i></a>';
			})
			->rawColumns(['proses'])
			->make(true);
	} */

	public function data_rawatInap(){
		$data['irna'] = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
										->leftJoin('inacbgs','registrasis.id','=','inacbgs.registrasi_id')
										->where('rawatinaps.tgl_keluar', 'LIKE', date('Y-m-d') . '%')
										->where('registrasis.status_reg', 'like', 'I%')
										->where('registrasis.bayar', 1)
										->select('registrasis.*','registrasis.id as reg_id','rawatinaps.kamar_id','inacbgs.final_klaim','inacbgs.kirim_dc','inacbgs.kirim_lpk')
										->get();								
		return view('frontoffice.e-claim.data_rawatInap', $data)->with('no', 1);
	}

	public function data_rawatInap_byTanggal(Request $request) {
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$data['irna'] = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
										->leftJoin('inacbgs','registrasis.id','=','inacbgs.registrasi_id')
										->whereBetween('rawatinaps.tgl_keluar', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
										->where('registrasis.status_reg', 'like', 'I%')
										->where('registrasis.bayar', 1)
										->select('registrasis.*','registrasis.id as reg_id','rawatinaps.kamar_id','inacbgs.final_klaim','inacbgs.kirim_dc','inacbgs.kirim_lpk')
										->get();
		return view('frontoffice.e-claim.data_rawatInap', $data)->with('no', 1);
	}

	public function bridging($registrasi_id = '') {
		$data['irna'] = Rawatinap::where('id', $registrasi_id)->first();
		$data['reg'] = Registrasi::where('id', $registrasi_id)->first();
		$data['inacbg'] = Inacbg::where('registrasi_id', $registrasi_id)->first();
		
		$prosedur_non_bedah = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 1)->sum('folios.total');
		$data['prosedur_non_bedah'] = $prosedur_non_bedah;
		
    $tenaga_ahli = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 4)->sum('folios.total');
		$data['tenaga_ahli'] = $tenaga_ahli;
		
    $radiologi = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 7)->sum('folios.total');
		$data['radiologi'] = $radiologi;
		
    $rehabilitasi = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 10)->sum('folios.total');
		$data['rehabilitasi'] = $rehabilitasi;
		
		// ubah
		$alkes = 0;
		$penjualan_obat = 0;
		$permintaan_obat = 0;
    $pemakaian_obat = Folio::where('registrasi_id', $registrasi_id)->whereIn('jenis',['PEM'])->sum('total');
    $obat = Folio::where('registrasi_id', $registrasi_id)->whereIn('jenis',['EPO','ORI','ORD','ORJ'])->get();
		if($obat!=null){
			foreach($obat as $kb => $ob){
				if($ob->jenis=='EPO'){
					$permintaan_obat = Permintaanobatdetail::where('no_resep',$ob->namatarif)->whereIn('jenis_obat',['OBAT MINUM','OBAT LUAR','INFUS','INJEKSI'])->where('delete_by',null)->sum('hargajual');
					$alkes = Permintaanobatdetail::where('no_resep',$ob->namatarif)->whereIn('jenis_obat',['ALKES'])->where('delete_by',null)->sum('hargajual');
				}else{
					$penjualan_obat = $penjualan_obat + Penjualandetail::where('no_resep',$ob->namatarif)->whereIn('jenis_obat',['OBAT MINUM','OBAT LUAR','INFUS','INJEKSI'])->where('hapus',null)->sum('hargajual');
				}
			}
		}
		$data['obat'] = $penjualan_obat+$permintaan_obat+$pemakaian_obat;

		$sewa_alat = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 16)->sum('folios.total');
		$data['sewa_alat'] = $sewa_alat;
		
    $prosedur_bedah = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 2)->sum('folios.total');
		$data['prosedur_bedah'] = $prosedur_bedah;
		
    $keperawatan = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 5)->sum('folios.total');
		$data['keperawatan'] = $keperawatan;
		
    $laboratorium = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 8)->sum('folios.total');
		$data['laboratorium'] = $laboratorium;
		
		$data['kamar'] = biaya_kamar($registrasi_id);
		
		$data['alkes'] = $alkes;
		
    $konsultasi = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 3)->sum('folios.total');
		$data['konsultasi'] = $konsultasi;
		
    $penunjang = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 6)->sum('folios.total');
		$data['penunjang'] = $penunjang;
		
    $pelayanan_darah = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 9)->sum('folios.total');
		$data['pelayanan_darah'] = $pelayanan_darah;
		
    $rawat_intensif = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 12)->sum('folios.total');
		$data['rawat_intensif'] = $rawat_intensif;
		
		// ubah
    $bmhp = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 15)->sum('folios.total');
		$data['bmhp'] = $bmhp;
		
		return view('frontoffice.e-claim.bridging', $data);
	}

	/* public function bridgingIRNA($registrasi_id = '') {
		$data['reg'] = Registrasi::where('id', $registrasi_id)->first();
		return view('frontoffice.e-claim.bridgingIRNA', $data);
	} */

	public static function cetakEklaim($no_sep){
		$data = Inacbg::where('no_sep', $no_sep)->first();
		$registrasi = Registrasi::find($data->registrasi_id);
		if ($data) {
			$pdf = PDF::loadView('frontoffice.e-claim.cetakEklaim', compact('data', 'registrasi'));
			return $pdf->stream();
		} else {
			Flashy::error('Cetak E-Klaim Gagal');
			return redirect()->back();
		}

	}
	
	//V-CLAIM
	function HashBPJS(){
		$ID = config('app.sep_id');
		$t=time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');

		// Computes the timestamp
		date_default_timezone_set('UTC');
		$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
		// Computes the signature by hashing the salt with the secret key as the key
		$signature = hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true);

		// base64 encode…
		$encodedSignature = base64_encode($signature);
		return array($ID, $t, $encodedSignature);
	}
	
	function xrequest($url, $signature, $ID, $t){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


		$headers = array();
		$headers[] = "Accept: application/json";
		$headers[] = "Content-Type: application/json";
		$headers[] = "X-Cons-Id:".$ID;
		$headers[] = "X-Timestamp:".$t;
		$headers[] = "X-Signature:".$signature;
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HTTPGET, 1);

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			$message = 'Error:' . curl_error($ch);
		}
		curl_close ($ch);
		return $response;
	}
	
	public function vclaimPeserta(){
		return view('frontoffice.v-claim.form-vclaim-peserta');
	}
	
	public function vclaimDpjp(){
		list($ID, $t, $signature) = $this->HashBPJS();
		$data['poli'] = Poli::whereNotIn('bpjs',['-'])->get();
		$data['dpjp_ri'] = null;
		$dpjp_rj = null;
		// RAWAT JALAN
		foreach($data['poli'] as $key => $data){
			$completeurl = config('app.bpjs_url')."/referensi/dokter/pelayanan/2/tglPelayanan/".date('Y-m-d')."/Spesialis/".$data->bpjs;
			$response = $this->xrequest($completeurl, $signature, $ID, $t);
			if(!$response){
				Flashy::error('Server BPJS tidak memberikan respon');
			}else{
				$encode = json_decode($response);
				if($encode->response!=null){
					foreach($encode->response->list as $datax){
						$dpjp_rj[$datax->kode] = $datax->nama;
						$pegawai = Pegawai::where('kode',$datax->kode)->first();
						if($pegawai==null){
							$pegawai = new Pegawai;
						}
						$pegawai->kode = $datax->kode;
						$pegawai->nama = strtoupper($datax->nama);
						$pegawai->kategori_pegawai = 1;
						$pegawai->created_at = date('Y-m-d H:i:s');
						$pegawai->save();
					}
				}
			}
		}
		// RAWAT INAP		
		$completeurl = config('app.bpjs_url')."/referensi/dokter/pelayanan/1/tglPelayanan/".date('Y-m-d')."/Spesialis/";
		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		if(!$response){
			Flashy::error('Server BPJS tidak memberikan respon');
		}else{
			$encode = json_decode($response);
			if($encode->response!=null){
				foreach($encode->response->list as $datax){
					$pegawai = Pegawai::where('kode',$datax->kode)->first();
					if($pegawai==null){
						$pegawai = new Pegawai;
					}
					$pegawai->kode = $datax->kode;
					$pegawai->nama = strtoupper($datax->nama);
					$pegawai->kategori_pegawai = 1;
					$pegawai->created_at = date('Y-m-d H:i:s');
					$pegawai->save();
				}
				$data['dpjp_ri'] = $encode->response->list;
			}
		}
		return view('frontoffice.v-claim.form-vclaim-dpjp', $data)->with('dpjp_rj',$dpjp_rj);
	}
	
	public function vclaimPesertaPost(Request $request){
		list($ID, $t, $signature) = $this->HashBPJS();
		$dari = 'nomor kartu bpjs';
		$completeurl = config('app.bpjs_url')."/peserta/nokartu/".$request['nomor']."/tglSEP/".date('Y-m-d');
		$response = $this->xrequest($completeurl, $signature, $ID, $t);
		if(!$response){
			Flashy::error('Server BPJS tidak memberikan respon');
		}else{
			$encode = json_decode($response);
			if($encode->response==null){
				$completeurl = config('app.bpjs_url')."/peserta/nik/".$request['nomor']."/tglSEP/".date('Y-m-d');
				$response = $this->xrequest($completeurl, $signature, $ID, $t);
				if(!$response){
					Flashy::error('Server BPJS tidak memberikan respon');
				}else{
					$dari = 'nomor ktp';
					$encode = json_decode($response);
				}
			}
		}
		$data['data'] = json_encode($encode->response);
		if($data['data']=='null'){
			Flashy::info('Pencarian peserta melalui '.$dari.' tidak ditemukan');
		}else{
			Flashy::success('Berhasil mengambil data Peserta');
		}
		return view('frontoffice.v-claim.form-vclaim-peserta', $data);
	}
	
	public function vclaimSep(){
		return view('frontoffice.v-claim.form-sep');
	}
	
	public function vclaimSepPost(Request $request) {
		$data['poli'] 		= Poli::select('nama', 'bpjs')->get();
		$data['dokter'] 	= Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['pasien'] 	= Pasien::where('no_rm',$request['nomor'])->first();
		if($data['pasien']==null){
			$data['reg'] 		= Registrasi::where('bayar',1)->where('reg_id',$request['nomor'])->first();
		}else{
			$data['reg'] 		= Registrasi::where('bayar',1)->where('pasien_id',$data['pasien']->id)->first();
		}
		if($data['reg']==null){
			Flashy::info('Pasien tidak ditemukan');
		}else{
			session(['reg_id'=>$data['reg']->id]);
			session(['vclaim_sep'=>true]);
			Flashy::success('Berhasil mengambil data Pasien');
		}
		$data['asal_rujukan']		= 0;
		$data['diagnosa_kode']	= null;
		$data['diagnosa_nama']	= null;
		$data['kode_poli']			= null;
		$data['no_rujukan']			= null;
		$data['provinsi']				= null;
		$data['dokter_dpjp']		= null;
		$data['cob']						= null;
		return view('sep.form_create', $data);
	}
	
	public function vclaimSepRanap(){
		$data['antrian'] = Registrasi::where('status_reg', 'I3')->where('bayar',1)->get();
		$data['kelas'] = Kelas::select('nama', 'id')->where('nama', '<>', '-')->orderBy('nama', 'asc')->get();
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		$data['icd10'] = Icd10::select('id', 'nomor', 'nama')->get();
		return view('rawat-inap.antrian', $data)->with('no', 1);
	}
	
	public function rincianBiaya($registrasi_id) {
		$registrasi = Registrasi::find($registrasi_id);
		$tagihan 	= Folio::where('registrasi_id', $registrasi_id)->where('lunas', 'Y')
								->select('registrasi_id', 'namatarif', 'total', 'jenis')
								->get();
		$tagihan_total = Folio::where('registrasi_id', $registrasi_id)->where('lunas', 'Y')->sum('total');
		$kamar 		= total_tagihan($registrasi_id,'Y') - $tagihan_total;		
		return response()->json(['tagihan'=>$tagihan, 'kamar'=>$kamar, 'status_reg'=>substr($registrasi->status_reg,0,1)]);
	}
	
	// ==========================================================================================
	public function geticd9data(){
		$icd9 = Icd9::all();
		return DataTables::of($icd9)
			->addColumn('input', function ($icd9) {
				return '<button type="button" class="btn btn-success btn-sm btn-flat insert-prosedure" data-nomor="' . $icd9->nomor . '"><i class="fa fa-check"></i></button>';
			})
			->rawColumns(['input'])
			->make(true);
	}

	public function geticd10data(){
		$icd9 = Icd10::all();
		return DataTables::of($icd9)
			->addColumn('input', function ($icd9) {
				return '<button type="button" class="btn btn-success btn-sm btn-flat insert-diagnosa" data-nomor="' . $icd9->nomor . '"><i class="fa fa-check"></i></button>';
			})
			->rawColumns(['input'])
			->make(true);
	}

	public function datapasien(){
		if(strtolower(Auth::user()->role()->first()->name)=='kasir'){
			$pasien = Pasien::join('registrasis','registrasis.pasien_id','=','pasiens.id')
								->select([
									'pasiens.id',
									'pasiens.no_rm',
									'pasiens.nama',
									'pasiens.kelamin',
									'pasiens.tgllahir',
									'pasiens.alamat',
								])
								->where('registrasis.pulang',null)
								->orderBy('id', 'desc');
		}else{
			$pasien = Pasien::select([
				'id',
				'no_rm',
				'nama',
				'kelamin',
				'tgllahir',
				'alamat',
			])->orderBy('id', 'desc');
		}

		return DataTables::of($pasien)
			->addColumn('input', function ($pasien) {
				return '<button type="button" class="btn btn-primary btn-sm btn-flat inputPasien" data-pasien_id="' . $pasien->id . '" data-nama="' . $pasien->nama . '" data-no_rm="' . $pasien->no_rm . '"><i class="fa fa-check"></i></button>';
			})
			->rawColumns(['input'])
			->make(true);
	}

	//TRACER
	public function tracer(){
		return view('frontoffice/tracer');
	}

	public function dataTracer($poli_id = '', $tgl = '') {
		$poli = [];
		foreach (Poli::all() as $key => $d) {
			$poli[] = '' . $d->id . '';
		}
		$tanggal = !empty($tgl) ? valid_date($tgl) : date('Y-m-d');
		DB::statement(DB::raw('set @nomorbaris=0'));
		$data = Registrasi::select([DB::raw('@nomorbaris  := @nomorbaris  + 1 AS nomorbaris'), 'id', 'pasien_id', 'jenis_pasien', 'dokter_id', 'poli_id', 'bayar', 'tipe_jkn', 'no_loket', 'antrian_poli'])
			->where('created_at', 'like', $tanggal . '%')
			->whereIn('status_reg', ['J1', 'G1'])
			->whereIn('poli_id', !empty($poli_id) ? [$poli_id] : $poli)
			->where('tracer', '0')
			->get();
		return DataTables::of($data)
			->addColumn('pasien', function ($data) {
				return $data->pasien->nama;
			})
			->addColumn('norm', function ($data) {
				return $data->pasien->no_rm;
			})
			->addColumn('poli', function ($data) {
				return $data->poli->nama;
			})
			->addColumn('dokter', function ($data) {
				return baca_dokter($data->dokter_id);
			})
			->addColumn('bayar', function ($data) {
				if (!empty($data->tipe_jkn)) {
					return baca_carabayar($data->bayar) . ' ' . $data->tipe_jkn;
				} else {
					return baca_carabayar($data->bayar);
				}
			})
			->addColumn('cetak', function ($data) {
				return '<a href="/frontoffice/cetak-tracer/' . $data->id . '" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-print">  </i></a>';
			})
			->rawColumns(['cetak'])
			->make(true);
	}

	public function cetakTracer($registrasi_id) {
		$data = Registrasi::find($registrasi_id);
		return view('frontoffice.cetakTracer', compact('data'));
	}

	//TRACER ALL
	public function tracerAll(){
		$data = Registrasi::where('tracer', '0')->where('status_reg', 'like', 'J%')->where('created_at', 'like', date('Y-m-d').'%')->take(1)->get();
		return view('frontoffice.tracerAll', compact('data'))->with('no', 1);
	}

	public function cetakTracerAll(){
		$dataAll = Registrasi::where('tracer', '0')->where('status_reg', 'like', 'J%')->where('created_at', 'like', date('Y-m-d').'%')->take(1)->get();
		return view('frontoffice.cetakTracerAll', compact('dataAll'));
	}

	public function settingKuotaPoli(){
		$poli = Poli::where('politype', 'J')->get();
		return view('frontoffice.settingKuotaPoli', compact('poli'))->with('no', 1);
	}

	public function getPoli($id){
		$poli = Poli::find($id);
		return response()->json($poli);
	}

	public function saveKuotaPoli(Request $request){
		$poli = Poli::find($request->id);
		$poli->kuota = $request['kuota'];
		$poli->loket = $request['loket'];
		$poli->update();
		return response()->json(['sukses'=>true]);
	}

	public function outgate(){
		return view('frontoffice.outgate');
	}

	public function outgateViewData(Request $request){
		//return $request['no_rm']; die;
		request()->validate(['no_rm'=>'required']);
		$data = Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
						->where('registrasis.created_at', 'like', date('Y-m-d').'%')
						->where('pasiens.no_rm', $request['no_rm'])
						->select('pasiens.*', 'registrasis.id as regID','registrasis.poli_id')->first();
		if ($data) {
			$reg = Registrasi::find($data->regID);
			$reg->posisiberkas_id = 1;
			$reg->update();
		}

		return view('frontoffice.outgate', compact('data'));
	}

	public function inguide(){
		return view('frontoffice.inguide');
	}

	public function inguideViewData(Request $request){
		//return $request['no_rm']; die;
		request()->validate(['no_rm'=>'required']);
		$data = Registrasi::join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
						->where('registrasis.created_at', 'like', date('Y-m-d').'%')
						->where('pasiens.no_rm', $request['no_rm'])
						->select('pasiens.*', 'registrasis.id as regID','registrasis.poli_id')->first();
		$reg = Registrasi::find($data->regID);
		$reg->posisiberkas_id = 2;
		$reg->update();
		return view('frontoffice.inguide', compact('data'));
	}

	public function dataSEP(){
		$data['sep'] = Registrasi::whereNotNull('no_sep')
								->where('cetak_sep', '0')
								->where('status_reg', 'like', 'J%')
								->whereIN('no_loket', [1,2])
								->where('created_at', 'like', date('Y-m-d').'%')
								->take(1)
								->orderBY('id', 'asc')
								->get(['id', 'pasien_id', 'no_sep', 'poli_id', 'dokter_id']);
		return view('frontoffice.dataSEP', $data);
	}

	public function cetakSEP(){
		$data['reg'] = Registrasi::whereNotNull('no_sep')
								->where('cetak_sep', '0')
								->where('status_reg', 'like', 'J%')
								// ->whereIN('no_loket', [1,2])
								->where('created_at', 'like', date('Y-m-d').'%')
								->take(1)
								->orderBY('id', 'asc')
								->first();
		return view('frontoffice/cetakSEP', $data);
	}

	public function dataSEP2(){
		$data['sep'] = Registrasi::whereNotNull('no_sep')
								->where('cetak_sep', '0')
								->where('status_reg', 'like', 'J%')
								// ->whereIN('no_loket', [3,4])
								->where('created_at', 'like', date('Y-m-d').'%')
								->take(1)
								->orderBY('id', 'asc')
								->get(['id', 'pasien_id', 'no_sep', 'poli_id', 'dokter_id']);
		return view('frontoffice.dataSEP2', $data);
	}

	public function cetakSEP2(){
		$data['reg'] = Registrasi::whereNotNull('no_sep')
								->where('cetak_sep', '0')
								->where('status_reg', 'like', 'J%')
								->whereIN('no_loket', [3,4])
								->where('created_at', 'like', date('Y-m-d').'%')
								->take(1)
								->orderBY('id', 'asc')
								->first();
		return view('frontoffice/cetakSEP2', $data);
	}

	public static function historiPasien($pasien_id){
		$data['pasien'] = Pasien::find($pasien_id);
		$data['reg'] = Registrasi::where('pasien_id', $data['pasien']->id)->orderBY('id', 'desc')->get();
		$idreg = Registrasi::where('pasien_id', $pasien_id)->first();
		$data['hasil_lab'] = db::select(db::raw("select * from hasillabs"));		
		$data['hasil_rad'] = db::select(db::raw("select * from hasilradiologis"));
		return view('frontoffice.historiPasien', $data)->with('no', 1);
	}

	public static function historiPasienByRequest(Request $request){
		$data['pasien'] = Pasien::where('no_rm', 'LIKE', '%'.$request['no_rm'].'%')->orWhere('no_rm_lama', 'LIKE', '%'.$request['no_rm'].'%')->first();
		if($data['pasien']){
			$data['reg'] = Registrasi::where('pasien_id', $data['pasien']->id)->orderBY('id', 'desc')->get();
		}
		return view('frontoffice.historiPasien', $data)->with('no', 1);
	}

	public static function historiPasien1($pasien_id){
		$data['pasien'] = Pasien::find($pasien_id);
		$data['reg'] = Registrasi::where('pasien_id', $data['pasien']->id)->orderBY('id', 'desc')->get();
		$idreg = Registrasi::where('pasien_id', $pasien_id)->first();
				
		
		return view('frontoffice.historiPasien', $data)->with('no', 1);
	}

	public static function historiPasienByRequest1(Request $request){
		$data['pasien'] = Pasien::where('no_rm', 'LIKE', '%'.$request['no_rm'].'%')->orWhere('no_rm_lama', 'LIKE', '%'.$request['no_rm'].'%')->first();
		if($data['pasien']){
			$data['reg'] = Registrasi::where('pasien_id', $data['pasien']->id)->orderBY('id', 'desc')->get();
		}
		return view('frontoffice.historiPasien', $data)->with('no', 1);
	}


	public static function getDataRegistrasi($registrasi_id){
		$reg = Registrasi::find($registrasi_id);
		if ( substr($reg->status_reg, 0,1) == 'G' ) {
			$status = 'Rawat Darurat';
		} elseif ( substr($reg->status_reg, 0,1) == 'J' ) {
			$status = 'Rawat Jalan';
		} elseif ($reg->status_reg == 'I1') {
			$status = 'Admisi';
		} elseif ($reg->status_reg == 'I2') {
			$status = 'Rawat Inap';
		} elseif ($reg->status_reg == 'I3') {
			$status = 'Sudah Pulang';
		}
		return response()->json(['status_reg' => $status, 'registrasi_id'=>$reg->id]);
	}

	public static function ubahStatusPelayanan(Request $request){
		$reg = Registrasi::find($request['registrasi_id']);
		$reg->pulang = null;
		//$reg->tgl_pulang = null;
		if($request['status_reg']=='menunggu persalinan'){
			$reg->status_reg = 'I2';
			$reg->posisi_pasien = 'menunggu persalinan';
		}else{
			$reg->status_reg = $request['status_reg'];
			$reg->posisi_pasien = 'sedang diperiksa';
		}
		$reg->supervisor_edit = 1;
		$reg->supervisor_at = date('Y-m-d H:i:s');
		$reg->supervisor = Auth::user()->id;
		$reg->update();
		Flashy::success('Status Pelayanan Berhasil di Ubah');
		return response()->json(['sukses'=>true]);
	}

	public function setCarabayar(){
		$folio = Folio::whereNull('cara_bayar_id')->take(3000)->get();
		$jml = [];
		foreach ($folio as $d) {
			$fol = Folio::find($d->id);
			$fol->cara_bayar_id = Registrasi::find($d->registrasi_id)->bayar;
			$fol->timestamps = false;
			$fol->update();
			array_push($jml, $fol->id);
		}
		$hasil = Folio::whereIn('id', $jml)->count();
		$sisa = Folio::whereNull('cara_bayar_id')->count();
		return $hasil.' data berhasil di set cara bayar id <br />'.$sisa.' cara bayar masih kosong <META HTTP-EQUIV="REFRESH" CONTENT="5; URL=/frontoffice/set-cara-bayar">';
	}

	public function setBangsalFolio(){
		$folio = Folio::whereNull('kelompokkelas_id')->where('jenis', 'TI')->take(3000)->get();
		$jml = [];
		foreach ($folio as $d) {
			$fol = Folio::find($d->id);
			$fol->kelompokkelas_id = !empty(Rawatinap::where('registrasi_id', $fol->registrasi_id)->first()) ? Rawatinap::where('registrasi_id', $fol->registrasi_id)->first()->kelompokkelas_id : NULL;
			$fol->kamar_id = !empty(Rawatinap::where('registrasi_id', $fol->registrasi_id)->first()) ? Rawatinap::where('registrasi_id', $fol->registrasi_id)->first()->kamar_id : NULL;
			$fol->timestamps = false;
			$fol->update();
			array_push($jml, $fol->id);
		}
		$hasil = Folio::whereIn('id', $jml)->count();
		$sisa = Folio::whereNull('kelompokkelas_id')->where('jenis', 'TI')->count();
		return $hasil.' data berhasil di set cara bangsal dan kamar <br />'.$sisa.' bangsal masih kosong <META HTTP-EQUIV="REFRESH" CONTENT="5; URL=/frontoffice/set-bangsal-folio">';

	}

}
