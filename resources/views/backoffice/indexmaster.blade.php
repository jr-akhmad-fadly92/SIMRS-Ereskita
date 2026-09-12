@extends('master')
@section('header')
  <h1>Back Office - Laporan </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
	  			
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/backoffice/master_ruangan')}}" ><img src="{{ asset('laravel/menu/input_master.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Master Ruangan</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/backoffice/master_jenis_barang')}}" ><img src="{{ asset('laravel/menu/input_master.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Master Jenis Barang</h5>
				</div>
        		<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/backoffice/master_lokasi_barang')}}" ><img src="{{ asset('laravel/menu/input_master.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Master Lokasi Barang</h5>
				</div>
        		<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/backoffice/produsen-supplier')}}" ><img src="{{ asset('laravel/menu/pemasok.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>produsen / supplier </h5>
				</div>
				
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/master/jenis_racikan')}}" ><img src="{{ asset('laravel/menu/input_master.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Master Jenis racikan</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/master/satuan')}}" ><img src="{{ asset('laravel/menu/input_master.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Master Satuan Barang</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/master/kategori_obat')}}" ><img src="{{ asset('laravel/menu/input_master.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Master Kategori Obat</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/master/golongan_obat')}}" ><img src="{{ asset('laravel/menu/input_master.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Master Golongan Obat</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/master/obat_program')}}" ><img src="{{ asset('laravel/menu/input_master.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Master Obat Program</h5>
				</div>
				
				
				
      </div>
    </div>
	
    <div class="box-footer">
    <div class="row">
	  			<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/master-obat-all')}}" ><img src="{{ asset('laravel/menu/masterobat.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Master Obat</h5>
				</div>
				
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/master-nonmedis')}}" ><img src="{{ asset('laravel/menu/gudang1.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Master Non Medis </h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/backoffice/Inv-global')}}" ><img src="{{ asset('laravel/menu/inv_global.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Invetaris Global</h5>
				</div>
				
				
      </div>
	</div>
	
  </div>
@endsection
