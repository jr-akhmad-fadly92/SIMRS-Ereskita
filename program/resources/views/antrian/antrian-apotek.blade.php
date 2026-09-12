@extends('master')

@section('header')

  <h1>Antrian Apotek<small></small></h1>

@endsection



@section('content')

  <div class="box box-primary">

    <div class="box-body">

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('guest/layarlcd-apotek') }}" target="_blank"><img src="{{ asset('laravel/menu/kompi.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>LCD Antrian Apotek</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('guest/nomor-antrian-apotek') }}" target="_blank"><img src="{{ asset('laravel/menu/tempel.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Nomor Antrian Apotek</h5>

      </div>

    </div>

  </div>

@endsection

