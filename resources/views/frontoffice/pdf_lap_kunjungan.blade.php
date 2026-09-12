<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    
  </head>
  <body>
    <h3>Laporan Kunjungan Rawat Jalan</h3>

      <table class='table table-bordered table-condensed'>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No. RM</th>
            <th>Umur</th>
            <th>L/P</th>
            <th>Poli Tujuan</th>
            <th>Dokter</th>
            <th>Cara Bayar</th>
            <th>Rujukan</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($reg as $key => $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->pasien->nama }}</td>
              <td>{{ $d->pasien->no_rm }}</td>
              <td>{{ hitung_umur($d->pasien->tgllahir, 'Y') }}</td>
              <td>{{ $d->pasien->kelamin }}</td>
              <td>{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td>
              <td>{{ !empty($d->dokter_id) ? $d->dokter->nama : '' }}</td>
              <td>{{ !empty($d->bayar) ? strtoupper(baca_carabayar($d->bayar)) : '' }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
              <td>{{ !empty($d->rujukan) ? Modules\Rujukan\Entities\Rujukan::find($d->rujukan)->nama : '' }}</td>
              <td>{{ tanggal($d->created_at) }}</td>
            </tr>
          @endforeach

        </tbody>
      </table>

  </body>
</html>
