<?php

namespace App\Http\Controllers;
use App\Mastersplit;
use App\Split;
use Excel;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Modules\Icd9\Entities\Icd9;
use Modules\Icd10\Entities\Icd10;
use Modules\Tarif\Entities\Tarif;
use Modules\Kelas\Entities\Kelas;
use Modules\Pasien\Entities\Pasien;
use Validator;

class ImportController extends Controller {

	public function templatePasien() {
		Excel::create('Template Data Pasien', function ($excel) {
				// Set the properties
				$excel->setTitle('Template Data Pasien')
				->setCreator('Digihealth')
					->setCompany('Digihealth')
				->setDescription('Template Data Pasien');
				$excel->sheet('Tarif Pasien', function ($sheet) {
						$row = 1;
						$sheet->row($row, [
								'nama',
								'no_rm',
								'no_rm_lama',
								'kelamin',
								'alamat',
								'nohp',
							]);
					});
			})->export('xlsx');
	}

	public function importPasien(Request $request) {
		request()->validate(['excel' => 'required']);
		//return $request->all(); die;
		$excel = $request->file('excel');
		$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
				// options, jika ada
			})->get();
		// rule
		$rowRules = [
			'nama'   => 'required',
			'alamat'  => 'required',
		];
		$pasienID = [];

		//Looping data
		foreach ($excels as $row) {
			$validator = Validator::make($row->toArray(), $rowRules);
			if ($validator->fails()) {continue;
			}
			$p = new Pasien();
			$p->no_rm_lama = sprintf("%08s", $row['no_rm']);
			$p->nama = $row['nama'];
			$p->alamat = $row['alamat'];
			$p->save();
			array_push($pasienID, $p->id);
		}

		$pasien = Pasien::whereIn('id', $pasienID)->get();
		if ($pasien->count() == 0) {
			Flashy::info('Tidak ada data Pasien yang diimport');
		} else {
			Flashy::success($pasien->count().' Data Pasien berhasil diimport ke Database ');
		}
		// Return it's location
		return redirect('kontrolpanel/import');
	}
	//=================== IRJ ======================================================
	public function templateIrj() {
		Excel::create('Template Tarif IRJ', function ($excel) {
				// Set the properties
				$excel->setTitle('Template Import IRJ')
				->setCreator('Digihealth')
					->setCompany('Digihealth')
				->setDescription('Template Tarif IRJ untuk SIMRS');
				$excel->sheet('Tarif IRJ', function ($sheet) {
						$row = 1;
						$sheet->row($row, [
								'nama',
								'total',
								'split1',
								'split2',
								'split3'
							]);
					});
			})->export('xlsx');
	}

	public function importIrj(Request $request) {
		request()->validate(['excel' => 'required']);
		//return $request->all(); die;

		$excel = $request->file('excel');
		$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
				// options, jika ada
			})->get();

		// rule
		$rowRules = [
			'nama'   => 'required',
			'total'  => 'required|integer',
			'split1' => 'nullable',
			'split2' => 'nullable',
		];
		$irjID = [];

		//Looping data
		foreach ($excels as $row) {
			$validator = Validator::make($row->toArray(), $rowRules);
			if ($validator->fails()) {continue;
			}

			$tarif = Tarif::where('nama', $row['nama'])->first();
			if (!$tarif) {
				$tarif = Tarif::create([
						'nama'             => $row['nama'],
						'jenis'            => $request['jenis'],
						'kategoriheader_id'=> $request['kategoriheader'],
						'kategoritarif_id' => $request['kategoritarif_id'],
						'keterangan'       => '-',
						'tahuntarif_id'    => configrs()->tahuntarif,
						'total'            => $row['total']
					]
				);
				array_push($irjID, $tarif->id);
				//Input split
				$mastersplit = Mastersplit::where('kategoriheader_id', $request['kategoriheader'])->get();
				for ($i = 1; $i <= $mastersplit->count(); $i++) {
					//if (!empty($row['split'.$i])) {
						$split = Split::create([
								'tahuntarif_id'     => configrs()->tahuntarif,
								'kategoriheader_id' => $request['kategoriheader'],
								'tarif_id'          => $tarif->id,
								'nama'              => $request['nama'.$i],
								'nominal'           => ($row['split'.$i] == 0) ? '0' : $row['split'.$i]
							]);
					//}

				}
			}
		}

		$tarifs = Tarif::whereIn('id', $irjID)->get();
		if ($tarifs->count() == 0) {
			Flashy::info('Tidak ada data tarif IRJ yang diimport');
		} else {
			Flashy::success($tarifs->count().' Data Tarif IRJ berhasil diimport ke Database ');
		}

		// Return it's location
		return redirect('kontrolpanel/import');
	}
	//=================== IRNA ======================================================
	public function templateIrna() {
		Excel::create('Template Tarif IRNA', function ($excel) {
				// Set the properties
				$excel->setTitle('Template Import IRNA')
				->setCreator('Digihealth')
					->setCompany('Digihealth')
				->setDescription('Template Tarif IRNA untuk SIMRS');
				$excel->sheet('Tarif IRNA', function ($sheet) {
						$row = 1;
						$sheet->row($row, [
								'nama',
								'total',
								'split1',
								'split2',
								'split3'
							]);
					});
			})->export('xlsx');
	}

	public function importIrna(Request $request) {
		//return $request->all(); die;
		request()->validate(['excel' => 'required']);
		$excel = $request->file('excel');

		$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
				// options, jika ada
			})->get();

		// rule
		$rowRules = [
			'nama'   => 'required',
			'total'  => 'required',
			'split1' => 'nullable',
			'split2' => 'nullable',
		];
		$irjID = [];

		//Looping data
		foreach ($excels as $row) {
			$validator = Validator::make($row->toArray(), $rowRules);
			if ($validator->fails()) {continue;
			}

			//$tarif = Tarif::where('nama', $row['nama'])->where('kategoritarif_id', $request['kategoritarif_id'])->where('jenis', $request['jenis'])->first();
			//if (!$tarif) {
				$tarif = Tarif::create([
						'nama'             => $row['nama'],
						'jenis'            => $request['jenis'],
						'kategoriheader_id'=> $request['kategoriheader'],
						'kategoritarif_id' => $request['kategoritarif_id'],
						'keterangan'       => '-',
						'tahuntarif_id'    => configrs()->tahuntarif,
						'total'            => $row['total']
					]
				);
				array_push($irjID, $tarif->id);
				//Input split
				$mastersplit = Mastersplit::where('kategoriheader_id', $request['kategoriheader'])->get();
				for ($i = 1; $i <= $mastersplit->count(); $i++) {
					//if (!empty($row['split'.$i])) {
						$split = Split::create([
								'tahuntarif_id'     => configrs()->tahuntarif,
								'kategoriheader_id' => $request['kategoriheader'],
								'tarif_id'          => $tarif->id,
								'nama'              => $request['nama'.$i],
								'nominal'           => $row['split'.$i]
							]);
					//}

				}
			//}
		}

		$tarifs = Tarif::whereIn('id', $irjID)->get();
		if ($tarifs->count() == 0) {
			Flashy::info('Tidak ada data tarif IRNA yang diimport');
		} else {
			Flashy::success($tarifs->count().' Data Tarif IRNA berhasil diimport ke Database ');
		}

		// Return it's location
		return redirect('kontrolpanel/import');
	}

	//=================== IGD ======================================================

	public function templateIGD() {
		Excel::create('Template Tarif IGD', function ($excel) {
				// Set the properties
				$excel->setTitle('Template Tarif IGD')
				->setCreator('Digihealth')
					->setCompany('Digihealth')
				->setDescription('Template Tarif IGD untuk SIMRS');
				$excel->sheet('Tarif IGD', function ($sheet) {
						$row = 1;
						$sheet->row($row, [
								'nama',
								'total',
								'split1',
								'split2',
								'split3'
							]);
					});
			})->export('xlsx');
	}

	public function importIgd(Request $request) {
		request()->validate(['excel' => 'required']);
		$excel = $request->file('excel');

		$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
				// options, jika ada
			})->get();

		// rule
		$rowRules = [
			'nama'   => 'required',
			'total'  => 'required|integer',
			'split1' => 'nullable|integer',
			'split2' => 'nullable|integer',
		];
		$irjID = [];
		//Looping data
		foreach ($excels as $row) {
			$validator = Validator::make($row->toArray(), $rowRules);
			if ($validator->fails()) {continue;
			}

			$tarif = Tarif::where('nama', $row['nama'])->where('jenis', $request['jenis'])->first();
			if (!$tarif) {
				$tarif = Tarif::create([
						'nama'             => $row['nama'],
						'jenis'            => $request['jenis'],
						'kategoriheader_id'=> $request['kategoriheader'],
						'kategoritarif_id' => $request['kategoritarif_id'],
						'keterangan'       => '-',
						'tahuntarif_id'    => configrs()->tahuntarif,
						'total'            => $row['total']
					]
				);
				array_push($irjID, $tarif->id);
				//Input split
				$mastersplit = Mastersplit::where('kategoriheader_id', $request['kategoriheader'])->get();
				for ($i = 1; $i <= $mastersplit->count(); $i++) {
					//if (!empty($row['split'.$i])) {
						$split = Split::create([
								'tahuntarif_id'     => configrs()->tahuntarif,
								'kategoriheader_id' => $request['kategoriheader'],
								'tarif_id'          => $tarif->id,
								'nama'              => $request['nama'.$i],
								'nominal'           => $row['split'.$i]
							]);
					//}

				}
			}
		}

		$tarifs = Tarif::whereIn('id', $irjID)->get();
		if ($tarifs->count() == 0) {
			Flashy::info('Tidak ada data tarif IGD yang diimport');
		} else {
			Flashy::success($tarifs->count().' Data Tarif IGD berhasil diimport ke Database ');
		}

		// Return it's location
		return redirect('kontrolpanel/import');
	}

	//====================== ICD9 ==================================================
	public function templateIcd9() {
		Excel::create('Template ICD9', function ($excel) {
				// Set the properties
				$excel->setTitle('Template ICD9')
				->setCreator('Digihealth')
					->setCompany('Digihealth')
				->setDescription('Template ICD9');
				$excel->sheet('Tarif ICD9', function ($sheet) {
						$row = 1;
						$sheet->row($row, [
								'nomor',
								'nama',
							]);
					});
			})->export('xlsx');
	}

	public function importIcd9(Request $request) {
		request()->validate(['excel' => 'required']);
		$excel = $request->file('excel');

		$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
				// options, jika ada
			})->get();

		// rule
		$rowRules = [
			'nomor' => 'required',
			'nama'  => 'required',
		];
		$icd9ID = [];

		//Looping data
		foreach ($excels as $row) {
			$validator = Validator::make($row->toArray(), $rowRules);
			if ($validator->fails()) {continue;
			}

			$icd9 = Icd9::where('nama', $row['nama'])->first();
			if (!$icd9) {
				$icd9 = Icd9::create([
						'nomor' => $row['nomor'],
						'nama'  => $row['nama'],
					]
				);
				array_push($icd9ID, $icd9->id);
			}
		}

		$icd9s = Icd9::whereIn('id', $icd9ID)->get();
		if ($icd9s->count() == 0) {
			Flashy::info('Tidak ada data ICD9 yang diimport');
		} else {
			Flashy::success($icd9s->count().' Data ICD9 berhasil diimport ke Database ');
		}

		// Return it's location
		return redirect('kontrolpanel/import');
	}

	//====================== ICD9 ==================================================
	public function templateIcd10() {
		Excel::create('Template ICD10', function ($excel) {
				// Set the properties
				$excel->setTitle('Template ICD10')
				->setCreator('Digihealth')
					->setCompany('Digihealth')
				->setDescription('Template ICD10');
				$excel->sheet('Tarif ICD10', function ($sheet) {
						$row = 1;
						$sheet->row($row, [
								'nomor',
								'nama',
							]);
					});
			})->export('xlsx');
	}

	public function importIcd10(Request $request) {
		request()->validate(['excel' => 'required']);
		$excel = $request->file('excel');

		$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
				// options, jika ada
			})->get();

		// rule
		$rowRules = [
			'nomor' => 'required',
			'nama'  => 'required',
		];
		$icd10ID = [];

		//Looping data
		foreach ($excels as $row) {
			$validator = Validator::make($row->toArray(), $rowRules);
			if ($validator->fails()) {continue;
			}

			$icd10 = Icd10::where('nama', $row['nama'])->first();
			if (!$icd10) {
				$icd10 = Icd10::create([
						'nomor' => $row['nomor'],
						'nama'  => $row['nama'],
					]
				);
				array_push($icd10ID, $icd10->id);
			}
		}

		$icd10s = Icd10::whereIn('id', $icd10ID)->get();
		if ($icd10s->count() == 0) {
			Flashy::info('Tidak ada data ICD9 yang diimport');
		} else {
			Flashy::success($icd10s->count().' Data ICD10 berhasil diimport ke Database ');
		}

		// Return it's location
		return redirect('kontrolpanel/import');
	}

	public function getKatTarif($kategoriheader_id = '') {
		$kat = Mastersplit::where('kategoriheader_id', $kategoriheader_id)->pluck('namatarif', 'id');
		return json_encode($kat);
	}

}
