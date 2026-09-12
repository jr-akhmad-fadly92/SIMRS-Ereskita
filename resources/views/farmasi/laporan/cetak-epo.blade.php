<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak KPO</title>
    <link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
    <style media="screen">
      body{
        font-size: 10px;
        margin-top: 10px;
        margin-left: 10px;
      }
    </style>
  </head>
	<script>
		setTimeout(function(){
				window.close();
		}, 500);
	</script>
  <body onload="print()">
		@for($i=1; $i<=2; $i++)
		<div style="PAGE-BREAK-BEFORE: always">
			<table style="width:100%;font-size:11px;">
				<tr>
					<td colspan="2" style="text-align:center;font-size:13px;"><b>{{ strtoupper(configrs()->nama) }}</b></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center">{{ configrs()->alamat }} {{ configrs()->kota }}</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center"><hr></td>
				</tr>
				<tr>
					<td style="width:50%;">
						<table style="width:100%;">
							<tr>
								<td>Tanggal</td>
								<td>: {{ date('d-m-Y H:i:s') }}</td>
							</tr>
							<tr>
								<td>No. RM</td>
								<td>: {{ $reg->pasien->no_rm }}</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td>: {{ $reg->pasien->nama }}</td>
							</tr>
							<tr>
								<td>Tgl. Lahir</td>
								<td>: {{ tgl_indo($reg->pasien->tgllahir) }}</td>
							</tr>
						</table>
					</td>
					<td style="width:50%;">
						<table style="width:100%;">
							<tr>
								<td>Ruangan</td>
								<td>: 
									@php
										$ranap = App\Rawatinap::where('registrasi_id', $reg->id)->first();
										echo $ranap->kamar->nama.' / '.$ranap->bed->nama;
									@endphp
								</td>
							</tr>
							<tr>
								<td>Dokter</td>
								<td>: {{ baca_dokter($reg->dokter_id) }}</td>
							</tr>
							<tr>
								<td>SIP</td>
								<td>: {{ $reg->pegawai->sip }}</td>
							</tr>
							<tr>
								<td><b>Alergi</b></td>
								<td>: {{ $permintaan->alergi }}</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr style="background:#ddd;">
					<td colspan="2" style="text-align:center;padding:5px 0;"><b>KARTU PERMINTAAN OBAT</b></td>
				</tr>
				<tr style="background:#f9f9f9;">
					<td><b>Obat Minum</b></td>
					<td><b></b></td>
				</tr>
				@php
					$x = '';
					$jamx = '';
				@endphp
				@if($sort_data_obat_minum!=null)
					@foreach($sort_data_obat_minum as $key => $data_obat)
						@foreach($data_obat as $keyx => $data)
							@php
								$jamx = $keyx;
								if($jamx!=$x){
									$x = $keyx;
								}else{
									$jamx = '';
								}
							@endphp
							@if($jamx != '')
								<tr>
									<td colspan=2>
										<br>
									</td>
								</tr>
							@endif
							<tr>
								<td>
									{{ $jamx }}
								</td>
								<td>
								{{ $data }}
								</td>
							</tr>
						@endforeach
					@endforeach
				@endif
				<tr style="background:#f9f9f9;">
					<td><b>Obat Injeksi</b></td>
					<td><b></b></td>
				</tr>				
				@php
					$x = '';
					$jamx = '';
				@endphp
				@if($sort_data_obat_injeksi!=null)
					@foreach($sort_data_obat_injeksi as $key => $data_obat)
						@foreach($data_obat as $keyx => $data)
							@php
								$jamx = $keyx;
								if($jamx!=$x){
									$x = $keyx;
								}else{
									$jamx = '';
								}
							@endphp
							@if($jamx != '')
								<tr>
									<td colspan=2>
										<br>
									</td>
								</tr>
							@endif
							<tr>
								<td>
									{{ $jamx }}
								</td>
								<td>
								{{ $data }}
								</td>
							</tr>
						@endforeach
					@endforeach
				@endif
				<tr style="background:#f9f9f9;">
					<td><b>Alkes</b></td>
					<td><b></b></td>
				</tr>
				@if($sort_data_obat_alkes!=null)
					@foreach($sort_data_obat_alkes as $key => $data_obat)
						@foreach($data_obat as $keyx => $data)
							<tr>
								<td>
									
								</td>
								<td>
								{{ $data }}
								</td>
							</tr>
						@endforeach
					@endforeach
				@endif
				<tr style="background:#f9f9f9;">
					<td><b>Infus</b></td>
					<td><b></b></td>
				</tr>		
				@php
					$x = '';
					$jamx = '';
				@endphp
				@if($sort_data_obat_infus!=null)
					@foreach($sort_data_obat_infus as $key => $data_obat)
						@foreach($data_obat as $keyx => $data)
							@php
								$jamx = $keyx;
								if($jamx!=$x){
									$x = $keyx;
								}else{
									$jamx = '';
								}
							@endphp
							@if($jamx != '')
								<tr>
									<td colspan=2>
										<br>
									</td>
								</tr>
							@endif
							<tr>
								<td>
									{{ $jamx }}
								</td>
								<td>
								{{ $data }}
								</td>
							</tr>
						@endforeach
					@endforeach
				@endif
				<tr style="background:#ddd;">
					<td style="text-align:center;padding:5px 0;"><b>PENYERAH OBAT</td>
					<td style="text-align:center;padding:5px 0;"><b>PENERIMA OBAT</td>
				</tr>
				<tr>
					<td style="border:solid 1px #ddd;padding:50px 0"></td>
					<td style="border:solid 1px #ddd;padding:50px 0"></td>
				</tr>
			</table>
		</div>
		<br style="PAGE-BREAK-BEFORE: always">
		@endfor
  </body>
</html>
