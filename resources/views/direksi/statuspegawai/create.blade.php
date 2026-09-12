@extends('master')

@section('header')
  <h1>Konfigurasi - Master Status Pegawai</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Master Status Pegawai &nbsp;
        </h3>
      </div>
     <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'direksi/statuspegawai.store', 'class' => 'form-horizontal']) !!}

           @include('direksi/statuspegawai._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
