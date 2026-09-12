@extends('master')

@section('header')

  <h1>Rawat Jalan - Laporan <small></small></h1>

@endsection



@section('content')

  <div class="box box-primary">

    <div class="box-header with-border">

    </div>

    <div class="box-body">

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('frontoffice/laporan/kunjungan') }}" ><img src="{{ asset('laravel/menu/laporan.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Laporan Kunjungan</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('frontoffice/laporan/rekammedis-pasien') }}" ><img src="{{ asset('laravel/menu/laporan.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Rekam Medis Pasien</h5>

      </div>

      {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="#" ><img src="{{ asset('laravel/menu/school-material-1.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Laporan Rekam Medis</h5>

      </div> --}}
      
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{url('/pendapatan_dokter/cek')}}" ><img src="{{ asset('laravel/menu/dokterperawat.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Cek Fee Dokter</h5>

      </div>

    </div>

    <div class="box-footer">

    </div>

  </div>

@endsection

