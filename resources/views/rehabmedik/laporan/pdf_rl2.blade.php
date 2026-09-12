<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laporan RL 2 </title>
<style>
    @page {
      sheet-size: A4-L;
      size: auto;
      odd-header-name: html_MyHeader1;
      odd-footer-name: html_MyFooter1;
    }
   
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {background-color: #f2f2f2;}

</style>
</head>
<body>
    <htmlpageheader name="MyHeader1">
        <div style="text-align: right; border-bottom: 1px solid #000000; font-weight: bold; font-size: 10pt;">{{$config->nama}}</div>
    </htmlpageheader>
   <htmlpagefooter name="MyFooter1">
        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
            <tr>
                <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
                <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
                <td width="33%" style="text-align: right; ">{{$config->nama}}</td>
            </tr>
        </table>
    </htmlpagefooter>

    

    <div><h3>Laporan Rl 2.@if($poli_id=="I") a @else b @endif
    </h3>

    <h5>
    {{$periode}}
    </h5>

    

      <table border="1" style="width:100%;">

        <thead>

          <tr style="background-color: #008080;">

                <th style="vertical-align: middle;" width="20%">Kode ICD</th>
                <th style="vertical-align: middle;" width="20%">Nama ICD</th>
                <th style="vertical-align: middle;">0 - 28 H</th>
                <th style="vertical-align: middle;">28H - < 1 Th </th>
                <th style="vertical-align: middle;">1 Th - 4 Th</th>
                <th style="vertical-align: middle;">5 Th - 14 Th</th>
                <th style="vertical-align: middle;">15 Th - 24 Th</th>
                <th style="vertical-align: middle;">25 Th - 44 Th</th>
                <th style="vertical-align: middle;">45 Th - 64 Th</th>
                <th style="vertical-align: middle;">64 Th < </th>
                <th style="vertical-align: middle;">Laki</th>
                <th style="vertical-align: middle;">Wanita</th>
                <th style="vertical-align: middle;">Hidup</th>
                <th style="vertical-align: middle;">Mati</th>

          </tr>

        </thead>

        <tbody>

        @foreach ($laporan as $key => $d)
       
                <tr>

                    <th style="vertical-align: middle;" width="20%">{{$d->nomor}}</th>
                    <th style="vertical-align: middle;" width="20%">{{$d->nama}}</th>
                    <!----28H--->
                    <th style="vertical-align: middle;">{{ App\PerawatanIcd10::join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])->whereRaw('TIMESTAMPDIFF(month , tgllahir, NOW() ) <= 1')->where('registrasis.status_reg','regexp',$poli_id)->where('perawatan_icd10s.icd10',$d->nomor)->count('perawatan_icd10s.icd10')}}</th>
                    <!----<1TH--->
                    <th style="vertical-align: middle;">{{ App\PerawatanIcd10::join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])->whereRaw('TIMESTAMPDIFF(month , tgllahir, NOW() ) < 12')->whereRaw('TIMESTAMPDIFF(month , tgllahir, NOW() ) >= 1')->where('registrasis.status_reg','regexp',$poli_id)->where('perawatan_icd10s.icd10',$d->nomor)->count('perawatan_icd10s.icd10')}} </th>
                    <!----<4TH--->
                    <th style="vertical-align: middle;">{{ App\PerawatanIcd10::join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])->whereRaw('TIMESTAMPDIFF(month , tgllahir, NOW() ) > 12')->whereRaw('TIMESTAMPDIFF(YEAR , tgllahir, NOW() ) <= 4')->where('registrasis.status_reg','regexp',$poli_id)->where('perawatan_icd10s.icd10',$d->nomor)->count('perawatan_icd10s.icd10')}}</th>
                    <!----<14TH--->
                    <th style="vertical-align: middle;">{{ App\PerawatanIcd10::join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])->whereRaw('TIMESTAMPDIFF(YEAR , tgllahir, NOW() ) > 4')->whereRaw('TIMESTAMPDIFF(YEAR , tgllahir, NOW() ) <= 14')->where('registrasis.status_reg','regexp',$poli_id)->where('perawatan_icd10s.icd10',$d->nomor)->count('perawatan_icd10s.icd10')}}</th>
                    <!----<24TH--->
                    <th style="vertical-align: middle;">{{ App\PerawatanIcd10::join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])->whereRaw('TIMESTAMPDIFF(YEAR , tgllahir, NOW() ) > 14')->whereRaw('TIMESTAMPDIFF(YEAR , tgllahir, NOW() ) <= 24')->where('registrasis.status_reg','regexp',$poli_id)->where('perawatan_icd10s.icd10',$d->nomor)->count('perawatan_icd10s.icd10')}}</th>
                    <!----<44TH--->
                    <th style="vertical-align: middle;">{{ App\PerawatanIcd10::join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])->whereRaw('TIMESTAMPDIFF(YEAR , tgllahir, NOW() ) > 24')->whereRaw('TIMESTAMPDIFF(YEAR , tgllahir, NOW() ) <= 44')->where('registrasis.status_reg','regexp',$poli_id)->where('perawatan_icd10s.icd10',$d->nomor)->count('perawatan_icd10s.icd10')}}</th>
                    <!----<64TH--->
                    <th style="vertical-align: middle;">{{ App\PerawatanIcd10::join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])->whereRaw('TIMESTAMPDIFF(YEAR , tgllahir, NOW() ) > 44')->whereRaw('TIMESTAMPDIFF(YEAR , tgllahir, NOW() ) <= 64')->where('registrasis.status_reg','regexp',$poli_id)->where('perawatan_icd10s.icd10',$d->nomor)->count('perawatan_icd10s.icd10')}}</th>
                    <!----diatas 64TH--->
                    <th style="vertical-align: middle;">{{ App\PerawatanIcd10::join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])->whereRaw('TIMESTAMPDIFF(YEAR , tgllahir, NOW() ) > 64')->where('registrasis.status_reg','regexp',$poli_id)->where('perawatan_icd10s.icd10',$d->nomor)->count('perawatan_icd10s.icd10')}}</th>
                    <!----Laki--->
                    <th style="vertical-align: middle;">{{ App\PerawatanIcd10::join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])->where('pasiens.kelamin','L')->where('registrasis.status_reg','regexp',$poli_id)->where('perawatan_icd10s.icd10',$d->nomor)->count('perawatan_icd10s.icd10')}}</th>
                    <!----Perempuan--->
                    <th style="vertical-align: middle;">{{ App\PerawatanIcd10::join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])->where('pasiens.kelamin','P')->where('registrasis.status_reg','regexp',$poli_id)->where('perawatan_icd10s.icd10',$d->nomor)->count('perawatan_icd10s.icd10')}}</th>
                    <!----hidup--->
                    <th style="vertical-align: middle;">{{ App\PerawatanIcd10::join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])->whereIn('registrasis.keadaan_keluar_inap',['sembuh','membaik'])->where('registrasis.status_reg','regexp',$poli_id)->where('perawatan_icd10s.icd10',$d->nomor)->count('perawatan_icd10s.icd10')}}</th>
                    <!----mati--->
                    <th style="vertical-align: middle;">{{ App\PerawatanIcd10::join('registrasis','registrasis.id','=','perawatan_icd10s.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')->whereBetween('registrasis.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])->whereNotIn('registrasis.keadaan_keluar_inap',['sembuh','membaik'])->where('registrasis.status_reg','regexp',$poli_id)->where('perawatan_icd10s.icd10',$d->nomor)->count('perawatan_icd10s.icd10')}}</th>

                

                </tr>

              @endforeach

        </tbody>

        <tfoot>
            <tr style="background-color: #008080;">
                <th style="vertical-align: middle;" width="20%" colspan="2">Total</th>
                
                <th style="vertical-align: middle;">{{$col28h}}</th>
                <th style="vertical-align: middle;">{{$col1th}} </th>
                <th style="vertical-align: middle;">{{$col4th}}</th>
                <th style="vertical-align: middle;">{{$col14th}}</th>
                <th style="vertical-align: middle;">{{$col24th}}</th>
                <th style="vertical-align: middle;">{{$col44th}}</th>
                <th style="vertical-align: middle;">{{$col64th}}</th>
                <th style="vertical-align: middle;">{{$coltua}} </th>
                <th style="vertical-align: middle;">{{$laki}}</th>
                <th style="vertical-align: middle;">{{$perempuan}}</th>
                <th style="vertical-align: middle;">{{$hidup}}</th>
                <th style="vertical-align: middle;">{{$mati}}</th>
            </tr>
        </tfoot>

      </table></div>
    
</body>

</html>