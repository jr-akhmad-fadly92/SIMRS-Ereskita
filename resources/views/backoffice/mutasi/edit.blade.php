@extends('master')

@section('header')
  <h1>Konfigurasi - Mutasi Barang</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Mutasi Barang &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($Inventarisdetail, ['route' => ['backoffice/inventarismutasi.store'], 'method' => 'POST','class'=>'form-horizontal']) !!}

          @include('backoffice/mutasi._form')

      {!! Form::close() !!}
      </div>
    </div>
@stop
