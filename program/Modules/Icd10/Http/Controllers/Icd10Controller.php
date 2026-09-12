<?php

namespace Modules\Icd10\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Icd10\Entities\Icd10;
use App\PerawatanIcd10;
use Modules\Registrasi\Entities\Registrasi;
use MercurySeries\Flashy\Flashy;
use Yajra\DataTables\DataTables;
use DB;
use App\User;
use App\Role;
use Auth;

class Icd10Controller extends Controller
{
    public function index()
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
      {
          return view('icd10::datatable');
      }else{
          return redirect('/dashboard');
      }
        
    }

    public function getICD10()
    {
      $data = Icd10::all();
      return DataTables::of($data)
        ->addColumn('edit', function ($data) {
          return '<a href="'.route('icd10.edit',$data->id) .'" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>';
        })
        ->rawColumns(['edit'])
        ->make(true);
    }

    public function create()
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
      {
          return view('icd10::create');
      }else{
          return redirect('/dashboard');
      }
        
    }

    public function store(Request $request)
    {
      $data = request()->validate(['nomor'=>'required','nama'=>'required']);
      Icd10::create($data);
      Flashy::success('Data ICD10 baru berhasil di tambahkan');
      return redirect()->route('icd10');
    }

    public function show()
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
      {
          return view('icd10::show');
      }else{
          return redirect('/dashboard');
      }
        
    }

    public function edit($id)
    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
      {
          $icd10 = Icd10::find($id);
          return view('icd10::edit', compact('icd10'));
      }else{
          return redirect('/dashboard');
      }
        
    }

    public function update(Request $request, $id)
    {
      $data = request()->validate(['nomor'=>'required','nama'=>'required']);
      Icd10::find($id)->update($data);
      Flashy::info('Data ICD10 berhasil di update');
      return redirect()->route('icd10');
    }

    public function getDataIcd10($no='')
    {
      $data = Icd10::all();
      if($no == 1) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih1"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 2) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih2"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 3) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih3"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 4) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih4"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 5) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih5"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 6) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih6"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 7) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih7"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 8) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih8"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 9) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih9"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 10) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih10"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 11) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih11"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 12) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih12"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 13) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih13"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 14) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih14"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 15) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih15"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 16) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih16"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 17) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih17"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 18) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih18"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 19) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih19"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 20) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih20"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      }

    }

    public function getDataIcd10_list()
    {
      $data = Icd10::all();
      
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" data-nama="'.$data->nama.'" class="btn btn-sm btn-success btn-flat pilih_icd10"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
     }

     public function get_data_riwayat_icd10($id)
     {
      $data_awal = Registrasi::where('id',$id)->first();
      $data_riwayat = db::table('perawatan_icd10s')->whereNotIn('keterangan',['penyakit_turunan'])->where('pasien_id',$data_awal->pasien_id)
      ->select('icd10','id','created_at','registrasi_id')->get();
      return DataTables::of($data_riwayat)
      ->addColumn('nama_icd', function ($data) {
        $btn = db::table('icd10s')->where('nomor',$data->icd10)->first();
        return $btn->nama;
      })
      ->addColumn('aksi', function ($data) use ($id){
        if($data->registrasi_id==$id)
        {
          return ' <a href="#" data-id="'.$data->id.'" class="btn btn-sm btn-danger btn-flat hapushistoririwayatpenyakit"><i class="fa fa-close"></i></a> ';
        }else{
          return ' ';
        }
      })
      ->addColumn('tanggal', function ($data) {
        return date('d F Y',strtotime($data->created_at));
      })
      ->rawColumns(['aksi','nama_icd','tanggal'])      
      ->make(true);
     }

     public function update_data_riwayat_icd10(Request $request)
     {
      $data_awal  = Registrasi::where('id',$request['registrasi_id'])->first();
      $cek_data   = db::table('perawatan_icd10s')->where('pasien_id',$data_awal->pasien_id)->where('icd10',$request['nomor_icd10'])->count();
      if($data_awal->status_reg='I%')
      {
        $status = 'TI';
      }elseif($data_awal->status_reg='G%')
      {
        $status = 'TG';
      }else
      {
        $status = 'TA';
      }
    
      if($cek_data<1)
      {
        PerawatanIcd10::insert([
          'icd10'=>$request['nomor_icd10'],
          'registrasi_id'=>$request['registrasi_id'],
          'pasien_id'=>$data_awal->pasien_id,
          'carabayar_id'=>$data_awal->bayar,
          'jenis'=>$status,
          'keterangan'=>'riwayat_penyakit'
        ]);
        return response()->json(['sukses' => true]);
      }else
      {
        $info = 'data sudah pernah di masukan';
        return response()->json(['sukses' => false,'info'=>$info]);
      }

    }
    
    public function hapus_histori_riwayat_icd10($id)
    {   
        
        db::table('perawatan_icd10s')->where('id',$id)->delete();
        return response()->json(['sukses' => true]);
    }

    //Penyakit Turunan
    public function get_data_riwayat_turunan($id)
     {
      $data_awal = Registrasi::where('id',$id)->first();
      $data_riwayat = db::table('perawatan_icd10s')->where('keterangan','penyakit_turunan')->where('pasien_id',$data_awal->pasien_id)
      ->select('icd10','id','created_at','registrasi_id')->get();
      return DataTables::of($data_riwayat)
      ->addColumn('nama_icd', function ($data) {
        $btn = db::table('icd10s')->where('nomor',$data->icd10)->first();
        return $btn->nama;
      })
      ->addColumn('aksi', function ($data) use ($id){
        if($data->registrasi_id==$id)
        {
          return ' <a href="#" data-id="'.$data->id.'" class="btn btn-sm btn-danger btn-flat hapushistoririwayatpenyakitturunan"><i class="fa fa-close"></i></a> ';
        }else{
          return ' ';
        }
      })
      ->addColumn('tanggal', function ($data) {
        return date('d F Y',strtotime($data->created_at));
      })
      ->rawColumns(['aksi','nama_icd','tanggal'])      
      ->make(true);
     }

     public function update_data_riwayat_turunan(Request $request)
     {
      $data_awal  = Registrasi::where('id',$request['registrasi_id'])->first();
      $cek_data   = db::table('perawatan_icd10s')->where('pasien_id',$data_awal->pasien_id)->where('icd10',$request['nomor_icd10'])->count();
      if($data_awal->status_reg='I%')
      {
        $status = 'TI';
      }elseif($data_awal->status_reg='G%')
      {
        $status = 'TG';
      }else
      {
        $status = 'TA';
      }
    
      if($cek_data<1)
      {
        PerawatanIcd10::insert([
          'icd10'=>$request['nomor_icd10'],
          'registrasi_id'=>$request['registrasi_id'],
          'pasien_id'=>$data_awal->pasien_id,
          'carabayar_id'=>$data_awal->bayar,
          'jenis'=>$status,
          'keterangan'=>'penyakit_turunan'
        ]);
        return response()->json(['sukses' => true]);
      }else
      {
        $info = 'data sudah pernah di masukan';
        return response()->json(['sukses' => false,'info'=>$info]);
      }

    }
    
    public function hapus_histori_riwayat_turunan($id)
    {   
        
        db::table('perawatan_icd10s')->where('id',$id)->delete();
        return response()->json(['sukses' => true]);
    }

     //Penyakit Assesment
     // selain keterangan = riwayat_penyakit / penyakit_turunan
     public function get_data_assesment($id)
     {
      $data_awal = Registrasi::where('id',$id)->first();
      $data_riwayat = db::table('perawatan_icd10s')->whereNotIn('keterangan',['penyakit_turunan','riwayat_penyakit'])->where('registrasi_id',$id)
      ->select('icd10','detail_diagnosa','id','created_at','registrasi_id')->get();
      return DataTables::of($data_riwayat)
      ->addColumn('nama_icd', function ($data) {
        $btn = db::table('icd10s')->where('nomor',$data->icd10)->first();
        return $btn->nama;
      })
      ->addColumn('aksi', function ($data) use ($id){
        if($data->registrasi_id==$id)
        {
          return ' <a href="#" data-id="'.$data->id.'" class="btn btn-sm btn-danger btn-flat hapusassesment"><i class="fa fa-close"></i></a> ';
        }else{
          return ' ';
        }
      })
      ->addColumn('tanggal', function ($data) {
        return date('d F Y',strtotime($data->created_at));
      })
      ->rawColumns(['aksi','nama_icd','tanggal'])      
      ->make(true);
     }

     public function update_data_assesment(Request $request)
     {
      $data_awal  = Registrasi::where('id',$request['registrasi_id'])->first();
      $cek_data   = db::table('perawatan_icd10s')->where('registrasi_id',$request['registrasi_id'])->where('icd10',$request['nomor_icd10'])->where('keterangan','Diagnosa_sekarang')->count();
      $icd = db::table('icd10s')->where('nomor',$request['nomor_icd10'])->first();
      if($data_awal->status_reg='I%')
      {
        $status = 'TI';
      }elseif($data_awal->status_reg='G%')
      {
        $status = 'TG';
      }else
      {
        $status = 'TA';
      }
    
      if($cek_data<1)
      {
        PerawatanIcd10::insert([
          'icd10'=>$request['nomor_icd10'],
          'registrasi_id'=>$request['registrasi_id'],
          'detail_diagnosa'=>$request['detail_diagnosa'],
          'pasien_id'=>$data_awal->pasien_id,
          'carabayar_id'=>$data_awal->bayar,
          'jenis'=>$status,
          'keterangan'=>'Diagnosa_sekarang'
        ]);
        if($request['kategori_diagnosa']=='awal')
        {
          Registrasi::where('id',$request['registrasi_id'])->update([
            'diagnosa_awal'=>$icd->nama,
            ]);
          db::table('histori_pemeriksaan_fisik')->insert([
              'registrasi_id'=>$request['registrasi_id'],
              'diagnosa_awal'=>$request['nomor_icd10'],
          ]);
        }else{
          Registrasi::where('id',$request['registrasi_id'])->update([
            'diagnosa_akhir'=>$icd->nama,
            ]);
          db::table('histori_pemeriksaan_fisik')->insert([
              'registrasi_id'=>$request['registrasi_id'],
              'diagnosa_akhir'=>$request['nomor_icd10'],
          ]);
        }
        return response()->json(['sukses' => true]);
      }else
      {
        PerawatanIcd10::where('registrasi_id',$request['registrasi_id'])->where('icd10',$request['nomor_icd10'])->where('keterangan','Diagnosa_sekarang')
        ->update([
          'detail_diagnosa'=>$request['detail_diagnosa'],
          'pasien_id'=>$data_awal->pasien_id,
          'carabayar_id'=>$data_awal->bayar,
          'jenis'=>$status,
          'keterangan'=>'Diagnosa_sekarang'
        ]);
        if($request['kategori_diagnosa']=='awal')
        {
          Registrasi::where('id',$request['registrasi_id'])->update([
            'diagnosa_awal'=>$icd->nama,
            ]);
          db::table('histori_pemeriksaan_fisik')->insert([
              'registrasi_id'=>$request['registrasi_id'],
              'diagnosa_awal'=>$request['nomor_icd10'],
          ]);
        }else{
          Registrasi::where('id',$request['registrasi_id'])->update([
            'diagnosa_akhir'=>$icd->nama,
            ]);
          db::table('histori_pemeriksaan_fisik')->insert([
              'registrasi_id'=>$request['registrasi_id'],
              'diagnosa_akhir'=>$request['nomor_icd10'],
          ]);
        }
        $info = 'data sudah pernah di masukan';
        return response()->json(['sukses' => false,'info'=>$info]);
      }

    }
    
    public function hapus_assesment($id)
    {   
        
        db::table('perawatan_icd10s')->where('id',$id)->delete();
        return response()->json(['sukses' => true]);
    }
}
