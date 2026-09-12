<?php

namespace App\Http\Controllers;
use Auth;
use App\Foliopelaksana;
use App\Gizi;
use App\Mastergizi;
use App\Operasi;
use App\Orderlab;
use App\Orderradiologi;
use App\Rawatinap;
use App\Apoteker;
use App\MasterEtiket;
use App\TakaranobatEtiket;
use App\DataOrderOperasi;
use App\Aturanetiket;
use App\Penjualan;

use DB;
use Excel;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Modules\Bed\Entities\Bed;
use Modules\Icd10\Entities\Icd10;
use Modules\Kamar\Entities\Kamar;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Kelas\Entities\Kelas;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Folio;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\HistoriStatus;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Tarif\Entities\Tarif;
use App\HistoriRawatInap;
use App\Historipengunjung;
use PDF;
use Validator;
use Yajra\DataTables\DataTables;
use Modules\Registrasi\Entities\Biayaregistrasi;
use Modules\Registrasi\Entities\Tagihan;
use Modules\Politype\Entities\Politype;

class AdmissionController extends Controller
{
    public function index()
    {
      $data['total_bed'] = Bed::count();
      $data['sisa_bed'] = Bed::where('reserved', 'N')->count();
      $data['bed'] = Bed::where('reserved', 'N')->get();
      $data['reg'] = Registrasi::join('pasiens','pasiens.id','=','registrasis.pasien_id')->where('pulang',null)->where('kondisi_akhir_pasien',null)->whereIn('status_reg', ['J1', 'J2', 'J3', 'J4', 'G1', 'G2', 'G3', 'G4'])->get(); 
			//where('created_at', 'like', date('Y-m-d').'%')->
      return view('admission.index', $data)->with('no', 1);
    }

    public function admissionByTanggal(Request $request)
    {
      request()->validate(['tga' => 'required']);
      $data['total_bed'] = Bed::count();
      $data['sisa_bed'] = Bed::where('reserved', 'N')->count();
      $data['bed'] = Bed::where('reserved', 'N')->get();
      $data['reg'] = Registrasi::where('created_at', 'like', valid_date($request['tga']).'%')->whereIn('status_reg', ['J1', 'J2', 'J3', 'J4', 'G1', 'G2', 'G3', 'G4'])->get();
      return view('admission.index', $data)->with('no', 1);
    }

    public function proses($id='')
    {
		$reg = Registrasi::where('pasien_id',$id)->first();	  
		$biaya = Biayaregistrasi::where('tipe', 'I')->get();
		$harus_dibayar = 0;
		foreach ($biaya as $key => $d){
			$fol = new Folio();
			$fol->registrasi_id = $reg->id;
			$fol->namatarif = $d->tarif->nama; //koneksi ke Tarif
			$fol->total = $d->tarif->tarif_kelas_3; //koneksi ke Tarif
			$fol->tarif_id = $d->tarif->id; //koneksi ke Tarif
			$fol->lunas = 'N';
			$fol->cara_bayar_id = $reg->bayar;
			
			$poli = Poli::where('id', $reg->poli_id)->first();
			$fol->poli_tipe = $poli->politype;
			
			$fol->jenis = "TI";
			$fol->pasien_id = $reg->pasien_id;
			$fol->dokter_id = $reg->dokter_id;
			$fol->poli_id = $reg->poli_id;
			$fol->user_id = Auth::user()->id;
			$fol->save();
		}		
		$reg->status_reg = 'I1';
		$reg->update();
			
		Flashy::success('Pasien masuk daftar Antrian Rawat Inap');
		return redirect('rawatinap/antrian');;
    }
}
