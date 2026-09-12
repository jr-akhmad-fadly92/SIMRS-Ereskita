@extends('master')
@section('header')
  <h1>Input Diagnosa Rawat Jalan </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <div class='table-responsive'>
				<div class="col-md-6 pull-left">
					{!! Form::open(['method' => 'POST', 'url' => 'frontoffice/input_diagnosa_rawatjalan', 'class'=>'form-hosizontal']) !!}
					<div class="row">
						<div class="col-md-4 no-padding">
							{!! Form::text('tga', null, ['class' => 'form-control datepicker', 'placeholder'=>'Dari Tanggal', 'required' => 'required']) !!}
							<small class="text-danger">{{ $errors->first('tga') }}</small>
						</div>
						<div class="col-md-4">
							{!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'placeholder'=>'Sampai Tanggal','required' => 'required', 'onchange'=>'this.form.submit()']) !!}
						</div>
						<div class="col-md-4 no-padding">
							{!! Form::submit('Download', ['class' => 'btn btn-warning btn-flat']) !!}
						</div>
					</div>
					{!! Form::close() !!}
				</div>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>No RM</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Umur</th>
              <th>Dokter</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reg as $key => $d)
              @if (!empty($d->pasien_id))
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ (isset($d->pasien)) ? $d->pasien->no_rm : '' }}</td>
                  <td>{{ (isset($d->pasien)) ? $d->pasien->nama : '' }}</td>
                  <td>{{ (isset($d->pasien)) ? $d->pasien->alamat : '' }}</td>
                  <td>{{ (isset($d->pasien)) ? hitung_umur($d->pasien->tgllahir) : '' }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>
                    <a href="{{ url('frontoffice/form-input-diagnosa/'.$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-tint"></i></a>
                  </td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
