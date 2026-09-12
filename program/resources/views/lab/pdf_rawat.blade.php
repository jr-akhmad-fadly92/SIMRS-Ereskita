<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Hasil Lab</title>
    <link href="{{ asset('public/css/pdf.css') }}" rel="stylesheet">
  </head>
	<script>
		setTimeout(function(){
				window.close();
		}, 500);
	</script>
  <body onload="print()" style="padding-top:0px;font-size:11px;">
    <div style="width: 5%; float:left">
      <img src="{{ asset('laravel/images/'.configrs()->logo) }}" class="img img-responsive" style="height:50px;width:auto;">
    </div>
    <div>
      <h6 class="text-center" style="font-size: 13pt; font-weight: bold;">
        {{ strtoupper(configrs()->nama) }}
			</h6>
      <h4 class="text-center" style="font-size: 12pt;font-weight: bold; margin-top: -5px; margin-bottom: 0px;">INSTALASI LABORATORIUM</h4>
      <p class="text-center">
        {{ configrs()->alamat }} {{ configrs()->kota }}
      </p>
      <hr>
    </div>
		<table style="width: 100%">
			<tbody>
				<tr>
					<th style="width: 17%">No. Lab / No. RM</th> <td>: {{ $lab->no_lab }} / {{ $lab->pasien->no_rm }}</td>
					<th style="width: 17%">Nama Dokter</th> <td>: {{ $reg->pegawai->nama }}</td>
				</tr>
				<tr>
					<th>Nama Pasien</th> <td>: {{ $lab->pasien->nama }}</td>
					<th>Tgl Pemeriksaan</th> <td>: {{ tgl_indo($lab->tgl_pemeriksaan) }}</td>
				</tr>
				<tr>
					<th>Alamat</th> <td>: {{ $lab->pasien->alamat }}</td>
					<th>Waktu Sampel</th> <td>: {{ $lab->jam }} / {{ tgl_indo($lab->tgl_bahanditerima) }}</td>
				</tr>
				<tr>
					<th>Tgl Lahir / Kelamin</th> <td>: {{ tgl_indo($lab->pasien->tgllahir) }} / {{ $lab->pasien->kelamin }}</td>
				</tr>

			</tbody>
		</table>
		<hr>
		<table style="width:100%">
			<thead>
				<tr>
					<th colspan="2" class="text-left">PEMERIKSAAN</th>
					<th class="text-left">HASIL</th>
					<th class="text-left">SATUAN</th>
					<!--th class="text-left">NILAI RUJUKAN</th-->
					<th class="text-left">KET</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($rincian as $key => $d)
					<tr>
						<td>
							{{ $d->tarif->nama }}
						</td>
						<td class="text-left">
							{{$d->lh}}
						</td>
						<td class="text-left">
							{{ ($d->hasil) ? number_format($d->hasil,0,'.',',') : '' }}
						</td>
						<td class="text-left">
							{{(isset($d->laboratoria->satuan)) ? $d->laboratoria->satuan : ''}}
						</td>
						<!--td class="text-left">
							{{(isset($d->laboratoria->nilairujukanbawah)) ? $d->laboratoria->nilairujukanbawah : ''}} - {{(isset($d->laboratoria->nilairujukanatas)) ? $d->laboratoria->nilairujukanatas : ''}}
						</td-->
						<td class="text-left">
							{{$d->hasiltext}}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<hr>
		<table style="width: 100%">
			<tbody>
				<tr>
					<td style="width:33%;">{{ ($lab->catatan!=null) ? 'Catatan: '.$lab->catatan : ''}}</td>
					<td style="width:33%;"></td>
					<td style="width:33%;text-align:center;"><i style="font-size:9px;">Dicetak pada: {{ date('m-d-Y H:i:s') }}</i></td>
				</tr>
				<tr>
					<td style="width:33%;"></td>
					<td style="width:33%;"></td>
					<td style="width:33%;text-align:center;">Petugas</td>
				</tr>
				<tr>
					<td style="width:33%;"></td>
					<td style="width:33%;"></td>
					<td style="width:33%;height:100px;text-align:center;">{{ baca_dokter($lab->penanggungjawab) }}</td>
				</tr>
			</tbody>
		</table>
  </body>
</html>
