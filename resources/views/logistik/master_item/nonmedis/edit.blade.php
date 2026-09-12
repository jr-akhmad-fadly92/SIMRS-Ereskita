@extends('master')

@section('header')
  <h1>Konfigurasi - Non Medis</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Non Medis &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($non_medis, ['route' => ['nonmedis.update', $non_medis->kode_barang], 'method' => 'POST','class'=>'form-horizontal']) !!}

      @include('/logistik/master_item/nonmedis._form')

      {!! Form::close() !!}
      </div>
    </div>
@stop
