@extends('master')

@section('header')
  <h1>Kofigurasi - Master Ruangan</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Updated Master Ruangan &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($Inventarisglobal, ['route' => ['backoffice/inventarisglobal.update', $Inventarisglobal->kode_barang], 'method' => 'POST','class'=>'form-horizontal']) !!}

          @include('backoffice/inventaris._form')

      {!! Form::close() !!}
      </div>
    </div>
@stop
