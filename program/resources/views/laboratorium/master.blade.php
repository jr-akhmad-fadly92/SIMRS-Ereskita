@extends('master')

@section('header')

  <h1>Laboratorium - Master Pemeriksaan <small></small></h1>

@endsection



@section('content')

  <div class="box box-primary">

    <div class="box-header with-border">

    </div>

    <div class="box-body">

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('labsection') }}" ><img src="{{ asset('laravel/menu/botol.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Master Lab</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('labkategori') }}" ><img src="{{ asset('laravel/menu/botol.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Group Lab</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('lab') }}" ><img src="{{ asset('laravel/menu/botol.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Nilai Rujukan</h5>

      </div>

    </div>

    <div class="box-footer">

    </div>

  </div>

@endsection

