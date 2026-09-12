@extends('master')
@section('header')
  <h1>V-Claim SEP<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/v-claim/sep-rj', 'class'=>'form-hosizontal']) !!}
				<div class="row">
					<div class="col-md-6">
						<div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
								<span class="input-group-btn">
									<button class="btn btn-default }}" type="button">NO. REKAM MEDIS / REGISTRASI</button>
								</span>
								{!! Form::text('nomor', null, ['class' => 'form-control']) !!}
								<span class="input-group-btn">
									<button class="btn btn-success }}" type="submit">CARI</button>
								</span>
						</div>
					</div>
        </div>
      {!! Form::close() !!}
      <hr>
			
			@isset($reg)
				@if($reg!=null)
					<priv>
					{{ var_dump($reg) }}
					</priv>
				@endif
			@endisset
    </div>
  </div>
@endsection
