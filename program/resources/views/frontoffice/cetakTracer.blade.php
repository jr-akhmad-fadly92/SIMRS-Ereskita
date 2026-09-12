<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Tracer</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <style media="screen">
      .table-borderless > tbody > tr > td,
      .table-borderless > tbody > tr > th,
      .table-borderless > tfoot > tr > td,
      .table-borderless > tfoot > tr > th,
      .table-borderless > thead > tr > td,
      .table-borderless > thead > tr > th {
          border: none;
      }

      ul, li{
        line-height: 175%;
      }
    </style>

  </head>
  <body onload="print()" style="margin:0;">
  {{-- <body> --}}
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <h5 class="text-center" style="font-weight: bold; font-size: 12pt;">
            {{ strtoupper(configrs()->nama) }} <br> {{ strtoupper(configrs()->alamat) }}
          </h5>
          <hr>
          <table class="table table-condensed table-borderless">
            <tr>
              <td>Tanggal / Jam</td> <td>: {{ $data->created_at->format('d-m-Y H:i:s') }}</td>
            </tr>
            <tr>
              <td>No. Pendaftaran</td> <td>: {{ $data->reg_id }}</td>
            </tr>
            <tr>
              <td>No. Rekam Medis</td> <td>: {{ $data->pasien->no_rm }}</td>
            </tr>
            <tr>
              <td>Cara Bayar</td> <td>: {{ baca_carabayar($data->bayar) }} {{ !empty($data->tipe_jkn) ? $data->tipe_jkn : '' }}</td>
            </tr>
            <tr>
              <td>Nama Pasien</td> <td>: {{ $data->pasien->nama }}</td>
            </tr>
            <tr>
              <td>Poli Tujuan</td> <td>: {{ !empty($data->poli_id) ? $data->poli->nama : NULL }}</td>
            </tr>
            <tr>
              <td>Dokter</td> <td>: {{ baca_dokter($data->dokter_id)}}</td>
            </tr>
            <tr>
              <td>Antrian Poli</td> <td>: {{ $data->antrian_poli }}</td>
            </tr>
          </table>

            <b>Konsultasi: </b>
            <ol>
              <li>...............................................................</li>
              <li>...............................................................</li>
            </ol>

            <b>Tindakan: </b>
            <ol>
              <li>...............................................................</li>
              <li>...............................................................</li>
            </ol>

            <b>Penunjang: </b>
            <ol>
              <li>...............................................................</li>
              <li>...............................................................</li>
            </ol>

            <br>
          <div class="row">
            <div class="col-md-4 text-center">
              KASIR
            </div>
            <div class="col-md-4 text-center">
              PERAWAT ADMIN
            </div>
            <div class="col-md-4 text-center">
              PETUGAS
            </div>
          </div>

        </div>
      </div>
    </div>

  @php
    DB::table('registrasis')->where('id', $data->id)->update(['tracer'=>'1']);
  @endphp


    <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('/frontoffice/tracer') }}">

  </body>
</html>
