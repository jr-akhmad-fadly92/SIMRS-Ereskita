@extends('master')
@section('header')
  <h1>Loket - Cetak<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <div class='table-responsive'>
				<div class="col-md-6 pull-left">
					{!! Form::open(['method' => 'POST', 'url' => 'frontoffice/cetak', 'class'=>'form-hosizontal']) !!}
						<div class="row">
							<div class="col-md-6">
								<div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
										<span class="input-group-btn">
											<button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Dari Tanggal</button>
										</span>
										{!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => true]) !!}
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
				</div>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr class="text-center">
              <th>NO</th>
              <th>No. RM</th>
              <th>NAMA</th>
              <th>ANTRIAN</th>
              <th>POLI</th>
              <th class="text-center"> L/P</th>
              <th class="text-center">KIUP</th>
              <th class="text-center">KIB BARU</th> 
              <th class="text-center">KIB LAMA</th> 
              <th class="text-center">LABEL</th>
              <th class="text-center">GELANG</th>
              <th class="text-center">REGISTRASI</th>
              <th class="text-center">SEP</th>
            </tr>
          </thead>
          <tbody>
            @foreach($today as $key => $d)
              @if(isset($d->pasien))
                <tr class="text-center">
                  <td>{{ $no++ }}</td>
                  <td>{{ (isset($d->pasien)) ? $d->pasien->no_rm : '' }}</td>
                  <td class="text-left">{{ $d->pasien->nama }}</td>
                  <td>{{ $d->antrian_poli }}</td>
                  <td class="text-left">{{ (isset($d->poli)) ? $d->poli->nama : null }}</td>
                  <td>{{ (isset($d->pasien)) ? $d->pasien->kelamin : '' }}</td>
                  <td><a target="_blank" href="{{ url('frontoffice/cetak-kiup/'.$d->id) }}" target="_blank"  class="btn btn-success btn-sm btn-flat"><i class="fa fa-print text-center"></i></a></td>
                  <td><a target="_blank" href="{{ url('frontoffice/cetak_kib/baru/'.$d->id) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-print text-center"></i></a></td>
                  <td><a target="_blank" href="{{ url('frontoffice/cetak_kib/lama/'.$d->id) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-print text-center"></i></a></td>
                  <td> <a target="_blank" href="{{ url('frontoffice/cetak_barcode/'.$d->pasien_id.'/'.$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a> </td>
                  <td> <a target="_blank" href="{{ url('frontoffice/cetak_gelang/'.$d->pasien_id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a> </td>
                  <td> <a target="_blank" href="{{ url('frontoffice/cetak_antrian/'.$d->pasien_id.'/'.$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a> </td>
                  <td>
                    @if (!empty($d->no_sep))
                      <a href="{{ url('cetak-sep/'.$d->no_sep) }}" target="_blank"  class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
                    @endif
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
