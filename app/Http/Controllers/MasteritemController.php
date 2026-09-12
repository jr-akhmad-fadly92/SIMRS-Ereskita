<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jenisracikan;
use App\Satuan;
use App\Kategoriobat;
use App\Golonganobat;
use App\Obatprogram;
use App\Masterobatall;
use App\Masternonmedis;
use Flashy;
use DB;
use Auth;
use Validator;
use Activity;

class MasteritemController extends Controller
{
   
    //Master Jenis Racikan
    
    public function jenisracikan()
    {   
        $data['jenis_racikan'] = Jenisracikan::all();
        return view('/logistik/master_item/jenisracikan.index',$data)->with('no',1);
    }
    public function createjenisracikan()
    {   
        return view('/logistik/master_item/jenisracikan.create');
    }

    public function storejenisracikan(Request $request)
    {
        $data = request()->validate(['jenis_racikan'=>'required']);
        Jenisracikan::create($data);
        Flashy::success('Jenis Racikan Telah Ditambahkan');
        
        return redirect('/master/jenis_racikan');
    }

    public function editjenisracikan($id)
    {
        $data['jenis_racikan'] = Jenisracikan::find($id);
        return view('/logistik/master_item/jenisracikan.edit',$data);
    }

    public function updatejenisracikan(Request $request, $id)
    {
        $data = request()->validate(['jenis_racikan'=>'required']);
        Jenisracikan::find($id)->update($data);
        Flashy::info('Data Jenis Racikan berhasil di update');
        return redirect('/master/jenis_racikan');
    }
    
    public function deletejenisracikan($id)
    {
        $data = Jenisracikan::find($id);
        $data->delete();
        return redirect('/master/jenis_racikan');
    }

    //Master satuan barang
    
    public function satuan()
    {   
        $data['satuan'] = Satuan::all();
        return view('/logistik/master_item/satuan.index',$data)->with('no',1);
    }
    public function createsatuan()
    {   
        return view('/logistik/master_item/satuan.create');
    }

    public function storesatuan(Request $request)
    {
        $data = request()->validate(['kode_satuan'=>'required','nama_satuan'=>'required']);
        satuan::create($data);
        Flashy::success('Satuan Barang Telah Ditambahkan');
        
        return redirect('/master/satuan');
    }

    public function editsatuan($id)
    {
        $data['satuan'] = satuan::find($id);
        return view('/logistik/master_item/satuan.edit',$data);
    }

    public function updatesatuan(Request $request, $id)
    {
        $data = request()->validate(['kode_satuan'=>'required','nama_satuan'=>'required']);
        satuan::find($id)->update($data);
        Flashy::info('Data Satuan Barang berhasil di update');
        return redirect('/master/satuan');
    }

    public function deletesatuan($id)
    {
        $data = satuan::find($id);
        $data->delete();
        return redirect('/master/satuan');
    }

    //Master Kategori Obat
    
    public function kategoriobat()
    {   
        $data['kategoriobat'] = Kategoriobat::all();
        return view('/logistik/master_item/kategoriobat.index',$data)->with('no',1);
    }
    public function createkategoriobat()
    {   
        return view('/logistik/master_item/kategoriobat.create');
    }

    public function storekategoriobat(Request $request)
    {
        $data = request()->validate(['nama'=>'required']);
        Kategoriobat::create($data);
        Flashy::success('kategori obat Telah Ditambahkan');
        
        return redirect('/master/kategori_obat');
    }

    public function editkategoriobat($id)
    {
        $data['kategoriobat'] = Kategoriobat::find($id);
        return view('/logistik/master_item/kategoriobat.edit',$data);
    }

    public function updatekategoriobat(Request $request, $id)
    {
        $data = request()->validate(['nama'=>'required']);
        Kategoriobat::find($id)->update($data);
        Flashy::info('Data kategori obat berhasil di update');
        return redirect('/master/kategori_obat');
    }

    public function deletekategoriobat($id)
    {
        $data = Kategoriobat::find($id);
        $data->delete();
        return redirect('/master/kategori_obat');
    }

    //Master Golongan Obat
    
    public function golonganobat()
    {   
        $data['golonganobat'] = Golonganobat::all();
        return view('/logistik/master_item/golonganobat.index',$data)->with('no',1);
    }
    public function creategolonganobat()
    {   
        return view('/logistik/master_item/golonganobat.create');
    }

    public function storegolonganobat(Request $request)
    {
        $data = request()->validate(['nama_golongan'=>'required','keterangan'=>'required']);
        Golonganobat::create($data);
        Flashy::success('Golongan Obat Telah Ditambahkan');
        
        return redirect('/master/golongan_obat');
    }

    public function editgolonganobat($id)
    {
        $data['golonganobat'] = Golonganobat::find($id);
        return view('/logistik/master_item/golonganobat.edit',$data);
    }

    public function updategolonganobat(Request $request, $id)
    {
        $data = request()->validate(['nama_golongan'=>'required','keterangan'=>'required']);
        Golonganobat::find($id)->update($data);
        Flashy::info('Data Golongan Obat berhasil di update');
        return redirect('/master/golongan_obat');
    }

    public function deletegolonganobat($id)
    {
        $data = Golonganobat::find($id);
        $data->delete();
        return redirect('/master/golongan_obat');
    }

    //Master Obat Program
    
    public function obatprogram()
    {   
        $data['Obatprogram'] = Obatprogram::all();
        return view('/logistik/master_item/obatprogram.index',$data)->with('no',1);
    }
    public function createobatprogram()
    {   
        return view('/logistik/master_item/obatprogram.create');
    }

