<html lang="en">
<head>
  <meta charset="utf-8">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Retur Barang</title>


	<style>
  
  @page {
  
      odd-footer-name: html_MyFooter1;
      margin-top: 1cm;
    margin-bottom: 2cm;
    margin-left: 1cm;
    margin-right: 1cm;
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
  <div style="text-align:center;"><b><u>Retur</u></b><br>

  </div>

  <table style="width:100%;font-size:16px;">

    <tr>

      <td width="10%">No Retur</td>

      <td width="5%">:</td>

      <td width="10%">{{$retur->no_retur}}</td>

      <td width="10%"></td>

      <td width="10%">Supplir</td>

      <td width="5%">:</td>

      <td width="50%">PT Maju Mundur</td>

    </tr>

    <tr>

      <td width="20%">Tanggal</td>

      <td width="5%">:</td>

      <td width="20%">1/12/2020</td>

      <td width="10%"></td>

      <td width="20%">Alamat Supplier</td>

      <td width="5%">:</td>

      <td width="20%">Jalan Jatisari Gg Cendana No 15 Semarang</td>

    </tr>

    </table><br>

    <table style="width:100%;" border=1>

      <tr>

        <th>No</th>

        <th>Nama</th>

        <th>Jumlah</th>

        <th>Harga</th>

        <th>Sub Harga</th>

        <th>Keterangan</th>

        

      </tr>

      @foreach($detail_retur as $data)

    

      <tr>

        <td>{{$no++}}</td>

        <td>{{$data->nama_obj}}</td>

        <td>{{$data->jumlah}}</td>

        <td>Rp.{{number_format($data->harga)}}</td>

        <td>Rp.{{number_format($data->total_harga)}}</td>

        <td>{{$data->keterangan}}</td>

      </tr>

      @endforeach

      <tr>

      <td colspan="4">Sub Total</td>

      <td colspan="2" align="right">Rp.{{number_format($retur->sub_harga)}}</td>  

      </tr>

      <tr>

      <td colspan="4">PPN</td>

      <td colspan="2" align="right">Rp.{{number_format($retur->ppn)}}</td>  

      </tr>

      <tr>

      <td colspan="4">Materai</td>

      <td colspan="2" align="right">Rp.{{number_format($retur->materai)}}</td>  

      </tr>

      <tr>

      <td colspan="4">Total</td>

      <td colspan="2" align="right">Rp.{{number_format($retur->total_harga)}}</td>  

      </tr>

    </table>

    <br>

    <br><br><br>

    <table width="100%">

      <tr>

        <td width="33%"></td>

        <td width="33%"></td>

        

        <td width="34%">Semarang, {{ tanggalkuitansi(date('d-m-Y')) }}</td>

      </tr>

      <tr>

        <td >Supplier</td>

        <td ></td>

        

        <td >Yang menyerahkan</td>

      </tr>

      <tr>

        <td ></td>

        <td ></td>

        

        <td height="50px"></td>

      </tr>

      <tr>

        <td >(. . . . . . . . . . . . . . . . . . . . . . . . )</td>

        <td ></td>

        

        <td >@if($retur->petugas==null)
        Pimpinan
        @else
        {{$retur->petugas}}
        @endif
        </td>

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