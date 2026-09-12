@extends('master')

@section('header')
  <h1>Penata Jasa Rawat Jalan </h1>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-header with-border">
			{!! Form::open(['method' => 'POST', 'url' => 'tindakan', 'class'=>'form-hosizontal']) !!}
			<div class="col-md-6 ">
				<div class="row hidden">
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">Poli</button>
						</span>
						<div class="rowx">
							<div class="col-md-4 no-padding">
								<select class="form-control select2" name="ruang" onchange="clearList()">
									<option {{ (session('ruang')==1) ? 'selected' : '' }} value="1">Ruang 1</option>
									<option {{ (session('ruang')==2) ? 'selected' : '' }} value="2">Ruang 2</option>
									<option {{ (session('ruang')==3) ? 'selected' : '' }} value="3">Ruang 3</option>
									<option {{ (session('ruang')==4) ? 'selected' : '' }} value="4">Ruang 4</option>
									<option {{ (session('ruang')==5) ? 'selected' : '' }} value="5">Ruang 5</option>
									<option {{ (session('ruang')==6) ? 'selected' : '' }} value="6">Ruang 6</option>
								</select>
							</div>
							<div class="col-md-8 no-padding">
								<select class="form-control select2" name="poli_id">
									@foreach ($poli as $key => $d)
										<option {{ (session('poli_id')==$d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->nama }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<span class="input-group-btn">
							<input type="submit" class="btn btn-flat btn-success pull-right" value="Filter">
						</span>
					</div>
				</div>
			</div>
			{!! Form::close() !!}
			<h4 class="box-title pull-right text-right" style="line-height:1.1;">
				<small>dokter Periode Tanggal</small><br><b>{{ date('d-m-Y') }}</b>
			</h4>
		</div>
		<div class="box-body">
			@include('tindakan::view_dokter_ajax')
		</div>
	</div>
	

	
	
@stop

<script type="text/javascript">
	function clearList(){
		jQuery("#list-pasien").html('');
	}
	
</script>

