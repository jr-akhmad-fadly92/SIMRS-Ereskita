<!DOCTYPE html>

<html lang="">

<head>

<link rel="stylesheet" href="{{ asset('style/dist/css/font-gotham.css') }}">

<link rel="shortcut icon" href="{{ asset('images/logo-ereskita.png') }}">

<link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">

<style type="text/css">

	body{

		background: #f9f9f9;

		font-family: "Gotham Rounded A","Gotham Rounded B",Helvetica,Arial,sans-serif !important;

		margin:0;

	}

</style>

<script src="{{ asset('/public/js/jquery.js') }}"></script>

</head>

<body>

	<div class="content-info">

		<div style="width:100%;height:100%;">

			<div class="col-md-12 no-padding" id="frame-video" style="height:100%;background:#f9f9f9;">

				<iframe autoplay="true" id="video-live" width="0" height="0" src="https://www.youtube.com/embed/FEJsoBM4Guk?&autoplay=1" allow="autoplay" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"></iframe>

			</div>

		</div>

	</div>

</body>

<script type="text/javascript">

	$('.content-info').css('height',(window.innerHeight-13));

	$('#video-live').attr('height',$('#frame-video').height()+10);

	$('#video-live').attr('width',$('#frame-video').width());

</script>

</html>