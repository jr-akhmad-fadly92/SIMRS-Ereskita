@extends('master')
@section('header')
  <h1>Konfigurasi - Keuangan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <div class="col-md-12">
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<a href="{{ url('tahuntarif') }}" ><img src="{{ asset('menu/tahun.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Tahun Tarif Aktif</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<a href="{{ url('mastersplit') }}" ><img src="{{ asset('menu/ceklist.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Split Tarif</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<a href="{{ url('kategoriheader') }}" ><img src="{{ asset('menu/folder.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Kategori Header</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<a href="{{ url('kategoritarif') }}" ><img src="{{ asset('menu/folder.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Kategori Tarif</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<a href="{{ url('politype') }}" ><img src="{{ asset('menu/biaya-reg.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Kategori Klinik</h5>
				</div>
			</div>
      <div class="col-md-12">
				<hr>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<a href="{{ url('tarif') }}" ><img src="{{ asset('menu/uang.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Tarif Tindakan</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<a href="{{ url('biayaregistrasi') }}" ><img src="{{ asset('menu/biaya-reg.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Biaya Pendaftaran</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<a href="{{ url('mapping-biaya') }}" ><img src="{{ asset('menu/biaya-reg.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Mapping Group Tindakan</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<a href="{{ url('mastermapping') }}" ><img src="{{ asset('menu/jkn.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Mapping Tarif E-Klaim</h5>
				</div>
			</div>
    </div>
  </div>
@endsection
