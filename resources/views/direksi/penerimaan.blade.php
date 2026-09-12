@extends('master')
@section('header')
  <h1>Laporan Penerimaan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">

      {!! Form::open(['method' => 'POST', 'url' => '#', 'class' => 'form-horizontal']) !!}

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  {!! Form::label('tga', 'Tanggal', ['class' => 'col-sm-4']) !!}
                  <div class="col-sm-4">
                      {!! Form::text('tga', null, ['class' => 'form-control datepicker']) !!}
                      <small class="text-danger">{{ $errors->first('tga') }}</small>
                  </div>
                  <div class="col-sm-4">
                      {!! Form::text('tgb', null, ['class' => 'form-control datepicker']) !!}
                      <small class="text-danger">{{ $errors->first('tgb') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
                  {!! Form::label('poli_id', 'Nama Poli', ['class' => 'col-sm-4']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('poli_id', [], null, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('poli_id') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('petugas') ? ' has-error' : '' }}">
                  {!! Form::label('petugas', 'Nama Petugas', ['class' => 'col-sm-4']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('petugas', [], null, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('petugas') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('bayar') ? ' has-error' : '' }}">
                  {!! Form::label('bayar', 'Jenis Bayar', ['class' => 'col-sm-4']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('bayar', [], null, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('bayar') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('shift') ? ' has-error' : '' }}">
                  {!! Form::label('shift', 'Shift Kasa', ['class' => 'col-sm-4']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('shift', [], null, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('shift') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('tipe_perawatan') ? ' has-error' : '' }}">
                  {!! Form::label('tipe_perawatan', 'Tipe Perawatan', ['class' => 'col-sm-4']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('tipe_perawatan', [], null, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('tipe_perawatan') }}</small>
                  </div>
              </div>


            </div>
            <div class="col-md-6">
              <div class="form-group{{ $errors->has('jenis_pasien') ? ' has-error' : '' }}">
                  {!! Form::label('jenis_pasien', 'Jenis Pasien', ['class' => 'col-sm-4']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('jenis_pasien', [], null, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('jenis_pasien') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                  {!! Form::label('dokter_id', 'Nama Dokter', ['class' => 'col-sm-4']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('dokter_id', [], null, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('tipe_layanan') ? ' has-error' : '' }}">
                  {!! Form::label('tipe_layanan', 'Tipe Layanan', ['class' => 'col-sm-4']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('tipe_layanan', [], null, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('tipe_layanan') }}</small>
                  </div>
              </div>

              <div class="form-group{{ $errors->has('tipe_penerimaan') ? ' has-error' : '' }}">
                  {!! Form::label('tipe_penerimaan', 'Tipe Penerimaan', ['class' => 'col-sm-4']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('tipe_penerimaan', [], null, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('tipe_penerimaan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('rekon') ? ' has-error' : '' }}">
                  {!! Form::label('rekon', 'Rekon', ['class' => 'col-sm-4']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('rekon', [], null, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('rekon') }}</small>
                  </div>
              </div>

            </div>
          </div>

      {!! Form::close() !!}


    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
