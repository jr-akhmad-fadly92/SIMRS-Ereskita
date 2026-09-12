@extends('master')

@section('header')
  <h1>Konfigurasi - master Ruangan</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah master ruangan &nbsp;
        </h3>
      </div>
     <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'backoffice/masterruangan.store', 'class' => 'form-horizontal']) !!}

           @include('backoffice/masterruangan._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
