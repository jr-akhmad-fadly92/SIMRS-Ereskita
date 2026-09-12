@extends('master')
@section('header')
  <h1>Laporan Rawat Inap<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('rawatinap/lap-pengunjung') }}" ><img src="{{ asset('menu/laporan.png') }}"  width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan Pengunjung</h5>
      </div>
      <!--div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('rawatinap/sensus-harian') }}" ><img src="{{ asset('menu/laporan.png') }}"  width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Sensus Harian</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('rawatinap/informasi-rawat') }}" ><img src="{{ asset('menu/laporan.png') }}"  width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Informasi Rawat</h5>
      </div-->
    </div>
    <div class="box-footer">

    </div>
  </div>
@endsection
