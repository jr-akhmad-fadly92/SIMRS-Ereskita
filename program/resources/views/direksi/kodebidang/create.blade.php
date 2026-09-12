@extends('master')

@section('header')
  <h1>Konfigurasi - Kode Bidang</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Kode Bidang &nbsp;
        </h3>
      </div>
     <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'direksi/kodebidang.store', 'class' => 'form-horizontal']) !!}

           @include('direksi/kodebidang._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
