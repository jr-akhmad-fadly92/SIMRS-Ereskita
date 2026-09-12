<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laporan Stok Opnam</title>
<style>
    @page {
      sheet-size: A4-L;
      size:auto;
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
    <div>
      <h4><center><b>LAPORAN STOK OPNAM </b><br>
      </center></h4>
          <table border=1 style="width:100%;">
            <thead>
              <tr class="info">
                <th style="vertical-align: middle;">#</th>
                <th style="vertical-align: middle;">Kode</th>
                <th style="vertical-align: middle;">Nama</th>
                <th style="vertical-align: middle;">Harga Satuan</th>
                <th style="vertical-align: middle;">Stok Awal</th>
                <th style="vertical-align: middle;">Total Nilai Awal</th>
                <th style="vertical-align: middle;">Stok Akhir</th>
                <th style="vertical-align: middle;">Total Nilai Akhir</th>
                <th style="vertical-align: middle;">Selisih</th>
                <th style="vertical-align: middle;">Total Nilai Selisih</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data_stok_opnam as $data)
              <tr>
                <td>{{$no++}}</td>
                <td>{{$data->kode}}</td>
                <td>{{$data->nama}}</td>
                <td>{{$data->harga}}</td>
                <td>{{$data->stok_sebelum}}</td>
                <td>{{number_format($data->nilai_awal)}}</td>
                <td>{{$data->stok_sesudah}}</td>
                <td>{{number_format($data->nilai_akhir)}}</td>
                <td>{{$data->selisih}}</td>
                <td>{{number_format($data->nilai_selisih)}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <h4>
          Nilai Total Persediaan Akhir : 
          @php
          $harga_total = 0;
          
          foreach($data_stok_opnam as $item=>$value)
          $harga_total +=$value->nilai_akhir;
          
          @endphp
          Rp. {{number_format($harga_total)}}
          </h4></div>
    
</body>

</html>