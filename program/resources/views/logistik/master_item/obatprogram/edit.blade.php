@extends('master')

@section('header')
  <h1>Konfigurasi - Obat Program</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Obat Program &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($Obatprogram, ['route' => ['obatprogram.update', $Obatprogram->id], 'method' => 'POST','class'=>'form-horizontal']) !!}

      @include('/logistik/master_item/obatprogram._form')

      {!! Form::close() !!}
      </div>
    </div>
@stop
