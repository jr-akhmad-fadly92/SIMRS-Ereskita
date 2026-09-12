@extends('master')

@section('header')
  <h1>Konfigurasi - Satuan Barang</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Satuan Barang &nbsp;
        </h3>
      </div>
     <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'satuan.store', 'class' => 'form-horizontal']) !!}

           @include('/logistik/master_item/satuan._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
