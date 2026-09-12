@extends('master')

@section('header')

  <h1>Informasi<small></small></h1>

@endsection



@section('content')

  <div class="box box-primary">

    <div class="box-header with-border">

    </div>

    <div class="box-body">

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('/surat-resep-kosong') }}" ><img src="{{ asset('laravel/menu/daftar_akun.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>SURAT RESEP</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('/surat-rujukan-kosong') }}" ><img src="{{ asset('laravel/menu/daftar_akun.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>SURAT RUJUKAN</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('/pegawai') }}" ><img src="{{ asset('laravel/menu/daftar_akun.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>SURAT KETERANGAN SEHAT</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('/pegawai') }}" ><img src="{{ asset('laravel/menu/daftar_akun.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>SURAT KETERANGAN SAKIT</h5>

      </div>


    </div>
    

    <div class="box-footer">



    </div>

  </div>

@endsection

