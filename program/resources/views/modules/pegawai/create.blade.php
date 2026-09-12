@extends('master')

@section('header')
  <h1>Pegawai Rumah Sakit</h1>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">
				Tambah Pegawai &nbsp;
				<a href="{{ URL::previous() }}" class="btn btn-default btn-sm"><i class="fa fa-backward"></i></a>
			</h3>
		</div>
		
		{!! Form::open(['method' => 'POST', 'route' => 'pegawai.store', 'class' => 'form-horizontal']) !!}
			<div class="box-body">
				@include('pegawai::_form')
			</div>
			<div class="box-footer with-border">
				<div class="pull-right">
						<a href="{{ route('pegawai') }}" class="btn btn-warning btn-flat">BATAL</a>
						{!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat']) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop
