@extends('master')
@section('header')
  <h1>Radiologi - Billing System <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('radiologi/tindakan-irj') }}" ><img src="{{ asset('menu/dollar-symbol-2.png') }}"  width="75px" heigth="75px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Entry Tindakan Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('radiologi/tindakan-ird') }}" ><img src="{{ asset('menu/book.png') }}"  width="75px" heigth="75px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Entry Tindakan Rawat Darurat</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('radiologi/tindakan-irna') }}" ><img src="{{ asset('menu/ancient.png') }}"  width="75px" heigth="75px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Entry Tindakan Rawat Inap</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('radiologi/transaksi-langsung') }}" ><img src="{{ asset('menu/rep.png') }}"  width="75px" heigth="75px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Transaksi Langsung</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
