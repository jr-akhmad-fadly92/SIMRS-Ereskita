<html lang="en">
<head>
  <meta charset="utf-8">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>SURAT RUJUKAN </title>

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
    <td align="center" vlign="top">
    <font style="font-size:24px;font-weight:bold;" ><u>dr. Mulyastowo Aryu Bimo</u></font><br>
    SIP. 337747.50183/DU.2686/01/449.1/314/VII/2019<br><br>
    Praktek : {{$config->alamat}}<br>
    </td>
  </tr>
  </table><hr class="double-garis"><br>
</div>
<div id="content">
  <div style="text-align:center;"><b><u>SURAT RUJUKAN </u></b>
  </div>

  <p>Yang bertanda tangan di bawah ini menerangkan bahwa :</p>
   <table width="100%">

      <tr>

        <td width="25%">Yth</td>

        <td width="5%">:</td>

        <td width="70%">.......................................</td>

      </tr>

      <tr>

        <td>Di RS</td>

        <td>:</td>

        <td>.......................................</td>

      </tr>

    </table>
    <p>Mohon pemeriksaan dan penanganan lebih lanjut terhadap penderita,</p>
    <table width="100%">

      <tr>

        <td width="25%">Nama Pasien</td>

        <td width="5%">:</td>

        <td width="70%">.......................................</td>

      </tr>

      <tr>

        <td>Jenis Kelamin</td>

        <td>:</td>

        <td>.......................................</td>

      </tr>

      <tr>

        <td>Umur</td>

        <td>:</td>

        <td>.......................................</td>

      </tr>

      <tr>

        <td>No. Telpon</td>

        <td>:</td>

        <td>.......................................</td>

      </tr>

      <tr>

        <td>Alamat Rumah</td>

        <td>:</td>

        <td>.......................................</td>

      </tr>

    </table>
    <p>Anamnese,</p>
    <table width="100%">

      <tr>

        <td width="25%">Keluhan</td>

        <td width="5%">:</td>

        <td width="70%">.......................................</td>

      </tr>

      <tr>

        <td>Diagnosa sementara</td>

        <td>:</td>

        <td>.......................................</td>

      </tr>

      <tr>

        <td>Kasus</td>

        <td>:</td>

        <td>.......................................</td>

      </tr>

      <tr>

        <td>Terapi/Obat yang telah diberikan </td>

        <td>:</td>

        <td>.......................................</td>

      </tr>

    </table>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian surat rujukan ini kami kirim, kami mohon balasan atas surat rujukan ini. Atas perhatian Bapak/Ibu kami ucapkan terima kasih.</p>
    <table width="100%" cellspacing="0px" >

    <tr>

    <td width="33%" style="border:0px solid;margin: 0px;padding: 0px;">Semarang, {{ tanggalkuitansi(date('d-m-Y')) }}</td>

    <td width="30%" style="border:0px solid;margin: 0px;padding: 0px;"></td>

    <td width="37%" style="text-align: center; border:0px solid;margin: 0px;padding: 0px;"></td>

    </tr>

    <tr >

    <td width="33%" style="border:0px solid;margin: 0px;padding: 0px;">Hormat Kami,</td>

    <td width="30%" style="border:0px solid;margin: 0px;padding: 0px;"></td>

    <td width="37%" style="text-align: center; border:0px solid;margin: 0px;padding: 0px;"></td>

    </tr>

    <tr>

    <td width="33%" style="border:0px solid;margin: 0px;padding: 0px;"></td>

    <td width="30%" style="border:0px solid;margin: 0px;padding: 0px;"></td>

    <td width="37%" height="80px"></td>

    </tr>

    <tr >

    <td width="33%" ><b><u>dr. Mulyastowo Aryu Bimo</u><br> STR 31.1.1.100.2.15.047805</b></td>

    <td width="30%"></td>

    <td width="37%" style="text-align: center; border:0px solid;margin: 0px;padding: 0px;"></td>

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