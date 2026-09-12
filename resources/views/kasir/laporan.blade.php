@extends('master')

@section('header')

  <h1>Kasir - Laporan <small></small></h1>

@endsection



@section('content')

  <div class="box box-primary">

    <div class="box-header with-border">

    </div>

    <div class="box-body">

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('kasir/tutup-kasir') }}" ><img src="{{ asset('laravel/menu/laporan.png') }}" width="75px" heigth="75px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Tutup Kasir</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('kasir/laporan-rincian-detail-tindakan') }}" ><img src="{{ asset('laravel/menu/laporan.png') }}" width="75px" heigth="75px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Rincian Detail Tindakan</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('kasir/laporan-penerimaan-tunai') }}" ><img src="{{ asset('laravel/menu/laporan.png') }}" width="75px" heigth="75px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Laporan Penerimaan Tunai/IKS/JKN</h5>

      </div>

    </div>

    <div class="box-footer">

    </div>

  </div>

@endsection

