@extends('master')

@section('header')
  <h1>Konfigurasi - Master Jabatan</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Master Jabatan &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($akunkeuangan, ['route' => ['keuangan/akunkeuangan.update', $akunkeuangan->id], 'method' => 'POST','class'=>'form-horizontal']) !!}

          @include('kasir/keuanganrs/akunkeuangan._form')

      {!! Form::close() !!}
      </div>
    </div>
@stop
