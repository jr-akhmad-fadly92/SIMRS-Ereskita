@extends('master')
@section('header')
  <h1>Laporan Pengunjung </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/pengunjung', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('politipe') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('politipe') ? ' has-error' : '' }}" type="button">Layanan</button>
              </span>
              {!! Form::select('politipe', [''=>'', 'J'=>'Rawat Jalan', 'G'=>'Rawat Darurat', 'I'=>'Rawat Inap'], '', ['class' => 'form-control select2']) !!}
              <small class="text-danger">{{ $errors->first('politipe') }}</small>
          </div>
        </div>
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('politipe') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('politipe') ? ' has-error' : '' }}" type="button">Klinik</button>
              </span>
              {!! Form::select('poli_id', $klinik, NULL, ['class' => 'form-control select2', 'placeholder'=>'']) !!}
              <small class="text-danger">{{ $errors->first('politipe') }}</small>
          </div>
        </div>
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>
      <h4 class="text-primary" style="margin-bottom: -10px">Total Pengunjung: {{ $histreg->count() }}</h4>
      
			@include('frontoffice.ajax_lap_pengunjung')

    </div>
    <div class="box-footer">
    </div>
  </div>


@endsection
