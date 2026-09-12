@extends('master')
@section('header')
  <h1>Diagnosa Rawat Jalan </h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
		<div class='table-responsive'>
			<table class='table table-bordered table-hover table-condensed'>
			  <tbody>
				<tr>
				  <th style="width:15%;">No RM</th> <td style="width:30%">{{ $reg->pasien->no_rm }}</td> <th>Alamat</th> <td>{{ $reg->pasien->alamat }}</td>
				</tr>
				<tr>
				  <th>Nama </th> <td>{{ $reg->pasien->nama }}</td> <th>Cara Bayar</th> <td>{{ baca_carabayar($reg->jenis_pasien) }}</td>
				</tr>
				<tr>
				  <th>Umur</th> <td>{{ hitung_umur($reg->pasien->tgllahir) }}</td> <th>Poli</th> <td>{{ $reg->poli->nama }}</td>
				</tr>
				<tr>
				  <th>Jenis Kelamin</th> <td>{{ ($reg->pasien->kelamin == 'L') ? 'Laki-laki' : 'Perempuan' }}</td>
				</tr>

			  </tbody>
			</table>
		  </div>

		  {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/simpan_diagnosa_rawatjalan', 'class' => 'form-horizontal']) !!}
		  {!! Form::hidden('registrasi_id', $reg->id) !!}
		  {!! Form::hidden('cara_bayar', $reg->bayar) !!}
			<div class="row">
			  <div class="col-md-6">
				@isset($perawatanicd10)
					<h4>Diagnosa Sebelumnya</h4>
					<div class="table-responsive">
					  <table class="table table-hover table-condensed">
						<tbody>
						  @foreach ($perawatanicd10 as $key => $d)
							<tr>
							  <td>{{ $d->icd10 }}</td>
							  <td>{{ baca_diagnosa($d->icd10) }}</td>
							  <td>
								<a href="{{ url('frontoffice/hapus-diagnosa/'.$d->id.'/'.$reg->id) }}" class="btn btn-flat btn-danger btn-xs" title="hapus"> <i class="fa fa-trash"></i></a>
							  </td>
							</tr>
						  @endforeach
						</tbody>
					  </table>
					</div>
					
				@endisset
				<hr>
				<h4>Diagnosa</h4>
				@for ($i=1; $i <= 5; $i++)
				  <div class="form-group{{ $errors->has('icd10'.$i) ? ' has-error' : '' }}">
					  {!! Form::label('icd10', 'Diagnosa '.$i, ['class' => 'col-sm-3 control-label']) !!}
					  <div class="col-sm-9">
						  {!! Form::text('icd10'.$i, null, ['class' => 'form-control', 'id'=>'icd10'.$i]) !!}
						  <small class="text-danger">{{ $errors->first('icd10'.$i) }}</small>
					  </div>
				  </div>
				@endfor


				<hr>
				<div class="form-group{{ $errors->has('status_kondisi') ? ' has-error' : '' }}">
					{!! Form::label('status_kondisi', 'Kondisi Pasien', ['class' => 'col-sm-3 control-label']) !!}
					<div class="col-sm-9">
						{!! Form::select('status_kondisi', $kondisi, null, ['class' => 'form-control select2']) !!}
						<small class="text-danger">{{ $errors->first('status_kondisi') }}</small>
					</div>
				</div>
				<div class="form-group{{ $errors->has('posisi_berkas_rm') ? ' has-error' : '' }}">
					{!! Form::label('posisi_berkas_rm', 'Posisi Berkas', ['class' => 'col-sm-3 control-label']) !!}
					<div class="col-sm-9">
						{!! Form::select('posisi_berkas_rm', $posisi, null, ['class' => 'form-control select2']) !!}
						<small class="text-danger">{{ $errors->first('posisi_berkas_rm') }}</small>
					</div>
				</div>
			  </div>

			  {{-- ======================================================================= --}}
			  <div class="col-md-6">
				@isset($perawatanicd9)
					<h4>Prosedur Sebelumnya</h4>
					<div class="table-responsive">
					  <table class="table table-hover table-condensed">
						<tbody>
						  @foreach ($perawatanicd9 as $key => $d)
							<tr>
							  <td>{{ $d->icd9 }}</td>
							  <td>{{ baca_prosedur($d->icd9) }} </td>
							  <td>
								<a href="{{ url('frontoffice/hapus-prosedur/'.$d->id.'/'.$reg->id) }}" class="btn btn-flat btn-danger btn-xs" title="hapus"> <i class="fa fa-trash"></i></a>
							  </td>
							</tr>
						  @endforeach
						</tbody>
					  </table>
					</div>
				@endisset
				<hr>
				<h4>Prosedur</h4>
				@for ($i=1; $i <= 5; $i++)
				  <div class="form-group{{ $errors->has('icd9'.$i) ? ' has-error' : '' }}">
					  {!! Form::label('icd9'.$i, 'Prosedur '.$i, ['class' => 'col-sm-3 control-label']) !!}
					  <div class="col-sm-9">
						  {!! Form::text('icd9'.$i, null, ['class' => 'form-control']) !!}
					  </div>
				  </div>
				@endfor            
			  </div>
			</div>
	</div>
	<div class="box-footer">
		<div class="pull-left">
			  <a href="{{ url('frontoffice/input_diagnosa_rawatjalan') }}" class="btn btn-warning btn-flat">BATAL</a>
		</div>
		<div class="pull-left">
			  <a href="{{ url('frontoffice/input_diagnosa_rawatjalan') }}" class="btn btn-primary btn-flat btn-sm"> <i class="fa fa-backward"></i> SELESAI</a>
		</div>
		<div class="pull-right">
			  {!! Form::submit('SIMPAN', ['class' => 'btn btn-success btn-flat','onclick'=>'return confirm("Yakin data sudah benar semua?")']) !!}
		</div>
	</div>
    {!! Form::close() !!}
</div>

  <div class="modal fade" id="icd9" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">Data ICD9</h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <table id='dataICD9' class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Add</th>
                </tr>
              </thead>

            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="icd10" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">Data ICD10</h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <table id='dataICD10' class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Add</th>
                </tr>
              </thead>

            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection
