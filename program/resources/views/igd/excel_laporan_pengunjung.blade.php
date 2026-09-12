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
    <h3>Laporan Kunjungan Rawat Darurat</h3>

      <table class='table table-bordered'>
        <thead>
          <tr>
            <th style="vertical-align: middle">No</th>
            <th style="vertical-align: middle">Nama</th>
            <th style="vertical-align: middle">No. RM</th>
            <th style="vertical-align: middle">Umur</th>
            <th style="vertical-align: middle">L/P</th>
            <th style="vertical-align: middle">Dokter</th>
            <th style="vertical-align: middle">Cara Bayar</th>
            <th style="vertical-align: middle">Tanggal</th>
            {{-- <th style="vertical-align: middle">Status</th> --}}
            <th style="vertical-align: middle">Petugas</th>
            <th style="vertical-align: middle">Kondisi Pulang</th>
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
              <td>{{ !empty($d->dokter_id) ? baca_dokter($d->dokter_id) : '' }}</td>
              <td>{{ strtoupper(baca_carabayar($d->bayar)) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
              <td>{{ tanggal($d->created_at) }}</td>
              {{-- <td></td> --}}
              <td>{{ App\User::find($d->user_create)->name }}</td>
              <td>{{ baca_carapulang($d->kondisi_akhir_pasien) }}</td>
            </tr>
          @endforeach

        </tbody>
      </table>
      <hr>
    <table width="30%">
     <tr>
     <td>Total Pasien </td><td>:</td><td>{{$total_pasien}} Orang</td>
     </tr>
     <tr>
     <td>Total Pasien Laki-Laki</td><td>:</td><td>{{$total_pasien_laki}} Orang</td>
     </tr>
     <tr>
     <td>Total Pasien Wanita</td><td>:</td><td>{{$total_pasien_wanita}} Orang</td>
     </tr>
     </table>

  </body>
</html>
