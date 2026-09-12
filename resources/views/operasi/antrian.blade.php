@extends('master')

@section('header')
  <h1>Daftar Antrian Operasi </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      {{--!! Form::open(['method' => 'POST', 'url' => 'operasi/pertanggal', 'class' => 'form-horizontal']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                {!! Form::label('tanggal', 'Tanggal ', ['class' => 'col-sm-3']) !!}
                <div class="col-sm-9">
                    {!! Form::text('tanggal', (empty(Request::segment(3))) ? date('d-m-Y') : tgl_indo(Request::segment(3)), ['class' => 'form-control datepicker', 'onchange'=>'this.form.submit()']) !!}
                    <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                </div>
            </div>
          </div>
        </div>
      {!! Form::close() !!--}}
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>No. RM</th>
              <th>Nama</th>
              <th>Tgl. Lahir</th>
              <th>Kelas</th>
              <th>Kamar</th>
              <th>Bed</th>
              <th>Rencana Operasi</th>
              <th>Tindakan</th>
							<th>Status</th>
            </tr>
          </thead>
          <tbody>
            @if ($antrian->count() < 1)
              <tr>
                <td colspan="8">Tidak ada pasien operasi</td>
              </tr>
            @else
              @foreach ($antrian as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->pasien->no_rm }}</td>
                  <td>{{ $d->pasien->nama }}</td>
                  <td>{{ tgl_indo($d->pasien->tgllahir) }}</td>
                  <td>{{ !empty($d->kelas_id) ? baca_kelas($d->kelas_id) : NULL }}</td>
                  <td>{{ !empty($d->kamar_id) ? baca_kamar($d->kamar_id) : NULL }}</td>
                  <td>{{ !empty($d->bed_id) ? baca_bed($d->bed_id) : NULL }}</td>
                  <td>{!! tgl_indo($d->rencana_operasi) !!}</td>
                  <td>
                    <a href="{{ url('operasi/tindakan/'.$d->registrasi_id) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-scissors"></i></a>
                  </td>
									<td>
										@if($d->status_proses==1)
											<i class="fa fa-check"></i> <b>Selesai</b>
										@else
											<i>Menunggu antrian</i>
										@endif
									</td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>

    </div>
  </div>
@endsection
