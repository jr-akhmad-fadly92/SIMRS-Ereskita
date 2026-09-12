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
        line-height: 50%;
      }
    </style>

  </head>
  <body onload="print()" style="margin:0;">
  {{-- <body> --}}
    @foreach ($dataAll as $key => $data)
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <h4 class="text-center" style="font-weight: bold; font-size: 10spt;">
              {{-- {{ strtoupper(configrs()->nama) }} <br> {{ strtoupper(configrs()->alamat) }} --}}
              <b>TRACERT RAWAT JALAN</b>
            </h4>
            <table class="table table-condensed table-borderless">
              <tr>
                <td>Tgl/Jam</td> <td>: {{ $data->created_at->format('d-m-Y H:i:s') }}</td>
              </tr>
              <tr>
                <td>RM. Lama </td> <td>: {{ no_rm($data->pasien->no_rm_lama) }} </td>
              </tr>
              <tr>
                <td>RM. Baru</td> <td>: {{ no_rm($data->pasien->no_rm) }} </td>
              </tr>
              <tr>
                <td>Cara Bayar</td> <td>: {{ baca_carabayar($data->bayar) }} {{ !empty($data->tipe_jkn) ? $data->tipe_jkn : '' }}</td>
              </tr>
              <tr>
                <td>Alamat</td> <td>: {{ $data->pasien->alamat }}</td>
              </tr>
              <tr>
                <td>Pasien</td> <td>: {{ $data->pasien->nama }}</td>
              </tr>
              <tr>
                <th style="font-size:12pt">Klinik</th> <th style="font-size:12pt">: {{ !empty($data->poli_id) ? $data->poli->nama : NULL }}</th>
              </tr>
              <tr>
                <th style="font-size:12pt">Urutan </th> <th style="font-size:12pt">: {{ $data->antrian_poli }}</th>
              </tr>
            </table>
              <br>
            <div class="row">
              <div class="col-md-3 text-center">
              </div>
              <div class="col-md-3 text-center">
              </div>
              <div class="col-md-6 text-center">

              </div>
            </div>
            <br><br>
          </div>
        </div>
      </div>

      @php
        DB::table('registrasis')->where('id', $data->id)->update(['tracer'=>'1']);
      @endphp
    @endforeach

    <META HTTP-EQUIV="REFRESH" CONTENT="{{ $dataAll->count() }}; URL={{ url('/frontoffice/tracerAll') }}">
  </body>
</html>
