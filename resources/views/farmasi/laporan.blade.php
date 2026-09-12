@extends('master')

@section('header')

  <h1>Farmasi - Laporan <small></small></h1>

@endsection



@section('content')

  <div class="box box-primary">

    <div class="box-header with-border">

    </div>

    <div class="box-body">

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('penjualan/laporan') }}" ><img src="{{ asset('laravel/menu/finances.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Laporan<br>Penjualan Obat Pasien</h5>

      </div>

      {{--<div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="#" ><img src="{{ asset('laravel/menu/finances.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Laporan<br>Penjualan Obat</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="#" ><img src="{{ asset('laravel/menu/finances.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Laporan<br>Permintaan</h5>

      </div>

    </div>--}}

    <div class="box-footer">

    </div>

  </div>

@endsection

