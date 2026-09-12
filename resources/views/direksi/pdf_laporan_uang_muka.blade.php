<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Data PDF</title>

    <link href="{{ asset('/laravel/css/pdf.css') }}" rel="stylesheet">



  </head>

  <body>



    <h3>Laporan Uang Muka</h3>

    <h5>

      @if ($petugas)

        Petugas: {{ $petugas }},  &nbsp; Periode: {{ $periode }}

      @else

        Semua Petugas, Periode: {{ $periode }}

      @endif



    </h5>

    <div class='table-responsive'>

      <table class='table table-striped table-bordered table-hover table-condensed'>

        <thead>

          <tr class="info">

          <th style="vertical-align: middle;">#</th>

                <th style="vertical-align: middle;">Tgl / Waktu</th>

                <th style="vertical-align: middle;">No RM</th>

                <th style="vertical-align: middle;">No. Registrasi</th>

                <th style="vertical-align: middle;">Nama Pasien</th>

                <th style="vertical-align: middle;">Penitip</th>

                <th style="vertical-align: middle;">No Hp penitip</th>

                <th style="vertical-align: middle;">Total</th>

                <th style="vertical-align: middle;">Kasir</th>

          </tr>

        </thead>

        <tbody>

        @foreach ($pembayaran as $key => $d)

              

                  

              <tr>

              <td>{{ $no++ }}</td>

              <td>{{ $d->updated_at }}</td>

              <td>{{ $d->pasien_id }}</td>

              <td>{{ $d->reg_id }}</td>

              <td>{{ $d->nama }}</td>

              <td>{{ $d->penitip }}</td>

              

              <td>{{ $d->no_hp }}</td>

              <td>{{ number_format($d->total) }}</td>

              <td>{{ $d->updated_by }}</td>

              

            </tr>

                

               

          @endforeach

        </tbody>

        <tfoot>

          <tr>

            <th colspan="7" class="text-right">Total</th>

            <th class="text-right">{{ number_format($tunai) }}</th>

         

            <th colspan="6"></th>

          </tr>

          <tr>

            <th colspan="2">Total</th>

            <th colspan="10">Rp. {{ number_format($tunai) }}</th>

          </tr>



          <tr>

            <th colspan="2"><i>Terbilang</i></th>

            <th colspan="10"><i>{{ terbilang($tunai) }} Rupiah</i></th>

          </tr>

        </tfoot>

      </table>

    </div>



  </body>

</html>

