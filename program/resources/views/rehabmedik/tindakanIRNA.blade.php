@extends('master')

@section('header')
  <h1>Billing System Radiologi - Rawat Inap </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4 class="box-title">
          Periode Tanggal &nbsp;
        </h4>
      </div>
      <div class="box-body">

        {!! Form::open(['method' => 'POST', 'url' => 'radiologi/tindakan-irna', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>

          <div class="col-md-6">
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

        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>No. RM</th>
                <th>Dokter</th>
                <th>Cara Bayar</th>
                <th>Proses</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($registrasi as $key => $d)
                  @if (Auth::user()->role()->first()->name == 'radiologi')
                      @if ( cek_tindakan($d->id, 18) > 0 )
                        <tr class="success">
                      @else
                        <tr>
                      @endif
                  @endif

                  <td>{{ $no++ }}</td>
                  <td>{{ $d->pasien->nama }}</td>
                  <td>{{ $d->pasien->no_rm }}</td>

                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>{{ baca_carabayar($d->bayar) }}
                    @if (!empty($d->tipe_jkn))
                      - {{ $d->tipe_jkn }}
                    @endif
                  </td>
                  <td>
                    <a href="{{ url('radiologi/entry-tindakan-irna/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>


      </div>
    </div>

@stop
