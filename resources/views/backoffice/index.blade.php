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
					<a href="{{url('/backoffice/Inv-mutasi')}}" ><img src="{{ asset('laravel/menu/inv_detail.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Mutasi Inventaris</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center" hidden>
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="#" ><img src="{{ asset('laravel/menu/produsen_inv.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Inventaris Ruangan</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/gudang/po-obat')}}" ><img src="{{ asset('laravel/menu/pemasok.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Pengadaan Barang  </h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/gudang/penerimaan-obat')}}" ><img src="{{ asset('laravel/menu/pengadaan obat.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Penerimaan Barang  </h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/stok-opnam/list')}}" ><img src="{{ asset('laravel/menu/pengadaan obat.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Stok Opnam </h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/dist-inv')}}" ><img src="{{ asset('laravel/menu/cek_pesanan_barang.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Distribusi Order Inv </h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/gudang/dist-obat')}}" ><img src="{{ asset('laravel/menu/cek_pesanan_barang.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Distribusi Order Obat </h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/gudang/dist-nonmedis')}}" ><img src="{{ asset('laravel/menu/cek_pesanan_barang.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Distribusi Order Non Medis </h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/gudang/retur')}}" ><img src="{{ asset('laravel/menu/cek_pesanan_barang.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Retur Obat </h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/laporan/pemesanan')}}" ><img src="{{ asset('laravel/menu/histori_pesanan.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Histori Pesanan barang</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/laporan/stok_gudang')}}" ><img src="{{ asset('laravel/menu/histori_pesanan.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Laporan Gudang</h5>
				</div>
      </div>
    </div>
    <div class="box-footer">
		<div class="row">
	  			<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/backoffice/Inv-global')}}" ><img src="{{ asset('laravel/menu/inv_global.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Invetaris Global</h5>
				</div>
        		<div class="col-md-2 col-sm-3 col-xs-6 text-center" >
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/gudang-obat')}}" ><img src="{{ asset('laravel/menu/gudang.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Stok obat Logistik</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center" hidden>
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/masterobat')}}" ><img src="{{ asset('laravel/menu/input_master.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Stok farmasi / Apotek</h5>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 text-center">
					<!--<a href="{{ url('/direksi/laporan-tagihan') }}" ><img src="{{ asset('laravel/menu/thaktif.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>-->
					<a href="{{url('/master-nonmedis')}}" ><img src="{{ asset('laravel/menu/gudang1.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
					</a>
					<h5>Master Non Medis </h5>
				</div>
				
      </div>
    </div>
  </div>
@endsection
