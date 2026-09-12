<!DOCTYPE html>

<html>

	<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>Nomor Antrian</title>

	<link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

	<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">

	<link rel="stylesheet" href="{{ asset('public/style/dist/css/skins/_all-skins.min.css') }}">

	<link rel="stylesheet" href="{{ asset('public/style/dist/css/font-gotham.css') }}">

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

		#judul{

			height: 60px;

			width: 100%;

			font-size: 20pt;

			font-weight: bold;

			color: #ffffff;

			margin-top: 20px;

			background:linear-gradient(90deg, rgba(29, 233, 182, 0.8) 0%, rgba(0,212,255,0.8) 100%);

			border-radius: 3px;

			padding: 10px 20px;

		}

		.ketersediaan-kamar{

			height: 570px;

			width: 100%;

			/*background:linear-gradient(90deg, rgba(29, 233, 182, 0.5) 0%, rgba(0,212,255,0.5) 100%);*/

			border-radius: 3px;

		}

		.blockloket{

			height: 250px;

			width: 100%;

			margin: 20px auto;

			float: left;

			border-radius: 5px;

			background:linear-gradient(90deg, rgba(29, 233, 182, 0.8) 0%, rgba(0,212,255,0.8) 100%);

		}

		.loketheader{

			background:linear-gradient(90deg, rgba(29, 233, 182, 1) 0%, rgba(0,212,255,1) 100%);

			width: 100%;

			line-height: 65px;

			height: 65px;

			color: white;

			font-weight: bold;

			font-size: 25pt;

			border-bottom: none;

		}

		.logo{

			width: 200px;

			float: left;

			margin-right: 20px;

		}

		.nama{

			font-weight: bold;

			padding-top: 10px;

			font-size: 25pt;

			color: #81C784;

			float: left;



		}

		.alamat{

			font-size: 13pt;

			margin-right: 130px;

		}

		.tanggal{

			font-size: 24px;

			font-weight: bold;

			color: #81C784;

			padding-top: 35px;

		}

		.btn-area{

			padding-top: 10px;

			width: 100%;

			font-family: Verdana;

			color: #ffffff;

			font-size: 80pt;

			letter-spacing: -10px;

			font-weight: bold;

		}

	</style>

	</head>

<body>

<div class="container-fluid">

	<div class="col-md-12">

		<div class="col-md-8">

			<div class="ketersediaan-kamar">

				<div id="judul" class="text-center">

					KETERSEDIAAN KAMAR

				</div>

				<div id="displayBed"></div>

			</div>

		</div>

		<div class="col-md-4">

			<div class="row">

				<div class="col-md-12">

						<div class="blockloket">

								<div class="loketheader text-center">

									LOKET 1

								</div>

								<div class="btn-area text-center">

									<div id="layarlcd"></div>

								</div>

						</div>

				</div>

				<div class="col-md-12">

						<div class="blockloket">

								<div class="loketheader text-center">

									LOKET 2

								</div>

								<div class="btn-area text-center">

									<div id="layarlcd2"></div>

								</div>

						</div>

				</div>

			</div>

		</div>

	</div>

</div>



<script type="text/javascript">

	$(document).ready(function() {

		setInterval(function () {

			$('#displayBed').load("{{ url('/guest/display-bed') }}");

		},2000); //defaul: 10000

	});

</script>



<!-- LOKET 1 -->

<script type="text/javascript">

	$(document).ready(function() {

		setInterval(function () {

			$('#layarlcd').load("{{ route('antrian.datalayarlcd',1) }}");

		},2000); //normal 13000

	});

</script>



<!-- LOKET 2 -->

<script type="text/javascript">

	$(document).ready(function() {

		setInterval(function () {

			$('#layarlcd2').load("{{ route('antrian.datalayarlcd',2) }}");

		},2000); //normal 13000

	});

</script>

</body>