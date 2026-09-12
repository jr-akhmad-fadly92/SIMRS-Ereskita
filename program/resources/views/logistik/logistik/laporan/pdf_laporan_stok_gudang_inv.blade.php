<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laporan Stok Gudang Barang</title>
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
        <div style="text-align: right; border-bottom: 1px solid #000000; font-weight: bold; font-size: 10pt;">Laporan Stok Gudang Barang</div>
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
    <table  >

            <thead>

              <tr class="info">

              

                <th style="vertical-align: middle;">#</th>

                <th style="vertical-align: middle;">Nama Barang</th>

                <th style="vertical-align: middle;">Supplier</th>

                <th style="vertical-align: middle;">stok</th>

                <th style="vertical-align: middle;">Harga Satuan</th>

                <th style="vertical-align: middle;">Nilai Persediaan</th>

              

              </tr>

            </thead>

            <tbody>

              @foreach($Laporan_stok as $data)

              <tr>

                <td>{{$no++}}</td>

                <td>{{$data->nama_barang}}</td>

                <td>{{$data->nama_produsen}}</td>

                <td>{{$data->stok}}</td>

                <td>Rp.{{number_format($data->harga_unit)}}</td>

                <td>Rp.{{number_format($data->total_harga)}}</td>

              </tr>

              @endforeach

            </tbody>

            

          </table>

          Total Harga : 

          @php

          $harga_total = 0;

          

          foreach($Laporan_stok as $item=>$value)

          {

          $harga_total +=$value->total_harga;

          }

          

          @endphp

          Rp. {{number_format($harga_total)}}

          <br>

          Total Barang : 

          @php

          $stok = 0;

          

          foreach($Laporan_stok as $item=>$value)

          {

          $stok +=$value->stok;

          }

          

          @endphp

          {{$stok}} Barang

          <br></div>
    
</body>

</html>