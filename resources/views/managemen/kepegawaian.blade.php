@extends('master')
@section('header')
  <h1>Direksi - Laporan </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{ url('/direksi/bidang') }}" ><img src="{{ asset('laravel/menu/folder.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Kode Bidang</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-pendapatan') }}" ><img src="{{ asset('menu/tempel.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{ url('/direksi/kategoripegawai') }}" ><img src="{{ asset('laravel/menu/folder.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Kategori Pegawai</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-pendapatan') }}" ><img src="{{ asset('menu/tempel.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{ url('/direksi/departemen') }}" ><img src="{{ asset('laravel/menu/folder.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Departemen</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-penerimaan') }}" ><img src="{{ asset('menu/tempel.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{ url('/direksi/masterjabatan') }}" ><img src="{{ asset('laravel/menu/folder.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Master Jabatan </h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-pem-uang-muka') }}" ><img src="{{ asset('menu/dollar-symbol-1.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{ url('/direksi/statusktppegawai') }}" ><img src="{{ asset('laravel/menu/folder.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Master Status KTP Pegawai</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<a href="{{ url('/direksi/statuspegawai') }}" ><img src="{{ asset('laravel/menu/folder.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>										
					</a>
					<h5>Master Status Kerja Pegawai</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<a href="{{url('/direksi/penggajian')}}" ><img src="{{ asset('laravel/menu/gaji_karyawan.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Penggajian</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<a href="{{url('/managemen/histori-pegawai')}}" ><img src="{{ asset('laravel/menu/histori_pegawai.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Histori Pegawai</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<a href="{{ url('/pegawai') }}" ><img src="{{ asset('laravel/menu/data_pegawai.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Data Pegawai</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<a href="{{ url('/pendapatan_dokter') }}" ><img src="{{ asset('laravel/menu/dokterperawat.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Pendapatan Dokter</h5>
				</div>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
