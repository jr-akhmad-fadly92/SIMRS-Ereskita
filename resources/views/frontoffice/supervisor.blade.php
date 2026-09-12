@extends('master')

@section('header')

  <h1>Loket - Supervisor <small></small></h1>

@endsection



@section('content')

  <div class="box box-primary">

    <div class="box-header with-border">

    </div>

    <div class="box-body">

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('/pegawai') }}" ><img src="{{ asset('laravel/menu/pegawai.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Data Pegawai</h5>

      </div>

      <!--div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('/dokter') }}" ><img src="{{ asset('menu/dokterperawat.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Data Dokter</h5>

      </div-->

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('/jadwal-dokter') }}" ><img src="{{ asset('laravel/menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Jadwal Dokter</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('/frontoffice/supervisor/ubahdpjp') }}" ><img src="{{ asset('laravel/menu/dpjp.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Ubah DPJP</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="/frontoffice/supervisor/hapusregistrasi" ><img src="{{ asset('laravel/menu/hapusreg.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Hapus Registrasi</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('/pasien') }}" ><img src="{{ asset('laravel/menu/pasien1.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Data Pasien</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('/regperjanjian') }}" ><img src="{{ asset('laravel/menu/reg-perjanjian.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Pendaftaran Perjanjian</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('/frontoffice/setting-kuota-poli') }}" ><img src="{{ asset('laravel/menu/kuota.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Kuota Antrian</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('frontoffice/input_diagnosa_rawatjalan') }}" ><img src="{{ asset('laravel/menu/rekammedis.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Diagnosa Rawat Jalan</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('frontoffice/input_diagnosa_rawatinap') }}" ><img src="{{ asset('laravel/menu/rekammedis.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Diagnosa Rawat Inap</h5>

      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('/pasien/rekammedispasien') }}" ><img src="{{ asset('laravel/menu/irekammedis.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Rekam Medis Pasien</h5>

      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">

        <a href="{{ url('rehabmedik/RL2') }}" ><img src="{{ asset('laravel/menu/tempel.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

        </a>

        <h5>Laporan RL 2 </h5>

      </div>

    </div>

    

    <div class="box-footer">



    </div>

  </div>

@endsection

