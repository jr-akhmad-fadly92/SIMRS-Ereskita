@extends('master')
@section('header')
  <h1>Rawat Inap - Mutasi<small></small></h1>
@endsection
@section('content')
	<style>
	.datepicker{
		z-index:1300!important;
	}
	</style>
  <div class="box box-primary">
    <div class="box-body">
      <div class="col-md-6">
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>Nama</th>
              <td>{{ $reg->pasien->nama }}</td>
            </tr>
            <tr>
              <th>No. RM</th>
              <td>{{ $reg->pasien->no_rm }}</td>
            </tr>
            <tr>
              <th>Alamat</th>
              <td>{{ $reg->pasien->alamat }}</td>
            </tr>
            <tr>
              <th>Dokter DPJP</th>
              <td>{{ baca_dokter($reg->dokter_id) }}</td>
            </tr>
            <tr>
              <th>Kelompok Kelas</th>
              <td>{{ App\Kelompokkelas::find($irna->kelompokkelas_id)->kelompok }}</td>
            </tr>
            <tr>
              <th>Kelas</th>
              <td>{{ $irna->kelas->nama }}</td>
            </tr>
            <tr>
              <th>Kamar</th>
              <td>{{ $irna->kamar->nama }}</td>
            </tr>
            <tr>
              <th>Bed</th>
              <td>{{ (isset($irna->bed)) ? $irna->bed->nama : '' }}</td>
            </tr>
          </thead>
        </table>
      </div>

      <div class='col-md-6'>
				<div class="row">
					<div class="col-md-12">
						{!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/simpan-mutasi', 'class' => 'form-horizontal']) !!}
								{!! Form::hidden('registrasi_id', $reg->id) !!}
								{!! Form::hidden('carabayar_id', $reg->bayar) !!}
								{!! Form::hidden('rawatinap_id', $irna->id) !!}
								{!! Form::hidden('bed_lama', $irna->bed_id) !!}
								@if($reg->bayi==1)
									<div class="form-group" id="bayisakitGroup">
										{!! Form::label('bayi_sakit', 'Akan dimutasikan apabila bayi dalam keadaan upnormal/sakit', ['class' => 'col-md-12 text-center text-red']) !!}
										{!! Form::hidden('bayi_sakit', 1) !!}
									</div>
								@endif
								<!--div class="form-group" id="kelompokkelas_idGroup">
										{!! Form::label('kelompokkelas_id', 'Kelompok', ['class' => 'col-md-4']) !!}
										<div class="col-md-8">
												<select class="form-control" name="kelompokkelas_id">
													<option value=""></option>
													@foreach (App\Kelompokkelas::all() as $d)
														<option value="{{ $d->id }}">{{ $d->kelompok }}</option>
													@endforeach
												</select>
												<small class="text-danger" id="kelompokkelas_idError"></small>
										</div>
								</div-->
								<div class="form-group" id="kelas_idGroup">
										{!! Form::label('kelas_id', 'Kelas', ['class' => 'col-md-4']) !!}
										<div class="col-md-8">
												<select class="form-control" name="kelas_id">
													<option value=""></option>
													@foreach($kelas as $d)
														<option value="{{ $d->id }}">{{ $d->nama }}</option>
													@endforeach
												</select>
												<small class="text-danger" id="kelas_idError"></small>
										</div>
								</div>
								<div class="form-group" id="kamaridGroup">
										{!! Form::label('kamarid', 'Kamar', ['class' => 'col-md-4']) !!}
										<div class="col-md-8">
												<select class="form-control" name="kamarid">
												</select>
												<small class="text-danger" id="kamaridError"></small>
										</div>
								</div>
								<div class="form-group " id="bedID">
										{!! Form::label('bed_id', 'Bed', ['class' => 'col-md-4']) !!}
										<div class="col-md-8">
												<select class="form-control" name="bed_id">
												</select>
												<small class="text-danger" id="bed_id-error"></small>
										</div>
								</div>
								<div class="form-group{{ $errors->has('tgl_masuk') ? ' has-error' : '' }}">
										{!! Form::label('tgl_masuk', 'Tanggal Mutasi', ['class' => 'col-md-4']) !!}
										<div class="col-md-8">
											<div class="col-xs-6 no-padding">
												{!! Form::text('tgl_masuk', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
											</div>
											<div class="col-xs-6 no-padding">
												{!! Form::text('jam', null, ['class' => 'form-control timepicker']) !!}
											</div>
											<small class="text-danger">{{ $errors->first('tgl_masuk') }}</small>
										</div>
								</div>

								<div class="pull-right">
										<a href="{{ url('rawat-inap/billing') }}" class="btn btn-warning btn-flat">BATAL</a>
										{!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Yakin data yang Anda masukkan sdh benar?")']) !!}
								</div>
						{!! Form::close() !!}
					</div>
				</div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  {{-- Pengaturan Kelas --}}
  <script type="text/javascript">
    /* $('select[name="kelompokkelas_id"]').on('change', function(e) {
      e.preventDefault();
      var kelompokkelas_id = $(this).val();
      $.ajax({
        url: '/kamar/getkelas/'+kelompokkelas_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          console.log(data);
          $('select[name="kamarid"]').empty()
          $('select[name="kelas_id"]').empty()
          $('select[name="bed_id"]').empty()
          $('select[name="kelas_id"]').append('<option value=""></option>');
          $.each(data, function(key, value) {
              $('select[name="kelas_id"]').append('<option value="'+ value.id +'">'+ value.kelas +'</option>');
          });
        }
      })
    }) */

    $('select[name="kelas_id"]').on('change', function(e) {
      e.preventDefault();
      var kelompokkelas_id = $('select[name="kelompokkelas_id"]').val()
      var kelas_id = $(this).val();
			$('select[name="bed_id"]').empty()
			$('select[name="kamarid"]').empty()
			$('select[name="kamarid"]').append('<option value=""></option>');
      $.ajax({
        url: '/kamar/getkamar/'+kelompokkelas_id+'/'+kelas_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $.each(data, function(key, value) {
              $('select[name="kamarid"]').append('<option value="'+ value.id +'">'+ value.nama +'</option>');
          });
        }
      })
    })

    $('select[name="kamarid"]').on('change', function(e) {
      e.preventDefault();
      var kelompokkelas_id = $('select[name="kelompokkelas_id"]').val()
      var kelas_id = $('select[name="kelas_id"]').val()
      var kamar_id = $(this).val()
			$('select[name="bed_id"]').empty()
      $.ajax({
        url: '/getbed/'+kelompokkelas_id+'/'+kelas_id+'/'+kamar_id+'/',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $.each(data, function(key, value) {
            $('select[name="bed_id"]').append('<option value="'+ key +'">'+ value +'</option>');
          });
        }
      })
    })
  </script>
@endsection