@extends('master')

@section('header')
  <h1>Konfigurasi - Inventeris Global</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Inventeris Global &nbsp;
        </h3>
      </div>
     <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'backoffice/inventarisdetail.store', 'class' => 'form-horizontal']) !!}

           @include('backoffice/inventaris/listdetail._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
