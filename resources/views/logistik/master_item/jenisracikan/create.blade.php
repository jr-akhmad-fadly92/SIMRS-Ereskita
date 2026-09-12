@extends('master')

@section('header')
  <h1>Konfigurasi - Jenis Racikan</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Jenis Racikan &nbsp;
        </h3>
      </div>
     <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'jenisracikan.store', 'class' => 'form-horizontal']) !!}

           @include('/logistik/master_item/jenisracikan._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
