@extends('master')

@section('header')
  <h1>Konfigurasi - Non Medis</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Non Medis &nbsp;
        </h3>
      </div>
     <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'nonmedis.store', 'class' => 'form-horizontal']) !!}

           @include('/logistik/master_item/nonmedis._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
