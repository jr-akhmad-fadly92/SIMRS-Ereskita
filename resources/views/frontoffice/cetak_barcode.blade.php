<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Cetak Barcode</title>
<link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
<style media="print">
.boxs{
	width: 15cm;
	height: 2 cm;
	margin: 0;
	font-size:15px;
}
.col-md-6{
	width:50%;
	float:left;
	padding-left:40px;
}
</style>
</head>
<script>
	setTimeout(function(){
		window.close();
	}, 500);
</script>
<body onload="print()">
	<div class="boxs">
		<div class="row">
			<div class="col-md-6">
				<div style="font-weight:bold;"> {{ strtoupper($pasien->nama) }} </div>
				<b>{{ no_rm($pasien->no_rm) }} / {{ $pasien->kelamin }}</b> <br>
				<div>
					{{ tgl_indo($pasien->tgllahir) }} / {{ hitung_umur($pasien->tgllahir,'') }} <br>
				</div>
				<div class="text-left">
					<img src='data:image/png;base64,{{ DNS1D::getBarcodePNG($pasien->no_rm, "C128",1,18,array(1,1,1), true) }}' alt="">
				</div>
			</div>
			<div class="col-md-6">
				<div style="font-weight:bold;"> {{ strtoupper($pasien->nama) }} </div>
				<b>{{ no_rm($pasien->no_rm) }} / {{ $pasien->kelamin }}</b> <br>
				<div>
					{{ tgl_indo($pasien->tgllahir) }} / {{ hitung_umur($pasien->tgllahir,'Y') }} <br>
				</div>
				<div class="text-left">
					<img src='data:image/png;base64,{{ DNS1D::getBarcodePNG($pasien->no_rm, "C128",1,18,array(1,1,1), true) }}' alt="">
				</div>
			</div>
		</div>
	</div>
</body>
</html>
