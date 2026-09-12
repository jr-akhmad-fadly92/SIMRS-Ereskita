@extends('master')

@section('header')
  <h1>Konfigurasi - Jenis Barang</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Jenis Barang &nbsp;
        </h3>
      </div>
     <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'backoffice/masterjenisbarang.store', 'class' => 'form-horizontal']) !!}

           @include('backoffice/masterjenisbarang._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
