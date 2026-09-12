<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Modules\Config\Entities\Config;

use Modules\Registrasi\Entities\Folio;

use Modules\Registrasi\Entities\Tagihan;

use Modules\Registrasi\Entities\Registrasi;

use Modules\Registrasi\Entities\Tipelayanan;

use Modules\Rujukan\Entities\Rujukan;

use Modules\Pegawai\Entities\Pegawai;

use Modules\Tarif\Entities\Tarif;

use Modules\Kategoritarif\Entities\Kategoritarif;

use Modules\Pasien\Entities\Pasien;

use Modules\Registrasi\Entities\HistoriStatus;

use Modules\Bed\Entities\Bed;

use Modules\Poli\Entities\Poli;

use Modules\Registrasi\Entities\Carabayar;

use Flashy;

use App\Pembayaran;

use App\Foliopelaksana;

use App\Penjualanbebas;

use App\Rawatinap;

use App\Penjualan;

use App\User;

use App\Penjualandetail;

use App\Inacbg;

use App\MasterBidang;

use App\Kategoripegawai;

use App\Departemen;

use App\MasterJabatan;

use App\StatusKtpPegawai;

use App\StatusPegawai;

use App\Penggajian;



use Validator;

use Activity;

use Excel;

use Auth;

use PDF;

use DB;

use App\Piutang;

use App\UangMuka;

use App\HistorikunjunganIRJ;

use App\HistorikunjunganIGD;

use App\HistoriRawatInap;

use App\Pasienlangsung;

use Yajra\DataTables\DataTables;



use App\Kelompokkelas;



class DireksiController extends Controller

{

    public function laporanKinerja()

    {

      $inacbg = Inacbg::all();

      return view('direksi.laporanKinerja', compact('inacbg'))->with('no', 1);

    }



    public function laporanKinerjaByTanggal(Request $request)

    {

      $inacbg = Inacbg::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();

      return view('direksi.laporanKinerja', compact('inacbg'))->with('no', 1);

    }



    public function tagihan()

    {

      $user = User::join('role_user', 'users.id', '=', 'role_user.user_id')

      ->join('roles', 'roles.id', '=', 'role_user.role_id')

      ->select('users.id as user_id', 'users.name as nama', 'users.email', 'roles.name as Role')

      ->where('roles.name', '=', 'kasir')

      ->get();

      return view('direksi.tagihan', compact('user'));



    }



    public function tagihan_byRequest(Request $request)

    {

      

      request()->validate(['tga'=>'required', 'tgb'=>'required']);

      $user = User::join('role_user', 'users.id', '=', 'role_user.user_id')

								->join('roles', 'roles.id', '=', 'role_user.role_id')

								->select('users.id as user_id', 'users.name as nama', 'users.email', 'roles.name as Role')

								->where('roles.name', '=', 'kasir')

								->get();

                foreach ($user as $key => $d) {

                  $iduser[] = ''.$d->user_id.'';

                }

                $di = [];

                foreach (Pegawai::select('id', 'nama')->where('kategori_pegawai', 1)->get() as $key => $d) {

                  $di[] = '' . $d->id . '';

                }

                $pi = [];

                foreach (Poli::select('id', 'nama')->get() as $key => $d) {

                  $pi[] = '' . $d->id . '';

                }

                $pembayaran = Folio::whereBetween('folios.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                ->join('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')

                ->join('pasiens', 'pasiens.id', '=', 'folios.pasien_id')

                //->join('folios', 'folios.pasien_id', '=', 'pasiens.id')

                //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])

                //->where('registrasis.pulang','!=','1')

                //->whereIn('folios.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

                ->whereIn('registrasis.jenis_pasien', !empty($request['bayar']) ? [$request['bayar']] : ['1', '2','3'])

                ->whereIn('registrasis.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)

                ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)

                ->select('registrasis.bayar', 'registrasis.tipe_jkn', 'registrasis.poli_id', 'pasiens.no_rm', 'pasiens.nama', 'folios.*')

                ->where('folios.lunas','N')

                ->where('folios.total','>','0')

                ->get();

                $tunai = Folio::whereBetween('folios.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                                ->join('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')

                                ->join('pasiens', 'pasiens.id', '=', 'folios.pasien_id')

                                ->whereIn('registrasis.jenis_pasien', !empty($request['bayar']) ? [$request['bayar']] : ['1', '2','3'])

                                ->whereIn('registrasis.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)

                                ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)

                                ->select('registrasis.bayar', 'registrasis.tipe_jkn', 'registrasis.poli_id', 'pasiens.no_rm', 'pasiens.nama', 'folios.*')

                                ->where('folios.lunas','N')

                                ->where('folios.total','>','0')

                                ->sum('total');

                if ($request['lanjut']) {

                  return view('direksi.tagihan', compact('user', 'pembayaran', 'tunai'))->with('no', 1);

                }elseif ($request['excel']) {

                  Excel::create('Laporan Tagihan', function($excel) use ($pembayaran, $tunai) {

                  // Set the properties

                  $excel->setTitle('Tagihan')

                        ->setCreator('Lukstron')

                        ->setCompany('Lukstron')

                        ->setDescription('Tagihan');

                  $excel->sheet('Tagihan', function($sheet) use ($pembayaran, $tunai) {

                    $row = 1;

                    $no=1;

                    $sheet->row($row, [

                      'No',

                      'Tgl / Waktu',

                      'No. RM',

                      'Nama Pasien',

                      'Nama Tarif',

                      'Cara bayar',

                      'total',

                      'Poli',

                      'Dokter'

                                

                              ]);

                      foreach ($pembayaran as $key => $d)  {

                        $sheet->row(++$row, [

                          $no++,

                          $d->created_at,

                          $d->no_rm,

                          $d->nama,

                          $d->namatarif,

                          baca_carabayar($d->bayar).' '.$d->tipe_jkn,

                          number_format($d->total),

                          baca_poli($d->poli_id),

                          baca_dokter($d->dokter_id)

                                ]);

                        };

                        $sheet->row(++$row, ['', '', '', '', '', 'TOTAL', $tunai,  '', '', '', '']);

                    });

            

                  })->export('xlsx');

            

                } elseif ($request['pdf']) {

                  $no=1;

                  $config = Config::find(1);

                  $petugas = !empty($request['petugas']) ? User::find($request['petugas'])->name : '';

                  $periode = $request['tga'].' s/d '.$request['tgb'];

                  $pdf = PDF::loadView('/direksi.pdf_laporan_tagihan', compact('config','user', 'pembayaran', 'tunai', 'no', 'petugas', 'periode'),[
                  'orientation' => 'L']);
                  return $pdf->stream();

                } 

                }



    public function pendapatan()

    {

      $user = User::join('role_user', 'users.id', '=', 'role_user.user_id')

      ->join('roles', 'roles.id', '=', 'role_user.role_id')

      ->select('users.id as user_id', 'users.name as nama', 'users.email', 'roles.name as Role')

      ->where('roles.name', '=', 'kasir')

      ->get();

      return view('direksi.pendapatan', compact('user'));

      

    }



    public function pendapatan_byRequest(Request $request)

    {

      request()->validate(['tga'=>'required', 'tgb'=>'required']);

      $user = User::join('role_user', 'users.id', '=', 'role_user.user_id')

								->join('roles', 'roles.id', '=', 'role_user.role_id')

								->select('users.id as user_id', 'users.name as nama', 'users.email', 'roles.name as Role')

								->where('roles.name', '=', 'kasir')

								->get();

                foreach ($user as $key => $d) {

                  $iduser[] = ''.$d->user_id.'';

                }

                $di = [];

                foreach (Pegawai::select('id', 'nama')->where('kategori_pegawai', 1)->get() as $key => $d) {

                  $di[] = '' . $d->id . '';

                }

                $pi = [];

                foreach (Poli::select('id', 'nama')->get() as $key => $d) {

                  $pi[] = '' . $d->id . '';

                }
                if($request['poli_id']=='13' or $request['poli_id']=='18')
                {
                  $pembayaran_pendapatan = db::table('folios')->join('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')

                  ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
  
                  ->join('pembayarans', 'pembayarans.registrasi_id', '=', 'registrasis.id')
                
                  ->whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                  //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])
  
                  ->whereIn('registrasis.jenis_pasien', !empty($request['bayar']) ? [$request['bayar']] : ['1', '2','3'])
  
                  ->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)
  
                  ->whereIn('folios.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)
  
                  ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
  
                  ->select('registrasis.bayar', 'registrasis.tipe_jkn', 'folios.total','folios.poli_id', 'pasiens.no_rm', 'pasiens.nama','folios.total', 'pembayarans.no_kwitansi','pembayarans.user_id','pembayarans.created_at','pembayarans.subsidi','pembayarans.dokter_id','pembayarans.jenis',DB::raw('CAST(pembayarans.created_at AS date)'))
  
                  ->whereIn('pembayarans.jenis', !empty($request['tipe_penerimaan']) ? [$request['tipe_penerimaan']] : ['piutang','tunai'])
  
                  ->get();

                 

                $tunai = db::table('folios')->join('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')

                                ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')

                                ->join('pembayarans', 'pembayarans.registrasi_id', '=', 'registrasis.id')

                                ->whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                                ->whereIn('registrasis.jenis_pasien', !empty($request['bayar']) ? [$request['bayar']] : ['1', '2','3'])
                                
                                ->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

                                ->whereIn('folios.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)

                                ->whereIn('pembayarans.jenis', !empty($request['tipe_penerimaan']) ? [$request['tipe_penerimaan']] : ['piutang','tunai'])

                                //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : $layanan)

                                ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)

                                ->where('pembayarans.jenis', 'tunai')->sum('folios.total');

                $piutang = db::table('folios')->join('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')

                                ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')

                                ->join('pembayarans', 'pembayarans.registrasi_id', '=', 'registrasis.id')

                                ->whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                                ->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

                                ->whereIn('folios.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)

                                ->whereIn('pembayarans.jenis', !empty($request['tipe_penerimaan']) ? [$request['tipe_penerimaan']] : ['piutang','tunai'])

                                //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : $layanan)

                                ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)

                                ->where('pembayarans.jenis', 'piutang')->sum('folios.total');
                                $pembayaran1 = Pembayaran::join('registrasis', 'registrasis.id', '=', 'pembayarans.registrasi_id')

                ->join('pasiens', 'pasiens.id', '=', 'pembayarans.pasien_id')

                ->groupby(DB::raw('CAST(month(pembayarans.created_at) AS date)'))

                ->select('pembayarans.total','pembayarans.id','pembayarans.jenis','pembayarans.user_id','pembayarans.dibayar','pembayarans.flag','pembayarans.registrasi_id','pembayarans.dokter_id','pembayarans.no_kwitansi','pembayarans.pasien_id','pembayarans.created_at')

                ->whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])

                //->whereIn('registrasis.jenis_pasien', !empty($request['bayar']) ? [$request['bayar']] : ['1', '2','3'])

                //->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

                //->whereIn('registrasis.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)

                //->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)

                

                ->whereIn('jenis', !empty($request['tipe_penerimaan']) ? [$request['tipe_penerimaan']] : ['piutang','tunai'])

                ->get();

                $pembayaran2 = Pembayaran::join('registrasis', 'registrasis.id', '=', 'pembayarans.registrasi_id')

                ->join('pasiens', 'pasiens.id', '=', 'pembayarans.pasien_id')

                ->groupby(DB::raw('CAST(pembayarans.created_at AS date)'))

                ->whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])

