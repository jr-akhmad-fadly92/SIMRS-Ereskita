@extends('master')

@section('header')
  <h1>Konfigurasi - Kategori Obat</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Kategori Obat &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($Obat_all, ['route' => ['obatall.update', $Obat_all->id_obat], 'method' => 'POST','class'=>'form-horizontal']) !!}

      @include('/logistik/master_item/obatall._form')

      {!! Form::close() !!}
      </div>
    </div>
@stop
