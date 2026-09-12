@extends('master')
@section('header')
  <h1>Konfigurasi - Umum<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('config/app') }}" ><img src="{{ asset('menu/rumahsakit.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Konfigurasi Umum</h5>
      </div>

      {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/konfig.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle" alt="" style="50%"/>
        </a>
        <h5>Konfigurasi Antrian</h5>
      </div> --}}
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('/fasilitas') }}" ><img src="{{ asset('menu/konfig.png') }}" width="50px" heigth="50px"   class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Fasilitas</h5>
      </div>
    </div>

    <div class="box-footer">
    </div>
  </div>
@endsection
