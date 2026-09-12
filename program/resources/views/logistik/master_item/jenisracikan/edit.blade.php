@extends('master')

@section('header')
  <h1>Konfigurasi - Jenis Racikan</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Jenis Racikan &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($jenis_racikan, ['route' => ['jenisracikan.update', $jenis_racikan->id], 'method' => 'POST','class'=>'form-horizontal']) !!}

      @include('/logistik/master_item/jenisracikan._form')

      {!! Form::close() !!}
      </div>
    </div>
@stop
