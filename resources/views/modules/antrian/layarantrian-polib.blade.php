<!DOCTYPE html>
<html lang="">
<head>
<link rel="stylesheet" href="{{ asset('style/dist/css/font-gotham.css') }}">
<link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
<style type="text/css">
	body{
		background-image: url("/public/images/bg-index-2.jpg");
		
		font-family: "Gotham Rounded A","Gotham Rounded B",Helvetica,Arial,sans-serif !important;
		margin:0;
	}
</style>
@php
$delay = 3;
if(isset($antrian)){			
	if($antrian->count()>0){
		$delay = 9 * $antrian->count();
	}
}
@endphp
<META HTTP-EQUIV="REFRESH" CONTENT="{{ $delay }}; URL={{ url('/guest/layarantrian-polib') }}">
<script src="{{ asset('/public/js/jquery.js') }}"></script>
<style>
	.bg-aqua-active{
		background: linear-gradient(90deg, rgba(29, 233, 182, 0.8) 0%, rgba(0,212,255,0.8) 100%), url("{{ asset('public/images/bg-index-2.jpg') }}") no-repeat fixed !important;
		background-size: cover;
	}
</style>
</head>
<body>
	<div style="padding:5px;">
		@for($i=1; $i<=1; $i++)
			<div class="col-md-12">
				<div class="box box-widget widget-user bg-aqua-active no-margin">
					<div style="text-align:center;padding:5px;">
						<span style="font-size:24px;font-weight:;">RUANG {{ $i }}</span>
						<br>
						@php
							$nomor_antrian = App\AntrianPoli::find(\DB::table('antrian_poli')->where('tanggal',date('Y-m-d'))->where('ruang',$i)->max('id'));
						@endphp						
						<span style="font-size:16px;font-weight:;">{{ ($nomor_antrian!=null) ? baca_dokter($nomor_antrian->registrasi->dokter_id) : '' }}</span>
						<br>						
						<span style="font-size:5em;font-weight:bold;">
							@php
								if($nomor_antrian!=null){
									echo $nomor_antrian->antrian;
								}else{
									echo 0;
								}
							@endphp
						</span>
					</div>
				</div>
			</div>
		@endfor
	</div>
	
	@foreach ($antrian as $key => $d)
		<audio preload class="antrian">
			<source src="/public/audio/nomorurut.mp3" type="audio/mpeg" />
		</audio>
		<audio preload class="antrian">
			<source src="/public/audio/{{ $d->antrian }}.mp3" type="audio/mpeg" />
		</audio>
		<audio preload class="antrian">
			<source src="/public/audio/ruang.mp3" type="audio/mpeg" />
		</audio>
		<audio preload class="antrian">
			<source src="/public/audio/{{ $d->ruang }}.mp3" type="audio/mpeg" />
		</audio>
		@php
			DB::table('antrian_poli')->where('id', $d->id)->update(['status_panggil' => 1]);
		@endphp
	@endforeach			
</body>
<script type="text/javascript">
	jQuery(document).ready(function (){
		var audioArray = document.getElementsByClassName('antrian');
		var i = 0;
		if(audioArray.length>0){
			audioArray[i].play();
			for (i = 0; i < audioArray.length - 1; ++i) {
				audioArray[i].addEventListener('ended', function(e){
					var currentSong = e.target;
					var next = $(currentSong).nextAll('audio');
					if (next.length) $(next[0]).trigger('play');
				});
			}							
		}
	});
</script>
</html>