<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laporan Pendapatan Dokter</title>
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

    

    <div><h3>Detail Pendapatan Dokter {{baca_dokter($dokter_id)}}</h3>

    <h5>
    Periode: {{ $periode }}
    </h5>



      <table border="1" style="width:100%;">

        <thead>

          <tr style="background-color: #008080;">

                <th style="vertical-align: middle;">No</th>
                <th style="vertical-align: middle;">Tanggal</th>
                <th style="vertical-align: middle;">Nama Pasien</th>
                <th style="vertical-align: middle;">Tindakan</th>
                <th style="vertical-align: middle;">Biaya Tarif</th>
                <th style="vertical-align: middle;">Pendapatan Rumah Sakit</th>
                <th style="vertical-align: middle;">Pendapatan Dokter</th>
           </tr>

        </thead>

        <tbody>

        @foreach($list_pendapatan as $data)
        @php
        $reg = Modules\Registrasi\Entities\Registrasi::where('id',$data->registrasi_id)->first();
        $pasien = Modules\Pasien\Entities\Pasien::where('id',$reg->pasien_id)->first();
        @endphp
          <tr>
            <td>{{$no++}}</td>
            <td>{{date('d F Y',strtotime($data->created_at))}}</td>
            <td>{{$pasien->nama}}</td>
            <td>{{$data->namatarif}}</td>
            <td>Rp. {{number_format($data->total)}}</td>
            <td>Rp. {{number_format($data->total*(100-$jasa->dokter)/100)}}</td>
            <td>Rp. {{number_format($data->total*$jasa->dokter/100)}}</td>
            
          </tr>

        @endforeach
        <tr style="background-color: #008080;">
            <th style="vertical-align: middle;" colspan="4">Total</th>
            <th style="vertical-align: middle;">Rp. {{number_format($total_sementara)}}</th>
            <th style="vertical-align: middle;">Rp. {{number_format($total_rs)}}</th>
            <th style="vertical-align: middle;">Rp. {{number_format($total_dokter)}}</th>
            
        </tr>

        </tbody>

      </table></div>
    
</body>

</html>