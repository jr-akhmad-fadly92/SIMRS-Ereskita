<title>INFORMASI ANTRIAN {{ config('app.nama') }}</title>
<link rel="shortcut icon" href="{{ asset('images/logo-ereskita.png') }}">
<frameset rows="0px,*">
	<frame src="{{url('guest/suara')}}" noresize marginheight="1">
	<frame src="{{url('guest/layarantrian')}}">
</frameset>
