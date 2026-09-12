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

					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->

					<a href="{{ url('direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Tagihan</h5>

				</div>

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<!--<a href="{{ url('/direksi/laporan-pendapatan') }}" ><img src="{{ asset('laravel/menu/tempel.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->

					<a href="{{ url('direksi/laporan-pendapatan') }}" ><img src="{{ asset('laravel/menu/tempel.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Pendapatan</h5>

				</div>

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<!--<a href="{{ url('/direksi/laporan-pendapatan') }}" ><img src="{{ asset('laravel/menu/tempel.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->

					<a href="{{ url('direksi/penggajian') }}" ><img src="{{ asset('laravel/menu/tempel.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>penggajian</h5>

				</div>

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<!--<a href="{{ url('/direksi/laporan-penerimaan') }}" ><img src="{{ asset('laravel/menu/tempel.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->

					<a href="#" ><img src="{{ asset('laravel/menu/tempel.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Penerimaan </h5>

				</div>
				
				

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<!--<a href="{{ url('/direksi/laporan-pem-uang-muka') }}" ><img src="{{ asset('laravel/menu/dollar-symbol-1.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->

					<a href="{{ url('direksi/laporan-pem-uang-muka') }}" ><img src="{{ asset('laravel/menu/dollar-symbol-1.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Pembayaran Uang Muka</h5>

				</div>

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<a href="#" ><img src="{{ asset('laravel/menu/jkn.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>										
					<!--<a href="{{ url('/direksi/laporan-bridging-jkn') }}" ><img src="{{ asset('laravel/menu/jkn.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>										
					-->
					</a>

					<h5>Bridging JKN</h5>

				</div>

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<a href="#" ><img src="{{ asset('laravel/menu/jkn.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					<!--<a href="{{ url('/direksi/laporan-selisih-negatif') }}" ><img src="{{ asset('laravel/menu/jkn.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					-->
					</a>

					<h5>Selisih Negative JKN</h5>

				</div>

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<a href="{{ url('/direksi/laporan-naik-kelas') }}" ><img src="{{ asset('laravel/menu/folder.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Naik Kelas</h5>

				</div>

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<a href="{{ url('/direksi/laporan-kinerja') }}" ><img src="{{ asset('laravel/menu/laporan.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Laporan Kinerja</h5>

				</div>

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<a href="{{ url('/direksi/kinerja-rawat-jalan') }}" ><img src="{{ asset('laravel/menu/dokterperawat.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Kinerja Rawat Jalan</h5>

				</div>

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<a href="{{ url('/direksi/kinerja-rawat-darurat') }}" ><img src="{{ asset('laravel/menu/dokterperawat.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Kinerja Rawat Darurat</h5>

				</div>

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<a href="{{ url('/direksi/kinerja-rawat-inap') }}" ><img src="{{ asset('laravel/menu/dokterperawat.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Kinerja Rawat Inap</h5>

				</div>

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<a href="{{ url('/kamar/histori_kamar_ranap') }}" ><img src="{{ asset('laravel/menu/Kamar_RS.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Histori Kamar Rawat Inap</h5>

				</div>

      </div>

    </div>

    <div class="box-footer">

    </div>

  </div>

@endsection

