<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laporan Pendapatan</title>
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

    

    <div><h3>Laporan Pendapatan</h3>

    <h5>

      @if ($petugas)

        Petugas: {{ $petugas }},  &nbsp; Periode: {{ $periode }}

      @else

        Semua Petugas, Periode: {{ $periode }}

      @endif



    </h5>



      <table border="1" style="width:100%;">

        <thead>

          <tr style="background-color: #008080;">

          <th style="vertical-align: middle;">#</th>

                <th style="vertical-align: middle;">Tgl / Waktu</th>

                <th style="vertical-align: middle;">No. RM</th>

                <th style="vertical-align: middle;">Nama</th>

                <th style="vertical-align: middle;">Nama Tarif</th>

                <th style="vertical-align: middle;">Cara Bayar</th>

                <th style="vertical-align: middle;">Total</th>

                <th style="vertical-align: middle;">Poli</th>

                <th style="vertical-align: middle;">Nama Dokter</th>

          </tr>

          </thead>

          <tbody>

          @foreach ($pembayaran as $key => $d)

                <tr>

                  <td>{{ $no++ }}</td>

                  

                  <td>{{ tanggal($d->created_at) }}</td>

                  <td>{{ $d->no_rm }}</td>

                  <td>{{ $d->nama }}</td>

                  <td>{{ $d->namatarif }}</td>

                  <td>{{ !empty($d->bayar) ? baca_carabayar($d->bayar) : '' }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>

                  <td>{{ number_format($d->total) }}</td>

                  <td>{{ baca_poli($d->poli_id) }}</td>

                  <td>{{ baca_dokter($d->dokter_id) }}</td>

                

                </tr>

              @endforeach

          </tbody>

         

          <tr>

                <th colspan="6" class="text-right">Total</th>

                <th>{{ number_format($tunai) }}</th>

                <th colspan="6"></th>

              </tr>

              <tr>

                <th colspan="2">Total</th>

                <th colspan="10">{{ number_format($tunai ) }}</th>

              </tr>



              <tr>

                <th colspan="2"><i>Terbilang</i></th>

                <th colspan="10"><i>{{ terbilang($tunai) }} Rupiah</i></th>

              </tr>

            

          </table></div>
    
</body>

</html>