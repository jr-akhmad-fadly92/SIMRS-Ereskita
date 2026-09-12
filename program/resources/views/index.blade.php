<!DOCTYPE html>
<html>
<head>
<title>ERESKITA - SISTEM INFORMASI RUMAH SAKIT</title>

<link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/style/dist/css/font-gotham.css') }}">
<link rel="shortcut icon" href="{{ asset('public/images/logo-ereskita.png') }}">
<style>
body{
	background-image: url("public/images/bg-index-4.jpg");
	background-color: #ffffff;
	background-size: cover;
	font-family: "Gotham Rounded A","Gotham Rounded B",Helvetica,Arial,sans-serif !important;
}
.box-body{
	width:100%;
	height:100%;
}
.box-left{
	width:70%;
	height:auto;
	float:left;
	margin-top:3%;
	margin-left:10%;
}
.box-right{
	width:35%;
	right:0;
	height:auto;
	position:absolute;
	margin-top:11%;
	margin-right:0%;
}
.box{
	width:auto;
	height:auto;
	padding:10px 30px;
	background:rgba(255,255,255,0);
	box-sizing: border-box;
}
.heptagon .text{
	color:white;
	font-size:16px;
	margin:auto;
	vertical-align:middle;
	display: inline-block;
	line-height: 1.2;
}
.heptagon .text:hover{
	color:#707070;
}
.heptagon:hover{
	background:linear-gradient(90deg, rgba(255,255,255,0.4) 0%, rgba(0,212,255,0.04) 100%);
	cursor:pointer;
}
.heptagon{
	height:125px;
	width:120px;
	-webkit-clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
	clip-path: polygon(50% 0%, 100% 23%, 100% 77%, 50% 100%, 0% 77%, 0% 23%);
	background:rgb(102,187,106);
	background:linear-gradient(90deg, rgba(29, 233, 182, 0.5) 0%, rgba(0,212,255,0.5) 100%);
	margin:7px 10px;
	float:left;
	line-height:125px;
}
.heptagon-hidden{
	height:125px;
	width:120px;
	-webkit-clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
	clip-path: polygon(50% 0%, 100% 23%, 100% 77%, 50% 100%, 0% 77%, 0% 23%);
	background:rgba(255,255,255,0);
	margin:7px 10px;
	float:left;
	line-height:125px;
}
.heptagon-right{
	height:330px;
	width:300px;
	-webkit-clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
	clip-path: polygon(50% 0%, 100% 23%, 100% 77%, 50% 100%, 0% 77%, 0% 23%);
	background:rgb(102,187,106);
	background:linear-gradient(90deg, rgba(29, 233, 182, 0.4) 0%, rgba(0,212,255,0.5) 100%);
	margin:5px;
	position:absolute;
	color:white;
	line-height: 330px;
}
.heptagon-right h1{
	margin:0;
	line-height: 1.5;
	vertical-align:middle;
	display: inline-block;
}
.box::after {
	clear:both;
	display: table;
	content: "";
}
</style>
</head>

<body>
	<center>
		<div class="box-body">
			<div class="box-left">
				<div class="box">
					<a href="{{ url('/login') }}">
						<div class="heptagon-hidden">
							
						</div>
						<div class="heptagon-hidden">
							
						</div>
						<div class="heptagon">
							<div class="text">Administrator</div>
						</div>
						<div class="heptagon">
							<div class="text">Antrian</div>
						</div>
						<div class="heptagon">
							<div class="text">Rekam Medis</div>
						</div>
						<div class="heptagon">
							<div class="text">Rawat Jalan</div>
						</div>
						<div class="heptagon">
							<div class="text">Rawat Inap</div>
						</div>
						<div class="heptagon">
							<div class="text">Rawat Darurat</div>
						</div>
						<div class="heptagon">
							<div class="text">Laboratorium</div>
						</div>
						<div class="heptagon">
							<div class="text">Radiologi</div>
						</div>
						<div class="heptagon">
							<div class="text">Operasi</div>
						</div>
						<div class="heptagon-hidden">
							
						</div>
						<div class="heptagon">
							<div class="text">Admisi</div>
						</div>
						<div class="heptagon">
							<div class="text">Gizi</div>
						</div>
						<div class="heptagon">
							<div class="text">Apotek</div>
						</div>
						<div class="heptagon">
							<div class="text">Kasir</div>
						</div>
						<div class="heptagon">
							<div class="text">BPJS Bridging</div>
						</div>
					</a>
					<a href="#">
						<div class="heptagon-hidden">
							
						</div>
						<div class="heptagon-hidden">
							
						</div>
						<div class="heptagon-hidden">
							
						</div>
						<div class="heptagon">
							<div class="text">Logistik</div>
						</div>
						<div class="heptagon">
							<div class="text">Jasa Pelayanan</div>
						</div>
						<div class="heptagon">
							<div class="text">Pendaftaran Online</div>
						</div>
						<div class="heptagon">
							<div class="text">Informasi Ketersediaan Kamar</div>
						</div>
					</a>
				</div>
			</div>
			
			<div class="box-right">
				<div class="box">
					<div class="heptagon-right">
							<img src="public/images/logo-ereskita.png" style="width:100px;height:100px;padding:10px;background:white;border-radius:50%;">
						<h1>ERESKITA</h1>
					</div>
				</div>
			</div>
		</div>
	</center>
</body>
</html>