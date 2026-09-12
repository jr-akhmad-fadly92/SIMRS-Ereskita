<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Etiket</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
  </head>
  <body onload="print()" style="margin:0;">

      @isset($penjualan->id)
        @php
          $det = App\Penjualandetail::where('penjualan_id', $penjualan->id)->where('cetak', 'Y')->get();
          $no =1;

        @endphp
        @foreach ($det as $key => $d)

              <table class="table">
                  <tr class="text-center">
                    <td>
                      <h4 class="text-center" style="font-weight: bold; text-decoration: underline; margin-bottom: -5px;">Unit Farmasi {{ configrs()->nama }} </h4>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center" style="font-size: 11pt;">
                      <p>
                        <span class="text-left">No. {{ $no++ }} </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="text-right">
                          {{ tgl_indo(date("Y-m-d")) }}
                        </span> <br>

                        <span>
                          {{ strtoupper(\App\Penjualanbebas::where('registrasi_id', $penjualan->registrasi_id)->first()->nama) }}
                         </span> <br style="margin: 5px 0 5px 0;">

                        Obat: {{ $d->masterobat->nama }}
                      </p>


                      <p class="text-center"><b>{{ $d->etiket }}</b><br>
                          {{-- kocok dahulu  --}} <br> <br>
                          <i>Insya Allah Sembuh</i>
                    </p>

                    </td>
                  </tr>
              </table>

        @endforeach

        @if (URL::previous() == url('farmasi/laporan/penjualan'))
          <META HTTP-EQUIV="REFRESH" CONTENT="{{ $det->count() }}; URL={{ URL::previous() }}">
        @else
					<META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('antrian/daftarantrian-apotek/1') }}">
        @endif

      @endisset



  </body>
</html>
