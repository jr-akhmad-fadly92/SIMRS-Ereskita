<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="{{ asset('style/dist/css/font-gotham.css') }}">
    <title>Suara Antrian</title>
    <style type="text/css">
      body{
        background: #f9f9f9;
        font-family: "Gotham Rounded A","Gotham Rounded B",Helvetica,Arial,sans-serif !important;
				margin:0;
      }
    </style>
		@php
		if (isset($antrian)) {
			if($antrian->count() == 1) {
				$delay = 9;
			}elseif ($antrian->count() == 2) {
				$delay = 18; // 9 * 2
			} else {
				$delay = 9;
			}
		}
		@endphp
		<META HTTP-EQUIV="REFRESH" CONTENT="{{ $delay }}; URL={{ url('guest/suara') }}">
    <script src="{{ asset('/public/js/jquery.js') }}"></script>
  </head>
  <body>
		@foreach ($antrian as $key => $d)
			<audio id="song-{{ $start + $no }}" preload class="antrian">
				<source src="/public/audio/nomorurut.mp3" type="audio/mpeg" />
			</audio>
			<audio id="song-{{ $start + $no }}" preload class="antrian">
				<source src="/public/audio/{{ $d->suara }}" type="audio/mpeg" />
			</audio>
			<audio id="song-{{ $start + $no }}" preload class="antrian">
				<source src="/public/audio/diloket.mp3" type="audio/mpeg" />
			</audio>
			<audio id="song-{{ $start + $no }}" preload class="antrian">
				<source src="/public/audio/{{ $d->loket }}.mp3" type="audio/mpeg" />
			</audio>
			@php
				DB::table('antrians')->where('id', $d->id)->update(['panggil' => 1]);
			@endphp
		@endforeach
				
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
  </body>
</html>

