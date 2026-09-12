@extends('master')

@section('header')
  <h1>Konfigurasi - Produsen - Supplier</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Produsen - Supplier &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($produsen, ['route' => ['backoffice/masterprodusen.update', $produsen->id_produsen], 'method' => 'POST','class'=>'form-horizontal']) !!}

          @include('backoffice/produsen._form')

      {!! Form::close() !!}
      </div>
    </div>
@stop
