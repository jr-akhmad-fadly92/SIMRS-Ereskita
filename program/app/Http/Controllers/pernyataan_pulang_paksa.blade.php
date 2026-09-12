<html lang="en">
<head>
  <meta charset="utf-8">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Penerimaan Barang</title>

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
  <div style="text-align:center;"><b><u>SURAT PERNYATAAN</u></b><br>
  PULANG PAKSA
  </div>

   <p>Saya yang bertanda tangan dibawah ini :</p>

   <table width="50%">

      <tr>

        <td width="25%">Nama</td>

        <td width="5%">:</td>

        <td width="70%"></td>

      </tr>

      <tr>

        <td width="25%">Umur / Tanggal Lahir</td>

        <td width="5%">:</td>

        <td width="70%"></td>

      </tr>

      <tr>

        <td width="25%">Alamat</td>

        <td width="5%">:</td>

        <td width="70%"></td>

      </tr>

      <tr>

        <td width="25%">Telp</td>

        <td width="5%">:</td>

        <td width="70%"></td>

      </tr>

    </table>
    Menyatakan dengan sesungguhnya dari saya sendiri / * Sebagai Orang Tua / * Sebagai Suami / * Sebagai Istri / * Sebagai Wali dari

    <br>

    <table width="50%">

      <tr>

        <td width="25%">Nama</td>

        <td width="5%">:</td>

        <td width="70%"></td>

      </tr>

      <tr>

        <td width="25%">Umur / Tanggal Lahir</td>

        <td width="5%">:</td>

        <td width="70%"></td>

      </tr>

    </table>

    <p>Bahwa orang tersebut belum diperbolehkan pulang oleh dokter, dan sudah mendapatkan penjelasan dari dokter / petugas tentang kondisi pasien dan kelanjutan terapi. Tetepi atas permintaan keluarga, pasien mau dibawa pulang dan keluarga siap menanggung segala resiko yang kemungkinan dihadapi</p>
    

    <table width="100%">

      <tr>

        <td width="33%"></td>

        <td width="33%"></td>

        <td width="33%">Semarang, {{ tanggalkuitansi(date('d-m-Y')) }}</td>

      </tr>

      <tr>

        <td width="33%">Petugas</td>

        <td width="33%"></td>

        <td width="33%">Yang Membuat Pernyataan</td>

      </tr>

      <tr>

        <td width="33%"></td>

        <td width="33%"></td>

        <td width="33%" height="50px"></td>

      </tr>

      <tr>

        <td width="33%">( . . . . . . . . . . . . . . . . . . . . . . )</td>

        <td width="33%"></td>

        <td width="33%">( . . . . . . . . . . . . . . . . . . . . . . )</td>

      </tr>

      <tr>

        <td width="33%"></td>

        <td width="33%">Saksi</td>

        <td width="33%"></td>

      </tr>

      <tr>

        <td width="33%"></td>

        <td width="33%"></td>

        <td width="33%" height="50px"></td>

      </tr>

      <tr>

        <td width="33%"></td>

        <td width="33%">( . . . . . . . . . . . . . . . . . . . . . . )</td>

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