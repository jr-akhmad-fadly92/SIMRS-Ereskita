@extends('master')

@section('header')

  <h1>Kasir - Transaksi <small></small></h1>

@endsection



@section('content')

  <div class="box box-primary">

    <div class="box-header with-border">

    </div>

    <div class="box-body">

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('kasir/rawatjalan') }}" ><img src="{{ asset('laravel/menu/calculating.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Rawat Jalan</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('kasir/rawatinap') }}" ><img src="{{ asset('laravel/menu/calculating.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Rawat Inap</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('kasir/igd') }}" ><img src="{{ asset('laravel/menu/calculating.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Rawat Darurat</h5>

      </div>

      <!--div class="col-md-2 col-sm-3 col-xs-6 text-center"> {{--{{ url('kasir/uangmuka-rawatinap') }}--}}

        <a href="{{ url('kasir/uangmuka-rawatinap') }}" ><img src="{{ asset('menu/calculating.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Uang Muka Rawat Inap</h5>

      </div-->

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('kasir/tutup-kasir') }}" ><img src="{{ asset('laravel/menu/calculating.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Tutup Transaksi Kasir</h5>

      </div>

			<!--div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('kasir/lain-lain') }}" ><img src="{{ asset('menu/calculating.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Kassa Lain-lain</h5>

      </div-->

    </div>

    <div class="box-footer">

    </div>

  </div>

@endsection

