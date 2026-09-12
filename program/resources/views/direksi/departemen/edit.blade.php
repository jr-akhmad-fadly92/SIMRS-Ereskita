@extends('master')

@section('header')
  <h1>Konfigurasi - Departemen</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Departemen &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($departemen, ['route' => ['direksi/departemen.update', $departemen->id], 'method' => 'POST','class'=>'form-horizontal']) !!}

          @include('direksi/departemen._form')

      {!! Form::close() !!}
      </div>
    </div>
@stop
