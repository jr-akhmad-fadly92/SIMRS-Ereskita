<html lang="en">
<head>
  <meta charset="utf-8">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>SURAT VISUM ET REPERTUM</title>

	<style>
  
  @page {
      margin-top: 1cm;
      margin-bottom: 2cm;
      margin-left: 1cm;
      margin-right: 1cm;
      odd-footer-name: html_MyFooter1;
    }
  #header{
    width:100%;
    margin:0px 0px;
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

  th{
    background-color: #008080;
  }
  th, td{
    padding:0px;
  }
  /*CONTENT SECTION*/
  
  </style>
  <script>
		setTimeout(function(){
				window.close();
		}, 500);
	</script>
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
  </table><hr class="double-garis"><br>
</div>
<div id="content">
  <div style="text-align:center;"><b><u>SURAT VISUM ET REPERTUM</u></b>
  </div>

   <p><b> Pro Justicia</b></p>
   <p align="justify">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sesuai dengan surat permohonan dari {{$cek_visum->instansi_pemohon}}, yang di tandatangani oleh {{$cek_visum->pemohon}}, selaku penyidik, dengan nomor {{$cek_visum->nomor_permohonan}}, yang diterima pada Tanggal {{date('d',strtotime($cek_visum->created_at))}} Bulan {{date('F',strtotime($cek_visum->created_at))}} Tahun {{date('Y',strtotime($cek_visum->created_at))}} oleh Dokter {{$config->nama}}, tentang permintaan Visum et Repertum dengan identitas sebagai berikut :</p>

   <table width="100%">

      <tr>

        <td width="25%"></td>

        <td width="25%">Nama</td>

        <td width="5%">:</td>

        <td width="45%"> {{$reg->pasien->nama}}</td>

      </tr>

      <tr>

        <td width="25%"></td>

        <td width="25%">Jenis Kelamin</td>

        <td width="5%">:</td>

        <td width="45%"> @if($reg->pasien->kelamin=='L')
        Laki - Laki 
        @else 
        Perempuan
        @endif</td>

      </tr>

      <tr>

        <td width="25%"></td>

        <td width="25%">Umur</td>

        <td width="5%">:</td>

        <td width="45%"> {{hitung_umur($reg->pasien->tgllahir,'Y')}}</td>

      </tr>

      <tr>

        <td width="25%"></td>

        <td width="25%">Pekerjaan</td>

        <td width="5%">:</td>

        <td width="45%"> {{$reg->pasien->pekerjaan->nama}}</td>

      </tr>

      <tr>

        <td width="25%"></td>

        <td width="25%">Alamat</td>

        <td width="5%">:</td>

        <td width="45%"> {{$reg->pasien->alamat}}</td>

      </tr>

    </table>
    <p><b><u>HASIL PEMERIKSANAAN</u></b></p>
    <p><b>Pada pemeriksaan korban didapatkan :</b></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$cek_visum->hasil_pemeriksaan}}</p>
    
    <p><b><u>KESIMPULAN</u></b></p>
    <p>Dari hasil pemeriksaan diatas disebabkan karena {{$cek_visum->kesimpulan}}</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Demikian visum et repertum ini dibuat dengan sesungguhnya berdasarkan keilmuan kedokteran dan dengan mengingat sumpah sesuai dengan Undang - Undang No. 8 tahun 1981 tentang Hukum Acara Pidana.</p>

    <table width="100%" cellspacing="0px" >

      <tr>

        <td width="33%" style="border:0px solid;margin: 0px;padding: 0px;"></td>

        <td width="30%" style="border:0px solid;margin: 0px;padding: 0px;"></td>

        <td width="37%" style="text-align: center; border:0px solid;margin: 0px;padding: 0px;">Semarang, {{ tanggalkuitansi(date('d-m-Y')) }}</td>

      </tr>

      <tr >

        <td width="33%" style="border:0px solid;margin: 0px;padding: 0px;"></td>

        <td width="30%" style="border:0px solid;margin: 0px;padding: 0px;"></td>

        <td width="37%" style="text-align: center; border:0px solid;margin: 0px;padding: 0px;">Dokter {{$config->nama}} </td>

      </tr>

      <tr>

        <td width="33%" style="border:0px solid;margin: 0px;padding: 0px;"></td>

        <td width="30%" style="border:0px solid;margin: 0px;padding: 0px;"></td>

        <td width="37%" height="80px"></td>

      </tr>

      <tr >

        <td width="33%" style="text-align: center;"></td>

        <td width="30%"></td>

        <td width="37%" style="text-align: center; border:0px solid;margin: 0px;padding: 0px;"><b><u>{{baca_dokter($cek_visum->dokter_id)}}</u><br> NIP 23.1.0052226</b></td>

      </tr>

    </table>
</div>
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