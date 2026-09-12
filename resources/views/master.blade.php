<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.merek') }} | @php $config = Modules\Config\Entities\Config::find(1);
      @endphp
      {{ $config->nama }}</title>
  
	<meta name="_token" content="{{ csrf_token() }}"/>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">  
  <link rel="shortcut icon" href="{{ asset('public/images/logo-ereskita.png') }}">
  <link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!--link rel="stylesheet" href="{{ asset('public/style/bower_components/font-awesome/css/font-awesome.min.css') }}"-->
  <!--link rel="stylesheet" href="{{ asset('public/style/bower_components/font-awesome-v2/css/all.min.css') }}"-->
  <!--link rel="stylesheet" href="{{ asset('public/style/bower_components/font-awesome-v2/css/brands.min.css') }}"-->
  <link rel="stylesheet" href="{{ asset('public/style/bower_components/font-awesome-v2/css/fontawesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/style/bower_components/font-awesome-v2/css/regular.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/style/bower_components/font-awesome-v2/css/solid.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/style/bower_components/font-awesome-v2/css/v4-shims.min.css') }}">
	
  <!--link rel="stylesheet" href="{{ asset('public/style/bower_components/Ionicons/css/ionicons.min.css') }}"-->
  <link rel="stylesheet" href="{{ asset('public/style/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('public/style/bower_components/select2/dist/css/select2.css') }}">
  <link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/style/dist/css/skins/_all-skins.min.css') }}">
  <!--link rel="stylesheet" href="{{ asset('public/style/dist/css/font-gotham.css') }}"-->
  <!--link rel="stylesheet" href="{{ asset('public/style/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}"-->
  <link rel="stylesheet" href="{{ asset('public/css/jquery.timepicker.min.css') }}">
  <!--link rel="stylesheet" href="{{ asset('public/css/fSelect.css') }}"-->
  <link rel="stylesheet" href="{{ asset('public/style/plugins/iCheck/flat/blue.css') }}">
  <link rel="stylesheet" href="{{ asset('public/style/plugins/iCheck/all.css') }}">  
  <style type="text/css" media="screen">
	body{
		font-size:12px;
		color:#5a5a5a !important;
	}
	.bg-pink{
		background:#F06292!important;
		color:white;
	}
	.bg-pink:hover,.bg-pink:active,.bg-pink:focus{
		color:white;
	}
  .form-group{
		margin-bottom: 5px;
  }
	.sidebar-menu li.header {
		padding: 10px 25px 10px 15px;
		font-size: 11px;
	}
	.datepicker {
		z-index: 1030!important;
	}
	.bg-aqua-active{
		background: linear-gradient(90deg, rgba(29, 233, 182, 0.8) 0%, rgba(0,212,255,0.8) 100%), url("{{ asset('public/images/bg-index-2.jpg') }}") no-repeat fixed !important;
		background-size: cover;
	}
	.skin-green-light .main-header{
		webkit-box-shadow: 1px 0px 5px rgba(0, 0, 0, 0.08);
    -moz-box-shadow: 1px 0px 5px rgba(0, 0, 0, 0.08);
    box-shadow: 1px 0px 5px rgba(0, 0, 0, 0.08);
	}
	.skin-green-light .main-header .navbar{
		background-color: #fff; /*#f4f7fb;*/
	}
	.bg-primary, .user-header, .btn-success, .btn-info, .btn-primary, .bg-gradient{
		background:linear-gradient(90deg, rgba(29, 233, 182, 0.8) 0%, rgba(0,212,255,0.8) 100%)!important;
	}
	.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover{
		border-color: #1DE9B6;
		background:linear-gradient(90deg, rgba(29, 233, 182, 1) 0%, rgba(0,212,255,1) 100%)!important;
	}
	.bg-gradient{
		color:white;
	}
	.widget-user .widget-user-header{
		height:auto!important;
	}
	.widget-user .widget-user-header, .box{
		border-radius:8px!important;
	}
	.form-control {
		border-radius: 4px;
	}
	.form-control, .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single, .chosen-container-single .chosen-single, .chosen-container .chosen-drop, .input-group-btn>.btn {
		border: 2px solid #eee!important;
		border-radius: 4px!important;
		box-shadow:none!important;
	}
	.form-control:focus, .select2-container--default .select2-selection--single:focus, .select2-selection .select2-selection--single:focus, .chosen-container-single .chosen-single:focus, .chosen-container-active.chosen-with-drop .chosen-single {
		border-color: #1DE9B6!important;
		box-shadow:none!important;
	}
	form{
		margin-bottom:0;
	}
	.skin-green-light .sidebar-menu .treeview-menu>li>a {
		color: rgba(0, 0, 0, 0.87);
	}
	.skin-green-light .main-header .navbar .sidebar-toggle:hover {
		background-color: transparent;
	}
	.treeview-menu>li>a, .chosen-container, .form-control, btn{
		font-size:12px!important;
	}
	.box-header>.fa, .box-header>.glyphicon, .box-header>.ion, .box-header .box-title{
		font-size:16px!important;
	}
	h1{
		font-size:20px!important;
	}
	h5{
		font-size:12px!important;
	}
	table {
		font-size: 90%;
		color:#5a5a5a;
	}
	.btn-flat{
		border-radius:15px!important;
	}
	.btn{
		font-weight:600;
	}
	.treeview-menu>li>a {
		padding: 8px 5px 8px 15px!important;
	}
	.skin-green-light .sidebar-menu>li>.treeview-menu {
		background: transparent;
		padding-bottom: 5px;
	}
	.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td{
		vertical-align:middle;
	}
	.modal-content{
		border-radius:10px!important;
	}
	.badge-danger{
			background-color: #FF0000	;
		}
	.badge-success{
			background-color: #00FF00	;
		}
	.badge-warning{
			background-color: #FFA500	;
		}
	.badge-primary{
			background-color: #0000FF	;
		}
		input:focus{
        outline: none;
		}
		.slider {
			-webkit-appearance: none;
			--range: calc(var(--max) - var(--min));
			--ratio: calc((var(--val) - var(--min))/var(--range));
			--sx: calc(.5*1.5em + var(--ratio)*(100% - 1.5em));
			margin: 0;
			padding: 0;
			width: 100%;
			height: 1.5em;
			background: transparent;
			font: 1em/1 arial, sans-serif;
			border: none;
		}
		.slider, .slider::-webkit-slider-thumb {
			-webkit-appearance: none;
		}
		.slider::-webkit-slider-runnable-track {
			box-sizing: border-box;
			border: none;
			width: 12.5em;
			height: 0.5em;
			background: #ccc;
		}
		.js .slider::-webkit-slider-runnable-track {
			background: linear-gradient(#1E90FF, #1E90FF) 0/var(--sx) 100% no-repeat #ccc;
		}
		.slider::-moz-range-track {
			box-sizing: border-box;
			border: none;
			height: 0.5em;
			background: #ccc;
		}
		.slider::-ms-track {
			box-sizing: border-box;
			border: none;
			width: 12.5em;
			height: 0.5em;
			background: #ccc;
		}
		.slider::-moz-range-progress {
			height: 0.5em;
			background: #1E90FF;
		}
		.slider::-ms-fill-lower {
			height: 0.5em;
			background: #1E90FF;
		}
		.slider::-webkit-slider-thumb {
			margin-top: -0.550em;
			box-sizing: border-box;
			border: none;
			width: 1.5em;
			height: 1.5em;
			border-radius: 50%;
			background: #1E90FF;
		}
		.slider::-moz-range-thumb {
			box-sizing: border-box;
			border: none;
			width: 1.5em;
			height: 1.5em;
			border-radius: 50%;
			background: #1E90FF;
		}
		.slider::-ms-thumb {
			margin-top: 0;
			box-sizing: border-box;
			border: none;
			width: 1.5em;
			height: 1.5em;
			border-radius: 50%;
			background: #1E90FF;
		}
		.slider::-ms-tooltip {
			display: none;
		}
		#tickmarks {
			display: flex;
			justify-content: space-between;
			padding: 0 10px;
		}

		#tickmarks p {
			position: relative;
			display: flex;
			justify-content: center;
			text-align: center;
			width: 1px;
			background: #D3D3D3;
			height: 10px;
			line-height: 40px;
			margin: 0 0 20px 0;
		}
  </style>
  <script>
      function sum() {
      var satu = document.getElementById('tarif_tindakan_perawat').value;
      var dua = document.getElementById('tarif_tindakan_dokter').value;
      var tiga = document.getElementById('tarif_jasa_rumah_sakit').value;
      var result = parseInt(satu) + parseInt(dua) + parseInt(tiga);
      if (!isNaN(result)) {
         document.getElementById('tarif_kelas_rj').value = result;
      }
}
</script>
</head>
<!-- hold-transition skin-green-light sidebar-mini fixed -->
<!-- skin-green-light sidebar-mini fixed sidebar-mini-expand-feature sidebar-collapse -->
@php
	$class="sidebar-collapse";
	if(strtolower(Auth::user()->role()->first()->name)=='admission' || strtolower(Auth::user()->role()->first()->name)=='administrator'){
		$class="";
	}
