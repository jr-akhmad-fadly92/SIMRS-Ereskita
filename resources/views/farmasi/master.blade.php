@extends('master')
@section('header')
  <h1>Farmasi - Master <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <!--div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('supliyer') }}" ><img src="{{ asset('menu/suplier.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Suplier</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('satuanjual') }}" ><img src="{{ asset('menu/pack.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Satuan Jual</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('satuanbeli') }}" ><img src="{{ asset('menu/pack.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Satuan Beli</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="#" ><img src="{{ asset('menu/pills.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Faktur Masuk</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('kategoriobat') }}" ><img src="{{ asset('menu/pills.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Kategori Obat</h5>
      </div-->
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('masterobat') }}" ><img src="{{ asset('menu/pills.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Master Obat</h5>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
