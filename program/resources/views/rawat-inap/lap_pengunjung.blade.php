@extends('master')

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'rawatinap/lap-pengunjung', 'class'=>'form-horizontal']) !!}
      {!! Form::hidden('pasien_id', null) !!}
      <div class="row">
        <div class="col-md-12">
					<div class="col-md-12">
						<div class="form-group">
							<div class="col-md-3 no-padding">
								<label for="tga" class="col-md-12 no-padding">Dari</label>
								{!! Form::text('tga', null, ['class' => 'form-control datepicker']) !!}
								<small class="text-danger">{{ $errors->first('tga') }}</small>
							</div>
							<div class="col-md-3 no-padding">
								<label for="tga" class="col-md-12 no-padding">Sampai</label>
								{!! Form::text('tgb', null, ['class' => 'form-control datepicker']) !!}
								<small class="text-danger">{{ $errors->first('tgb') }}</small>
							</div>
							<div class="col-md-3 no-padding">
								<label for="nama" class="col-md-3 no-padding">Kamar</label>
								<select class="form-control" name="kamar">
									<option value="">[Semua]</option>
									@foreach ($kamar as $key => $d)
										@if (!empty($_POST['kamar']) && $_POST['kamar'] == $d->id)
											<option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
										@else
											<option value="{{ $d->id }}">{{ $d->nama }}</option>
										@endif
									@endforeach
								</select>
							</div>
							<div class="col-md-3 no-padding">
								<label for="nama" class="col-md-12 no-padding">Nama Pasien</label>
								<div class="input-group">
										{!! Form::text('nama', null, ['class' => 'form-control']) !!}
										<span class="input-group-btn">
											<button type="button" id="openModal" class="btn btn-default btn-flat"><i class="fa fa-search"></i> </button>
										</span>
								</div>
							</div>
						</div>
					</div>
        </div>
				
				<div class="col-md-12">
					<div class="col-md-12" style="background:#f9f9f9;padding:10px;border:solid 1px #eee;text-align:center;">
						<input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT">
						<input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
						<input type="submit" name="pdf" class="btn btn-danger btn-flat fa-file-pdf-o" value="&#xf1c1; CETAK">
					</div>
				</div>
      </div>
      {!! Form::close() !!}
			<br>

      <div class='table-responsive'>
        <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th style="vertical-align: middle;">No</th>
              <th style="vertical-align: middle;">No. RM</th>
              <th style="vertical-align: middle;">Nama</th>
              <th style="vertical-align: middle;">Alamat</th>
              <th style="vertical-align: middle;">Tgl Masuk</th>
              <th style="vertical-align: middle;">Cara Bayar</th>
              <th style="vertical-align: middle;">Kelas</th>
              <th style="vertical-align: middle;">Kamar</th>
              <th style="vertical-align: middle;">Bed</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($irna as $key => $d)
              @php
                $pasien = Modules\Pasien\Entities\Pasien::where('id', $d->pasien_id)->first()
              @endphp
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $pasien->no_rm }}</td>
                <td>{{ $pasien->nama }}</td>
                <td>{{ $pasien->alamat }}</td>
                <td>{{ tanggal($d->created_at) }}</td>
                <td>{{ baca_carabayar($d->carabayar_id) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                <td>{{ baca_kelas($d->kelas_id) }}</td>
                <td>{{ baca_kamar($d->kamar_id) }}</td>
                <td>{{ baca_bed($d->bed_id) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>


    </div>
  </div>

  {{-- MODAL SEARCH pasien --}}
  <div class="modal fade" id="searchPasien" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <table id="dataPasien" class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No. RM</th>
                  <th>Nama Lengkap</th>
                  <th>Alamat</th>
                  <th>Input</th>
                </tr>
              </thead>
              <tbody></tbody>
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

@section('script')
<script type="text/javascript">
$(document).ready(function() {
	$('select[name="kelas"]').on('change', function () {
		var kelas_id = $(this).val();
		if(kelas_id) {
				$.ajax({
						url: '/lap-irna-getkamar/'+kelas_id,
						type: "GET",
						dataType: "json",
						success:function(data) {
								$('select[name="kamar"]').empty();
								$.each(data, function(key, value) {
										$('select[name="kamar"]').append('<option value="'+ key +'">'+ value +'</option>');
								});
						}
				});
		}else{
			$.ajax({
					url: '/lap-irna-getkamar/',
					type: "GET",
					dataType: "json",
					success:function(data) {
							$('select[name="kamar"]').empty();
							$('select[name="kamar"]').append('<option value="">[Semua]</option>');
							$.each(data, function(key, value) {
									$('select[name="kamar"]').append('<option value="'+ key +'">'+ value +'</option>');
							});
					}
			});
		}
	});

	//SEARCH PASIEN
	$('#openModal').on('click', function () {
		$("#dataPasien").DataTable().destroy();
		$('#searchPasien').modal('show');
		$('.modal-title').text('Cari Pasien');
		$('#dataPasien').DataTable({
				"language": {
						"url": "/json/pasien.datatable-language.json",
				},

				pageLength: 10,
				autoWidth: false,
				processing: true,
				serverSide: true,
				ordering: false,
				ajax: '/frontoffice/lap-rekammedis/datapasien',
				columns: [
						{data: 'no_rm'},
						{data: 'nama'},
						{data: 'alamat'},
						{data: 'input', searchable: false},
				]
		});
	});

	$(document).on('click', '.inputPasien', function (e) {
		$('input[name="nama"]').val($(this).attr('data-nama'));
		$('input[name="no_rm"]').val($(this).attr('data-no_rm'));
		$('input[name="pasien_id"]').val($(this).attr('data-pasien_id'));
		$('#searchPasien').modal('hide');
	});

	$('input[name="nama"]').on('keyup', function () {
		if ( $('input[name="nama"]').val() == '' ) {
			$('input[name="no_rm"]').val('');
			$('input[name="pasien_id"]').val('');
		}
	});


});
</script>
@endsection
