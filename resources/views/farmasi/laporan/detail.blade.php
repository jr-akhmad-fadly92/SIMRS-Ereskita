<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Rincian Penjualan</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
    <style media="screen">
      body{
        width: auto;
				margin:0;
      }
    </style>
  </head>
	<script>
		setTimeout(function(){
				window.close();
		}, 500);
	</script>
  <body onload="print()">
		<table style="width:100%;" class="no-margin">
			<tr>
				<td style="width:10%;"></td>
				<td>
					<img src="{{ asset('laravel/images/'.configrs()->logo) }}" class="pull-right" style="padding-right:10px;height:40px;">
				</td>
				<td style="text-align:left;">
					<h4 style="font-size: 16px; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>
					{{ configrs()->alamat }}</p>
				</td>
			</tr>
		</table>
		<hr>
		<center><h4>RINCIAN PENJUALAN OBAT</h4></center>
		
		<table style="width:100%;text-align:left;" class="table table-bordered table-condensed">
			<tbody>
				<tr>
					<th>No. RM</th> <td>{{ $reg->pasien->no_rm }}</td>
				</tr>
				<tr>
					<th>Nama </th> <td>{{ $reg->pasien->nama }}</td>
				</tr>
				<tr>
					<th>Tgl Lahir / Umur </th> <td>{{ tgl_indo($reg->pasien->tgllahir) }}  /  {{ hitung_umur($reg->pasien->tgllahir) }}</td>
				</tr>
				<tr>
					<th style="width:25%">Tanggal </th> <td>{{ $penjualan->created_at->format('m-d-y H:i:s') }}</td>
				</tr>
				<tr>
					<th>Nama Dokter </th> <td>{{ baca_dokter($reg->dokter_id) }}</td>
				</tr>
				<tr>
					<th>Pelayanan</th> <td>{{ (isset($reg->poli->nama)) ? $reg->poli->nama : '' }}</td>
				</tr>
			</tbody>
		</table>
		
		<table style="width:100%;" class="table table-bordered">
				<thead>
						<tr>
								<th class="text-center">No</th>
								<th style="text-align:left">Nama Obat</th>
								<th style="text-align:right">Harga</th>
								<th class="text-center">Qty</th>
								<th style="text-align:right">Total</th>
						</tr>
				</thead>
				<tbody>
						@foreach ($detail as $key => $d)
								<tr>
										<td style="text-align:center;">{{ $no++ }}</td>
										<td>{{ $d->masterobat->nama }}</td>
										<td style="text-align:right">{{ number_format( $d->hargajual / $d->jumlah )}}</td>
										<td style="text-align:center;">{{ $d->jumlah }}</td>
										<td style="text-align:right;">{{ number_format( $d->hargajual ) }}</td>
								</tr>
						@endforeach
				</tbody>
				<tfoot>
						<tr>
								<th colspan="4" style="text-align:right;">Total Harga</th>
								<th style="text-align:right;">{{ number_format($total) }}</th>
						</tr>
				</tfoot>
		</table>
		
		<!--
		<p><i><b>Terbilang: {{ terbilang($total) }} Rupiah</b></i></p>
		<div class="pull-right">
			<div class="col-md-4">
				<table style="width:100%;text-align:center;" class="table">
					<tr>
						<td class="text-center">
							Pembeli,
							<br>
							<br>
							<br>
							<br>____________________
						</td>
						<td class="text-center">
							Penerima,
							<br>
							<br>
							<br>
							<br>____________________
						</td>
					</tr>
				</table>
			</div>
		</div>
		<br>
		<br>
		-->
  </body>
</html>
