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
  <div style="text-align:center;"><b><u>BERITA ACARA SERAH TERIMA BARANG / OBAT </u></b><br>

    Antara {{$config->nama}} dengan {{$penerimaan->nama_produsen}}</div>

   <p>Kami yang bertanda tangan dibawah ini :</p>

   <table width="70%">

    <tr>

      <td width="20%">Nama</td>

      <td width="10%">:</td>

      <td width="70%">{{baca_pegawai($pemohon->po_nama_pemohon)}}</td>

    </tr>

    <tr>

      <td width="20%">NIK</td>

      <td width="10%">:</td>

      <td width="70%">PG258369741(contoh)</td>

    </tr>

   </table>

   <p>Berdasarkan PO Tanggal {{tgl_indo($pemohon->po_tanggal_pemesanan)}} dengan No PO : <b>{{$pemohon->po_no_purchaseorder}} </b>telah menerima barang dari :</p>

   <table width="70%">

    <tr>

      <td width="20%">Nama</td>

      <td width="10%">:</td>

      <td width="70%"></td>

    </tr>

    <tr>

      <td width="20%">Jabatan</td>

      <td width="10%">:</td>

      <td width="70%"></td>

    </tr>

   </table><br>

   Dengan rincian barang yang diterima :
   <br><br>
   <table border="1" style="width:100%;">

      <tr>

        <th>No</th>

        <th>Nama</th>

        <th>Satuan</th>

        <th >Jumlah Di Terima</th>

        <th>Experied</th>

        

      </tr>

      @foreach($detail_faktur as $data)

      @php 

        $satuan= App\Tbdetailpurchase::where('dpo_no_purchaseorder',$penerimaan->no_po)->where('dpo_item_name',$data->nama_obj)->first();

      @endphp

      <tr>

        <td>{{$no++}}</td>

        <td>{{$data->nama_obj}}</td>

        <td>{{$satuan->dpo_item_unit}}</td>

        <td>{{$data->jumlah_diterima}}</td>

        <td>{{tanggalkuitansi(valid_date($data->expired))}}</td>

        

      </tr>

      @endforeach

      

   </table>

   <br>

   Demikian Berita Acara Penerimaan Barang ini dibuat untuk dipergunakan sebagaimana mestinya. 

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

        

        <td >Yang menerima</td>

       </tr>

      <tr>

        <td ></td>

        <td ></td>

        

        <td height="50px"></td>

      </tr>

      <tr>

        <td >(. . . . . . . . . . . . . . . . . . . . .)</td>

        <td ></td>

        

        <td >{{baca_pegawai($pemohon->po_nama_pemohon)}}</td>

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