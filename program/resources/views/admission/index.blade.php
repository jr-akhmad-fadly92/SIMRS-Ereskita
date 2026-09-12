@extends('master')
@section('header')
  <h1>Admission </h1>
@endsection

@section('content')
    <div class="box box-primary">			
      <div class="box-header with-border">
				{!! Form::open(['method' => 'POST', 'url' => 'admission', 'class'=>'form-horizontal']) !!}
        <div class="row">
          <div class="col-md-4">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal Registrasi</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => true, 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>
          <div class="col-md-4">
          </div>
          <div class="col-md-4">
						<a href="{{ url('rawatinap/antrian') }}" class="btn btn-flat btn-success pull-right">Proses Kamar/Bed</a>
          </div>
        </div>
				{!! Form::close() !!}				
      </div>
      <div class="box-body">
        <div class='table-responive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>No. RM</th>
                <th>Nama</th>
                <th>Tgl Lahir</th>
                <th>Alamat</th>
                <th>Instalasi</th>
                <th>Klinik</th>
                <th>DPJP</th>
                <th>Cara Bayar</th>
                <th>Proses</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($reg as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->pasien->no_rm }}</td>
                  <td>{{ $d->pasien->nama }}</td>
                  <td>{{ ($d->pasien->tgllahir) ? tgl_indo($d->pasien->tgllahir) : '' }}</td>
                  <td>{{ substr($d->pasien->alamat,0,25) }}...</td>
                  <td>
                    @if ( substr($d->status_reg, 0,1) == 'J' )
                      Rawat Jalan
                    @elseif ( substr($d->status_reg, 0,1) == 'G' )
                      Rawat Darurat
                    @endif
                  </td>
                  <td>{{ ($d->poli_id!=null AND $d->poli_id!=0) ? $d->poli->nama : '' }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }} </td>
                  <td>{{ baca_carabayar($d->bayar) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                  <td>
                    <a href="{{ url('admission/proses/'.$d->id) }}" onclick="return confirm('Yakin pasien akan Anda inapkan')" class="btn btn-primary btn-sm"><i class="fa fa-bed"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
