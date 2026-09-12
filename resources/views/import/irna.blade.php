@extends('master')
@section('header')
  <h1>Import File IRNA <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <br>
      <div class="row">
        <div class="col-md-8">
          {!! Form::open(['method' => 'POST', 'route' => 'import-irna', 'class' => 'form-horizontal','files'=>true]) !!}

          <div class="form-group">
              {!! Form::label('inputname', 'Download Template', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <a href="{{ route('template-irna') }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cloud-download"></i> DOWNLOAD </a>
              </div>
          </div>
          <div class="form-group{{ $errors->has('kategoriheader') ? ' has-error' : '' }}">
              {!! Form::label('kategoriheader', 'Kategori Header', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::select('kategoriheader', Modules\Kategoriheader\Entities\Kategoriheader::pluck('nama', 'id'), 17, ['class' => 'chosen-select']) !!}
                  <small class="text-danger">{{ $errors->first('kategoriheader') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('kategoritarif_i') ? ' has-error' : '' }}">
              {!! Form::label('kategoritarif_id', 'Kategori Tarif', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::select('kategoritarif_id', Modules\Kategoritarif\Entities\Kategoritarif::pluck('namatarif', 'id'), 17, ['class' => 'chosen-select']) !!}
                  <small class="text-danger">{{ $errors->first('kategoritarif_id') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('jenis') ? ' has-error' : '' }}">
              {!! Form::label('jenis', 'Jenis ', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::select('jenis', ['TI'=>'TI'], null, ['class' => 'chosen-select']) !!}
                  <small class="text-danger">{{ $errors->first('jenis') }}</small>
              </div>
          </div>
          {{-- <div class="form-group{{ $errors->has('kelas') ? ' has-error' : '' }}">
              {!! Form::label('kelas', 'Kelas', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::select('kelas', Modules\Kelas\Entities\Kelas::where('nama', '<>', '-')->pluck('nama', 'id'), null, ['class' => 'chosen-select']) !!}
                  <small class="text-danger">{{ $errors->first('kelas') }}</small>
              </div>
          </div> --}}

          @for ($i=1; $i <= 2; $i++)
            <div class="form-group{{ $errors->has('nama'.$i) ? ' has-error' : '' }}">
                {!! Form::label('nama'.$i, 'Split-'.$i, ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {{-- {!! Form::select('nama'.$i, App\Mastersplit::pluck('nama', 'nama'), null, ['class' => 'chosen-select']) !!} --}}
                    <select class="form-control chosen-select" name="nama{{ $i }}">
                      <option value=""></option>
                      @foreach (App\Mastersplit::where('kategoriheader_id', 17)->get() as $key => $d)
                        <option value="{{ $d->nama }}">{{ $d->nama }}</option>
                      @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('nama'.$i) }}</small>
                </div>
            </div>
          @endfor

          <div class="form-group{{ $errors->has('excel') ? ' has-error' : '' }}">
              {!! Form::label('excel', 'File Excel', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::file('excel', ['class' => 'form-control']) !!}
                      <p class="help-block">File Excel: xls, xlsx</p>
                      <small class="text-danger">{{ $errors->first('excel') }}</small>
                  </div>
          </div>

          <div class="btn-group pull-right">
              <a href="{{ URL::previous() }}" class="btn btn-warning btn-flat">Batal</a>
              {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
          </div>


          {!! Form::close() !!}
        </div>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
