@extends('master')
@section('header')
  <h1>Konfigurasi - Medis <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
					<div class="col-md-2 col-sm-3 col-xs-6 text-center text-center">
						<a href="{{ url('politype') }}" ><img src="{{ asset('menu/tipe.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
						</a>
						<h5>Master Tipe </h5>
					</div>
					<div class="col-md-2 col-sm-3 col-xs-6 text-center text-center">
						<a href="{{ url('poli') }}" ><img src="{{ asset('menu/gedung.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
						</a>
						<h5>Master Klinik</h5>
					</div>
					<div class="col-md-2 col-sm-3 col-xs-6 text-center text-center">
						<a href="{{ url('instalasi') }}" ><img src="{{ asset('menu/gedung.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
						</a>
						<h5>Master Instalasi</h5>
					</div>
        </div>
        <div class="col-md-12">
					<hr>
					<div class="col-md-2 col-sm-3 col-xs-6 text-center text-center">
						<a href="{{ url('/kelompokkelas') }}" ><img src="{{ asset('menu/bed.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
						</a>
						<h5>Master Kelompok Kamar</h5>
					</div>
					<div class="col-md-2 col-sm-3 col-xs-6 text-center text-center">
						<a href="{{ url('kelas') }}" ><img src="{{ asset('menu/bed.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
						</a>
						<h5>Master Kelas Kamar</h5>
					</div>			
					<div class="col-md-2 col-sm-3 col-xs-6 text-center text-center">
						<a href="{{ url('kamar') }}" ><img src="{{ asset('menu/bed.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
						</a>
						<h5>Master Kamar</h5>
					</div>
					<div class="col-md-2 col-sm-3 col-xs-6 text-center text-center">
						<a href="{{ url('bed') }}" ><img src="{{ asset('menu/bed.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
						</a>
						<h5>Master Bed</h5>
					</div>
				</div>
        <div class="col-md-12">
					<hr>
					<div class="col-md-2 col-sm-3 col-xs-6 text-center text-center">
						<a href="{{ url('icd9') }}" ><img src="{{ asset('menu/icd.png') }}"  width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
						</a>
						<h5>Master ICD 9</h5>
					</div>
					<div class="col-md-2 col-sm-3 col-xs-6 text-center text-center">
						<a href="{{ url('icd10') }}" ><img src="{{ asset('menu/icd.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
						</a>
						<h5>Master ICD 10</h5>
					</div>
        </div>
      </div>
    </div>
  </div>
@endsection