                //->whereIn('registrasis.jenis_pasien', !empty($request['bayar']) ? [$request['bayar']] : ['1', '2','3'])

                //->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

                //->whereIn('registrasis.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)

                //->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)

                

                ->sum('total');

                }elseif($request['poli_id']=='17' or $request['poli_id']=='14')
                {
                  $pembayaran_pendapatan = db::table('folios')->join('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')

                  ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
  
                  ->join('pembayarans', 'pembayarans.registrasi_id', '=', 'registrasis.id')
                
                  ->whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                  //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])
  
                  ->whereIn('registrasis.jenis_pasien', !empty($request['bayar']) ? [$request['bayar']] : ['1', '2','3'])
  
                  ->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)
  
                  ->whereIn('folios.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)
  
                  ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)
  
                  ->select('registrasis.bayar', 'registrasis.tipe_jkn', 'folios.total','folios.poli_id', 'pasiens.no_rm', 'pasiens.nama','folios.total', 'pembayarans.no_kwitansi','pembayarans.user_id','pembayarans.created_at','pembayarans.subsidi','pembayarans.dokter_id','pembayarans.jenis',DB::raw('CAST(pembayarans.created_at AS date)'))
  
                  ->whereIn('pembayarans.jenis', !empty($request['tipe_penerimaan']) ? [$request['tipe_penerimaan']] : ['piutang','tunai'])
  
                  ->get();

                 

                $tunai = db::table('folios')->join('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')

                                ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')

                                ->join('pembayarans', 'pembayarans.registrasi_id', '=', 'registrasis.id')

                                ->whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                                ->whereIn('registrasis.jenis_pasien', !empty($request['bayar']) ? [$request['bayar']] : ['1', '2','3'])
                                
                                ->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

                                ->whereIn('folios.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)

                                ->whereIn('pembayarans.jenis', !empty($request['tipe_penerimaan']) ? [$request['tipe_penerimaan']] : ['piutang','tunai'])

                                //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : $layanan)

                                ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)

                                ->where('pembayarans.jenis', 'tunai')->sum('folios.total');

                $piutang = db::table('folios')->join('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')

                                ->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')

                                ->join('pembayarans', 'pembayarans.registrasi_id', '=', 'registrasis.id')

                                ->whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                                ->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

                                ->whereIn('folios.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)

                                ->whereIn('pembayarans.jenis', !empty($request['tipe_penerimaan']) ? [$request['tipe_penerimaan']] : ['piutang','tunai'])

                                //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : $layanan)

                                ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)

                                ->where('pembayarans.jenis', 'piutang')->sum('folios.total');
                                $pembayaran1 = Pembayaran::join('registrasis', 'registrasis.id', '=', 'pembayarans.registrasi_id')

                ->join('pasiens', 'pasiens.id', '=', 'pembayarans.pasien_id')

                ->groupby(DB::raw('CAST(month(pembayarans.created_at) AS date)'))

                ->select('pembayarans.total','pembayarans.id','pembayarans.jenis','pembayarans.user_id','pembayarans.dibayar','pembayarans.flag','pembayarans.registrasi_id','pembayarans.dokter_id','pembayarans.no_kwitansi','pembayarans.pasien_id','pembayarans.created_at')

                ->whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])

                //->whereIn('registrasis.jenis_pasien', !empty($request['bayar']) ? [$request['bayar']] : ['1', '2','3'])

                //->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

                //->whereIn('registrasis.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)

                //->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)

                

                ->whereIn('jenis', !empty($request['tipe_penerimaan']) ? [$request['tipe_penerimaan']] : ['piutang','tunai'])

                ->get();

                $pembayaran2 = Pembayaran::join('registrasis', 'registrasis.id', '=', 'pembayarans.registrasi_id')

                ->join('pasiens', 'pasiens.id', '=', 'pembayarans.pasien_id')

                ->groupby(DB::raw('CAST(pembayarans.created_at AS date)'))

                ->whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])

                //->whereIn('registrasis.jenis_pasien', !empty($request['bayar']) ? [$request['bayar']] : ['1', '2','3'])

                //->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

                //->whereIn('registrasis.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)

                //->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)

                

                ->sum('total');

                }else
                {
                  $pembayaran_pendapatan = Pembayaran::whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                ->join('registrasis', 'registrasis.id', '=', 'pembayarans.registrasi_id')

                ->join('pasiens', 'pasiens.id', '=', 'pembayarans.pasien_id')

                //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])

                ->whereIn('registrasis.jenis_pasien', !empty($request['bayar']) ? [$request['bayar']] : ['1', '2','3'])

                ->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

                ->whereIn('registrasis.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)

                ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)

                ->select('registrasis.bayar', 'registrasis.tipe_jkn', 'registrasis.poli_id', 'pasiens.no_rm', 'pasiens.nama', 'pembayarans.*',DB::raw('CAST(pembayarans.created_at AS date)'))

                ->whereIn('jenis', !empty($request['tipe_penerimaan']) ? [$request['tipe_penerimaan']] : ['piutang','tunai'])

                ->get();

                $pembayaran1 = Pembayaran::join('registrasis', 'registrasis.id', '=', 'pembayarans.registrasi_id')

                ->join('pasiens', 'pasiens.id', '=', 'pembayarans.pasien_id')

                ->groupby(DB::raw('CAST(month(pembayarans.created_at) AS date)'))

                ->select('pembayarans.total','pembayarans.id','pembayarans.jenis','pembayarans.user_id','pembayarans.dibayar','pembayarans.flag','pembayarans.registrasi_id','pembayarans.dokter_id','pembayarans.no_kwitansi','pembayarans.pasien_id','pembayarans.created_at')

                ->whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])

                //->whereIn('registrasis.jenis_pasien', !empty($request['bayar']) ? [$request['bayar']] : ['1', '2','3'])

                //->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

                //->whereIn('registrasis.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)

                //->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)

                

                ->whereIn('jenis', !empty($request['tipe_penerimaan']) ? [$request['tipe_penerimaan']] : ['piutang','tunai'])

                ->get();

                $pembayaran2 = Pembayaran::join('registrasis', 'registrasis.id', '=', 'pembayarans.registrasi_id')

                ->join('pasiens', 'pasiens.id', '=', 'pembayarans.pasien_id')

                ->groupby(DB::raw('CAST(pembayarans.created_at AS date)'))

                ->whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])

                //->whereIn('registrasis.jenis_pasien', !empty($request['bayar']) ? [$request['bayar']] : ['1', '2','3'])

                //->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

                //->whereIn('registrasis.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)

                //->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)

                

                ->sum('total');

                $tunai = Pembayaran::whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                                ->join('registrasis', 'registrasis.id', '=', 'pembayarans.registrasi_id')

                                ->join('pasiens', 'pasiens.id', '=', 'pembayarans.pasien_id')

                                ->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

                                ->whereIn('registrasis.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)

                                ->whereIn('jenis', !empty($request['tipe_penerimaan']) ? [$request['tipe_penerimaan']] : ['piutang','tunai'])

                                //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : $layanan)

                                ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)

                                ->where('jenis', 'tunai')->sum('total');

                $piutang = Pembayaran::whereBetween('pembayarans.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

                                ->join('registrasis', 'registrasis.id', '=', 'pembayarans.registrasi_id')

                                ->join('pasiens', 'pasiens.id', '=', 'pembayarans.pasien_id')

                                ->whereIn('pembayarans.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

                                ->whereIn('registrasis.poli_id', !empty($request['poli_id']) ? [$request['poli_id']] : $pi)

                                ->whereIn('jenis', !empty($request['tipe_penerimaan']) ? [$request['tipe_penerimaan']] : ['piutang','tunai'])

                                //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : $layanan)

                                ->whereIn('registrasis.dokter_id', !empty($request['dokter_id']) ? [$request['dokter_id']] : $di)

                                ->where('jenis', 'piutang')->sum('total');

                }
                
                $namatanggal = Pembayaran::select('created_at')->orderBy('created_at', 'asc')->groupBy('created_at')->get()->toArray(); 

                $namatanggal = array_column($namatanggal,'created_at');

                

                if ($request['lanjut']) {

                  return view('direksi.pendapatan', compact('user','namatanggal', 'pembayaran_pendapatan', 'tunai', 'piutang','pembayaran1','pembayaran2'))->with('no', 1);

                }elseif ($request['excel']) {

                  Excel::create('Laporan Pendapatan', function($excel) use ($pembayaran_pendapatan, $tunai, $piutang) {

                  // Set the properties

                  $excel->setTitle('Pendapatan')

                        ->setCreator('Lukstron')

                        ->setCompany('Lukstron')

                        ->setDescription('Laporan Pendapatan');

                  $excel->sheet('Laporan Pendapatan', function($sheet) use ($pembayaran_pendapatan, $tunai, $piutang) {

                    $row = 1;

                    $no=1;

                    $sheet->row($row, [

                      'No',

                      'No Kuitansi',

                      'Tgl / Waktu',

                      'No. RM',

                      'Nama',

                      'Cara bayar',

                      'Tunai',

                      'Piutang',

                      'Subsidi',

                      'Kasir',

                      'Poli',

                      'Dokter'

                                

                              ]);

                      foreach ($pembayaran as $key => $d)  {

                        $sheet->row(++$row, [

                          $no++,

                          $d->no_kwitansi,

                          $d->created_at,

                          $d->no_rm,

                          $d->nama,

                          baca_carabayar($d->bayar).' '.$d->tipe_jkn,

                          ($d->jenis == 'tunai') ? $d->dibayar : '',

                          ($d->jenis == 'piutang') ? $d->dibayar : '',

                          $d->subsidi,

                          User::find($d->user_id)->name,

                          baca_poli($d->poli_id),

                          baca_dokter($d->dokter_id)

                                ]);

                        };

                        $sheet->row(++$row, ['', '', '', '', '', 'TOTAL', $tunai, $piutang, '', '', '', '']);

                    });

            

                  })->export('xlsx');

            

                } elseif ($request['pdf']) {

                  $no=1;

                  $config = Config::find(1);

                  $petugas = !empty($request['petugas']) ? User::find($request['petugas'])->name : '';

                  $periode = $request['tga'].' s/d '.$request['tgb'];

                  $pdf = PDF::loadView('direksi.pdf_laporan_pendapatan', compact('config','user', 'pembayaran_pendapatan', 'tunai','piutang',  'no', 'petugas', 'periode'),[
                    'format' => 'legal-L']);

                  return $pdf->stream();

                } 

                }



    public function penerimaan()

    {

      return view('direksi.penerimaan');

      

    }



    public function uangmuka()

    {

      $user = User::join('role_user', 'users.id', '=', 'role_user.user_id')

								->join('roles', 'roles.id', '=', 'role_user.role_id')

								->select('users.id as user_id', 'users.name as nama', 'users.email', 'roles.name as Role')

								->where('roles.name', '=', 'kasir')

								->get();

                return view('direksi.pem_uang_muka', compact('user'));

      }

    public function uangmuka_byRequest(Request $request)

    {

      

      request()->validate(['tga'=>'required', 'tgb'=>'required']);

      $user = User::join('role_user', 'users.id', '=', 'role_user.user_id')

								->join('roles', 'roles.id', '=', 'role_user.role_id')

								->select('users.id as user_id', 'users.name as nama', 'users.email', 'roles.name as Role')

								->where('roles.name', '=', 'kasir')

								->get();

		$iduser = [];

		foreach ($user as $key => $d) {

			$iduser[] = ''.$d->user_id.'';

    }

    $uangmu = [];

      foreach(UangMuka::select('id')->get() as $d){

        $uangmu[] = '' . $d->id . '';

      }

    $uangmuka =   UangMuka::whereBetween('uang_muka.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

    ->whereIn('uang_muka.updated_by', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

    ->get();

		$pembayaran = UangMuka::whereBetween('uang_muka.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

														->join('registrasis', 'registrasis.id', '=', 'uang_muka.registrasi_id')

														->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')

														->whereIn('uang_muka.updated_by', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

                           

                            ->get();

		$tunai = UangMuka::whereBetween('uang_muka.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

														->whereIn('uang_muka.updated_by', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

														->sum('total');

	

		if ($request['lanjut']) {

			return view('direksi.pem_uang_muka', compact('user','uangmuka', 'pembayaran', 'tunai'))->with('no', 1);

		}elseif ($request['excel']) {

			Excel::create('Laporan Keuangan', function($excel) use ($pembayaran, $tunai, $piutang) {

			// Set the properties

			$excel->setTitle('Tutup Kasir')

						->setCreator('Lukstron')

						->setCompany('Lukstron')

						->setDescription('Tutup Kasir');

			$excel->sheet('Tutup Kasir', function($sheet) use ($pembayaran, $tunai, $piutang) {

				$row = 1;

				$no=1;

				$sheet->row($row, [

										'No',

										'No Kuitansi',

										'Tgl / Waktu',

										'No. RM',

										'Nama',

										'Cara bayar',

										'Tunai',

										'Piutang',

										'Subsidi',

										'Kasir',

										'Poli',

										'Dokter'

									]);

					foreach ($pembayaran as $key => $d)  {

						$sheet->row(++$row, [

											$no++,

											$d->no_kwitansi,

											$d->created_at,

											$d->no_rm,

											$d->nama,

											baca_carabayar($d->bayar).' '.$d->tipe_jkn,

											($d->jenis == 'tunai') ? $d->dibayar : '',

											($d->jenis == 'piutang') ? $d->dibayar : '',

											$d->subsidi,

											User::find($d->user_id)->name,

											baca_poli($d->poli_id),

											baca_dokter($d->dokter_id)

										]);

						};

						$sheet->row(++$row, ['', '', '', '', '', 'TOTAL', $tunai, $piutang, '', '', '', '' ]);

				});



			})->export('xlsx');



		}elseif ($request['pdf']) {

			$no=1;

			$petugas = !empty($request['petugas']) ? User::find($request['petugas'])->name : '';

			$periode = $request['tga'].' s/d '.$request['tgb'];

			$pdf = PDF::loadView('direksi.pdf_laporan_uang_muka', compact('user', 'pembayaran', 'tunai',  'no', 'petugas', 'periode'),[
        'format' => 'legal-L']);

			return $pdf->download('laporan uang Muka.pdf');

		}else{

      return view('direksi.pem_uang_muka');

    }



		 

    }



    public function bridgingjkn()

    {

      return view('direksi.bridging_jkn');

    }



    public function selisihnegatif()

    {

      return view('direksi.selisih_negatif_jkn');

    }

//naik kelas

    public function naikkelas()

    {

      $user = User::join('role_user', 'users.id', '=', 'role_user.user_id')

								->join('roles', 'roles.id', '=', 'role_user.role_id')

								->select('users.id as user_id', 'users.name as nama', 'users.email', 'roles.name as Role')

								->where('roles.name', '=', 'kasir')

								->get();

                

    

      return view('direksi.naik_kelas', compact('user'));

    }

    public function naikkelas_byRequest(Request $request)

    {

      

      request()->validate(['tga'=>'required', 'tgb'=>'required']);

      $user = User::join('role_user', 'users.id', '=', 'role_user.user_id')

								->join('roles', 'roles.id', '=', 'role_user.role_id')

								->select('users.id as user_id', 'users.name as nama', 'users.email', 'roles.name as Role')

								->where('roles.name', '=', 'kasir')

								->get();

		$iduser = [];

		foreach ($user as $key => $d) {

			$iduser[] = ''.$d->user_id.'';

    }

    

   

		$pembayaran = Registrasi::whereBetween('registrasis.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])

														->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')

                            ->where('is_naik_kelas','=','1')

                            ->select('registrasis.created_at','pasiens.no_rm','registrasis.reg_id','pasiens.nama','registrasis.hak_kelas_inap','registrasis.is_naik_kelas')

                            ->get();

	

	

		if ($request['lanjut']) {

			return view('direksi.naik_kelas', compact('user', 'pembayaran'))->with('no', 1);

		}elseif ($request['excel']) {

			Excel::create('Laporan Naik Kelas', function($excel) use ($pembayaran) {

			// Set the properties

			$excel->setTitle('Naik Kelas')

						->setCreator('Lukstron')

						->setCompany('Lukstron')

						->setDescription('Naik Kelas');

			$excel->sheet('Naik Kelas', function($sheet) use ($pembayaran) {

				$row = 1;

				$no=1;

				$sheet->row($row, [

										'No',

										'Tgl / Waktu',

                    'No. RM',

                    'No Registrasi',

										'Nama Pasien',

										'Kelas Awal',

										'Naik Kelas'

									]);

					foreach ($pembayaran as $key => $d)  {

						$sheet->row(++$row, [

											$no++,

											$d->created_at,

                      $d->no_rm,

                      $d->reg_id,

											$d->nama,

                      baca_kelas($d->hak_kelas_inap),

                      baca_kelas($d->is_naik_kelas)

										]);

						};

						$sheet->row(++$row, ['', '', '', '', '', '', '', '', '' ]);

				});



			})->export('xlsx');



		}elseif ($request['pdf']) {

			$no=1;

			$petugas = !empty($request['petugas']) ? User::find($request['petugas'])->name : '';

			$periode = $request['tga'].' s/d '.$request['tgb'];

			$pdf = PDF::loadView('direksi.pdf_laporan_naik_kelas', compact('user', 'pembayaran', 'no', 'petugas', 'periode'),[
        'format' => 'legal-L']);

			return $pdf->download('laporan naik kelas.pdf');

		}else{

      return view('direksi.naik_kelas');

    }



		 

    }

    //KINERJA RAWAT JALAN

    public function kinerjaRawatJalan()

    {

      $data['carabayar'] = Carabayar::select('carabayar', 'id')->get();

      $data['klinik'] = Poli::where('politype', 'J')->get();

      return view('direksi.kinerjaRawatJalan', $data)->with('no',1);

    }



    public function kinerjaRawatJalanByDate(Request $request)

    {

      request()->validate(['tga' => 'required', 'tgb' => 'required']);

      if ($request['submit'] == 'view') {

        $data['tga'] = valid_date($request['tga']).' 00:00:00';

        $data['tgb'] = valid_date($request['tgb']).' 23:59:59';

              session(['tga'=>$data['tga'], 'tgb'=>$data['tgb']]);

        $data['cara_bayar_id'] = $request['carabayar'];

        $data['carabayar'] = Carabayar::select('carabayar', 'id')->get();

        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();

        $data['klinik'] = Poli::where('politype', 'J')->get();

        return view('direksi.kinerjaRawatJalan', $data)->with('no',1);

      } else {

        $tga = valid_date($request['tga']).' 00:00:00';

          $tgb = valid_date($request['tgb']).' 23:59:59';

          $cara_bayar_id = $request['carabayar'];

          $dokter= Pegawai::where('kategori_pegawai', 1)->get();

          $klinik = Poli::where('politype', 'J')->get();

          Excel::create('Laporan Kinerja Rawat Jalan', function($excel) use ($klinik, $dokter, $tga, $tgb, $cara_bayar_id) {

                $excel->sheet('Kinerja Rawat Jalan', function($sheet) use ($klinik, $dokter, $tga, $tgb, $cara_bayar_id) {

                    $sheet->loadView('direksi.excelKinerjaRawatJalan')->with("klinik", $klinik)->with("dokter", $dokter)->with("tga", $tga)->with("tgb", $tgb)->with("cara_bayar_id", $cara_bayar_id)->with('no',1);

                });

            })->export('xlsx');

      }

    }



    public function detailKinerjaRawatJalan($dokter_id, $cara_bayar_id, $mapping)

    {

      $pemeriksaan = Tarif::where('mapping_pemeriksaan', $mapping)->get();

      $pm = [];

      foreach ($pemeriksaan as $key => $d) {

        $pm[] = '' . $d->id . '';

      }

      $bayar = [];

      foreach(Carabayar::select('id')->get() as $d){

        $bayar[] = '' . $d->id . '';

      }

      if($cara_bayar_id == '100'){

        $data['detail'] = Folio::where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->whereIn('cara_bayar_id', $bayar)->where('jenis', 'TA')->whereBetween('updated_at', [session('tga'), session('tgb')])->get();

      } else {

        $data['detail'] = Folio::where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('cara_bayar_id', $cara_bayar_id)->where('jenis', 'TA')->whereBetween('updated_at', [session('tga'), session('tgb')])->get();

      }

      

      return view('direksi.detailKinerjaRawatJalan', $data)->with('no', 1);

    }



    //KINERJA RAWAT DARURAT

    public function kinerjaRawatDarurat()

    {

      $data['carabayar'] = Carabayar::select('carabayar', 'id')->get();

      $data['klinik'] = Poli::where('politype', 'G')->get();

      return view('direksi.kinerjaRawatDarurat', $data)->with('no',1);

    }



    public function kinerjaRawatDaruratByDate(Request $request)

    {

      request()->validate(['tga' => 'required', 'tgb' => 'required']);

      if ($request['submit'] == 'view') {

        $data['tga'] = valid_date($request['tga']).' 00:00:00';

        $data['tgb'] = valid_date($request['tgb']).' 23:59:59';

            session(['tga'=>$data['tga'], 'tgb'=>$data['tgb']]);

        $data['cara_bayar_id'] = $request['carabayar'];

        $data['carabayar'] = Carabayar::select('carabayar', 'id')->get();

        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();

        $data['klinik'] = Poli::where('politype', 'G')->get();

        return view('direksi.kinerjaRawatDarurat', $data)->with('no',1);

      } else {

        $tga = valid_date($request['tga']).' 00:00:00';

        $tgb = valid_date($request['tgb']).' 23:59:59';

        $cara_bayar_id = $request['carabayar'];

        $dokter= Pegawai::where('kategori_pegawai', 1)->get();

        $klinik = Poli::where('politype', 'G')->get();

        Excel::create('Laporan Kinerja Rawat Darurat', function($excel) use ($klinik, $dokter, $tga, $tgb, $cara_bayar_id) {

              $excel->sheet('Kinerja Rawat Darurat', function($sheet) use ($klinik, $dokter, $tga, $tgb, $cara_bayar_id) {

                  $sheet->loadView('direksi.excelKinerjaRawatDarurat')->with("klinik", $klinik)->with("dokter", $dokter)->with("tga", $tga)->with("tgb", $tgb)->with("cara_bayar_id", $cara_bayar_id)->with('no',1);

              });

          })->export('xlsx');

      }

    }



    public function detailKinerjaRawatDarurat($dokter_id, $cara_bayar_id, $mapping)

    {

      $pemeriksaan = Tarif::where('mapping_pemeriksaan', $mapping)->get();

      $pm = [];

      foreach ($pemeriksaan as $key => $d) {

        $pm[] = '' . $d->id . '';

      }

      $bayar = [];

      foreach(Carabayar::select('id')->get() as $d){

        $bayar[] = '' . $d->id . '';

      }

      if($cara_bayar_id == '100'){

        $data['detail'] = Folio::where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->whereIn('cara_bayar_id', $bayar)->where('jenis', 'TG')->whereBetween('updated_at', [session('tga'), session('tgb')])->get();

      } else {

        $data['detail'] = Folio::where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('cara_bayar_id', $cara_bayar_id)->where('jenis', 'TG')->whereBetween('updated_at', [session('tga'), session('tgb')])->get();

      }

      return view('direksi.detailKinerjaRawatDarurat', $data)->with('no', 1);

    }



    //KINERJA RAWAT INAP

    public function kinerjaRawatInap()

    {

      $data['carabayar'] = Carabayar::select('carabayar', 'id')->get();

      $data['bangsal'] = Kelompokkelas::all();

      return view('direksi.kinerjaRawatInap', $data)->with('no',1);

    }



    public function kinerjaRawatInapByDate(Request $request) 

    {

      request()->validate(['tga' => 'required', 'tgb' => 'required']);

      if ($request['submit'] == 'view') {

        $data['tga'] = valid_date($request['tga']).' 00:00:00';

        $data['tgb'] = valid_date($request['tgb']).' 23:59:59';

            session(['tga'=>$data['tga'], 'tgb'=>$data['tgb']]);

        $data['cara_bayar_id'] = $request['carabayar'];

        $data['carabayar'] = Carabayar::select('carabayar', 'id')->get();

        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();

        $data['bangsal'] = Kelompokkelas::all();

        return view('direksi.kinerjaRawatInap', $data)->with('no',1);

      } else {

        $tga = valid_date($request['tga']).' 00:00:00';

        $tgb = valid_date($request['tgb']).' 23:59:59';

        $cara_bayar_id = $request['carabayar'];

        $dokter= Pegawai::where('kategori_pegawai', 1)->get();

        $bangsal = Kelompokkelas::get();

      Excel::create('Laporan Kinerja Rawat Inap', function($excel) use ($bangsal, $dokter, $tga, $tgb, $cara_bayar_id) {

                $excel->sheet('Kinerja Rawat Inap', function($sheet) use ($bangsal, $dokter, $tga, $tgb, $cara_bayar_id) {

                    $sheet->loadView('direksi.excelKinerjaRawatInap')->with("bangsal", $bangsal)->with("dokter", $dokter)->with("tga", $tga)->with("tgb", $tgb)->with("cara_bayar_id", $cara_bayar_id)->with('no',1);

                });

            })->export('xlsx');

    }

  }



    public function detailKinerjaRawatInap($dokter_id, $cara_bayar_id, $mapping)

    {

      $pemeriksaan = Tarif::where('mapping_pemeriksaan', $mapping)->get();

      $pm = [];

      foreach ($pemeriksaan as $key => $d) {

        $pm[] = '' . $d->id . '';

      }

      $bayar = [];

      foreach(Carabayar::select('id')->get() as $d){

        $bayar[] = '' . $d->id . '';

      }

      if($cara_bayar_id == '100'){

        $data['detail'] = Folio::where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->whereIn('cara_bayar_id', $bayar)->where('jenis', 'TI')->whereBetween('updated_at', [session('tga'), session('tgb')])->get();

      } else {

        $data['detail'] = Folio::where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('cara_bayar_id', $cara_bayar_id)->where('jenis', 'TI')->whereBetween('updated_at', [session('tga'), session('tgb')])->get();

      }

      return view('direksi.detailKinerjaRawatInap', $data)->with('no', 1);

    }



    public function pendapatan1()

    {

      $user = User::join('role_user', 'users.id', '=', 'role_user.user_id')

								->join('roles', 'roles.id', '=', 'role_user.role_id')

								->select('users.id as user_id', 'users.name as nama', 'users.email', 'roles.name as Role')

								->where('roles.name', '=', 'kasir')

								->get();

      return view('direksi.pendapatan1', compact('user'));

    }



    //managemen

    public function bidang()

    {

      $data['bidang'] = MasterBidang::all();

      //$bidang = MasterBidang::all();

      return view('direksi/kodebidang.index', $data)->with('no',1);



    }



    public function createbidang()

    {

        return view('direksi/kodebidang.create');

    }



    public function storebidang(Request $request)

    {

      $data = request()->validate(['kode'=>'required','nama_bidang'=>'required']);

      MasterBidang::create($data);

      Flashy::success('kode Bidang Telah Ditambahkan');

      

      return redirect()->route('bidang');

    }

    public function editbidang($id)

    {

      $data['kodebidang'] = MasterBidang::find($id);

      return view('/direksi/kodebidang.edit',$data);

    }



    public function updatebidang(Request $request, $id)

    {

      $data = request()->validate(['kode'=>'required','nama_bidang'=>'required']);

      MasterBidang::find($id)->update($data);

      Flashy::info('Data Kode bidang berhasil di update');

      return redirect()->route('bidang');

    }



    public function delete($id)

    {

        $bidang = MasterBidang::find($id);

        $bidang->delete();

        return redirect()->route('bidang');

    }



    //kategoripegawai

    public function kategoripegawai()

    {

      $data['kategoripegawai'] = Kategoripegawai::all();

      //$bidang = MasterBidang::all();

      return view('direksi/kategoripegawai.index', $data)->with('no',1);



    }



    public function createkategoripegawai()

    {

        return view('direksi/kategoripegawai.create');

    }



    public function storekategoripegawai(Request $request)

    {

      $data = request()->validate(['kategori'=>'required']);

      Kategoripegawai::create($data);

      Flashy::success('Kategori Pegawai Telah Ditambahkan');

      

      return redirect()->route('kategoripegawai');

    }

    public function editkategoripegawai($id)

    {

      $data['kategoripegawai'] = Kategoripegawai::find($id);

      return view('/direksi/kategoripegawai.edit',$data);

    }



    public function updatekategoripegawai(Request $request, $id)

    {

      $data = request()->validate(['kategori'=>'required']);

      Kategoripegawai::find($id)->update($data);

      Flashy::info('Data Kategori Pegawai berhasil di update');

      return redirect()->route('kategoripegawai');

    }



    public function deletekategoripegawai($id)

    {

        $Kategoripegawai = Kategoripegawai::find($id);

        $Kategoripegawai->delete();

        return redirect()->route('kategoripegawai');

    }

   

   

   //departemen

   public function departemen()

   {

     $data['departemen'] = Departemen::all();

     //$bidang = MasterBidang::all();

     return view('direksi/departemen.index', $data)->with('no',1);



   }



   public function createdepartemen()

   {

       return view('direksi/departemen.create');

   }



   public function storedepartemen(Request $request)

   {

     $data = request()->validate(['departemen'=>'required']);

     Departemen::create($data);

     Flashy::success('Departemen Telah Ditambahkan');

     

     return redirect()->route('departemen');

   }

   public function editdepartemen($id)

   {

     $data['departemen'] = Departemen::find($id);

     return view('/direksi/departemen.edit',$data);

   }



   public function updatedepartemen(Request $request, $id)

   {

     $data = request()->validate(['departemen'=>'required']);

     Departemen::find($id)->update($data);

     Flashy::info('Data Departemen berhasil di update');

     return redirect()->route('departemen');

   }



   public function deletedepartemen($id)

   {

       $departemen = Departemen::find($id);

       $departemen->delete();

       return redirect()->route('departemen');

   }

   

   //status KTP

   public function statusktppegawai()

   {

     $data['statusktppegawai'] = StatusKtpPegawai::all();

     //$bidang = MasterBidang::all();

     return view('direksi/statusktppegawai.index', $data)->with('no',1);



   }



   public function createstatusktppegawai()

   {

       return view('direksi/statusktppegawai.create');

   }



   public function storestatusktppegawai(Request $request)

   {

     $data = request()->validate(['status'=>'required','keterangan'=>'required','tunjangan'=>'required']);

     StatusKtpPegawai::create($data);

     Flashy::success('Status KTP Telah Ditambahkan');

     

     return redirect()->route('statusktppegawai');

   }

   public function editstatusktppegawai($id)

   {

     $data['statusktppegawai'] = StatusKtpPegawai::find($id);

     return view('/direksi/statusktppegawai.edit',$data);

   }



   public function updatestatusktppegawai(Request $request, $id)

   {

     $data = request()->validate(['status'=>'required','keterangan'=>'required','tunjangan'=>'required']);

     StatusKtpPegawai::find($id)->update($data);

     Flashy::info('Data Status KTP berhasil di update');

     return redirect()->route('statusktppegawai');

   }



   public function deletestatusktppegawai($id)

   {

       $status = StatusKtpPegawai::find($id);

       $status->delete();

       return redirect()->route('statusktppegawai');

   }

   

   //Master jabatan

   public function masterjabatan()

   {

     $data['masterjabatan'] = MasterJabatan::all();

     //$bidang = MasterBidang::all();

     return view('direksi/masterjabatan.index', $data)->with('no',1);



   }



   public function createmasterjabatan()

   {

       return view('direksi/masterjabatan.create');

   }



   public function storemasterjabatan(Request $request)

   {

     $data = request()->validate(['kode_jabatan'=>'required','nama_jabatan'=>'required','tunjangan_jabatan'=>'required']);

     MasterJabatan::create($data);

     Flashy::success('Master Jabatan Telah Ditambahkan');

     

     return redirect()->route('masterjabatan');

   }

   public function editmasterjabatan($id)

   {

     $data['masterjabatan'] = MasterJabatan::find($id);

     return view('/direksi/masterjabatan.edit',$data);

   }



   public function updatemasterjabatan(Request $request, $id)

   {

     $data = request()->validate(['kode_jabatan'=>'required','nama_jabatan'=>'required','tunjangan_jabatan'=>'required']);

     MasterJabatan::find($id)->update($data);

     Flashy::info('Data Master Jabatan berhasil di update');

     return redirect()->route('masterjabatan');

   }



   public function deletemasterjabatan($id)

   {

       $jabatan = MasterJabatan::find($id);

       $jabatan->delete();

       return redirect()->route('masterjabatan');

   

   }

   

   

   //status KTP

   public function statuspegawai()

   {

     $data['statuspegawai'] = StatusPegawai::all();

     //$bidang = MasterBidang::all();

     return view('direksi/statuspegawai.index', $data)->with('no',1);



   }



   public function createstatuspegawai()

   {

       return view('direksi/statuspegawai.create');

   }



   public function storestatuspegawai(Request $request)

   {

     $data = request()->validate(['status'=>'required','keterangan'=>'required']);

     StatusPegawai::create($data);

     Flashy::success('Status KTP Telah Ditambahkan');

     

     return redirect()->route('statuspegawai');

   }

   public function editstatuspegawai($id)

   {

     $data['statuspegawai'] = StatusPegawai::find($id);

     return view('/direksi/statuspegawai.edit',$data);

   }



   public function updatestatuspegawai(Request $request, $id)

   {

     $data = request()->validate(['status'=>'required','keterangan'=>'required']);

     StatusPegawai::find($id)->update($data);

     Flashy::info('Data Status KTP berhasil di update');

     return redirect()->route('statuspegawai');

   }



   public function deletestatuspegawai($id)

   {

       $status = StatusPegawai::find($id);

       $status->delete();

       return redirect()->route('statuspegawai');

   }

   

   // penggajian

   public function penggajian()

   {  

    

    $pegawai = Pegawai::join('status_ktp_pegawai', 'status_ktp_pegawai.id', '=', 'pegawais.status_ktp_pegawai')

    ->join('departemen', 'departemen.id', '=', 'pegawais.departemen')

    ->join('masterjabatan', 'masterjabatan.id', '=', 'pegawais.jabatan')

    ->join('status_pegawai', 'status_pegawai.id', '=', 'pegawais.status_pegawai')

    ->join('kategoripegawais', 'kategoripegawais.id', '=', 'pegawais.kategori_pegawai')

    ->select('status_pegawai.keterangan as status_peg','pegawais.*', 'departemen.departemen', 'masterjabatan.nama_jabatan', 'masterjabatan.tunjangan_jabatan', 'kategoripegawais.kategori','status_ktp_pegawai.tunjangan as tunjangan_ktp')

    ->get();

    $gaji = Penggajian::join('pegawais', 'pegawais.id', '=', 'penggajian.id')

            ->select('penggajian.kode','penggajian.total_gaji','penggajian.gaji_pokok')

            ->get();

    

     //$bidang = MasterBidang::all();

     return view('direksi/penggajian.index',compact('pegawai','gaji'))->with('no', 1);



   }

   

   public function inputpenggajian($id)

   {

      $data['pegawai'] = Pegawai::find($id);

      $departemen = Departemen::pluck('departemen', 'id');

		  

      $jabatan = MasterJabatan::pluck('nama_jabatan', 'id');

      $jabatan1 = MasterJabatan::pluck('tunjangan_jabatan', 'id');

		  $status_ktp_pegawai = StatusKtpPegawai::pluck('keterangan', 'id');

		  $status_pegawai = StatusPegawai::pluck('keterangan', 'id');

      $pegawai = Pegawai::join('status_ktp_pegawai', 'status_ktp_pegawai.id', '=', 'pegawais.status_ktp_pegawai')

      ->join('departemen', 'departemen.id', '=', 'pegawais.departemen')

      ->join('masterjabatan', 'masterjabatan.id', '=', 'pegawais.jabatan')

      ->join('status_pegawai', 'status_pegawai.id', '=', 'pegawais.status_pegawai')

      ->join('kategoripegawais', 'kategoripegawais.id', '=', 'pegawais.kategori_pegawai')

      ->join('penggajian', 'penggajian.kode', '=', 'pegawais.id')

    

    ->where('pegawais.id','=',$id)

    //->join('folios', 'folios.pasien_id', '=', 'pasiens.id')

    //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])

    //->where('registrasis.pulang','!=','1')

    //->whereIn('folios.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

    ->select('pegawais.nama','status_pegawai.keterangan as status_peg','pegawais.id', 'departemen.departemen', 'masterjabatan.nama_jabatan', 'masterjabatan.tunjangan_jabatan', 'kategoripegawais.kategori','status_ktp_pegawai.tunjangan as tunjangan_ktp')

    ->get();

      return view('/direksi/penggajian.input',$data,compact('pegawai','jabatan','jabatan1','status_ktp_pegawai','status_pegawai','departemen'))->with('no', 1);

   }



   public function savepenggajian(Request $request, $id)

   {

    $data['pegawai'] = Pegawai::find($id);

    $pegawai = Pegawai::join('status_ktp_pegawai', 'status_ktp_pegawai.id', '=', 'pegawais.status_ktp_pegawai')

    ->join('departemen', 'departemen.id', '=', 'pegawais.departemen')

    ->join('masterjabatan', 'masterjabatan.id', '=', 'pegawais.jabatan')

    ->join('status_pegawai', 'status_pegawai.id', '=', 'pegawais.status_pegawai')

    ->join('kategoripegawais', 'kategoripegawais.id', '=', 'pegawais.kategori_pegawai')

    ->join('penggajian', 'penggajian.kode', '=', 'pegawais.id')

    

    ->where('pegawais.id','=',$id)

    //->join('folios', 'folios.pasien_id', '=', 'pasiens.id')

    //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])

    //->where('registrasis.pulang','!=','1')

    //->whereIn('folios.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

    ->select('status_ktp_pegawai.*','pegawais.nama','status_pegawai.keterangan as status_peg','pegawais.id', 'departemen.departemen', 'masterjabatan.nama_jabatan', 'masterjabatan.tunjangan_jabatan', 'kategoripegawais.kategori','status_ktp_pegawai.tunjangan as tunjangan_ktp')

    ->get();

    $jabatan = MasterJabatan::pluck('tunjangan_jabatan')->where('id','=',$request->jabatan);

    $status_ktp_pegawai = StatusKtpPegawai::pluck('keterangan')->where('id','=',$request->status_ktp_pegawai);

    $status_pegawai = StatusPegawai::pluck('keterangan', 'id');

    if($request->status_pegawai==1) 
    {
    Penggajian::create([

       'kode'=> $id,

       'nama'=> $request->nama,

       'jabatan'=> $request->jabatan,

       'status_pegawai'=> $request->status_pegawai,

       'status_ktp_pegawai'=> $request->status_ktp_pegawai,

       'gaji_pokok'=> $request->gaji_pokok,

       'gaji_kontrak'=> $request->gaji_kontrak,

       'total_gaji'=> $request->gaji_pokok+$request->tunjangan+$request->tunjanganktp,

       ]);
    }elseif($request->status_pegawai==2)
    {
      Penggajian::create([

        'kode'=> $id,
 
        'nama'=> $request->nama,
 
        'jabatan'=> $request->jabatan,
 
        'status_pegawai'=> $request->status_pegawai,
 
        'status_ktp_pegawai'=> $request->status_ktp_pegawai,
 
        'gaji_pokok'=> $request->gaji_pokok,
 
        'gaji_kontrak'=> $request->gaji_kontrak,
 
        'total_gaji'=> $request->gaji_kontrak*$request->gaji_pokok/100+$request->tunjangan+$request->tunjanganktp,
 
        ]);
    }else{
      Penggajian::create([

        'kode'=> $id,
 
        'nama'=> $request->nama,
 
        'jabatan'=> $request->jabatan,
 
        'status_pegawai'=> $request->status_pegawai,
 
        'status_ktp_pegawai'=> $request->status_ktp_pegawai,
 
        'gaji_pokok'=> $request->gaji_pokok,
 
        'gaji_kontrak'=> $request->gaji_kontrak,
 
        'total_gaji'=> $request->gaji_kontrak*$request->gaji_pokok/100+$request->tunjangan+$request->tunjanganktp,
 
        ]);
    }

     $pegawaiedit = Pegawai::find($id);

     $pegawaiedit->status_gaji = 1;

     $pegawaiedit->save();

     Flashy::info('Data Status KTP berhasil di update');

     return redirect()->route('penggajian');

   }

   

   public function editpenggajian($id)

   {

      $data['pegawai'] = Pegawai::find($id);

      $departemen = Departemen::pluck('departemen', 'id');

      

      $gaji = Penggajian::pluck('gaji_pokok', 'id');

      $jabatan = MasterJabatan::pluck('nama_jabatan', 'id');

      $jabatan1 = MasterJabatan::pluck('tunjangan_jabatan', 'id');

		  $status_ktp_pegawai = StatusKtpPegawai::pluck('keterangan', 'id');

		  $status_pegawai = StatusPegawai::pluck('keterangan', 'id');

      $pegawai = Pegawai::join('status_ktp_pegawai', 'status_ktp_pegawai.id', '=', 'pegawais.status_ktp_pegawai')

      ->join('departemen', 'departemen.id', '=', 'pegawais.departemen')

      ->join('masterjabatan', 'masterjabatan.id', '=', 'pegawais.jabatan')

      ->join('status_pegawai', 'status_pegawai.id', '=', 'pegawais.status_pegawai')

      ->join('kategoripegawais', 'kategoripegawais.id', '=', 'pegawais.kategori_pegawai')

      ->join('penggajian', 'penggajian.kode', '=', 'pegawais.id')

    

    ->where('pegawais.id','=',$id)

    //->join('folios', 'folios.pasien_id', '=', 'pasiens.id')

    //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])

    //->where('registrasis.pulang','!=','1')

    //->whereIn('folios.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

    ->select('pegawais.nama','status_pegawai.keterangan as status_peg','pegawais.id', 'departemen.departemen', 'masterjabatan.nama_jabatan', 'masterjabatan.tunjangan_jabatan', 'kategoripegawais.kategori','status_ktp_pegawai.tunjangan as tunjangan_ktp')

    ->get();

      return view('/direksi/penggajian.edit',$data,compact('gaji','pegawai','jabatan','jabatan1','status_ktp_pegawai','status_pegawai','departemen'))->with('no', 1);

   }



   public function updatepenggajian(Request $request, $id)

   {

    $data['pegawai'] = Pegawai::find($id);

    

    $pegawai = Pegawai::join('status_ktp_pegawai', 'status_ktp_pegawai.id', '=', 'pegawais.status_ktp_pegawai')

    ->join('departemen', 'departemen.id', '=', 'pegawais.departemen')

    ->join('masterjabatan', 'masterjabatan.id', '=', 'pegawais.jabatan')

    ->join('status_pegawai', 'status_pegawai.id', '=', 'pegawais.status_pegawai')

    ->join('kategoripegawais', 'kategoripegawais.id', '=', 'pegawais.kategori_pegawai')

    ->join('penggajian', 'penggajian.kode', '=', 'pegawais.id')

    

    ->where('pegawais.id','=',$id)

    //->join('folios', 'folios.pasien_id', '=', 'pasiens.id')

    //->whereIn('registrasis.tipe_layanan', !empty($request['tipelayanan']) ? [$request['tipelayanan']] : ['1', '2'])

    //->where('registrasis.pulang','!=','1')

    //->whereIn('folios.user_id', !empty($request['petugas']) ? [$request['petugas']] : $iduser)

    ->select('status_ktp_pegawai.*','pegawais.nama','status_pegawai.keterangan as status_peg','pegawais.id', 'departemen.departemen', 'masterjabatan.nama_jabatan', 'masterjabatan.tunjangan_jabatan', 'kategoripegawais.kategori','status_ktp_pegawai.tunjangan as tunjangan_ktp')

    ->get();

    $jabatan = MasterJabatan::pluck('tunjangan_jabatan')->where('id','=',$request->jabatan);

    $status_ktp_pegawai = StatusKtpPegawai::pluck('keterangan')->where('id','=',$request->status_ktp_pegawai);

    $status_pegawai = StatusPegawai::pluck('keterangan', 'id');

     

     $gajian = Penggajian::find($id);

     $gajian->gaji_pokok = $request->gaji_pokok;

     $gajian->gaji_kontrak = $request->gaji_kontrak;

     $gajian->total_gaji =  $request->gaji_pokok+$request->gaji_kontrak*$request->gaji_pokok/100+$request->tunjangan+$request->tunjanganktp;

     $gajian->update();

     $pegawaiedit = Pegawai::find($id);

     $pegawaiedit->status_gaji = 1;

     $pegawaiedit->save();

     Flashy::info('Data Status KTP berhasil di update');

     return redirect()->route('penggajian');

   }

   

   

    /* public function tutup_kasir_byRequest(Request $request)

    {

      request()->validate(['tga'=>'required', 'tgb'=>'required']);

      $user = User::join('role_user', 'users.id', '=', 'role_user.user_id')

                  ->join('roles', 'roles.id', '=', 'role_user.role_id')

                  ->select('users.id as user_id', 'users.name as nama', 'users.email', 'roles.name as Role')

                  ->where('roles.name', '=', 'kasir')

                  ->get();

      $iduser = [];

      foreach ($user as $key => $d) {

        $iduser[] = ''.$d->user_id.'';

      }*/

}

