<title>ANTRIAN POLI {{ config('app.nama') }}</title>
<link rel="shortcut icon" href="{{ asset('public/images/logo-ereskita.png') }}">
<script src="{{ asset('/public/js/jquery.js') }}"></script>
<frameset id="framex" rows="70%,*">
	<frame id="framea" src="{{url('guest/layarantrian-polia')}}" noresize marginheight="0">
	<frame id="frameb" src="{{url('guest/layarantrian-polic')}}" noresize marginheight="0">
</frameset>