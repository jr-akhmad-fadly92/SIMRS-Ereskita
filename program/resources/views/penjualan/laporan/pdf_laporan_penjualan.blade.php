<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laporan Penjualan Apotik</title>
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

    

    <div><h3>Laporan Penjualan Apotik</h3>

    <h4>Periode: {{ $tga }} s/d {{ $tgb }}</h4>

    <div class="table-responsive">
          <table border=1 class="table table-hover table-condensed table-bordered">
            <thead>
              <tr style="background-color: #00FFFF;">
                <th></th>
                <th>JKN</th>
                <th>NON JKN</th>
                <th>TOTAL</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>Penjualan</th>
                <td>{{ $jkn->count() }}</td>
                <td>{{ $penjualan->count() - $jkn->count() }}</td>
                <td>{{ $penjualan->count() }}</td>
              </tr>
              <tr>
                <th>Total</th>
                <td>{{ number_format( $jkn->sum('total') ) }}</td>
                <td>{{ number_format($penjualan->sum('total') - $jkn->sum('total')) }}</td>
                <td>{{ number_format($penjualan->sum('total')) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <br>
          <div class="table-responsive">
            <table border=1 class="table table-hover table-bordered table-condensed" id="dataPenjualan">
              <thead>
                <tr style="background-color: #00FFFF;">
                  <th>No</th>
                  <th>No. Faktur</th>
                  <th>Nama Pasien</th>
                  <th>No. RM</th>
                  <th class="text-center">Total</th>
                  <th>Jenis Pasien</th>
                  <th class="text-center">Tanggal</th>
                  <th>User</th>
                
                </tr>
              </thead>
              <tbody>
                @if ($penjualan->count() < 3000)
                  @foreach ($penjualan as $d)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $d->namatarif }}</td>
                        <td>{{ $d->pasien_id == 0 ? 'Pasien Langsung' : $d->pasien->nama }}</td>
                        <td>{{ $d->pasien_id == 0 ? 'Pasien Langsung' : $d->pasien->no_rm }}</td>
                        <td class="text-right">{{ number_format($d->total) }}</td>
                        <td class="text-center">{{ !empty($d->cara_bayar_id) ? baca_carabayar($d->cara_bayar_id) : 'Penjualan Langsung' }}</td>
                        <td class="text-right">{{ $d->created_at->format('d-m-Y') }}</td>
                        <td>{{ App\User::find($d->user_id)->name }}</td>
                       
                      </tr>
                  @endforeach
                @else
                  <tr>
                    <th class="text-center" colspan="8">Data lebih dari 3000 tidak bisa di tampilkan</th>
                  </tr>
                @endif
                
              </tbody>
            </table>
          </div>
    
</body>

</html>