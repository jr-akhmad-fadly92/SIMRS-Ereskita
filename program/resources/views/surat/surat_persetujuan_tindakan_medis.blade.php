<html lang="en">
<head>
  <meta charset="utf-8">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>SURAT PERSETUJUAN / PENOLAKAN TINDAKAN MEDIS</title>

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
  <div style="text-align:center;"><b><u>SURAT PERSETUJUAN / PENOLAKAN TINDAKAN MEDIS</u></b>
  </div>

  <p>Saya yang bertanda tangan di bawah ini :</p>
   <table width="100%">

      <tr>

        <td width="25%"></td>

        <td width="25%">Nama</td>

        <td width="5%">:</td>

        <td width="45%"> {{$reg->pasien->penanggung_jawab}}</td>

      </tr>

      <tr>

        <td width="25%"></td>

        <td width="25%">Umur / Jenis Kelamin</td>

        <td width="5%">:</td>

        <td width="45%">{{hitung_umur($reg->pasien->umur_penanggung_jawab,'Y')}}  /  @if($reg->pasien->kelamin_penanggung_jawab=='L')
        Laki - Laki 
        @else 
        Perempuan
        @endif</td>

      </tr>

      <tr>

        <td width="25%"></td>

        <td width="25%">Alamat</td>

        <td width="5%">:</td>

        <td width="45%"> {{$reg->pasien->alamat_penanggung_jawab}}</td>

      </tr>

      <tr>

        <td width="25%"></td>

        <td width="25%"> No {{$reg->pasien->jenis_tanda_pengenal}} </td>

        <td width="5%">:</td>

        <td width="45%"> {{$reg->pasien->no_bukti_diri}} </td>

      </tr>

    </table>

    <p>Dengan ini menyatakan dengan sesungguhnya telah memberikan </p><p align="center"><b>PERSETUJUAN / PENOLAKAN</b></center></p>
    <p>Untuk dilakukan tindakan medis berupa **<br>
    Terhadap diri saya sendiri*/istri*/suami*/orang tua*/anak* saya dengan </p>

    <table width="100%">

      <tr>

        <td width="25%"></td>

        <td width="25%">Nama</td>

        <td width="5%">:</td>

        <td width="45%"> {{$reg->pasien->nama}}</td>

      </tr>

      <tr>

        <td width="25%"></td>

        <td width="25%">Umur / Jenis Kelamin</td>

        <td width="5%">:</td>

        <td width="45%"> {{hitung_umur($reg->pasien->tgllahir)}} / @if($reg->pasien->kelamin=='L')
        Laki - Laki 
        @else 
        Perempuan
        @endif</td>

      </tr>

      <tr>

        <td width="25%"></td>

        <td width="25%">Alamat</td>

        <td width="5%">:</td>

        <td width="45%"> {{$reg->pasien->alamat}}</td>

      </tr>

      <tr>

        <td width="25%"></td>

        <td width="25%">Bukti diri / KTP</td>

        <td width="5%">:</td>

        <td width="45%"> {{$reg->pasien->pekerjaan->nama}}</td>

      </tr>

      <tr>

        <td width="25%"></td>

        <td width="25%">Dirawat di</td>

        <td width="5%">:</td>

        <td width="45%"> {{$config->nama}}</td>

      </tr>

      <tr>

        <td width="25%"></td>

        <td width="25%">Nomor Keluarga</td>

        <td width="5%">:</td>

        <td width="45%"> {{$reg->pasien->telp_penanggung_jawab}}</td>

      </tr>

    </table>
    <p>Yang tujuan, sifat dan perlunya tindakan medis tersebut di atas, serta resiko yang dapat ditimbulkannya telah cukup dijelaskan oleh dokter / paramedis dan telah saya mengerti sepenuhnya.<br>
    Demikian pernyataan saya ini saya buat penuh kesadaran dan tanpa paksaan</p>
        
    <table width="100%" cellspacing="0px" >

      <tr>

        <td width="33%" style="border:0px solid;margin: 0px;padding: 0px;"></td>

        <td width="30%" style="border:0px solid;margin: 0px;padding: 0px;"></td>

        <td width="37%" style="text-align: center; border:0px solid;margin: 0px;padding: 0px;">Semarang, {{ tanggalkuitansi(date('d-m-Y')) }}</td>

      </tr>

      <tr >

        <td width="33%" style="text-align: center; border:0px solid;margin: 0px;padding: 0px;">Dokter / Perawat / Bidan {{$config->nama}}</td>

        <td width="30%" style="text-align: center; border:0px solid;margin: 0px;padding: 0px;"> Saksi </td>

        <td width="37%" style="text-align: center; border:0px solid;margin: 0px;padding: 0px;">Yang membuat pernyataan</td>

      </tr>

      <tr>

        <td width="33%" style="border:0px solid;margin: 0px;padding: 0px;"></td>

        <td width="30%" style="border:0px solid;margin: 0px;padding: 0px;"></td>

        <td width="37%" height="80px"></td>

      </tr>

      <tr >

        <td width="33%" style="text-align: center;">
        <b><u>( . . . . . . . . . . . . . . . . . . . )</u><br> NIP : ............................</b>
        </td>

        <td width="30%">( . . . . . . . . . . . . . . . . . . . )</td>

        <td width="37%" style="text-align: center; border:0px solid;margin: 0px;padding: 0px;"><b><u>{{$reg->pasien->penanggung_jawab}}</u></b></td>

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