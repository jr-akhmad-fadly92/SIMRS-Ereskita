<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Data PDF</title>
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

    

    <div><h3>Laporan Kunjungan IGD</h3>

    <h5>

        Periode: {{ $periode }}

    </h5>



      <table border="1" style="width:100%;">

      <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No. RM</th>
                <th>Umur</th>
                @if ($pasien_asal == 'TI')
                  <th>Kamar</th>
                @else
                  <th>Klinik Asal</th>
                @endif
                <th>Dokter</th>
                <th>Status</th>
                <th>Tes Lab</th>
                
              </tr>
      </thead>

      <tbody>
              @foreach ($kunjungan as $key => $d)
                  @php
                    $reg = Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id);
                    $pasien = Modules\Pasien\Entities\Pasien::find($d->pasien_id);
                    $ri = App\Rawatinap::where('registrasi_id', $d->registrasi_id)->first();
                  @endphp
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $pasien ? strtoupper($pasien->nama) : 'PASIEN DARI LUAR' }}</td>
                  <td>{{ $pasien ? $pasien->no_rm : NULL }}</td>
                  <td>{{ $pasien ? hitung_umur($pasien->tgl_lahir) : NULL }}</td>
                  @if ($pasien_asal == 'TI')
                    <td>{{ $ri ? baca_kamar($ri->kamar_id) : NULL }}</td>
                  @else
                    <td>{{ baca_poli($d->poli_id) }}</td>
                  @endif
                  <td>{{ $reg ? baca_dokter($reg->dokter_id) : NULL }}</td>
                  <td>{{ tanggal($d->created_at) }}</td>
                  <td>
                  {{$d->sample}}
                  </td>
                </tr>
              @endforeach
      </tbody>

      </table>
      <hr>
      Total Pengunjung: {{ $kunjungan->count() }}</div>
    
</body>

</html>