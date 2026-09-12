<html lang="en">
<head>
  <meta charset="utf-8">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>SURAT KETERANGAN SEHAT</title>

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
  <div style="text-align:center;"><b><u>SURAT KETERANGAN SEHAT</u></b><br>
  nomor : ...../SRT/SKS/.../2020
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
    <p>Hasil pemeriksaan fisik kami pada tanggal {{date('d F Y',strtotime($ket_sehat->created_at))}} di {{$config->nama}} adalah sebagai berikut</p>
    <table width="100%">

        <tr>

        <td width="25%"></td>

        <td width="25%">Berat Badan</td>

        <td width="5%">:</td>

        <td width="45%">{{$ket_sehat->berat_badan}} Kg</td>

        </tr>

        <tr>

        <td width="25%"></td>

        <td width="25%">Tinggi Badan</td>

        <td width="5%">:</td>

        <td width="45%">{{$ket_sehat->tinggi_badan}} cm</td>

        </tr>

        <tr>

        <td width="25%"></td>

        <td width="25%">Tekanan Darah</td>

        <td width="5%">:</td>

        <td width="45%">{{$ket_sehat->tekanan_darah}} mmHg</td>

        </tr>

        <tr>

        <td width="25%"></td>

        <td width="25%">Golongan Darah</td>

        <td width="5%">:</td>

        <td width="45%">{{$ket_sehat->golongan_darah}} </td>

        </tr>


        <tr>

        <td width="25%"></td>

        <td width="25%">Riwayat Penyakit</td>

        <td width="5%">:</td>

        <td width="45%">{{$ket_sehat->riwayat_penyakit}} </td>

        </tr>

        </table>

        <p>Surat Keterangan Sehat ini dipergunakan sebagai {{$ket_sehat->keperluan}} <br>
        Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya</p>

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

        <td width="37%" style="text-align: center; border:0px solid;margin: 0px;padding: 0px;"><b><u>{{baca_dokter($reg->dokter_id)}}</u><br> NIP 23.1.0052226</b></td>

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