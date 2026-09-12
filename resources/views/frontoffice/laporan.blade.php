@extends('master')

@section('header')

  <h1>Loket - Laporan </h1>

@endsection



@section('content')

  <div class="box box-primary">

    <div class="box-header with-border">

    </div>

    <div class="box-body">

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('frontoffice/laporan/pengunjung') }}" ><img src="{{ asset('laravel/menu/laporan.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Laporan Pengunjung</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('frontoffice/laporan/kunjungan') }}" ><img src="{{ asset('laravel/menu/laporan.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Laporan Kunjungan</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('frontoffice/laporan/diagnosa-irj') }}" ><img src="{{ asset('laravel/menu/icd.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>10 Besar Diagnosa Rawat Jalan</h5>

        <h5></h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('frontoffice/laporan/diagnosa-irna') }}" ><img src="{{ asset('laravel/menu/icd.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>10 Besar Diagnosa Rawat Inap</h5>

        <h5></h5>

      </div>

    </div>

    <div class="box-footer">

    </div>

  </div>

@endsection