    public function storeobatprogram(Request $request)
    {
        $data = request()->validate(['nama_program'=>'required','keterangan'=>'required']);
        Obatprogram::create($data);
        Flashy::success('Obat Program Telah Ditambahkan');
        
        return redirect('/master/obat_program');
    }

    public function editobatprogram($id)
    {
        $data['Obatprogram'] = Obatprogram::find($id);
        return view('/logistik/master_item/obatprogram.edit',$data);
    }

    public function updateobatprogram(Request $request, $id)
    {
        $data = request()->validate(['nama_program'=>'required','keterangan'=>'required']);
        Obatprogram::find($id)->update($data);
        Flashy::info('Data Obat Program berhasil di update');
        return redirect('/master/obat_program');
    }

    public function deleteobatprogram($id)
    {
        $data = Obatprogram::find($id);
        $data->delete();
        return redirect('/master/obat_program');
    }

    //Master Obat All
    
    public function obatall()
    {   
        $data['Obat_all'] = Masterobatall::all();
        return view('/logistik/master_item/obatall.index',$data)->with('no',1);
    }
    public function createobatall()
    {   
        return view('/logistik/master_item/obatall.create');
    }

    public function storeobatall(Request $request)
    {
        $data = request()->validate([
            'nama_obat'=>'required',        'id_obat'=>'required',
            'no_batch'=>'required',         'nomor_registrasi'=>'required',
            'barcode'=>'required',          'kode_binfar'=>'required',
            'satuan'=>'required',           'satuan_besar'=>'required',
            'satuan_besar_unit'=>'required','satuanjual'=>'required',
            'satuan_jual_unit'=>'required', 'satuanbeli'=>'required',
           
            'gol_obat'=>'required',         'komposisi'=>'required',
            'indikasi'=>'required',         'dosis'=>'required',
            'supplier'=>'required',         
            'stokmax'=>'required',          'stokmin'=>'required',
            'katagori_obat'=>'required',    'jenis_obat'=>'required',
            'hargajual'=>'required',
            'hargajual_jkn'=>'required',    'hargabeli'=>'required',
            'status'=>'required',           'expired_date'=>'required',
            'jenis'=>'required',            'aktif'=>'required',
            ]);
        $cek =Masterobatall::where('id_obat',$request->id_obat)->count();
        if($cek==0)
        {    
        Masterobatall::create($data);
        Flashy::success('Master Obat Telah Ditambahkan');
        
        return redirect('/master-obat-all');
        }else{    
            Flashy::info('Master Obat sudah ada');
            
            return view('/logistik/master_item/obatall.create');
        }
    }

    public function editobatall($id)
    {
        $data['Obat_all'] = Masterobatall::where('id_obat',$id)->first();
        return view('/logistik/master_item/obatall.edit',$data);
    }

    public function updateobatall(Request $request, $id)
    {
        $data = request()->validate([
            'nama_obat'=>'required',
            'no_batch'=>'required',         'nomor_registrasi'=>'required',
            'barcode'=>'required',          'kode_binfar'=>'required',
            'satuan'=>'required',           'satuan_besar'=>'required',
            'satuan_besar_unit'=>'required','satuanjual'=>'required',
            'satuan_jual_unit'=>'required', 'satuanbeli'=>'required',
           
            'gol_obat'=>'required',         'komposisi'=>'required',
            'indikasi'=>'required',         'dosis'=>'required',
            'supplier'=>'required',         
            'stokmax'=>'required',          'stokmin'=>'required',
            'katagori_obat'=>'required',    'jenis_obat'=>'required',
            'hargajual'=>'required',
            'hargajual_jkn'=>'required',    'hargabeli'=>'required',
            'status'=>'required',           'expired_date'=>'required',
            'jenis'=>'required',            'aktif'=>'required',
            ]);
        Masterobatall::where('id_obat',$id)->update($data);
        Flashy::info('Data Master Obat berhasil di update');
        return redirect('/master-obat-all');
    }

    public function deleteobatall($id)
    {
        $data = Masterobatall::where('id_obat',$id);
        $data->delete();
        return redirect('/master-obat-all');
    }
    //Master Non Medis
    
    public function nonmedis()
    {   
        $data['non_medis'] = Masternonmedis::join('master_jenis_barang','master_jenis_barang.id','=','master_nonmedis.jenis')
                                             ->get();
        return view('/logistik/master_item/nonmedis.index',$data)->with('no',1);
    }
    public function createnonmedis()
    {   
        return view('/logistik/master_item/nonmedis.create');
    }

    public function storenonmedis(Request $request)
    {
        $data = request()->validate([
            'kode_barang'=>'required',          'nama_barang'=>'required',
            'satuan'=>'required',               'jenis'=>'required',
            'stok'=>'required',                 'harga'=>'required',
            
            ]);
        Masternonmedis::create($data);
        Flashy::success('Master Non Medis Telah Ditambahkan');
        
        return redirect('/master-nonmedis');
    }

    public function editnonmedis($id)
    {
        $data['non_medis'] = Masternonmedis::where('kode_barang',$id)->first();
        return view('/logistik/master_item/nonmedis.edit',$data);
    }

    public function updatenonmedis(Request $request, $id)
    {
        $data = request()->validate([
            'kode_barang'=>'required',          'nama_barang'=>'required',
            'satuan'=>'required',               'jenis'=>'required',
            'stok'=>'required',                 'harga'=>'required',
            
            ]);
        Masternonmedis::where('kode_barang',$id)->update($data);
        Flashy::info('Data Master Non Medis berhasil di update');
        return redirect('/master-nonmedis');
    }

    public function deletenonmedis($id)
    {
        $data = Masternonmedis::where('kode_barang',$id);
        $data->delete();
        return redirect('/master-nonmedis');
    }
}
