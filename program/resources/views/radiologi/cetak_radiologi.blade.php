<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Radiologi</title>
    <link href="{{ asset('public/css/pdf.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
    <style media="screen">
      body{
        font-family: sans-serif;
        margin-left: auto;
      }
    </style>
  </head>
	<script>
		setTimeout(function(){
				window.close();
		}, 500);
	</script>
  <body onload="print()">
		@if(count($order_radiologi_data)>0)
			@foreach($order_radiologi_data as $key => $datax)
				@php
					$get_hasil = App\Hasilradiologi::where('data_order_radiologi_id',$datax->id)->first();
				@endphp
				<div style="PAGE-BREAK-BEFORE: always">
					<table style="width:100%;margin-bottom:0;" class="no-margin">
						<tr>
							<td style="width:10%;"></td>
							<td>
								<img src="{{ asset('laravel/images/'.configrs()->logo) }}" class="pull-right" style="padding-right:10px;height:40px;">
							</td>
							<td style="text-align:left;">
								<h4 style="font-size: 16px; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>
								<p>{{ configrs()->alamat }} - {{ configrs()->kota }}</p>
							</td>
						</tr>
						<tr>
							<td colspan=3><hr></td>
						</tr>
						<tr>
							<td colspan=3>
								<center>
									<h4 style="margin-top:0;"><b>HASIL {{$datax->tindakanRadiologi->tindakan_radiologi}}</h4>
							</td>
						</tr>
					</table>
					<table style="width: 100%;">
						<tr>
							<td>
								<table style="width: 100%;">
									<tr>
										<td>No. RM</td><td>: {{ $reg->pasien->no_rm }}</td>
									</tr>
									<tr>
										<td>Nama Peserta</td><td>: {{ $reg->pasien->nama }}</td>
									</tr>
									<tr>
										<td>Tgl Lahir</td><td>: {{ tgl_indo($reg->pasien->tgllahir) }}</td>
									</tr>
									<tr>
										<td>Dokter Pengirim</td><td>: {{ baca_dokter($reg->dokter_id) }}</td>
									</tr>
								</table>
							</td>
							<td>
								<table style="width: 100%;">
									<tr>
										<td>No. Foto</td> <td>: <b>{{$datax->no_foto}}</b></td>
									</tr>
									<tr>
										<td>Tanggal</td> <td>: {{date('d/m/Y')}}</td>
									</tr>
									<tr>
										<td>Pemeriksaan</td> <td>: {{$datax->tindakanRadiologiSub->kelompok}}</td>
									</tr>
									<tr>
										@if(substr($reg->status_reg,0,1)=="I")
											<td>Ruang</td> <td>: {{App\Rawatinap::where('registrasi_id',$reg->id)->first()->kamar->nama}}</td>
										@endif
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table style="width:100%;margin-bottom:0;" class="no-margin">
						<tr>
							<td><hr></td>
						</tr>
						<tr>
							<td><b>TS YTH</td>
						</tr>
						<tr>
							<td><b>{{strtoupper($datax->tindakanRadiologiSub->kelompok)}}</td>
						</tr>
						<tr>
							<td>{{(isset($get_hasil->hasil_pemeriksaan)) ? $get_hasil->hasil_pemeriksaan : ''}}</td>
						</tr>
						<tr>
							<td><br></td>
						</tr>
						<tr>
							<td><b>KESAN:</td>
						</tr>
						<tr>
							<td>{{(isset($get_hasil->kesan)) ? $get_hasil->kesan : ''}}</td>
						</tr>
					</table>
					<table style="width:100%;margin-bottom:0;" class="no-margin">
						<tr>
							<td><br><br></td>
						</tr>
						<tr>
							<td style="width:33%"></td>
							<td style="width:33%"></td>
							<td style="width:33%">
								<center>
								Dokter Radiologi
								<br>
								<br>
								<br>
								<br>
								({{(isset($get_hasil->dokter_id)) ? baca_dokter($get_hasil->dokter_id) : ''}})
							</td>
						</tr>
					</table>
				</div>
			@endforeach
		@endif
  </body>
</html>
