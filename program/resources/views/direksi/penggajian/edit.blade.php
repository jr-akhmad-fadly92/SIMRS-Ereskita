@extends('master')

@section('header')
  <h1>Konfigurasi - Master Status KTP Pegawai /h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Edit Status KTP Pegawai &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($pegawai, ['route' => ['direksi/penggajian.update', $pegawai->id], 'method' => 'POST','class'=>'form-horizontal']) !!}

          @include('direksi/penggajian._form')

      {!! Form::close() !!}
      </div>
    </div>
@stop
