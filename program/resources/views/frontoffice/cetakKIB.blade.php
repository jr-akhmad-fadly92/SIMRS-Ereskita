<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Cetak KIB</title>
	<link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
	<style media="print">
	@page {
		width: 9.5cm;
		height: 5cm;
		margin-left: 0.1cm;
		margin-top: 0.1cm;
	}
	.boxs{
		width: 10cm;
		padding: 3cm 1cm 0.5cm 0.5cm;
		height: 2.5cm;
		margin: 0.2cm;
		margin-bottom: 0.3cm;
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
		<div style="font-weight:bold; font-weight: 16pt;" class="text-right"> {{ ($status=='baru') ? strtoupper($pasien->nama) : '' }} </div>
		<div class="text-right"><b>{{ ($status=='baru') ? no_rm($pasien->no_rm) : '' }}</div>
		<div class="text-right"><b>{{ ($status=='baru') ? tgl_indo($pasien->tgllahir) : '' }}</div>
		<div class="text-right">
			<img style="margin-top:10px;margin-left:12px;" src="data:image/png;base64,{{ DNS1D::getBarcodePNG($pasien->no_rm, "C128",1,24,array(1,1,1), true) }}" alt="">
		</div>
	</div>
</body>
</html>
