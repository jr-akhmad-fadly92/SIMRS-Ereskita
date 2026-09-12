<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laporan Penjualan Obat Apotik</title>
<style>
    @page {
      sheet-size: A4-L;
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

    tr:nth-child(even) {background-color: #f2f2f2;}

</style>
</head>
<body>
    <htmlpageheader name="MyHeader1">
        <div style="text-align: right; border-bottom: 1px solid #000000; font-weight: bold; font-size: 10pt;">{{$config->nama}}</div>
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

    

    <div><h3>Laporan Penjualan Obat Apotik</h3>

    <h4>Periode: {{ $tga }} s/d {{ $tgb }}</h4>
        <br>
          <div class="table-responsive">
            <table border=1 class="table table-hover table-bordered table-condensed" id="data">
              <thead>
                <tr style="background-color: #00FFFF;">
                  <th>No</th>
                  <th>Nama Obat</th>
                  <th>Jumlah yang terjual</th>
                  <th>Harga Satuan</th>
                  <th class="text-center">Total</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($penjualan as $data)
                      <tr>
                        <th>{{$no++}}</th>
                        <th>{{$data->nama}}</th>
                        <th>{{$data->total_jumlah}}</th>
                        <th>Rp. {{number_format($data->hargasatuan)}}</th>
                        <th class="text-right">Rp. {{number_format($data->total)}}</th>
                      </tr>
                  @endforeach
              </tbody>
            </table>
            <br>
            <h4>Total Jumlah yang terjual : <b>Rp. {{number_format($total_penjualan->total)}}</b></h4>
          </div>
    
</body>

</html>