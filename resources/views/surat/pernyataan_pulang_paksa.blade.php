<html lang="en">
<head>
  <meta charset="utf-8">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>SURAT PERNYATAAN PULANG APS</title>

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
    padding:10px;
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
  <div style="text-align:center;"><b><u>SURAT PERNYATAAN PULANG APS</u></b><br>
  ATAS PERMINTAAN SENDIRI
  </div>

   <p>Saya yang bertanda tangan dibawah ini :</p>

   <table width="50%">

      <tr>

        <td width="75%">Nama</td>

        <td width="5%">:</td>

        <td width="20%"></td>

      </tr>

      <tr>

        <td width="75%">Umur / Tanggal Lahir</td>

        <td width="5%">:</td>

        <td width="20%"></td>

      </tr>

      <tr>

        <td width="75%">Alamat</td>

        <td width="5%">:</td>

        <td width="20%"></td>

      </tr>

      <tr>

        <td width="75%">Telp</td>

        <td width="5%">:</td>

        <td width="20%"></td>

      </tr>

    </table>
    Menyatakan dengan sesungguhnya dari saya sendiri / * Sebagai Orang Tua / * Sebagai Suami / * Sebagai Istri / * Sebagai Wali dari Pasien :

    <br>

    <table width="100%">

      <tr>

        <td width="38%">Nama / No RM</td>

        <td width="5%">:</td>

        <td width="57%"> {{$pasien->nama}} / {{$pasien->no_rm}}</td>

      </tr>

      <tr>

        <td width="38%">Umur / Tanggal Lahir</td>

        <td width="5%">:</td>

        <td width="57%"> {{ hitung_umur($pasien->tgllahir,'Y') }} / {{tanggalkuitansi(valid_date($pasien->tgllahir))}}</td>

      </tr>

    </table>

    <p align="justify">Dengan ini Menyatakan :</p>
    
    <ol>
      <li>Dengan sadar tanpa paksaan dari pihak manapun meminta kepada pihak Rumah Sakit untuk <b> PULANG ATAS PERMINTAAN SENDIRI ( APS ) </b> yang merupakan hak saya / pasien dengan alasan <br>
      :....................................................................................................................................................................<br>
      ....................................................................................................................................................................</li>
      <li>Saya telah memahami sepenuhnya penjelasan yang diberikan dari pihak rumah sakit mengenai penyakit dan kemungkinan / konekuensi terbaik sampai dengan terburuk atas keputusan yang saya ambil. Serta tanggung jawab saya adalah mengambil kepurusan ini.</li>
      <li>Apabila terjadi sesuatu hal berkaitan dengan putusan yang telah diambil, maka hal tersebut adalah menjadi tanggung jawab pasien / keluarga sepenuhnya dan tidak akan menyangkutpautkan / menuntut kepada pihak Rumah Sakit.</li>
      <li>atas keputusan saya ini, rumah sakit telah memberikan penjelasan mengenai alternatif pengobatan selanjutnya.</li>
    </ol>
    <p align="justify"> Demikian pernyataan ini saya buat dengan sesungguhnya untuk diketahui dan digunakan sebagaimana perlunya.
    

    <table width="100%">

      <tr>

        <td width="33%"></td>

        <td width="33%"></td>

        <td width="33%" style="text-align: center;">Semarang, {{ tanggalkuitansi(date('d-m-Y')) }}</td>

      </tr>

      <tr >

        <td width="33%" style="text-align: center;">Petugas</td>

        <td width="33%"></td>

        <td width="33%" style="text-align: center;">Yang Membuat Pernyataan</td>

      </tr>

      <tr>

        <td width="33%"></td>

        <td width="33%"></td>

        <td width="33%" height="50px"></td>

      </tr>

      <tr >

        <td width="33%" style="text-align: center;">( . . . . . . . . . . . . . . . . . . . . . . )</td>

        <td width="33%"></td>

        <td width="33%" style="text-align: center;">( . . . . . . . . . . . . . . . . . . . . . . )</td>

      </tr>

      <tr>

        <td width="33%"></td>

        <td width="33%" style="text-align: center;">Saksi</td>

        <td width="33%"></td>

      </tr>

      <tr>

        <td width="33%"></td>

        <td width="33%"></td>

        <td width="33%" height="50px"></td>

      </tr>

      <tr>

        <td width="33%"></td>

        <td width="33%" style="text-align: center;">( . . . . . . . . . . . . . . . . . . . . . . )</td>

        <td width="33%"></td>

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