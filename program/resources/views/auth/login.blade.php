<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.merek') }}</title>
  <link rel="shortcut icon" href="{{ asset('public/images/logo-ereskita.png') }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/style/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/style/bower_components/Ionicons/css/ionicons.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/style/plugins/iCheck/square/blue.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('public/style/dist/css/font-gotham.css') }}">
  <style media="screen">
  .bg-image{
    background-image: url("public/images/bg-index-2.jpg");
    background-color: #ffffff;
	  background-size:cover;
  }
	.login-box-body{
		background:linear-gradient(90deg, rgba(29, 233, 182, 0.5) 0%, rgba(0,212,255,0.5) 100%)!important;
		border-radius:15px;
		padding:30px;
		webkit-box-shadow: 0 4px 13px -10px rgba(76,175,80,.28),0 2px 9px 0 rgba(0,0,0,.12),0 7px 4px -5px rgba(76,175,80,.2)!important;
		box-shadow: 0 4px 13px -10px rgba(76,175,80,.28),0 2px 9px 0 rgba(0,0,0,.12),0 7px 4px -5px rgba(76,175,80,.2)!important;
	}
	.btn-success{
		background:linear-gradient(90deg, #1DE9B6 0%, rgba(0,212,255,1) 100%)!important;
	}
  </style>
</head>
<body class="hold-transition login-page bg-image">
	<div class="login-box">  
		<!-- /.login-logo -->
		<div class="login-box-body">
			<h2 class="text-center" style="color: white; font-weight: bold;margin-top:0px;">@php $config = Modules\Config\Entities\Config::find(1);
			@endphp
			{{ $config->nama }}<br></h2>
			<p class="login-box-msg" style="color: white;">Masuk dengan akun dan kata sandi Anda!</p>
			<form class="form-horizontal" method="POST" action="{{ route('login') }}">
				{{ csrf_field() }}
				<div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
					<div class="col-md-12">
						<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
						@if ($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
					  <div class="col-md-12">
						<input id="password" type="password" class="form-control" name="password" required>
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<button type="submit" class="btn btn-success btn-block btn-flat btn-lg">
							Masuk
						</button>
					</div>
				</div>
			</form>
		</div>
		<!-- /.login-box-body -->
	</div>
</body>
</html>
