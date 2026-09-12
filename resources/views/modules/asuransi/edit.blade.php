@extends('master')

@section('header')
  <h1>Asuransi</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Asuransi &nbsp;

        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($asuransi, ['route' => ['asuransi.update', $asuransi->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}

          @include('asuransi::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
