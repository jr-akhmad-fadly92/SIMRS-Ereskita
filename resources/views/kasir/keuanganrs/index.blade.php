@extends('master')

@section('header')

  <h1>Keuangan - Laporan </h1>

@endsection



@section('content')

  <div class="box box-primary">

    <div class="box-header with-border">

    </div>

    <div class="box-body">

      <div class="row">

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->

					<a href="{{ url('keuangan/akun') }}" ><img src="{{ asset('laravel/menu/input_document.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Akun Jurnal</h5>

				</div>

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<!--<a href="{{ url('/direksi/laporan-pendapatan') }}" ><img src="{{ asset('menu/tempel.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->

					<a href="{{ url('keuangan/input-jurnal') }}" ><img src="{{ asset('laravel/menu/isi_jurnal.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Isi Jurnal</h5>

				</div>

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<!--<a href="{{ url('/direksi/laporan-pendapatan') }}" ><img src="{{ asset('menu/tempel.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->

					<a href="{{ url('/keuangan/jurnal-umum') }}" ><img src="{{ asset('laravel/menu/jurnal_harian1.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Jurnal Umum</h5>

				</div>

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<!--<a href="{{ url('/direksi/laporan-pendapatan') }}" ><img src="{{ asset('menu/tempel.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->

					<a href="{{ url('/keuangan/buku-besar') }}" ><img src="{{ asset('laravel/menu/buku_besar.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Buku Besar</h5>

				</div>

				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<!--<a href="{{ url('/direksi/laporan-pendapatan') }}" ><img src="{{ asset('menu/tempel.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->

					<a href="{{ url('/keuangan/neraca') }}" ><img src="{{ asset('laravel/menu/neraca.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Neraca</h5>

				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">

					<!--<a href="{{ url('/direksi/laporan-pendapatan') }}" ><img src="{{ asset('menu/tempel.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->

					<a href="{{ url('/pendapatan_dokter') }}" ><img src="{{ asset('laravel/menu/dokterperawat.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>

					</a>

					<h5>Cek Fee Dokter</h5>

				</div>

      </div>

    </div>

    <div class="box-footer">

    </div>

  </div>

@endsection

