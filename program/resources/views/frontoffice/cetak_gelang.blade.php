<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Cetak Gelang</title>
<link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
<style media="print">
.boxs{
	width: 7.5cm;
	height: 2 cm;
	margin: 0.2cm;
	margin-bottom: 0.3cm;
}
.col-md-6{
	width:50%;
	float:left;
}
</style>
</head>
<script>
	setTimeout(function(){
			window.close();
	}, 500);
</script>
<body onload="print()">
	<table style="width: 100%">
		<tbody>
			<tr>
				<td>
					<p style="font-size:9pt;line-height:100%;margin-left:220px" class="text-left">
					{{ $pasien->no_rm }} <br>
					{{ substr($pasien->nama,0,10) }}<br>
					{{ tgl_indo($pasien->tgllahir) }}<br>
					<img src='data:image/png;base64,{{ DNS1D::getBarcodePNG($pasien->no_rm, "C128",1,24,array(1,1,1), true) }}' alt="">
					</p>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>
