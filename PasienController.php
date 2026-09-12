<?php



namespace Modules\Pasien\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Http\Response;

use Illuminate\Routing\Controller;

use Modules\Pasien\Entities\Province;

use Modules\Pasien\Entities\Regency;

use Modules\Pasien\Entities\District;

use Modules\Pasien\Entities\Agama;

use Modules\Pasien\Entities\Pasien;

use Modules\Pasien\Entities\Village;

use App\Penjualan;

use App\Penjualanbebas;

use App\Masterobat;

use Modules\Pasien\Http\Requests\SavePasienRequest;

use Modules\Pekerjaan\Entities\Pekerjaan;

use Modules\Asuransi\Entities\Asuransi;

use Modules\Pendidikan\Entities\Pendidikan;

use Modules\Registrasi\Entities\Registrasi;

use Yajra\DataTables\DataTables;

use Auth;

use DB;



class PasienController extends Controller

{

    public function index()

    {

        return view('pasien::datatable');

    }



    public function getData()

    {

      $pasien = Pasien::select([

        'id',

        'no_rm',

        'nama',

        'kelamin',

        'tgllahir',

        'notlp',

        'alamat'

      ])->orderBy('id', 'asc');



      return DataTables::of($pasien)

      ->addColumn('edit', function ($pasien) {

          return '<a href="'.route('pasien.edit', $pasien->id).'" class="btn btn-primary btn-flat"><i class="fa fa-edit"></i></a>'.

                 '<button type="button" class="btn btn-primary btn-flat" data-idpasien="'.$pasien->id.'" id=pasienshow><i class="fa fa-search"></i></button>'.

                 '<a href="'.url('/frontoffice/histori-pasien/'. $pasien->id).'" class="btn btn-success  btn-flat"><i class="fa fa-file-pdf-o"></i></a>';

      })

      ->editColumn('tgllahir', function ($pasien) {

          return date_format(date_create($pasien->tgllahir), "d-M-Y");

      })

      ->rawColumns(['edit'])

      ->make(true);

    }



    public function search(Request $req)

    {

      request()->validate(['keyword'=>'required']);

      $keyword = $req['keyword'];

      $data['pasien'] = Pasien::where('nama', 'LIKE', '%'.$keyword.'%')

                      ->orWhere('no_rm', 'LIKE', '%'.$keyword.'%')

                      ->orWhere('alamat', 'LIKE', '%'.$keyword.'%')

                      ->get();

      $data['no'] = 1;

      return view('pasien::search', $data);

    }



    public function create()

    {

        $data['provinsi']   = Province::pluck('name','id');

        $data['pekerjaan']  = Pekerjaan::pluck('nama','id');

        $data['agama']      = Agama::pluck('agama', 'id');

        $data['asuransi'] = Asuransi::pluck('nama','id');

        $data['pendidikan'] = Pendidikan::pluck('pendidikan','id');

        return view('pasien::create', $data);

    }



    public function store(SavePasienRequest $request)

    {

      $no_rm = Pasien::where('no_rm', 'LIKE','00%')->count();

      $data = $request->all();

      $data['no_rm'] = sprintf("%08s", ($no_rm + 1));

      $data['foto'] = '';

      $data['kode'] = '';

      $data['negara'] = 'Indonesia';

      $data['nama_kk'] = '';

      $date['no_kk'] = '';

      $data['no_identitas'] = '';

      $data['no_jaminan'] = '';

      $data['tipe_paket'] = '';

      $data['no_sktm'] = '';

      $pasien = Pasien::create($data);

      return redirect('registrasi/create/'.$pasien->id);

    }



    public function show($id)

    {

        $p = Pasien::find($id);

        return view('pasien::show', compact('p'));

    }



    public function edit($id)

    {

        $data['provinsi']   = Province::pluck('name','id');

        $data['pekerjaan']  = Pekerjaan::pluck('nama','id');

        $data['agama']      = Agama::pluck('agama', 'id');

        $data['asuransi'] = Asuransi::pluck('nama','id');

        $data['pendidikan'] = Pendidikan::pluck('pendidikan','id');

        $data['pasien'] = Pasien::find($id);

        return view('pasien::edit', $data);

    }



    public function update(Request $request, $id)

    {

      request()->validate(['tgllahir'=>'date_format:d-m-Y', 'no_rm' => 'unique:pasiens,no_rm,'.$id]);

      $pasien = Pasien::find($id);

      $pasien->nama          = $request['nama'];

      $pasien->nik           = $request['nik'];

      $pasien->tmplahir      = $request['tmplahir'];

      $pasien->tgllahir      = valid_date($request['tgllahir']);

      $pasien->kelamin       = $request['kelamin'];

      $pasien->province_id   = $request['province_id'];

      $pasien->regency_id    = $request['regency_id'];

      $pasien->district_id   = $request['district_id'];

      $pasien->village_id    = $request['village_id'];

      $pasien->alamat        = $request['alamat'];

      $pasien->nohp          = $request['nohp'];

      $pasien->negara        = 'Indonesia';

      $pasien->pekerjaan_id  = $request['pekerjaan_id'];

      $pasien->agama_id      = $request['agama_id'];

      $pasien->pendidikan_id = $request['pendidikan_id'];

      $pasien->status_marital = $request['status_marital'];

      $pasien->user_create   = Auth::user()->name;

      $pasien->user_update   = '';

      $pasien->penanggung_jawab        = $request['penanggung_jawab'];

      $pasien->telp_penanggung_jawab          = $request['telp_penanggung_jawab'];

      $pasien->alamat_penanggung_jawab        = $request['alamat_penanggung_jawab'];

      $pasien->hubungan_penanggung_jawab  = $request['hubungan_penanggung_jawab'];

      

      $pasien->update();

      return redirect('pasien');

    }



