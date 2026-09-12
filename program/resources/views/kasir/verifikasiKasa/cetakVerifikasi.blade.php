<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rincian Biaya Perawatan</title>
    <link href="{{ asset('public/css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
    </style>
  </head>
  <body>
    <table style="width:100%; margin-bottom: -10px;">
			<tbody>
				<tr>
					<th style="width:20%">
						<img src="{{ asset('images/'.configrs()->logo) }}" class="img img-responsive text-left" style="width:50px;">
					</th>
					<th class="text-left">
						<h4 style="font-size: 100%;">{{ configrs()->nama }} </h4>
						<p>{{ configrs()->alamat }} {{ configrs()->tlp }} </p>
					</th>
				</tr>
			</tbody>
		</table> 
		<br>
    <hr> 
		<br>

		<table style="width:100%">
			<tbody>
				<tr>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td style="width:25%">Nama / Jenis Kelamin</td> <td>: {{ strtoupper($reg->pasien->nama) }} / {{ $reg->pasien->kelamin }}</td>
				</tr>
				<tr>
					<td>Umur </td> <td>: {{ hitung_umur($reg->pasien->tgllahir) }}</td>
				</tr>
				<tr>
					<td style="width:25%">Nomor Rekam Medis</td> <td>: {{ $reg->pasien->no_rm }}</td>
				</tr>
				<tr>
					<td style="width:25%">Alamat</td> <td>: {{ strtoupper($reg->pasien->alamat) }} {{ strtoupper($reg->pasien->regency_id) }}</td>
				</tr>
				@if (!empty($reg->no_sep))
					<tr>
						<td>No. SEP</td><td>: {{ $reg->no_sep }}</td>
					</tr>
				@endif
				
				@if ( substr($reg->status_reg,0,1) == 'I' )
					<tr>
						<td>Tanggal Perawatan</td><td>: {{ tanggal($irna->tgl_masuk) }} s/d {{ tanggal($irna->tgl_keluar) }}</td>
					</tr>
					<tr>
						<td>Bangsal / BED</td> <td>: {{ baca_kamar($irna->kamar_id) }} / {{ baca_bed($irna->bed_id) }}</td>
					</tr>
					<tr>
						<td>DPJP</td> <td>: {{ baca_dokter($irna->dokter_id) }}</td>
					</tr>
				@else
					<tr>
						<td>Tanggal Registrasi</td><td>: {{ $reg->created_at->format('d-m-Y H:i:s') }}</td>
					</tr>
					<tr>
						<td>Klinik Tujuan</td><td>: {{ strtoupper( baca_poli($reg->poli_id)) }}</td>
					</tr>
					<tr>
						<td>DPJP</td> <td>: {{ baca_dokter($reg->dokter_id) }}</td>
					</tr>
				@endif

			</tbody>
		</table>
		<br>

		<h5 style="text-align: center;">Rincian Biaya Perawatan</h5>
				
		<table class="table table-bordered" style="width: 100%">
			<thead>
				<tr>
					<th class="text-center">No</th>
					<th class="text-center">Nama Tindakan</th>
					<th class="text-center">Biaya@</th>
					<th class="text-center">Qty</th>
					<th class="text-center">Total</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($folio as $d)
					<tr>
						<td class="text-center">{{ $no++ }}</td>
						<td>{{ $d->namatarif }}</td>
						<td class="text-right">{{ number_format($d->total) }}</td>
						<td class="text-center">
							@php
								$tarifx = 0;
								if($d->tarif_id==10000 || $d->tarif_id==20000 || $d->tarif_id==30000){
									$tarifx = 1;
								}elseif($d->total > 0){									
									$settarif = getTotalTarif($reg,$d);
									if($settarif>0){
										$tarifx = ceil($d->total/$settarif);
									}else{
										$tarifx = 1;
									}
								}else{
									$tarifx = 1;
								}
							@endphp
							{{ $tarifx }}
						</td>
						<td class="text-right">{{ number_format($d->total) }}</td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4" class="text-right">Total Biaya Perawatan</th>
					<th class="text-right">{{ number_format($jml) }}</th>
				</tr>
			</tfoot>
		</table>
				
		<p><b><i>Terbilang: {{ terbilang($jml) }} {{ ($jml > 0) ? ' Rupiah' : NULL  }}</i></b></p>

		<table style="width: 100%">
			<tr>
				<td style="width: 50%"></td>
				<td style="width: 50%" class="text-center">
					{{ configrs()->kota }}, {{ date('d-m-Y') }} <br>
					Verifikator <br><br><br>
					<u><b>{{ Auth::user()->name }}</b></u>
				</td>
			</tr>
		</table>
  </body>
</html>
