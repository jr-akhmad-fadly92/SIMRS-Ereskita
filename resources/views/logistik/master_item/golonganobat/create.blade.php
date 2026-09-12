@extends('master')

@section('header')
  <h1>Konfigurasi - Golongan Obat</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Golongan Obat &nbsp;
        </h3>
      </div>
     <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'golonganobat.store', 'class' => 'form-horizontal']) !!}

           @include('/logistik/master_item/golonganobat._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
