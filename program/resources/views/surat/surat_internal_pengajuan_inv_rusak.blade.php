<html lang="en">
<head>
  <meta charset="utf-8">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Pengajuan Inventaris</title>

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
  <div style="text-align:center;"><b><u>Pengajuan Internal Inventaris</u></b><br>
  Unit Rawat Jalan
  </div>

   <p>Kepada Yth.<br>
   Direktur {{$config->nama}}<br>
   Di Tempat</p><br>
   <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dengan hormat,<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dengan ini saya atas nama Kepala Logistik {{$config->nama}} mengajukan permohonan untuk barang inventaris unit Rawat Jalan yaitu :</p>
    <table width="100%" border=1 style="font-size:14px;">

      <tr>

        <td width="5%">No</td>

        <td width="15%">No Inventaris</td>

        <td width="40%">Nama Barang</td>

        <td width="10%">Jumlah</td>

        <td width="30%">Keadaan Barang</td>

      </tr>
@foreach($baranginv as $data)
      <tr>

        <td >{{$no++}} </td>

        <td >{{$data->no_inv}} </td>
        
        <td >{{$data->nama_barang}} </td>

        <td > </td>

        <td >{{$data->kondisi_barang}} </td>

      </tr>
@endforeach
    </table>
    <p align="justify">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian permohonan ini kami buat, atas perhatian dan kerjasamanya kami sampaikan terima kasih.</p>
    <table width="100%">

      <tr>

        <td width="33%"></td>

        <td width="33%"></td>

        <td width="33%" style="text-align: center;">Semarang, {{ tanggalkuitansi(date('d-m-Y')) }}</td>

      </tr>

      <tr >

        <td width="33%" style="text-align: center;">Dokter / Perawat yang mengusulkan</td>

        <td width="33%" style="text-align: center;">Kepala Unit</td>

        <td width="33%" style="text-align: center;">Kepala Logistik</td>

      </tr>

      <tr>

        <td width="33%"></td>

        <td width="33%"></td>

        <td width="33%" height="50px"></td>

      </tr>

      <tr >

        <td width="33%" style="text-align: center;">( . . . . . . . . . . . . . . . . . . . . . . )</td>

        <td width="33%" style="text-align: center;">( . . . . . . . . . . . . . . . . . . . . . . )</td>

        <td width="33%" style="text-align: center;">( . . . . . . . . . . . . . . . . . . . . . . )</td>

      </tr>

      <tr>

        <td width="33%" style="text-align: center;">Mengetahui,<br>Kepala Keuangan</td>

        <td width="33%" style="text-align: center;"></td>

        <td width="33%" style="text-align: center;">Menyetujui,<br>Direktur</td>

      </tr>

      <tr>

        <td width="33%"></td>

        <td width="33%"></td>

        <td width="33%" height="50px"></td>

      </tr>

      <tr>

        <td width="33%" style="text-align: center;">( . . . . . . . . . . . . . . . . . . . . . . )</td>

        <td width="33%"></td>

        <td width="33%" style="text-align: center;">( . . . . . . . . . . . . . . . . . . . . . . )</td>

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