<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Data Detail Operasi</title>

    <link href="{{ asset('laravel/css/pdf.css') }}" rel="stylesheet">

    <style type="text/css">
    @page {
      sheet-size: A4;
      margin-top: 15px;
      margin-bottom: 1cm;
      margin-left: 1cm;
      margin-right: 1cm;
      odd-footer-name: html_MyFooter1;
    }
    #header{
      width:100%;
    
    }
    #content{
      position:relative;
    }

    #footer{
      position:relative;
      height:40px;
      line-height:40px;
      color:#fff;
      text-align:center;
    }

		table tr td,

		table tr th{

			font-size: 8,5pt;

		}

    th { background-color: #d3d3d3; border: 2px #2b2b2b solid; text-align:center;}

    tr.abu { background-color: #d3d3d3; border: 2px #2b2b2b solid; text-align:left;}

    tr.bawah { border-bottom: 2px #2b2b2b solid; }

    .atas {

      text-align:left;

      vertical-align: text-top;

      border-left: solid 2px #000

      }

      .atastr {

      border-top: solid 2px #000

      }

    .border-left-d{

    border-left: solid 2px #000;

    }

    .border-bottom-d{

    border-bottom: solid 2px #000;

    }

    .border-bottom-t{

    border-bottom: solid 2px #000;

    }

    .border-top-d{

    border-top: solid 2px #000;

    }

    .border-top-t{

    border-top: solid 2px #000;

    }

    .border-right-d{

    border-right: solid 2px #000;

    }

    .border-all{

    border-left: solid 2px #000;

    border-right: solid 2px #000;

    border-top: solid 2px #000;

    border-bottom: solid 2px #000;

    }

    hr.double-garis{

      border:0;

      border-top: 3px double #000;

    }

    hr.1garis{

      border:solid 1px;

   

    }

	</style>

  </head>

  <body>

  

  <div id="header">
    <table width="100%" >
    <tr>
      <td width="10%"><img height="60px" src="/public/images/{{$config->logo}}" style="width:18mm;" /></td>
      <td align="center" vlign="top">
      <b>{{$config->nama}}</b><br>
      {{$config->alamat}}<br>
      No Telepon : {{$config->tlp}}<br>
      Email : {{$config->email}}<br>
      </td>
      <td width="10%"></td>
    </tr>
    </table><hr style="margin-top:20;margin-bottom: 5;"><br>
  </div>

    <h5>Laporan Operasi Pasien {{$reg->nama_pasien}}</h5>

    <hr style="margin-top:5;margin-bottom: 0;">

    <table width='100%'  >

    <tr>

    <td width='15%'><b>Nama Pasien</b></td>

    <td width='2%'><b>:</b></td>

    <td width='33%'>{{$reg->nama_pasien}}</td>

    <td width='19%'><b>No. Rekam Medis</b></td>

    <td width='1%'>:</td>

    <td width='30%'>{{$reg->no_rm}}</td>

    
    </tr>

    <tr>

    <td><b>Umur</b></td>

    <td><b>:</b></td>

    <td>{{ hitung_umur($reg->tgllahir,'Y') }}</td>

    

    <td><b>Ruangan</b></td>

    <td>:</td>

    <td>{{$kamar->nama}}</td>

    

    </tr>

    <tr >

    <td><b>Tanggal Lahir</b></td>

    <td><b>:</b></td>

    <td>{{ tgl_indo($reg->tgllahir) }}</td>

    

    <td><b>Jenis Kelamin</b></td>

    <td>:</td>

    @if($reg->kelamin=="P")

      <td >Perempuan </td>

    @else

      <td>Laki-Laki </td>

    @endif

    </tr>

    </table>

    <table width='100%'  >

    <tr >

    <th width='100%' style="border: 1px solid black;"><h5><b>PENILAIAN SEBELUM OPERASI</b></h5></th>

    </tr>

    </table>

    <table width="100%">
      <tr>
        <td style="width:15%;"> Tanggal </td>
        <td style="width:2%;"> : </td>
        <td style="width:33%;">{{ $op->rencana_operasi }} </td>
        <td style="width:20%;"colspan="2">Dokter Bedah</td>
        <td style="width:20%;"colspan="2">: {{baca_dokter($op->operator)}} </td>
        
      </tr>
    </table>
    <hr style="margin-top:0;margin-bottom: 0;">
    <table width="100%">
      <tr >
        <td colspan="4" style="height:50px;vertical-align: top;"> Keluhan : <br>{{$op->keluhan}} tes</td>
        <td style="width:50%;vertical-align: top; border-left: solid 2px #000" rowspan="2"> Penilaian : <br>{{$op->penilaian}}</td>
      </tr>
      <tr >
        <td colspan="4" style="height:50px;vertical-align: top;"> Pemeriksaan : <br>{{$op->pemerikasaan_fisik}} tes</td>
      </tr>
      <tr >
        <td > Suhu Tubuh(C) </td>
        <td > {{$op->suhu_tubuh}}</td>
        <td > Nadi(/Mnt) </td>
        <td > {{$op->nadi}}</td>
        <td style="width:50%;vertical-align: top;  border-left: solid 2px #000" rowspan="4"> Tindak Lanjut : <br>{{$op->tindak_lanjut}}</td>
      </tr>
      <tr >
        <td > Tensi </td>
        <td > {{$op->tensi}}</td>
        <td > Respirasi(/Mnt) </td>
        <td > {{$op->respirasi}}</td>
        
     </tr>
     <tr >
        <td > Tinggi(Cm) </td>
        <td > {{$op->tinggi}}</td>
        <td > GCS(E,V,M) </td>
        <td > {{$op->GCS}}</td>
      </tr>
     
      <tr >
        <td > Berat(Kg) </td>
        <td > {{$op->berat}}</td>
        <td >  </td>
        <td > </td>
      </tr>
     
    </table>
    <table width='100%'  >

    <tr >

    <th width='100%' colspan='7' style="border: 1px solid black;"><h5><b>PENILAIAN PASCA OPERASI</b></h5></th>

    

    </tr>

    <tr >

    <td width='25%'><b>Dokter Bedah</b></td>

    <td width='45%'><b>:</b> {{baca_dokter($op->operator)}}</td>

    <td width='30%' colspan="5" rowspan="13" class="atas">

    <b>Tipe / Kategori Anastesi </b>: <br>{{$op->tipe_anastesi}}<br><br><br>

    <b>Tipe / Kategori Operasi</b>: <br>{{$op->tipe_operasi}}<br><br><br>

    <b>Selesai Operasi </b>: <br>{{$op->updated_at}}<br><br><br></td>

    </tr>

    <tr >

    <td width='15%'><b>Dokter Bedah 2</b></td>

    <td width='35%'><b>:</b> {{baca_dokter($op->operator2)}}</td>

    

    </tr>

    <tr >

    <td width='15%'><b>Dokter Anestesi</b></td>

    <td width='35%'><b>:</b> {{baca_dokter($op->dokter_anastesi)}}</td>

    

    </tr>

    <tr >

    <td width='15%'><b>Dokter Anak</b></td>

    <td width='35%'><b>:</b> {{baca_dokter($op->dokter_anak)}}</td>

    

    </tr>

    <tr >

    <td width='15%'><b>Perawat / Bidan 1</b></td>

    <td width='35%'><b>:</b> {{baca_dokter($op->perawat_1)}}</td>

    

    </tr>

    <tr >

    <td width='15%'><b>Perawat / Bidan 2</b></td>

    <td width='35%'><b>:</b> {{baca_dokter($op->perawat_2)}}</td>

    

    </tr>

    <tr >

    <td width='15%'><b>Perawat / Bidan 3</b></td>

    <td width='35%'><b>:</b> {{baca_dokter($op->perawat_3)}}</td>

    

    </tr>

    <tr class="abu">

    <td colspan="2"><b>Diagnosa Awal</b></td>

    </tr>

    <tr>

    <td colspan="2" style="height:40px;vertical-align: top;  "> {{$op->diagnosa_awal}}</td>

    

    </tr>

    <tr class="abu">

    <td colspan="2"><b>Jaringan yang di Eksisi / Insisi</b></td>

    </tr>

    <tr >

    <td colspan="2" style="height:40px;vertical-align: top;  "> {{$op->jaringan_tubuh}}</td>

    

    </tr>

    <tr class="abu">

    <td colspan="2" ><b>Diagnosa Pasca Operasai</b></td>

    </tr>

    <tr>

    <td colspan="2" style="height:40px;vertical-align: top;  "> {{$op->diagnosa_pasca_op}}</td>

    

    </tr>

    </table>

    <table width='100%'  >

    <tr  >

    <th width='100%'  style="border: 1px solid black;"><h5><b>REPORT(PROCEDURES, SPECIFIC, FINDINGS, AND COMPLICATIONS)</b></h5></th>

    

    </tr>

    <tr>

      <td style="height:60px;vertical-align: top;  ">{{$op->laporan_operasi}}</td>

    </tr>

    </table>

    <table width='100%'>

    <tr>

    <td width="70%">

    </td>

    <td>

    {{tanggal($op->updated_at)}}<br>Dokter Bedah

    <br><br><br><br><br><br>

    {{baca_dokter($op->operator)}}

    </td>

    </tr>

    </table>

    <htmlpagefooter name="MyFooter1">
            <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
                <tr>
                    <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
                    <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right; ">{{$config->nama}}</td>
                </tr>
            </table>
    </htmlpagefooter>

  </body>

</html>

