@extends('master')

@section('header')
  <h1>Konfigurasi - Master Jabatan</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Master Jabatan &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($masterjabatan, ['route' => ['direksi/masterjabatan.update', $masterjabatan->id], 'method' => 'POST','class'=>'form-horizontal']) !!}

          @include('direksi/masterjabatan._form')

      {!! Form::close() !!}
      </div>
    </div>
@stop
