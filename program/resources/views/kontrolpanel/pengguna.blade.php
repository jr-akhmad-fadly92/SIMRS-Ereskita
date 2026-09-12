@extends('master')
@section('header')
  <h1>Konfigurasi - Pengguna <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('role') }}" ><img src="{{ asset('menu/hakakses.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Hak Akses</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('pegawai') }}" ><img src="{{ asset('menu/pegawai.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Pegawai</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('user') }}" ><img src="{{ asset('menu/akun.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Pengguna</h5>
      </div>
    </div>
  </div>
@endsection
