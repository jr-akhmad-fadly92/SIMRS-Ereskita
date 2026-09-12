@extends('master')
@section('header')
  <h1>Laporan 10 Besar Diagnosa Rawat Jalan </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/diagnosa-irj', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('batas') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('batas') ? ' has-error' : '' }}" type="button">Batas</button>
              </span>
              {!! Form::number('batas', 10, ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('batas') }}</small>
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
              <button class="btn btn-default" type="button">s/d Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
          </div>
        </div>
        <div class="col-md-3">
          <button type="submit" class="btn btn-primary btn-flat">CHECK</button>
        </div>
      </div>
      {!! Form::close() !!}
      <hr>
      {{-- ================================================================================================== --}}
      @if ( isset($irj) )
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>ICD10</th>
                <th>Diagnosa</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($irj as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->diagnosa }}</td>
                  <td>{{ baca_icd10($d->diagnosa) }}</td>
                  <td>{{ $d->jumlah }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif


    </div>
    <div class="box-footer">
    </div>
  </div>

  @endsection
