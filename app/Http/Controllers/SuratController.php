<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;
use Flashy;
use Validator;
use Modules\Role\Entities\Role;
use Modules\Config\Entities\Config;
use Activity;
use Excel;
use Auth;
use PDF;
use DB;
use Yajra\DataTables\DataTables;
use App\Inventarisglobal;
use App\Inventarisdetail;
use App\Historyinventaris;
use App\Depoinv;
use App\Depoinvdetail;
use App\Depo;
use App\Depopo;
use App\Depopodetail;
use App\Depomasterobat;
use App\Masterruangan;
use App\Masterjenisbarang;
use App\Masterlokasi;
use App\Masterprodusen;

class SuratController extends Controller
{
    public function surat_paksa_pulang($id)
    {
        $data['config'] = Config::find(1);
        $no = 1;
        $data['reg'] = Registrasi::find($id);
        $data['pasien'] = Pasien::where('id',$data['reg']->pasien_id)->first();
        $pdf = PDF::loadView('/surat.pernyataan_pulang_paksa', $data,compact('no'),[
            'format' => 'legal-P']);
        return $pdf->stream();
    }

    public function pdf_pengajuan_inv_rusak()
    {
        $data['config'] = Config::find(1);
        $data['baranginv'] = db::select(db::raw('SELECT inventaris_global.nama_barang,invetaris_detail.kondisi_barang,histori_pengajuan_inv_rusak.no_inv
        FROM histori_pengajuan_inv_rusak
        JOIN invetaris_detail ON invetaris_detail.no_inv = histori_pengajuan_inv_rusak.no_inv
        JOIN inventaris_global ON inventaris_global.kode_barang = invetaris_detail.kode_barang
        JOIN roles ON roles.id = invetaris_detail.role
        JOIN master_ruangan ON master_ruangan.id = invetaris_detail.ruangan
        WHERE histori_pengajuan_inv_rusak.alasan = "rusak"
        '));
        $no = 1;
        $pdf = PDF::loadView('/surat.surat_internal_pengajuan_inv_rusak', $data,compact('no'),[
            'format' => 'legal-P']);
        return $pdf->stream();
    }

    public function pdf_pengajuan_inv_hilang()
    {
        $data['config'] = Config::find(1);
        $data['baranginv'] = db::select(db::raw('SELECT inventaris_global.nama_barang,invetaris_detail.kondisi_barang,histori_pengajuan_inv_rusak.no_inv
        FROM histori_pengajuan_inv_rusak
        JOIN invetaris_detail ON invetaris_detail.no_inv = histori_pengajuan_inv_rusak.no_inv
        JOIN inventaris_global ON inventaris_global.kode_barang = invetaris_detail.kode_barang
        JOIN roles ON roles.id = invetaris_detail.role
        JOIN master_ruangan ON master_ruangan.id = invetaris_detail.ruangan
        WHERE histori_pengajuan_inv_rusak.alasan = "hilang"
        '));
        $no = 1;
        $pdf = PDF::loadView('/surat.surat_internal_pengajuan_inv_hilang', $data,compact('no'),[
            'format' => 'legal-P']);
        return $pdf->stream();
    }

    public function pdf_visum($id)
    {
        $data['config'] = Config::find(1);
        $data['reg'] = Registrasi::find($id);
        $data['cek_visum'] = db::table('data_visum')->where('registrasi_id',$id)->first();
        $no = 1;
        $pdf = PDF::loadView('/surat.surat_visum', $data,compact('no'),[
            'format' => 'legal-P']);
        return $pdf->stream();
    }
    
    public function create_visum(Request $request)
    {
       $cek_visum = db::table('data_visum')->where('registrasi_id',$request['registrasi_id'])->count();
       $reg = Registrasi::find($request['registrasi_id']);
       if($cek_visum<1)
       {
        db::table('data_visum')->insert([
            'registrasi_id'=>$request['registrasi_id'],
            'instansi_pemohon'=>$request['instansi_pemohon'],
            'pemohon'=>$request['pemohon'],
            'jabatan_pemohon'=>$request['jabatan_pemohon'],
            'hasil_pemeriksaan'=>$reg->anamnesis,
            'kesimpulan'=>$request['kesimpulan'],
            'nomor_permohonan'=>$request['nomor_permohonan'],
            'dokter_id'=>$reg->dokter_id
        ]);
       }else
       {
        db::table('data_visum')->where('registrasi_id',$request['registrasi_id'])->update([
            'instansi_pemohon'=>$request['instansi_pemohon'],
            'pemohon'=>$request['pemohon'],
            'jabatan_pemohon'=>$request['jabatan_pemohon'],
            'hasil_pemeriksaan'=>$reg->anamnesis,
            'kesimpulan'=>$request['kesimpulan'],
            'nomor_permohonan'=>$request['nomor_permohonan'],
            'dokter_id'=>$reg->dokter_id
        ]);
       }
       $data_visum = db::table('data_visum')->where('registrasi_id',$request['registrasi_id'])->first();
       return response()->json(['sukses'=>true,'instansi_pemohon'=>$data_visum->instansi_pemohon,
       'pemohon'=>$data_visum->pemohon,'jabatan_pemohon'=>$data_visum->jabatan_pemohon,'hasil_pemeriksaan'=>$data_visum->hasil_pemeriksaan,
       'kesimpulan'=>$data_visum->kesimpulan,'nomor_permohonan'=>$data_visum->nomor_permohonan]);
    }

    public function surat_ket_sakit($id)
    {
        $data['config'] = Config::find(1);
        $data['reg'] = Registrasi::find($id);
        $no = 1;
        $pdf = PDF::loadView('/surat.surat_ket_sakit', $data,compact('no'),[
            'format' => 'A5-L']);
        return $pdf->stream();
    }

    public function surat_persetujuan_tindakan_medis($id)
    {
        $data['config'] = Config::find(1);
        $data['reg'] = Registrasi::find($id);
        $no = 1;
        $pdf = PDF::loadView('/surat.surat_persetujuan_tindakan_medis', $data,compact('no'),[
            'format' => 'legal-P']);
        return $pdf->stream();
    }

    public function surat_ket_sehat($id)
    {
        $data['config'] = Config::find(1);
        $data['reg'] = Registrasi::find($id);
        $data['ket_sehat'] = db::table('data_surat_ket_sehat')->where('registrasi_id',$id)->first();
        $no = 1;
        $pdf = PDF::loadView('/surat.surat_ket_sehat', $data,compact('no'),[
            'format' => 'legal-P']);
        return $pdf->stream();
    }

    public function create_ket_sehat(Request $request)
    {
       $cek = db::table('data_surat_ket_sehat')->where('registrasi_id',$request['registrasi_id'])->count();
       $reg = Registrasi::find($request['registrasi_id']);
       if($cek<1)
       {
        db::table('data_surat_ket_sehat')->insert([
            'registrasi_id'=>$request['registrasi_id'],
            'keperluan'=>$request['keperluan'],
            'berat_badan'=>$request['berat_badan'],
            'tinggi_badan'=>$request['tinggi_badan'],
            'tekanan_darah'=>$request['tekanan_darah'],
            'golongan_darah'=>$request['golongan_darah'],
            'riwayat_penyakit'=>$request['riwayat_penyakit'],
        ]);
       }else
       {
        db::table('data_surat_ket_sehat')->where('registrasi_id',$request['registrasi_id'])->update([
            'keperluan'=>$request['keperluan'],
            'berat_badan'=>$request['berat_badan'],
            'tinggi_badan'=>$request['tinggi_badan'],
            'tekanan_darah'=>$request['tekanan_darah'],
            'golongan_darah'=>$request['golongan_darah'],
            'riwayat_penyakit'=>$request['riwayat_penyakit'],
        ]);
       }
       $data = db::table('data_surat_ket_sehat')->where('registrasi_id',$request['registrasi_id'])->first();
       return response()->json(['sukses'=>true,'keperluan'=>$data->keperluan,
       'berat_badan'=>$data->berat_badan,'tinggi_badan'=>$data->tinggi_badan,'tekanan_darah'=>$data->tekanan_darah,
       'golongan_darah'=>$data->golongan_darah,'riwayat_penyakit'=>$data->riwayat_penyakit]);
    }

    public function create_persetujuan_tindakan_medis(Request $request)
    {
       $cek = db::table('data_surat_persetujuan_tindakan')->where('registrasi_id',$request['registrasi_id'])->count();
       $reg = Registrasi::where('id',$request['registrasi_id'])->first();
       if($cek<1)
       {
        db::table('data_surat_persetujuan_tindakan')->insert([
            'registrasi_id'=>$request['registrasi_id'],
            'penanggung_jawab'=>$request['penanggung_jawab'],
            'hubungan_penanggung_jawab'=>$request['hubungan_penanggung_jawab'],
            'umur_penanggung_jawab'=>date('Y-m-d',strtotime($request['umur_penanggung_jawab'])),
            'kelamin_penanggung_jawab'=>$request['kelamin_penanggung_jawab'],
            'alamat_penanggung_jawab'=>$request['alamat_penanggung_jawab'],
            'no_bukti_diri'=>$request['no_bukti_diri'],
            'jenis_tanda_pengenal'=>$request['jenis_tanda_pengenal'],
            'telp_penanggung_jawab'=>$request['telp_penanggung_jawab'],
        ]);
        db::table('pasiens')->where('id',$request['pasien_id'])->update([
            'penanggung_jawab'=>$request['penanggung_jawab'],
            'hubungan_penanggung_jawab'=>$request['hubungan_penanggung_jawab'],
            'umur_penanggung_jawab'=>date('Y-m-d',strtotime($request['umur_penanggung_jawab'])),
            'kelamin_penanggung_jawab'=>$request['kelamin_penanggung_jawab'],
            'alamat_penanggung_jawab'=>$request['alamat_penanggung_jawab'],
            'no_bukti_diri'=>$request['no_bukti_diri'],
            'jenis_tanda_pengenal'=>$request['jenis_tanda_pengenal'],
            'telp_penanggung_jawab'=>$request['telp_penanggung_jawab'],
        ]);
       }else
       {
        db::table('data_surat_persetujuan_tindakan')->where('registrasi_id',$request['registrasi_id'])->update([
            'penanggung_jawab'=>$request['penanggung_jawab'],
            'hubungan_penanggung_jawab'=>$request['hubungan_penanggung_jawab'],
            'umur_penanggung_jawab'=>date('Y-m-d',strtotime($request['umur_penanggung_jawab'])),
            'kelamin_penanggung_jawab'=>$request['kelamin_penanggung_jawab'],
            'alamat_penanggung_jawab'=>$request['alamat_penanggung_jawab'],
            'no_bukti_diri'=>$request['no_bukti_diri'],
            'jenis_tanda_pengenal'=>$request['jenis_tanda_pengenal'],
            'telp_penanggung_jawab'=>$request['telp_penanggung_jawab'],
        ]);
        db::table('pasiens')->where('id',$request['pasien_id'])->update([
            'penanggung_jawab'=>$request['penanggung_jawab'],
            'hubungan_penanggung_jawab'=>$request['hubungan_penanggung_jawab'],
            'umur_penanggung_jawab'=>date('Y-m-d',strtotime($request['umur_penanggung_jawab'])),
            'kelamin_penanggung_jawab'=>$request['kelamin_penanggung_jawab'],
            'alamat_penanggung_jawab'=>$request['alamat_penanggung_jawab'],
            'no_bukti_diri'=>$request['no_bukti_diri'],
            'jenis_tanda_pengenal'=>$request['jenis_tanda_pengenal'],
            'telp_penanggung_jawab'=>$request['telp_penanggung_jawab'],
        ]);
       }
       $data = db::table('data_surat_persetujuan_tindakan')->where('registrasi_id',$request['registrasi_id'])->first();
       return response()->json(['sukses'=>true,
       'penanggung_jawab'=>$data->penanggung_jawab,'hubungan_penanggung_jawab'=>$data->hubungan_penanggung_jawab,'umur_penanggung_jawab'=>date('d-m-Y',strtotime($data->umur_penanggung_jawab)),'kelamin_penanggung_jawab'=>$data->kelamin_penanggung_jawab,
       'alamat_penanggung_jawab'=>$data->alamat_penanggung_jawab,'no_bukti_diri'=>$data->no_bukti_diri,'jenis_tanda_pengenal'=>$data->jenis_tanda_pengenal,'telp_penanggung_jawab'=>$data->telp_penanggung_jawab,]);
    }

    public function surat_resep_kosong()
    {
        $data['config'] = Config::find(1);
       
        $no = 1;
        $pdf = PDF::loadView('/surat.surat_resep', $data,compact('no'),[
            'format' => 'A5-P']);
        return $pdf->stream();
    }

    public function surat_rujukan_kosong()
    {
        $data['config'] = Config::find(1);
       
        $no = 1;
        $pdf = PDF::loadView('/surat.surat_rujukan', $data,compact('no'),[
            'format' => 'A4-P']);
        return $pdf->stream();
    }

    public function surat_rujukan($id)
    {
        $data['config'] = Config::find(1);
       
        $no = 1;
        $pdf = PDF::loadView('/surat.surat_rujukan_request', $data,compact('no'),[
            'format' => 'A4-P']);
        return $pdf->stream();
    }

    public function create_surat_rujukan(Request $request)
    {
        $cek = Registrasi::find($requset['registrasi_id']);
        if($cek->keluhan==null)
        {
            $note = 'Mohon isi terlebih dahulu data keluhan pasien';
            return response()->json(['sukses'=>False,'note'=>$note]);
        }elseif($cek->diagnosa_awal==null && $cek->diagnosa_akhir==null)
        {
            $note = 'Mohon isi terlebih dahulu data keluhan pasien';
            return response()->json(['sukses'=>False,'note'=>$note]);
        }else{
            $id_pemakaian_obat = db::table('pemakaians')->where('registrasi_id',$requset['registrasi_id'])->first();
            $cek_rujukan = db::table('histori_rujukan')->where('registrasi_id',$requset['registrasi_id'])->count();
            if($cek->diagnosa_awal==null)
            {
                $diagnosa = $cek->diagnosa_akhir;
            }else{
                $diagnosa = $cek->diagnosa_awal;
            }
            if($cek_rujukan<1)
            {
                db::table('histori_rujukan')->insert([
                    'registrasi_id'=>$requset['registrasi_id'],
                    'ppk_dirujuk'=>$requset['ppkDirujuk1'],
                    'penanggung_jawab_ppk'=>$request['penanggung_jawab_ppk'],
                    'kasus_rujuk'=>$request['kasus_rujuk'],
                    'terapi_pasien'=>$request['terapi'],
                    'diagnosa'=>$diagnosa,
                    'obat_pasien'=>$id_pemakaian_obat->no_resep,
                ]);
            }else{
                db::table('histori_rujukan')->where('registrasi_id',$requset['registrasi_id'])->update([
                    'ppk_dirujuk'=>$requset['ppkDirujuk1'],
                    'penanggung_jawab_ppk'=>$request['penanggung_jawab_ppk'],
                    'kasus_rujuk'=>$request['kasus_rujuk'],
                    'terapi_pasien'=>$request['terapi'],
                    'diagnosa'=>$diagnosa,
                    'obat_pasien'=>$id_pemakaian_obat->no_resep,
                ]);
            }
            return response()->json(['sukses'=>True]);
        }
    }
}
