@extends('master')

@section('header')
  <h1>Konfigurasi - Kategori Pegawai</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Kategori Pegawai &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($kategoripegawai, ['route' => ['direksi/kategoripegawai.update', $kategoripegawai->id], 'method' => 'POST','class'=>'form-horizontal']) !!}

          @include('direksi/kategoripegawai._form')

      {!! Form::close() !!}
      </div>
    </div>
@stop
