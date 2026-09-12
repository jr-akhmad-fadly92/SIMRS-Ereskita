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



    <h3>Laporan Naik Kelas</h3>

    <h5>

      @if ($petugas)

        &nbsp; Periode: {{ $periode }}

      @else

         Periode: {{ $periode }}

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

                <th style="vertical-align: middle;">Kelas Awal</th>

                <th style="vertical-align: middle;">Naik Kelas</th>

                

                </tr>

            </thead>

            <tbody>

            @foreach ($pembayaran as $key => $d)

              

                  

              <tr>

              <td>{{ $no++ }}</td>

              <td>{{ $d->created_at }}</td>

              <td>{{ $d->no_rm }}</td>

              <td>{{ $d->reg_id }}</td>

              <td>{{ $d->nama }}</td>

              <td>{{ baca_kelas($d->hak_kelas_inap) }}</td>

              <td>{{ baca_kelas($d->is_naik_kelas) }}</td>

              

            </tr>

                

               

          @endforeach

            </tbody>

            <tfoot>

             

            </tfoot>

          </table>

          </div>



  </body>

</html>

