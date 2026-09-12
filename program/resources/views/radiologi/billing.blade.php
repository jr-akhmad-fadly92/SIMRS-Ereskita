@extends('master')
@section('header')
  <h1>Radiologi - Penata Jasa <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('radiologi/tindakan-irj') }}" ><img src="{{ asset('menu/radiologi.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('radiologi/tindakan-ird') }}" ><img src="{{ asset('menu/radiologi.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Rawat Darurat</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('radiologi/tindakan-irna') }}" ><img src="{{ asset('menu/radiologi.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Rawat Inap</h5>
      </div>
      <!--div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('radiologi/transaksi-langsung') }}" ><img src="{{ asset('menu/radiologi.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Transaksi Langsung</h5>
      </div-->
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
