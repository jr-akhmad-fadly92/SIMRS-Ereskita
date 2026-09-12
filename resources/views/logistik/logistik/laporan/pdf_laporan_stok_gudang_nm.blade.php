<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laporan Stok Gudang Non Medis</title>
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
        <div style="text-align: right; border-bottom: 1px solid #000000; font-weight: bold; font-size: 10pt;">Laporan Stok Gudang Non Medis</div>
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
    <table class='table table-striped table-bordered table-hover table-condensed' id="data">

            <thead>

              <tr class="info">

              

                <th style="vertical-align: middle;">#</th>

                <th style="vertical-align: middle;">Kode t</th>

                <th style="vertical-align: middle;">Nama</th>

                <th style="vertical-align: middle;">Satuan</th>

                <th style="vertical-align: middle;">Jenis</th>

                <th style="vertical-align: middle;">stok</th>

                <th style="vertical-align: middle;">Harga Satuan</th>

                <th style="vertical-align: middle;">Nilai Persediaan</th>

              

              </tr>

            </thead>

            <tbody>

              @foreach($Laporan_stok as $data)

              <tr>

                <td>{{$no++}}</td>

                <td>{{$data->kode_barang}}</td>

                <td>{{$data->nama_barang}}</td>

                <td>{{$data->satuan}}</td>

                <td>{{$data->jenis_barang}}</td>

                <td>{{$data->stok}}</td>

                <td>Rp.{{number_format($data->harga)}}</td>

                <td>Rp.{{number_format($data->total_harga)}}</td>

              </tr>

              @endforeach

            </tbody>

            

          </table>

          Total Item : {{number_format($item_stok)}} item<br>

          Total Jumlah Barang Di terima : {{number_format($jumlah_stok)}} barang<br>

          Total Biaya Pemesanan : Rp. {{number_format($biaya_stok->nilai_persediaan)}}</div>
    
</body>

</html>