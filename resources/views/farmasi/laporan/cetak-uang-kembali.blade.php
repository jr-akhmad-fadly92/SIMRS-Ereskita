<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Cetak Pengajuan Uang Kembali</title>
<link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
<style media="screen">	
body{
	font-size: 8pt;
	margin-:0;
}	
@page {
	margin: 5mm 5mm 20mm 5mm;
}
</style>
</head>
<META HTTP-EQUIV="REFRESH" CONTENT="0; URL={{ url()->previous() }}">
<body onload="print()">
	<table style="width:100%;">
		<tbody>
			<tr>
				<td style="margin-bottom:0;width:10%;"><img src="{{ asset('laravel/images/'.configrs()->logo) }}" style="width:40px; margin-right: -20px;"></td>
				<td style="margin-bottom:0;">
					<h4 style="margin-bottom:5px;font-size: 135%; font-weight: bold;">{{ configrs()->nama }}</h4>
					<h4 style="margin:0;font-size: 100%;">{{ configrs()->alamat }}</h4>
				</td>
			</tr>
			<tr style="margin:0;">
				<td colspan=2 style="margin:0;"><hr style="margin:15px 0 10px 0;padding:0;"></td>
			</tr>
		</tbody>
	</table>
	<table style="width:100%">
		<tbody>
			<tr>
				<td colspan="2"><h5 style="text-align:center;font-weight:bold;margin:0;">TANDA BUKTI RETUR OBAT</h5></td>
			</tr>
			<tr>
				<td style="width:25%">NOMOR RM</td> <td>: {{ $reg->pasien->no_rm }}</td>
			</tr>
			<tr>
				<td style="width:25%">NAMA</td> <td>: {{ strtoupper($reg->pasien->nama) }}</td>
			</tr>
			<tr>
				<td style="width:25%">ALAMAT</td> <td>: {{ strtoupper($reg->pasien->alamat) }}</td>
			</tr>
			<tr>
				<td style="width:25%">CARA BAYAR</td> <td>: {{ strtoupper($reg->bayars->carabayar) }}</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top:10px;">Bahwa pasien tersebut diatas telah melakukan retur obat{{($reg->bayar==2) ? ', maka dari itu dengan ini mohon dikembalikan uang sebesar: Rp. '.number_format($uang_kembali) : ''}}</td>
			</tr>
			@if($reg->bayar==2)
			<tr>
				<td colspan="2" style="padding-top:10px;font-weight:bold;">Terbilang: {{terbilang($uang_kembali)}} Rupiah</td>
			</tr>
			@endif
		</tbody>
	</table>
	<table style="width: 100%;margin-top:15px;">
		<tr>
			<td style="width: 50%;" class="text-center">
				Mengetahui,
				<br><br><br><br><br>
				<u>{{ Auth::user()->name }}</u><br>
				<small style="font-size: 8pt;">Petugas Farmasi</small>
			</td>
			<td style="width: 50%;" class="text-center">
				{{ configrs()->kota }}, {{ date('d-m-Y') }}
				<br><br><br><br><br>
				<u>...............................</u><br>
				<small style="font-size: 8pt;">Petugas Kasir</small>
			</td>
		</tr>
	</table>
</body>
</html>
