<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak KIUP</title>
    <link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
    <style media="screen">
			@page {
          margin-top: 1cm;
          margin-left: 3cm;
          margin-right: 3cm;
      }
      .table tr td, .table tr th{
          border: none;
					text-align:left;
      }
    </style>
  </head>
	<script>
		setTimeout(function(){
				window.close();
		}, 500);
	</script>
  <body onload="window.print()">
    <div class="row">
      <div class="col-sm-12 text-center">
        <h4><b>{{ strtoupper( config('app.name') ) }} </b></h4>
        <h5>{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</h5>
        <hr>
          <h5><b>IDENTITAS PASIEN</b></h5>
        <hr> <br>
        <b>NO. REKAM MEDIK <br> {{ no_rm($pasien->no_rm) }} </b><br> <br> <br>

        <table class="table no-border">
          <tr>
            <td style="text-align:left;">Nama</td> <td style="text-align:left;">: {{ $pasien->nama }}</td>
          </tr>
          
          <tr>
            <td style="text-align:left;">No. NIK</td> <td style="text-align:left;">: {{ $pasien->nik }}</td>
          </tr>
          <tr>
            <td style="text-align:left;">Jenis Kelamin</td> 
            <td style="text-align:left;">: 
              @if ($pasien->kelamin == 'L')
                Laki - Laki
              @elseif ($pasien->kelamin == 'P')
                Perempuan
              @endif
            </td>
          </tr>
          <tr>
            <td style="text-align:left;">Tempat Lahir</td> <td style="text-align:left;">: {{ $pasien->tmplahir }}</td>
          </tr>
          <tr>
            <td style="text-align:left;">Tanggal Lahir</td> <td style="text-align:left;">: {{ tgl_indo($pasien->tgllahir) }}</td>
          </tr>
          
          <tr>
            <td style="text-align:left;">Alamat</td> <td style="text-align:left;" colspan="3">: {{ $pasien->alamat }} RT {{ $pasien->rt }} RW {{ $pasien->rw }}</td>
          </tr>
          <tr>
            <td style="text-align:left;">Propinsi</td> <td style="text-align:left;">: {{ baca_propinsi($pasien->province_id) }}</td>
            <td style="text-align:left;">Kodya/Kabupaten</td> <td style="text-align:left;">: {{ baca_kabupaten($pasien->regency_id) }}</td>
          </tr>
          <tr>
            <td style="text-align:left;">Kecamatan</td> <td style="text-align:left;">: {{ baca_kecamatan($pasien->district_id) }}</td>
            <td style="text-align:left;">Kelurahan</td> <td style="text-align:left;">: {{ baca_kelurahan($pasien->village_id) }}</td>
          </tr>
          <tr>
            <td style="text-align:left;">No. HP/Telp.</td> <td style="text-align:left;">: {{ $pasien->nohp }}</td>
          </tr>
          <tr>
            <td style="text-align:left;">Status</td> <td style="text-align:left;">: {{ $pasien->status_marital }}</td>
            <td style="text-align:left;">Agama</td> <td style="text-align:left;">: {{ Modules\Pasien\Entities\Agama::find($pasien->agama_id)->agama }}</td>
          </tr>
          <tr>
            <td style="text-align:left;">Pendidikan</td> <td style="text-align:left;">: {{ Modules\Pendidikan\Entities\Pendidikan::find($pasien->pendidikan_id)->pendidikan }}</td>
            <td style="text-align:left;">Pekerjaan</td> <td style="text-align:left;">: {{ Modules\Pekerjaan\Entities\Pekerjaan::find($pasien->pekerjaan_id)->pekerjaan }}</td>
          </tr>
          <tr>
            <td style="text-align:left;">Nama Ibu Kandung </td> <td style="text-align:left;">: {{ $pasien->ibu_kandung }}</td>
          </tr>          
        </table>
        <hr>
      </div>
    </div>    
  </body>
</html>
