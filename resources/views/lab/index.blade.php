@extends('master')
@section('header')
  <h1>Pemeriksaan Laboratorium</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="box-title">
        Periode Tanggal &nbsp;
      </h4>
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'pemeriksaanlab', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="form-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>
      {{-- =================================================== --}}
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pasien</th>
              <th>No. RM</th>
              <th>No. Reg</th>
              <th>Dokter</th>
              <th>Poli</th>
              <th>Cara Bayar</th>
              <th>Input</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($today as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ !empty($d->pasien_id) ? $d->pasien->nama : '' }}</td>
                <td>{{ !empty($d->pasien_id) ? $d->pasien->no_rm : '' }}</td>
                <td>{{ $d->reg_id }}</td>
                <td>{{ baca_dokter($d->dokter_id) }}</td>
                <td>{{ !empty($d->poli_id) ? $d->poli->nama : NULL }}</td>
                <td>{{ baca_carabayar($d->bayar) }}</td>
                <td>
                  <a href="{{ url('pemeriksaanlab/create/'.$d->id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a>
                  @if (cek_hasil_lab($d->id) >= 1)
                    @php
                      $hasil = App\Hasillab::where('registrasi_id', $d->id)->get();
                    @endphp

                    @foreach ($hasil as $key => $r)
                      <a target="_blank" href="{{ url('pemeriksaanlab/cetak/'.$d->id.'/'.$r->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-print"></i></a>
                    @endforeach

                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
  </div>
@endsection
