@extends('master')
@section('header')
  <h1>Farmasi - Penjualan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('penjualan') }}" ><img src="{{ asset('menu/tablets.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Rawat Jalan / Darurat</h5>
      </div>
      <!--div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('penjualan') }}" ><img src="{{ asset('menu/tablets.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Rawat Darurat</h5>
      </div-->
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('penjualan/irna') }}" ><img src="{{ asset('menu/tablets.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Rawat Inap</h5>
      </div>
      <!--div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('penjualanbebas') }}" ><img src="{{ asset('menu/tablets.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Penjualan Bebas</h5>
      </div-->
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
