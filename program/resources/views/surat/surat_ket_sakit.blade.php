<html lang="en">
<head>
  <meta charset="utf-8">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>SURAT KETERANGAN SAKIT</title>

	<style>
  
  @page {
      margin-top: 1cm;
      margin-bottom: 1cm;
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
  <div style="text-align:center;"><b><u>SURAT KETERANGAN SAKIT</u></b>
  </div>

   <p>Yang bertanda tangan di bawah ini menerangkan bahwa :</p>
   <table width="100%">

      <tr>

        <td width="25%"></td>

        <td width="25%">Nama</td>

        <td width="5%">:</td>

        <td width="45%"> {{$reg->pasien->nama}}</td>

      </tr>

      <tr>

        <td width="25%"></td>

        <td width="25%">Umur</td>

        <td width="5%">:</td>

        <td width="45%"> {{hitung_umur($reg->pasien->tgllahir)}}</td>

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
    <p>Oleh karena <b>S A K I T</b>, perlu diberikan <b>I S T I R A H A T</b><br>selama ......... hari terhitung mulai tanggal ........................................... s.d ......................................<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Demikian surat keterangan ini dibuat dengan sebenarnya dan untuk dipergunakan dengan semestinya.</p>

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

        <td width="37%" height="50px"></td>

      </tr>

      <tr >

        <td width="33%" style="text-align: center;"></td>

        <td width="30%"></td>

        <td width="37%" style="text-align: center; border:0px solid;margin: 0px;padding: 0px;"><b>{{baca_dokter($reg->dokter_id)}}<br> NIP 23.1.0052226</b></td>

      </tr>

    </table>
</div>
<htmlpagefooter name="MyFooter1">
       
</htmlpagefooter>

</body>
</html>