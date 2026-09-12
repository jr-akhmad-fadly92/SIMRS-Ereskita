@extends('master')
@section('header')
  <h1>Front Office - Laporan Rekam Medis <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('/frontoffice/lap-rekammedis') }}" ><img src="{{ asset('menu/laporan.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Rekam Medis Pasien</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
