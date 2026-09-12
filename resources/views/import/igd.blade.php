@extends('master')
@section('header')
  <h1>Import File IGD <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <br>
        <div class="row">
          <div class="col-md-8">
            @php
              $kategori_header = 2;
            @endphp
            {!! Form::open(['method' => 'POST', 'route' => 'import-igd', 'class' => 'form-horizontal','files'=>true]) !!}

              <div class="form-group">
                  {!! Form::label('inputname', 'Download Template', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                    <a href="{{ route('template-igd') }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cloud-download"></i> DOWNLOAD </a>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('kategoriheader') ? ' has-error' : '' }}">
                  {!! Form::label('kategoriheader', 'Kategori Header', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::select('kategoriheader', Modules\Kategoriheader\Entities\Kategoriheader::pluck('nama', 'id'), 2, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('kategoriheader') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('kategoritarif_i') ? ' has-error' : '' }}">
                  {!! Form::label('kategoritarif_id', 'Kategori Tarif', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::select('kategoritarif_id', Modules\Kategoritarif\Entities\Kategoritarif::pluck('namatarif', 'id'), 2, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('kategoritarif_id') }}</small>
                  </div>
              </div>
              @include('import.form')

            {!! Form::close() !!}
          </div>
        </div>

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
