@extends('master')

@section('header')
  <h1>Konfigurasi - Obat All</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Master Obat &nbsp;
        </h3>
      </div>
     <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'obatall.store', 'class' => 'form-horizontal']) !!}

           @include('/logistik/master_item/obatall._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