@endphp

<body class="hold-transition skin-green-light sidebar-mini {{ $class }} fixed">
	@php
		$marginobat = App\MarginHargaObat::find(1);
	@endphp
	<input type="hidden" value="{{$marginobat->rawatinap}}" id="obatri">
	<input type="hidden" value="{{$marginobat->rawatjalan}}" id="obatrj">
	<div class="wrapper">
		<header class="main-header">
			@include('header')
		</header>
		<aside class="main-sidebar">
			@include('sidebar')
		</aside>
		<div class="content-wrapper">
			<section class="content">
				@yield('content')
			</section>
		</div>
		<div class="control-sidebar-bg"></div>
	</div>
	<input type="hidden" value="{{ strtolower(Auth::user()->role()->first()->name) }}" id="userrole">
</body>
<script src="{{ asset('public/style/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('public/js/jquery-ui.js') }}"></script>

<script src="{{ asset('public/style/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/style/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!--script src="{{ asset('public/style/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('public/style/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('public/style/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<script src="{{ asset('public/style/bower_components/moment/min/moment.min.js') }}"></script-->
<script src="{{ asset('public/style/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('public/style/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!--script src="{{ asset('public/style/bower_components/select2/dist/js/select2.full.min.js') }}"></script-->
<script src="{{ asset('public/style/bower_components/select2/dist/js/select2.min.js') }}"></script>
<!--script src="{{ asset('public/style/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script-->
<script src="{{ asset('public/style/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('public/style/bower_components/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('public/style/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('public/style/dist/js/demo.js') }}"></script>
<script src="{{ asset('public/style/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/style/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('public/style/plugins/iCheck/icheck.min.js') }}"></script>

@if(in_array(Route::currentRouteName(),['dashboard','home']))
<script src="{{ asset('public/style/bower_components/Flot/jquery.flot.js') }}"></script>
<script src="{{ asset('public/style/bower_components/Flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('public/style/bower_components/Flot/jquery.flot.categories.js') }}"></script>
@php
	$poli = App\HistorikunjunganIRJ::select('poli_id')->where('created_at', 'LIKE', date('Y-m-d').'%')->where('poli_id', '<>', '')->distinct()->get();
@endphp
<script type="text/javascript">
  $( function() {
    var bar_data = {
        //data : [['January', 10], ['February', 8], ['March', 4], ['April', 13], ['May', 17], ['June', 9]],
        data : [
          @foreach ($poli as $r)
            ['{{ baca_poli($r->poli_id) }}', {{ pasien_perpoli(date('Y-m-d'), $r->poli_id) }}],
          @endforeach
        ],
        color: '#40c4ff'
      }
      $.plot('#bar-chart', [bar_data], {
        grid  : {
          borderWidth: 1,
          borderColor: '#f3f3f3',
          tickColor  : '#f3f3f3'
        },
        series: {
          bars: {
            show    : true,
            barWidth: 0.9,
            align   : 'center'
          }
        },
        xaxis : {
          mode      : 'categories',
          tickLength: 0
        }
      })

  });
</script>
@endif
@include('flashy::message')
<script src="{{ asset('public/js/demografi.js') }}" charset="utf-8"></script>
<script src="{{ asset('public/js/simrs.js') }}" charset="utf-8"></script>
<script src="{{ asset('public/js/aplikasi.js') }}" charset="utf-8"></script>
<script src="{{ asset('public/js/rekammedis.js') }}" charset="utf-8"></script>
<script src="{{ asset('public/js/jquery.timepicker.min.js') }}" charset="utf-8"></script>
<script src="{{ asset('public/js/datatable.js') }}" charset="utf-8"></script>
<script src="{{ asset('public/js/jquery.masknumber.js') }}"></script>
<script type="text/javascript">
 $(function(){
  $(".datepicker").datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      todayHighlight: true,
  });
 });

$(".select2").select2();
$.widget.bridge('uibutton', $.ui.button);
$('input').attr("autocomplete", "off");
$(function () {
	$('#data').DataTable({
		'language'    : {
		"url": "/json/pasien.datatable-language.json",
		},
		'paging'      : true,
		'lengthChange': false,
		'searching'   : true,
		'ordering'    : true,
		'info'        : true,
		'autoWidth'   : false
	});
});

function mojs(pelayanan, hargabeli){
	var harga = 0;
	if(pelayanan=="I"){
		harga = (hargabeli + (hargabeli * $("#obatri").val() / 100));
	}else{
		harga = (hargabeli + (hargabeli * $("#obatrj").val() / 100));
	}
	return parseInt(harga);
}
$(function () {
	$('input[type="checkbox"].flat-col, input[type="radio"].flat-col').iCheck({
	checkboxClass: 'icheckbox_flat-green',
	radioClass: 'iradio_flat-green'
	});
	$( "#tgllahir" ).datepicker({
		format: "dd-mm-yyyy",
		autoclose: true
	});
	$( "#tanggal_pengadaan" ).datepicker({
		format: "dd-mm-yyyy",
		autoclose: true
	});
	$( "#regperjanjian" ).datepicker({
		format: "dd-mm-yyyy",
		autoclose: true
	});

	$('.timepicker').timepicker({
		timeFormat: 'H:mm',
		use24hours: true,
		interval: 30,
		minTime: '00',
		maxTime: '23:30',
		defaultTime: '09',
		startTime: '00:00',
		dynamic: false,
		dropdown: true,
		scrollbar: true
	});
	$(".select2ajax").select2({
		minimumInputLength: 3,
		ajax: {
			url: "/penjualan/master-obat",
			dataType: 'json',
			type: "GET",
			quietMillis: 50,
			data: function (term) {	return term; },
			processResults: function (data) {	return { results: data }; },
			transport: function (params, success, failure) {
				var $request = $.ajax(params);
				$request.then(success);
				$request.fail(failure);
				return $request;
			}
		}
	});
	$(".select2ajaxdepo").select2({
		minimumInputLength: 3,
		ajax: {
			url: "/penjualan/master-obat/{{(isset($depo)) ? $depo : null}}",
			dataType: 'json',
			type: "GET",
			quietMillis: 50,
			data: function (term) {	return term; },
			processResults: function (data) {	return { results: data }; },
			transport: function (params, success, failure) {
				var $request = $.ajax(params);
				$request.then(success);
				$request.fail(failure);
				return $request;
			}
		}
	});
});

getNotif();
setInterval(function(){
	$.ajax({
		headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    },
		type: 'POST',
		url: 'logout',
		success: function (data) {
			location.reload();
		}
	})
}, (1000*60*60*8));
setInterval(function(){
	getNotif();
}, 3000);
setInterval(function(){
	if($("#count-notif").html()!=0){
		var in_ = new Audio('/public/audio/in.mp3');
		play(in_);
	}
}, 60000);
function play(audio) {
	audio.play();
	return new Promise(function(resolve, reject) {
			audio.addEventListener('ended', resolve);
	});
}
function getNotif(){
	$.ajax({
		url: '/notifikasi',
		type: "GET",
		dataType: "json",
		success:function(data) {
			if(data.count=="0"){
				$("#count-notif").fadeOut();
			}else{
				$("#count-notif").fadeIn();
				$("#count-notif").html(data.count);
			}
			$("#list-notif").html(data.list_notif);
		}
	});
}
function play(audio) {
	audio.play();
	return new Promise(function(resolve, reject) {
			audio.addEventListener('ended', resolve);
	});
}
$('#click-panggil').on('click', function () {
	var user_role = $('#userrole').val();
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		type: 'POST',
		url: '/antrian/panggil-apotek',
		data: {id: $(this).attr('data-idreg')},
		success: function (data) {
			if(data.status) {
				var nomorantrain = new Audio('/public/audio/nomorurut.mp3');
				var kelompok = new Audio('/public/audio/'+data.data.kelompok+'.mp3');
				var urut = new Audio('/public/audio/'+data.data.suara);
				
				if(user_role=='apotik'){
					var apotik = new Audio('/public/audio/apotik.mp3');
				}else{
					var apotik = new Audio('/public/audio/kasir.mp3');
				}
				play(nomorantrain).then(function() {
					return play(kelompok);
				}).then(function() {
					return play(urut);
				}).then(function() {
					return play(apotik);
				});
			}else{
				alert(data.message);
			}
		}
	});
});
</script>

@isset($pembayaran_pendapatan)
<script src="{{ asset('public/style/bower_components/Flot/jquery.flot.js') }}"></script>
<script src="{{ asset('public/style/bower_components/Flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('public/style/bower_components/Flot/jquery.flot.categories.js') }}"></script>

<script type="text/javascript">
  $( function() {
	  
    var bar_data = {
        //data : [['January', 10], ['February', 8], ['March', 4], ['April', 13], ['May', 17], ['June', 9]],
        data : [
          @foreach ($pembayaran1 as $r)
		  
		    ['{{ $r->created_at }}', {{ $pembayaran2 }}],
          @endforeach
        ],
        color: '#40c4ff'
      }
      $.plot('#bar-chart1', [bar_data], {
        grid  : {
          borderWidth: 1,
          borderColor: '#f3f3f3',
          tickColor  : '#f3f3f3'
        },
        series: {
          bars: {
            show    : true,
            barWidth: 0.9,
            align   : 'center'
          }
        },
        xaxis : {
          mode      : 'categories',
          tickLength: 0
        }
      })

  });
</script>

@endisset
@yield('script')
</html>
