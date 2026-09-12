<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta name="_token" content="{{ csrf_token() }}"/>
	<title>ANTRIAN APOTEK</title>
	<link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('public/style/bower_components/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
	<link rel="stylesheet" href="{{ asset('public/style/dist/css/skins/_all-skins.min.css') }}">
	<link rel="stylesheet" href="{{ asset('Nivo-Slider/style/style.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('public/style/dist/css/font-gotham.css') }}">
	<link rel="shortcut icon" href="{{ asset('images/logo-ereskita.png') }}">
	<script src="{{ asset('public/js/tanggal.js') }}" charset="utf-8"></script>
	<script src="{{ asset('public/style/bower_components/jquery/dist/jquery.min.js') }}"></script>
	<style type="text/css" media="screen">
		body{
			background-image: url("/public/images/bg-index-1.jpg");
			background-color: #ffffff;
			background-size: cover;
			height: 100%;
			width: 100%;
			font-family: 'Poppins', sans-serif!important;
		}
		.box-loket{
			width:100%;
		}
		.loketheader .text{
			vertical-align:middle;
			display: inline-block;
			line-height: 1.2;
			color:white;
			font-size:32px;
		}
		.loketheader #barcode-registrasi{
			height:60px;
			font-size:20px;
			color:#5a5a5a;
			text-align:center;
			vertical-align:middle;
			display: inline-block;
			line-height: 1.2;
		}
		.loketheader{
			width:450px;
			height:450px;
			background:linear-gradient(90deg, rgba(29, 233, 182, 0.5) 0%, rgba(0,212,255,0.5) 100%);
			-webkit-clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
			clip-path: polygon(50% 0%, 100% 23%, 100% 77%, 50% 100%, 0% 77%, 0% 23%);
			line-height:450px;
			cursor:pointer;
		}
		.loketheader:focus, .loketheader:active{
			background:linear-gradient(90deg, rgba(29, 233, 182, 1) 0%, rgba(0,212,255,1) 100%);
		}
		.section{
			width:100%;
		}
		#nomor-sekarang{
			font-size:70px;
		}
		.header{
			font-size:20px;
			color:white;
			top:0;
			border-radius:0;
			padding:5px;
			width:100%;
			height:auto;
			background:linear-gradient(90deg, rgba(29, 233, 182, 0.5) 0%, rgba(0,212,255,0.5) 100%);
			position:absolute;
		}
	</style>
	<body>
		<div class="header">
			<center>
				ANTRIAN APOTEK & KASIR {{ configrs()->nama }}
				<br>
				<small style="font-size:12px;">{{ date('d M Y') }}</small>
			</center>
		</div>
		<div class="section">
			<div class="box-loket">
				<div class="col-xs-6"><center>
					<div class="loketheader text-center">
						<div class="col-md-12">
							<span class="text">
								PASIEN RAWAT JALAN / POLI
								<input style="margin:20px 0;" class="form-control barcode-registrasi" id="barcode-registrasi" name="barcode_registrasi" value="" placeholder="No. Registrasi / Rekam Medis" autofocus onchange="getDataRegistrasi(this.value);">
								[SCAN BARCODE]
							</span>
						</div>
					</div>
				</div>
				<div class="col-xs-6"><center>
					<div class="loketheader text-center" id="loketheader">
						<div class="col-md-12">							
							<span class="text">
								KHUSUS PASIEN DARI LUAR
								<div id="nomor-sekarang">F1</div>
								[TEKAN]
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="div-print" style="text-align:center;display:none;">
			<center>
				<h5 style="text-align:center;margin:0;font-size:12px;">Antrian Apotek</h5>
				<h4 style="text-align:center;margin:0;font-size:16px;font-weight:bold;">{{ configrs()->nama }}</h4>
				<p style="text-align:center;font-size:11px;margin:0;">Nomor Antrian Anda:</p>
				<h5 style="text-align:center;margin:0;font-size:10px;" id="jenis"></h5>
				<p style="text-align:center;font-size:70pt;margin:0;" id="nomor-antrian"></p>
				<p style="text-align:center;font-size:11px;margin:0;" id="tanggal"></p>
			</center>
		</div>
	</body>
</html>
<script>
var height = (window.screen.height-111);
var width = (window.screen.width-0);
$(".box-loket").css('height',height+'px');
var marginleft = (width-400)/2;
var margintop = (height-380)/2;
$(".box-loket").css('padding-top',margintop+'px');

function getDataRegistrasi(val){
	if(val!=""){
		$.ajax({
			headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			type: 'POST',
			url: '/guest/savetouch-apotek',
			data: { value: val},
			success: function (data) {
				$("#barcode-registrasi").val("");
				$("#barcode-registrasi").focus();
				if(data.status == false) {
					alert(data.message);
				}else if(data.status == true) {
					var jenis = '';
					if(data.message.kelompok=='A' || data.message.kelompok=='C'){ // non racik
						jenis = '(Non Racikan)';
					}else if(data.message.kelompok=='B' || data.message.kelompok=='D'){
						jenis = '(Racikan)';
					}
					$("#jenis").html(jenis);
					$("#nomor-antrian").html(data.message.kelompok+''+data.message.nomor);
					$("#tanggal").html(data.message.time);
					var divToPrint	=	document.getElementById('div-print');
					var newWin			=	window.open('','Print-Window','width=1,height=1,bottom=0,right=0');
					newWin.document.open();
					newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
					newWin.document.close();
					setTimeout(function(){newWin.close();},10);
				}
			}
		});
	}
}

$('#loketheader').on('click', function () {
	$.ajax({
		headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		type: 'POST',
		url: '/guest/savetouch-apotek',
		data: {value: 'bebas'},
		success: function (data) {
			$("#barcode-registrasi").val("");
			$("#barcode-registrasi").focus();
			if(data.status == false) {
				alert(data.message);
			}else if(data.status == true) {
				$("#jenis").html('Penjualan Bebas');
				$("#nomor-sekarang").html(data.message.kelompok+''+(parseInt(data.message.nomor)+1));
				$("#nomor-antrian").html(data.message.kelompok+''+data.message.nomor);
				$("#tanggal").html(data.message.time);
				var divToPrint	=	document.getElementById('div-print');
				var newWin			=	window.open('','Print-Window','width=1,height=1,bottom=0,right=0');
				newWin.document.open();
				newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
				newWin.document.close();
				setTimeout(function(){newWin.close();},10);
			}
		}
	});
});
</script>