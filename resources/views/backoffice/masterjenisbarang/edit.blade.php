@extends('master')

@section('header')
  <h1>Konfigurasi - Jenis Barang</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Jenis Barang &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($jenis_barang, ['route' => ['backoffice/masterjenisbarang.update', $jenis_barang->id], 'method' => 'POST','class'=>'form-horizontal']) !!}

          @include('backoffice/masterjenisbarang._form')

      {!! Form::close() !!}
      </div>
    </div>
@stop
