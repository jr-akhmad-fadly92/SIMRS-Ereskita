<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laporan Penerimaan</title>
<style>
    @page {
      size: auto;
      odd-header-name: html_MyHeader1;
      odd-footer-name: html_MyFooter1;
    }
   
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      text-align: left;
      padding: 8px;
    }
    th{
      background-color: #008080;
    }

    tr:nth-child(even) {background-color: #f2f2f2;}

</style>
</head>
<body>
    <htmlpageheader name="MyHeader1">
        <div style="text-align: right; border-bottom: 1px solid #000000; font-weight: bold; font-size: 10pt;">
        <div style="text-align: right;">{{$config->nama}}</div>
        </div>
        
    </htmlpageheader>
    <htmlpagefooter name="MyFooter1">
          <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
              <tr>
                  <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
                  <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
                  <td width="33%" style="text-align: right; ">{{$config->nama}}</td>
              </tr>
          </table>
      </htmlpagefooter>
  <div>
  <div style="text-align:center;"><b>LAPORAN PENERIMAAN </b><br>
  </div>
    @foreach($kategori as $key => $data1)

   <h5>Kategori : {{$data1->po_kategori_order}}</h5><br>

   <table border="1">

    <tr>

      <th>No Penerimaan</th>

      <th>Tanggal Penerimaan</th>

      <th>Nama Barang</th>

      <th>Kemasan</th>

      <th>Jumlah</th>

      <th>Sub Total</th>

    </tr>



    @foreach($tampil as $data)

      @if($data->po_kategori_order==$data1->po_kategori_order)

      <tr>

        <td>{{$data->no_faktur}}</td>

        <td>{{tanggalkuitansi(tgl_indo($data->tanggal))}}</td>

        <td>{{$data->nama_obj}}</td>

        <td>{{$data->jumlah_diterima}}</td>

        <td >Rp. {{number_format($data->harga)}} </td>

        <td align="right">Rp. {{number_format($data->total)}}</td>

      </tr>

      @else

      @endif

      @endforeach

    </table>

    Jumlah Macam Item : 

    <?php $number = 0; ?>

      @foreach ($tampil as $item)

          @if ( $item->po_kategori_order==$data1->po_kategori_order)

      <?php $number++ ?>    

          @endif

      @endforeach

      {{ $number }}<br>

    Total Harga Kategori {{$data1->po_kategori_order}} : 

      @php

      $harga_total = 0;

      

      foreach($tampil as $item=>$value)

      {if($value->po_kategori_order==$data1->po_kategori_order){

      $harga_total +=$value->total;

      }}

      

      @endphp

      Rp. {{number_format($harga_total)}}

      <hr>

    @endforeach
    </div>
    
</body>

</html>