@extends('master')

@section('header')
  <h1>Konfigurasi - Detail Invetaris</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Updated Detail Invetaris &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($Inventarisdetail, ['route' => ['backoffice/inventarisdetail.update', $Inventarisdetail->kode_barang], 'method' => 'POST','class'=>'form-horizontal']) !!}

          @include('backoffice/inventaris/listdetail._form')

      {!! Form::close() !!}
      </div>
    </div>
@stop
