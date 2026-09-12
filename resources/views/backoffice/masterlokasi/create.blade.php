@extends('master')

@section('header')
  <h1>Konfigurasi - Lokasi Barang</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Lokasi Barang &nbsp;
        </h3>
      </div>
     <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'backoffice/masterlokasibarang.store', 'class' => 'form-horizontal']) !!}

           @include('backoffice/masterlokasi._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
