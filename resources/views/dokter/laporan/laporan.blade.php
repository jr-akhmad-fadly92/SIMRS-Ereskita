@extends('master')
@section('header')
  <h1>Laporan Dokter <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('tindakan') }}" ><img src="{{ asset('menu/dokterperawat.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan Pendapatan Dokter</h5>
      </div>
      
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
