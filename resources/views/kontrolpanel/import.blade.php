@extends('master')
@section('header')
  <h1>Konfigurasi - Import <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('cari-file-pasien') }}" ><img src="{{ asset('menu/suntik.png') }}" width="50px" heigth="50px" 
          class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Import Pasien</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('cari-file-irj') }}" ><img src="{{ asset('menu/suntik.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Import Tarif Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('cari-file-igd') }}" ><img src="{{ asset('menu/suntik.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Import Tarif Rawat Darurat</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('cari-file-irna') }}" ><img src="{{ asset('menu/suntik.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Import Tarif Rawat Inap</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('cari-file-icd9') }}" ><img src="{{ asset('menu/suntik.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Import ICD 9</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('cari-file-icd10') }}" ><img src="{{ asset('menu/suntik.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Import ICD 10</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