    public function destroy()

    {

    }



    // =========== Demografi ===============================

    public function getKabupaten($province_id)

    {

      $kab = Regency::where('province_id',$province_id)->pluck('name','id');

      return json_encode($kab);

    }



    public function getKecamatan($regency_id)

    {

      $kec = District::where('regency_id',$regency_id)->pluck('name','id');

      return json_encode($kec);

    }



    public function getDesa($district_id)

    {

      $desa = Village::where('district_id',$district_id)->pluck('name','id');

      return json_encode($desa);

    }



    public function searchPasien($antrian_id, $no_loket)

    {

      session()->forget('antrian_id');

      session( ['antrian_id'=> $antrian_id]);

      $pasien = Pasien::select([

        'id',

        'tgllahir',

        'no_rm',

        //'no_rm_lama',

				'kelamin',

				'status_marital',

        'nama',

        'alamat',

        'ibu_kandung',

      ])->orderBy('id', 'asc');



      return DataTables::of($pasien)

      ->addColumn('jkn', function ($pasien) {

          return '<a href="/registrasi/create/'.$pasien->id.'" onclick="return confirm(\'Yakin didaftarkan ke JKN? \')" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';

      })

      ->addColumn('non-jkn', function ($pasien) {

          return '<a href="/registrasi/create_umum/'.$pasien->id.'" onclick="return confirm(\'Yakin didaftarkan ke Non JKN? \')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';

      })

      ->rawColumns(['jkn', 'non-jkn'])

      ->make(true);

    }



    public function searchPasienIGD($url='')

    {

			$kelamin = ['L','P'];

			if($url=='bayi'){

				$kelamin = ['P'];

			}

			$pasien = Pasien::select([

				'id',

				'no_rm',

				'nama',

				'tgllahir',

				'alamat',

				'ibu_kandung',

			])->whereIn('kelamin',$kelamin)->orderBy('id', 'asc');

			session(['urlx'=>$url]);

			return DataTables::of($pasien)

			->editColumn('tgllahir', function ($pasien) {

				return date_format(date_create($pasien->tgllahir),'d-m-Y');

			})

			->addColumn('jkn', function ($pasien) {

				if(session('urlx')=='bayi'){

					return '<a href="/registrasi/create/'.$pasien->id.'/bayi" onclick="return confirm(\'Yakin didaftarkan ke JKN? \')" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';

				}else{

					return '<a href="/registrasi/igd/jkn/'.$pasien->id.'" onclick="return confirm(\'Yakin didaftarkan ke JKN? \')" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';

				}

			})

			->addColumn('non-jkn', function ($pasien) {

				if(session('urlx')=='bayi'){

					return '<a href="/registrasi/create_umum/'.$pasien->id.'/bayi" onclick="return confirm(\'Yakin didaftarkan ke Non JKN? \')" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';

				}else{

					return '<a href="/registrasi/igd/umum/'.$pasien->id.'" onclick="return confirm(\'Yakin didaftarkan ke Non JKN? \')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';

				}

			})

			->rawColumns(['jkn', 'non-jkn'])

			->make(true);

    }



    //rekammedis pasien 

    public function indexrekammedispasien()

    {

        return view('pasien::datatablerekammedis');

    }



    public function getDataRekamMedis()

    {

      $pasien = Pasien::select([

        'id',

        'no_rm',

        'nama',

        'kelamin',

        'tgllahir',

        'alamat'

      ])->orderBy('id', 'asc');



      return DataTables::of($pasien)

      ->addColumn('edit', function ($pasien) {

          return '<a href="'.url('/frontoffice/histori-pasien/'. $pasien->id).'" class="btn btn-success  btn-flat"><i class="fa fa-file-pdf-o"></i></a>';

      })

      ->editColumn('tgllahir', function ($pasien) {

          return date_format(date_create($pasien->tgllahir), "d-M-Y");

      })

      ->rawColumns(['edit'])

      ->make(true);

    }



    public function searchRekamMedis(Request $req)

    {

      request()->validate(['keyword'=>'required']);

      $keyword = $req['keyword'];

      $data['pasien'] = Pasien::where('nama', 'LIKE', '%'.$keyword.'%')

                      ->orWhere('no_rm', 'LIKE', '%'.$keyword.'%')

                      ->orWhere('alamat', 'LIKE', '%'.$keyword.'%')

                      ->get();

      $data['no'] = 1;

      return view('pasien::search', $data);

    }

}

