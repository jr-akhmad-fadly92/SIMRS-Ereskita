@extends('master')

@section('header')

  <h1>Kasir - Supervisor <small></small></h1>

@endsection



@section('content')

  <div class="box box-primary">

    <div class="box-header with-border">

    </div>

    <div class="box-body">

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('kasir/edit-transaksi') }}" ><img src="{{ asset('laravel/menu/edit.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Edit Transaksi</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('kasir/batal-bayar') }}" ><img src="{{ asset('laravel/menu/dollar-symbol-1.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Batal Bayar</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('kasir/batal-piutang') }}" ><img src="{{ asset('laravel/menu/dollar-symbol-1.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Batal Piutang</h5>

      </div> 

     

       <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('kasir/verifikasi-kasa') }}" ><img src="{{ asset('laravel/menu/verifikasi.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Verifikasi Pembayaran</h5>

      </div> 

     

       <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('kasir/transaksi') }}" ><img src="{{ asset('laravel/menu/transaksi.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Informasi Transaksi</h5>

      </div> 

    </div>

    <div class="box-footer">

    </div>

  </div>

@endsection

